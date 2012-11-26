#!/usr/bin/env php
<?
    // constants
    require("../includes/config.php");
 
    // connect to database
    mysql_connect(project);
    mysql_select_db(project);

	$url = "http://usodb.fas.harvard.edu/public/index.cgi";
	$html = file_get_contents($url);
	
    
 
?>