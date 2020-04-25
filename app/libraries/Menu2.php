<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu2{
	
	var $CI;
	
	public function __construct()
	{
		//instantiate CI
		$this->CI =& get_instance();
		$menu_arr = array();
	}
	
	public function generate()
	{
		

		$menu_arr[] = array('text' => 'Savings', 'controller' => 'members', 'function' => 'get_member_info2');

		$menu_arr[] = array('text' => 'Loans', 'controller' => 'loans', 'function' => 'get_member_loan_info2');


		//$menu_arr[] = array('text' => 'Add Loan', 'controller' => 'loans', 'function' => 'add_loan_member');

		$menu_arr[] = array('text' => 'Transactions', 'controller' => 'transactions', 'function' => 'view_transactions_member');
				
		$menu_arr[] = array('text' => 'Attendance', 'controller' => 'members', 'function' => 'attendance_list2');

		$menu_arr[] = array('text' => 'Fines', 'controller' => 'fines', 'function' => 'show_fines_member');

		$menu_arr[] = array('text' => 'Balances', 'controller' => 'balances', 'function' => 'show_balances_member');

		$menu_arr[] = array('text' => 'Chairman\'s Bag', 'controller' => 'members', 'function' => 'chairman_list_member');


		$menu_arr[] = array('text' => 'Change Password', 'controller' => 'users', 'function' => 'change_password');

		$menu_arr[] = array('text' => 'Logout', 'controller' => 'users', 'function' => 'logout');
		
		//print_r($menu_arr);
		
		echo "<div id='cssmenu'>";
		
		$level = 0;
		$this->print_link($menu_arr, $level);
		
		echo "</div>";
		
	}

	function print_link($complex_array, &$level)
	{
		$base_url = base_url();
		echo "<ul class='nav nav-tabs nav-justified'>";
	    foreach ($complex_array as $n)
	    {
	    	$has_sub = (array_key_exists('submenu', $n) AND is_array($n['submenu'])) ? TRUE:FALSE;
			
			$class = $has_sub?"class='has-sub'":"";
			
	    	echo "<li $class><a href='{$base_url}{$n['controller']}/{$n['function']}'>{$n['text']}</a>";
			//str_repeat('-',$level).$n['text'].'-'.$n['controller'].'-'.$n['function'].'<br />';
			if($has_sub) {
				$level++;
	            $this->print_link($n['submenu'],$level);
				$level--;
			}
			echo  "</li>";
	    }
		echo "</ul>";
	}
	
}