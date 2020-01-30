<?php $this->load->model('member_model'); ?>

<?php $members = $this->Member_model->get_members(); ?>


    
<h3><u>Add Savings</u></h3>
<p>Please fill out the form below to create a User account</p>

<?php if($this->session->flashdata('Savings_pay')) : ?>
    <?php echo '<p class="error">' .$this->session->flashdata('Savings_pay') . '</p>'; ?>
<?php endif; ?>

<?php if($error) : ?>
    <?php echo '<p class="error">' .$error. "<a href ="."fines_info/$id".">here</a> or balances if any". "<a href = "."balances_info/$id".">here</a></p>"; ?>
<?php endif; ?>
 
<div class="table-cover"> 
<table width="30%" border="0" cellpadding="5" align="center" >
<?php echo validation_errors('<p class="text-error">'); ?>
 <?php echo form_open('savings/add_savings'); ?>
<!--Field: First Name-->


<!--Field: Username-->
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



<!--Field: Password-->
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

    <?php
      $data = array(
                    'name'        => 'date',
                    'value'       => set_value('date'),
                    'id' => 'dos'
                  );
      ?>
    <?php echo form_input($data); ?>
  </td>
</tr>

<?php  $data = array('id'=> $row->member_id); ?>

<?php echo form_hidden($data); ?>
<tr>
  <td></td>
  <td>
    <?php $data = array("value" => "Save",
                    "name" => "submit",
                    "class" => "btn btn-primary"); ?>
<p>
    <?php echo form_submit($data); ?>
    <?php echo form_close(); ?>
</p>
  </td>
</tr>



</table>
</div>


<script type="text/javascript">
$(function() {
    $("#dos").datepicker();
});
</script>