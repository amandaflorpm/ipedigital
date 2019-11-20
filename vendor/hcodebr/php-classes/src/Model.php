<?php

namespace Hcode;

class Model
{
	private $values = [];

	public function __call($name, $args)
	{
		$method = substr($name, 0, 3) ;
	}
}

?>