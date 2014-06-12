<?php

/**
 *	Controle
 */
App::uses('AppModel', 'Model');
App::uses('Venda', 'Model');
App::uses('Vendedor', 'Model');
App::uses('ProdutoVendido', 'Model');
App::uses('Produto', 'Model');
App::uses('Venda', 'Model');
App::uses('Cliente', 'Model');
App::uses('Endereco', 'Model');
App::uses('Cidade', 'Model');
App::uses('Estado', 'Model');
class RelatoriosController extends AppController {

    // modelos adicionais disponíveis para este Controller
    var $uses = array('Venda', 'Vendedor', 'Produto');

    //esta ação ocorre antes da ação das actions deste Controller
    public function beforeFilter() {

        //executa ação herdada do AppController
        parent::beforeFilter();

    }//fim beforeFilter()

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

        if ($tipoDeUsuario == 0 || $permissao['RelatoriosController']['permitido'] == 0) {

            //fluxo normal
            return true;

        } else {

            // página de acesso restrito
            return $this -> redirect('/usuarios/acesso_restrito');

        }//fim if

    }//fim isAuthorized()

    /**
     * Relatório de vendas
     * Com dois filtros de consultas
     * Relatório 1 - 'action' => 'relatorios_vendas/1/{data}
     *   Descrição: Listas todas as vendas realizadas no mês ou dia
     *
     * Relatório 2 - 'action' => 'relatorios_vendas/2/{data}/{id do vendedor}
     *   Descrição: Listas todas as vendas realizadas por um vendedor no mês ou dia
     *
     * DADOS VIA POST
     *   $this->data['buscar']         // avisa o tipo de relatório e armazena a data
     *   $this->data['buscar2']        // avisa o tipo de relatório e armazena a data
     *   $this->data['Vendedor']['id'] // armazena o id do vendedor
     *
     * DADOS VIA GET
     *   Array
     *   (
     *     [0] => 1              // tipo de relatório
     *     [1] => 16-01-2014     // data
     *     [2] => 1              // id vendedor
     *   )
     */
    public function relatorios_vendas() {

        //se existe valor
        if (!empty($this -> data['buscar'])) {

            //redirecionamento
            $this -> redirect(array('controller' => 'relatorios', 'action' => 'relatorios_vendas/1/' . $this -> data['buscar']));

        }//fim if

        if (!empty($this -> data['buscar2'])) {

            //redirecionamento
            $this -> redirect(array('controller' => 'relatorios', 'action' => 'relatorios_vendas/2/' . $this -> data['buscar2'] . '/' . $this -> data['Vendedor']['id']));
        }//fim if

        // modelo importânte Venda
        $Venda = new Venda;

        //recupera usuário da sessão
        $usuario = $this -> Session -> read('Auth.User');

        //Paginação - Numero de diferença entre os botões
        //utilizada na view PaginatorHelper
        $this -> set('modulus', $usuario['Config']['diferenca_entre_botoes_pag']);

        // info do post - buscar - info da url
        if (!empty($this -> params['pass'][0])) {

            //relatório 1
            if ($this -> params['pass'][0] == 1) {

                //recupero parâmetro - valor da data
                $data = $this -> params['pass'][1];

                // concatena url
                $buscaUrl = '1/' . $data;

                // define variável - busca
                $this -> set('busca', $buscaUrl);

                // define variável - data
                $this -> set('data', $data);

                //recupera info para auxílio da paginação e informação
                $options = $Venda -> relatorio_1($usuario['Config']['registros_por_pagina'], $data);

                //ativa tab
                $this -> set('tab_1', 'active');

                //menu
                //título da página
                $this -> set('titulo', __('Vendas no mês ou dia'));

            }//fim if

            //relatório 2
            if ($this -> params['pass'][0] == 2) {

                //recupero parâmetro - com valor da data
                $data = $this -> params['pass'][1];

                //recupero parâmetro - com valor do id do vendedor
                $idVendedor = $this -> params['pass'][2];

                // define variável - com valor da data
                $this -> set('data2', $data);

                // define variável - com id do vendedor
                $this -> set('idVendedor', $idVendedor);

                // recupera informações sobre o vendedor
                $vendedor = $this -> Vendedor -> findById($idVendedor);

                // define variável - com valor do nome do vendedor
                $this -> set('nomeVendedor', $vendedor['Pessoa']['pes_nome']);

                //concatena url
                $buscaUrl = '2/' . $data . '/' . $idVendedor;

                //disponível na view o valor da url de busca
                $this -> set('busca', $buscaUrl);

                //recupera info para auxílio da paginação e informação
                $options = $Venda -> relatorio_2($usuario['Config']['registros_por_pagina'], $data, $idVendedor);

                //ativa da tab na view
                $this -> set('tab_2', 'active');

                //menu
                //título da página
                $this -> set('titulo', __('Vendas no mês ou dia vendedor'));

            }//fim if

        } else {

            //listagem normal

            //recupera info para auxílio da paginação e informação
            $options = $Venda -> relatorio_1($usuario['Config']['registros_por_pagina'], null);

            //ativa tab na view
            $this -> set('tab_1', 'active');

            //menu
            //título da página
            $this -> set('titulo', __('Vendas'));

        }//fim if

        //define configuração para paginação
        $this -> paginate = $options;

        // Roda a consulta, já trazendo os resultados paginados
        $vendas = $this -> paginate('Venda');

        // //disponível na view
        $this -> set('vendas', $vendas);

        //total de registros tanto de busca quanto de listagem normal
        $this -> set('totalRegistros', count($vendas));

        //Breadcrumb
        $this -> set('breadcrumb', __('Relatório vendas'));

        //aqui vai ativar o menu - extender
        $this -> set('relatorios_menu', 'active');

        //aqui vai ativar o sub menu - extender
        $this -> set('relatorios_vendas_listar_sub_menu', 'active');

    }//fim listar()

    /**
     * Relatórios de produtos
     * Com um filtro de consulta
     * Relatório 1 - 'action' => 'relatorios_produtos/{data}
     *   Descrição: Listas os produtos mais vendidos do mês ou dia
     *
     * DADOS VIA POST
     *   $this->data['buscar']  // avisa o tipo de relatório e armazena a data
     *
     * DADOS VIA GET
     *   Array
     *   (
     *     [0] => 16-01-2014     // data
     *   )
     */
    public function relatorios_produtos() {

        if (!empty($this -> data['buscar'])) {

            //redirecionamento
            $this -> redirect(array('controller' => 'relatorios', 'action' => 'relatorios_produtos/' . $this -> data['buscar']));

        }//fim if

        //busca
        if (!empty($this -> params['pass'][0])) {

            //recupero parâmetro - com valor da data
            $data = $this -> params['pass'][0];

            // define variável - com valor da data
            $this -> set('data', $data);

            //disponível na view o valor da url de busca
            $this -> set('busca', $data);

            //menu
            //título da página
            $this -> set('titulo', __('Produtos mais vendidos no mês ou dia'));

        } else {
            //fim if

            //menu
            //título da página
            $this -> set('titulo', __('Produtos'));

            $data = null;
        }

        // Modelo produto
        $Produto = new Produto;

        //recupera usuário da sessão
        $usuario = $this -> Session -> read('Auth.User');

        //Paginação - Numero de diferença entre os botões
        //utilizada na view PaginatorHelper
        $this -> set('modulus', $usuario['Config']['diferenca_entre_botoes_pag']);

        //recupera info para auxílio da paginação e informação
        $options = $Produto -> relatorio_1($usuario['Config']['registros_por_pagina'], $data);

        //define configurações
        $this -> paginate = $options;

        // Roda a consulta, já trazendo os resultados paginados
        $produtos = $this -> paginate('Produto');

        // //disponível na view
        $this -> set('produtos', $produtos);

        //Breadcrumb
        $this -> set('breadcrumb', __('Relatório produtos'));

        //total de registros tanto de busca quanto de listagem normal
        $this -> set('totalRegistros', count($produtos));

        //aqui vai ativar o menu - extender
        $this -> set('relatorios_menu', 'active');

        //aqui vai ativar o sub menu - extender
        $this -> set('relatorios_produtos_listar_sub_menu', 'active');

        // ativa tab na view
        $this -> set('tab_1', 'active');

    }//fim relatorios_produtos()

    /**
     * Relatório de clientes
     * Com dois filtros de consultas
     * Relatório 1 - 'action' => 'relatorios_clientes/1/{id do estado}/{id da cidade}
     *   Descrição: Listas todos as clientes de uma determinada cidade
     *
     * Relatório 2 - 'action' => 'relatorios_clientes/2/{id do estado}
     *   Descrição: Listas todos as clientes de uma determinada estado
     *
     * DADOS VIA POST
     *   $this->data['buscar']  //  avisa o tipo de relatório e armazena o id da cidade
     *   $this->data['buscar2'] // avisoa o tipo de relatório e armazena o id do estado
     *
     * DADOS VIA GET
     *   Array
     *   (
     *     [0] => 1              // tipo de relatório
     *     [1] => 16-01-2014     // id do estado
     *     [2] => 1              // id da cidade
     *   )
     *
     */
    public function relatorios_clientes() {

        //estrutura de controle
        //se existe valor
        // buscar cidades de clientes
        if (!empty($this -> data['buscar'])) {

            //redirecionamento
            $this -> redirect(array('controller' => 'relatorios', 'action' => 'relatorios_clientes/1/' . $this -> data['estado'] . '/' . $this -> data['buscar']));

        }//fim if

        //buscar estados
        if (!empty($this -> data['buscar2'])) {

            //redirecionamento
            $this -> redirect(array('controller' => 'relatorios', 'action' => 'relatorios_clientes/2/' . $this -> data['buscar2']));
        }//fim if

        // Modelo cliente
        $Cliente = new Cliente;

        //objeto necessário
        $Estado = new Estado;

        //configuração de paginação
        //recupero o usuário da sessão
        $usuario = $this -> Session -> read('Auth.User');

        //busca
        if (!empty($this -> params['pass'][0])) {

            //Relatório 1
            if ($this -> params['pass'][0] == 1) {

                //recupera parâmetro - com valor do id do estado
                $idEstado = $this -> params['pass'][1];

                //recupera parâmetro - com valor do id da cidade
                $idCidade = $this -> params['pass'][2];

                //concatena url
                $busca = '1/' . $idEstado . '/' . $idCidade;

                //disponível na view o valor da url de busca
                $this -> set('busca', $busca);

                //recupero info de todas as cidade de uma determinado estado
                $cidades = $Estado -> buscarCidades($idEstado);

                //disponível na view o valor das cidades
                $this -> set('listaCidades', $cidades[0]);

                //disponível na view o valor do id da cidade escolhida
                $this -> set('cidadeEscolhida', $idCidade);

                //recupera info para auxílio da paginação e informação
                $options = $Cliente -> relatorio_1($usuario['Config']['registros_por_pagina'], $idCidade);

                //ativa tab disponível na view
                $this -> set('tab_1', 'active');

                //menu
                //título da página
                $this -> set('titulo', __('Clientes por cidade'));

            }//fim if

            //clientes por estado
            if ($this -> params['pass'][0] == 2) {

                //recupera parâmetro - com valor do id do estado
                $idEstado = $this -> params['pass'][1];

                //concatena url
                $busca = '2/' . $idEstado;
                
                //disponível na view o valor da url de busca
                $this -> set('busca', $busca);

                //recupera info para auxílio da paginação e informação
                $options = $Cliente -> relatorio_2($usuario['Config']['registros_por_pagina'], $idEstado);

                //ativa tab   disponível na view
                $this -> set('tab_2', 'active');

                //disponível na view o valor do id do estado escolhida
                $this -> set('estadoEcolhido', $idEstado);

                //menu
                //título da página
                $this -> set('titulo', __('Clientes por estado'));

            }//fim if

        } else {

            // Lista todos os clientes
            $options = $Cliente -> listagem_relatorio($usuario['Config']['registros_por_pagina']);

            //ativa tab padrão disponível na view
            $this -> set('tab_1', 'active');

            //menu
            //título da página
            $this -> set('titulo', __('Clientes'));

        }//fim if

        //Paginação - Numero de diferença entre os botões
        //utilizada na view PaginatorHelper
        $this -> set('modulus', $usuario['Config']['diferenca_entre_botoes_pag']);

        //define configurações
        $this -> paginate = $options;

        // Roda a consulta, já trazendo os resultados paginados
        $clientes = $this -> paginate('Cliente');

        //disponível os clientes do relatório
        $this -> set('clientes', $clientes);

        //total de registros tanto de busca quanto de listagem normal
        $this -> set('totalRegistros', count($clientes));

        //Breadcrumb
        $this -> set('breadcrumb', __('Relatório clientes'));

        //aqui vai ativar o menu - extender
        $this -> set('relatorios_menu', 'active');

        //aqui vai ativar o sub menu - extender
        $this -> set('relatorios_clientes_listar_sub_menu', 'active');

        //disponível na view o valor de todos os estados
        $this -> set('estados', $Estado -> listarTodosEstados());

        // pr($clientes);
        // $Cliente = new Cliente;
        // $log = $Cliente->getDataSource()->getLog(false, false);
        // debug($log);

    }//fim relatorios_clientes()

}//fim class RelatoriosController
?>