<?php
    // configuration
    require("../includes/config.php");
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // check that all fields have proper inputs
        if (empty($_GET["id"]))
        {
            apologize("What activity is this?!?!");
        }
        /*
        else if (lookup($_POST["activity_id"]) === false)
        {
            apologize("No activity details found.");
        }
        */
        // $results = lookup_detailed($_POST["search_value"]);
        $results = lookup_detailed($_GET["id"]);
        render("activity_view.php", array("title" => $results['name'], "results" => $results));
    }
    else
    {
    // else render form
        render("activity_view.php", array("title" => $results['name'], "results" => $results));
    }
?>
