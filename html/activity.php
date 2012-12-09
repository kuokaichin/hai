<?php
    // configuration
    require("../includes/config.php");
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // check that there is an id identifying a specific activity
        if (empty($_GET["id"]))
        {
            apologize("What activity is this?!?!");
        }
        // obtain most data about this activity from tables activity and tags available in the database
        $results = lookup_detailed($_GET["id"]);
        // get comments about the activity
        $comments = get_comments($_GET["id"]);
        render("activity_view.php", array("title" => $results['name'], "results" => $results, "comments" => $comments));
    }
    else
    {
    // else render return message
        echo '<div>
        The activity you look for is in another castle.</br>
        <a href="seach.php">Search Again</a>
        ';
    }
?>
