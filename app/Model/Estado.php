<?php
/**
 * Modelo de Estado - Informações
 */
App::uses('AppModel', 'Model');

class Estado extends AppModel {
	
	/**
 	* Relacionamentos
 	*/

 	// Estado tem muitas cidades	
 	var $hasMany = array('Cidade');

	/*
    * métodos ou funções personalizadas
    */	

	/**  
	*  recupera info de um determinado estado e cidade
	* @param integer $IdCidade id da cidade
	* @return array com info de cidade e estado determinado
	*/
	public function infoCidadeEstado($IdCidade) {
		
		//consulta 
		$options['joins'] = array(
			array('table' => 'cidades',
				'alias' => 'Cidade',
				'type' => 'inner',
				'conditions' => array(
					'Cidade.estado_id = estado.id',
					)
				)
			);

		//condição
		$options['conditions'] = array(
			'Cidade.id' => $IdCidade
			);

		//O CakePHP busca os dados do Grupo e de seu domínio.
		$options['recursive'] =  0;

		//retorna somente estes campos
		$options['fields'] = array('Cidade.id','Cidade.cid_nome','estado.est_sigla','estado.est_descricao');

		//retorna o array com info.
		return $this->find('all',$options);

	}//fim infoCidadeEstado()


	/**  
	* Recupera todos os estados
	* @return array de estados
	*/
	public function listarTodosEstados() {

		return $this-> find('all', array('recursive' => 0));

	}//fim listarTodosEstados()


	/**  
	* Recupera as cidades de um determinado estado
	* @param integer $idEstado id de um estado
	* @return array de cidades
	*/
	public function buscarCidades($idEstado){

		return $this -> findAllById($idEstado);

	}//fim buscarCidades()

}

?>