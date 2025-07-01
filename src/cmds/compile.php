<?php

function _compile($line)
{
    global $listing;
    global $program;
    global $debug;
    global $only_goto;

    $out = ".$program.c";
    $fout = fopen($out, "w");
    $cnt = file_get_contents(__DIR__."/../../res/opening.c");
    $cc = "gcc";
    fwrite($fout, $cnt, strlen($cnt));
    $keys = array_keys($listing);
    foreach ($keys as $idx => $k)
    {
	$line = $listing[$k];
	// detect variable
	if (!detect_variable($line))
	{
	    $label = "l$k:;\n";
	    fwrite($fout, $label, strlen($label));
	}
	if (isset($keys[$idx + 1]))
	    $line = "#define l__AFTER l{$keys[$idx + 1]}\n$line\n#undef l__AFTER\n";
	else
	    $line = "#define l__AFTER __very_end\n$line\n";
	
	fwrite($fout, $line, strlen($line));
	if (strstr($line, "gfx_mode"))
	    $cc = "bcc -DGFX_MODE=1";
    }
    $cnt = file_get_contents(__DIR__."/../../res/closing.c");
    fwrite($fout, $cnt, strlen($cnt));
    fclose($fout);

    $flags = "";
    if ($debug)
	$flags = "-g -g3 -ggdb";
    else
	$flags = "-O2 -ffast-math";
    if ($only_goto)
	$flags .= " -DONLY_GOTO";
    echo `$cc $out -o $program -w -Wno-unused-label -Wno-unused-parameter $flags`;
    if (!$debug)
	`rm -f $out`;
}

$commands[] = "compile";

