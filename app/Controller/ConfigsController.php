<?php

/**
 *	Controle
 */

class ConfigsController extends AppController {


    // modelos adicionais disponíveis para este Controller
    var $uses = array('Usuario','Config');


	//esta ação ocorre antes da ação das actions deste Controller
    public function beforeFilter(){

        //executa ação herdada do AppController
        parent::beforeFilter();   

    }//fim beforeFilter()


    /** 
    * Session sucesso - armazena valor da msg de sucesso quando necessário para a view
    */
    function afterFilter() {

        //se existe sessão com o nome sucesso
        if ($this -> Session -> check('sucesso')) {

            //destroi sessão com o nome sucesso
            $this -> Session -> delete('sucesso');

        }//fim if

    }//fim afterFilter()


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
    * Se requisição GET
    *  Ação de rederizar a página configuracao com informações
    *  @return void
    *
    * Se requisição POST
    *  Ação de configurar
    *  @param array do POST $this -> data informações sobre as configurações
    *  @return void
    */
	public function configuracao(){

        //se a requisição é post
        if ($this->request->is('post')) {

            //recupera valores
            $dados = $this->data;

            //salva configurações
            $this-> Config ->salva_configuracoes($dados);

            //disponível na view
            $this -> Session -> write('sucesso', __('Configuração atualizada'));

            //atualiza login com as informações atualizadas anteriormente
            $this->Auth->login($this->Usuario->atualizaLogin($this->Auth->user()));
            
             //redirecionamento e atualização rápida
            $this->redirect(array('action' => 'configuracao'));

        }//fim if

        //define informação de todas as configurações
        $this->set('configuracao',$this-> Config ->find('first'));

        //define título da página
        $this ->set('titulo',__('Configuração do sistema'));
        
       

	}//fim configuracao()

 
}// fim class ConfigsController
?>