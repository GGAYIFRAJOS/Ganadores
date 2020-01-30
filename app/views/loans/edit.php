    
    <h3><u>Edit Loan</u></h3>
<p>Please fill out the form below to Edit User Loan</p>
     

<?php echo validation_errors('<p class="text-error">'); ?>
 <?php echo form_open('users/register'); ?>
<!--Field: First Name-->


<!--Field: Username-->
<p>
<?php echo form_label('Username:'); ?>
<?php
$data = array(
              'name'        => 'username',
              'value'       => set_value('username')
            );
?>
<?php echo form_input($data); ?>
</p>

<?php  
$options = array(
                'member'         => 'Member',
                'nonmember'           => 'Non Member',
                
              );

          
echo form_dropdown('membership', $options, 'member');
?>

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
              'value'       => set_value('date')
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Submit Buttons-->
<?php $data = array("value" => "Register",
                    "name" => "submit",
                    "class" => "btn btn-primary"); ?>
<p>
    <?php echo form_submit($data); ?>
</p>
<?php echo form_close(); ?>