<h3>Attendance list</h3>

<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th >No</th>
      <th >Names</th>
      <th >Date</th>
      <th >Status</th>
      <th>Fine</th>
    </tr>
  </thead>
  <tbody>
  <?php $i = 0; $total_fines = 0;?>
  <?php foreach ($attendance as $attend) : ?>
    
    
    <tr>  
    <td style="width:20%;"><?php echo ++$i; ?></td>
    <td style="width:20%;"><?php echo $attend->member; ?></td>
    <td style="width:20;"><?php echo $attend->date; ?></td>
    <td style="width:20%;"><?php echo $attend->status; ?></td>
    <td style="width:20%;"><?php echo $attend->fine; ?><?php $total_fines += $attend->fine; ?></td>
    </tr>
  <?php endforeach; ?>

  </tbody>

  <tfoot>
    <td><b>TOTAL</b></td>
    <td></td>
    <td></td>
    <td></td>
    <td><?php echo $total_fines; ?></td>
  </tfoot>
    
  
</table>


