<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu {
	
	var $CI;
	
	public function __construct()
	{
		//instantiate CI
		$this->CI =& get_instance();
		$menu_arr = array();
	}
	
	public function generate()
	{
		

		
		$menu_arr[] = array('text' => 'Home', 'controller' => 'home', 'function' => 'index');

		$menu_arr[] = array('text' => 'Savings', 'controller' => 'savings', 'function' => 'show_savings',



			'submenu' => array(
				array(
					'text' => 'Savings', 
					'controller' => 'savings', 
					'function' => 'show_savings'
				),
				array(
					'text' => 'Add Savings', 
					'controller' => 'savings', 
					'function' => 'add_savings'
				)
			)
		);

		$menu_arr[] = array('text' => 'Loans', 'controller' => 'loans', 'function' => 'show_loans',

			'submenu' => array(
				
				
				array('text' => 'Add Loan', 'controller' => 'loans', 'function' => 'add_loan_member',
					'submenu' => array(
						array(
							'text' => 'Member', 
							'controller' => 'loans', 
							'function' => 'add_loan_member'
						),
						array(
							'text' => 'Non Member', 
							'controller' => 'loans', 
							'function' => 'add_loan_non_member'
						)
						
					)
				),
				array(
					'text' => 'Active Loans', 
					'controller' => 'loans', 
					'function' => 'show_loans'
				),
				array(
					'text' => 'All Loans', 
					'controller' => 'loans', 
					'function' => 'show_loans_general'
				)

			)
		);

		//$menu_arr[] = array('text' => 'Add Loan', 'controller' => 'loans', 'function' => 'add_loan_member');

		$menu_arr[] = array('text' => 'Transactions', 'controller' => 'transactions', 'function' => 'index');

		$menu_arr[] = array('text' => 'Payments', 'controller' => 'payments', 'function' => 'index');
				
		$menu_arr[] = array('text' => 'Membership', 'controller' => 'members', 'function' => 'show_members',

			'submenu' => array(
				array(
					'text' => 'Membership List', 
					'controller' => 'members', 
					'function' => 'show_members'
				),
				array(
					'text' => 'Attendance', 
					'controller' => 'members', 
					'function' => 'attendance'
				),
				array(
					'text' => 'Add Member', 
					'controller' => 'members', 
					'function' => 'add_member'
				)
			)

		);
		$menu_arr[] = array('text' => 'Fines', 'controller' => 'fines', 'function' => 'show_fines');

		$menu_arr[] = array('text' => 'Balances', 'controller' => 'balances', 'function' => 'show_balances');

		$menu_arr[] = array('text' => 'Chairman\'s Bag', 'controller' => 'member', 'function' => 'chairman',
			'submenu' => array(
				array(
					'text' => 'Chairman\'s Bag', 
					'controller' => 'members', 
					'function' => 'chairman'
				),
				array(
					'text' => 'Chairman\'s Bag List', 
					'controller' => 'members', 
					'function' => 'chairman_list'
				)
			)

		);

		$menu_arr[] = array('text' => 'Expenses', 'controller' => 'expenses', 'function' => 'show_expenses',


			'submenu' => array(
				array(
					'text' => 'Expenses', 
					'controller' => 'expenses', 
					'function' => 'show_expenses'
				),
				array(
					'text' => 'Expenses List', 
					'controller' => 'expenses', 
					'function' => 'add_expenses'
				)
			)
		);

		$menu_arr[] = array('text' => 'Users', 'controller' => 'users', 'function' => 'show_users',

			'submenu' => array(
				array(
					'text' => 'Users', 
					'controller' => 'users', 
					'function' => 'show_users'
				),
				array(
					'text' => 'Add User', 
					'controller' => 'users', 
					'function' => 'add_user'
				)
			)
		);
		
		

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