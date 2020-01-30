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
	border: lightblue 1px solid;
}

table.tablesorter th {
	background-color: blue;
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


<!-- <h2  style="text-align: center;"><u>MEMBER LOAN INFORMATION FOR <?php echo urldecode($names); ?></u></h2>

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
			<td><b><?php echo urldecode($names); ?></b></td>
		</tr>
		<tr>
			<td><b>Loan Date:</b></td>
			<td><b><?php echo $loan_date; ?></b></td>
		</tr>
		<tr>
			<td><b>Principal:</b></td>
			<td><b><?php echo $loan_amount; ?></b></td>
		</tr>
		<tr>
			<td><b>Interest:</b></td>
			<td><b><?php echo $loan_interest; ?>%</b></td>
		</tr>
		
	</table>
</div>
</div>

<div class="clearFix"></div>
<div class="frm_container">
	<div class="frm_heading"><span><u>Loan_report</u></span></div>
	<table class="tablesorter" cellspacing="1" >
		  <thead>
		    <tr>
		    <th>N<u>o</u></th>
		      <th>Payment Date</th>
		      <th>Payment Amount</th>
		      <th>Balance</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php $i = 0; ?>
		  <?php foreach ($payment as $pay) : ?>
		  	
		    
		    <tr>
		    <td ><b><?php echo ++$i; ?></b></td>
		    <td ><b><?php echo $pay->payment_date; ?></b></td>
		    <td ><b><?php echo $pay->payment_amount; ?></b></td>
		    <td ><b><?php echo $pay->balance; ?></b></td>
		    </tr>
    	

		  </tbody>
		    
		  </tbody>
</table>
</div>


<div style="text-align: center;"><strong>********** NOTHING FOLLOWS **********</strong></div>
 -->


<h2  style="text-align: center;"><u>LOAN INFORMATION FOR <?php echo urldecode($names); ?></u></h2>

		<div class="frm_container">
<div class="frm_heading"><span>Info</span></div>
<div class="frm_inputs">

	<table class="tablesorter" cellspacing="1" >

		<tr>
			<td><b>ID Number:</b></td>
			<td><b><?php echo $id; ?></b></td>
		</tr>

		<tr>
			<td><b>Names:</b></td>
			<td><b><?php echo urldecode($names); ?></b></td>
		</tr>
		<tr>
			<td><b>Loan Date:</b></td>
			<td><b><?php echo $loan_date; ?></b></td>
		</tr>
		<tr>
			<td><b>Principal:</b></td>
			<td><b><?php echo $loan_amount; ?></b></td>
		</tr>
		<tr>
			<td><b>Interest:</b></td>
			<td><b><?php echo $loan_interest; ?>%</b></td>
		</tr>
		
	</table>
</div>
</div>

<div class="clearFix"></div>
<div class="frm_container">
	<div class="frm_heading"><span><u>Loan_report</u></span></div>
	<table class="tablesorter" cellspacing="1" >
		  <thead>
		    <tr>
		      <th>Period N<u>o</u></th>
		      <th>Period</th>
		      <th>Transaction N<u>o</u></th>
		      <th>Type</th>
		      <th>Amount Carried Forward</th>
		      <th>Interest</th>
		      <th>Fine</th>

		      <th>Amount_paid</th>
		      <th>Total Amount Paid</th>
		      <th>Balance</th>

		    </tr>
		  </thead>
		  <tbody>
		  <?php $i = 0; $range_dates = 0; $trans = 0; ?>
		  <?php foreach ($progress as $saving) : ?>
		  	
		    <?php if($range_dates != $saving->loan_range_dates ): ?>
		    	<?php if($saving->fine == 0): ?>

				    <tr>
				    <td ><b><?php echo ++$i; ?></b></td>
				    <td ><b><?php echo $saving->loan_range_dates; ?></b></td>
				    <td ><b><?php echo ++$trans; ?></b></td>
				    <td ><b><?php echo 'loan payment'; ?></b></td>
				    <td ><b><?php echo $saving->prev_amount; ?></b></td>
				    <td ><b><?php echo $saving->interest; ?></b></td>
				    <td ><b><?php echo $saving->fine; ?></b></td>
				    <td ><b><?php echo $saving->amount_paid; ?></b></td>
				    <td ><b><?php echo $saving->total_amount; ?></b></td>
				    <td ><b><?php echo $saving->balance; ?></b></td>
				    </tr>
		    	<?php else: ?>
		    		<tr>
				    <td ><b><?php echo ++$i; ?></b></td>
				    <td ><b><?php echo $saving->loan_range_dates; ?></b></td>
				    <td ><b><?php echo ++$trans; ?></b></td>
				    <td ><b><?php echo 'loan fine'; ?></b></td>
				    <td ><b><?php echo $saving->prev_amount; ?></b></td>
				    <td ><b><?php echo $saving->fine; ?></b></td>
				    <td ><b><?php echo $saving->amount_paid; ?></b></td>
				    <td ><b><?php echo $saving->total_amount; ?></b></td>
				    <td ><b><?php echo $saving->balance; ?></b></td>
				    </tr>
		    	<?php endif; ?>
		    <?php else: ?>
		    	<?php if($saving->fine == 0): ?>
				    <tr>
				   	<td ></td>
				    <td ></td>
				    <td ><b><?php echo ++$trans; ?></b></td>
				    <td ><b><?php echo 'loan payment'; ?></b></td>
				    <td ><b><?php echo $saving->prev_amount; ?></b></td>
				    <td ><b><?php echo $saving->fine; ?></b></td>
				    <td ><b><?php echo $saving->amount_paid; ?></b></td>
				    <td ><b><?php echo $saving->total_amount; ?></b></td>
				    <td ><b><?php echo $saving->balance; ?></b></td>
				    </tr>
		    	<?php else: ?>
		    	 	<tr>
				   	<td ></td>
				    <td ></td>
				    <td ><b><?php echo ++$trans; ?></b></td>
				    <td ><b><?php echo 'loan fine'; ?></b></td>
				    <td ><b><?php echo $saving->prev_amount; ?></b></td>
				    <td ><b><?php echo $saving->fine; ?></b></td>
				    <td ><b><?php echo $saving->amount_paid; ?></b></td>
				    <td ><b><?php echo $saving->total_amount; ?></b></td>
				    <td ><b><?php echo $saving->balance; ?></b></td>
				    </tr>
				<?php  endif; ?>
			<?php endif; ?>
			
			<?php $range_dates = $saving->loan_range_dates; ?>

		  <?php endforeach; ?>

		  </tbody>
		    
		  </tbody>
</table>
</div>


<div style="text-align: center;"><strong>********** NOTHING FOLLOWS **********</strong></div>