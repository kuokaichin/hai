<?php
    // configuration
    require("../includes/config.php");
    
    $time_start = microtime(1);
    $time_prev = $time_start;
    beginscrape();
    echo '<div>
        Scrape complete!</br>
        <a href="admin.php">Return to Admin</a>
    </div>';  

    function since($desc) 
    {
        global $time_start, $time_prev;
        $time_now = microtime(1);
        echo '<p>Since start: ' . number_format($time_now - $time_start, 4) . '; since previous: ' . number_format($time_now - $time_prev, 4) . ' &mdash; ' . $desc . '</p>';
        $time_prev = $time_now;
    }
    
    function beginscrape()
    {
        $url = "http://usodb.fas.harvard.edu/public/index.cgi";    
        $html = file_get_contents($url);        
        insert_categories(parse_categories($html));
        insert_activities(parse_list($html));
    }
    
    /*
     * grabs the OSL designated categories to eventually put in tags. Takes in html string and returns
     * preg_matched names of each category in a nested array
     */
    function parse_categories($html)
    {
        // truncate the html string for easier processing
        $html_start = '<ul class="org-cats-2">';
        $html_start_pos = strpos($html, $html_start) + strlen($html_start);
        $html_end = '</ul>';
        $html = substr($html, $html_start_pos , strpos($html, $html_end, $html_start_pos) - $html_start_pos);
        
        // pull OSL category and the ID they assign to later add to tag table
        preg_match_all('#value="(\d*?)".*?>\s*(.*?)\s<#si', $html, $categories_all, PREG_SET_ORDER);                
        foreach ($categories_all as $index => $tag)
        {
            $categories_all[$index][2] = substr($tag[2],0,-12);
        }
        return $categories_all;        
    }
    
    /*
     * preg_match every single activity and its corresponding ID, return them in nested array
     */
    function parse_list($html)
    {
        // demarcate the beginning and end of portion we want to work with
        $html_start = '<ul>';
        $html_start_pos = strpos($html, $html_start) + strlen($html_start);
        $html_end = '</ul>';
        $html = substr($html, $html_start_pos , strpos($html, $html_end, $html_start_pos) - $html_start_pos);

        // scrape id and name of activity and put it into array
        preg_match_all('#(?P<id>\d+)">(?P<name>.*?)</a><br />#si', $html, $activities_all, PREG_SET_ORDER);
        
        // takes every activity and adds on info from activity specific site
        foreach ($activities_all as $activity)
        {
            $activity += parse_one($activity['id']);
        }
           
        /*
        // functionally the same as foreach loop. Useful if requests are timing out or if only a small portion need to be rescraped
        for ($i = 400; $i < 442; $i++)
        {
            $activities_all[$i] += parse_one($activities_all[$i]['id']);
        }
        */
        // makes array smaller by getting rid of entries under numerical index
        $activities_all = unset_numeric_keys_($activities_all);
        return $activities_all;
    }
    
    /*
     * parses a specific activity's page for various details like email, website...etc, returning array
     */
    function parse_one($id)
    {   
        // go to url specific to an activity
        $url = 'http://usodb.fas.harvard.edu/public/index.cgi?rm=details&id=' . $id;
        // grab the html and reduce it to relevant portions
        $html = file_get_contents($url);
        // for activities-tags linking, this has the OSL's relationships
        preg_match_all('#category=(\d*?)">#si', $html, $activities_tags, PREG_SET_ORDER);
        $html_start = '</h2>';
        $html_start_pos = strpos($html, $html_start) + strlen($html_start);
        $html_end = '</html>';
        $html = substr($html, $html_start_pos , strpos($html, $html_end, $html_start_pos) - $html_start_pos);
        // capture fields of interest
        preg_match('#<p>(?P<description>.*?)</p>.*?Members:</strong>\s*(?P<size>.*?)\s*</li>.*?Involvement:</strong>\s*(?P<members>.*?)\s*</li>.*?Group Email:.*?<a href="(?P<email>.*?)">.*?Web Site.*?<a href="(?P<website>.*?)">.*?Elections:</strong>\s*(?P<election>\w*)\s*.*?</strong>\s*(?P<osl_updated>\w*\s\S*\s\d*)\s#si', $html, $info_extra);
        $tag_ids = array( 'tag_id' => $activities_tags );
        return $info_extra + $tag_ids;
    }
    
    /*
     * insert into activities and activities_tags tables everything scraped from OSL
     */
    function insert_activities($activities_all)
    {
        // insert data from scraping into mySQL (2 separate, one for activities-tags relationship)
        $query1 = "INSERT INTO activities (id, name, description, email, website, size, members, election, osl_updated) VALUES ";
        $query2 = "INSERT INTO activities_tags (activity_id, tag_id) VALUES ";
        
        // adds each activity's various details, taking care to process inputs with MRES first.
        foreach ($activities_all as $activity)
        {
            $query1 .= "('". mres($activity['id']) . "', '" . mres($activity['name']) . "', '" . mres($activity['description']) . "', '" . mres($activity['email']) . "', '" . mres($activity['website']) . "', '" . mres($activity['size']) . "', '" . mres($activity['members']) . "', '" . mres($activity['election']) . "', '" . mres($activity['osl_updated']) . "'), " ;        
            // every tag_id associated with this particular activity
            foreach ($activity['tag_id'] as $id)
            {
                $query2 .= "('" . mres($activity['id']) . "', '". mres($id[1]) . "'), "; 
            }
        }
        
        /*
        // funcionally the same as foreach
        for ($i = 400; $i < 442; $i++)
        {
            $query1 .= "('". mres($activities_all[$i]['id']) . "', '" . mres($activities_all[$i]['name']) . "', '" . mres($activities_all[$i]['description']) . "', '" . mres($activities_all[$i]['email']) . "', '" . mres($activities_all[$i]['website']) . "', '" . mres($activities_all[$i]['size']) . "', '" . mres($activities_all[$i]['members']) . "', '" . mres($activities_all[$i]['election']) . "', '" . mres($activities_all[$i]['osl_updated']) . "'), " ;        
            // every tag_id associated with this particular activity
            foreach ($activities_all[$i]['tag_id'] as $id)
            {
                $query2 .= "('" . mres($activities_all[$i]['id']) . "', '". mres($id[1]) . "'), "; 
            }
        }
        */
        
        // could have truncated tables here before adding if desired
        $query1 = substr($query1, 0, strlen($query1) - 2);
        $query2 = substr($query2, 0, strlen($query2) - 2);
        query($query1);
        query($query2);
        
    }
    
    function unset_numeric_keys($a) 
    {
        foreach ($a as $i => $ai)
        {
            if (is_numeric($i))
            unset($a[$i]);
        }
        return $a;
    }
    
    function unset_numeric_keys_($a) 
    {
        return array_map('unset_numeric_keys', $a);
    }

?>



