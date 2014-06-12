

<?php
/**
 * Modelo de usuário - Informações
 */
App::uses('AppModel', 'Model');
App::uses('Config', 'Model');
App::uses('Permissao', 'Model');
App::uses('Security', 'Utility');

class Usuario extends AppModel {

    /**
     * Relacionamentos
     */

     var $hasOne = array('Vendedor','Proprietario');

    /*
     * métodos ou funções personalizadas
     */

    
    /**  
    * Validação de login, senha e email de usuário
    * retornando informações importantes se credenciado
    * @param array de dados senha e email
    * @return array com info importantes pessoa, domínio(se vendedor ou proprietário) e configuração
    */   
    public function validaLogin($dados){
       
        // recupera usuário atravéz do email, pois ele é único
        $infoUsuario = $this->findByEmail($dados['Usuario']['email']);

        //'Existe' e senha ser igual informada;
        if (!empty($infoUsuario) && $dados['Usuario']['senha'] == $infoUsuario['Usuario']['senha']) {

            //Existe usuário

            // (0 - proprietário)  (1 - vendedor)

             //carrega modelo
            $config = new Config();
            
            //informações sobre configuração
            $infoConfiguracao = $config ->find('first');
            
             //carrega modelo
            $permissao = new Permissao();

            //informações sobre permissões
            $infoPermissoes = $permissao->listaDePermissoes();

            // é proprietário
            if ($infoUsuario['Usuario']['tipo'] == 0) {

                //recupero info - só quero mesmo o id dele para usar no editar
                $infoProprietario = $this-> Proprietario-> findById($infoUsuario['Proprietario']['id']);

                // por segurança a senha é excluída
                unset($infoProprietario['Usuario']['senha']);

                //mescla as informações de proprietário, pessoa, usuário e configurações
                $infoCompleta = array_merge( $infoProprietario,$infoConfiguracao,$infoPermissoes);

                //retorna info
                return $infoCompleta;

            }//fim if

            // é vendedor
            if ($infoUsuario['Usuario']['tipo'] == 1) {

                //recupero valores de pessoa e vendedor completo
                $infoVendedor = $this-> Vendedor->findById($infoUsuario['Vendedor']['id']);

                 // por segurança a senha é excluída
                unset($infoVendedor['Usuario']['senha']);

                //mescla as informações de pessoa e tipo de usuário 
                $infoCompleta = array_merge($infoVendedor,$infoConfiguracao,$infoPermissoes);

                //retorna info
                return $infoCompleta;

            }//fim if

            
        }else{

            //'Não Existe';
            //retorna vazio
            return array();

        }//fim if
        
    }//fim validaLogin()

    /**  
    * Função usada para atualiza informações de login, retornando info,
    * para que possa ser criada outra sessão
    * vai ser utilizada em proprietário
    * @param array $dados info de proprietário, pessoa e usuário
    * @return array $infoCompleta com info de proprietário, pessoa, tipo de usuário e configuração
    */
    public function atualizaLogin($dados){

        //recupero usuário
        $infoUsuario = $this->findById($dados['Usuario']['id']);

        //carrega modelo
        $config = new Config();

        //informações sobre configuração
        $infoConfiguracao = $config ->find('first');

        //carrega modelo
        $permissao = new Permissao();

        //informações sobre permissões
        $infoPermissoes = $permissao->listaDePermissoes();

        // é proprietário
        if ($infoUsuario['Usuario']['tipo'] == 0) {
           
            //recupero info - só quero mesmo o id dele para usar no editar
            $infoProprietario = $this-> Proprietario-> findById($dados['Proprietario']['id']);

             //mescla as informações de proprietário, pessoa, usuário e configurações
            $infoCompleta = array_merge($infoProprietario,$infoConfiguracao,$infoPermissoes);

            return $infoCompleta;

        }//fim if 

    }//fim atualizaLogin()


    /**  
    * Valida se existe email menos o registro que está solicitando
    * @param array $dados email
    * @return boolean 
    */
     public function validaSeEmail_editar($dados){
        
        //consulta
        $registros = $this->find('all',array('conditions' => array('Usuario.id  <>' => $dados['id']),'recursive' => -1,'fields' => array('Usuario.email')));

        foreach ($registros as $key => $banco) {

            //comparação case sensitive ex: aDmiN é = admin
            $comparacao = strcasecmp($banco['Usuario']['email'], $dados['email']);
            if ( $comparacao == 0) {

                 //pr('É igual');
                return false;
                
            }else{
            
                //pr('Não é igual');
                return true;

             }//fim if

        }//fim foreach

    }//fim validaSeEmail_editar()

    /**  
    * Antes de salvar ou atualizar usuário, pegamos o campo senha e criptografamos 
    * para assim ser gravada do banco
    * @param string $this->data['Usuario']['senha'] senha
    * @return boolean true
    */
    public function beforeSave() {

        // se existe senha
        if (!empty($this->data['Usuario']['senha'])) {

            //cifra senha
            $this->data['Usuario']['senha'] = Security::encrypt($this->data['Usuario']['senha']);

        }//fim if

        return true;

    }//fim beforeSave()


    /**  
    * Depois da busca, faremos a decriptografia da senha, para o 
    * usuário poder visualizar e editar a senha
    * @param $results resultado da operação de busca
    * @return parametro
    */
    public function afterFind($results) {

        foreach ($results as $key => $val) {

            if (isset($results[$key]['Usuario']['senha'])) {

                //decifra senha
                $results[$key]['Usuario']['senha'] = Security::decrypt($results[$key]['Usuario']['senha']);
              
            }//fim if

        }//fim foreach

        return $results;

    }//fim afterFind()


    /**  
    * Processo de salvar
    * @param array com info
    * @return integer id criado
    */
    public function salvar($dados) {

        //carrega dados para endereco
        $this-> set($dados);    

        //salva
        $this-> save($dados);
        
        //recupera o id
        $idUsuario = $this -> id;

        return  $idUsuario;

    }//fim salvar()

     /**  
     * Processo de excluir
    * @param array info
    * @return void
    */
    public function excluir($dados){

         //deleta
         $this-> delete($dados['Usuario']['id']); 

    }//fim excluir()

    /**  
    * descricao
    * @param parametro
    * @return parametro
    */
    public function atualiza($dados) {
    
        //carrega dados para endereco
        $this-> set($dados);

        //atualiza
        $this -> save($dados);

    }//fim atualiza()

    public function total_usuarios()
    {
       return $this->find('count');
    }

}//class Usuario
?>


