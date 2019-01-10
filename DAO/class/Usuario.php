<?php  
	
	class Usuario{
		private $idusuario;
		private $deslogin;
		private $desenha;
		private $dtcadastro;

		public function getIdusuario(){
			return $this->idusuario;
		}
		public function setIdusuario($value){
			$this->idusuario = $value;
		}

		public function getDeslogin(){
			return $this->deslogin;
		}
		public function setDeslogin($value){
			$this->deslogin = $value;
		}

		public function getDesenha(){
			return $this->desenha;
		}
		public function setDesenha($value){
			$this->desenha = $value;
		}

		public function getDtcadastro(){
			return $this->dtcadastro;
		}
		public function setDtcadastro($value){
			$this->dtcadastro = $value;
		}

		//método construtor com passagem de parâmetro login e senha
		//nos parâmetros $loing="" garante a passagem ou não de parâmetros
		public function __construct($login = "", $password = ""){
			$this->deslogin = $login;
			$this->desenha = $password;
		}

		//lista um usuário por id
		public function loadById($id){

			$sql = new Sql();
			$result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$id));

			if(count($result) > 0){
				$this->setData($result[0]);
			}
		}

		//listar todos os usuários da tabela
		//método static por não utilizar o $this, não é preciso estanciar o objeto no index
		public static function getList(){
			
			$sql = new Sql();
			return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");

		}

		//realiza a busca por um parâmetro, neste caso por login
		public static function search($login){
			
			$sql = new Sql();
			return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
				':SEARCH'=>"%".$login."%"
			));
		}

		//buscar os dados do usuário autenticado, ou seja, validar o login e senha
		public function login($login, $password){

			$sql = new Sql();
			
			$result = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND desenha = :SENHA", array(
				":LOGIN"=>$login,
				":SENHA"=>$password
			));

			if(count($result) > 0){				
				
				$this->setData($result[0]);
			}
			else{
				throw new Exception("Erro de login ou senha");
				
			}

		}

		public function insert(){
			
			$sql = new Sql();
			$result = $sql->select("INSERT INTO tb_usuarios(deslogin, desenha) VALUES (:LOGIN, :SENHA);",array(
				':LOGIN'=>$this->getDeslogin(),
				':SENHA'=>$this->getDesenha()
			));

			$resposta = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = LAST_INSERT_ID()");
			if(count($resposta)>0){
				$this->setData($resposta[0]);
			}

		}

		public function setData($data){
			$this->setIdusuario($data['idusuario']);
			$this->setDeslogin($data['deslogin']);
			$this->setDesenha($data['desenha']);
			$this->setDtcadastro(new DateTime($data['dtcadastro']));
		}

		public function update($login, $senha){
			$this->setDeslogin($login);
			$this->setDesenha($senha);
			$sql = new Sql();

			$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, desenha = :SENHA WHERE idusuario = :ID", array(
					':LOGIN'=>$this->getDeslogin(),
					':SENHA'=>$this->getDesenha(),
					':ID'=>$this->getIdusuario()
			));
		}

		public function delete(){
			$sql = new Sql();

			$sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
				':ID'=>$this->getIdusuario()
			));

			$this->setIdusuario(0);
			$this->setDeslogin("");
			$this->setDesenha("");
			$this->setDtcadastro(new DateTime());
		}
		
		public function __toString(){
			return json_encode(array(
				"idusuario"=>$this->getIdusuario(),	
				"deslogin"=>$this->getDeslogin(),
				"desenha"=>$this->getDesenha(),
				"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
			));
		}

		
	}
?>