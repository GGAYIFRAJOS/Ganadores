<?php $this->load->model('member_model'); ?>

<?php $members = $this->Member_model->get_members(); ?>


    
<h3><u>Add Savings for <?php echo $names; ?></u></h3>

<?php if($error) : ?>
    <?php echo '<p class="error">' .$error. '</p>'; ?>
<?php endif; ?>
     

<?php echo validation_errors('<p class="text-error">'); ?>
 <?php echo form_open('savings/add_savings_direct/'.$id.'/'.urldecode($names)); ?>
<!--Field: First Name-->


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
<!--Field: Password2-->

<!--Submit Buttons-->
<?php $data = array("value" => "Save",
                    "name" => "submit",
                    "class" => "btn btn-primary"); ?>
<p>
    <?php echo form_submit($data); ?>
</p>
<?php echo form_close(); ?>

<script type="text/javascript">
$(function() {
    $("#dos").datepicker();
});
</script>