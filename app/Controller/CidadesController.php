<?php

/**
 *	Controle
 */

class CidadesController extends AppController {


	 // modelos adicionais disponíveis para este Controller
     var $uses = array('Cidade','Estado');


	/**  
	* Recupera todas as cidades de um determinado estado
	* @param integer do GET $this->request->query['term'] id do estado 
	* @return json de cidades
	*/
	public function buscarJson() {
		
		//recebe valor do parâmetro
		$idEstado =  $this->request->query['term'];

		//recupera uma lista de cidades
		$cidades = $this -> Estado -> buscarCidades($idEstado);
		
		//FALSE não permite rederizar o nome do método em uma página .ctp
		//pois somente queremos que retorne o conteúdo
		$this->autoRender = false;

		//define layout da página ou seja vazía
        $this->layout = "ajax";
		
		return  json_encode($cidades);

	}//fim buscarJson()

}//fim class CidadesController
?>