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
        $results = lookup_quick(4);
        render("search_result.php", ["title" => $results['name'], "id" => 4, "name" => $results['name'], "description" => $results['description'], "satisfaction" => $results['satisfaction'], "tags" => $results['tags']]);
    }
    else
    {
    // else render form
        $results = lookup_quick(4);
        render("search_result.php", ["title" => $results['name'], "id" => 4, "name" => $results['name'], "description" => $results['description'], "satisfaction" => $results['satisfaction'], "tags" => $results['tags']]);

    }
?>
