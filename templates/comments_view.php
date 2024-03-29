<script src="js/jquery.cookie.js"></script>
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
            var id = <?echo $_GET['id']?>;
            if($.cookie('upvoted_'+id+'_'+email) === null){   
                upvotes.innerHTML=button.value;
                button.disabled=true;
                $.ajax({
                  url: 'upvote.php?id='+id,
                  type: 'POST',
                  data: {
                      email: email
                  }              
                });
                $.cookie('upvoted_'+id+'_'+email, 1);
            }
        }
</script>
<div>
<caption><h3>Comments about <?echo $results['name'];?></h3></caption>
<?
    if(!empty($comments))
    {
        echo '<table class="table table-condensed">';
        echo '<tr>
            <td>Upvotes</td><td/>
            <td>Comment</td>
        </tr>';    
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
    echo '</table>';
    }

    else
    {
        echo "No Comments So far!<br></br>";
    }
?>
<p>
    <button class="btn btn-info" value="back" onClick="history.go(-1);return true;"><i class="icon-white icon-arrow-left"></i></button>
    <a href="activity.php?id=<?echo $_GET['id']?>"class="btn btn-info">Details</a>
	<a href="rate.php?id=<?echo $_GET['id']?>" class="btn btn-success">Rate this Activity</a>
</p>
</div>
