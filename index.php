<?php 
	require_once("config.php");
	
	/*$sql = new Sql();
	$usuarios = $sql->select("SELECT * FROM tb_usuarios");
	echo json_encode($usuarios);*/
	
	/* retorna um usuario pelo id passado como parâmetro
	$user = new Usuario();
	$user->loadById(3);	
	echo $user;*/

	/*//como o método getList é static não é necessário criar um obejto da classe para 
	//acessar o método
	$lista = Usuario::getList();
	echo json_encode($lista);*/

	/*//busca uma lista de usuários passado por parâmetro 
	$search = Usuario::search("jo");
	echo json_encode($search);*/

	/*//carrega um usuario utilizando o login e senha
	$login = new Usuario();
	$login->login("admin","123456");
	echo $login;*/

	//criando um novo usuario
	/*$novoUsuario = new Usuario("antonio", "3222");
	$novoUsuario->insert();
	echo $novoUsuario;*/

/*Alterar um usuário
	$usuario = new Usuario();
	$usuario->loadById(9);

	$usuario->update("professor2", "prof123222");
	echo($usuario);
	*/
	$usuario = new Usuario();
	$usuario->loadById(13);
	$usuario->delete();
	echo($usuario);
 ?>