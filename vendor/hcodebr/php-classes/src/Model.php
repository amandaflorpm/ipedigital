<?php
//// Criando classe model para os getters e setters, depois vamos utilizá-la em User

namespace Hcode; // Ela está no namespace principal

class Model
{
	private $values = []; // Valores (getter e setter) do objeto, por exemplo, do objeto Usuário

	public function __call($name, $args) // Método call: Ele recebe o nome e os argumentos que vão ser digitados na tela de login
	{
		$method = substr($name, 0, 3) ; // Método para saber se temos um get ou um set: ler as 3 primeiras strings
		$fieldName = substr($name, 3, strlen($name)); // Descobrir qual o nome do campo: da posição 0 até o final

		/* var_dump($method, $fieldName);
		exit;  // Apenas testando o substr*/

		switch ($method)
		{
			case "get":
				return $this->values[$fieldName]; // Se ele encontrar o nome, vai dar um retorno
			break;

			case "set":
				$this->values[$fieldName] = $args[0]; // Se encontrar vai aplicar os valores (args), no exemplo, o args vai retornar o iduser do usuário
			break;

			
		}


	}

	public function setData($data = array())
	{
		foreach ($data as $key => $value) 
		{
			$this->{"set".$key}($value); // *ATENÇÃO* Método: Unir o nome set com a variável key (nome do campo) dinamicamente
			// Aqui ele vai fazer o set automatico de todos os campos que vierem do db
		}
	}

	public function getValues()
	{
		return $this->values; // Por que não acessamos o atributo diretamente? Não é uma boa prática, segurança vem primeiro!
	}
}

?>