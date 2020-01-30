<h3><u>Add Loan</u></h3>
<?php $this->load->model('member_model'); ?>

<?php $members = $this->Member_model->get_members(); ?>



<p>Please fill out the form below to add a Member Loan</p>
     
<h5><u>Members</u></h5>
<?php echo validation_errors('<p class="text-error">'); ?>
 <?php echo form_open('loans/add_loan_member'); ?>

 <?php if($error) : ?>
    <?php echo '<p class="error">' .$error.'</p>'; ?>
<?php endif; ?>
<!--Field: First Name-->
<table width="30%" border="0" cellpadding="5" align="center" >
<tr>
  <td>
    <p>
      Member:
    </p>
  </td>
  <td>
      <select class="form-control" name ="member">
            <?php 

            foreach($members as $row)
            { 
              echo '<option value="'.$row->names.'">'.$row->names.'</option>';
            }
            ?>
      </select>
  </td>
</tr>


<tr>
  <td>
      <?php echo form_label('Amount:'); ?>
  </td>
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
    <?php echo form_label('Date:'); ?>
  </td>
  <td>
      <p>
        <?php
        $data = array(
                      'name'        => 'date',
                      'value'       => set_value('date'),
                       'id' => 'dos'
                    );
        ?>
        <?php echo form_input($data); ?>
      </p>
  </td>
</tr>

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