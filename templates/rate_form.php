<!--Displays a form for submission of ratings -->
<div>
    <h2><?echo $results['name']?></h2>
</div>
<form action=<?echo '"rate.php?id='. $id. '"'?> method="post">
    <fieldset>
    <legend>Please enter your ratings! </legend>
	<h5>Handy sliders only available in Chrome, Safari, and Opera. Otherwise please enter integers within indicated range, with 5 being highest.</h5>
            <!-- The javascript allows updating of values and value displayed when the bar is moved -->
            <script>
                window.onload = updatingsliders;
                function updatingsliders(){
                    var categories = ["satisfaction", "time", "organization", "selectiveness", "friendliness" , "learning_impact"];
                    for (var i in categories)
                    {
                        var input = document.getElementById(categories[i]+"_input");
                        var span = document.getElementById(categories[i]);
                        input.onchange= (function(input, span) { return function() {showValue(input.value,span) }})(input, span);
                    }
                }
                function showValue(newValue, span)
                {
	                span.innerHTML=newValue;
                }
            </script>

<?
    $categories = array("satisfaction" => array( 'name' => "Overall Satisfaction (1-5) ", 'max' => 5), "time" => array( 'name' => "Time Commitment (1-30 hrs/wk)", 'max' => 30), "organization" => array( 'name' => "Organization and Professionalism (1-5)", 'max' => 5), "selectiveness" => array( 'name' => "Selectivness (1-5, 5 being most selective)", 'max' => 5), "friendliness" => array( 'name' => "Friendliness (1-5)", 'max' => 5), "learning_impact" => array( 'name' => "Learning & Impact (1-5)", 'max' => 5));
    // html portion of form with sliders
    foreach ($categories as $cat => $array)
    {
    echo '<div class="control-group">
                <label>',
                $array['name'],'</label>
                <input id="',$cat.'_input', '" name="',$cat.'_input', '" type="range" min="1" max="', $array['max'], '" value="1" step="1" />
                <span id="', $cat, '">1</span>
            </div>', "\n";
    }
?>
        <div class="control-group">
            <label class="control-label" for="comment">Comments (1000 Character Limit)</label>
            <div class="controls">  
              <textarea class="input-xlarge" name="comment" placeholder="I think this activity..."rows="3" maxlength="1000"></textarea>  
            </div>  
        </div>
        <div class="control-group">  
            <label class="control-label" for="email">Harvard Email</label>  
            <div class="controls">  
              <input type="text" class="input-xlarge" name="email" maxlength="50">  
              <p class="help-block">For verification purposes. No emails will come from Nigerian princes and your rating is anonymous!</p>  
            </div>  
          </div>  
        <div class="control-group">
            <button type="rate" class="btn-primary">Submit</button>
        </div>
    </fieldset>
</form>
<button class="btn btn-info" value="back" onClick="history.go(-1);return true;"><i class="icon-white icon-arrow-left"></i></button>
