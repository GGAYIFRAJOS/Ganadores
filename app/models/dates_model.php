<?php 


class Dates_model extends CI_Model {



public function calculate_range($user_date){

		$original_date = '2019-01-06';

		
		//$date[0] = date('Y-m-d',strtotime($original_date));

		$ranges = $this->createDateRange("2019-01-06", "2022-01-06");


		$date_range = 0;
	

		
		for($i = 1;$i<61;$i++){

			$date_range = $i;
		
			$start_date = $ranges[--$i];

			$end_date = $ranges[++$i];

			$date_range = $i;

			$start = strtotime($start_date);
			$end =   strtotime($end_date);
			$user =  strtotime($user_date);
			//$date_from_user = '2009-08-28';
			if(($user >= $start) && ($user <= $end)){
				break;
			}

			
		}

		if($date_range > 0)
			return $date_range;
		else
			return FALSE;
}


public function calculate_range_today(){

		$original_date = '2019-06-01';

		$today = date('Y-m-d');

		
		//$date[0] = date('Y-m-d',strtotime($original_date));

		$ranges = $this->createDateRange("2019-01-06", "2022-01-06");

		
		for($i = 1;$i<61;$i++){

			$date_range = $i;
		
			$start_date = $ranges[--$i];

			$end_date = $ranges[++$i];

			$date_range = $i;

			$start = strtotime($start_date);
			$end =   strtotime($end_date);
			$user =  strtotime($today);
			//$date_from_user = '2009-08-28';
			if(($user >= $start) && ($user <= $end)){
				break;
			}

			
		}

		if($date_range > 0)
			return $date_range;
		else
			return FALSE;
}



public function get_member_years($id){

	 
     $this->db->group_by('date');
     $this->db->from('transactions');
     $this->db->where('member_id',$id);
     $date=$this->db->get();
	

	if($date->num_rows > 0){
		return $date->result();
	}
	else
		return FALSE;
}

public function get_member_year(){

	 
     $this->db->group_by('date');
     $this->db->from('transactions');
     $date=$this->db->get();
	

	if($date->num_rows > 0){
		return $date->result();
	}
	else
		return FALSE;
}

public function get_non_member_years($id){

	 
     $this->db->group_by('date');
     $this->db->from('non_member_transactions');
     $this->db->where('non_member_id',$id);
     $date=$this->db->get();
	

	if($date->num_rows > 0){
		return $date->result();
	}
	else
		return FALSE;
}

public function get_non_member_year(){

	 
     $this->db->group_by('date');
     $this->db->from('non_member_transactions');
     $date=$this->db->get();
	

	if($date->num_rows > 0){
		return $date->result();
	}
	else
		return FALSE;
}

public function createDateRange($startDate, $endDate, $format = "Y-m-d"){

		    $begin = new DateTime($startDate);
		    $end = new DateTime($endDate);

		    $interval = new DateInterval('P1M'); // 1 Month
		    $dateRange = new DatePeriod($begin, $interval, $end);

		    $range = [];
		    foreach ($dateRange as $date) {
		        $range[] = $date->format($format);
		    }

		    return $range;
}


 public function get_range_dates($range){

    	$original_date = "2017-06-06";

    	$first_date = strtotime("+$range months",strtotime($original_date));

    	$first_date = date("Y-m-d",$first_date);

    	$prev_range = $range - 1;

    	$second_date = strtotime("+$prev_range months",strtotime($original_date));

    	$second_date = date("Y-m-d",$second_date);

    	$range_dates = "from $second_date to $first_date";

    	if($range_dates)
    		return $range_dates;
    	else
    		return FALSE;
}

 public function get_loan_range_dates($range,$loan_date){

    	$original_date = $loan_date;

    	$first_date = strtotime("+$range months",strtotime($original_date));

    	$first_date = date("Y-m-d",$first_date);

    	$prev_range = $range - 1;

    	$second_date = strtotime("+$prev_range months",strtotime($original_date));

    	$second_date = date("Y-m-d",$second_date);

    	$range_dates = "from $second_date to $first_date";

    	if($range_dates)
    		return $range_dates;
    	else
    		return FALSE;
}


public function get_month_days($number){

	$days = 0;

	switch ($number)
	{
		case 1:
		$days = 31;
		break;
		case 2:
		$days = 28;
		break;
		case 3:
		$days = 31;
		break;
		case 4:
		$days = 30;
		break;
		case 5:
		$days = 31;
		break;
		case 6:
		$days = 30;
		break;
		case 7:
		$days = 31;
		break;
		case 8:
		$days = 31;
		break;
		case 9:
		$days = 30;
		break;
		case 10:
		$days = 31;
		break;
		case 11:
		$days = 30;
		break;
		case 12:
		$days = 31;
		break;
		
	}

	return $days;
}







}


?>