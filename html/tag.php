<?php
    // configuration
    require("../includes/config.php");
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // check that we are tagging a specific activity
        if (empty($_GET['id']))
        {
            apologize("What activity is this?!?!");
        }
        // query database for a few details about the activity, most importantly pre-existing current tags        
        $results = lookup_detailed($_GET['id']);
        render("tag_form.php", array("title" => "Tag " . $results['name'], "results" => $results, "id" => $_GET['id']));

    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(empty($_GET['id']))
        {
            apologize("What activity is this?");
        }
        // verify completion of form
        if (empty($_POST['tag1']) && empty($_POST['tag2']) && empty($_POST['tag3']) && empty($_POST['tag4']) && empty($_POST['tag5']) )
        {
            apologize("You didn't enter any tags!");
        }
        // find largest ID currently used in the tags table so new tags get IDs larger than this
        $max_id = query("SELECT tag_id FROM tags WHERE tag_id=(SELECT MAX(tag_id) FROM tags)")[0]['tag_id'];
        // populate the array that will be inserted into tags 
        $insert = array();
        foreach($_POST as $tag)
        {
            if(!empty($tag))
            {
                $insert[$max_id+1][1] = $max_id + 1;
                $insert[$max_id+1][2] = $tag;
                $max_id++;
            }
        }
        // insert previously unused tags into tags. Duplicates will not be inserted because tag_name has to be unique
        // known bug: this means that some tag_ids will be unused
        insert_categories($insert);
        
        // pulls tag IDs matching names of desired tags. This is necessary because a desired tag might already exist
        $query1 = "SELECT tag_id FROM tags WHERE ";       
        foreach($_POST as $tag)
        {
            if(!empty($tag))
            {
                $query1 .= "tag_name='$tag' OR "; 
            }
        }
        $query1 = substr($query1, 0, strlen($query1) - 3);
        $tag_ids = query($query1);
        
        // actually insert activity-tag relationship into activities_tags
        $query2 = "INSERT INTO activities_tags (activity_id, tag_id) VALUES ";                
        foreach ($tag_ids as $tag_id)
        {
            // every tag_id associated with this particular activity
            $query2 .= "('" . mres($_GET['id']) . "', '". mres($tag_id['tag_id']) . "'), "; 
        }               
        $query2 = substr($query2, 0, strlen($query2) - 2);
        query($query2);
        render("tag_complete.php", array('title' => 'Rating complete!'));
    }
    else
    {
        // else render form
        render("tag_form.php", array("title" => $results['name'], "results" => $results));
    }
?>
