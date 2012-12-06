<form action="search.php" method="post">
    <fieldset>
        <div class="control-group">
            <input autofocus name="search_value" placeholder="name, category...etc" type="text"/>
        </div>
        <div class="control-group">
            <select name="filter">
            <option value="All">all</option>
            <option value="Name">name</option>
            <option value="Description">description</option>
            <option value="Tags">tags</option>
            </select>
        </div>
        <div class="control-group">
            <button type="search_value" class="btn">Search</button>
        </div>
    </fieldset>
</form>

