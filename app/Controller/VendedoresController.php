<?php

/**
 * Controle
 */

class VendedoresController extends AppController {

    // modelos adicionais disponíveis para este Controller
    var $uses = array('Vendedor', 'Estado');

    //esta ação ocorre antes da ação das actions deste Controller
    public function beforeFilter() {

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
        $permissao = $this -> Session -> read('Auth.User.Permissoes');

        //recupero tipo de usuário ativo na sessão
        $tipoDeUsuario = $this -> Session -> read('Auth.User.Usuario.tipo');

        //permitido (0 - sim) (1 = não)
        //tipo (0 - proprietário) (1 - Vendedor)

        if ($tipoDeUsuario == 0 || $permissao['VendedoresController']['permitido'] == 0) {

            //fluxo normal
            return true;

        } else {

            // página de acesso restrito
            return $this -> redirect('/usuarios/acesso_restrito');

        }//fim if

    }//fim isAuthorized()

    /**
     * Se requisição POST
     *  Ação de adicionar
     *  @param array do POST $this -> data informações de vendedor, endereço, usuário e pessoa
     *  @return void
     *
     * Se requisição GET
     *  Ação de rederizar a página novo com informações
     *  @param integer do GET $this->params['pass'][0] id do vendedor
     *  @return void
     *
     */
    public function novo() {

        //se  a requisição for post
        if ($this -> request -> is('post')) {

            // recebe todos os dados enviados
            $dados = $this -> data;

            //processo de salvar
            $this -> Vendedor -> salvar_vendedor($dados);

            //escrevendo msg de sucesso na sessão
            $this -> Session -> write('sucesso', __("Vendedor cadastrado"));

        }//fim if

        //disponível na view o valor de todos os estados
        $this -> set('estados', $this -> Estado -> listarTodosEstados());

        //menu
        //título da página
        $this -> set('titulo', __('Adicionar vendedor'));

        //aqui vai ativar o menu - extender
        $this -> set('vendedor_menu', 'active');

        //aqui vai ativar o sub menu - extender
        $this -> set('vendedor_novo_sub_menu', 'active');

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
        if (!empty($this -> data['buscar'])) {

            //redirecionamento
            $this -> redirect(array('controller' => 'vendedores', 'action' => 'listar/buscar', $this -> data['buscar']));

        }//fim if

        // recupera usuário ativo na sessão
        $usuario = $this -> Session -> read('Auth.User');

        //Paginação - Numero de diferença entre os botões
        //utilizada na view PaginatorHelper
        $this -> set('modulus', $usuario['Config']['diferenca_entre_botoes_pag']);

        // info do post - buscar - info da url
        if (!empty($this -> params['pass'][1])) {

            //busca

            //recupera valor da busca pela url
            $busca = $this -> params['pass'][1];

            //disponível na view o valor da busca
            $this -> set('busca', $busca);

        } else {

             //listagem normal
             $busca = null;

        }//fim if
        
        //recupera info para auxílio da paginação e informação
        $options = $this -> Vendedor -> listagem($usuario['Config']['registros_por_pagina'], $busca);

        //define paginação
        $this -> paginate = $options;

        // Roda a consulta, já trazendo os resultados paginados
        $vendedores = $this -> paginate('Vendedor');

        //disponível na view
        $this -> set('vendedores', $vendedores);

        //total de registros tanto de busca quanto de listagem normal
        $this -> set('totalRegistros', count($vendedores));

        //menu
        //título da página
        $this -> set('titulo', __('Listar vendedores'));

        //aqui vai ativar o menu - extender
        $this -> set('vendedor_menu', 'active');

        //aqui vai ativar o sub menu - extender
        $this -> set('vendedor_listar_sub_menu', 'active');

    }//fim listar()

    /**
     * Requisição GET
     *  Ação de vizualizar registro
     *  @param integer do GET $this->request->query['term'] id do vendedor
     *  @return void
     */
    public function visualizar() {

        //recupero o valor do id
        $idVendedor = $this -> request -> query['term'];

        //recupero info. do vendedor com id
        $vendedor = $this -> Vendedor -> findAllById($idVendedor);

        //recupero inf. da cidade e estado correspondente ao vendedor
        $infoCidadeEstado = $this -> Estado -> infoCidadeEstado($vendedor[0]['Endereco']['cidade_id']);

        // mesclo as informações
        $vendedor = array_merge($vendedor[0], $infoCidadeEstado[0]);

        //disponível na view os valores dos vendedores
        $this -> set('vendedor', $vendedor);

        //define título da janela modal
        $this -> set('tituloJanelaModal', __('Vendedor'));

        //define layout da página ou seja vazía
        $this -> layout = "ajax";

    }//fim visualizar()

    /**
     * Requisição GET
     *  Ação de excluir apenas um registro
     *  @param integer do GET $this->params['pass'][0] id do vendedor
     *  @return render de outra página de resultado
     */
    public function excluir() {

        //processo de excluir
        $this -> Vendedor -> excluir_vendedor($this -> params['pass'][0]);

        //escrevendo msg de sucesso na sessão
        $this -> Session -> write('sucesso', __('Exclusão concluída'));

        //redirecionamento
        $this -> redirect(array('controller' => 'vendedores', 'action' => 'listar'));

    }//fim excluir()

    /**
     * Requisição POST
     *  Ação de excluir mais de um registro
     *  @param array do POST $this->data id do vendedor
     *  @return void
     */
    public function excluir_selecionados() {

        if (count($this -> data) >= 1) {

            foreach ($this->data as $key => $valor) {

                //processo de excluir
                $this -> Vendedor -> excluir_vendedor($valor);

            }//fim foreach

            //escrevendo msg de sucesso na sessão
            $this -> Session -> write('sucesso', __('Exclusões concluídas'));

            //redirecionamento
            $this -> redirect(array('controller' => 'vendedores', 'action' => 'listar'));

        } else {

            //escrevendo msg de erro na sessão
            $this -> Session -> write('erro', __('Selecione pelo menos uma item na checkbox'));

            //redirecionamento
            $this -> redirect(array('controller' => 'vendedores', 'action' => 'listar'));

        }//fim if

    }//fim excluir_selecionados()

    /**
     * Se requisição POST
     *  Ação de atualizar
     *  @param array do POST $this -> data informações de vendedor, endereço, usuário e pessoa
     *  @return void
     *
     * Se requisição GET
     *  Ação de rederizar a página editar com informações
     *  @param integer do GET $this->params['pass'][0] id do vendedor
     *  @return void
     */
    public function editar() {

        //se a requisição é post
        if ($this -> request -> is('post')) {

            // recebe todos os dados enviados
            $dados = $this -> data;

            //processo da atualizar
            $this -> Vendedor -> atualizar_vendedor($dados);

            //escrevendo msg de sucesso na sessão
            $this -> Session -> write('sucesso', __('Vendedor atualizado'));

            //redirecionamento
            $this -> redirect(array('controller' => 'vendedores', 'action' => 'editar', $dados['Vendedor']['id']));

        }//fim if

        //disponível na view
        $this -> set('estados', $this -> Estado -> listarTodosEstados());

        //recupero info. do vendedor pelo id
        $vendedor = $this -> Vendedor -> findAllById($this -> params['pass'][0]);

        //recupero info de cidade e estado correspondente do vendedor
        $infoCidadeEstado = $this -> Estado -> infoCidadeEstado($vendedor[0]['Endereco']['cidade_id']);

        // mesclo as informações
        $vendedor = array_merge($vendedor[0], $infoCidadeEstado[0]);

        //disponível na view o valor do vendedor
        $this -> set('vendedor', $vendedor);

        //recupero info de todas as cidade de uma determinado estado
        $cidades = $this -> Estado -> buscarCidades($vendedor['Estado']['id']);

        //disponível na view o valor das cidades
        $this -> set('listaCidades', $cidades[0]);

        //menu
        //título da página
        $this -> set('titulo', __('Atualizar vendedor'));

        //aqui vai ativar o menu - extender
        $this -> set('vendedor_menu', 'active');

        //aqui vai ativar o sub menu - extender
        $this -> set('vendedor_listar_sub_menu', 'active');

    }//fim editar()

    /**
     * Busca por nome
     * @param string nome
     * @return json com informações do vendedor
     */
    public function ajaxBuscaPorNome() {

        //FALSE não permite rederizar o nome do método em uma página .ctp
        //pois somente queremos que retorne o conteúdo
        $this -> autoRender = false;

        //define layout da página ou seja vazía
        $this -> layout = "ajax";

        //recupero o valor do nome do vendedor
        $nomeVendedor = $this -> request -> query['term'];

        return json_encode($this -> Vendedor -> buscaPorNome($nomeVendedor));

    }//fim ajaxBuscaPorNome()

}//class VendedoresController
?>