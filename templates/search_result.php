<form action="search.php" method="post">
    <fieldset>
        <div class="control-group">
            <input autofocus name="search_value" placeholder="name, category...etc" type="text" value="<?=$_POST['search_value'] ?>"/>
        </div>
        <div class="control-group">
            <select name="filter">
            <option selected="selected" value="<?=$_POST['filter'] ?>"/><?=$_POST['filter'] ?></option>
            <option value="all">all</option>
            <option value="name">name</option>
            <option value="description">description</option>
            <option value="tags">tags</option>
            </select>
        </div>
        <div class="control-group">
            <button type="search_value" class="btn">Search</button>
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
        echo '<div>    
            Activity Name: ' 
            , $result['name']
             , '<br/>'
            , 'Description: ' , $result['description'] , '<br/>',
             'Overall Rating: ', $result['satisfaction'], '<br/>
            <br/>
        </div>
        <div>   
            Tags: ', $result['tags'], '<br/>
        </div>
        <div>
            <a href="activity.php?id=', $result['id'], '">Details</a>
            <a href="rate.php?id=', $result['id'], '">Rate this Activity</a><br/><br/>
        </div>';
    }
?>

