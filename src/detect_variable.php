<?php

function detect_variable($line)
{
    $tmp = explode(" ", $line);
    foreach ([
	"int", "char", "float", "double", "short", "long"
    ] as $type)
        if ($type == $tmp[0])
	    return (true);
    return (false);
}

