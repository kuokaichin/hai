<? 
    // get html from website    
    $url = "http://usodb.fas.harvard.edu/public/index.cgi";
    $html = file_get_contents($url);

    // demarcate the beginning and end of portion we want to work with
    $html_start = '<ul>';
        $html_start_pos = strpos($html, $html_start) + strlen($html_start);
        $html_end = '</ul>';
        $html = substr($html, $html_start_pos , strpos($html, $html_end, $html_start_pos) - $html_start_pos);

    // make sure that we got the right substring
    echo $html;    
    // scrape data and put it into array
    preg_match_all('#(\d+)">(.*?)</a><br />#si', $html, $activities, PREG_SET_ORDER);
    print_r($activities);
    // insert data from scraping into mySQL
    foreach ($activities as $id)
    {
        query ("INSERT INTO activities (id, name) VALUES($id[1], " . "'" . mres($id[2]) . "')");
    }
    
    // necessary so that apostrophes in org. names don't truncate string
    function mres($value)
    {
        $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
        $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

        return str_replace($search, $replace, $value);
    }
?>


