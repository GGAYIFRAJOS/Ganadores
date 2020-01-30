<h3 >Editing Member Information for <?php echo urldecode($names); ?></h3>
<p>Please fill out the form below to edit the Member's information</p>

<?php $names = urldecode($names); ?>
<!--Display Errors-->
<?php echo validation_errors('<p class="text-error">'); ?>
 <?php echo form_open(base_url('members/edit_member/'.$id.'/'.$names)); ?>
<!--Field: First Name-->
<p>
<?php echo form_label('Names:'); ?>
<?php
$data = array(
              'name'        => 'names',
              'value'       => set_value('names')
            );
?>
<?php echo form_input($data); ?>


<?php echo form_label('Adress:'); ?>
<?php
$data = array(
              'name'        => 'adress',
              'value'       => set_value('adress')
            );
?>
<?php echo form_input($data); ?>

</p>


<?php echo form_label('Phone:'); ?>
<?php
$data = array(
              'name'        => 'phone_cell',
              'value'       => set_value('phone_cell')
            );
?>
<?php echo form_input($data); ?>

</p>


<?php echo form_label('Email:'); ?>
<?php
$data = array(
              'name'        => 'email',
              'value'       => set_value('email')
            );
?>
<?php echo form_input($data); ?>

</p>
<!--Field: Last Name-->


<!--Submit Buttons-->
<?php $data = array("value" => "EDIT",
                    "name" => "submit",
                    "class" => "btn btn-primary"); ?>
<p>
    <?php echo form_submit($data); ?>
</p>
<?php echo form_close(); ?>