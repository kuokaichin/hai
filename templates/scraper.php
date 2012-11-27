<? 
    //beginscrape();
    parse_one(4);



    // get html from website    
    
    function beginscrape()
    {
        $url = "http://usodb.fas.harvard.edu/public/index.cgi";    
        $html = file_get_contents($url);        
        // demarcate the beginning and end of portion we want to work with
        $html_start = '<ul>';
        $html_start_pos = strpos($html, $html_start) + strlen($html_start);
        $html_end = '</ul>';
        $html = substr($html, $html_start_pos , strpos($html, $html_end, $html_start_pos) - $html_start_pos);
        parse_list($html);
    }
    
    function parse_list($html)
    {
        // scrape data and put it into array
        preg_match_all('#(\d+)">(.*?)</a><br />#si', $html, $activities_all, PREG_SET_ORDER);
        foreach($activities_all as $i => $info_basic)
        {
            $info_extra = parse_one($info_basic[1]);
            $activities_all[$i] = array_merge($info_basic, $info_extra);
        }
    }
    
    function parse_one($id)
    {
        $url = 'http://usodb.fas.harvard.edu/public/index.cgi?rm=details&id=' . $id;
        $html = file_get_contents($url);
        $html_start = '</h2>';
        $html_start_pos = strpos($html, $html_start) + strlen($html_start);
        $html_end = '</html>';
        $html = substr($html, $html_start_pos , strpos($html, $html_end, $html_start_pos) - $html_start_pos);
        preg_match_all('#Group Email:.*?<a href="(.*?)">.*?Web Site.*?<a href="(.*?)">#si', $html, $info_extra, PREG_SET_ORDER);
        // preg_match_all('#Group Email:.*?<a href="(.*?)">#si', $html, $info_extra, PREG_SET_ORDER);
        print_r($info_extra);
    }
    
/*    
    // insert data from scraping into mySQL
    $query = "INSERT INTO activities (id, name) VALUES ";
    foreach ($activities_all as $id)
    {
        $query .= '('. $activity[1] . ", '" . mres($activity[2]) . "'), ";
    }
    $query = substr($query, 0, strlen($query) - 2);
    query('TRUNCATE activities');
    query($query);
    
    // necessary so that apostrophes in org. names don't truncate string
    // from http://stackoverflow.com/questions/1162491/alternative-to-mysql-real-escape-string-without-connecting-to-db
    function mres($value)
    {
        $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
        $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
        return str_replace($search, $replace, $value);
    }
    */
?>


