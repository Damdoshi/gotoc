#!/usr/bin/env php
<?php
// pack.php entry.php > standalone.php
if ($argc < 2) { fwrite(STDERR,"Usage: pack.php <entry.php>\n"); exit(1); }

$seen = [];

/**
 * Lit un fichier PHP et renvoie son code sans shebang, sans <?php/?>,
 * avec include/require résolus récursivement.
 */
function inline_php($file) {
    global $seen;

    $path = realpath($file);
    if (!$path) throw new RuntimeException("Not found: $file");

    // require_once / include_once: ne pas réinclure deux fois
    if (isset($seen[$path])) return "";
    $seen[$path] = true;

    $code = file_get_contents($path);

    // 1) enlever BOM + shebang éventuel
    $code = preg_replace('/^\xEF\xBB\xBF/', '', $code);      // BOM UTF-8
    $code = preg_replace('/^#!.*\R/', '', $code, 1);         // shebang

    // 2) dépouiller l'ouverture/fermeture PHP aux bords (sans toucher au contenu)
    $code = preg_replace('/^\s*<\?(php)?\s*/i', '', $code, 1);
    $code = preg_replace('/\s*\?>\s*$/', '', $code, 1);

    $dir  = addslashes(dirname($path));
    $fil  = addslashes($path);

    // 3) remplacer __FILE__/__DIR__ dans le code inliné
    $code = str_replace(['__FILE__','__DIR__'], ["'$fil'","'$dir'"], $code);

    // 4) résoudre include/require "littéraux"
    $code = preg_replace_callback(
        '#(?P<stmt>\b(require|include)(_once)?\s*(\(\s*)?[\'"](?P<inc>[^\'"]+)[\'"]\s*(\)\s*)?; )#x',
        function($m) use ($dir) {
            $inc = $m['inc'];
            $incPath = ($inc[0] === '/' ? $inc : $dir.'/'.$inc);
            $incReal = realpath($incPath);
            if (!$incReal) {
                // introuvable : laisser l’include tel quel
                return $m[0];
            }
            $body = inline_php($incReal);
            return "\n/* BEGIN include $incReal */\n".$body."\n/* END include */\n";
        },
        $code
    );

    return $code;
}

$entry = $argv[1];

// Sortie finale avec UN seul <?php
echo "<?php\n";
echo "/* Single-file build of ".basename($entry)." */\n";
echo inline_php($entry);
echo "\n";
