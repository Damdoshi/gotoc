<?php

function _load_help()
{
    echo output();
    echo " - LOAD COMMAND -\n";
    echo "Close current file and load another specified one.\n";
    echo "\n";
}

function _load($line)
{
    global $program;
    global $listing;

    alert();
    $line = substr($line, strlen("load "));
    $line = trim($line);
    if ($line != $program && $line != "")
	$program = $line;
    if (pathinfo($program, PATHINFO_EXTENSION) == "gtc")
	$program = substr($program, 0, strlen($program) - 4);
    if (!file_exists("$program.gtc"))
    {
	echo "Creating $program.gtc\n";
	$cnt = [];
    }
    else
    {
	echo "Loading $program.gtc\n";
	$cnt = file_get_contents("$program.gtc");
	$cnt = explode("\n", $cnt);
    }
    $biggest = 0;
    $listing = [];
    foreach ($cnt as $line)
    {
	if ($line != "")
	{
	    $matches = [];
	    if (preg_match('/^([0-9]+) (.*)$/', $line, $matches, PREG_OFFSET_CAPTURE))
	    {
		if (($now = (int)$matches[1][0]) > $biggest)
		    $biggest = $now;
	    }
	    else
	    {
		$biggest += 1;
		$line = "$biggest $line";
	    }
	    read_and_store($line);
	}
    }
    return (true);
}

$commands[] = "load";
