<?php
/**
 * Modelo de financeiro - Informações
 */
App::uses('AppModel', 'Model');
class Financeiro extends AppModel {

    /**
     * Adiciona total
     * @param double $valor_total_venda total
     * @return void
     */
    public function adicionar_total($valor_total_venda) {

        $financeiro = $this -> find('first');

        if (!empty($financeiro)) {
            $financeiro['Financeiro']['valor_total'] = $financeiro['Financeiro']['valor_total'] + $valor_total_venda;
            $this -> id = $financeiro['Financeiro']['id'];

        } else {
            
            $financeiro['Financeiro']['valor_total'] = $valor_total_venda;
            
        }//fim if

        $this -> set($financeiro);
        $this -> save($financeiro);

    }//fim adicionar_total()
    
    /*
     * Atualiza total
    */
    public function atualizar_total($dados) {
        $this -> set($dados);
        $this -> save($dados);
    }//fim atualizar_total()

}//fim class Finnncia
?>