<?php

function _save($line)
{
    global $program;
    global $listing;
    global $edited;

    $line = substr($line, strlen("save "));
    $line = trim($line);
    if ($line != $program && $line != "")
	if (substr($program = $line, -4) == ".gtc")
	    $program = substr($program, 0, strlen($program) - 4);

    ksort($listing);

    $fout = fopen("$program.gtc", "w");
    foreach ($listing as $k => $line)
    {
	fwrite($fout, $k, strlen($k));
	fwrite($fout, " ", 1);
	$line .= "\n";
	fwrite($fout, $line, strlen($line));
    }
    fclose($fout);
    echo "Saving $program.gtc\n";
    $edited = false;
    return (true);
}

$commands[] = "save";

