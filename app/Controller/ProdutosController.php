<?php

/**
 *	Controle
 */


class ProdutosController extends AppController {

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

        //tipo de usuário ativo na sessão
        $tipoDeUsuario = $this->Session->read('Auth.User.Usuario.tipo');

        //permitido (0 - sim) (1 = não)
        //tipo (0 - proprietário) (1 - Vendedor)

        if ($tipoDeUsuario == 0 || $permissao['ProdutosController']['permitido'] == 0 ) {
            
            //fluxo normal
            return true;

        }else{

             if($this->action == 'visualizar'){

                 if ( $permissao['RelatoriosController']['permitido'] == 0) {

                   return true;
                }else{

                    // página de acesso restrito
                    return $this->redirect('/usuarios/acesso_restrito');
                }

            }

            // página de acesso restrito
            return $this->redirect('/usuarios/acesso_restrito');

        }//fim if
           
    }//fim isAuthorized()

	public function teste(){

		$this->Produto->geraCodigoBarras();
		
	}


    /** 
    * Se requisição POST
    *  Ação de adicionar
    *  @param array do POST $this -> data informações sobre produto o id do Fornecedor
    *  @return void
    *
    * Se requisição GET
    *  Ação de rederizar a página novo com informações
    *  @return void
    *
    */
    public function novo() {
        
          //se  a requisição for post
        if ($this->request->is('post')) {

            // recebe todos os dados enviados
            $dados = $this -> data;

            //processo de salvar
            $this->Produto-> salvar_produto($dados);

            //escrevendo msg de sucesso na sessão 
            $this -> Session -> write('sucesso', __("Produto cadastrado"));

        }//fim if

        //menu
        //título da página
        $this -> set('titulo', __('Adicionar produto'));

        //aqui vai ativar o menu - extender
        $this -> set('produto_menu', 'active');

        //aqui vai ativar o sub menu - extender
        $this -> set('produto_novo_sub_menu', 'active');
         
    }//fim novo()


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
    public function listar(){


        //se existe valor 
        if (!empty($this->data['buscar'])) {

            //redirecionamento
            $this->redirect(array('controller' => 'produtos', 'action' => 'listar/buscar',$this->data['buscar']));

        }//fim if

        // recupera usuário ativo na sessão
        $usuario = $this -> Session -> read('Auth.User');

        //Paginação - Numero de diferença entre os botões
        //utilizada na view PaginatorHelper
        $this -> set('modulus', $usuario['Config']['diferenca_entre_botoes_pag']);

        // info do post - buscar - info da url
        if(!empty($this->params['pass'][1])){

             //busca

             //recupera valor da busca pela url
            $busca = $this->params['pass'][1];

            //disponível na view o valor da busca
            $this->set('busca',$busca);
           
        }else{

            //listagem normal

            $busca = null;
            
        }//fim if
        
         //recupera info para auxílio da paginação e informação
        $options = $this -> Produto -> listagem($usuario['Config']['registros_por_pagina'], $busca);
        
         //define paginação
        $this -> paginate = $options;
  
        // Roda a consulta, já trazendo os resultados paginados
        $produtos = $this -> paginate('Produto'); 
        
        //disponível na view
        $this->set('produtos', $produtos);

        //total de registros tanto de busca quanto de listagem normal
        $this->set('totalRegistros',count($produtos));

        //menu
        //título da página
        $this -> set('titulo', __('Listar produtos'));

        //aqui vai ativar o menu - extender
        $this -> set('produto_menu', 'active');

        //aqui vai ativar o sub menu - extender
        $this -> set('produto_listar_sub_menu', 'active');

       
    }//fim listar()

    /**  
    * Requisição GET
    *  Ação de vizualizar registro
    *  @param integer do GET $this->request->query['term'] id do Produto
    *  @return void
    */
    public function visualizar()  {
        
        //recupero o valor do id 
        $idProduto =  $this->request->query['term'];

        //recupero info. do Produto com id
        $produto = $this -> Produto -> findById($idProduto);

        //recupero informações completas sobre o fornecedor
        $fornecedor = $this->Produto->Fornecedor->buscaPorId($produto['Fornecedor']['id']);

        // mesclo as informações
        $produto = array_merge($produto,$fornecedor);

        //disponível na view os valores dos produtos
        $this-> set('produto', $produto);

        //define título da janela modal
        $this-> set('tituloJanelaModal', __('Produto'));
        
        //define layout da página ou seja vazía
        $this->layout = "ajax";

    }//fim visualizar()

    /** 
    * Se requisição POST
    *  Ação de atualizar
    *  @param array do POST $this -> data informações de Produto, endereço, usuário e pessoa
    *  @return void
    *
    * Se requisição GET
    *  Ação de rederizar a página editar com informações
    *  @param integer do GET $this->params['pass'][0] id do Produto
    *  @return void
    *
    */
    public  function editar(){

        //se a requisição é post
        if ($this->request->is('post')) {

            // recebe todos os dados enviados
            $dados = $this -> data;

            //processo da atualizar
            $this->Produto -> atualizar_produto($dados);

            //escrevendo msg de sucesso na sessão
            $this -> Session -> write('sucesso', __('Produto atualizado'));

            //redirecionamento
            $this -> redirect(array('controller' => 'produtos', 'action' => 'editar',$dados['Produto']['id']));

        }//fim if

        //recupero info. do Produto pelo id
        $produto = $this -> Produto -> findById($this->params['pass'][0]);

        //recupero informações completas sobre o fornecedor
        $fornecedor = $this->Produto->Fornecedor->buscaPorId($produto['Fornecedor']['id']);

        // mesclo as informações
        $produto = array_merge($produto,$fornecedor);

        //disponível na view o valor do Produto
        $this->set('produto', $produto);

        //menu
        //título da página
        $this -> set('titulo', __('Atualizar Produto'));

        //aqui vai ativar o menu - extender
        $this -> set('produto_menu', 'active');

        //aqui vai ativar o sub menu - extender
        $this -> set('produto_listar_sub_menu', 'active');

    }//fim editar()

    /**  
    * Requisição GET
    *  Ação de excluir apenas um registro
    *  @param integer do GET $this->params['pass'][0] id do Produto
    *  @return render de outra página de resultado
    */
    public function excluir() { 

        //processo de excluir
        $this-> Produto ->excluir_produto($this->params['pass'][0]);

        //escrevendo msg de sucesso na sessão
        $this -> Session -> write('sucesso', __('Exclusão concluída'));

        //redirecionamento
        $this -> redirect(array('controller' => 'produtos', 'action' => 'listar'));
      
    }//fim excluir()


    /**  
    * Requisição POST
    *  Ação de excluir mais de um registro
    *  @param array do POST $this->data id do Produto
    *  @return void
    */
    public function excluir_selecionados() {

        if (count($this->data) >=1 ) {

            foreach ($this->data as $key => $valor) {

                //processo de excluir
                $this->Produto->excluir_produto($valor);

            }//fim foreach
        
            //escrevendo msg de sucesso na sessão
            $this -> Session -> write('sucesso', __('Exclusões concluídas'));
            
            //redirecionamento
            $this -> redirect(array('controller' => 'produtos', 'action' => 'listar'));

        }else{

            //escrevendo msg de erro na sessão
            $this -> Session -> write('erro',__('Selecione pelo menos uma item na checkbox'));
            
            //redirecionamento
            $this -> redirect(array('controller' => 'produtos', 'action' => 'listar'));

        }//fim if

    }//fim excluir_selecionados()

    
    /**  
    * Busca por nome e código de barras
    * @param string nome ou código de barras
    * @return json com informações do produto
    */
    public function ajaxBuscaPorNomeCodigoBarras(){

        //FALSE não permite rederizar o nome do método em uma página .ctp
        //pois somente queremos que retorne o conteúdo
        $this->autoRender = false;

        //define layout da página ou seja vazía
        $this->layout = "ajax";

        //recupero o valor do nome do vendedor
        $consulta =  $this->request->query['term'];

        return  json_encode($this->Produto->buscaPorNomeCodigoBarras($consulta));

    }

   

     
}//fim class ProdutosController
?>