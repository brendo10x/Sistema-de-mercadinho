<?php

/**
 *	Controle
 */
App::uses('Venda', 'Model');
class FinanceirosController extends AppController {



	//esta ação ocorre antes da ação das actions deste Controller
    public function beforeFilter(){

        //executa ação herdada do AppController
        parent::beforeFilter();   

    }//fim beforeFilter()

     /**  
    * Deleta a sessões que existir logo depois da ação dos controllers
    * Session erro - armazena valor da msg de erro quando necessário para a view
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

        //recupero permissões
        $permissao = $this->Session->read('Auth.User.Permissoes');

        //recupero tipo de usuário ativo na sessão
        $tipoDeUsuario = $this->Session->read('Auth.User.Usuario.tipo');

        //permitido (0 - sim) (1 = não)
        //tipo (0 - proprietário) (1 - Venda)

        if ($tipoDeUsuario == 0 || $permissao['FinanceirosController']['permitido'] == 0) {
            
            //fluxo normal
            return true;

        }else{

            // página de acesso restrito
            return $this->redirect('/usuarios/acesso_restrito');

        }//fim if
        
    }//fim isAuthorized()
 
    
    /**  
    * Página principal deste controller
    *  Descrição - operações de consulta e de
    *  operação de inserção e atualização
    */
    public function index(){

    	 if ($this->request->is('post') && empty($this->data['data'])) {

    		 $this->Financeiro->atualizar_total($this->data);

    		  //escrevendo msg de sucesso na sessão 
             $this -> Session -> write('sucesso', __("Operação realizada"));
    	}

   		//se existe valor 
        if (!empty($this->data['data'])) {

            //redirecionamento
            $this->redirect(array('controller' => 'financeiros', 'action' => 'index/'.$this->data['data']));

        }//fim if

          // info do post - buscar - info da url
        if(!empty($this->params['pass'][0]) ){

            //recupera parâmetro com o valor da data
        	$data = $this->params['pass'][0];

        	$Venda = new Venda;
            //recupera valor total todas das vendas pesquisadas de acordo com a data
        	$totalVendas = $Venda->find('all',array('fields' => array('SUM(Venda.ven_total) AS totalVendas'),'conditions'=>array('Venda.data like'=>'%'. $data .'%')));
        	
            //atribui a variável
        	$totalVendas = $totalVendas[0][0]['totalVendas'];

            //disponível na view - o valor total pesquisado das vendas
        	$this->set('totalVendasPesquisado',$totalVendas);

        	$this->set('data',$data);

        }//fim if 

        //recupera financeiro
    	$financeiro = $this->Financeiro->find('first');

		//disponível na view - o valor do financeiro
		$this->set('financeiro',$financeiro);

    	 //menu
        //título da página
        $this -> set('titulo', __('Financeiro'));

        //aqui vai ativar o menu  
        $this -> set('financia_menu', 'active');

    }//fim index()

}//fim class FinanciasController
?>