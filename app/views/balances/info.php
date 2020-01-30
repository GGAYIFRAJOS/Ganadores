<h3>Balances list for <?php echo $names ?></h3>

<?php if($this->session->flashdata('amount_excess')) : ?>
    <?php echo '<p class="error">' .$this->session->flashdata('amount_excess') . '</p>'; ?>
<?php endif; ?>

<p style="text-align: right;"><a href="<?php echo base_url(); ?>balances/pay_balances/<?php echo $id;?>/<?php echo $names;?>"><span class="button_cart1">PAY BALANCES</span></a></p>
<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th >No</th>
      <th >Dates</th>
      <th >Balances</th>
      <th >Status</th>
    </tr>
  </thead>
  <tbody>
  <?php $i = 0; $total_balances = 0;?>
  <?php foreach ($balances as $balance) : ?>
    <?php $dates = $this->Dates_model->get_range_dates($balance->balance_range); ?>
    <tr>  
    <td style="width:25%;"><?php echo ++$i; ?></td>
    <td style="width:25%;"><?php echo $dates; ?></td>
    <td style="width:25%;"><?php echo $balance->balance; ?><?php $total_balances += $balance->balance; ?></td>
    <td style="width:25%;"><?php echo $balance->status; ?></td>
    </tr>
  <?php endforeach; ?>

  </tbody>

  <tfoot>
    <td>TOTAL</td>
    <td></td>
    <td><?php echo $total_balances; ?></td>
    <td></td>
  </tfoot>
  
</table>


<div style='display:none'>
              <div class="frm_container" id="dialog-modal-pay">
                    <div class="frm_heading"><span>Balance Payment Confirmation</span></div>
                    <div class="frm_inputs">
                      <?php echo validation_errors('<p class="text-error">'); ?>
                  <?php echo form_open(base_url('balances/pay_balance/'.$id.'/'.$names)); ?>
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
                                 'id' => 'dos'
                              );
                  ?>
                  <?php echo form_input($data); ?>
                  </p>

                  <!--Submit Buttons-->
                  <?php $data = array("value" => "Pay Balance",
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
      $( '.button_cart1' ).button({ icons: {primary:'ui-icon-cart'} });
      $( '.button_cart1').colorbox({width:'30%', inline:true, href:'#dialog-modal-pay'});
    </script>

<script type="text/javascript">
$(function() {
    $("#dos").datepicker();
});
</script>