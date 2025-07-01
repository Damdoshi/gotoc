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

    $padding = 0;
    ksort($listing, SORT_NUMERIC);
    $mx = max(array_keys($listing));
    while ($mx >= 10)
    {
	$mx /= 10;
	$padding += 1;
    }
    
    $fout = fopen("$program.gtc", "w");
    foreach ($listing as $k => $line)
    {
	$sp = "";
	$dup = $k;
	$pad = 0;
	while ($dup >= 10)
	{
	    $dup /= 10;
	    $pad += 1;
	}
	while ($pad < $padding)
	{
	    $sp .= "0";
	    $pad += 1;
	}
	fwrite($fout, $sp.$k, strlen($sp.$k));
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

