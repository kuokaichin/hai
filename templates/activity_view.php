<h2><?echo $results['name'];?></h2>
<legend>Basic Information</legend>
<table class="table table-condensed">    
    <tr>
        <td>Description</td>
        <td><?echo $results['description'];?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?echo $results['email'];?></td>
    </tr>
    <tr>
        <td>Website</td>
        <td><?echo $results['website'];?></td>
    </tr>
    <tr>
        <td>Size</td>
        <td><?echo $results['size'];?></td>
    </tr>
    <tr>
        <td>Members</td>
        <td><?echo $results['members'];?></td>
</table>
<legend>Average Ratings</legend>
<table class="table table-condensed">
    <tr>
        <td>Overall Satisfaction</td>
        <td><?echo $results['satisfaction'];?></td>
    </tr>
    <tr>
        <td>Time Commitment</td>
        <td><?echo $results['time'];?></td>
    </tr>
    <tr>
        <td>Organization & Professionalism</td>
        <td><?echo $results['organization'];?></td>
    </tr>
    <tr>  
        <td>Selectiveness</td>
        <td><?echo $results['selectiveness'];?></td>
    </tr>
    <tr>
        <td>Friendliness</td>
        <td><?echo $results['friendliness'];?></td>
    </tr>
    <tr>
        <td>Member to Officer Ratio</td>
        <td><?echo $results['m_o_ratio'];?></td>    
</table>
<div>
    Read Comments or I guess have top comments with a link to more comments <br/>
</div>
<div>
    Tags: <?echo $results['tags'];?><br/>
</div>
