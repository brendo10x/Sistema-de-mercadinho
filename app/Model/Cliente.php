<?php
/**
 * Modelo de Cliente - Informações
 */
App::uses('AppModel', 'Model');
class Cliente extends AppModel {

    /*
     * Relacionamentos
     */
    // belongsTo: o model atual contém a chave estrangeira.
    var $belongsTo = array('Endereco', 'Pessoa');

    /*
     * métodos ou funções personalizadas
     */

    /**
     * Processo de salvar cliente
     * @param array $dados informações sobre cliente, endereço e pessoa.
     * @return void
     */
    public function salvar_cliente($dados) {

        // Criação: id não está definido ou é null
        $this -> create();

        //salva e recupera o id criado
        $idPessoa = $this -> Pessoa -> salvar($dados);

        //atualiza a posição do array com o id
        $dados['Cliente']['pessoa_id'] = $idPessoa;

        //salva e recupera o id criado
        $IdEndereco = $this -> Endereco -> salvar($dados);

        //atualiza a posição do array com o id
        $dados['Cliente']['endereco_id'] = $IdEndereco;

        //salva
        $this -> save($dados);

    }//fim salvar_cliente()

    /**
     * Processo de excluir cliente
     * @param integer $idCliente id do cliente
     * @return void
     */
    public function excluir_cliente($idCliente) {

        //obtem informações
        $cliente = $this -> findById($idCliente);

        //deleta
        $this -> delete($idCliente);

        //deleta
        $this -> Endereco -> excluir($cliente);

        //deleta
        $this -> Pessoa -> excluir($cliente);

    }//fim excluir_cliente()

    /**
     * Processo de atualizar cliente
     * @param array $dados informações sobre cliente,endereço e pessoa.
     * @return void
     */
    public function atualizar_cliente($dados) {

        //atualiza
        $this -> Pessoa -> atualiza($dados);

        //atualiza
        $this -> Endereco -> atualiza($dados);

        //atualiza
        $this -> save($dados);

    }//fim atualizar_cliente()

    /**
     * Função que busca Cliente por nome
     * @param string $nomeCliente nome do forneceodor
     * @return array de Clientees
     */
    public function buscaPorNome($nomeCliente) {

        //consulta
        $options['joins'] = array( array('table' => 'pessoas', 'alias' => 'Pessoas', 'type' => 'inner', 'conditions' => array('Cliente.pessoa_id = Pessoas.id', )));

        //O CakePHP busca os dados do Grupo e de seu domínio.
        $options['recursive'] = 0;

        //Condições
        $options['conditions'] = array('Pessoas.pes_nome LIKE' => "%" . $nomeCliente . "%");

        //retorna somente estes campos
        $options['fields'] = array('Cliente.id', 'Pessoas.pes_nome');

        $resultados = $this -> find('all', $options);

        if (count($resultados) == 0) {
            return array(0 => 0);
        }
        //retorna o array com info.
        return $resultados;

    }//fim buscaPorNome()

    /**
     * Retorna o total de produtos
     * @return integer
     */
    public function total_clientes() {

        return $this -> find('count');

    }//fim total_clientes()

    /**
     * Relatório 1
     *  Descrição: Armazenar os valores nos índices do array - Listas todos as clientes de uma determinada cidade
     *
     * @param $limit - limite, $idCidade - Id da cidade
     * @return array $options com os opções
     */
    public function relatorio_1($limit, $idCidade) {

        // união
        $options['joins'] = array( array('table' => 'enderecos', 'alias' => 'end', 'type' => 'inner', 'conditions' => array('end.id = Cliente.endereco_id', )), array('table' => 'cidades', 'alias' => 'cid', 'type' => 'inner', 'conditions' => array('end.cidade_id = cid.id')), array('table' => 'estados', 'alias' => 'est', 'type' => 'inner', 'conditions' => array('cid.estado_id = est.id')));

        //campos retornados
        $options['fields'] = array('Cliente.id', 'Pessoa.pes_nome', 'cid.cid_nome ', 'est.est_descricao');

        $options['conditions'] = array('cid.id = ?' => array($idCidade));

        // registros por página
        //utilizada aqui pelo PaginatorComponent
        $options['limit'] = $limit;

        return $options;

    }//fim relatorio_1()

    /**
     * Relatório 2
     * Descrição: Armazenar os valores nos índices do array - - Listas todos as clientes de uma determinada estado
     * @param $limit - limite, $idEstado - id o estado
     * @return array $options com os opções
     */
    public function relatorio_2($limit, $idEstado) {

        // união
        $options['joins'] = array( array('table' => 'enderecos', 'alias' => 'end', 'type' => 'inner', 'conditions' => array('end.id = Cliente.endereco_id', )), array('table' => 'cidades', 'alias' => 'cid', 'type' => 'inner', 'conditions' => array('end.cidade_id = cid.id')), array('table' => 'estados', 'alias' => 'est', 'type' => 'inner', 'conditions' => array('cid.estado_id = est.id')));

        //campos retornados
        $options['fields'] = array('Cliente.id', 'Pessoa.pes_nome', 'cid.cid_nome ', 'est.est_descricao');

        //condição
        $options['conditions'] = array('est.id = ?' => array($idEstado));

        // registros por página
        //utilizada aqui pelo PaginatorComponent
        $options['limit'] = $limit;

        return $options;

    }//fim relatorio_2()

    /**
     * Listar informações sobre cliente normal com os
     * campos 'Cliente.id','Pessoa.pes_nome', 'cid.cid_nome ','est.est_descricao'
     * @param $limit - limite
     * @return array $options com os opções
     */
    public function listagem_relatorio($limit) {

        // união
        $options['joins'] = array( array('table' => 'enderecos', 'alias' => 'end', 'type' => 'inner', 'conditions' => array('end.id = Cliente.endereco_id', )), array('table' => 'cidades', 'alias' => 'cid', 'type' => 'inner', 'conditions' => array('end.cidade_id = cid.id')), array('table' => 'estados', 'alias' => 'est', 'type' => 'inner', 'conditions' => array('cid.estado_id = est.id')));

        //campos retornados
        $options['fields'] = array('Cliente.id', 'Pessoa.pes_nome', 'cid.cid_nome ', 'est.est_descricao');

        // registros por página
        //utilizada aqui pelo PaginatorComponent
        $options['limit'] = $limit;

        return $options;

    }//fim relatorio_2()

    /**
     * Listagem de clientes
     * @param integer $limit - limite, $busca- busca
     * @return array com informação do cliente
     */
    public function listagem($limit, $busca) {

        //campos retornados
        $options['fields'] = array('Cliente.id', 'Pessoa.pes_nome', 'Pessoa.pes_telefone');

        // registros por página
        //utilizada aqui pelo PaginatorComponent
        $options['limit'] = $limit;

        // valores agregados
        $options['recursive'] = 2;

        //condição de busca
        if (!empty($busca)) {

            $options['conditions'] = array('Pessoa.pes_nome LIKE' => '%' . $busca . '%');
            
        }//fim if

        return $options;

    }//fim listagem()

}//fim class Cliente
?>