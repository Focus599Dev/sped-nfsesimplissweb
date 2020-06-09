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

        $this->loteRps = $this->dom->createElement('nfse:LoteRps');

        $this->infRps = $this->dom->createElement('InfRps');

        $this->servico = $this->dom->createElement('Servico');

        $this->itensServico = $this->dom->createElement('ItensServico');

        $this->valores = $this->dom->createElement('Valores');

        $this->identificacaoRps = $this->dom->createElement('IdentificacaoRps');

        $this->prestador = $this->dom->createElement('Prestador');

        $this->tomador = $this->dom->createElement('Tomador');

        $this->identificacaoTomador = $this->dom->createElement('IdentificacaoTomador');

        $this->contato = $this->dom->createElement('Contato');

        $this->endereco = $this->dom->createElement('Endereco');
    }

    public function getXML()
    {
        if (empty($this->xml)) {

            $this->monta();
        }

        return $this->xml;
    }

    public function monta()
    {
        $this->dom->appendChild($this->loteRps);

        $listaRps = $this->dom->createElement('nfse:ListaRps');
        $this->loteRps->appendChild($listaRps);

        $rps = $this->dom->createElement('Rps');
        $listaRps->appendChild($rps);

        $rps->appendChild($this->infRps);

        $items = $rps->getElementsByTagName('InfRps');

        $firstItem = $items->item(0);

        $firstItem->insertBefore($this->identificacaoRps, $firstItem->firstChild);

        $this->infRps->appendChild($this->servico);

        $items = $this->infRps->getElementsByTagName('Servico');

        $firstItem = $items->item(0);

        $firstItem->insertBefore($this->valores, $firstItem->firstChild);

        $this->servico->appendChild($this->itensServico);

        $this->infRps->appendChild($this->prestador);

        $this->infRps->appendChild($this->tomador);

        $items = $this->infRps->getElementsByTagName('Tomador');

        $firstItem = $items->item(0);

        $firstItem->insertBefore($this->identificacaoTomador, $firstItem->firstChild);

        $this->tomador->appendChild($this->contato);

        $contato = $this->tomador->getElementsByTagName('Contato')->item(0);

        $firstItem->insertBefore($this->endereco, $contato);

        $this->buildIntermediarioServico();

        $this->buildConstrucaoCivil();

        $this->xml = $this->dom->saveXML();

        return $this->xml;
    }

    public function buildLoteRps($std)
    {

        $this->dom->addChild(
            $this->loteRps,
            "nfse:NumeroLote",
            $std->NumeroLote,
            true,
            "Número do Lote de RPS"
        );

        $this->dom->addChild(
            $this->loteRps,
            "nfse:Cnpj",
            $std->Cnpj,
            true,
            "CNPJ do contribuinte"
        );

        $this->dom->addChild(
            $this->loteRps,
            "nfse:InscricaoMunicipal",
            $std->InscricaoMunicipal,
            true,
            "Número de Inscrição Municipal"
        );

        $this->dom->addChild(
            $this->loteRps,
            "nfse:QuantidadeRps",
            $std->QuantidadeRps,
            true,
            "Quantidade de RPS do Lote"
        );
    }

    public function buildInfRps($std)
    {

        $this->dom->addChild(
            $this->infRps,
            "DataEmissao",
            $std->DataEmissao,
            true,
            "Formato AAAA-MM-DDTHH:mm:ss"
        );

        $this->dom->addChild(
            $this->infRps,
            "NaturezaOperacao",
            $std->NaturezaOperacao,
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
            $this->infRps,
            "RegimeEspecialTributacao",
            $std->RegimeEspecialTributacao,
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
            $this->infRps,
            "OptanteSimplesNacional",
            $std->OptanteSimplesNacional,
            true,
            "Identificação de Sim/Não
                1 –Sim 
                2 –Não"
        );

        $this->dom->addChild(
            $this->infRps,
            "IncentivadorCultural",
            $std->IncentivadorCultural,
            true,
            "Identificação de Sim/Não
                1 –Sim 
                2 –Não"
        );

        $this->dom->addChild(
            $this->infRps,
            "Status",
            $std->Status,
            true,
            "Código de status do RPS
                1 –Normal
                2 –Cancelado"
        );
    }

    public function buildIdentificacaoRps($std)
    {

        $this->dom->addChild(
            $this->identificacaoRps,
            "Numero",
            '1',
            true,
            "Número do RPS"
        );

        $this->dom->addChild(
            $this->identificacaoRps,
            "Serie",
            $std->Serie,
            true,
            "Número de série do RPS"
        );

        $this->dom->addChild(
            $this->identificacaoRps,
            "Tipo",
            '1',
            true,
            "Código de tipo de RPS.
            1 –RPS
            2 –Nota Fiscal Conjugada (Mista)
            3 –Cupom"
        );
    }

    public function buildServico($std)
    {

        $this->dom->addChild(
            $this->servico,
            "ItemListaServico",
            $std->ItemListaServico,
            true,
            "Código de item da lista de serviço"
        );

        $this->dom->addChild(
            $this->servico,
            "CodigoCnae",
            $std->CodigoCnae,
            true,
            "Código CNAE"
        );

        $this->dom->addChild(
            $this->servico,
            "CodigoTributacaoMunicipio",
            $std->CodigoTributacaoMunicipio,
            true,
            "Código de Tributação"
        );

        $this->dom->addChild(
            $this->servico,
            "Discriminacao",
            $std->Discriminacao,
            true,
            "Discriminação do conteúdo da NFS-e"
        );

        $this->dom->addChild(
            $this->servico,
            "CodigoMunicipio",
            $std->CodigoMunicipio,
            true,
            "Código  de  identificação do município conforme tabela do IBGE.
            Preencher com 5 noves para serviço prestado no exterior."
        );
    }

    public function buildValores($std)
    {

        $this->dom->addChild(
            $this->valores,
            "ValorServicos",
            $std->ValorServicos,
            true,
            "Valor dos serviços em R$"
        );

        $this->dom->addChild(
            $this->valores,
            "ValorDeducoes",
            $std->ValorDeducoes,
            true,
            "Valor das deduções para Redução da Base de Cálculo em R$."
        );

        $this->dom->addChild(
            $this->valores,
            "ValorPis",
            $std->ValorPis,
            true,
            "Valor da retenção do PIS em R$"
        );

        $this->dom->addChild(
            $this->valores,
            "ValorCofins",
            $std->ValorCofins,
            true,
            "Valor da retenção do COFINS em R$"
        );

        $this->dom->addChild(
            $this->valores,
            "ValorInss",
            $std->ValorInss,
            true,
            "Valor da retenção do INSS em R$"
        );

        $this->dom->addChild(
            $this->valores,
            "ValorIr",
            $std->ValorIr,
            true,
            "Valor da retenção do IR em R$"
        );

        $this->dom->addChild(
            $this->valores,
            "ValorCsll",
            $std->ValorCsll,
            true,
            "Valor da retenção do CSLL em R$"
        );

        $this->dom->addChild(
            $this->valores,
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
            $this->valores,
            "ValorIss",
            $std->ValorIss,
            true,
            "Valor do ISS"
        );

        $this->dom->addChild(
            $this->valores,
            "OutrasRetencoes",
            $std->ValorOutrasRetencoes,
            true,
            "Valor de outras retenções"
        );

        $this->dom->addChild(
            $this->valores,
            "BaseCalculo",
            $std->BaseCalculo,
            true,
            "Valor dos serviços – Valor das deduções – descontos incondicionados"
        );

        $this->dom->addChild(
            $this->valores,
            "Aliquota",
            $std->Aliquota,
            true,
            "Valor percentual"
        );

        $this->dom->addChild(
            $this->valores,
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
            $this->valores,
            "ValorIssRetido",
            $std->ValorIssRetido,
            true,
            "Valor do ISS Retido"
        );

        $this->dom->addChild(
            $this->valores,
            "DescontoCondicionado",
            '0',
            true,
            "Valor do Desconto Condicionado"
        );

        $this->dom->addChild(
            $this->valores,
            "DescontoIncondicionado",
            $std->DescontoIncondicionado,
            true,
            "Valor do Desconto Incondicionado"
        );
    }

    public function buildItensServico($std)
    {

        $this->dom->addChild(
            $this->itensServico,
            "Descricao",
            $std->Discriminacao,
            true,
            "Descrição do serviço"
        );

        $this->dom->addChild(
            $this->itensServico,
            "Quantidade",
            $std->Quantidade,
            true,
            "Quantidade de itens"
        );

        $this->dom->addChild(
            $this->itensServico,
            "ValorUnitario",
            $std->ValorUnit,
            true,
            "Valor unitário de cada serviço"
        );
    }

    public function buildPrestador($std)
    {

        $this->dom->addChild(
            $this->prestador,
            "Cnpj",
            $std->Cnpj,
            true,
            "Número do CNPJ do prestador"
        );

        $this->dom->addChild(
            $this->prestador,
            "InscricaoMunicipal",
            $std->InscricaoMunicipal,
            true,
            "Número de Inscrição Municipal do prestador"
        );
    }

    public function buildTomador($std)
    {

        $this->dom->addChild(
            $this->tomador,
            "RazaoSocial",
            $std->RazaoSocial,
            true,
            "Razão Social do tomador"
        );
    }

    public function buildIdentificacaoTomador($std)
    {

        $cpfCnpj = $this->dom->createElement('CpfCnpj');
        $this->identificacaoTomador->appendChild($cpfCnpj);

        $this->dom->addChild(
            $cpfCnpj,
            "Cpf",
            '00000000000',
            true,
            "Número do Cpf"
        );

        $this->dom->addChild(
            $cpfCnpj,
            "Cnpj",
            $std->Cnpj,
            true,
            "Número do Cnpj"
        );

        $this->dom->addChild(
            $this->identificacaoTomador,
            "InscricaoMunicipal",
            $std->InscricaoMunicipal,
            true,
            "Número de Inscrição Municipal do tomador"
        );

        $this->dom->addChild(
            $this->identificacaoTomador,
            "InscricaoEstadual",
            $std->InscricaoMunicipal,
            true,
            "Número de Inscrição Estadual do tomador"
        );
    }

    public function buildEndereco($std)
    {

        $this->dom->addChild(
            $this->endereco,
            "Endereco",
            $std->Endereco,
            true,
            "Endereço"
        );

        $this->dom->addChild(
            $this->endereco,
            "Numero",
            $std->Numero,
            true,
            "Número do endereço"
        );

        $this->dom->addChild(
            $this->endereco,
            "Complemento",
            $std->Complemento,
            true,
            "Complemento do Endereço"
        );

        $this->dom->addChild(
            $this->endereco,
            "Bairro",
            $std->Bairro,
            true,
            "Nome do bairro"
        );

        $this->dom->addChild(
            $this->endereco,
            "CodigoMunicipio",
            $std->CodigoMunicipio,
            true,
            "Código de identificação do município conforme tabela do IBGE"
        );

        $this->dom->addChild(
            $this->endereco,
            "Uf",
            $std->Uf,
            true,
            "Sigla da unidade federativa"
        );

        $this->dom->addChild(
            $this->endereco,
            "Cep",
            $std->Cep,
            true,
            "Número do CEP"
        );
    }

    public function buildContato($std)
    {

        $this->dom->addChild(
            $this->contato,
            "Telefone",
            $std->Telefone,
            true,
            "Telefone para contato"
        );

        $this->dom->addChild(
            $this->contato,
            "Email",
            $std->Email,
            true,
            "E-mail para contato"
        );
    }

    public function buildIntermediarioServico()
    {
        $intermediarioServico = $this->dom->createElement('IntermediarioServico');
        $this->infRps->appendChild($intermediarioServico);

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
    }

    public function buildConstrucaoCivil()
    {

        $construcaoCivil = $this->dom->createElement('ConstrucaoCivil');
        $this->infRps->appendChild($construcaoCivil);

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
            $cpfCnpj,
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
