<?php

function _system_help()
{
    echo output();
    echo " - SYSTEM COMMAND -\n";
    echo "Exit the shell. Same as quit. Same as exit.\n";
    echo "\n";
}

function _system($line)
{
    alert();
    exit(0);
}

$commands[] = "system";

