<form action="search.php" method="post">
    <fieldset>
        <div class="control-group">
            <input autofocus name="search_value" placeholder="name, category...etc" type="text"/>
        </div>
        <div class="control-group">
            <select name="filter">
            <option value="All">All</option>
            <option value="Name">Name</option>
            <option value="Description">Description</option>
            <option value="Tags">Tags</option>
            </select>
        </div>
        <div class="control-group">
            <button type="search_value" class="btn">Search</button>
        </div>
    </fieldset>
</form>
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
            <a href="activity.php?id=', $result['id'], '">Details</a><br/><br/>
        </div>';
    }
?>

