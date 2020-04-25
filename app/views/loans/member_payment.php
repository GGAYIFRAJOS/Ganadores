<h4><u>Member Loan Payment for <?php echo $names; ?></u></h4>



<?php echo validation_errors('<p class="text-error">'); ?>
 <?php echo form_open(base_url('loans/member_loan_payment/'.$member_id)); ?>
<!--Field: First Name-->


<!--Field: Password-->
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

<?php echo form_hidden('id', $member_id); ?>

<!--Submit Buttons-->
<?php $data = array("value" => "PAY",
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