<?php

function single_line_execution($line)
{
    global $program;
    global $listing;

    if (detect_variable($line))
    {
	echo "Statement with no effect.\n";
	return ;
    }
    
    // Cette fonction compile une ligne et l'execute immédiatement
    // En la placant à la fin du listing.
    // Ainsi, on peut tester un appel de fonction
    $old_program = $program;
    $old_listing = $listing;

    $program = ".t".uniqid();
    if (count($listing) == 0)
	$max = 0;
    else
	$max = max(array_keys($listing)) + 1;
    $listing[-10] = "__save_cpos();";
    $listing[$max] = $line;
    $listing[$max + 1] = "__restore_cpos();";
    _compile("");
    _run("");
    `rm -f $program.gtc .$program.c $program`;

    $program = $old_program;
    $listing = $old_listing;
}

