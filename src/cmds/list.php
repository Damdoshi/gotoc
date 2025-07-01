<?php

function _list_help()
{
    echo output();
    echo " - LIST COMMAND -\n";
    echo "Display your current listing.\n";
    echo " - list\tdisplay the whole thing\n";
    echo " - list min\tdisplay the listing starting label min\n";
    echo " - list min max\tdisplay the listing between label min and max\n";
    echo " - list -p\tdisplay listing page per page\n";
    echo "The option -p can be combined with min and min/max commands.\n";
    echo "\n";
}


function _list($line)
{
    global $listing;

    $space = false;
    $min = 0;
    $max = 1e24;
    
    ksort($listing);
    
    $i = 0;
    $line = explode(" ", $line);
    for ($k = 1; isset($line[$k]); ++$k)
    {
	$l = $line[$k];
	if ($l == "-p")
	    $space = true;
	else if ($i == 0)
	{
	    $min = (int)$l;
	    $i = $i + 1;
	}
	else
	    $max = (int)$l;
    }

    $i = 0;
    foreach ($listing as $k => $v)
    {
	if ($min <= $k && $k <= $max)
	{
	    ekko(alternate($i++));
	    echo "$k $v\n";
	    if ($space && $i % 4 == 0)
		fread(STDIN, 1);
	}
    }
    return (true);
}

$commands[] = "list";

