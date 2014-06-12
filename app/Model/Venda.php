<?php
/**
 * Modelo de Venda - Informações
 */
App::uses('Produto', 'Model');
App::uses('ProdutoVendido', 'Model');
App::uses('Financeiro', 'Model');
App::uses('AppModel', 'Model');
class Venda extends AppModel {

	/**
 	* Relacionamentos
 	*/
	var $belongsTo = array('Cliente','Vendedor');

    // dica $hasMany no meu caso serviu para excluir os associados
    // o dependent só posse ser usados nos relacionamentos que tem  a variável
    // $hasMany, $hasOne e $hasAndBelongsToMany
   var $hasMany = array(

    'Parcela' => array(
        'className'    => 'Parcela',
        'dependent'    => true),

    'ProdutoVendido' => array(
        'className'    => 'ProdutoVendido',
        'dependent'    => true)

    );

	/*
    * métodos ou funções personalizadas
    */

    /**  
    * Processo de salvar Venda
    * @param array $dados informações sobre Venda
    * @return void
    */
    public function salvar_venda($dados) {
        
        $this->set($dados);

        //1º salvo venda
       // $dados['Venda']['data'] = date("d/m/Y");

        $this->save($dados);

        $idVenda = $this->id;
        $dados['Venda']['id'] = $idVenda;
        
        //2º atualizar quantidade do produto
        $Produto = new Produto;
        $Produto->atualizar_produto_quantd($dados);

        //3º salva produto vendido
        $ProdutoVendido = new ProdutoVendido;
        $ProdutoVendido->salvar_produto_vendido($dados);

        // ven_forma_pagamento 0 - á vista 1 - prazo
        if ($dados['Venda']['ven_forma_pagamento'] == 1) {
        
            //3º salva parcelas
            // atualiza a data
            $dados['Parcela']['venda_id'] = $idVenda;

            //salva parcela
            $this -> Parcela -> salva_parcela($dados);

            }else{
                
        //adiciona o valor total no financeiro
        $financeiro = new Financeiro;

        $financeiro->adicionar_total($dados['Venda']['ven_total']);
        
        }//fim if

    }//fim salvar_venda()
    
    /*
    * Antes da busca (find), formatando o parâmetro ['Venda']['ven_forma_pagamento'] 
    * para uma string util
    */
    public function afterFind($results) {

        foreach ($results as $key => $val) {

            if (isset($results[$key]['Venda']['ven_forma_pagamento'])) {

                //ven_forma_pagamento 0 - á vista 1 - prazo
                if ($results[$key]['Venda']['ven_forma_pagamento'] == 1) {
                      $results[$key]['Venda']['ven_forma_pagamento'] = __('Prazo');
                }else{
                    $results[$key]['Venda']['ven_forma_pagamento'] = __('Á vista') ;
                }//fim if
                
            }//fim if

        }//fim foreach

        return $results;

    }//fim afterFind()

     /**  
    * Processo de excluir venda
    * @param integer $idvenda id do venda
    * @return void
    */
    public function excluir_venda($idvenda){


         //obtem informações  
        $venda = $this->findById($idvenda); 

        //deleta
        $this -> delete($idvenda,true);  
      
    }//fim excluir_venda(()

    /**  
    * Retorna o total de vendas
    * @return integer
    */
    public function total_vendas(){

       return $this->find('count');
    }//fim total_vendas()


    /**  
    * Relatório 1  
    *  Descrição: Armazenar os valores nos índices do array
    *  
    * @param $limete - limite, $data - data da consulta
    * @return array $options com os opções
    */
    public function relatorio_1($limit,$data){
        
        
         //consulta 
        $options['joins'] = array(
            array('table' => 'vendedores',
                'alias' => 'Vendedores',
                'type' => 'inner',
                'conditions' => array(
                    'Venda.vendedor_id = Vendedores.id',
                    )
                ),
            array('table' => 'Pessoas',
                'alias' => 'Pessoas',
                'type' => 'inner',
                'conditions' => array(
                    'Vendedores.pessoa_id = Pessoas.id',
                    )
                )
            );
            
        //campos retornados
        $options['fields'] = array('Venda.id', 'Venda.ven_total','Venda.data','Pessoas.pes_nome');
        
        
        // registros por página
        //utilizada aqui pelo PaginatorComponent
        $options['limit'] = $limit;

        // valores agregados
        $options['recursive'] = 2;
        
        if (!empty($data)) {
             
            //condição
            $options['conditions'] = array('Venda.data LIKE' => '%'.$data.'%');
        
        }//fim if
        
        return $options;

    }//fim relatorio_1()

    /**  
    * Relatório 2 
    *  Descrição: Armazenar os valores nos índices do array
    *  
    * @param $limete - limite, $data - data da consulta
    * @return array $options com os opções
    */
    public function relatorio_2($limit,$data,$idVendedor){
        
         // registros por página
        //utilizada aqui pelo PaginatorComponent
        $options['limit'] = $limit;

        // valores agregados
        $options['recursive'] = 2;

        //condição
        $options['conditions'] = array( 'vendedores.id = ? AND Venda.data like ?'  => array($idVendedor,'%'. $data .'%') );
        
         //campos retornados
        $options['fields'] = array('Venda.id', 'Venda.ven_total','Venda.data','Pessoas.pes_nome');
        
        
       //consulta 
        $options['joins'] = array(
            array('table' => 'vendedores',
                'alias' => 'Vendedores',
                'type' => 'inner',
                'conditions' => array(
                    'Venda.vendedor_id = Vendedores.id',
                    )
                ),
            array('table' => 'Pessoas',
                'alias' => 'Pessoas',
                'type' => 'inner',
                'conditions' => array(
                    'Vendedores.pessoa_id = Pessoas.id',
                    )
                )
            );

        return $options;

    }//fim relatorio_1()
    
    
    /**  
    * Listagem de vendas
    * @param integer $limit - limite, $busca - busca
    * @return array com informação da venda
    */
    public function listagem($limit,$busca){
        
        //campos retornados
        $options['fields'] = array('Venda.id', 'Venda.ven_total','Venda.ven_forma_pagamento','Venda.data');
        
        // registros por página
        //utilizada aqui pelo PaginatorComponent
        $options['limit'] = $limit;
        
        // valores agregados
        $options['order'] = 'Venda.data DESC';
        
        // valores agregados
        $options['recursive'] = 2;
         
         //condição de busca
        if (!empty($busca)) {
            
            $options['conditions'] = array('Venda.data LIKE' => '%'. $busca .'%');
        }//fim if
      
        return $options;
        
    }//fim listagem()
    
}//fim class Venda
?>