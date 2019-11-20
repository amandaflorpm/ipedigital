<?php

namespace Hcode\Model;

use \Hcode\DB\Sql; // Chamando o DB pois está em outra classe
use \Hcode\Model;

class User extends Model // Extends de Model para não ficar setando sempre o getter e o setter
{
	public static function($login, $password)
	{
		$sql = new Sql(); // Acessando o db

		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
			":LOGIN"=>$login
		));

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

			// Métodos mágicos

		} else
			{
				throw new \Exception("Usuário inexistente ou senha inválida!", 1);

			}


	}

}

?>