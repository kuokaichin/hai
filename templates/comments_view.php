<script>
    window.onload = upvotebuttons;
    function upvotebuttons(){
        for (var i = 0; i < <?echo count($comments)?>; i++)
        {
            var button = document.getElementById("button_"+i);
            var upvotes = document.getElementById("number_"+i);
            console.log(button);
            console.log(upvotes);
            button.onclick=(function(button, upvotes) { return function() {showValue(button,upvotes) }})(button, upvotes);
        }
    }
    function showValue(button, upvotes)
    {
        upvotes.innerHTML=button.value;
        button.disabled=true;
    }
</script>
<div>
<legend>Comments about the <?echo $results['name'];?></legend>
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
                <td><span id="number_',$index,'">', $comment['upvotes'], '</span></td>
                <td>
                    <input id="button_', $index,'" value="', $comment['upvotes']+1,'" type="image" src="img/arrow-up.png">
                </td>
                <td>', $comment['comment'], '</td>
            </tr></br>';
    }
?>
</table>
<?
    if(empty($comments))
    {
        echo "<div>No Comments So far</div></br>";
        echo '<div><a href="rate.php?id=', $_GET['id'],'">Rate the ', $results['name'], '</a></div>';
    }
?>
</div>
<div>
    <a href="activity.php?id=<?echo $_GET['id']?>">Back to Activity Information</a>
</div>
