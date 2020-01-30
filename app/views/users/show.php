<h1>User's List</h1>

<?php if($this->session->flashdata('user_registered')) : ?>
    <?php echo '<p class="text-success">' .$this->session->flashdata('user_registered') . '</p>'; ?>
<?php endif; ?>


<?php if($this->session->flashdata('user_deleted')) : ?>
    <?php echo '<p class="text-success">' .$this->session->flashdata('user_deleted') . '</p>'; ?>
<?php endif; ?>

<?php if($this->session->flashdata('user_editted')) : ?>
    <?php echo '<p class="text-success">' .$this->session->flashdata('user_editted') . '</p>'; ?>
<?php endif; ?>



<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Names</th>
      <th scope="col">role</th>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <th scope="col" >Edit</th>
      <th scope="col">Delete</th>
      <?php else: ?>
        <?php echo ""; ?>
      <?php endif; ?>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($users as $user) : ?>
    
    <tr>
     <td><?php echo $user->id; ?></td>
      <td><?php echo $user->username; ?></td>
      <td><?php echo $user->role; ?></td>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <td><a href="<?php echo base_url(); ?>users/edit_user/<?php echo $user->id; ?>/<?php echo $user->username; ?>"><img src="<?php echo base_url(); ?>public/images/document_edit.png" /></a></td>
      <td><a href="<?php echo base_url(); ?>users/delete_user/<?php echo $user->id; ?>"><span class="btn-delete"><img src="<?php echo base_url(); ?>public/images/document_delete.png" /></span></a></td>
      <?php else: ?>
        <?php echo ""; ?>
      <?php endif; ?>
    </tr>
  <?php endforeach; ?>
  
  </tbody>
    
  </tbody>
</table>

<script type="text/javascript">
                

                    $(document).ready(function(){
                        $(".btn-delete").click(function(e){
                            if(!confirm('Are you sure you want to delete this User?')){
                                e.preventDefault();
                                return false;
                            }
                            return true;
                        });
                    });
                
</script>

