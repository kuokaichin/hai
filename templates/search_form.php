<form action="search.php" method="post">
    <fieldset>
        <div class="control-group">
            <input autofocus name="search_value" placeholder="name, category...etc" type="text"/>
        </div>
        <div class="control-group">
            <select name="filter">
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

