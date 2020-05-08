<?php

namespace NFePHP\NFSe\SIMPLISSWEB;

use NFePHP\Common\DOMImproved as Dom;

class Make
{

    public $dom;

    public $xml;

    public function __construct()
    {

        $this->dom = new Dom();

        $this->dom->preserveWhiteSpace = false;

        $this->dom->formatOutput = false;
    }

    public function getXML($std)
    {

        if (empty($this->xml)) {

            $this->gerarNota($std);
        }

        return $this->xml;
    }

    public function gerarNota($std)
    {

        $loteRps = $this->dom->createElement('nfse:LoteRps');
        $this->dom->appendChild($loteRps);

        $this->dom->addChild(
            $loteRps,                                       // pai
            "nfse:NumeroLote",                              // nome
            $std->NumeroLote,                               // valor
            true,                                           // se é obrigatorio
            "Número do Lote de RPS"                         // descrição se der catch
        );

        $this->dom->addChild(
            $loteRps,
            "nfse:Cnpj",
            $std->prestador->Cnpj,
            true,
            "CNPJ do contribuinte"
        );

        $this->dom->addChild(
            $loteRps,
            "nfse:InscricaoMunicipal",
            $std->NumeroLote,
            true,
            "Número de Inscrição Municipal"
        );

        $this->dom->addChild(
            $loteRps,
            "nfse:QuantidadeRps",
            '1',
            true,
            "Quantidade de RPS do Lote"
        );

        $listaRps = $this->dom->createElement('nfse:ListaRps');
        $loteRps->appendChild($listaRps);

        $rps = $this->dom->createElement('nfse:Rps');
        $listaRps->appendChild($rps);

        $infRps = $this->dom->createElement('nfse:InfRps');
        $rps->appendChild($infRps);

        $identificacaoRps = $this->dom->createElement('nfse:IdentificacaoRps');
        $infRps->appendChild($identificacaoRps);

        $this->dom->addChild(
            $identificacaoRps,
            "nfse:Numero",
            '1',
            true,
            "Número do RPS"
        );

        $this->dom->addChild(
            $identificacaoRps,
            "nfse:Serie",
            $std->Serie,
            true,
            "Número de série do RPS"
        );

        $this->dom->addChild(
            $identificacaoRps,
            "nfse:Tipo",
            '1',
            true,
            "Código de tipo de RPS.
            1 –RPS
            2 –Nota Fiscal Conjugada (Mista)
            3 –Cupom"
        );

        $this->dom->addChild(
            $infRps,
            "nfse:DataEmissao",
            $std->DataEmissao,
            true,
            "Formato AAAA-MM-DDTHH:mm:ss"
        );

        $this->dom->addChild(
            $infRps,
            "nfse:NaturezaOperacao",
            '1',
            true,
            "Código de natureza da operação.
                1 –Tributação no município
                2 –Tributação fora do município
                3 –Isenção
                4 –Imune
                5 –Exigibilidade  suspensa  pordecisão judicial
                6 –Exigibilidade  suspensa  por procedimento administrativo"
        );

        $this->dom->addChild(
            $infRps,
            "nfse:RegimeEspecialTributacao",
            '1',
            true,
            "Código de identificação do regime especial de tributação.
                1 –Microempresa municipal
                2 –Estimativa
                3 –Sociedade de profissionais
                4 –Cooperativa
                5 –Microempresário Individual (MEI)
                6 –Microempresário e Empresa dePequeno Porte (ME EPP)"
        );

        $this->dom->addChild(
            $infRps,
            "nfse:OptanteSimplesNacional",
            '1',
            true,
            "Identificação de Sim/Não
                1 –Sim 
                2 –Não"
        );

        $this->dom->addChild(
            $infRps,
            "nfse:IncentivadorCultural",
            '1',
            true,
            "Identificação de Sim/Não
                1 –Sim 
                2 –Não"
        );

        $this->dom->addChild(
            $infRps,
            "nfse:Status",
            '1',
            true,
            "Código de status do RPS
                1 –Normal
                2 –Cancelado"
        );

        // $identificacaoRps = $this->dom->createElement('nfse:RpsSubstituido');
        // $infRps->appendChild($identificacaoRps);

        $servico = $this->dom->createElement('nfse:Servico');
        $infRps->appendChild($servico);

        $valores = $this->dom->createElement('nfse:Valores');
        $servico->appendChild($valores);

        $this->dom->addChild(
            $valores,
            "nfse:ValorServicos",
            $std->ValorServicos,
            true,
            "Valor dos serviços em R$"
        );

        $this->dom->addChild(
            $valores,
            "nfse:ValorDeducoes",
            $std->ValorDeducoes,
            true,
            "Valor das deduções para Redução da Base de Cálculo em R$."
        );

        $this->dom->addChild(
            $valores,
            "nfse:ValorPis",
            $std->ValorPis,
            true,
            "Valor da retenção do PIS em R$"
        );

        $this->dom->addChild(
            $valores,
            "nfse:ValorCofins",
            $std->ValorCofins,
            true,
            "Valor da retenção do COFINS em R$"
        );

        $this->dom->addChild(
            $valores,
            "nfse:ValorInss",
            $std->ValorInss,
            true,
            "Valor da retenção do INSS em R$"
        );

        $this->dom->addChild(
            $valores,
            "nfse:ValorIr",
            $std->ValorIr,
            true,
            "Valor da retenção do IR em R$"
        );

        $this->dom->addChild(
            $valores,
            "nfse:ValorCsll",
            $std->ValorCsll,
            true,
            "Valor da retenção do CSLL em R$"
        );

        $this->dom->addChild(
            $valores,
            "nfse:IssRetido",
            $std->IssRetido,
            true,
            "1 –Sim
             2 –Não
            Caso “Sim”, o valor do IssRetido dever ser igual ao
            ValorIss e exibir o ValorIssRetido.
            Caso “Não”, não exibir ValorIssRetido"
        );

        $this->dom->addChild(
            $valores,
            "nfse:ValorIss",
            $std->ValorIss,
            true,
            "Valor do ISS"
        );

        $this->dom->addChild(
            $valores,
            "nfse:OutrasRetencoes",
            $std->ValorOutrasRetencoes,
            true,
            "Valor de outras retenções"
        );

        $this->dom->addChild(
            $valores,
            "nfse:BaseCalculo",
            $std->BaseCalculo,
            true,
            "Valor dos serviços – Valor das deduções – descontos incondicionados"
        );

        $this->dom->addChild(
            $valores,
            "nfse:Aliquota",
            $std->Aliquota,
            true,
            "Valor percentual"
        );

        $this->dom->addChild(
            $valores,
            "nfse:ValorLiquidoNfse",
            $std->ValorLiquidoNfse,
            true,
            "    ValorServicos 
                –ValorPIS 
                –ValorCOFINS 
                –ValorINSS 
                –ValorIR 
                –ValorCSLL 
                –utrasRetençoes 
                –ValorISSRetido 
                -DescontoIncondicionado 
                -DescontoCondicionado"
        );

        $this->dom->addChild(
            $valores,
            "nfse:ValorIssRetido",
            $std->ValorIssRetido,
            true,
            "Valor do ISS Retido"
        );

        $this->dom->addChild(
            $valores,
            "nfse:DescontoCondicionado",
            '0',
            true,
            "Valor do Desconto Condicionado"
        );

        $this->dom->addChild(
            $valores,
            "nfse:DescontoIncondicionado",
            $std->DescontoIncondicionado,
            true,
            "Valor do Desconto Incondicionado"
        );

        $this->dom->addChild(
            $servico,
            "nfse:ItemListaServico",
            $std->ItemListaServico,
            true,
            "Código de item da lista de serviço"
        );

        $this->dom->addChild(
            $servico,
            "nfse:CodigoCnae",
            $std->CodigoCnae,
            true,
            "Código CNAE"
        );

        $this->dom->addChild(
            $servico,
            "nfse:CodigoTributacaoMunicipio",
            $std->CodigoTributacaoMunicipio,
            true,
            "Código de Tributação"
        );

        $this->dom->addChild(
            $servico,
            "nfse:Discriminacao",
            $std->Discriminacao,
            true,
            "Discriminação do conteúdo da NFS-e"
        );

        $this->dom->addChild(
            $servico,
            "nfse:CodigoMunicipio",
            $std->CodigoMunicipio,
            true,
            "Código  de  identificação do município conforme tabela do IBGE.
            Preencher com 5 noves para serviço prestado no exterior."
        );

        $itensServico = $this->dom->createElement('nfse:ItensServico');
        $servico->appendChild($itensServico);

        $this->dom->addChild(
            $itensServico,
            "nfse:Descricao",
            $std->Discriminacao,
            true,
            "Descrição do serviço"
        );

        $this->dom->addChild(
            $itensServico,
            "nfse:Quantidade",
            $std->Quantidade,
            true,
            "Quantidade de itens"
        );

        $this->dom->addChild(
            $itensServico,
            "nfse:ValorUnitario",
            $std->ValorUnit,
            true,
            "Valor unitário de cada serviço"
        );

        $prestador = $this->dom->createElement('nfse:Prestador');
        $infRps->appendChild($prestador);

        $this->dom->addChild(
            $prestador,
            "nfse:Cnpj",
            $std->prestador->Cnpj,
            true,
            "Número do CNPJ do prestador"
        );

        $this->dom->addChild(
            $prestador,
            "nfse:InscricaoMunicipal",
            $std->prestador->InscricaoMunicipal,
            true,
            "Número de Inscrição Municipal do prestador"
        );

        $tomador = $this->dom->createElement('nfse:Tomador');
        $infRps->appendChild($tomador);

        $identificacaoTomador = $this->dom->createElement('nfse:IdentificacaoTomador');
        $tomador->appendChild($identificacaoTomador);

        $cpfCnpj = $this->dom->createElement('nfse:CpfCnpj');
        $identificacaoTomador->appendChild($cpfCnpj);

        $this->dom->addChild(
            $cpfCnpj,
            "nfse:Cpf",
            '00000000000',
            true,
            "Número do Cpf"
        );

        $this->dom->addChild(
            $identificacaoTomador,
            "nfse:Cnpj",
            $std->tomador->Cnpj,
            true,
            "Número do Cnpj"
        );

        $this->dom->addChild(
            $identificacaoTomador,
            "nfse:InscricaoMunicipal",
            $std->tomador->InscricaoMunicipal,
            true,
            "Número de Inscrição Municipal do tomador"
        );

        $this->dom->addChild(
            $identificacaoTomador,
            "nfse:InscricaoEstadual",
            $std->tomador->InscricaoMunicipal,
            true,
            "Número de Inscrição Estadual do tomador"
        );

        $this->dom->addChild(
            $tomador,
            "nfse:RazaoSocial",
            $std->tomador->RazaoSocial,
            true,
            "Razão Social do tomador"
        );

        $endereco = $this->dom->createElement('nfse:Endereco');
        $tomador->appendChild($endereco);

        $this->dom->addChild(
            $endereco,
            "nfse:Endereco",
            $std->tomador->Endereco,
            true,
            "Endereço"
        );

        $this->dom->addChild(
            $endereco,
            "nfse:Numero",
            $std->tomador->Numero,
            true,
            "Número do endereço"
        );

        $this->dom->addChild(
            $endereco,
            "nfse:Complemento",
            $std->tomador->Complemento,
            true,
            "Complemento do Endereço"
        );

        $this->dom->addChild(
            $endereco,
            "nfse:Bairro",
            $std->tomador->Bairro,
            true,
            "Nome do bairro"
        );

        $this->dom->addChild(
            $endereco,
            "nfse:CodigoMunicipio",
            $std->tomador->CodigoMunicipio,
            true,
            "Código de identificação do município conforme tabela do IBGE"
        );

        $this->dom->addChild(
            $endereco,
            "nfse:Uf",
            $std->tomador->Uf,
            true,
            "Sigla da unidade federativa"
        );

        $this->dom->addChild(
            $endereco,
            "nfse:Cep",
            $std->tomador->Cep,
            true,
            "Número do CEP"
        );

        $contato = $this->dom->createElement('nfse:Contato');
        $tomador->appendChild($contato);

        $this->dom->addChild(
            $contato,
            "nfse:Telefone",
            $std->tomador->Telefone,
            true,
            "Telefone para contato"
        );

        $this->dom->addChild(
            $contato,
            "nfse:Email",
            $std->tomador->Email,
            true,
            "E-mail para contato"
        );

        $intermediarioServico = $this->dom->createElement('nfse:IntermediarioServico');
        $infRps->appendChild($intermediarioServico);

        $this->dom->addChild(
            $intermediarioServico,
            "nfse:RazaoSocial",
            '',
            true,
            "Razão Social do intermediário"
        );

        $cpfCnpj = $this->dom->createElement('nfse:CpfCnpj');
        $intermediarioServico->appendChild($cpfCnpj);

        $this->dom->addChild(
            $cpfCnpj,
            "nfse:Cpf",
            '',
            true,
            "Número do Cpf"
        );

        $this->dom->addChild(
            $cpfCnpj,
            "nfse:Cnpj",
            '',
            true,
            "Número do Cnpj"
        );

        $this->dom->addChild(
            $identificacaoTomador,
            "nfse:InscricaoMunicipal",
            '',
            true,
            "Número de Inscrição Municipal do intermediário"
        );

        $construcaoCivil = $this->dom->createElement('nfse:ConstrucaoCivil');
        $infRps->appendChild($construcaoCivil);

        $this->dom->addChild(
            $construcaoCivil,
            "nfse:CodigoObra",
            '',
            true,
            "Código de Obra"
        );

        $this->dom->addChild(
            $construcaoCivil,
            "nfse:Art",
            '',
            true,
            "Código ART"
        );

        $this->xml = $this->dom->saveXML();

        return $this->xml;
    }

    public function cancelamento($std)
    {
    }

    public function consulta($std, $codigoCidade)
    {
    }
}
