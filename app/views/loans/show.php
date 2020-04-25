<h1>Loans List</h1>

<?php if($this->session->flashdata('Loan_added')) : ?>
    <?php echo '<p class="text-success">' .$this->session->flashdata('Loan_added') . '</p>'; ?>
<?php endif; ?>

<H4>MEMBER LOANS</H4>

<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Names</th>
      <th scope="col">Amount</th>
      <th scope="col">Interest</th>
      
      <th scope="col">Amount Paid</th>
      <th scope="col">Balance</th>
      <th scope="col">Date</th>
      <th scope="col">Pay</th>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <th scope="col">Freeze</th>
      <th scope="col">Delete</th>
      <?php else: ?>
      <?php echo ""; ?>
      <?php endif; ?>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($mem_loans as $mem) : ?>
    
    <tr>
     <td><?php echo $mem->member_id; ?></td>
      <td><a href="<?php echo base_url(); ?>loans/get_member_loan_info/<?php echo $mem->member_id; ?>/<?php echo $mem->names; ?>"><?php echo $mem->names; ?></a></td>
      <td><?php echo $mem->amount; ?></td>
      <td><?php echo $mem->interest; ?></td>
      
      <td><?php echo $mem->total_amount; ?></td>
      <td><?php echo $mem->balance; ?></td>
      <td><?php echo $mem->due_date; ?></td>
      <td><a href="<?php echo base_url(); ?>loans/member_loan_payment/<?php echo $mem->member_id; ?>"><span class="button_cart1">PAY</span></a></td>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>

        <td><a href="<?php echo base_url(); ?>loans/member_loan_freeze/<?php echo $mem->member_id; ?>/<?php echo $mem->names; ?>"><span class="btn-freeze">FREEZE</span></a></td>
      <td><a href="<?php echo base_url(); ?>loans/delete_loan_member/<?php echo $mem->member_id; ?>"><span class="btn-delete"><img src="<?php echo base_url(); ?>public/images/document_delete.png" /></span></a></td>
     
      
      <?php else: ?>
      <?php echo ""; ?>
      <?php endif; ?>
    </tr>
    </tr>
  <?php endforeach; ?>

  </tbody>
    
  </tbody>
</table>

<H4>NON-MEMBER LOANS</H4>

<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Names</th>
      <th scope="col">Amount</th>
      <th scope="col">Interest</th>
      <th scope="col">Interest Amount</th>
      <th scope="col">Amount Paid</th>
      <th scope="col">Total Amount Due</th>
      <th scope="col">Date</th>
      <th scope="col">Pay</th>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <th scope="col">Delete</th>
      <?php else: ?>
        <?php echo ""; ?>
      <?php endif; ?>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($non_loans as $non) : ?>
    
    <tr>
     <td><?php echo $non->non_member_id; ?></td>
      <td><a href="<?php echo base_url(); ?>members/get_non_member_inform/<?php echo $non->non_member_id; ?>"><?php echo $non->non_member; ?></a></td>
      <td><?php echo $non->amount; ?></td>
      <td><?php echo $non->interest; ?></td>
	  <td><?php echo $non->interest_amount; ?></td>
	  <td><?php echo $non->total_amount; ?></td>
      <td><?php echo $non->balance; ?></td>
      <td><?php echo $non->due_date; ?></td>
      <td><a href="<?php echo base_url(); ?>loans/non_member_loan_payment/<?php echo $non->non_member_id; ?>"><span class="button_cart2">PAY</span></a></td>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <td><a href="<?php echo base_url(); ?>loans/delete_loan_non_member/<?php echo $non->non_member_id; ?>"><span class="btn-delete"><img src="<?php echo base_url(); ?>public/images/document_delete.png" /></span></a></td>
        <?php else: ?>
        <?php echo ""; ?>
      <?php endif; ?>
    </tr>
    </tr>
  <?php endforeach; ?>

  </tbody>
    
  </tbody>
</table>

<div style='display:none'>
              <div class="frm_container" id="dialog-modal-pay$mem->member_id;">
                    <div class="frm_heading"><span>Member Loan Payment Confirmation</span></div>
                    <div class="frm_inputs">
                      
                      <?php echo validation_errors('<p class="text-error">'); ?>
                       <?php echo form_open(base_url('loans/member_loan_payment/'.$mem->member_id)); ?>
                      <!--Field: First Name-->


                      <!--Field: Password-->
                      <p>
                      <?php echo form_label('Amount:'); ?>
                      <?php
                      $data = array(
                                    'name'        => 'amount',
                                    'value'       => set_value('amount')
                                  );
                      ?>
                      <?php echo form_input($data); ?>
                      </p>
                      <!--Field: Password2-->
                      <p>
                      <?php echo form_label('Date:'); ?>
                      <?php
                      $data = array(
                                    'name'        => 'date',
                                    'value'       => set_value('date'),
                                     'id' => 'dos'
                                  );
                      ?>
                      <?php echo form_input($data); ?>
                      </p>

                      <?php echo form_hidden('id', $mem->member_id); ?>

                      <!--Submit Buttons-->
                      <?php $data = array("value" => "PAY",
                                          "name" => "submit",
                                          "class" => "btn btn-primary"); ?>
                      <p>
                          <?php echo form_submit($data); ?>
                      </p>
                      <?php echo form_close(); ?>

                      <hr>
                </div>
              </div>   
</div>

<div style='display:none'>
              <div class="frm_container" id="dialog-modal-pay2">
                    <div class="frm_heading"><span>Non Member Loan Payment Confirmation</span></div>
                    <div class="frm_inputs">
                      
                            <?php echo validation_errors('<p class="text-error">'); ?>
                             <?php echo form_open(base_url('loans/non_member_loan_payment/'.$non->non_member_id)); ?>
                            <!--Field: First Name-->


                            <!--Field: Password-->
                            <p>
                            <?php echo form_label('Amount:'); ?>
                            <?php
                            $data = array(
                                          'name'        => 'amount',
                                          'value'       => set_value('amount')
                                        );
                            ?>
                            <?php echo form_input($data); ?>
                            </p>
                            <!--Field: Password2-->
                            <p>
                            <?php echo form_label('Date:'); ?>
                            <?php
                            $data = array(
                                          'name'        => 'date',
                                          'value'       => set_value('date'),
                                           'id' => 'dos2'
                                        );
                            ?>
                            <?php echo form_input($data); ?>
                            </p>

                            <?php echo form_hidden('id', $non->non_member_id); ?>

                            <!--Submit Buttons-->
                            <?php $data = array("value" => "PAY",
                                                "name" => "submit",
                                                "class" => "btn btn-primary"); ?>
                            <p>
                                <?php echo form_submit($data); ?>
                            </p>
                            <?php echo form_close(); ?>

                </div>
              </div>   
</div>

<script type="text/javascript">
      $( '.button_cart1' ).button({ icons: {primary:'ui-icon-cart'} });
      $( '.button_cart1').colorbox({width:'30%', inline:true, href:'#dialog-modal-pay$mem->member_id;');
</script>


<script type="text/javascript">
      $( '.button_cart2' ).button({ icons: {primary:'ui-icon-cart'} });
      $( '.button_cart2').colorbox({width:'30%', inline:true, href:'#dialog-modal-pay2'});
</script>

<script type="text/javascript">
      $( '.btn-freeze' ).button({ icons: {primary:'ui-icon-locked'} });
     
    </script>

<script type="text/javascript">
$(function() {
    $("#dos").datepicker();
});
</script>

<script type="text/javascript">
$(function() {
    $("#dos2").datepicker();
});
</script>

 <script type="text/javascript">
                

                    $(document).ready(function(){
                        $(".btn-delete").click(function(e){
                            if(!confirm('Are you sure you want to delete this Loan?')){
                                e.preventDefault();
                                return false;
                            }
                            return true;
                        });
                    });
                

                $(document).ready(function(){
                        $(".btn-freeze").click(function(e){
                            if(!confirm('Are you sure you want to freeze this Loan?')){
                                e.preventDefault();
                                return false;
                            }
                            return true;
                        });
                    });
                
</script>

