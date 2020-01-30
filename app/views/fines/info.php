<h3>Fines list for <?php echo $names ?></h3>

<?php if($this->session->flashdata('amount_excess')) : ?>
    <?php echo '<p class="error">' .$this->session->flashdata('amount_excess') . '</p>'; ?>
<?php endif; ?>

<p style="text-align: right;"><a href="<?php echo base_url(); ?>fines/pay_fines/<?php echo $id;?>/<?php echo $names;?>"><span class="button_cart2">PAY FINES</span></a></p>

<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th >No</th>
      <th >Dates</th>
      <th >Fines</th>
      <th >Status</th>
    </tr>
  </thead>
  <tbody>
  <?php $i = 0; $total_fines = 0; ?>
  <?php foreach ($fines as $fine) : ?>
  	
    <?php $dates = $this->Dates_model->get_range_dates($fine->fine_range); ?>
    <tr>  
    <td style="width:25%;"><?php echo ++$i; ?></td>
    <td style="width:25%;"><?php echo $dates; ?></td>
    <td style="width:25%;"><?php echo $fine->fine; ?><?php $total_fines += $fine->fine; ?></td>
    <td style="width:25%;"><?php echo $fine->status; ?></td>
    </tr>
  <?php endforeach; ?>

  </tbody>

  <tfoot>
    <td>TOTAL</td>
    <td></td>
    <td><?php echo $total_fines; ?></td>
    <td></td>
  </tfoot>
    
  
</table>

<div style='display:none'>
              <div class="frm_container" id="dialog-modal-pay-fine">
                    <div class="frm_heading"><span>Fine Payment Confirmation</span></div>
                    <div class="frm_inputs">
                      <?php echo validation_errors('<p class="text-error">'); ?>
                  <?php echo form_open(base_url('fines/pay_fines/'.$id.'/'.$names)); ?>
                  <p>
                  <?php echo form_label('Amount:'); ?>
                  <?php
                  $data = array(
                                'name'        => 'amount',
                                'value'       => set_value('amount')
                              );
                  ?>
                  <?php echo form_input($data); ?>
                  </p>
                  <!--Field: Password2-->
                  <p>
                  <?php echo form_label('Date:'); ?>
                  <?php
                  $data = array(
                                'name'        => 'date',
                                'value'       => set_value('date'),
                                 'id' => 'dos2'
                              );
                  ?>
                  <?php echo form_input($data); ?>
                  </p>

                  <!--Submit Buttons-->
                  <?php $data = array("value" => "Pay Fine",
                                      "name" => "submit",
                                      "class" => "btn btn-primary"); ?>
                  <p>
                      <?php echo form_submit($data); ?>
                  </p>
                  <?php echo form_close(); ?>
                </div>
              </div>   
</div>


<script type="text/javascript">
      $( '.button_cart2' ).button({ icons: {primary:'ui-icon-cart'} });
      $( '.button_cart2').colorbox({width:'30%', inline:true, href:'#dialog-modal-pay-fine'});
</script>

<script type="text/javascript">
$(function() {
    $("#dos2").datepicker();
});
</script>