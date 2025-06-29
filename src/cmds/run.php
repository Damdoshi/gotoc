<?php

function _run($line)
{
    global $program;
    global $edited;
    global $running;

    _compile($line);
    $line = substr($line, strlen("run "));
    echo output();
    $running = time();
    `./$program $line >&2`;
    $running = time();
}

$commands[] = "run";

