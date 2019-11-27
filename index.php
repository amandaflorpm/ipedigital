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

$app->get('/admin/logout', function() // Rota logout do admin
{
	User::logout();

	header("Location: /admin/login");
	exit;
});

$app->get("/admin/users", function() // Rota da listagem de todos users
{
	User::verifyLogin(); // Verificando se está logado

	// Rota para chamar a lista de users do db:
	$users = User::listAll(); // Criando médoto listAll no Model/User.php retorna array com a lista de users

	$page = new PageAdmin();

	$page->setTpl("users", array( 	// Buscando template users e chamando o array
		"users"=>$users
	));

});

$app->get("/admin/users/create", function() // Rota do create user (get responde html)
{
	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-create");	// Buscando template users-create

});

$app->get("/admin/users/:iduser/delete", function($iduser) // Rota para deletar um user, só altera o método #ATENÇÃO# não usamos o método delete direto por causa do RainTpl, precisamos chamá-lo
{
	User::verifyLogin();

});

$app->get("/admin/users/:iduser", function($iduser) // Rota do update users - #ATENÇÃO# estamos chamando o usuário que queremos alterar em :iduser
{
	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-update");	// Buscando template users-update

});

$app->post("/admin/users/create", function() // Rota para salvar o user criado (post responde inserção de dados)
{
	User::verifyLogin();

	//// var_dump($_POST); // Conferindo se está recebendo os dados do formulário

	$user = new User(); // Criando o novo usuário

	$user->setData($_POST); // Método setData: cria automaticamente as variáveis no Data Access Object

	var_dump($user);

});

$app->post("/admin/users/:iduser", function($iduser) // Rota para salvar o user que teve update
{
	User::verifyLogin();

});



$app->run();

 ?>