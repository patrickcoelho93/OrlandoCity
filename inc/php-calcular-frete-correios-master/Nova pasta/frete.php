<?php

	class Frete
	{
		
		function calcularFrete(
			$cepOrigem,
			$cepDestino,
			$peso,
			$comprimento,
			$altura,
			$largura,
			$tipoDeEntrega){

			/*
	 			Seu código administrativo junto à ECT. O código está
				disponível no corpo do contrato firmado com os Correios.
				Sim, para clientes com contrato.Para clientes sem contrato informar o parâmetro vazio.
	 		*/
			$codigoEmpresa = "";// Aqui eu deixei pré definido, só por teste mesmo

			/*
				Senha para acesso ao serviço, associada ao seu código administrativo. A senha inicial corresponde 
				aos	8 primeiros dígitos do CNPJ informado no contrato.
				Sim, para clientes com contrato.Para clientes sem contrato informar o parâmetro vazio.
			*/
			$acessoSenha = "";// Aqui eu deixei pré definido, só por teste mesmo

			/*
				Formato da encomenda (incluindo embalagem).
				Valores possíveis: 1, 2 ou 3
				1 – Formato caixa/pacote
				2 – Formato rolo/prisma
				3 – Envelope
			*/
			$formato = "1";// Aqui eu deixei pré definido, só por teste mesmo

			/*
				Indica se a encomenda será entregue com o serviço
				adicional mão própria.
				Valores possíveis: S ou N (S – Sim, N – Não)
			*/
			$maoPropria = "N";// Aqui eu deixei pré definido, só por teste mesmo

			/*
				Indica se a encomenda será entregue com o serviço
				adicional valor declarado. Neste campo deve ser
				apresentado o valor declarado desejado, em Reais.
				Recebe valor decimal
			*/
			$valorDeclarado = "0";// Aqui eu deixei pré definido, só por teste mesmo

			/*
				Indica se a encomenda será entregue com o serviço
				adicional aviso de recebimento.
				Valores possíveis: S ou N (S – Sim, N – Não)
			*/
			$avisoRecebimento = "N";// Aqui eu deixei pré definido, só por teste mesmo

			/*
				Para clientes sem contrato:
				Códigos Vigentes:
				Código Serviço
				04014 SEDEX à vista
				04510 PAC à vista
				04782 SEDEX 12 ( à vista)
				04790 SEDEX 10 (à vista)
				04804 SEDEX Hoje à vista
			*/
			//$tipoDeEntrega = "04510";

			/*
				Diâmetro da encomenda (incluindo embalagem), em	centímetros.

			*/
			$diametro = "5";// Aqui eu deixei pré definido, só por teste mesmo

			// Aqui eu monto a url antes de mandar para o simplexml_load_file
			$url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?';
			$url .= 'nCdEmpresa='.$codigoEmpresa;
			$url .= '&sDsSenha='.$acessoSenha;
			$url .= '&sCepOrigem='.$cepOrigem;
			$url .= '&sCepDestino='.$cepDestino;
			$url .= '&nVlPeso='.$peso;
			$url .= '&nCdFormato='.$formato;
			$url .= '&nVlComprimento='.$comprimento;
			$url .= '&nVlAltura='.$altura;
			$url .= '&nVlLargura='.$largura;
			$url .= '&sCdMaoPropria='.$maoPropria;
			$url .= '&nVlValorDeclarado='.$valorDeclarado;
			$url .= '&sCdAvisoRecebimento='.$avisoRecebimento;
			$url .= '&nCdServico='.$tipoDeEntrega;
			$url .= '&nVlDiametro='.$diametro;
			$url .= '&StrRetorno='.'xml';
			
			$this->xml = simplexml_load_file($url);

			$retorno = ['valor' => $this->xml->cServico[0]->Valor, 'prazo' => $this->xml->cServico[0]->PrazoEntrega];

			return $retorno;
		}

	public function getValorSemAdicionais(){

		return (float)str_replace(',', '.', $this->xml->ScServico[0]->ValorSemAdicionais);

	}

	public function getValorMaoPropria(){

		return (float)str_replace(',', '.', $this->xml->ScServico[0]->ValorMaoPropria);

	}

	public function getValorAvisoRecebimento(){

		return (float)str_replace(',', '.', $this->xml->ScServico[0]->ValorAvisoRecebimento);

	}

	public function getValorValorDeclarado(){

		return (float)str_replace(',', '.', $this->xml->ScServico[0]->ValorValorDeclarado);

	}

	public function getMsgErro(){

		return $this->xml->ScServico[0]->MsgErro;

	}

	public function getObs(){

		return $this->xml->ScServico[0]->obsFim;

	}

}
?>