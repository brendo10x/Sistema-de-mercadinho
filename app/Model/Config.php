<?php
/**
 * Modelo de Config de configurações - Informações
 */
 App::uses('AppModel', 'Model');
class Config extends AppModel {

	/**  
	* Salva cofigurações
	* @param array $dados informações sorbre configuração
	* @return void
	*/
	public function salva_configuracoes($dados){

		//foto
        //processo de salvar foto upload
        // 4 = vazio - 0 = preenchido

        if ($dados['Config']['foto_sistema']['error'] == 0) {
        	
        	//gera no nome da foto
    		$nomeDaFoto = 'logomarca-sistema';

			// caminho de destino da foto
    		$destinoDaFoto = 'uploads/';

            //recupera extensão
            $ext = '.' . substr(strtolower(strrchr($dados['Config']['foto_sistema']['type'], '/')), 1); 

            //move o arquivo para a pasta destinada
            move_uploaded_file($dados['Config']['foto_sistema']['tmp_name'], IMAGES . $destinoDaFoto . $nomeDaFoto . $ext);
             
             //caminho da foto
    		$caminhoDaFoto = $destinoDaFoto . $nomeDaFoto . $ext;

         	//atualiza caminho da foto da pessoa
        	$dados['Config']['foto_sistema'] = $caminhoDaFoto;

        }else{

        	unset($dados['Config']['foto_sistema']);
        }

        //carrega dados para endereco
		$this->set($dados);

		 //atualiza
		$this->save($dados);

	}//fim salva_configuracoes()
	
	/**  
    * Salva cofigurações 
    * @return string $config['Config']['idioma'] com a apreviação da linguagem
    */
    
    public function obterLinguagem(){
        //obtem informações sobre configuração
        $config = $this->find('first');
           
        //retorna string com a apreviação da linguagem
        return $config['Config']['idioma'];
    }//fim obterLinguagem()
	
}//fim class Config
?>