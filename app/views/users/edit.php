    
    <h3><u>User Edit for <?php echo urldecode($names); ?></u></h3>

     

<?php echo validation_errors('<p class="text-error">'); ?>
 <?php echo form_open(base_url('users/edit_user/'.$id.'/'.$names)); ?>
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

<?php echo form_label('User Role:'); ?>
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
<?php $data = array("value" => "Edit",
                    "name" => "submit",
                    "class" => "btn btn-primary"); ?>
<p>
    <?php echo form_submit($data); ?>
</p>
<?php echo form_close(); ?>