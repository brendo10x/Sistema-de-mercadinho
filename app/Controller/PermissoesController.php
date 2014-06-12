<?php

/**
 *	Controle
 */

class PermissoesController extends AppController {


	// modelos adicionais disponíveis para este Controller
    var $uses = array('Permissao','Usuario');

    //esta ação ocorre antes da ação das actions deste Controller
    public function beforeFilter(){

        //executa ação herdada do AppController
        parent::beforeFilter();   

    }//fim beforeFilter()
	

    /**  
    * Função usada pelo cake, autoriza o controler 
    * @return boolean ou um redirect
    */
    function isAuthorized() {

        //tipo de usuário ativo na sessão
       $tipoDeUsuario = $this->Session->read('Auth.User.Usuario.tipo');

        //tipo (0 - proprietário) (1 - vendedor)

        //se ele é proprietário, liberado 
        if ($tipoDeUsuario == 0 ) {

            //fluxo normal
            return true;
     
        }else{

            // página de acesso restrito
            return $this->redirect('/usuarios/acesso_restrito'); 

      }//fim if
        
    }//fim isAuthorized()


    /**  
    * Processo de atualizar permissões
    */
    public function permitir(){

        //se  a requisição for post
    	if ($this->request->is('post')) {

            //processo de atualização
    		$this-> Permissao ->atualiza_permissoes($this->data);

            //disponível na view
            $this->set('sucesso',__('Permissões atualizadas'));

            //atualiza login com as informações atualizadas
            $this->Auth->login($this-> Usuario ->atualizaLogin($this->Auth->user()));

        }//fim if

        //disponível na view
        $this->set('permissao',$this-> Permissao ->find('all'));

        //disponível na view
        $this ->set('titulo',__('Permissões de usuário'));

    }//fim permitir()


    

}//fim class PermissoesController
?>