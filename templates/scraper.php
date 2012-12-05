<? 
    $time_start = microtime(1);
    $time_prev = $time_start;
    beginscrape();      

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
        parse_categories($html);
        // insert_categories(parse_categories($html));
        since('After calling file_get_contents()');
        
        // insert_activities(parse_list($html));
    }
    
    function parse_categories($html)
    {
        $html_start = '<ul class="org-cats-2">';
        $html_start_pos = strpos($html, $html_start) + strlen($html_start);
        $html_end = '</ul>';
        $html = substr($html, $html_start_pos , strpos($html, $html_end, $html_start_pos) - $html_start_pos);
        
        // pull OSL category and the ID they assign to later add to tag table
        preg_match_all('#value="(\d*?)".*?>\s*(.*?)\s<#si', $html, $categories_all, PREG_SET_ORDER);                
        print_r($categories_all);        
    }
    
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
        
        for ($i = 0; $i < 10; $i++)
        {
            $activities_all[$i] += parse_one($activities_all[$i]['id']);
        }
        $activities_all = unset_numeric_keys_($activities_all);
        return $activities_all;
    }
    
    function parse_one($id)
    {
    
        // this is for matching the tags, not quite right yet.
        preg_match_all('#category=(\d*?)">#si', $html, $categories_all, PREG_SET_ORDER);
    
        // go to url specific to an activity
        $url = 'http://usodb.fas.harvard.edu/public/index.cgi?rm=details&id=' . $id;
        // grab the html and reduce it to relevant portions
        $html = file_get_contents($url);
        $html_start = '</h2>';
        $html_start_pos = strpos($html, $html_start) + strlen($html_start);
        $html_end = '</html>';
        $html = substr($html, $html_start_pos , strpos($html, $html_end, $html_start_pos) - $html_start_pos);
        // capture fields of interest
        preg_match('#<p>(?P<description>.*?)</p>.*?Members:</strong>\s*(?P<size>.*?)\s*</li>.*?Involvement:</strong>\s*(?P<members>.*?)\s*</li>.*?Group Email:.*?<a href="(?P<email>.*?)">.*?Web Site.*?<a href="(?P<website>.*?)">.*?Elections:</strong>\s*(?P<election>\w*)\s*.*?</strong>\s*(?P<osl_updated>\w*\s\S*\s\d*)\s#si', $html, $info_extra);
        return $info_extra;
    }
    
    function insert_activities($activities_all)
    {
  
        // insert data from scraping into mySQL
        $query = "INSERT INTO activities (id, name, description, email, website, size, members, election, osl_updated) VALUES ";
        for ($i = 0; $i < 10; $i++)
        {
            $query .= "('". mres($activities_all[$i]['id']) . "', '" . mres($activities_all[$i]['name']) . "', '" . mres($activities_all[$i]['description']) . "', '" . mres($activities_all[$i]['email']) . "', '" . mres($activities_all[$i]['website']) . "', '" . mres($activities_all[$i]['size']) . "', '" . mres($activities_all[$i]['members']) . "', '" . mres($activities_all[$i]['election']) . "', '" . mres($activities_all[$i]['osl_updated']) . "'), " ;        
        }
        $query = substr($query, 0, strlen($query) - 2);
        query('TRUNCATE activities');
        query($query);
    }
    
    function insert_categories($categories_all)
    {
    }
        
    // necessary so that apostrophes in org. names don't truncate string, other problems
    // from http://stackoverflow.com/questions/1162491/alternative-to-mysql-real-escape-string-without-connecting-to-db
    function mres($value)
    {
        return strtr($value, array( "\x00" => '\x00', "\n" => '\n', "\r" => '\r', '\\' => '\\\\', "'" => "\'", '"' => '\"', "\x1a" => '\x1a' ));
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


