<?php

require_once("model/model.php");

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

		$salt = $this->salt();
		$hashed_password = sha1($salt.$password);
		$newpassword = $salt.$hashed_password;

		//echo "s: $salt\nh: $hashed_password\np: $newpassword\n\n";

		$this->data["email"] = $email;
		$this->data["password"] = $newpassword;
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

	/**
	 * Get or generate a salt value
	 *
	 * @param mixed $hashed_password A password from which you want to obtain a salt or false if you want to generate one.
	 * @return string A salt value of $hashed_password or a random salt if $hashed_password is false
	 */
	function salt($hashed_password=false)
	{
		if($hashed_password)
		{
			// return the salt part of this password
			return substr($hashed_password, 0, SITS_SALT_LENGTH);
		}
		else
		{
			// generate a new salt
			return substr(md5(uniqid(rand(), true)), 0, SITS_SALT_LENGTH);
		}
	}

	/**
	 * Check if the passed in password matches the one stored in DB.
	 * Can't be run on an empty model.
	 *
	 * @param string $plaintext_password A password to be matched
	 * @return boolean True if the password matches, false otherwise
	 */
	function check_password($plaintext_password)
	{
		if(!$this->is_empty)
		{
			$hashed_salted_password = $this->data["password"];

			// get the salt
			$salt = $this->salt($hashed_salted_password);


			// pop the salt off
			$hashed_password = substr($hashed_salted_password, SITS_SALT_LENGTH);

			// hash the argument with the salt
			$newpassword = sha1($salt . $plaintext_password);

			//echo "h: $hashed_salted_password\ns: $salt\np: $hashed_password\nn: $newpassword\n\n";

			// compare and return the result
			return ($hashed_password == $newpassword);
		}


	}
}

?>
