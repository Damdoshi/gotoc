<?php

function read_and_store($loading = NULL)
{
    global $listing;

    if ($loading == NULL)
    {
	ekko(reset_color());
	$line = readline("- ");
	$line = trim($line);
    }
    else
	$line = $loading;

    if ($line == "")
	return (true);

    $line = str_replace("\t", " ", $line);
    $matches = [];
    if (preg_match('/^([0-9]+)(.*)$/', $line, $matches, PREG_OFFSET_CAPTURE))
    {
	if (($number = (int)$matches[1][0]) == 0)
	{
	    echo "Value 0 cannot be used as label.\n";
	    return (true);
	}
	$content = strtolower(trim($matches[2][0]));
	if ($loading != NULL)
	{
	    if (isset($listing[$number]))
		echo "Duplicated label $number.\n";
	}
	if (substr($content, 0, 5) == "goto ")
	{
	    $content = explode(" ", $content);
	    if ($content[1][0] != "l")
		$content[1] = "l".$content[1];
	    $content = implode(" ", $content);
	}
	$edited = true;
	if ($content == "")
	    unset($listing[$number]);
	else
	    $listing[$number] = $content;
	return (true);
    }
    return (execute($line));
}


