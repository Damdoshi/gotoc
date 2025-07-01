<?php

function _save_help()
{
    echo output();
    echo " - SAVE COMMAND -\n";
    echo "Save into the currently open file your listing.\n";
    echo "You can precise a single other file as target.\n";
    echo "It will become your new currently open file and the previous one will be closed.\n";
    echo "\n";
}

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

