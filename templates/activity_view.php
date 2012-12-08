<h2><?echo $results['name'];?></h2>
<legend>Basic Information</legend>
<table class="table table-condensed">    
    <tr>
        <td>Description</td>
        <td><?echo $results['description'];?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?echo $results['email'];?></td>
    </tr>
    <tr>
        <td>Website</td>
        <td><?echo $results['website'];?></td>
    </tr>
    <tr>
        <td>Size</td>
        <td><?echo $results['size'];?></td>
    </tr>
    <tr>
        <td>Members</td>
        <td><?echo $results['members'];?></td>
        <tr>
            <td>Tags</td>
            <td><?echo $results['tags'];?></td>
        </tr>
</table>
<legend>Average Ratings</legend>
<table class="table table-condensed">
    <tr>
        <td>Overall Satisfaction</td>
        <td><?echo $results['satisfaction'];?></td>
    </tr>
    <tr>
        <td>Time Commitment</td>
        <td><?echo $results['time'];?></td>
    </tr>
    <tr>
        <td>Organization & Professionalism</td>
        <td><?echo $results['organization'];?></td>
    </tr>
    <tr>  
        <td>Selectiveness</td>
        <td><?echo $results['selectiveness'];?></td>
    </tr>
    <tr>
        <td>Friendliness</td>
        <td><?echo $results['friendliness'];?></td>
    </tr>
    <tr>
        <td>Learning & Impact</td>
        <td><?echo $results['learning_impact'];?></td>    
</table>
<legend>Top Comments</legend>
<table>
    <? 
    $num = count($comments);
    if($num == 0)
    {
        echo '<tr><td>Top Comment</td><td>No Comments So Far!</td></tr>';
    }
    else if ($num <=3)
    {
        foreach($comments as $comment)
        {
            echo '<tr><td>Comment</td><td>',$comment['comment'],'</td></tr>';
        }
    }
    else
    {
        for($i = 0; $i < 3; $i++)
        {
            echo '<tr><td>Comment</td><td>', $comments[$i]['comment'], '</td></tr>';
        }
    }
    ?>
</table>
</br>
<button class="btn btn-info" value="back" onClick="history.go(-1);return true;"><i class="icon-white icon-arrow-left"></i></button>
<a href="comments.php?id=<?echo $_GET['id']?>" class="btn btn-info">Full Comments</a>
<a href="rate.php?id=<?echo $_GET['id']?>" class="btn btn-success">Rate this Activity</a>
<a href="tag.php?id=<?echo $_GET['id']?>" class="btn btn-success">Tag this Activity</a>


