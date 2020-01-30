<h5><u>BALANCE PAYMENT for <?php echo urldecode($names); ?></u></h5>


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

<hr>
