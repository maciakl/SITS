<?php

require_once("model.php");

class TagModel extends Model
{
	function __construct()
	{
		parent::__construct("sits_tag");

		$this->data = array("tagname" => null, "style" => null );
	}

	function create($tagname, $style)
	{
		// TODO - validate tagname
		// TODO - validate style


		$this->data["tagname"] = $tagname;
		$this->data["style"] = $style;


		$this->is_empty = false;

		parent::create();
	}

	function read($id)
	{
		parent::read("tagname", $id);
	}

	function update()
	{
		parent::update("tagname");
	}

	function delete()
	{
		parent::delete("tagname");
	}
}

?>

