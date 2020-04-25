<h1>Add Expense</h1>
<p>Please fill out the form below to create a new Member</p>
<!--Display Errors-->
<?php echo validation_errors('<p class="text-error">'); ?>
 <?php echo form_open('members/add_expenses'); ?>
<!--Field: First Name-->
<table width="30%" border="0" cellpadding="5" align="center" >


<tr>
	<td>
		<?php echo form_label('Expense Name:'); ?>
	</td>
	<td>
		<?php
		$data = array(
		              'name'        => 'expense_name',
		              'value'       => set_value('expense_name')
		            );
		?>
		<?php echo form_input($data); ?>
	</td>
</tr>


<tr>
	<td>
		<?php echo form_label('Amount:'); ?>
	</td>
	<td>
		<?php
			$data = array(
			              'name'        => 'amount',
			              'value'       => set_value('amount')
			            );
			?>
			<?php echo form_input($data); ?>

	</td>
</tr>


<tr>
	<td></td>
	<td>
		<?php $data = array("value" => "Add Expense",
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