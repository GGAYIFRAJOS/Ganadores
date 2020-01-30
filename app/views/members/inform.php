<style>
			body, p, table, tr, td {
				font-size: 12px;
				font-family: verdana,helvetica,arial,sans-serif;
			}
			p {
				text-align: justify;
				margin:0;
			}
			table {width:100%;}
			table.collapse {
				border-collapse: collapse;
			}

			tr td, tr th {
				text-align: right;
			}

			tr.total {
				font-weight: 900;
			}
			hr {
				margin: 15px 0;
			}
			h1 {
				margin:0;
			}

			.title {
				color: #000;
				font-size: 18px;
				font-weight: normal;
			}

			.section {
				border-bottom: 1px #D4D4D4 solid;
				padding: 10px 0;
				margin-bottom: 20px;
			}

			.section .content {
				margin-left: 10px;
			}
			/* Blue Theme */
table.tablesorter {
	font: 11px/18px Arial, Sans-serif;
	background-color: #cdcdcd;
	margin: 10px 0 15px;
	width: 100%;
	text-align: left;
	border-spacing: 0;
}
table.tablesorter,
table.tablesorter th,
table.tablesorter td {
	border: #cdcdcd 1px solid;
}

table.tablesorter th {
	background-color: purple;
	color: #FFF;
	border-collapse: collapse;
	font: 14px/18px Arial, Sans-serif;
	padding: 4px;
	font-weight: 300;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .3);
	text-align: left;
}

table.tablesorter tfoot {
	background-color: purple;
	color: #FFF;
	border-collapse: collapse;
	font: 14px/18px Arial, Sans-serif;
	padding: 4px;
	font-weight: 300;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .3);
}
table.tablesorter .header,
table.tablesorter .tablesorter-header {
	/* black double arrow */
	background-image: url(data:image/gif;base64,R0lGODlhFQAJAIAAACMtMP///yH5BAEAAAEALAAAAAAVAAkAAAIXjI+AywnaYnhUMoqt3gZXPmVg94yJVQAAOw==);
	/* white double arrow */
	/* background-image: url(data:image/gif;base64,R0lGODlhFQAJAIAAAP///////yH5BAEAAAEALAAAAAAVAAkAAAIXjI+AywnaYnhUMoqt3gZXPmVg94yJVQAAOw==); */
	/* image */
	/* background-image: url(black-bg.gif); */
	background-repeat: no-repeat;
	background-position: center right;
	padding: 4px 20px 4px 4px;
	cursor: pointer;
}
table.tablesorter tbody td {
	color: #3d3d3d;
	padding: 4px;
	background-color: #fff;
	vertical-align: top;
	text-align: left;
}
table.tablesorter tbody td.due {background-color: red}
table.tablesorter tbody td.paid {background-color: #D1EFD1}
table.tablesorter tbody td.due_now {background-color: green}
table.tablesorter th.headerSortUp,
table.tablesorter th.tablesorter-headerSortUp {
	background-color: #9fbfdf;
	/* black asc arrow */
	background-image: url(data:image/gif;base64,R0lGODlhFQAEAIAAACMtMP///yH5BAEAAAEALAAAAAAVAAQAAAINjB+gC+jP2ptn0WskLQA7);
	/* white asc arrow */
	/* background-image: url(data:image/gif;base64,R0lGODlhFQAEAIAAAP///////yH5BAEAAAEALAAAAAAVAAQAAAINjB+gC+jP2ptn0WskLQA7); */
	/* image */
	/* background-image: url(black-asc.gif); */
}
table.tablesorter th.headerSortDown,
table.tablesorter th.tablesorter-headerSortDown {
	background-color: #8cb3d9;
	/* black desc arrow */
	background-image: url(data:image/gif;base64,R0lGODlhFQAEAIAAACMtMP///yH5BAEAAAEALAAAAAAVAAQAAAINjI8Bya2wnINUMopZAQA7);
	/* white desc arrow */
	/* background-image: url(data:image/gif;base64,R0lGODlhFQAEAIAAAP///////yH5BAEAAAEALAAAAAAVAAQAAAINjI8Bya2wnINUMopZAQA7); */
	/* image */
	/* background-image: url(black-desc.gif); */
}
/* used to hide a tbody while rebuilding to speed it up */
table.tablesorter .tablesorter-hidden {
	display: none;
}

/* Zebra Widget - row alternating colors */
table.tablesorter tr.odd td {
	background-color: #ebf2fa;
}
table.tablesorter tr.even td {
	background-color: #fff;
}

/* Column Widget - column sort colors */
.tablesorter td.primary,
.tablesorter tr.odd td.primary {
	background-color: #99b3e6;
}
.tablesorter tr.even td.primary {
	background-color: #c2d1f0;
}

.tablesorter td.secondary,
.tablesorter tr.odd td.secondary {
	background-color: #c2d1f0;
}
.tablesorter tr.even td.secondary {
	background-color: #d6e0f5;
}

.tablesorter td.tertiary,
.tablesorter tr.odd td.tertiary {
	background-color: #d6e0f5;
}
.tablesorter tr.even td.tertiary {
	background-color: #ebf0fa;
}

/* hovered row colors */
table.tablesorter tbody tr:hover td,
table.tablesorter tbody tr.even:hover td {
	background: lightblue;
}
table.tablesorter tbody tr.odd:hover td {
	background: lightblue;
}

/* filter widget */
table.tablesorter input.tablesorter-filter,
table.tablesorter select.tablesorter-filter {
	width: 95%;
	height: inherit;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}
table.tablesorter tr.tablesorter-filter,
table.tablesorter tr.tablesorter-filter td {
	text-align: center;
	background: #fff;
}
/* optional disabled input styling */ 
table.tablesorter input.tablesorter-filter.disabled,
table.tablesorter select.tablesorter-filter.disabled {
	opacity: 0.5;
	filter: alpha(opacity=50);
}


			#hor-minimalist-b
			{
				font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
				font-size: 12px;
				background: #fff;
				width: 480px;
				border-collapse: collapse;
				text-align: center;
			}
			#hor-minimalist-b th
			{
				font-size: 14px;
				font-weight: 900;
				padding: 10px 8px;
				border-bottom: 2px solid #000;
				text-align: center;
			}
			#hor-minimalist-b td
			{
				border-bottom: 1px solid #ccc;
				padding: 6px 8px;
			}

			#pattern-style-a
			{
				font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
				font-size: 12px;
				width: 100%;
				text-align: left;
				border-collapse: collapse;
				background: url('./public/img/pattern.png');
			}

			#pattern-style-a th
			{
				font-size: 13px;
				font-weight: normal;
				padding: 8px;
				border-bottom: 1px solid #fff;
				color: #039;
			}
			#pattern-style-a td
			{
				padding: 3px; 
				border-bottom: 1px solid #fff;
				color: #000;
				border-top: 1px solid transparent;
			}
			#pattern-style-a tbody tr:hover td
			{
				color: #339;
				background: #fff;
			}
		</style>

<?php 

	$date_current = date('Y-m-d');

	$year = date('Y',strtotime($date_current));

 ?>
<h4><u>GENERAL MEMBER INFORMATION FOR <?php echo $names; ?> FOR THE YEAR <?php echo $year; ?></u></h4>

		<div class="frm_container">
<div class="frm_heading"><span>Member Info</span></div>
<div class="frm_inputs">

	<table class="tablesorter" cellspacing="1" >

		<tr>
			<td><b>Member ID Number:</b></td>
			<td><b><?php echo $id; ?></b></td>
		</tr>

		<tr>
			<td><b>Names:</b></td>
			<td><b><?php echo $names; ?></b></td>
		</tr>
		
		
		<tr>
			<td><b><a href="<?php echo base_url(); ?>savings/show_savings_member/<?php echo $id; ?>/<?php echo $names; ?>">Total Savings:</b></a></td>
			<td><b><?php echo $total_savings->amount_total; ?></b></td>
		</tr>
		<tr>
			<td><b><a href="<?php echo base_url(); ?>balances/info/<?php echo $id; ?>">Total Remittance Balances:</b></a></td>
			<td>
					<b><?php echo $balances ?></b>
				
			</td>
		
		</tr>
		<tr>
			<td><b><a href="<?php echo base_url(); ?>fines/info/<?php echo $id;?>">Total Fines:</b></a></td>
			<td><b><?php echo $fines ?></b>
		</tr>
	</table>
</div>
</div>

<div class="clearFix"></div>
<div class="frm_container">
	<div class="frm_heading"><span><u>Annual Savings</u></span></div>
	<table class="tablesorter" cellspacing="1">
		  <thead>
		    <tr>
		      <th >No</th>
		      <th >Dates</th>
		      <th >Amount Due</th>
		      <th>Amount Paid</th>
		      <th>Balance</th>
		      <th>Fine</th>
		      <th>Status</th>

		    </tr>
		  </thead>
		  <tbody>
		  
		  <?php foreach ($savings as $saving) : ?>
		  	<?php if($ranges == $saving->saving_range): ?>
		    <tr style="background-color: green;">  
		    <td style="width:15%;background-color: green !important;"><b><?php echo $saving->saving_range; ?></b></td>
		    <td style="width:15%;background-color: green !important;"><b><?php echo $saving->range_dates; ?></b></td>
		    <td style="width:15%;background-color: green !important;"><b><?php echo 200000; ?></b></td>
		    <td style="width:15%;background-color: green !important;"><b><?php echo $saving->total_paid; ?></b></td>
		    <td style="width:15%;background-color: green !important;"><b><?php echo $saving->balance; ?></b></td>
		    <?php if($saving->balance != 0): ?>
		    	<td style="width:15%;background-color: green !important;"><b><?php echo 30000; ?></b></td>
		    <?php else: ?>
		    	<td style="width:15%;background-color: green !important;"><b><?php echo 0; ?></b></td>
		    <?php endif; ?>
		    <td style="width:15%;background-color: green !important;"><b><?php echo $saving->status; ?></b></td>
		    </tr>
		    <?php else: ?>
		    <tr>  
		    <td style="width:15%;"><b><?php echo $saving->saving_range; ?></b></td>
		    <td style="width:15%;"><b><?php echo $saving->range_dates; ?></b></td>
		    <td style="width:15%;"><b><?php echo 200000; ?></b></td>
		    <td style="width:15%;"><b><?php echo $saving->total_paid; ?></b></td>
		    <td style="width:15%;"><b><?php echo $saving->balance; ?></b></td>
		    <?php if($saving->balance != 0): ?>
		    	<td style="width:15%;"><b><?php echo 30000; ?></b></td>
		    <?php else: ?>
		    	<td style="width:15%;"><b><?php echo 0; ?></b></td>
		    <?php endif; ?>
		    <td style="width:15%;"><b><?php echo $saving->status; ?></b></td>
		    </tr>
			<?php endif; ?>
		  <?php endforeach; ?>

		  </tbody>
		    
		  </tbody>
</table>
</div>


<div class="clearFix"></div>

<?php if($loans): ?>
<H3 style="text-align:center;"><u>LOANS</u></H3>


	<table class="tablesorter" cellspacing="1">
		  <thead>
		    <tr>
		      <th >No</th>
		      <th >Amount Due </th>
		      <th >Amount Paid </th>
		      <th >Due Date</th>  		      
		    </tr>
		  </thead>
		  <tbody>
		  
		  <?php foreach ($loans as $loan) : ?>
		  	
		    <tr>  
		    <td style="width:25%;"><?php echo $loan->member_id; ?></td>
		    <td style="width:25%;"><?php echo $loan->balance; ?></td>
		    <td style="width:25%;"><?php echo $loan->total_amount; ?></td>
		    <td style="width:25%;"><?php echo $loan->due_date; ?></td>
		    
		    </tr>
		  <?php endforeach; ?>

		  </tbody>
		    
		  </tbody>
</table>
<?php endif; ?>


<div class="clearFix"></div>


<div style="text-align: center;"><strong>********** NOTHING FOLLOWS **********</strong></div>







