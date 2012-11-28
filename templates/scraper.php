<? 
    beginscrape();
    
    $time_start = microtime(1);
    $time_prev = $time_start;
    function since($desc) 
    {
        global $time_start, $time_prev;
        $time_now = microtime(1);
        echo '<p>Since start: ' . number_format($time_now - $time_start, 4) . '; since previous: ' . number_format($time_now - $time_prev, 4) . ' &mdash; ' . $desc . '</p>';
        $time_prev = $time_now;
    }
    

    // get html from website    
    
    function beginscrape()
    {
        $url = "http://usodb.fas.harvard.edu/public/index.cgi";    
        $html = file_get_contents($url);        
        since('After calling file_get_contents()');
        // demarcate the beginning and end of portion we want to work with
        parse_list($html);
//      insert(parse_list($html));
    }
    
    function parse_list($html)
    {
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
        print_r($activities_all);
        
        /*
        foreach ($activities_all as $info_basic)
        {
            // combine the two arrays
            $info_basic += parse_one($info_basic['id']);
        }
        print_r($activities_all);
        */

//        return $activities_all;
    }
    
    function parse_one($id)
    {
        // go to url specific to an activity
        $url = 'http://usodb.fas.harvard.edu/public/index.cgi?rm=details&id=' . $id;
        // grab the html and reduce it to relevant portions
        $html = file_get_contents($url);
        $html_start = '</h2>';
        $html_start_pos = strpos($html, $html_start) + strlen($html_start);
        $html_end = '</html>';
        $html = substr($html, $html_start_pos , strpos($html, $html_end, $html_start_pos) - $html_start_pos);
        // capture fields of interest
        preg_match('#<p>(?P<description>.*?)</p>.*?Members:</strong>\s*(?P<size>.*?)\s*</li>.*?Involvement:</strong>\s*(?P<members>.*?)\s*</li>.*?Group Email:.*?<a href="(?P<email>.*?)">.*?Web Site.*?<a href="(?P<website>.*?)">.*?Elections:</strong>\s*(?P<election>.*?)</li>.*?Updated:</strong>\s*(?P<updated>.*?)</li>#si', $html, $info_extra);
        return $info_extra;
    }
    
    function insert($activities_all)
    {
  
        // insert data from scraping into mySQL
        $query = "INSERT INTO activities (id, name, description, email, website, size, members, election, updated) VALUES ";
        echo $query;
        foreach ($activities_all as $activity)
        {
            $query .= '('. $activity[id] . ", '" . mres($activity[name]) . "', '" . mres($activity[decription]) . "', '" . mres($activity[email]) . "', '" . mres($activity[website]) . "', '" . mres($activity[size]) . "', '" . mres($activity[members]) . "', '" . mres($activity[election]) . "', '" . mres($activity[updated]) . "'), " ;
        }
        $query = substr($query, 0, strlen($query) - 2);
        echo $query;
        // query('TRUNCATE activities');
        // query($query);
    }
        
        // necessary so that apostrophes in org. names don't truncate string
        // from http://stackoverflow.com/questions/1162491/alternative-to-mysql-real-escape-string-without-connecting-to-db
        function mres($value)
        {
            $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
            $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
            return str_replace($search, $replace, $value);
        }

?>


