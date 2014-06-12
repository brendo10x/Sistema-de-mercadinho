<?php

/**
 * Controle
 */
class PessoasController extends AppController {


	//esta ação ocorre antes da ação das actions deste Controller
	public function beforeFilter(){

		//executa ação herdada do AppController
        parent::beforeFilter();   
        
     }//fim beforeFilter()


	/**  
	* valida cpf 
	* @param string do POST $this->data['pes_cpf_ou_cnpj'] cpf 
	* @return boolean de sucesso
	*/
	public function ajaxValidaCPF(){

		//FALSE não permite rederizar o nome do método em uma página .ctp
		//pois somente queremos que retorne o conteúdo
		$this->autoRender = false;

		//define layout
		$this->layout = "ajax";

		//validação
		return $this-> Pessoa->cpf($this->data['pes_cpf_ou_cnpj']);
		
	}//fim ajaxValidaCPFouCNPJ()


	/**  
	* valida cnpj 
	* @param string do POST $this->data['pes_cpf_ou_cnpj'] cnpj 
	* @return boolean de sucesso
	*/
	public function ajaxValidaCNPJ(){

		//FALSE não permite rederizar o nome do método em uma página .ctp
		//pois somente queremos que retorne o conteúdo
		$this->autoRender = false;

		//define layout
		$this->layout = "ajax";

		//validação
		return $this-> Pessoa->cnpj($this->data['pes_cpf_ou_cnpj']);
		
	}//fim ajaxValidaCPFouCNPJ()

	/**  
	* valida se existe cpf ou cnpj
	* @param string do POST $this->data cpf ou cnpj
	* @return boolean de sucesso
	*/
	public function ajaxCPFouCNPJSeExiste(){
		
		//FALSE não permite rederizar o nome do método em uma página .ctp
		//pois somente queremos que retorne o conteúdo
		$this->autoRender = false;

		//define layout
		$this->layout = "ajax";

		//validação
		return $this-> Pessoa->isUnique($this->data);
		 
	}//fim ajaxCPFouCNPJSeExiste()

	/**  
	* valida se existe cpf ou cnpj no atualiza
	* @param string do POST $this->data cpf ou cnpj
	* @return boolean de sucesso
	*/
	public function ajaxCPFouCNPJSeExisteEditar(){
		
		//FALSE não permite rederizar o nome do método em uma página .ctp
		//pois somente queremos que retorne o conteúdo
		$this->autoRender = false;

		//define layout
		$this->layout = "ajax";

		//validação
		return $this-> Pessoa->validaSeExisteCPFouCNPJ_editar($this->data);
		
		 
	}//fim ajaxCPFouCNPJSeExisteEditar()

}//fim class PessoasController
?>