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
        // get basic information about the activity identified by id
        $results = lookup_quick($_GET["id"]);
        // get all the comments about the activity identified by id
        $comments = get_comments($_GET["id"]);
        render("comments_view.php", array("title" => $results['name'], "results" => $results, "comments" => $comments));
    }
    else
    {
    // else render error message
        echo '<div>
        The comments of this activity are in another castle.</br>
        <a href="seach.php">Search Again</a>
        ';
    }
?>
