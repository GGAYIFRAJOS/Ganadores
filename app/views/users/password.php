<h3><u>Changing Password for User - <?php echo $names; ?></u></h3>

     
<table width="30%" border="0" cellpadding="5" align="center" >
<?php echo validation_errors('<p class="text-error">'); ?>
 <?php echo form_open('users/change_password'); ?>
<!--Field: First Name-->



<tr>
  <td>
      <?php echo form_label('Password:'); ?>
  </td>
  <td>
      <p>

      <?php
      $data = array(
                    'name'        => 'password',
                    'value'       => set_value('password')
                  );
      ?>
      <?php echo form_password($data); ?>
      </p>
  </td>
</tr>


<tr>
  <td>
    <p><?php echo form_label('Confirm Password:'); ?></p>
  </td>
  <td>
      <p>

      <?php
      $data = array(
                    'name'        => 'password2',
                    'value'       => set_value('password2')
                  );
      ?>
      <?php echo form_password($data); ?>
      </p>
  </td>
</tr>


<tr>
  <td></td>
  <td>
      <?php $data = array("value" => "CHANGE",
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