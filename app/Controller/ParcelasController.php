<?php

/**
 *	Controle
 */

class ParcelasController extends AppController {

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
        //tipo (0 - proprietário) (1 - Parcela)

        if ($tipoDeUsuario == 0 || $permissao['VendasController']['permitido'] == 0) {
            
            //fluxo normal
            return true;

        }else{

            // página de acesso restrito
            return $this->redirect('/usuarios/acesso_restrito');

        }//fim if
        
    }//fim isAuthorized()
 	

 	/**  
    * Função de configuração de paginação
    *  utilizada na action excluir e listar
    *  @return void
    */
    public function configuraPaginacao(){
      
        //CONFIGURAÇÃO DE PAGINAÇÃO

        // recupera usuário ativo na sessão
        $usuario = $this->Session->read('Auth.User');

        // registros por página
        //utilizada aqui pelo PaginatorComponent
        $options['limit'] = $usuario['Config']['registros_por_pagina'];

        //define configurações
        $this ->paginate =  $options;
        
        //Paginação - Numero de diferença entre os botões
        //utilizada na view PaginatorHelper
        $this->set('modulus',$usuario['Config']['diferenca_entre_botoes_pag']);

    }//fim configuraPaginacao()

	 /**  
    * Requisição GET
    *  listagem normal sem busca
    *  @return void
    *
    * Requisição POST
    *  listagem com busca
    *  se $this->data['buscar'] estiver preenchido a página será redirecionada
    *  com a pesquisa na url, assim o usuário poderá navegar entre os registros 
    *  atravéz da requisição GET 
    * Se requisição POST
    *  @param string do POST $this->data['buscar'] pesquisa 
    *  @return void
    * Se requisição GET
    *  @param string do GET $this->params['pass'][1] pesquisa 
    *  @return void
    */
    public function listar() {

         //se existe valor 
        if (!empty($this->data['buscar'])) {

            //redirecionamento
            $this->redirect(array('controller' => 'parcelas', 'action' => 'listar/'.$this->data['idVenda'].'/buscar', $this->data['buscar']));
        
        }//fim if

        //configuração de paginação
        $this->configuraPaginacao();
        
        //recupera parâmetro com o valor do id da venda
        $idVenda = $this->params['pass'][0];
        
      
        if(!empty($this->params['pass'][2])){
            
            //recupera parâmetro com o valor da busca - data
            $busca = $this->params['pass'][2];
            $this->set('busca',$busca);

            // Roda a consulta, já trazendo os resultados paginados
            $parcelas = $this -> paginate('Parcela',array('Parcela.venda_id ' =>$idVenda,'Parcela.data like '=>'%'.$busca.'%'));   

        }else{

            $parcelas = $this -> paginate('Parcela',array('Parcela.venda_id ' =>$idVenda));  

        }//fim if

        // //disponível na view
        $this->set('parcela', $parcelas);

        //total de registros tanto de busca quanto de listagem normal
        $this->set('totalRegistros',count($parcelas));

        //menu
        //título da página
        $this -> set('titulo', __('Parcelas desta venda'));

         //menu
        //breadcrumb
        $this -> set('breadcrumb_titulo', __('Listar vendas'));

        //aqui vai ativar o menu - extender
        $this -> set('venda_menu', 'active');

        //aqui vai ativar o sub menu - extender
        $this -> set('venda_listar_sub_menu', 'active');
         

    }//fim listar()


    /**  
    * Processo de pagar parcela
    * @param do GET $this->params['pass'][0] // id da parcela
    * @return void
    */
    public function pagar(){

    	 //processo de excluir
        $this-> Parcela ->pagar_parcela($this->params['pass'][0]);

        //escrevendo msg de sucesso na sessão
        $this -> Session -> write('sucesso', __('Parcela paga'));

        //redirecionamento
        $this -> redirect(array('controller' => 'parcelas', 'action' => 'listar',$this->params['pass'][1]));
    }

     /**  
    * Processo de pagar muitas parcelas
    * @param do POST $this->data // array de id de parcela
    * @return void
    */
    public function pagar_selecionados(){


    	 if (count($this->data) >1 ) {

            foreach ($this->data as $key => $valor) {

                //processo de excluir
                $this->Parcela->pagar_parcela($valor);

            }//fim foreach
        
            //escrevendo msg de sucesso na sessão
            $this -> Session -> write('sucesso', __('Parcelas pagas'));
            
            //redirecionamento
            $this -> redirect(array('controller' => 'parcelas', 'action' => 'listar',$this->data['idVenda']));

        }else{

            //escrevendo msg de erro na sessão
            $this -> Session -> write('erro',__('Selecione pelo menos uma item na checkbox'));
            
            //redirecionamento
            $this -> redirect(array('controller' => 'parcelas', 'action' => 'listar',$this->data['idVenda']));

        }//fim if

    }//fim pagar_selecionados()

}//fim class ParcelasController
?>