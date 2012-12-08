<?php
    // configuration
    require("../includes/config.php");
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // check that all fields have proper inputs
        if (empty($_GET["search_value"]))
        {
            render("search_form.php", array("title" => "Search"));
        }
        else
        {
            // weed out injection attacks using search box
            if (preg_match("#/[A-Za-z]+#", $_GET['search_value']))
            {
                apologize("The first character of our search should be alphabetical");
            }
            // get array of ID numbers of applicable orgs
            $hits = search(mres($_GET["search_value"]), $_GET["filter"]);
            // 
            $results = array();
            foreach ($hits as $index => $id)
            {        
                $results[$index] = lookup_quick($index);
            }
            render("search_result.php", array("title" => "Search Results", "results" => $results));
        }
    }
    else
    {
        // else render form
        render("search_form.php", array("title" => "Search"));
    }
?>
