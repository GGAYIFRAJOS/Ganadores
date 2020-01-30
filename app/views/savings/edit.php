    
    <h3><u>User Register</u></h3>
<p>Please fill out the form below to create a User account</p>
     

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
                'admin'         => 'Administrator',
                'user'           => 'User',
                'assistant'         => 'Assistant'
              );

          
echo form_dropdown('role', $options, 'user');
?>

<!--Field: Password-->
<p>
<?php echo form_label('Password:'); ?>
<?php
$data = array(
              'name'        => 'password',
              'value'       => set_value('password')
            );
?>
<?php echo form_password($data); ?>
</p>

<!--Field: Password2-->
<p>
<?php echo form_label('Confirm Password:'); ?>
<?php
$data = array(
              'name'        => 'password2',
              'value'       => set_value('password2')
            );
?>
<?php echo form_password($data); ?>
</p>

<!--Submit Buttons-->
<?php $data = array("value" => "Register",
                    "name" => "submit",
                    "class" => "btn btn-primary"); ?>
<p>
    <?php echo form_submit($data); ?>
</p>
<?php echo form_close(); ?>