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
    // array to put scraped data
    $activities = array();
    preg_match_all('#(?<=id=)(\d*)#si', $html, $activities_id);
    preg_match_all('#(?<=>)(.*?)(?=</)#si', $html, $activities_name);  
    foreach ($activities_id[0] as $id)
    {
        query("INSERT INTO activities (id) VALUES($id)");
    }
  
    
    print_r($activities_id);

?>


