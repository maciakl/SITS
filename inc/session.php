<?php

require_once("config.php");

define("SITS_ACCESS_LEVEL_ADMIN", 	1); // less than 1 admin(0) 
define("SITS_ACCESS_LEVEL_STANDARD",	2); // less than 2 admin(0), standard(1)
define("SITS_ACCESS_LEVEL_USER",	3); // less than 3 admin(0), standard(1), user(2)

if(SITS_PUBLIC_MODE)
	define("SITS_ACCESS_LEVEL_ALL", 100); // less than 100 admin(0), standard(1), user(2), read_only(3), logged_out(99)
else
	define("SITS_ACCESS_LEVEL_ALL", 4); // less than 4 admin(0), standard(1), user(2), read_only(3)

define("SITS_LOGGED_OUT", 99);

session_start();

class Session
{
	/**
	 * Access Level of the current page. Available access levels are:
	 *
	 *
	 */
	var $ACCESS_LEVEL;

	function __construct($access_level=null)
	{
		$this->ACCESS_LEVEL = $access_level==null ? SITS_ACCESS_LEVEL_ALL : $access_level;


		if(!$this->can_access())
			die("
				<h3>Not Permitted</h3>
				<p>You don't have permission to view this page.
				<meta http-equiv='refresh' content='3;url=login.php'>
			");
	}

	function login($email, $type)
	{
		$_SESSION["email"] = $email;
		$_SESSION["type"] = $type;
	}

	function is_logged_in()
	{
		return !(empty($_SESSION["email"]) or empty($_SESSION["type"]));
	}

	function logout()
	{
		//session_write_close();
		session_unset();
		session_destroy();
	}

	function can_access()
	{
		if($this->is_logged_in())
			$user_type_number = $this->type_to_number($_SESSION["type"]);		
		else
			$user_type_number = SITS_LOGGED_OUT;

		//echo "u: $user_type_number\ns: $this->ACCESS_LEVEL";
		
		if($user_type_number < $this->ACCESS_LEVEL)
			return true;
		else
			return false;
	}

	function type_to_number($type)
	{
		switch($type)
		{
			case "admin":
				return 0;
				break;
			case "standard":
				return 1;
				break;
			case "user":
				return 2;
				break;
			case "read-only":
				return 3;
				break;
			default:
				return 99;
		}
	}


}
?>
