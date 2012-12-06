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
        else if (lookup($_POST["activity_id"]) === false)
        {
            apologize("No activity details found.");
        }
        */
            // $results = lookup_detailed($_POST["search_value"]);
        print_r(lookup_detailed(4));
        //render("/activity_view.php", ["title" => "Search Result", "results" => $results]);
    }
    else
    {
    // else render form
    $results = lookup_detailed(4);
    render("activity_view.php", ["title" => $results['name'], "name" => $results['name'], "description" => $results['description'], "email" => $results['email'], "website" => $results['website'], "size" => $results['size'], "members" => $results['members'], "satisfaction" => $results['satisfaction'], "time" => $results['time'], "organization" => $results['organization'],  "selectiveness" => $results['selectiveness'], "friendliness" => $results['friendliness'], "tags" => $results['tags']]);    
    }
?>
