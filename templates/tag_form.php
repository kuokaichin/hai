<div>
    <h2><?echo $results['name']?></h2>
</div>
<legend>Existing Tags</legend>
<?echo $results['tags'];?>
<br></br>
<legend>Enter up to 5 New Tags</legend>
<form action=<?echo '"tag.php?id='. $id. '"'?> method="post">
    <fieldset>
    <div class="control-group">
        <input autofocus name="tag1" placeholder="tag1" type="text"/>
    </div>
    <div class="control-group">
        <input name="tag2" placeholder="tag2" type="text"/>
    </div>
    <div class="control-group">
        <input name="tag3" placeholder="tag3" type="text"/>
    </div>
    <div class="control-group">
        <input name="tag4" placeholder="tag4" type="text"/>
    </div>
    <div class="control-group">
        <input name="tag5" placeholder="tag5" type="text"/>
    </div>
    <div class="control-group">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    </fieldset>
</form>
<button class="btn btn-info" value="back" onClick="history.go(-1);return true;"><i class="icon-white icon-arrow-left"></i></button>
