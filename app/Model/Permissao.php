<?php
/**
 * Modelo de Cidade - Informações
 */
class Permissao extends AppModel {

	//especifica o nome da tabela do banco de dados
	var $useTable = 'permissoes'; // Este modelo usa a tabela 'permissoes'

	/*
    * métodos ou funções personalizadas
    */

	/**  
	* Ação de atualizar status de permissão
	* permitido (0 - sim) (1 = não)
	* @param array $dados informações de permissão
	* @return void
	*/
	public function atualiza_permissoes($dados){
		
		// define valores	
		$this->set($dados);

		foreach ($dados as $key => $valor) {
			
			//atualiza
			$this->save($valor);

		}//fim atualiza_permissoes()

	}//fim atualiza_permissoes()


	/**  
	* Organiza as permissões e armazena o valor em chaves correspondêntes
	* para poder ser acessadas nas views
	* Essas variáveis seram acessadas pelas views e pelos controlles
	* @return array 
	*/
	public function listaDePermissoes(){
		
		$listaPermissoes = $this->find('all');

        //Organizando os valores de permissões
		foreach ($listaPermissoes as $key => $valor) {

			switch ($valor['Permissao']['controle']) {

				case 'VendedoresController':
				$permissao['VendedoresController'] = $valor['Permissao'];

				case 'ClientesController':
				$permissao['ClientesController'] = $valor['Permissao'];

				case 'FornecedoresController':
				$permissao['FornecedoresController'] = $valor['Permissao'];

				case 'ProdutosController':
				$permissao['ProdutosController'] = $valor['Permissao'];

				case 'VendasController':
				$permissao['VendasController'] = $valor['Permissao'];

				case 'ConfigsBoletosController':
				$permissao['ConfigsBoletosController'] = $valor['Permissao'];

				case 'FinanceirosController':
				$permissao['FinanceirosController'] = $valor['Permissao'];

				case 'RelatoriosController':
				$permissao['RelatoriosController'] = $valor['Permissao'];
				

            }//fim switch

         }//fim foreach

        return array('Permissoes'=>$permissao);

	}//fim organizaPermissoes()

}//fim class Permissao
?>