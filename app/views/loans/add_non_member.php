<h3><u>Add Loan</u></h3>


<p>Please fill out the form below to add a Member Loan</p>
     
<h5><u>Non-Members</u></h5>
<?php echo validation_errors('<p class="text-error">'); ?>
 <?php echo form_open('loans/add_loan_non_member'); ?>
<!--Field: First Name-->

 <?php if($error) : ?>
    <?php echo '<p class="error">' .$error.'</p>'; ?>
<?php endif; ?>

<table width="30%" border="0" cellpadding="5" align="center" >
<!--Field: Username-->
<tr>
	<td>
		<?php echo form_label('Names:'); ?>
	</td>
	<td>
		<p>

		<?php
		$data = array(
		              'name'        => 'names',
		              'value'       => set_value('names')
		            );
		?>
		<?php echo form_input($data); ?>
		</p>

	</td>
</tr>


<tr>
	<td><?php echo form_label('Amount:'); ?></td>
	<td>
		<p>

		<?php
		$data = array(
		              'name'        => 'amount',
		              'value'       => set_value('amount')
		            );
		?>
		<?php echo form_input($data); ?>
		</p>
	</td>
</tr>


<tr>
	<td>
		<?php echo form_label('Adress:'); ?>
	</td>
	<td>
		<p>
			<?php
			$data = array(
			              'name'        => 'adress',
			              'value'       => set_value('adress')
			            );
			?>
			<?php echo form_input($data); ?>
		</p>
	</td>
</tr>



<tr>
	<td>
		<?php echo form_label('Email:'); ?>
	</td>
	<td>
		<p>

		<?php
		$data = array(
		              'name'        => 'email',
		              'value'       => set_value('email')
		            );
		?>
		<?php echo form_input($data); ?>
		</p>
	</td>
</tr>


<tr>
	<td>
		<?php echo form_label('Contact:'); ?>
	</td>
	<td>
		<p>
		<?php
		$data = array(
		              'name'        => 'contact',
		              'value'       => set_value('contact')
		            );
		?>
		<?php echo form_input($data); ?>
		</p>
	</td>
</tr>


<tr>
	<td>
		<?php echo form_label('Date:'); ?>
	</td>
	<td>
		<p>
		<?php
		$data = array(
		              'name'        => 'date',
		              'value'       => set_value('date'),
		              'id' => 'dos2'
		            );
		?>
		<?php echo form_input($data); ?>
		</p>
	</td>
</tr>

<!--Field: Password2-->

<tr>
	<td></td>
	<td>
		<?php $data = array("value" => "Loan",
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

<script type="text/javascript">
$(function() {
    $("#dos").datepicker();
});
$(function() {
    $("#dos2").datepicker();
});
</script>
<!--Field: First Name-->
