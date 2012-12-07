<?php
    // configuration
    require("../includes/config.php");
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // check that we are rating a specific activity
        if (empty($_GET['id']))
        {
            apologize("What activity is this?!?!");
        }
        // query database for a few details about the activity, most notably name        
        $results = lookup_quick($_GET['id']);
        render("rate_form.php", array("title" => "Rate " . $results['name'], "results" => $results));

    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // verify completion of form
        if (empty($_POST['satisfaction']) || empty($_POST['time']) || empty($_POST['organization']) || empty($_POST['selectiveness']) || empty($_POST['friendliness']) || empty($_POST['member_officer_ratio']) || empty($_POST['email']))
        {
            apologize("Invalid ratings!");
        }
        // verify Harvard email. More with verification and such in the future but currently it's just making sure Harvard is in there.
        if (preg_match('#.*?@.*harvard.edu#',$_POST['email']))
        {
            apologize("Please enter a Harvard affiliated email for verification");
        }

        // insert into reviews_all
        $query =  "INSERT INTO reviews_all";
        
        // update average of this particular ID in reviews_avg
        
        // render("rate_complete.php", array("title => "Rating complete!"));
        
    }
    else
    {
        // else render form
        render("rate_form.php", array("title" => $results['name'], "results" => $results));
    }
?>
