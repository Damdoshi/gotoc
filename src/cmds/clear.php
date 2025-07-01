<?php

function _clear_help()
{
    echo output();
    echo " - CLEAR COMMAND -\n";
    echo "Clear erase your currently loaded listing.\n";
    echo "\n";
}

function _clear($line)
{
    global $listing;

    $listing = [];
    return (true);
}

$commands[] = "clear";

