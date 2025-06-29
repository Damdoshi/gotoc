<?php

function _list($line)
{
    global $listing;

    ksort($listing);
    $i = 0;
    foreach ($listing as $k => $v)
    {
	ekko(alternate($i++));
	echo "$k $v\n";
    }
    return (true);
}

$commands[] = "list";

