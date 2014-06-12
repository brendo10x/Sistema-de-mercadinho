<?php
/**
 * Modelo de Configuração de boleto - Informações
 */
class ConfigBoleto extends AppModel {

	   //especifica o nome da tabela do banco de dados
    var $useTable = 'configs_boletos'; // Este modelo usa a tabela 'configs_boletos'

    /**  
	* Organiza as configurações e armazena o valor em chaves correspondêntes
	* para poder ser acessadas nas views
	* Essas variáveis seram acessadas pelas views e pelos controlles
	* @return array 
	*/
	public function listaDeConfigBoleto(){
		
		$listaDeConfigBoleto = $this->find('all');

        //Organizando os valores de permissões
		foreach ($listaDeConfigBoleto as $key => $valor) {

			switch ($valor['ConfigBoleto']['chave']) {

				case 'taxa_boleto':
				$configBoleto['taxa_boleto']['valor'] = $valor['ConfigBoleto']['valor'];
				$configBoleto['taxa_boleto']['id'] = $valor['ConfigBoleto']['id'];

				case 'especie':
				$configBoleto['especie']['valor'] = $valor['ConfigBoleto']['valor'];
				$configBoleto['especie']['id'] = $valor['ConfigBoleto']['id'];

				case 'inicio_nosso_numero':
				$configBoleto['inicio_nosso_numero']['valor'] = $valor['ConfigBoleto']['valor'];
				$configBoleto['inicio_nosso_numero']['id'] = $valor['ConfigBoleto']['id'];

				case 'nosso_numero':
				$configBoleto['nosso_numero']['valor'] = $valor['ConfigBoleto']['valor'];
				$configBoleto['nosso_numero']['id'] = $valor['ConfigBoleto']['id'];

				case 'demonstrativo':
				$configBoleto['demonstrativo']['valor'] = $valor['ConfigBoleto']['valor'];
				$configBoleto['demonstrativo']['id'] = $valor['ConfigBoleto']['id'];

				case 'instrucoes':
				$configBoleto['instrucoes']['valor'] = $valor['ConfigBoleto']['valor'];
				$configBoleto['instrucoes']['id'] = $valor['ConfigBoleto']['id'];

				case 'agencia':
				$configBoleto['agencia']['valor'] = $valor['ConfigBoleto']['valor'];
				$configBoleto['agencia']['id'] = $valor['ConfigBoleto']['id'];

				case 'conta':
				$configBoleto['conta']['valor'] = $valor['ConfigBoleto']['valor'];
				$configBoleto['conta']['id'] = $valor['ConfigBoleto']['id'];

				case 'conta_dv':
				$configBoleto['conta_dv']['valor'] = $valor['ConfigBoleto']['valor'];
				$configBoleto['conta_dv']['id'] = $valor['ConfigBoleto']['id'];
				

            }//fim switch

         }//fim foreach

        return array('ConfigBoleto'=>$configBoleto);

	}//fim organizaPermissoes()


	public function salva_configuracao_boleto($dados){

		// define valores	
		$this->set($dados);

		foreach ($dados as $key => $valor) {
			
			//atualiza
			$this->save($valor);

		}//fim atualiza_permissoes()
	}
	
}//fim class ConfigBoleto
?>