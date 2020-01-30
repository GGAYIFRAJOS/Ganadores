<h1>Member's List</h1>

<?php if($this->session->flashdata('member_registered')) : ?>
    <?php echo '<p class="text-success">' .$this->session->flashdata('member_registered') . '</p>'; ?>
<?php endif; ?>

<?php if($this->session->flashdata('member_updated')) : ?>
    <?php echo '<p class="text-success">' .$this->session->flashdata('member_updated') . '</p>'; ?>
<?php endif; ?>


<?php if($this->session->flashdata('member_exists')) : ?>
    <?php echo '<p class="error">' .$this->session->flashdata('member_exists') . '</p>'; ?>
<?php endif; ?>


<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Names</th>
      <th scope="col">Phone</th>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
      <?php else: ?>
      <?php echo ""; ?>
      <?php endif; ?>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($members as $member) : ?>
    
    <tr>
     <td><?php echo $member->id; ?></td>
      <td><a href="<?php echo base_url(); ?>members/get_member_info/<?php echo $member->id; ?>"><?php echo $member->names; ?></a></td>
      <td><?php echo $member->phone_cell; ?></td>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <td><a href="<?php echo base_url(); ?>members/edit_member/<?php echo $member->member_id ?>/<?php echo $member->names; ?>" style="margin-left: 12px;"><img src="<?php echo base_url(); ?>public/images/document_edit.png" /></a></td>
      <td><a href="<?php echo base_url(); ?>members/delete_member/<?php echo $member->member_id ?>" style="margin-left: 12px;"><span class="btn-delete"><img src="<?php echo base_url(); ?>public/images/document_delete.png" /></span></td>
      <?php else: ?>
      <?php echo ""; ?>
      <?php endif; ?>
    </tr>
    </tr>
  <?php endforeach; ?>

  </tbody>
    
  </tbody>
</table>


<h1>Non Member's List</h1>
<table class="tablesorter" cellspacing="1">  
    <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Names</th>
      <th scope="col">Phone</th>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
      <?php else: ?>
      <?php echo ""; ?>
      <?php endif; ?>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($non_members as $non_member) : ?>
    
    <tr>
     <td><?php echo $non_member->non_member_id; ?></td>
      <td><a href="<?php echo base_url(); ?>members/get_non_member_inform/<?php echo $non_member->non_member_id; ?>"><?php echo $non_member->non_member; ?></a></td>
      <td><?php echo $non_member->contact; ?></td>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <td><a href="#" style="margin-left: 12px;"><img src="<?php echo base_url(); ?>public/images/document_edit.png" /></td>
      <td><a href="#" style="margin-left: 12px;"><img src="<?php echo base_url(); ?>public/images/document_delete.png" /></td>
      <?php else: ?>
      <?php echo ""; ?>
      <?php endif; ?>
    </tr>
    </tr>
  <?php endforeach; ?>

  </tbody>
    
  </tbody>
</table>

 <script type="text/javascript">
                

                    $(document).ready(function(){
                        $(".btn-delete").click(function(e){
                            if(!confirm('Are you sure you want to delete this Member?')){
                                e.preventDefault();
                                return false;
                            }
                            return true;
                        });
                    });
                
</script>

