<?php

/**
 *	Controle
 */

class VendasController extends AppController {
    
   

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
        //tipo (0 - proprietário) (1 - Venda)

        if ($tipoDeUsuario == 0 || $permissao['VendasController']['permitido'] == 0 ) {
            
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

    /**
    * Se requisição POST
    *  Ação de adicionar
    *  @param array do POST $this -> data informações de Venda e parcelas
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

            // //processo de salvar
             $this->Venda-> salvar_venda($dados);

            // //escrevendo msg de sucesso na sessão 
             $this -> Session -> write('sucesso', __("Venda cadastrada"));

        }//fim if


        //menu
        //título da página
        $this -> set('titulo', __('Adicionar venda'));

        //aqui vai ativar o menu - extender
        $this -> set('venda_menu', 'active');

        //aqui vai ativar o sub menu - extender
        $this -> set('venda_novo_sub_menu', 'active');
        
         
    }//fim novo()

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
            $this->redirect(array('controller' => 'vendas', 'action' => 'listar/buscar',$this->data['buscar']));

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
        $options = $this -> Venda -> listagem($usuario['Config']['registros_por_pagina'], $busca);

        //define paginação
        $this -> paginate = $options;
        
        // Roda a consulta, já trazendo os resultados paginados
        $vendas = $this -> paginate('Venda');

        //disponível na view
        $this->set('vendas', $vendas);

        //total de registros tanto de busca quanto de listagem normal
        $this->set('totalRegistros',count($vendas));

        //menu
        //título da página
        $this -> set('titulo', __('Listar vendas'));

        //aqui vai ativar o menu - extender
        $this -> set('venda_menu', 'active');

        //aqui vai ativar o sub menu - extender
        $this -> set('venda_listar_sub_menu', 'active');

    }//fim listar()

    /**  
    * Requisição GET
    *  Ação de vizualizar registro
    *  @param integer do GET $this->request->query['term'] id do Venda
    *  @return void
    */
    public function visualizar()  {
        
        //recupero o valor do id 
        $idVenda =  $this->request->query['term'];

        //recupero info. do Venda com id
        $venda = $this -> Venda -> findAllById($idVenda);

        $cliente = $this->Venda->Cliente->findById($venda[0]['Cliente']['id']);
        
        $vendedor = $this->Venda->Vendedor->findById($venda[0]['Vendedor']['id']);

        $parcelas = $this->Venda->Parcela->findAllByVendaId($venda[0]['Venda']['id']);

        //disponível na view os valores dos Vendaes
        $this-> set('venda', $venda[0]);

        $this-> set('parcela', $parcelas);

        $this-> set('cliente', $cliente);

        $this-> set('vendedor', $vendedor);

        //define título da janela modal
        $this-> set('tituloJanelaModal', __('Venda'));
        
        //define layout da página ou seja vazía
        $this->layout = "ajax";

    }//fim visualizar()

     /**  
    * Requisição GET
    *  Ação de excluir apenas um registro
    *  @param integer do GET $this->params['pass'][0] id do vendedor
    *  @return render de outra página de resultado
    */
    public function excluir() { 

        //processo de excluir
        $this-> Venda ->excluir_venda($this->params['pass'][0]);

        //escrevendo msg de sucesso na sessão
        $this -> Session -> write('sucesso', __('Exclusão concluída'));

        //redirecionamento
        $this -> redirect(array('controller' => 'vendas', 'action' => 'listar'));
      
    }//fim excluir()


    /**  
    * Requisição POST
    *  Ação de excluir mais de um registro
    *  @param array do POST $this->data id do venda
    *  @return void
    */
    public function excluir_selecionados() {

        if (count($this->data) >=1 ) {

            foreach ($this->data as $key => $valor) {

                //processo de excluir
                $this->Venda->excluir_venda($valor);
                 

            }//fim foreach
        
            //escrevendo msg de sucesso na sessão
            $this -> Session -> write('sucesso', __('Exclusões concluídas '));
            
            //redirecionamento
            $this -> redirect(array('controller' => 'vendas', 'action' => 'listar'));

        }else{

            //escrevendo msg de erro na sessão
            $this -> Session -> write('erro',__('Selecione pelo menos uma item na checkbox'));
            
            //redirecionamento
            $this -> redirect(array('controller' => 'vendas', 'action' => 'listar'));

        }//fim if

    }//fim excluir_selecionados()

    

}//fim class VendasController
?>