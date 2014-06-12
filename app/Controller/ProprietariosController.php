<?php

/**
 *	Controle
 */

class ProprietariosController extends AppController {

    // modelos adicionais disponíveis para este Controller
    var $uses = array('Usuario','Proprietario');

    //esta ação ocorre antes da ação das actions deste Controller
	public function beforeFilter(){

        //executa ação herdada do AppController
        parent::beforeFilter();   

    }//fim beforeFilter()


    /**  
    * Deleta a sessões que existir logo depois da ação dos controllers 
    * Session sucesso - armazena valor da msg de sucesso quando necessário para a view
    */
    public function afterFilter() {

        //se existe sessão com o nome sucesso
        if ($this -> Session -> check('sucesso')) {

            //destroi sessão com o nome sucesso
            $this -> Session -> delete('sucesso');

        }//fim if

    }//fim afterFilter()
    
    /**  
    * Função usada pelo cake, autoriza o controler
    *  @return boolean ou um redirect
    */
    public function isAuthorized() {

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
    *  Ação de rederizar a página editar com informações
    *  @param integer do GET $this->params['pass'][0] id do proprietário
    *  @return void
    *
    * Se requisição POST
    *  Ação de atualizar
    *  @param array do POST $this -> data informações de proprietário, usuário e pessoa
    *  @return void
    */
    public function editar(){

        //se a requisição é post
        if ($this->request->is('post')) {

            // recebe todos os dados enviados
            $dados = $this -> data;

            //processo da atualizar
            $this-> Proprietario -> atualizar_proprietario($dados);

            //atualiza login com as informações atualizadas anteriormente
            $this->Auth->login($this->Usuario->atualizaLogin($dados));

            //disponível na view
            $this -> Session -> write('sucesso', __('Proprietário atualizado'));

            //redirecionamento
            $this -> redirect(array('controller' => 'proprietarios', 'action' => 'editar',$dados['Proprietario']['id']));
        
        }//fim if

        //recupero info. do proprietário pelo id
        $proprietario = $this-> Proprietario->findAllById($this->params['pass'][0]);

        //disponível na view
        $this->set('proprietario', $proprietario[0]);
        
        //menu
        //título da página
        $this -> set('titulo', __('Atualizar proprietário'));
        
    }//fim editar()

     /**  
    * Ação de vizualizar registro
    * @param integer do GET $this->request->query['term'] id do proprietário
    * @return void
    */
    public function visualizar()  {
        
        //recupero o valor do id 
        $idProprietario =  $this->request->query['term'];

        //recupero info. do vendedor com id
        $proprietario = $this -> Proprietario -> findAllById($idProprietario);

        //disponível na view
        $this-> set('proprietario', $proprietario[0]);

         //define título da janela modal
        $this-> set('tituloJanelaModal', __('Proprietário'));
        
        //define layout da página ou seja vazía
        $this->layout = "ajax";

    }//fim visualizar()

}//fim class ProprietariosController
?>