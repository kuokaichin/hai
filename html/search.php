<?php
    // configuration
    require("../includes/config.php");
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // check that all fields have proper inputs
        if (empty($_POST["search_value"]))
        {
            apologize("Your search cannot be empty.");
        }
        /*
        else if (lookup($_POST["search_value"]) === false)
        {
            apologize("No activities found.");
        }
        */
            // get array of ID numbers of applicable orgs
            // $results = lookup_quick($_POST["search_value"]);
            $results = array('name' => 'Piano Society', 'id' => 1);
            render("/search_result.php", ["title" => "Search Result", "results" => $results]);
    }
    else
    {
    // else render form
    render("search_form.php", ["title" => "Activities Search"]);
    }
?>
