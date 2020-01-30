<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<a href="index.php"><title>Ganadores Investment Club</title></a>

<link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">


<!-- General CSS -->
<link type="text/css" href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" />

<!-- jQuery -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/jquery/jquery-1.6.4-min.js"></script>

<!-- jQuery-UI -->
<link type="text/css" href="<?php echo base_url(); ?>assets/css/jquery-ui/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/jquery/jquery-ui-1.8.16.custom.min.js"></script>





<!-- Color Box -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/jquery/plugins/colorbox/jquery.colorbox-min.js"></script>
<link type="text/css" href="<?php echo base_url(); ?>assets/jquery/plugins/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="<?= base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>js/bootstrap-datepicker.js"></script>

<link type="text/css" href="<?php echo base_url(); ?>assets/css/tablesorter/style.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/jquery/plugins/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/jquery/plugins/jquery.tablesorter.pager.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/jquery/plugins/jquery.tablesorter.widgets.min.js"></script>

</head>
<body >


 <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#">Ganadores</a>

          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
             <!--RIGHT TOP CONTENT-->
             <?php if($this->session->userdata('logged_in')) : ?>
               Welcome,  <?php echo $this->session->userdata('username'); ?>
             <?php else : ?>
                <a href="<?php echo base_url(); ?>users/register">Register</a>
             <?php endif; ?>
            </p>
          
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
<div id="content2" class="contentTitle2">


<div class="clear-fix"></div>
    <div class="container-fluid  contentBody2" style="background-color: white;">
      <div class="row-fluid">
        <div class="span7">
          
          <div style="margin:0 0 10px 10px;">
			<!--SIDEBAR CONTENT-->
			<img src="<?php echo base_url(); ?>assets/css/finance3.jpg">
          </div>
         
        </div><!--/span-->

        <div class="span5">
   		<div class="forms">
        <?php $this->load->view($main_content); ?>
      </div>
			
        </div><!--/span-->
		</div><!--/row-->
      <hr>

      <footer>
        <p align="center"><b>&copy; Ganadores Investment Club,2019</b></p>
      </footer>
    </div><!--/.fluid-container-->
</div>

</body>
</html>

