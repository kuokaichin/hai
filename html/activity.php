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
        $results = lookup_detailed($_GET["id"]);
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
