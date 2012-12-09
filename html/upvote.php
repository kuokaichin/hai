<?php
    // configuration
    require("../includes/config.php");
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // check that all fields have proper inputs
        if (empty($_GET["id"]))
        {
            apologize("What activity is this?!?!");
        }
        else
        {
            // update the number of upvotes by adding one to current value
            $query = "UPDATE ratings_all SET upvotes=upvotes+1 WHERE id='" . $_GET['id'] . "' AND email='" . $_POST['email'] . "'";
            query($query);
        }
    }
    else
    {
    // else render error message
        echo '<div>
        Something went terribly wrong with your upvote...</br>
        <a href="index.php">Home</a>
        ';
    }
?>
