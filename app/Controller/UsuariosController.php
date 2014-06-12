<?php

/**
 * Controle
 */
class UsuariosController extends AppController {


	//esta ação ocorre antes da ação das actions deste Controller
	public function beforeFilter(){

		//executa ação herdada do AppController
		parent::beforeFilter();  

		// liberando acesso para os não logados
		$this->Auth->allow('login','logout');   

	}//fim beforeFilter()


	/**  
    * Deleta a sessões que existir logo depois da ação dos controllers
    * Session erro - armazena valor da msg de erro quando necessário para a view
    * Session sucesso - armazena valor da msg de sucesso quando necessário para a view
    */
    public function afterFilter() {

         //se existe sessão com o nome erro
        if ($this -> Session -> check('erro')) {

             //destroi sessão com o nome erro
            $this -> Session -> delete('erro');

        }//fim if

         //se existe sessão com o nome sucesso
        if ($this -> Session -> check('sucesso')) {

            //destroi sessão com o nome sucesso
            $this -> Session -> delete('sucesso');

        }//fim if

    }// fim afterFilter()


	/**  
	* Requisição POST
	* Ação de logar usuário se válido
	* @param array do POST $this->data informações de email e senha
	* @return void
	*/
	function login() {
	 	
	 	//se a requsisão é POST	
        if ($this->request->is('post')) {

        	//validação e atribuição
        	$usuario = $this->Usuario->validaLogin($this->data);

        	 //verifica se existe usuário
        	if (!empty($usuario)) {

        		// usuário existe
        		
        		//faz login de usuário credenciado com todas as informações
        		$this->Auth->login($usuario);

        		//redireciona para página principal
        		return $this->redirect($this->Auth->redirect());

        	}else{

        		// usuário não existe 

        		//escrevendo msg de erro na sessão
        		 $this -> Session -> write('erro', $this->Auth->loginError);

        	}// fim if

        }// fim if
       
        //define layout
        $this->layout = "ajax";

        //título da view
	 	$this->set('titulo', __('Entrar como usuário'));

	 }// fim login()


	 /**  
	 * Ação de deslogar
	 * @return void
	 */
	function logout() {

	 	//escreve msg de sucesso na sessão
	 	$this->Session->write('sucesso',__('Saiu do sistema'));

	 	//efetua o logout e redirecionamento
	 	$this->redirect($this->Auth->logout());

	}//fim logout()


	/**  
	* valida se existe email 
	* @param string do POST $this->data email
	* @return boolean de sucesso
	*/
	public function verificaEmail() {

		//FALSE não permite rederizar o nome do método em uma página .ctp
		//pois somente queremos que retorne o conteúdo
		$this->autoRender = false;

		//define layout
		$this->layout = "ajax";

		//validação
		return $this -> Usuario -> isUnique($this->data);
		
	}//fim verificaEmail()


	/**  
	* valida se existe email no atualizar, vai consulta todos 
	* menos o id que está atualizando
	* @param string do POST $this->data email
	* @return boolean de sucesso
	*/
	public function verificaEmailEditar() {

		//FALSE não permite rederizar o nome do método em uma página .ctp
		//pois somente queremos que retorne o conteúdo
		$this->autoRender = false;

		//define layout
		$this->layout = "ajax";

		//validação
		return $this -> Usuario -> validaSeEmail_editar($this->data) ;
		
	}//fim verificaEmailEditar()


	/**  
	* Página de acesso restrito para logados 
	* @return void
	*/
	public function acesso_restrito(){
		
		//define título
		$this->set('titulo', __('Acesso restrito'));

	}//fim acesso_restrito()

}//fim class UsuariosController

?>