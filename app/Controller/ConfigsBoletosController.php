<?php

/**
 *	Controle
 */
App::uses('AppModel', 'Model');
App::uses('Parcela', 'Model');
App::uses('Cliente', 'Model');
App::uses('Estado', 'Model');
App::uses('Config', 'Model');
class ConfigsBoletosController extends AppController {

 
    // modelos adicionais disponíveis para este Controller
    var $uses = array('ConfigBoleto');


	//esta ação ocorre antes da ação das actions deste Controller
    public function beforeFilter(){

        //executa ação herdada do AppController
        parent::beforeFilter(); 
 
    }//fim beforeFilter()


    public function isAuthorized()
    {

         //recupero permissões
        $permissao = $this->Session->read('Auth.User.Permissoes');

        //recupero tipo de usuário ativo na sessão
        $tipoDeUsuario = $this->Session->read('Auth.User.Usuario.tipo');

        //permitido (0 - sim) (1 = não)
        //tipo (0 - proprietário) (1 - Vendedor)

        if ($tipoDeUsuario == 0 || $permissao['ConfigsBoletosController']['permitido'] == 0 ) {
            
            //fluxo normal
            return true;

        }else{

            // só pode imprimir parcela se estiver autirizado ver vendas
            if($this->action == 'boletoCef'){

                if ( $permissao['VendasController']['permitido'] == 0) {

                   return true;
                }else{

                    // página de acesso restrito
                    return $this->redirect('/usuarios/acesso_restrito');
                }
            }

            // página de acesso restrito
            return $this->redirect('/usuarios/acesso_restrito');

        }//fim if
    }


    /** 
    * Session sucesso - armazena valor da msg de sucesso quando necessário para a view
    */
    function afterFilter() {

        //se existe sessão com o nome sucesso
        if ($this -> Session -> check('sucesso')) {

            //destroi sessão com o nome sucesso
            $this -> Session -> delete('sucesso');

        }//fim if

    }//fim afterFilter()


    /**  
    * Configuração de boleto
    * @param parametro
    * @return parametro
    */
    public function configuracaoBoleto(){


        //se a requisição é post
        if ($this->request->is('post')) {

            //recupera valores
            $dados = $this->data;

            //salva configurações
            $this-> ConfigBoleto ->salva_configuracao_boleto($dados);

            //disponível na view
            $this -> Session -> write('sucesso', __('Configuração de boleto atualizado'));

            
        }//fim if

        //define informação de todas as configurações
        $this->set('configBoleto',$this-> ConfigBoleto ->listaDeConfigBoleto());


        //define título da página
        $this ->set('titulo',__('Configuração de boleto'));
    }


    /**  
    * Processo de mostrar boleto
    * @param Do GET $this->params['pass'][0] id da parcela
    * @return void
    */
    public function boletoCef(){

      if(!empty($this->params['pass'][0])){

        //recupera info de parcela
        $Parcela = new Parcela;
        $infoParcela = $Parcela->findById($this->params['pass'][0]);

        //recupera info de cliente
        $Cliente = new Cliente;
        $infoCliente = $Cliente->findById($infoParcela['Venda']['cliente_id']);
        
        //recupera info do estado
        $Estado = new Estado;
        $infoCidadeEstado = $Estado->infoCidadeEstado($infoCliente['Endereco']['cidade_id']);

        //recupera info do boleto
        $infoBoleto = $this->ConfigBoleto->listaDeConfigBoleto();

        //recupera info da configuração
        $Config = new Config();
        $infoConfig = $Config->find('all');

        // mescla as informações
        $infoCompleta = array_merge($infoParcela,$infoCliente,$infoCidadeEstado[0],$infoBoleto,$infoConfig[0]);
        
        // disponível na view as informações
        $this->set('infoCompleta',$infoCompleta);

    }//fim if  

    //define layout
    $this->layout=  'ajax';

}//fim boletoCef
    


}// fim class ConfigsController
?>