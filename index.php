<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;
use Hcode\Page;
use Hcode\PageAdmin;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() // / main site
{
    $page = new Page();
	

	$page->setTpl("index");

});

$app->get('/admin', function() // /admin = admin you can change to increase security
{
    $page = new PageAdmin();
	

	$page->setTpl("index");

});


$app->run();

 ?>