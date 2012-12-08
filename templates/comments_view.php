<div>
<legend>Comments about <?echo $results['name'];?></legend>
<table class="table table-condensed">
<?
    if(!empty($comments))
    {
        echo '<tr>
            <td>Upvotes</td><td/>
            <td>Comment</td>
        </tr>';
    }
    foreach($comments as $index => $comment)
    {
        // <i class="icon-arrow-up"></i>
        echo '  
            <tr>
                <td>', $comment['upvotes'], '</td>
                <td>
                    <form method="post" action="/cgi-bin/myscript.cgi">
                    <input type="submit" src="img/arrow-up.png" 
                       onclick="this.disabled=true;">
                    </form>
                </td>
                <td>', $comment['comment'], '</td>
            </tr></br>';
    }
?>
</table>
<?
    if(empty($comments))
    {
        echo "<div>No Comments So far</div>";
        echo '<div><a href="activity.php?id=', $_GET['id'],'">Back</a></div>';
    }
?>
</div>
<div>
    <a href="activity.php?id=<?echo $_GET['id']?>">Back to Activity</a>
</div>
