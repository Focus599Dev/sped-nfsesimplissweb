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

        $rps = $this->dom->createElement('Rps');
        $listaRps->appendChild($rps);

        $infRps = $this->dom->createElement('InfRps');
        $rps->appendChild($infRps);

        $identificacaoRps = $this->dom->createElement('IdentificacaoRps');
        $infRps->appendChild($identificacaoRps);

        $this->dom->addChild(
            $identificacaoRps,
            "Numero",
            '1',
            true,
            "Número do RPS"
        );

        $this->dom->addChild(
            $identificacaoRps,
            "Serie",
            $std->Serie,
            true,
            "Número de série do RPS"
        );

        $this->dom->addChild(
            $identificacaoRps,
            "Tipo",
            '1',
            true,
            "Código de tipo de RPS.
            1 –RPS
            2 –Nota Fiscal Conjugada (Mista)
            3 –Cupom"
        );

        $this->dom->addChild(
            $infRps,
            "DataEmissao",
            $std->DataEmissao,
            true,
            "Formato AAAA-MM-DDTHH:mm:ss"
        );

        $this->dom->addChild(
            $infRps,
            "NaturezaOperacao",
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
            "RegimeEspecialTributacao",
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
            "OptanteSimplesNacional",
            '1',
            true,
            "Identificação de Sim/Não
                1 –Sim 
                2 –Não"
        );

        $this->dom->addChild(
            $infRps,
            "IncentivadorCultural",
            '1',
            true,
            "Identificação de Sim/Não
                1 –Sim 
                2 –Não"
        );

        $this->dom->addChild(
            $infRps,
            "Status",
            '1',
            true,
            "Código de status do RPS
                1 –Normal
                2 –Cancelado"
        );

        // $identificacaoRps = $this->dom->createElement('RpsSubstituido');
        // $infRps->appendChild($identificacaoRps);

        $servico = $this->dom->createElement('Servico');
        $infRps->appendChild($servico);

        $valores = $this->dom->createElement('Valores');
        $servico->appendChild($valores);

        $this->dom->addChild(
            $valores,
            "ValorServicos",
            $std->ValorServicos,
            true,
            "Valor dos serviços em R$"
        );

        $this->dom->addChild(
            $valores,
            "ValorDeducoes",
            $std->ValorDeducoes,
            true,
            "Valor das deduções para Redução da Base de Cálculo em R$."
        );

        $this->dom->addChild(
            $valores,
            "ValorPis",
            $std->ValorPis,
            true,
            "Valor da retenção do PIS em R$"
        );

        $this->dom->addChild(
            $valores,
            "ValorCofins",
            $std->ValorCofins,
            true,
            "Valor da retenção do COFINS em R$"
        );

        $this->dom->addChild(
            $valores,
            "ValorInss",
            $std->ValorInss,
            true,
            "Valor da retenção do INSS em R$"
        );

        $this->dom->addChild(
            $valores,
            "ValorIr",
            $std->ValorIr,
            true,
            "Valor da retenção do IR em R$"
        );

        $this->dom->addChild(
            $valores,
            "ValorCsll",
            $std->ValorCsll,
            true,
            "Valor da retenção do CSLL em R$"
        );

        $this->dom->addChild(
            $valores,
            "IssRetido",
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
            "ValorIss",
            $std->ValorIss,
            true,
            "Valor do ISS"
        );

        $this->dom->addChild(
            $valores,
            "OutrasRetencoes",
            $std->ValorOutrasRetencoes,
            true,
            "Valor de outras retenções"
        );

        $this->dom->addChild(
            $valores,
            "BaseCalculo",
            $std->BaseCalculo,
            true,
            "Valor dos serviços – Valor das deduções – descontos incondicionados"
        );

        $this->dom->addChild(
            $valores,
            "Aliquota",
            $std->Aliquota,
            true,
            "Valor percentual"
        );

        $this->dom->addChild(
            $valores,
            "ValorLiquidoNfse",
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
            "ValorIssRetido",
            $std->ValorIssRetido,
            true,
            "Valor do ISS Retido"
        );

        $this->dom->addChild(
            $valores,
            "DescontoCondicionado",
            '0',
            true,
            "Valor do Desconto Condicionado"
        );

        $this->dom->addChild(
            $valores,
            "DescontoIncondicionado",
            $std->DescontoIncondicionado,
            true,
            "Valor do Desconto Incondicionado"
        );

        $this->dom->addChild(
            $servico,
            "ItemListaServico",
            $std->ItemListaServico,
            true,
            "Código de item da lista de serviço"
        );

        $this->dom->addChild(
            $servico,
            "CodigoCnae",
            $std->CodigoCnae,
            true,
            "Código CNAE"
        );

        $this->dom->addChild(
            $servico,
            "CodigoTributacaoMunicipio",
            $std->CodigoTributacaoMunicipio,
            true,
            "Código de Tributação"
        );

        $this->dom->addChild(
            $servico,
            "Discriminacao",
            $std->Discriminacao,
            true,
            "Discriminação do conteúdo da NFS-e"
        );

        $this->dom->addChild(
            $servico,
            "CodigoMunicipio",
            $std->CodigoMunicipio,
            true,
            "Código  de  identificação do município conforme tabela do IBGE.
            Preencher com 5 noves para serviço prestado no exterior."
        );

        $itensServico = $this->dom->createElement('ItensServico');
        $servico->appendChild($itensServico);

        $this->dom->addChild(
            $itensServico,
            "Descricao",
            $std->Discriminacao,
            true,
            "Descrição do serviço"
        );

        $this->dom->addChild(
            $itensServico,
            "Quantidade",
            $std->Quantidade,
            true,
            "Quantidade de itens"
        );

        $this->dom->addChild(
            $itensServico,
            "ValorUnitario",
            $std->ValorUnit,
            true,
            "Valor unitário de cada serviço"
        );

        $prestador = $this->dom->createElement('Prestador');
        $infRps->appendChild($prestador);

        $this->dom->addChild(
            $prestador,
            "Cnpj",
            $std->prestador->Cnpj,
            true,
            "Número do CNPJ do prestador"
        );

        $this->dom->addChild(
            $prestador,
            "InscricaoMunicipal",
            $std->prestador->InscricaoMunicipal,
            true,
            "Número de Inscrição Municipal do prestador"
        );

        $tomador = $this->dom->createElement('Tomador');
        $infRps->appendChild($tomador);

        $identificacaoTomador = $this->dom->createElement('IdentificacaoTomador');
        $tomador->appendChild($identificacaoTomador);

        $cpfCnpj = $this->dom->createElement('CpfCnpj');
        $identificacaoTomador->appendChild($cpfCnpj);

        $this->dom->addChild(
            $cpfCnpj,
            "Cpf",
            '00000000000',
            true,
            "Número do Cpf"
        );

        $this->dom->addChild(
            $identificacaoTomador,
            "Cnpj",
            $std->tomador->Cnpj,
            true,
            "Número do Cnpj"
        );

        $this->dom->addChild(
            $identificacaoTomador,
            "InscricaoMunicipal",
            $std->tomador->InscricaoMunicipal,
            true,
            "Número de Inscrição Municipal do tomador"
        );

        $this->dom->addChild(
            $identificacaoTomador,
            "InscricaoEstadual",
            $std->tomador->InscricaoMunicipal,
            true,
            "Número de Inscrição Estadual do tomador"
        );

        $this->dom->addChild(
            $tomador,
            "RazaoSocial",
            $std->tomador->RazaoSocial,
            true,
            "Razão Social do tomador"
        );

        $endereco = $this->dom->createElement('Endereco');
        $tomador->appendChild($endereco);

        $this->dom->addChild(
            $endereco,
            "Endereco",
            $std->tomador->Endereco,
            true,
            "Endereço"
        );

        $this->dom->addChild(
            $endereco,
            "Numero",
            $std->tomador->Numero,
            true,
            "Número do endereço"
        );

        $this->dom->addChild(
            $endereco,
            "Complemento",
            $std->tomador->Complemento,
            true,
            "Complemento do Endereço"
        );

        $this->dom->addChild(
            $endereco,
            "Bairro",
            $std->tomador->Bairro,
            true,
            "Nome do bairro"
        );

        $this->dom->addChild(
            $endereco,
            "CodigoMunicipio",
            $std->tomador->CodigoMunicipio,
            true,
            "Código de identificação do município conforme tabela do IBGE"
        );

        $this->dom->addChild(
            $endereco,
            "Uf",
            $std->tomador->Uf,
            true,
            "Sigla da unidade federativa"
        );

        $this->dom->addChild(
            $endereco,
            "Cep",
            $std->tomador->Cep,
            true,
            "Número do CEP"
        );

        $contato = $this->dom->createElement('Contato');
        $tomador->appendChild($contato);

        $this->dom->addChild(
            $contato,
            "Telefone",
            $std->tomador->Telefone,
            true,
            "Telefone para contato"
        );

        $this->dom->addChild(
            $contato,
            "Email",
            $std->tomador->Email,
            true,
            "E-mail para contato"
        );

        $intermediarioServico = $this->dom->createElement('IntermediarioServico');
        $infRps->appendChild($intermediarioServico);

        $this->dom->addChild(
            $intermediarioServico,
            "RazaoSocial",
            '',
            true,
            "Razão Social do intermediário"
        );

        $cpfCnpj = $this->dom->createElement('CpfCnpj');
        $intermediarioServico->appendChild($cpfCnpj);

        $this->dom->addChild(
            $cpfCnpj,
            "Cpf",
            '',
            true,
            "Número do Cpf"
        );

        $this->dom->addChild(
            $cpfCnpj,
            "Cnpj",
            '',
            true,
            "Número do Cnpj"
        );

        $this->dom->addChild(
            $identificacaoTomador,
            "InscricaoMunicipal",
            '',
            true,
            "Número de Inscrição Municipal do intermediário"
        );

        $construcaoCivil = $this->dom->createElement('ConstrucaoCivil');
        $infRps->appendChild($construcaoCivil);

        $this->dom->addChild(
            $construcaoCivil,
            "CodigoObra",
            '',
            true,
            "Código de Obra"
        );

        $this->dom->addChild(
            $construcaoCivil,
            "Art",
            '',
            true,
            "Código ART"
        );

        $this->xml = $this->dom->saveXML();

        return $this->xml;
    }

    public function cancelamento($std)
    {
        $pedido = $this->dom->createElement('Pedido');
        $this->dom->appendChild($pedido);

        $infPedidoCancelamento = $this->dom->createElement('InfPedidoCancelamento');
        $pedido->appendChild($infPedidoCancelamento);

        $this->dom->addChild(
            $infPedidoCancelamento,
            "Numero",
            $std->NumeroLote,
            true,
            "Número da Nota Fiscal de Serviço Eletrônica Formato AAAANNNNNNNNNNN"
        );

        $this->dom->addChild(
            $infPedidoCancelamento,
            "Cnpj",
            $std->infPedidoCancelamento,
            true,
            "CNPJ"
        );

        $this->dom->addChild(
            $infPedidoCancelamento,
            "InscricaoMunicipal",
            $std->infPedidoCancelamento,
            true,
            "Número de inscrição municipal"
        );

        $this->dom->addChild(
            $infPedidoCancelamento,
            "CodigoMunicipio",
            $std->infPedidoCancelamento,
            true,
            "Código de identificação do município conforme1-1tabela do IBGE"
        );
    }

    public function consulta($std)
    {
        $consultarNfse = $this->dom->createElement('ConsultarNfse');
        $this->dom->appendChild($consultarNfse);

        $consultarNfseEnvio = $this->dom->createElement('ConsultarNfseEnvio');
        $consultarNfse->appendChild($consultarNfseEnvio);

        $prestador = $this->dom->createElement('Prestador');
        $consultarNfseEnvio->appendChild($prestador);

        $this->dom->addChild(
            $prestador,
            "Cnpj",
            $std->NumeroLote,
            true,
            "Número do CNPJ do prestador"
        );

        $this->dom->addChild(
            $prestador,
            "InscricaoMunicipal",
            $std->NumeroLote,
            true,
            "Número de Inscrição Municipal do prestador"
        );

        $this->dom->addChild(
            $consultarNfseEnvio,
            "NumeroNfse",
            $std->NumeroLote,
            true,
            "Número da Nota Fiscal de Serviço Eletrônica Formato AAAANNNNNNNNNNN"
        );

        $periodoEmissao = $this->dom->createElement('PeriodoEmissao');
        $consultarNfseEnvio->appendChild($periodoEmissao);

        $this->dom->addChild(
            $periodoEmissao,
            "DataInicial",
            $std->NumeroLote,
            true,
            "Data inicial da consulta Nfse Formato: AAAA-MM-DD"
        );

        $this->dom->addChild(
            $periodoEmissao,
            "DataFinal",
            $std->NumeroLote,
            true,
            "Data final da consulta Nfse"
        );

        $tomador = $this->dom->createElement('Tomador');
        $consultarNfseEnvio->appendChild($tomador);

        $cpfCnpj = $this->dom->createElement('CpfCnpj');
        $tomador->appendChild($cpfCnpj);

        $this->dom->addChild(
            $cpfCnpj,
            "Cpf",
            '00000000000',
            true,
            "Número do Cpf"
        );

        $this->dom->addChild(
            $identificacaoTomador,
            "Cnpj",
            $std->tomador->Cnpj,
            true,
            "Número do Cnpj"
        );

        $this->dom->addChild(
            $identificacaoTomador,
            "InscricaoMunicipal",
            $std->tomador->InscricaoMunicipal,
            true,
            "Número de Inscrição Municipal do tomador"
        );

        $this->dom->addChild(
            $identificacaoTomador,
            "InscricaoEstadual",
            $std->tomador->InscricaoMunicipal,
            true,
            "Número de Inscrição Estadual do tomador"
        );

        $intermediarioServico = $this->dom->createElement('IntermediarioServico');
        $consultarNfseEnvio->appendChild($intermediarioServico);

        $this->dom->addChild(
            $intermediarioServico,
            "RazaoSocial",
            $std->tomador->InscricaoMunicipal,
            true,
            "Razão Social do intermediário"
        );

        $cpfCnpj = $this->dom->createElement('CpfCnpj');
        $intermediarioServico->appendChild($cpfCnpj);

        $this->dom->addChild(
            $cpfCnpj,
            "Cpf",
            '00000000000',
            true,
            "Número do Cpf"
        );

        $this->dom->addChild(
            $identificacaoTomador,
            "Cnpj",
            $std->tomador->Cnpj,
            true,
            "Número do Cnpj"
        );

        $this->dom->addChild(
            $intermediarioServico,
            "InscricaoMunicipal",
            $std->tomador->InscricaoMunicipal,
            true,
            "Número de Inscrição Municipal do intermediário"
        );
    }
}
