<h2><?echo $results['name'];?></h2>
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
<div>
    Overall Satisfaction: <?echo $results['satisfaction'];?><br/>
    Time Commitment: <?echo $results['time'];?><br/>
    Organization & Professionalism: <?echo $results['organization'];?><br/>    
    Selectiveness: <?echo $results['selectiveness'];?><br/>
    Friendliness: <?echo $results['friendliness'];?><br/>
    Member to Officer Ratio: <?echo $results['m_o_ratio'];?><br/>    
</div>
<div>
    Read Comments or I guess have top comments with a link to more comments <br/>
</div>
<div>
    Tags: <?echo $results['tags'];?><br/>
</div>
