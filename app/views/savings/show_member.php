
<h3><u>Savings list for <?php echo urldecode($names); ?></u></h3>


<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th >No</th>
      <th >Names</th>
      <th >Date</th>
      <th >Amount</th>
      
      
    </tr>
  </thead>
  <tbody>
  <?php $i = 0; ?>
  <?php foreach ($savings as $save) : ?>
    
    <tr>
        
    <td style="width:25%;"><?php echo ++$i; ?></td>
    <td style="width:25%;"><a href="<?php echo base_url(); ?>members/get_member_info/<?php echo $save->member_id; ?>"><?php echo urldecode($save->member); ?></a></td>
    <td style="width:25%;"><?php echo $save->date; ?></td>
    <td style="width:25%;"><?php echo $save->amount; ?></td>
      
    </tr>
    </tr>
  <?php endforeach; ?>

  </tbody>
    
  </tbody>
</table>
