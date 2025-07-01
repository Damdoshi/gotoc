<?php

function _exit_help()
{
    echo output();
    echo " - EXIT COMMAND -\n";
    echo "Exit the shell. Same as quit. Same as system.\n";
    echo "\n";
}

function _exit($line)
{
    _system($line);
}

$commands[] = "exit";

