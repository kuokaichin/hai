<div>
    <h2><?echo $results['name']?></h2>
</div>
<form action="rate.php" method="post">
    <fieldset>
    <legend>Please enter your ratings:</legend>
    <input id="name" type="hidden" value=<?$results['name']?> />
            <script type="text/javascript">
                window.onload = updatingsliders;
                function updatingsliders(){
                    var categories = ["satisfaction", "time", "organization", "selectiveness", "friendliness" , "member_officer_ratio"];
                    for (var i in categories)
                    {
                        var input = document.getElementById(categories[i]+"_input");
                        var span = document.getElementById(categories[i]);
                        console.log(input);
                        console.log(span);
                        input.onchange= (function(input, span) { return function() {console.log(input, span); showValue(input.value,span) }})(input, span);
                    }
                }
                function showValue(newValue, span)
                {
                    console.log(span);
	                span.innerHTML=newValue;
                }
            </script>

<?
    $categories = array("satisfaction" => array( 'name' => "Overall Satisfaction ", 'max' => 5), "time" => array( 'name' => "Time Commitment (hrs/wk)", 'max' => 20), "organization" => array( 'name' => "Organization and Professionalism", 'max' => 5), "selectiveness" => array( 'name' => "Selectivness", 'max' => 5), "friendliness" => array( 'name' => "Friendliness", 'max' => 5), "member_officer_ratio" => array( 'name' => "Member:Officer Ratio", 'max' => 100));
    foreach ($categories as $cat => $array)
    {
    echo '<div class="control-group">
                <label>',
                $array['name'],'</label>
                <input id="',$cat.'_input', '" type="range" min="1" max="', $array['max'], '" value="1" step="1" />
                <span id="', $cat, '">1</span>
            </div>', "\n";
    }
?>
        <div class="control-group">
            <label class="control-label" for="comments">Comments (1000 Character Limit)</label>
            <div class="controls">  
              <textarea class="input-xlarge" id="comments" rows="3" maxlength="1000">I think this activity...</textarea>  
            </div>  
        </div>
        <div class="control-group">  
            <label class="control-label" for="email">Harvard Email</label>  
            <div class="controls">  
              <input type="text" class="input-xlarge" id="email" maxlength="50">  
              <p class="help-block">For verification purposes. No emails will come from Nigerian princes and your rating is anonymous!</p>  
            </div>  
          </div>  
        <div class="control-group">
            <button type="rate" class="btn-primary">Submit</button>
        </div>
    </fieldset>
</form>
