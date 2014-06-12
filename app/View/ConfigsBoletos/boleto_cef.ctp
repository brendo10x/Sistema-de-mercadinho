<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Vers�o Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo est� dispon�vel sob a Licen�a GPL dispon�vel pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Voc� deve ter recebido uma c�pia da GNU Public License junto com     |
// | esse pacote; se n�o, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colabora��es de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de Jo�o Prado Maia e Pablo Martins F. Costa                |
// |                                                                      |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordena��o Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto CEF: Elizeu Alcantara                         |
// +----------------------------------------------------------------------+

// ------------------------- DADOS DIN�MICOS DO SEU CLIENTE PARA A GERA��O DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formul�rio c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = $infoCompleta['ConfigBoleto']['taxa_boleto']['valor'];
$data_venc = $infoCompleta['Parcela']['data']; //date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias  OU  informe data: "13/04/2006"  OU  informe "" se Contra Apresentacao;
$valor_cobrado = $infoCompleta['Parcela']['valor']; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto = number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["inicio_nosso_numero"] = $infoCompleta['ConfigBoleto']['inicio_nosso_numero']['valor'];  // Carteira SR: 80, 81 ou 82  -  Carteira CR: 90 (Confirmar com gerente qual usar)
$dadosboleto["nosso_numero"] = $infoCompleta['ConfigBoleto']['nosso_numero']['valor'];  // Nosso numero sem o DV - REGRA: M�ximo de 8 caracteres!

$dadosboleto["numero_documento"] = $infoCompleta['Parcela']['id'].'-000'.$infoCompleta['Parcela']['venda_id'];	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $infoCompleta['Parcela']['data']; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss�o do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] =  $infoCompleta['Pessoa']['pes_nome'];
$dadosboleto["endereco1"] =  __('Cidade').":" .$infoCompleta['Cidade']['cid_nome']." -". __('Estado').":". $infoCompleta['Estado']['est_descricao']."-".$infoCompleta['Estado']['est_sigla'];
$dadosboleto["endereco2"] =  "Bairro:".$infoCompleta['Endereco']['end_bairro']." - ".(__('Número')).":".$infoCompleta['Endereco']['end_numero']." - ".__('Rua')." :".$infoCompleta['Endereco']['end_rua'];

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] =  __("Pagamento de Compra com Idvenda:".$infoCompleta['Venda']['id']." na ".$infoCompleta['Config']['nome_sistema']);
$dadosboleto["demonstrativo2"] =  __("Mensalidade referente a parcela com IdParcela: ".$infoCompleta['Parcela']['id']." na compra relalizada no dia ".$infoCompleta['Venda']['data']."<br>".('Taxa bancária')." - R$ ".number_format($taxa_boleto, 2, ',', ''));
$dadosboleto["demonstrativo3"] = $infoCompleta['ConfigBoleto']['demonstrativo']['valor'];

// INSTRU��ES PARA O CAIXA
$dadosboleto["instrucoes1"] =  __("- Sr. Caixa, cobrar multa de 2% após o vencimento");
$dadosboleto["instrucoes2"] =  __("- Receber até 10 dias após o vencimento");
$dadosboleto["instrucoes3"] =  __("- Em caso de dúvidas entre em contato conosco: xxxx@xxxx.com.br");
$dadosboleto["instrucoes4"] =  "- ".$infoCompleta['ConfigBoleto']['instrucoes']['valor'];


// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "1";
$dadosboleto["valor_unitario"] = $infoCompleta['Parcela']['valor'];
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = $infoCompleta['ConfigBoleto']['especie']['valor'];
$dadosboleto["especie_doc"] = "";


// ---------------------- DADOS FIXOS DE CONFIGURA��O DO SEU BOLETO --------------- //
 
// DADOS DA SUA CONTA - CEF
$dadosboleto["agencia"] = $infoCompleta['ConfigBoleto']['agencia']['valor']; // Num da agencia, sem digito
$dadosboleto["conta"] = $infoCompleta['ConfigBoleto']['conta']['valor']; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = $infoCompleta['ConfigBoleto']['conta_dv']['valor']; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - CEF
$dadosboleto["conta_cedente"] = "87000000414"; // ContaCedente do Cliente, sem digito (Somente N�meros)
$dadosboleto["conta_cedente_dv"] = "3"; // Digito da ContaCedente do Cliente
$dadosboleto["carteira"] = "SR";  // C�digo da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)

// SEUS DADOS
$dadosboleto["identificacao"] = $infoCompleta['Config']['nome_sistema'];
$dadosboleto["cpf_cnpj"] = "";
$dadosboleto["endereco"] = __("Coloque o endereço da sua empresa aqui");
$dadosboleto["cidade_uf"] = __("Cidade / Estado");
$dadosboleto["cedente"] =  $infoCompleta['Config']['nome_sistema'];

// N�O ALTERAR!
include("include/funcoes_cef.php"); 
include("include/layout_cef.php");
?>
