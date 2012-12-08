<h2>Comments about <?echo $results['name'];?></h2>
<?
    if(empty($comments))
    {
        echo "No Comments So far";
    }

    foreach($comments as $index => $comment)
    {
        echo '<table class="table table-condensed">    
            <tr><td>Comment ', $index, '</td><td>' 
            , $comment['comment']
             , '</td></tr></br>
        </table>';
    }
?>

