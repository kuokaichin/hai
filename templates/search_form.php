<form action="search.php" method="post">
    <fieldset>
        <div class="control-group">
            <input autofocus name="search_value" placeholder="name, category...etc" type="text"/>
        </div>
        <div class="control-group">
            <select name="filter">
            <option value="all">All</option>
            <option value="name">Name</option>
            <option value="description">Description</option>
            <option value="tags">Tags</option>
            </select>
        </div>
        <div class="control-group">
            <button type="search_value" class="btn">Search</button>
        </div>
    </fieldset>
</form>

