<?php

namespace Hcode;

class PageAdmin extends Page // extends: Class Pageadmin "inherits" everything from Class Page
{

	public function __construct($opts = array(), $tpl_dir = "/views/admin/")
	{
		parent::__construct($opts, $tpl_dir); //parent Class construct
	}

}

?>