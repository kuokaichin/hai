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
                <td><span id="number_',$index,'">', $comment['upvotes'], '</span></td>
                <td>
                    <button class="btn" id="button_', $index,'" value="', $comment['upvotes']+1,'"><i class="icon-arrow-up"></i></button>
                </td>
                <td>', $comment['comment'], '</td>
            </tr></br>';
    }
?>
</table>
<?
    if(empty($comments))
    {
        echo "No Comments So far!<br></br>";
        echo '<a href="rate.php?id=', $_GET['id'],' "class="btn btn-success">Rate ', $results['name'], '</a></div></br>';
    }
?>
    <button class="btn btn-info" value="back" onClick="history.go(-1);return true;"><i class="icon-white icon-arrow-left"></i></button>
</div>
