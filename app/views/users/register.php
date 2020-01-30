    
  <h3><u>User Register</u></h3>
<p>Please fill out the form below to create a User account</p>
     
<table width="30%" border="0" cellpadding="5" align="center" >
<?php echo validation_errors('<p class="text-error">'); ?>
 <?php echo form_open('users/add_user'); ?>
<!--Field: First Name-->


<tr>
  <td>
      <?php echo form_label('Username:'); ?>
  </td>
  <td>
      <p>

      <?php
      $data = array(
                    'name'        => 'username',
                    'value'       => set_value('username')
                  );
      ?>
      <?php echo form_input($data); ?>
      </p>
  </td>
</tr>


<tr>
  <td>
      <?php echo form_label('User Role:'); ?>
  </td>
  <td>
      <?php  
      $options = array(
                      'admin'         => 'Administrator',
                      'user'           => 'User',
                      'assistant'         => 'Assistant'
                    );

                
      echo form_dropdown('role', $options, 'user');
      ?>
  </td>
</tr>


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
      <?php $data = array("value" => "Register",
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