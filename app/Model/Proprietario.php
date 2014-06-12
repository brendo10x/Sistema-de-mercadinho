<?php
/**
 * Modelo de Proprietário - Informações
 */
App::uses('AppModel', 'Model');
class Proprietario extends AppModel {


    /*
    * Relacionamentos
    */
    var $belongsTo = array('Pessoa', 'Usuario');


    /*
    * métodos ou funções personalizAadas
    */


    /**  
    * Processo de atualizar proprietário
    * @param array $dados informações sobre Proprietário,
    * usuário e pessoa.
    * @return void
    */
    public function atualizar_proprietario($dados){

        //atualiza
        $this-> Pessoa->atualiza($dados);

        //atualiza
        $this -> Usuario -> atualiza($dados);

        //carrega os dados para proprietário
        $this -> set($dados);

        //atualiza
        $this -> save($dados);

    }//fim atualizar_proprietario()

}//fim class Proprietario
?>