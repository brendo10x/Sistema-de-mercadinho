<?php
/**
 * Modelo de Vendedor - Informações
 */
App::uses('AppModel', 'Model');
class Vendedor extends AppModel {

    //especifica o nome da tabela do banco de dados
    var $useTable = 'vendedores'; // Este modelo usa a tabela 'vendedores'

    /*
    * Relacionamentos
    */
    var $belongsTo = array('Endereco', 'Pessoa', 'Usuario');


    /*
    * métodos ou funções personalizadas
    */

    /**  
    * Processo de salvar vendedor
    * @param array $dados informações sobre vendedor,endereço,
    * usuário e pessoa.
    * @return void
    */
    public function salvar_vendedor($dados) {

        //carrega os dados para vendedor
        $this -> set($dados);

         //salva e recupera o id criado
        $idPessoa = $this-> Pessoa->salvar($dados);

        //atualiza a posição do array com o id
        $dados['Vendedor']['pessoa_id'] = $idPessoa;

        //salva e recupera o id criado
        $IdEndereco = $this -> Endereco ->salvar($dados);

        //atualiza a posição do array com o id
        $dados['Vendedor']['endereco_id'] = $IdEndereco;

        //salva e recupera o id criado
        $IdUsuario = $this-> Usuario ->salvar($dados);

        //atualiza a posição do array com o id
        $dados['Vendedor']['usuario_id'] = $IdUsuario;

        //salva
        $this -> save($dados);

    }//fim salvar_vendedor()


    /**  
    * Processo de excluir vendedor
    * @param integer $idVendedor id do vendedor
    * @return void
    */
    public function excluir_vendedor($idVendedor){

        //obtem informações  
        $vendedor = $this->findById($idVendedor); 

        //deleta
        $this -> delete($idVendedor);  

        //deleta
        $this-> Endereco-> excluir($vendedor);  

        //deleta
        $this -> Usuario-> excluir($vendedor);  

        //deleta
        $this-> Pessoa-> excluir($vendedor); 

    }//fim excluir_vendedor(()


    /**  
    * Processo de atualizar vendedor
    * @param array $dados informações sobre vendedor,endereço,
    * usuário e pessoa.
    * @return void
    */
    public function atualizar_vendedor($dados){
 
        //atualiza
        $this-> Pessoa->atualiza($dados);

        //atualiza
        $this -> Endereco -> atualiza($dados);

        //atualiza
        $this -> Usuario -> atualiza($dados);

        //carrega os dados para vendedor
        $this -> set($dados);

        //atualiza
        $this -> save($dados);

    }//fim atualizar_vendedor()

    /**  
    * Função que busca Vendedor por nome
    * @param string $nomeVendedor nome do forneceodor
    * @return array de Vendedores
    */
    public function buscaPorNome($nomeVendedor){
        
        //consulta 
        $options['joins'] = array(
            array('table' => 'pessoas',
                'alias' => 'Pessoas',
                'type' => 'inner',
                'conditions' => array(
                    'Vendedor.pessoa_id = Pessoas.id',
                    )
                )
            );

        //O CakePHP busca os dados do Grupo e de seu domínio.
        $options['recursive'] =  0;

        //Condições
        $options['conditions'] = array(
            'Pessoas.pes_nome LIKE' => "%".$nomeVendedor."%"
        );

        //retorna somente estes campos
        $options['fields'] = array('Vendedor.id','Pessoas.pes_nome');

        $resultados = $this->find('all',$options);
        
        if (count($resultados) == 0) {
           return  array( 0=>0);
        }
        //retorna o array com info.
        return  $resultados;

    }//fim buscaPorNome()
    
    /**  
    * Total de vendedores
    * @return integer
    */
    public function total_vendedores(){
        
       return $this->find('count');
       
    }//fim total_vendedores()
    
    /**  
    * Listagem de vendedores
    * @param integer $limit - limite, $busca- busca
    * @return array com informação do vendedor
    */
    public function listagem($limit,$busca){
        
         //campos retornados
        $options['fields'] = array('Vendedor.id', 'Pessoa.pes_nome','Pessoa.pes_telefone');
        
        
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

}//fim class Vendedor
?>