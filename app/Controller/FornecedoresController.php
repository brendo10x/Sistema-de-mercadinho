<?php

/**  
* Controle
*/

class FornecedoresController extends AppController {


    //modelos adicionais disponíveis para este Controller
    var $uses = array('Fornecedor','Estado');

    
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

        if ($tipoDeUsuario == 0 || $permissao['FornecedoresController']['permitido'] == 0) {
            
            //fluxo normal
            return true;

        }else{

            // página de acesso restrito
            return $this->redirect('/usuarios/acesso_restrito');

        }//fim if
           
    }//fim isAuthorized()
  
    
    /** 
    * Se requisição POST
    *  Ação de adicionar
    *  @param array do POST $this -> data informações de Fornecedor, endereço e pessoa
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
            $this->Fornecedor-> salvar_fornecedor($dados);

            //escrevendo msg de sucesso na sessão 
            $this -> Session -> write('sucesso', __("Fornecedor cadastrado"));

        }//fim if

        //disponível na view o valor de todos os estados
        $this -> set('estados', $this-> Estado -> listarTodosEstados());

        //menu
        //título da página
        $this -> set('titulo', __('Adicionar fornecedor'));

        //aqui vai ativar o menu - extender
        $this -> set('fornecedor_menu', 'active');

        //aqui vai ativar o sub menu - extender
        $this -> set('fornecedor_novo_sub_menu', 'active');
         
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
    public function listar() {
         
        //se existe valor 
        if (!empty($this->data['buscar'])) {

            //redirecionamento
            $this->redirect(array('controller' => 'fornecedores', 'action' => 'listar/buscar',$this->data['buscar']));

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
        $options = $this -> Fornecedor -> listagem($usuario['Config']['registros_por_pagina'], $busca);

        //define paginação
        $this -> paginate = $options;
            
        // Roda a consulta, já trazendo os resultados paginados
        $fornecedores = $this -> paginate('Fornecedor');
        
        //disponível na view
        $this->set('fornecedores', $fornecedores);

        //total de registros tanto de busca quanto de listagem normal
        $this->set('totalRegistros',count($fornecedores));

        //menu
        //título da página
        $this -> set('titulo', __('Listar fornecedores'));

        //aqui vai ativar o menu - extender
        $this -> set('fornecedor_menu', 'active');

        //aqui vai ativar o sub menu - extender
        $this -> set('fornecedor_listar_sub_menu', 'active');

    }//fim listar()
    

    /**  
    * Requisição GET
    *  Ação de vizualizar registro
    *  @param integer do GET $this->request->query['term'] id do Fornecedor
    *  @return void
    */
    public function visualizar()  {
        
        //recupero o valor do id 
        $idFornecedor =  $this->request->query['term'];

        //recupero info. do Fornecedor com id
        $fornecedor = $this -> Fornecedor -> findAllById($idFornecedor);

        //recupero inf. da cidade e estado correspondente ao Fornecedor
        $infoCidadeEstado = $this->Estado->infoCidadeEstado($fornecedor[0]['Endereco']['cidade_id']);

        // mesclo as informações
        $fornecedor = array_merge($fornecedor[0],$infoCidadeEstado[0]);

        //disponível na view os valores dos Fornecedores
        $this-> set('fornecedor', $fornecedor);

        //define título da janela modal
        $this-> set('tituloJanelaModal', __('Fornecedor'));
        
        //define layout da página ou seja vazía
        $this->layout = "ajax";

    }//fim visualizar()


    /**  
    * Requisição GET
    *  Ação de excluir apenas um registro
    *  @param integer do GET $this->params['pass'][0] id do Fornecedor
    *  @return render de outra página de resultado
    */
    public function excluir() { 

        //processo de excluir
        $this-> Fornecedor ->excluir_fornecedor($this->params['pass'][0]);

        //escrevendo msg de sucesso na sessão
        $this -> Session -> write('sucesso', __('Exclusão concluída'));

        //redirecionamento
        $this -> redirect(array('controller' => 'fornecedores', 'action' => 'listar'));
      
    }//fim excluir()


    /**  
    * Requisição POST
    *  Ação de excluir mais de um registro
    *  @param array do POST $this->data id do Fornecedor
    *  @return void
    */
    public function excluir_selecionados() {

        if (count($this->data) >=1 ) {

            foreach ($this->data as $key => $valor) {

                //processo de excluir
                $this->Fornecedor->excluir_fornecedor($valor);

            }//fim foreach
        
            //escrevendo msg de sucesso na sessão
            $this -> Session -> write('sucesso', __('Exclusões concluídas'));
            
            //redirecionamento
            $this -> redirect(array('controller' => 'fornecedores', 'action' => 'listar'));

        }else{

            //escrevendo msg de erro na sessão
            $this -> Session -> write('erro',__('Selecione pelo menos uma item na checkbox'));
            
            //redirecionamento
            $this -> redirect(array('controller' => 'fornecedores', 'action' => 'listar'));

        }//fim if

    }//fim excluir_selecionados()

   
    /** 
    * Se requisição POST
    *  Ação de atualizar
    *  @param array do POST $this -> data informações de Fornecedor, endereço e pessoa
    *  @return void
    *
    * Se requisição GET
    *  Ação de rederizar a página editar com informações
    *  @param integer do GET $this->params['pass'][0] id do Fornecedor
    *  @return void
    *
    */
    public  function editar(){

        //se a requisição é post
        if ($this->request->is('post')) {

            // recebe todos os dados enviados
            $dados = $this -> data;

            //processo da atualizar
            $this->Fornecedor -> atualizar_fornecedor($dados);

            //escrevendo msg de sucesso na sessão
            $this -> Session -> write('sucesso', __('Fornecedor atualizado'));

            //redirecionamento
            $this -> redirect(array('controller' => 'fornecedores', 'action' => 'editar',$dados['Fornecedor']['id']));

        }//fim if

        //disponível na view
        $this -> set('estados', $this-> Estado -> listarTodosEstados());

        //recupero info. do Fornecedor pelo id
        $fornecedor = $this -> Fornecedor -> findAllById($this->params['pass'][0]);

        //recupero info de cidade e estado correspondente do Fornecedor
        $infoCidadeEstado = $this-> Estado->infoCidadeEstado($fornecedor[0]['Endereco']['cidade_id']);
           
        // mesclo as informações
        $fornecedor = array_merge($fornecedor[0],$infoCidadeEstado[0]);

        //disponível na view o valor do Fornecedor
        $this->set('fornecedor', $fornecedor);

        //recupero info de todas as cidade de uma determinado estado
        $cidades = $this-> Estado -> buscarCidades($fornecedor['Estado']['id']);

        //disponível na view o valor das cidades
        $this -> set('listaCidades', $cidades[0]);
        
        //menu
        //título da página
        $this -> set('titulo', __('Atualizar fornecedor'));

        //aqui vai ativar o menu - extender
        $this -> set('fornecedor_menu', 'active');

        //aqui vai ativar o sub menu - extender
        $this -> set('fornecedor_listar_sub_menu', 'active');

    }//fim editar()


    /**  
    * Busca por nome
    * @param string nome
    * @return json com informações do fornecedor
    */

    public function ajaxBuscaPorNome(){

        //FALSE não permite rederizar o nome do método em uma página .ctp
        //pois somente queremos que retorne o conteúdo
        $this->autoRender = false;

        //define layout da página ou seja vazía
        $this->layout = "ajax";

        //recupero o valor do nome do vendedor
        $nomeFornecedor =  $this->request->query['term'];

        return  json_encode($this->Fornecedor->buscaPorNome($nomeFornecedor));

    }

}//class fornecedorController

?>