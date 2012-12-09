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
        $max_id = query("SELECT tag_id FROM tags WHERE tag_id=(SELECT MAX(tag_id) FROM tags)")[0]['tag_id'];
        echo $max_id;
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
        
        print_r($insert);
        // insert previously unused tags into tags. Duplicates will not be inserted because tag_name has to be unique
        // known bug: this means that some tag_ids will be unused
        insert_categories($insert);
        
        // insert into activities_tags
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
        
        $query2 = "INSERT INTO activities_tags (activity_id, tag_id) VALUES ";
        
        print_r($tag_ids);
        
        foreach ($tag_ids as $tag_id)
        {
            // every tag_id associated with this particular activity
            $query2 .= "('" . mres($_GET['id']) . "', '". mres($tag_id['tag_id']) . "'), "; 
        }               
        $query2 = substr($query2, 0, strlen($query2) - 2);
        query($query2);
        //render("tag_complete.php", array('title' => 'Rating complete!'));
        
    }
    else
    {
        // else render form
        render("tag_form.php", array("title" => $results['name'], "results" => $results));
    }
?>
