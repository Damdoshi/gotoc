<?php

function _help_help()
{
    echo " - HELP COMMAND -\n";
    echo "Type 'help command' to get more about a specific command\n";
    echo "\n";
}

function _help($line)
{
    global $commands;

    echo output();
    $line = explode(" ", $line);
    if (count($line) == 1)
    {
	echo "Shell commands are:\n";
	foreach ($commands as $cmd)
	    echo " - $cmd\n";
	echo "Type 'help command' to get more about a specific command\n";
	return (true);
    }
    for ($i = 1; isset($line[$i]); ++$i)
	if (function_exists($f = "_".$line[$i]."_help"))
	    $f();
        else if (function_exists("_".$line[$i]))
	    echo "Command {$line[$i]} does not have a manual.\n";
        else
	    echo "Command {$line[$i]} does not exist.\n";
}

$commands[] = "help";
