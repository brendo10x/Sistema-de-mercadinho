<?php
/**
 * Modelo de Endereço - Informações
 */
App::uses('AppModel', 'Model');
class Endereco extends AppModel {

	/**
 	* Relacionamentos
 	*/
    var $hasOne = array('Vendedor','Cliente','Fornecedor');

    var $belongsTo = array('Cidade');


    /*
    * métodos ou funções personalizadas
    */

    /**  
  	* Processo de salvar endereço
  	* @param array com info
  	* @return integer id criado
  	*/	
    public function salvar($dados){

        // Criação: id não está definido ou é null
        $this->create();

  	    //salva
        $this-> save($dados);

        //recupera o id
        $idEndereco = $this-> id;

        return $idEndereco;

    }//fim salvar()

    /**  
    * Processo de excluir
    * @param array info
    * @return void
    */
    public function excluir($vendedor){

        //deleta
        $this-> delete($vendedor['Endereco']['id']);  

    }//fim excluir()

    /**  
    * Processo de atualizar
    * @param array info
    * @return void
    */
    public function atualiza($dados){

         //atualiza
        $this-> save($dados);

    }//fim atualiza()

}//fim class Endereco
?>