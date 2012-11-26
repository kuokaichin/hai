<? 
    // connect to database
	$url = "http://usodb.fas.harvard.edu/public/index.cgi";
	$html = file_get_contents($url);
	
    $html_start = '<ul>';
    $html_start_pos = strpos($html, $html_start) + strlen($html_start);
    $html_end = '</ul>';
    $html = substr($html, $html_start_pos , strpos($html, $html_end, $html_start_pos) - $html_start_pos);
    echo $html;

?>
