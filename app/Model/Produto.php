<?php
/**
 * Modelo de Produto - Informações
 */
App::uses('AppModel', 'Model');
App::uses('BarCodeGenrator', 'Lib');

class Produto extends AppModel {
	

	/**
 	* Relacionamentos
 	*/
 	// o model atual contém a chave estrangeira.
 	var $belongsTo = array('Fornecedor');

 	/**  
 	* Processo de salvar produto
 	* @param array $dados informações sobre o produto
 	* @return void 
 	* Informações sobre BarCodeGenrator
	* Link de explicação na integra-> http://taylorlopes.com/?p=407 
	* Os parâmetros, como você já deve ter observado, indicam respectivamente:
	*(1°) Os dígitos que você deseja usar para formar o código de barra
	*(2°) A forma de exibição: 0 = Gera a saída direto na tela do script | 1 = Salva o arquivo em disco
	*(3°) O nome do arquivo. Pode-se usar o caminho absoluto seguido do nome para indicar onde o arquivo será salvo.
	*(4°) A largura da barra. Exemplo: 190 pixels (informe apenas o número).
	*(5°) A altura da barra. Exemplo: 130 pixels (informe apenas o número).
	*(6°) Se vai querer ou não exibir na etiqueta/imagem o número do código. true = exibe, e false = não.
	*/
	public function salvar_produto($dados){

		// define valores
		$this->set($dados);

	 	//salvar a imagem do código de barras
		new BarCodeGenrator($dados['Produto']['pro_codigo_barras'],1,IMAGES.'codigoBarras/'.$dados['Produto']['pro_codigo_barras'].'.png', 190, 130, true);

		//salva
		$this->save($dados);

	}//fim salvar_produto()

	/**  
	* Processo de atualiza produto
	* @param array dados informações sobre o produto e o id do produto 
	* @return void
	*/
	public function atualizar_produto($dados){
		// define valores
		$this->set($dados);

		//verifica se arquivo existe
		if(!file_exists(IMAGES.'codigoBarras/'.$dados['Produto']['pro_codigo_barras'].'.png')){

			//salvar a imagem do código de barras
			new BarCodeGenrator($dados['Produto']['pro_codigo_barras'],1,IMAGES.'codigoBarras/'.$dados['Produto']['pro_codigo_barras'].'.png', 190, 130, true);

		}//fim if

		//salva
		$this->save($dados);

	}//fim atualizar_produto()

	/**  
    * Processo de excluir produto
    * @param integer $idProduto id do produto
    * @return void
    */
    public function excluir_produto($idProduto){

        //obtem informações  
        $produto = $this->findById($idProduto); 

        //deleta
        $this -> delete($idProduto);  
  

         //deleta foto de pessoa
        unlink(IMAGES.'codigoBarras/'.$produto['Produto']['pro_codigo_barras'].'.png'); 

    }//fim excluir_produto()


    /**  
    * Função que busca Produto por nome ou pelo código de barras
    * @param string $nomeProduto nome do produto
    * @return array de Produtoes
    */
    public function buscaPorNomeCodigoBarras($consulta){
        
        //Condições
        $options['conditions'] = array(
            'Produto.pro_nome LIKE' => "%".$consulta."%"
        );

     	//retorna somente estes campos
        $options['fields'] = array('Produto.id','Produto.pro_nome','Produto.pro_preco','Produto.pro_quantidade');


        $resultados = $this->find('all',$options);

        if (count($resultados) == 0) {
          
             //Condições
            $options['conditions'] = array(
                'Produto.pro_codigo_barras ' => $consulta
            );

            //retorna somente estes campos
            $options['fields'] = array('Produto.id','Produto.pro_nome','Produto.pro_preco','Produto.pro_quantidade');


            $resultados = $this->find('all',$options);

        }
      
         if (count($resultados) == 0) {
           return  array( 0=>0);
         }
      
        //retorna o array com info.
        return  $resultados;

    }//fim buscaPorNome()


    /**  
    * Atualiza a quantidade comprada
    * @param parametro
    * @return parametro
    */
    public function atualizar_produto_quantd($dados){
    	 

    	 foreach ($dados['Produto'] as $key => $valor) {

    	 //defino id a ser alterado
    	 $this->id=$valor['id'];

    	 //recupero produto
    	 $produto = $this->findById($valor['id']);

    	 //subtrai o valor do banco que o valor recebido do formulário
    	 $quantidade = $produto['Produto']['pro_quantidade'] - $valor['pro_quantidade'];

    	 //atualiza quantidade
    	 $this->saveField('pro_quantidade', $quantidade);

    	 }
    }

    /**  
    * Retorna o total de produtos
    * @return integer
    */
    public function total_produtos(){

       return $this->find('count');
    
    }//fim total_produtos()()

    /**  
    * Relatório 1
    *  Descrição: Armazenar os valores nos índices do array - Produtos mais vendidos
    * 
    * @param $limete - limite, $data - data da consulta
    * @return array $options com os opções
    */
    public function relatorio_1($limit,$data){

        //campos retornados
       $options['fields'] = array('Produto.*', 'SUM( p_v.quantidade ) AS quantidade_vendido');

        //Condição
       $options['conditions'] = array( 'p_v.produto_id = Produto.id AND v.data like ?'  => array('%'.$data.'%'));

        //grupo
       $options['group'] = array('Produto.pro_nome');

        //ordem
       $options['order'] = 'quantidade_vendido  DESC';

        // registros por página
        //utilizada aqui pelo PaginatorComponent
       $options['limit'] = $limit;

        //dados agregados
       $options['recursive'] = -1;

        //união
       $options['joins'] = array(
        array('table' => 'produtos_vendidos ',
            'alias' => 'p_v',
            'type' => 'inner',
            'conditions' => array(
                'p_v.produto_id = Produto.id',
                )
            ),
        array('table' => 'vendas',
            'alias' => 'v',
            'type' => 'inner',
            'conditions' => array(
                'p_v.venda_id = v.id'
                )
            )
        );

       return $options;
       
    }//fim relatorio_1()
    
      /**  
    * Listagem de produtos
    * @param integer $limit - limite, $busca- busca
    * @return array com informação do produto
    */
    public function listagem($limit,$busca){
        
         //campos retornados
        $options['fields'] = array('Produto.id', 'Produto.pro_nome','Produto.pro_preco');
        
        // registros por página
        //utilizada aqui pelo PaginatorComponent
        $options['limit'] = $limit;
        
       

        // valores agregados
        $options['recursive'] = 2;
        
         //condição de busca
        if (!empty($busca)) {
            
            $options['conditions'] = array('Produto.pro_nome LIKE' => '%'. $busca .'%');
        }//fim if
      
        return $options;
        
    }//fim listagem()
    
}//fim class Produto

?>