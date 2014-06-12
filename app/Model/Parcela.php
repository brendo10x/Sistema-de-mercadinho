<?php
/**
 * Modelo de Parcela - Informações
 */
App::uses('Financeiro', 'Model');
App::uses('AppModel', 'Model');
class Parcela extends AppModel {

    /**
     * Relacionamentos
     */

    var $belongsTo = array('Venda');

    /**
     * Salva parcelas
     * @param parametro
     * @return parametro
     */
    public function salva_parcela($dados) {

        //define valores
        $this -> set($dados);

        $numeroParcelas = $dados['Parcela']['numero'];

        //destrói índice
        unset($dados['Parcela']['numero']);

        $numDias = 30;

        for ($i = 0; $i < $numeroParcelas; $i++) {

            //Ao chamar o método save em um laço, não se esqueça de chamar o método create().
            $this -> create();

            $data = new DateTime('+' . $numDias . ' day');

            $dados['Parcela']['data'] = $data -> format('Y-m-d');

            //(0 - sim) (1 - não)
            $dados['Parcela']['pago'] = 1;

            //salva parcela
            $this -> save($dados);

            //incrementa cada parcela mais 30 dias
            $numDias = $numDias + 30;

        }

    }

    public function afterFind($results) {

        foreach ($results as $key => $val) {

            if (isset($results[$key]['Parcela']['pago'])) {

                //pago (0 - sim) (1 - não)
                if ($results[$key]['Parcela']['pago'] == 1) {
                    $results[$key]['Parcela']['pago'] = __('Não');
                } else {
                    $results[$key]['Parcela']['pago'] = __('Sim');
                }

            }//fim if

        }//fim foreach

        return $results;

    }//fim afterFind()

    public function pagar_parcela($idParcela) {

        $parcela = $this -> findById($idParcela);
        //pago (0 - sim) (1 - não)
        $parcela['Parcela']['pago'] = 0;

        $this -> set($parcela);

        $this -> save($parcela);

        //adiciona o valor total no financeiro
        $Financeiro = new Financeiro;

        $Financeiro -> adicionar_total($parcela['Parcela']['valor']);

    }

}//fim class Parcela
?>