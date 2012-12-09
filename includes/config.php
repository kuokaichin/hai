<?php

    /***********************************************************************
     * config.php
     *
     * Computer Science 50
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

    // require authentication for most pages that are not really meant to be accessed by general user    
    if (!preg_match("{(?:index|login|logout|register|search|activity|rate|comments|tag|register|upvote)\.php$}", $_SERVER["PHP_SELF"]))
    {
        if (empty($_SESSION["id"]))
        {
            redirect("login.php");
        }
    }
    
	

?>
