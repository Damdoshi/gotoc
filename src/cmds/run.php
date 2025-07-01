<?php

function _run_help()
{
    echo output();
    echo " - RUN COMMAND -\n";
    echo "Compile and run the current program.\n";
    echo "You can precise parameters.\n";
    echo "Argc, argv and env are available.\n";
    echo "\n";
}

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

