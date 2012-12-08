<form action="search.php" method="get">
    <fieldset>
        <div class="control-group">
            <input autofocus name="search_value" placeholder="name, category...etc" type="text" value="<?=$_GET['search_value'] ?>"/>
        </div>
        <div class="control-group">
            <select name="filter">
            <option selected="selected" value="<?=$_GET['filter'] ?>"/><?=$_GET['filter'] ?></option>
            <option value="all">all</option>
            <option value="name">name</option>
            <option value="description">description</option>
            <option value="tags">tags</option>
            </select>
        </div>
        <div class="control-group">
            <button type="search_value" class="btn btn-primary"><i class="icon-white icon-search"></i>Search Again</button>
        </div>
    </fieldset>
</form>
<?
    if(empty($results))
    {
        echo "No Activities Found";
    }
?>

<?
    foreach($results as $result)
    {
        echo '<table class="table table-condensed">    
            <tr><td>Activity Name</td><td>' 
            , $result['name']
             , '</td></tr><br/>'
            , '<tr><td>Description</td><td>' , $result['description'] , '</td></tr><br/>',
             '<tr><td>Overall Rating</td><td>', $result['satisfaction'], '</td></tr><br/>
            <br/>
            <tr><td>Tags</td><td>', $result['tags'], '</td></tr><br/>
            <tr><td>Options</td><td><a href="activity.php?id=', $result['id'], '"class="btn btn-info">Details    </a>
            <a href="comments.php?id=', $result['id'], '"class="btn btn-info">Comments    </a>
            <a href="tag.php?id=', $result['id'], '"class="btn btn-success">Tag this Activity</a>
            <a href="rate.php?id=', $result['id'], '"class="btn btn-success">Rate this Activity</a><br/></td></tr><br/>
        </table>';
    }
?>

