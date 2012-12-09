<script>
        window.onload = upvotebuttons;
        function upvotebuttons(){
            for (var i = 0; i < <?echo count($comments)?>; i++)
            {
                var button = document.getElementById("button_"+i);
                var upvotes = document.getElementById("number_"+i);
                var email = upvotes.getAttribute("value");
                button.onclick=(function(button, upvotes, email) { return function() {showValue(button,upvotes, email) }})(button, upvotes, email);
            }
        }
        function showValue(button, upvotes, email)
        {
            if($.cookie('upvoted') === null){            
                upvotes.innerHTML=button.value;
                button.disabled=true;
                $.ajax({
                  url: 'upvote.php?id=<?echo $_GET['id']?>',
                  type: 'POST',
                  data: {
                      email: email
                  }              
                });
                $.cookie('upvoted', 'email+<?echo $_GET['id']?>');
            }
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
        echo '  
            <tr>
                <td><span id="number_',$index,'" value="',$comment['email'],'">', $comment['upvotes'], '</span></td>
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
    <a href="rate.php?id=', $result['id'], '"class="btn btn-success">Rate this Activity</a>
</div>
