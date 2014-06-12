<?php
/**
 * Modelo de Fornecedor - Informações
 */
App::uses('AppModel', 'Model');
class Fornecedor extends AppModel {


    //especifica o nome da tabela do banco de dados
    var $useTable = 'fornecedores'; // Este modelo usa a tabela 'fornecedores'

    /*
    * Relacionamentos
    */
    
    // o model atual contém a chave estrangeira.
    var $belongsTo = array('Endereco', 'Pessoa');

    //hasMany: o outro modelo cotém a chave estrangeira.
    var $hasMany = array('Produto'=> array(
            'className'    => 'Produto',
            'foreignKey'    => 'fornecedor_id',
            'dependent'    => true
        ));

    /*
    * métodos ou funções personalizadas
    */

    /**  
    * Processo de salvar Fornecedor
    * @param array $dados informações sobre Fornecedor, endereço e pessoa.
    * @return void
    */
    public function salvar_fornecedor($dados) {

        //carrega os dados para Fornecedor
        $this -> set($dados);

         //salva e recupera o id criado
        $idPessoa = $this-> Pessoa->salvar($dados);

        //atualiza a posição do array com o id
        $dados['Fornecedor']['pessoa_id'] = $idPessoa;

        //salva e recupera o id criado
        $IdEndereco = $this -> Endereco ->salvar($dados);

        //atualiza a posição do array com o id
        $dados['Fornecedor']['endereco_id'] = $IdEndereco;

        //salva
        $this -> save($dados);

    }//fim salvar_fornecedor()


    /**  
    * Processo de excluir Fornecedor
    * @param integer $idFornecedor id do Fornecedor
    * @return void
    */
    public function excluir_fornecedor($idFornecedor){

        //obtem informações  
        $fornecedor = $this->findById($idFornecedor); 

        //deleta
        $this -> delete($idFornecedor,true);  

        //deleta
        $this-> Endereco-> excluir($fornecedor);  

        //deleta
        $this-> Pessoa-> excluir($fornecedor); 

    }//fim excluir_fornecedor()


    /**  
    * Processo de atualizar Fornecedor
    * @param array $dados informações sobre Fornecedor,endereço e pessoa.
    * @return void
    */
    public function atualizar_fornecedor($dados){
 
        //atualiza
        $this-> Pessoa->atualiza($dados);

        //atualiza
        $this -> Endereco -> atualiza($dados);

        //carrega os dados para Fornecedor
        $this -> set($dados);

        //atualiza
        $this -> save($dados);

    }//fim atualizar_fornecedor()


    /**  
    * Função que busca fornecedor por nome
    * @param string $nomeFornecedor nome do forneceodor
    * @return array de fornecedores
    */
    public function buscaPorNome($nomeFornecedor){
        
        //consulta 
        $options['joins'] = array(
            array('table' => 'pessoas',
                'alias' => 'Pessoas',
                'type' => 'inner',
                'conditions' => array(
                    'Fornecedor.pessoa_id = Pessoas.id',
                    )
                )
            );

        //O CakePHP busca os dados do Grupo e de seu domínio.
        $options['recursive'] =  0;

        //Condições
        $options['conditions'] = array(
            'Pessoas.pes_nome LIKE' => "%".$nomeFornecedor."%"
        );

        //retorna somente estes campos
        $options['fields'] = array('Fornecedor.id','Pessoas.pes_nome','Pessoas.pes_foto');

        $resultados = $this->find('all',$options);
        
        if (count($resultados) == 0) {
           return  array( 0=>0);
        }
        //retorna o array com info.
        return  $resultados;

    }//fim buscaPorNome()



    /**  
    * Função que busca fornecedor por id
    * @param $idFornecedor do fornecedor
    * @return array com informações do fornecedor 
    */
    public function buscaPorId($idFornecedor){
        //consulta 
        $options['joins'] = array(
            array('table' => 'pessoas',
                'alias' => 'Pessoas',
                'type' => 'inner',
                'conditions' => array(
                    'Fornecedor.pessoa_id = Pessoas.id',
                    )
                )
            );

        //O CakePHP busca os dados do Grupo e de seu domínio.
        $options['recursive'] =  0;

        //Condições
        $options['conditions'] = array(
            'Fornecedor.id =' => $idFornecedor
        );

        //retorna somente estes campos
        $options['fields'] = array('Fornecedor.id,Pessoas.pes_nome','Pessoas.pes_cpf_ou_cnpj','Pessoas.pes_telefone','Pessoas.pes_foto');

        //retorna o array com info.
        return $this->find('first',$options);

    }//fim buscaPorId()
    
    /**  
    * Retorna o total de fornecedores 
    * @return integer total de fornecedores
    */
    public function total_fornecedores(){
        
       return $this->find('count');
       
    }//fim total_fornecedores()

    /**  
    * Listagem de fornecedores
    * @param integer $limit - limite, $busca- busca
    * @return array com informação do fornecedor
    */
    public function listagem($limit,$busca){
        
         //campos retornados
        $options['fields'] = array('Fornecedor.id', 'Pessoa.pes_nome','Pessoa.pes_telefone');
        
        
        // registros por página
        //utilizada aqui pelo PaginatorComponent
        $options['limit'] = $limit;

        // valores agregados
        $options['recursive'] = 2;
        
         //condição de busca
        if (!empty($busca)) {
            
            $options['conditions'] = array('Pessoa.pes_nome LIKE' => '%'. $busca .'%');
        }//fim if
      
        
        return $options;
        
    }//fim listagem()
    
}//fim class Fornecedor
?>