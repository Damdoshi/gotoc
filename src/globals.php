<?php

$program = "default";
$listing = [];
$commands = [];
$edited = false;
$running = time();
$debug = false;
$only_goto = false;

foreach (glob(__DIR__."/cmds/*.php") as $file)
{
    require_once ($file);
}
