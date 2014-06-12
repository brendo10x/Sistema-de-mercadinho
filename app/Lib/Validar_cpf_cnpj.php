<?php

// classe que tem métodos ou funções que valida cpf e cnpj
class Validar {

	private function replace($string) {
		return $string = str_replace('/', '', str_replace('-', '', str_replace('.', '', $string)));
	}

	private function check_fake($string, $length) {
		for ($i = 0; $i <= 9; $i++) {
			$fake = str_pad('', $length, $i);
			if ($string === $fake)
				return (1);
		}
	}

	//explicação deste script php -> http://www.geradorcpf.com/script-validar-cpf-php.htm
	//função que valida cpf
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
	}

	//função que valida cnpj
	public function cnpj($cnpj) {
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
			}
		}

		
	}

}
?>