<?php
    // configuration
    require("../includes/config.php");
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // check that all fields have proper inputs
        if (empty($_POST["activity_id"]))
        {
            apologize("What activity is this?!?!");
        }
        /*
        else if (lookup($_POST["search_value"]) === false)
        {
            apologize("No activity details found.");
        }
        */
            // get array of ID numbers of applicable orgs
            // $results = lookup($_POST["search_value"]);
            $results = array('name' => 'Piano Society', 'id' => 1);
            render("/activity_view.php", ["title" => "Search Result", "results" => $results]);
    }
    else
    {
    // else render form
    render("activity_view.php", ["title" => "Activity Name Goes HERE"]);
    }
?>
