<?php
/**
 * Modelo de Pessoa - Informações
 */
App::uses('AppModel', 'Model');

class Pessoa extends AppModel {

    /**
     * Relacionamentos
     */
    public $hasOne = array(
    'Vendedor' => array('className' => 'Vendedor', 'dependent' => true),
    'Proprietario' => array('className' => 'Proprietario', 'dependent' => true),
    'Cliente' => array('className' => 'Cliente', 'dependent' => true),
    'Fornecedor' => array('className' => 'Fornecedor', 'dependent' => true)
    
    );

    /*
     * métodos ou funções personalizadas
     */

    /**
     * Valida se existe cpf ou cnpj menos o registro que está solicitando
     * @param array $data cpf ou cnpj
     * @return boolean
     */
    public function validaSeExisteCPFouCNPJ_editar($dados) {

        //consulta
        $registros = $this -> find('all', array('conditions' => array('Pessoa.id  <>' => $dados['id']), 'recursive' => -1, 'fields' => array('Pessoa.pes_cpf_ou_cnpj')));

        foreach ($registros as $key => $banco) {

            if ($banco['Pessoa']['pes_cpf_ou_cnpj'] == $dados['pes_cpf_ou_cnpj']) {

                //pr('É igual');
                return false;

            } else {

                //pr('Não é igual');
                return true;

            }//fim if

        }//fim foreach

    }//fim validaSeExisteCPFouCNPJ_editar()

    /**
     * auxilia na validação de cnpj
     * @param string $string
     * @return string
     */
    private function replace($string) {

        return $string = str_replace('/', '', str_replace('-', '', str_replace('.', '', $string)));

    }//fim replace()

    /**
     * auxilia na validação de cnpj
     * @param string $string palavra
     * @param string $length tamanho
     * @return boolean
     */
    private function check_fake($string, $length) {

        for ($i = 0; $i <= 9; $i++) {
            $fake = str_pad('', $length, $i);
            if ($string === $fake)
                return (1);
        }//fim for

    }//fim check_fake()

    /**
     * Processo de validação de cpf
     * @param string $cpf CPF
     * @return boolean se TRUE é válido se FALSE não é válido
     */
    function cpf($cpf) {

        // Verifica se um número foi informado
        if (empty($cpf)) {
            return false;
        }

        // Elimina possivel mascara
        $cpf = ereg_replace('[^0-9]', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados é igual a 11
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se nenhuma das sequências invalidas abaixo
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
            return false;
            // Calcula os digitos verificadores para verificar se o
            // CPF é válido
        } else {

            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }

    }//fim cpf()

    //função que valida cnpj
    public function cnpj($cnpj) {
        $sum = 0;
        $cnpj = $this -> replace($cnpj);
        $cnpj = trim($cnpj);
        if (empty($cnpj) || strlen($cnpj) != 14)
            return FALSE;
        else {
            if ($this -> check_fake($cnpj, 14))
                return FALSE;
            else {
                $rev_cnpj = strrev(substr($cnpj, 0, 12));
                for ($i = 0; $i <= 11; $i++) {
                    $i == 0 ? $multiplier = 2 : $multiplier;
                    $i == 8 ? $multiplier = 2 : $multiplier;
                    $multiply = ($rev_cnpj[$i] * $multiplier);
                    $sum = $sum + $multiply;
                    $multiplier++;
                }
                $rest = $sum % 11;
                if ($rest == 0 || $rest == 1)
                    $dv1 = 0;
                else
                    $dv1 = 11 - $rest;
                $sub_cnpj = substr($cnpj, 0, 12);
                $rev_cnpj = strrev($sub_cnpj . $dv1);
                unset($sum);
                $sum = 0;
                for ($i = 0; $i <= 12; $i++) {$i == 0 ? $multiplier = 2 : $multiplier;
                    $i == 8 ? $multiplier = 2 : $multiplier;
                    $multiply = ($rev_cnpj[$i] * $multiplier);
                    $sum = $sum + $multiply;
                    $multiplier++;
                }
                $rest = $sum % 11;
                if ($rest == 0 || $rest == 1)
                    $dv2 = 0;
                else
                    $dv2 = 11 - $rest;
                if ($dv1 == $cnpj[12] && $dv2 == $cnpj[13])
                    return TRUE;
                else
                    return FALSE;
            }//fim if
        }//fim if

    }//fim cnpj()

    /**
     * Processo de salvar pessoa
     * @param array de dados
     * @return integer o id criado
     */
    public function salvar($dados) {

        //foto canvas -> $dados['Pessoa']['foto'][1]
        //foto upload -> $dados['Pessoa']['foto'][0]
        // $dados['Pessoa']['foto'][0]['error'] == 4 é vazio

        // Criação: id não está definido ou é null
        $this -> create();

        //gera no nome da foto
        $nomeDaFoto = (uniqid(time()));

        // caminho de destino da foto
        $destinoDaFoto = 'uploads/';

        //processo de salvar foto upload
        // 4 = vazio - 0 = preenchido
        if ($dados['Pessoa']['foto'][0]['error'] == 0) {

            //recupera extensão
            $ext = '.' . substr(strtolower(strrchr($dados['Pessoa']['foto'][0]['type'], '/')), 1);

            //move o arquivo para a pasta destinada
            move_uploaded_file($dados['Pessoa']['foto'][0]['tmp_name'], IMAGES . $destinoDaFoto . $nomeDaFoto . $ext);

        } else {

            // extensão permitida para canvas
            $ext = '.png';

            //processo de salvar foto canvas
            $unencodedData = base64_decode($dados['Pessoa']['foto'][1]);

            //detino do arquivo de imagem
            $fp = fopen(IMAGES . $destinoDaFoto . $nomeDaFoto . $ext, 'wb');

            //escreve no arquivo de imagem
            fwrite($fp, $unencodedData);

            //fecha o arquivo de imagem
            fclose($fp);

        }//fim if

        //caminho da foto
        $caminhoDaFoto = $destinoDaFoto . $nomeDaFoto . $ext;

        // destroi importante
        unset($dados['Pessoa']['foto']);

        //atualiza caminho da foto da pessoa
        $dados['Pessoa']['pes_foto'] = $caminhoDaFoto;

        //salva
        $this -> save($dados);

        //recupera o id
        $idPessoa = $this -> id;

        return $idPessoa;

    }//fim salvar()

    /**
     * Processo de excluir
     * @param array info
     * @return void
     */
    public function excluir($pessoa) {

        //deleta
        $this -> delete($pessoa['Pessoa']['id']);

        //deleta foto de pessoa
        unlink(IMAGES . $pessoa['Pessoa']['pes_foto']);

    }//fim excluir()

    /**
     * Processo de atualizar
     * @param array info
     * @return void
     */
    public function atualiza($dados) {

        //foto canvas -> $dados['Pessoa']['foto'][1]
        //foto upload -> $dados['Pessoa']['foto'][0]
        // $dados['Pessoa']['foto'][0]['error'] == 4 é vazio

        //  0 = preenchido
        if ($dados['Pessoa']['foto'][0]['error'] == 0 && !empty($dados['Pessoa']['foto'][0]) || !empty($dados['Pessoa']['foto'][1])) {

            // deleta foto
            unlink(IMAGES . $dados['Pessoa']['pes_foto']);

            //gera no nome da foto
            $nomeDaFoto = (uniqid(time()));

            // caminho de destino da foto
            $destinoDaFoto = 'uploads/';

            //processo de salvar foto upload

            // 4 = vazio - 0 = preenchido
            if (!empty($dados['Pessoa']['foto'][1])) {

                // extensão permitida para canvas
                $ext = '.png';

                //processo de salvar foto canvas
                $unencodedData = base64_decode($dados['Pessoa']['foto'][1]);

                //detino do arquivo de imagem
                $fp = fopen(IMAGES . $destinoDaFoto . $nomeDaFoto . $ext, 'wb');

                //escreve no arquivo de imagem
                fwrite($fp, $unencodedData);

                //fecha o arquivo de imagem
                fclose($fp);

            } else {

                //recupera extensão
                $ext = '.' . substr(strtolower(strrchr($dados['Pessoa']['foto'][0]['type'], '/')), 1);

                //move o arquivo para a pasta destinada
                move_uploaded_file($dados['Pessoa']['foto'][0]['tmp_name'], IMAGES . $destinoDaFoto . $nomeDaFoto . $ext);

            }//fim if

            //caminho da foto
            $caminhoDaFoto = $destinoDaFoto . $nomeDaFoto . $ext;

            // destroi importante
            unset($dados['Pessoa']['foto']);

            //atualiza caminho da foto da pessoa
            $dados['Pessoa']['pes_foto'] = $caminhoDaFoto;

        }//fim if

        //atualiza
        $this -> save($dados);

    }//fim atualiza()

}// fim classe Pessoa
?>