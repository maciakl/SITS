<?php

require_once("model.php");

class UserModel extends Model
{
	function __construct()
	{
		parent::__construct("sits_user");

		$this->data = array("email" => null, "password" => null, "type" => null );
	}

	function create($email, $password, $type)
	{
		// TODO - validate email
		// TODO - validate type

		// TODO - hash password

		$this->data["email"] = $email;
		$this->data["password"] = $password;
		$this->data["type"] = $type;

		$this->is_empty = false;

		parent::create();
	}

	function read($id)
	{
		parent::read("email", $id);
	}

	function update()
	{
		parent::update("email");
	}

	function delete()
	{
		parent::delete("email");
	}
}

?>
