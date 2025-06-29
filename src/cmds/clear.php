<?php

function _clear($line)
{
    global $listing;

    $listing = [];
    return (true);
}

$commands[] = "clear";

