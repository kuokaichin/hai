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
        render("rate_form.php", array("title" => "Rate " . $results['name'], "results" => $results, "id" => $_GET['id']));

    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(empty($_GET['id']))
        {
            apologize("wtf");
        }
        // verify completion of form
        if (empty($_POST['satisfaction_input']) || empty($_POST['time_input']) || empty($_POST['organization_input']) || empty($_POST['selectiveness_input']) || empty($_POST['friendliness_input']) || empty($_POST['learning_impact_input']) || empty($_POST['email']))
        {
            apologize("Invalid ratings!");
        }
        // verify Harvard email. More with verification and such in the future but currently it's just making sure Harvard is in there.
        if (!preg_match('#.*?@.*harvard.edu#',$_POST['email']))
        {
            apologize("Please enter a Harvard affiliated email for verification");
        }
        // check that this email hasn't rated this activity before
        $old_ratings = query("SELECT id FROM ratings_all WHERE id=? AND email=?", $_GET['id'], $_POST['email']);
        if(!empty($old_ratings))
        {
            apologize("You have already rated this activity!");
        }
        
        // insert into reviews_all
        if (false === query("INSERT INTO ratings_all (id, satisfaction, time, organization, selectiveness, friendliness, learning_impact, email, comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", $_GET['id'], $_POST['satisfaction_input'], $_POST['time_input'], $_POST['organization_input'], $_POST['selectiveness_input'], $_POST['friendliness_input'], $_POST['learning_impact_input'], $_POST['email'], $_POST['comment']))
        {
            apologize("Could not enter review into database.");
        } 
        // update average of this particular ID in reviews_avg
        
        // render("rate_complete.php", array('title' => 'Rating complete!'));
        
    }
    else
    {
        // else render form
        render("rate_form.php", array("title" => $results['name'], "results" => $results));
    }
?>
