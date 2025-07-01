<?php

function _quit_help()
{
    echo output();
    echo " - QUIT COMMAND -\n";
    echo "Exit the shell. Same as exit. Same as system.\n";
    echo "\n";
}


function _quit($line)
{
    _system($line);
}

$commands[] = "quit";


