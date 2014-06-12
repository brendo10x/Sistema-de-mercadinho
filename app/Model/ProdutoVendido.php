<?php
/**
 * Modelo de Produtos vendidos - Informações
 */
App::uses('AppModel', 'Model');
class ProdutoVendido extends AppModel {

   //especifica o nome da tabela do banco de dados
    var $useTable = 'produtos_vendidos'; // Este modelo usa a tabela 'produtos_vendidos'
	/**
 	* Relacionamentos
 	*/
	var $belongsTo = array('Produto','Venda');
 	
	

	public function salvar_produto_vendido($dados){


		foreach ($dados['Produto'] as $key => $valor) {

			$dados['ProdutoVendido']['quantidade'] = $valor['pro_quantidade'];
			$dados['ProdutoVendido']['produto_id'] = $valor['id'];
			$dados['ProdutoVendido']['venda_id'] = $dados['Venda']['id'];

			//Ao chamar o método save em um laço, não se esqueça de chamar o método create().
	 	 	$this->create();

			$this->set($dados);
			$this->save($dados); 
		}
	
	}


}//fim class ProdutoVendido
?>