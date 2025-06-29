<?php

function alert()
{
    global $edited;

    if ($edited)
    {
	$in = false;
	do
	{
	    if (!$in)
		echo "Please answer y or n.\n";
	    echo "Do you want to save before leaving? (Y/n) ";
	    $in = true;
	    $res = strtolower(trim(readline("")));
	    if ($res == "")
		$res = "y";
	}
	while ($res != "y" && $res != "n");
	if ($res == "y")
	    _save("");
    }
}

