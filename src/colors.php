<?php

function ekko($x)
{
    fwrite(STDOUT, $x, strlen($x));
}

function reset_color()
{
    return ("\033[0;0m");
}

function alternate($i)
{
    if ($i % 2 == 0)
	return ("\033[1;30m");
    return ("\033[0;37m");
}

function output()
{
    return ("\033[1;37m");
}

