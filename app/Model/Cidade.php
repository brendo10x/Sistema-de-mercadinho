<?php
/**
 * Modelo de Cidade - Informações
 */
class Cidade extends AppModel {

	/**
 	* Relacionamentos
 	*/
	var $hasMany = array('Endereco');

	var $belongsTo = array('Estado');

	
}//fim class Cidade
?>