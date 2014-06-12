<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
App::uses('Config', 'Model');
class AppController extends Controller {

    //trabalhando para os controlles
    public $components = array('Session', 'Auth');

    //criar instâncias de modelos em cache para uso dos controllers
    public $persistModel = true;

    //criar cache das views
    public $cacheAction = true;


    /**  
    * Função padrão do beforeFilter()
    * Esta ação ocorre antes da ação de qualquer actions deste Controller
    */
    public function beforeFilter() {

         // CONFIGURAÇÃO DE USUÁRIO
         $this->configUsuario();
         
          // CONFIGURAÇÃO DE LINGUAGEM
         $this->configLinguagem();

         // CONFIGURAÇÃO DE AUTENTICAÇÃO
         $this->configAuth();

          
	}// fim beforeFilter()

    /**
    * Configura usuário
    * Disponiniliza uma variável $usuario com as informações necessárias 
    * assim as views poderam ter acesso
    */
    public function configUsuario(){

         //recupera usuário ativo na sessão $this->Auth->user()
         $usuario = $this->Auth->user();

         //Define usuário
         $this->set('usuario',$usuario);

    }//fim configUsuario()


    /** 
    * Configura variáveis do AuthComponent
    */
    public function configAuth(){
         
         //mensagem de usuário inválido
         $this->Auth->loginError = __("Falha ao entrar no sistema, infome um email e senha válidos");

         //mensagem de área restrita 
         $this->Auth->authError = __("Acesso restrito, por favor entre com email e senha");

          //Url de redirecionamento depois que efetua o logout
         $this->Auth->logoutRedirect = '/usuarios/login';

         //Url de redirecionamento para efetuar login
         $this->Auth->loginAction = '/usuarios/login';

         //Url de redirecionamento depois efetua login com sucesso
         $this->Auth->loginRedirect  = '/';

         //Informa que o controle de autenticação será sobre os controllers
         $this->Auth->authorize = 'controller';

    }//fim configAuth()


    /**
    * Define a linguagem de acordo com a preferência do usuário
    */
    public function configLinguagem(){

         //recupera usuário ativo na sessão $this->Auth->user()
         $usuario = $this->Auth->user();
         
         if(empty($usuario['Config']['idioma'])){
             //resolvendo o problema de linguagem no login
             $Config = new Config;
             $usuario['Config']['idioma'] =  $Config->obterLinguagem();
          }//fim if

         //configura tipo de linguagem
         Configure::write('Config.language', $usuario['Config']['idioma']);

         $locale = Configure::read('Config.language');

         // disponibiliza a linguagem Locale em todas as views
        if ($locale && file_exists($locale . DS . $this -> viewPath)) {

             $this -> viewPath = $locale . DS . $this -> viewPath;

         }//fim if

    }//fim configLinguagem()


   /**  
   * Autorização padrão
   * função padrão isAuthorized()
   * para todas as classes que herdar desta classe AppController
   * terão autorização de acesse para as actions somente logados 
   * @param parametro
   * @return boolean
   */
  public function isAuthorized($usuario) {

    //se usuário existe
    if (!empty($usuario)) {

         return true;

    }else{

         return false;

    }//fim if 


  }//fim isAuthorized()

}//fim class AppController
