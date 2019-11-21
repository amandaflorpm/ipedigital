<?php

namespace Hcode\Model;

use \Hcode\DB\Sql; // Chamando o DB pois está em outra classe
use \Hcode\Model;

class User extends Model// Extends de Model para não ficar setando sempre o getter e o setter
{
	const SESSION = "User"; //Criando constante sessão

	/*

public static function getFromSession()
	{
		$user = new User();
		if (isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]['iduser'] > 0) {
			$user->setData($_SESSION[User::SESSION]);
		}
		return $user;
	} */

public static function checkLogin($inadmin = true)
	{
		if (
			!isset($_SESSION[User::SESSION])
			||
			!$_SESSION[User::SESSION]
			||
			!(int)$_SESSION[User::SESSION]["iduser"] > 0
		) {
			//Não está logado
			return false;
		} else {
			if ($inadmin === true && (bool)$_SESSION[User::SESSION]['inadmin'] === true) {
				return true;
			} else if ($inadmin === false) {
				return true;
			} else {
				return false;
			}
		}
	}
	// acaba comment aqui

	public static function login($login, $password)
	{
		$sql = new Sql(); // Acessando o db

		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(":LOGIN"=>$login));

		// Verificando usuário
		if (count($results) === 0)
		{
			throw new \Exception("Usuário inexistente ou senha inválida!", 1);
			
		}

		$data = $results[0];

		// Verificando a senha
		if (password_verify($password, $data["despassword"]) === true)
		{

			$user = new User();

			// *ATENÇÃO* Métodos mágicos get/set na classe Model.php vão ser usados aqui mais o método dinâmico setData (não precisa buscar iduser um a um)
			$user->setData($data); // *ATENÇÃO* Vamos passar o array inteiro, o método vai tirar uma "foto" dos dados e criar um atributo para cada um deles (iduser, deslogin, despassword...) - set automático

			return $user;
			// Para usar um login, precisamos de uma sessão para saber se a pessoa está logada
			// Criando a sessão:

			$_SESSION[User::SESSION] = $user->getValues(); // Inserir esse método na Model tbm

			
		} else
			{
				throw new \Exception("Usuário inexistente ou senha inválida!", 1);
			}


	}

	public static function verifyLogin($inadmin = true)
	{
		/* if (
			!isset($_SESSION[User::SESSION]) // Não existe User nessa Session?
			||
			!$_SESSION[User::SESSION]
			||
			!(int)$_SESSION[User::SESSION]["iduser"] > 0 // Se o iduser dentro dessa sessao nao for maior que 0
			||
			(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin // Se não for admin (1) não pode acessar admnistração
		) {

			header("Location: /admin/login");
			exit;

		} */
		if (!User::checkLogin($inadmin)) {
 
       		if ($inadmin){
            	header("Location: /admin/login");
        	}
        	else {
           		header("Location: /login");
        	}
    	}
 
    }
	

	public static function logout()
	{
		$_SESSION[User::SESSION] = NULL;
	}
}

?>