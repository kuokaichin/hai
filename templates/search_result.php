<?
    foreach($results as $result)
    {
        echo '<div>    
            Activity Name:' 
            , $result['name']
             , '<br/>'
            , 'Description:' , $result['description'] , '<br/>',
             'Overall Rating:', $result['satisfaction'], '<br/>
            <br/>
        </div>
        <div>   
            Tags:', $result['tags'], '<br/>
        </div>
        <div>
            <a href="activity.php?id=', $result['id'], '">Details</a><br/><br/>
        </div>';
    }
?>
