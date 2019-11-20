<?php

namespace Hcode; //namespace specifying where this class is (Hcode)

use Rain\Tpl; //using another namespace (Rain)

class Page
{
	private $tpl; 
	private $options = [];
	private $defaults = [ // Criando os defaults, exemplo: no login nao temos header e footer, serão false
		"header"=>true,
		"footer"=>true,
		"data"=>[] 
	];

	public function __construct($opts = array(), $tpl_dir = "/views/")
	{

		$this->options = array_merge($this->defaults, $opts);
		
		$config = array(
			"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"].$tpl_dir,
			"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
			"debug"         => false
		);

	Tpl::configure( $config );

	$this->tpl = new Tpl;

	$this->setData($this->options["data"]);

	if ($this->options["header"] === true) $this->tpl->draw("header");

	}

	private function setData($data = array())
	{
		foreach ($data as $key => $value)
		{
			$this->tpl->assign($key, $value);
		}
	}

	//// page content
	public function setTpl($name, $data = array(), $returnHTML = false)
	{
		$this->setData($data);

		return $this->tpl->draw($name, $returnHTML);
	}



	public function __destruct()
	{
		if ($this->options["footer"] === true) $this->tpl->draw("footer");

	}
	////first you construct, last you destruct - "magic methods"
}

?>