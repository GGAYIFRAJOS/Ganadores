<h1>Add a Member</h1>
<p>Please fill out the form below to create a new Member</p>
<!--Display Errors-->
<?php echo validation_errors('<p class="text-error">'); ?>
 <?php echo form_open('members/add_member'); ?>
<!--Field: First Name-->
<table width="30%" border="0" cellpadding="5" align="center" >
<tr>
	<td>
		<?php echo form_label('Names:'); ?>
	</td>
	<td>
		

		<?php
		$data = array(
		              'name'        => 'names',
		              'value'       => set_value('names')
		            );
		?>
		<?php echo form_input($data); ?>

	</td>
</tr>

<tr>
	<td>
		<?php echo form_label('Adress:'); ?>
	</td>
	<td>
		<?php
		$data = array(
		              'name'        => 'adress',
		              'value'       => set_value('adress')
		            );
		?>
		<?php echo form_input($data); ?>
	</td>
</tr>


<tr>
	<td>
		<?php echo form_label('Phone:'); ?>
	</td>
	<td>
		<?php
			$data = array(
			              'name'        => 'phone_cell',
			              'value'       => set_value('phone_cell')
			            );
			?>
			<?php echo form_input($data); ?>

	</td>
</tr>



<tr>
	<td>
		<?php echo form_label('Email:'); ?>
	</td>
	<td>
		
		<?php
		$data = array(
		              'name'        => 'email',
		              'value'       => set_value('email')
		            );
		?>
		<?php echo form_input($data); ?>
	</td>
</tr>

<tr>
	<td></td>
	<td>
		<?php $data = array("value" => "Add Member",
                    "name" => "submit",
                    "class" => "btn btn-primary"); ?>
	<p>
	    <?php echo form_submit($data); ?>
	</p>
	<?php echo form_close(); ?>
	</td>
</tr>

<!--Submit Buttons-->

</table>