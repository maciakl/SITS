<?php

define("SITS_ACCESS_LEVEL_ADMIN", 	0);
define("SITS_ACCESS_LEVEL_STANDARD",	1);
define("SITS_ACCESS_LEVEL_USER",	2);
define("SITS_ACCESS_LEVEL_ALL", 	99);

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
			die("Forbidden");

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
			$user_type_number = 999;

		if($user_type > $this->ACCESS_LEVEL)
			return false;
		else
			return true;
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
				return 99;
				break;
			default:
				return 999;
		}
	}


}
?>
