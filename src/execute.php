<?php

function execute($line)
{
    global $commands;
    
    foreach ($commands as $cmd)
    {
	$len = strlen($cmd);
	if (substr($line, 0, $len) == $cmd && (strlen($line) == $len || $line[$len] == ' '))
	{
	    $cmd = "_$cmd";
	    return ($cmd($line));
	}
    }
    return (single_line_execution($line));
}

