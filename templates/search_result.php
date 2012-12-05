<div>    
    Activity Name: <?print_r($results['name']) ;?> <br/>
    Description: <br/>
    Overall Rating: <br/>
    <br/>
</div>
<div>   
    Tags: <br/>
</div>
<form action="activity.php" method="post">
    <fieldset>
        <div class="control-group">
            <input autofocus name="activity_id" placeholder="name, category...etc" type="text"/>
        </div>
        <div class="control-group">
            <button type="search_value" class="btn">Details</button>
        </div>
    </fieldset>
</form>
