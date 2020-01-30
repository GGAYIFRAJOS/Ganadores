<h5><u>FINE PAYMENT for <?php echo urldecode($names); ?></u></h5>

<?php $names = urldecode($names); ?>

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
               'id' => 'dos'
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

<hr>

<script type="text/javascript">
$(function() {
    $("#dos").datepicker();
});
</script>