

<H3>MEMBER ATTENDANCE LIST  </H3>

<?php

//$conn = mysqli_connect("127.0.0.1", "root", "", "invest");

$this->db->select('member_id, names ');
$this->db->from("members");
$value = $this->db->get();

$report = $value->result();
//$report = mysqli_query($conn,"SELECT member_id, names  FROM members") or die(mysql_error());

?>
<form action="<?php echo base_url(); ?>members/attendance" method="post">
<table class="tablesorter" cellspacing="1">
<thead>
  <tr>
    <th width="83" scope="col">ID</th>
    <th width="83" scope="col">Member Name</th>
   
    <th width="51" scope="col">Attendance</th>

   
    
  </tr>
</thead>
<tbody>
 <?php foreach($report as $mem): ?>
  <tr>
    <td><?php echo $mem->member_id; ?></td>
    <td><?php echo $mem->names; ?><?php echo '<input type="hidden" name="names[]" value="$mem->names"/>';?></td>
    <td align="center"><?php echo '<input type="hidden" name="att[]" value="0"/>';?><?php echo '<input type="checkbox"   name="att[]" value="1"  />'; ?></td>
    
  </tr>
 <?php endforeach; ?>

</tbody>
  </table>
 

 <p><?php echo '<label for="date">Date:</label><input type="date"   name="date"   />'; ?>
  <input type="submit" name ="submit2"  id="submit2" value ="submit"></input>
</form>