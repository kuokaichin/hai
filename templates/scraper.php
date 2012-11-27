<? 
    beginscrape();


    // get html from website    
    
    function beginscrape()
    {
        $url = "http://usodb.fas.harvard.edu/public/index.cgi";    
        $html = file_get_contents($url);        
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

        // call separate function for scraping additional activity info
        $info_extra = parse_one($activities_all[306][1]);
        
        // add additionally scraped info into associative array for one instance
        $activities_all[306]['description'] = $info_extra['description'];
        $activities_all[306]['email'] = $info_extra['email'];
        $activities_all[306]['website'] = $info_extra['website'];
        $activities_all[306]['size'] = $info_extra['size'];
        $activities_all[306]['members'] = $info_extra['members'];
        $activities_all[306]['election'] = $info_extra['election'];
        $activities_all[306]['updated'] = $info_extra['updated'];
/*
        
        foreach($activities_all as $i => $info_basic)
        {
            $info_extra = parse_one($info_basic[1]);
            foreach ($info_extra as $info)
            {
                $info_basic = array_merge($info_basic, $info);
            }
        }
        print_r($activities_all);

*/
        return $activities_all;
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


