<?php 

// Vamos iniciar o uso de sessões:
session_start();

require_once("vendor/autoload.php");

// Use de cada classe:

use \Slim\Slim; // Framework
use \Hcode\Page; // Main site page
use \Hcode\PageAdmin; // Admin page
use \Hcode\Model\User;

$app = new Slim();

$app->config('debug', true); // Show me the bug

$app->get('/', function() // Acces by get. Route: Main site
{
    $page = new Page(); // Creating page
	

	$page->setTpl("index");

});

$app->get('/admin', function() // Route: admin
{
	// Precisamos verificar o login na página do Admin, método estático a seguir

	User::verifyLogin();

    $page = new PageAdmin();
	

	$page->setTpl("index");

});

$app->get('/admin/login', function() //Route: admin login
{
	$page = new PageAdmin([ // BUT login page does not have header and footer, we see only the body, so:
		
		"header"=>false,
		"footer"=>false // disable 
	]);

	$page->setTpl("login");

});

$app->post('/admin/login', function() // Rota com post por causa do método post na login.html
{
	// Validando o login (estamos dentro da sessão):
	User::login($_POST["login"], $_POST["password"]); // método estático pois vai ser usado só aqui

	header("Location: /admin");
	exit;

});

$app->get('/admin/logout', function()
{
	User::logout();

	header("Location: /admin/login");
	exit;
});

$app->run();

 ?>