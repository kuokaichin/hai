<?php

    /***********************************************************************
     * config.php
     *
     * Computer Science 50
     * 
     *
     * Configures pages.
     **********************************************************************/

    // display errors, warnings, and notices
    ini_set("display_errors", true);
    error_reporting(E_ALL);

    // requirements
    require("constants.php");
    require("functions.php");

    // enable sessions
    session_start();

    // require authentication for most pages
    // change this to require changes if you want to be admin and scrape!
    
    if (!preg_match("{(?:index|login|logout|register|search|activity|rate|comments|tag|register|upvote)\.php$}", $_SERVER["PHP_SELF"]))
    {
        if (empty($_SESSION["id"]))
        {
            redirect("login.php");
        }
    }
    
	

?>
