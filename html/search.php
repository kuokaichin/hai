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
            // $hits = search($_POST["search_value"]);
        $hits = array (0 => 4, 1 => 11);
        $results = array();
        foreach ($hits as $index => $id)
        {        
            $results[$index] = lookup_quick($id);
        }
        render("search_result.php", ["title" => "Search Results", "results" => $results]);
    }
    else
    {
        // else render form
        render("search_form.php", ["title" => "Search"]);
    }
?>
