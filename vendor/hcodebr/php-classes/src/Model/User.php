<?php

namespace Hcode\Model;

use \Hcode\DB\Sql; // Chamando o DB pois está em outra classe
use \Hcode\Model;

class User extends Model// Extends de Model para não ficar setando sempre o getter e o setter
{
	const SESSION = "User"; //Criando constante sessão


	public static function checkLogin($inadmin = true) // Checando login na sessão
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
		/* # Esse if não deu certo, refazendo-o na function checkLogin #
			if (
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
	

	public static function logout() // Fazendo o logout
	{
		$_SESSION[User::SESSION] = NULL;
	}

	public static function listAll()
	{
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.desperson");
		// Unimos as tabelas users e persons, ordenando pelo nome da pessoa desperson
	}

	public function save() // Método para salvar os dados do new user no db
	{
		$sql = new Sql();

		// #ATENÇÃO# Chamando o PROCEDURE que vai fazer o INSERT, SELECT automaticamente evitando várias linhas de código e request/response para o servidor:
		$results = $sql->select("CALL sp_users_save(:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
			":desperson"=>$this->getdesperson(),
			":deslogin"=>$this->getdeslogin(),
			":despassword"=>$this->getdespassword(),
			":desemail"=>$this->getdesemail(),
			":nrphone"=>$this->getnrphone(),
			":inadmin"=>$this->getinadmin()
			// Todos esses getters foram gerados pelo setdata
		));

		// Só nos interessa a primeira linha desse results, setando no próprio objeto:
		$this->setData($results[0]);
	}

	// Criando método get:
	public function get($iduser)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = :iduser", array(
			":iduser"=>$iduser
		));

		$this->setData($results[0]);
	}

	public function update() // Vai ser bem similar ao save()
	{
		$sql = new Sql();

		$results = $sql->select("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
			":iduser"=>$this->getiduser(),
			":desperson"=>$this->getdesperson(),
			":deslogin"=>$this->getdeslogin(),
			":despassword"=>$this->getdespassword(),
			":desemail"=>$this->getdesemail(),
			":nrphone"=>$this->getnrphone(),
			":inadmin"=>$this->getinadmin()
	
		));

		$this->setData($results[0]);

	}

	public function delete() // Método para deletar o usuário
	{
		$sql = new Sql();

		$sql->query("CALL sp_users_delete(:iduser)", array(
			":iduser"=>$this->getiduser()
		));

	}

}

?>