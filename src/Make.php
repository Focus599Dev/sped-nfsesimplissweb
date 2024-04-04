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
        
        $this->infRps = $this->dom->createElement('nfse:InfRps');

        $this->servico = $this->dom->createElement('nfse:Servico');

        $this->itensServico = $this->dom->createElement('nfse:ItensServico');

        $this->valores = $this->dom->createElement('nfse:Valores');

        $this->identificacaoRps = $this->dom->createElement('nfse:IdentificacaoRps');

        $this->prestador = $this->dom->createElement('nfse:Prestador');

        $this->tomador = $this->dom->createElement('nfse:Tomador');

        $this->identificacaoTomador = $this->dom->createElement('nfse:IdentificacaoTomador');

        $this->contato = $this->dom->createElement('nfse:Contato');

        $this->endereco = $this->dom->createElement('nfse:Endereco');
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

        $rps = $this->dom->createElement('nfse:Rps');
        $listaRps->appendChild($rps);

        $rps->appendChild($this->infRps);

        $items = $rps->getElementsByTagName('nfse:InfRps');

        $firstItem = $items->item(0);

        $firstItem->insertBefore($this->identificacaoRps, $firstItem->firstChild);

        $this->infRps->appendChild($this->servico);

        $items = $this->infRps->getElementsByTagName('nfse:Servico');

        $firstItem = $items->item(0);

        $firstItem->insertBefore($this->valores, $firstItem->firstChild);

        $this->servico->appendChild($this->itensServico);

        $this->infRps->appendChild($this->prestador);

        $this->infRps->appendChild($this->tomador);

        $items = $this->infRps->getElementsByTagName('nfse:Tomador');

        $firstItem = $items->item(0);

        $firstItem->insertBefore($this->identificacaoTomador, $firstItem->firstChild);

        $this->tomador->appendChild($this->contato);

        $contato = $this->tomador->getElementsByTagName('nfse:Contato')->item(0);

        $firstItem->insertBefore($this->endereco, $contato);

        // $this->buildIntermediarioServico();

        // $this->buildConstrucaoCivil();

        $this->xml = $this->dom->saveXML();

        return $this->xml;
    }

    public function buildLoteRps($std)
    {

        $std->NumeroLote = ltrim($std->NumeroLote, '0') . sprintf("%06d", mt_rand(1, 999999));

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
            "nfse:DataEmissao",
            $std->DataEmissao,
            true,
            "Formato AAAA-MM-DDTHH:mm:ss"
        );

        $this->dom->addChild(
            $this->infRps,
            "nfse:NaturezaOperacao",
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
            "nfse:RegimeEspecialTributacao",
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
            "nfse:OptanteSimplesNacional",
            $std->OptanteSimplesNacional,
            true,
            "Identificação de Sim/Não
                1 –Sim 
                2 –Não"
        );

        $this->dom->addChild(
            $this->infRps,
            "nfse:IncentivadorCultural",
            $std->IncentivadorCultural,
            true,
            "Identificação de Sim/Não
                1 –Sim 
                2 –Não"
        );

        $this->dom->addChild(
            $this->infRps,
            "nfse:Status",
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
            "nfse:Numero",
            $std->Numero,
            true,
            "Número do RPS"
        );

        $this->dom->addChild(
            $this->identificacaoRps,
            "nfse:Serie",
            $std->Serie,
            true,
            "Número de série do RPS"
        );

        $this->dom->addChild(
            $this->identificacaoRps,
            "nfse:Tipo",
            '1',
            true,
            "Código de tipo de RPS.
            1 –RPS
            2 –Nota Fiscal Conjugada (Mista)
            3 –Cupom"
        );

        $this->infRps->setAttribute('id', $std->Numero);
    }

    public function buildServico($std)
    {

        $this->dom->addChild(
            $this->servico,
            "nfse:ItemListaServico",
            $std->ItemListaServico,
            true,
            "Código de item da lista de serviço"
        );

        $this->dom->addChild(
            $this->servico,
            "nfse:CodigoCnae",
            $std->CodigoCnae,
            true,
            "Código CNAE"
        );

        $this->dom->addChild(
            $this->servico,
            "nfse:CodigoTributacaoMunicipio",
            $std->CodigoTributacaoMunicipio,
            true,
            "Código de Tributação"
        );

        $this->dom->addChild(
            $this->servico,
            "nfse:Discriminacao",
            $std->Discriminacao,
            true,
            "Discriminação do conteúdo da NFS-e"
        );

        $this->dom->addChild(
            $this->servico,
            "nfse:CodigoMunicipio",
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
            "nfse:ValorServicos",
            $std->ValorServicos,
            true,
            "Valor dos serviços em R$"
        );

        $this->dom->addChild(
            $this->valores,
            "nfse:ValorDeducoes",
            $std->ValorDeducoes,
            true,
            "Valor das deduções para Redução da Base de Cálculo em R$."
        );

        $this->dom->addChild(
            $this->valores,
            "nfse:ValorPis",
            $std->ValorPis,
            true,
            "Valor da retenção do PIS em R$"
        );

        $this->dom->addChild(
            $this->valores,
            "nfse:ValorCofins",
            $std->ValorCofins,
            true,
            "Valor da retenção do COFINS em R$"
        );

        $this->dom->addChild(
            $this->valores,
            "nfse:ValorInss",
            $std->ValorInss,
            true,
            "Valor da retenção do INSS em R$"
        );

        $this->dom->addChild(
            $this->valores,
            "nfse:ValorIr",
            $std->ValorIr,
            true,
            "Valor da retenção do IR em R$"
        );

        $this->dom->addChild(
            $this->valores,
            "nfse:ValorCsll",
            $std->ValorCsll,
            true,
            "Valor da retenção do CSLL em R$"
        );

        $this->dom->addChild(
            $this->valores,
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
            $this->valores,
            "nfse:ValorIss",
            $std->ValorIss,
            true,
            "Valor do ISS"
        );

        $this->dom->addChild(
            $this->valores,
            "nfse:OutrasRetencoes",
            $std->ValorOutrasRetencoes,
            true,
            "Valor de outras retenções"
        );

        $this->dom->addChild(
            $this->valores,
            "nfse:BaseCalculo",
            $std->BaseCalculo,
            true,
            "Valor dos serviços – Valor das deduções – descontos incondicionados"
        );

        $this->dom->addChild(
            $this->valores,
            "nfse:Aliquota",
            $std->Aliquota,
            true,
            "Valor percentual"
        );

        $this->dom->addChild(
            $this->valores,
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
            $this->valores,
            "nfse:ValorIssRetido",
            $std->ValorIssRetido,
            true,
            "Valor do ISS Retido"
        );

        $this->dom->addChild(
            $this->valores,
            "nfse:DescontoCondicionado",
            '0',
            true,
            "Valor do Desconto Condicionado"
        );

        $this->dom->addChild(
            $this->valores,
            "nfse:DescontoIncondicionado",
            $std->DescontoIncondicionado,
            true,
            "Valor do Desconto Incondicionado"
        );
    }

    public function buildItensServico($std)
    {

        $this->dom->addChild(
            $this->itensServico,
            "nfse:Descricao",
            $std->Discriminacao,
            true,
            "Descrição do serviço"
        );

        $this->dom->addChild(
            $this->itensServico,
            "nfse:Quantidade",
            $std->Quantidade,
            true,
            "Quantidade de itens"
        );

        $this->dom->addChild(
            $this->itensServico,
            "nfse:ValorUnitario",
            $std->ValorUnit,
            true,
            "Valor unitário de cada serviço"
        );
    }

    public function buildPrestador($std)
    {

        $this->dom->addChild(
            $this->prestador,
            "nfse:Cnpj",
            $std->Cnpj,
            true,
            "Número do CNPJ do prestador"
        );

        $this->dom->addChild(
            $this->prestador,
            "nfse:InscricaoMunicipal",
            $std->InscricaoMunicipal,
            true,
            "Número de Inscrição Municipal do prestador"
        );
    }

    public function buildTomador($std)
    {

        $this->dom->addChild(
            $this->tomador,
            "nfse:RazaoSocial",
            $std->RazaoSocial,
            true,
            "Razão Social do tomador"
        );
    }

    public function buildIdentificacaoTomador($std)
    {

        $cpfCnpj = $this->dom->createElement('nfse:CpfCnpj');
        $this->identificacaoTomador->appendChild($cpfCnpj);
        
        if (strlen($std->Cnpj) > 11){
            $this->dom->addChild(
                $cpfCnpj,
                "nfse:Cnpj",
                $std->Cnpj,
                true,
                "Número do Cnpj"
            );
        } else {
            $this->dom->addChild(
                $cpfCnpj,
                "nfse:Cpf",
                $std->Cnpj,
                true,
                "Número do Cpf"
            );
        }
       

        $this->dom->addChild(
            $this->identificacaoTomador,
            "nfse:InscricaoMunicipal",
            $std->InscricaoMunicipal,
            false,
            "Número de Inscrição Municipal do tomador"
        );

        $this->dom->addChild(
            $this->identificacaoTomador,
            "nfse:InscricaoEstadual",
            $std->InscricaoMunicipal,
            false,
            "Número de Inscrição Estadual do tomador"
        );
    }

    public function buildEndereco($std)
    {

        $this->dom->addChild(
            $this->endereco,
            "nfse:Endereco",
            $std->Endereco,
            true,
            "Endereço"
        );

        $this->dom->addChild(
            $this->endereco,
            "nfse:Numero",
            $std->Numero,
            true,
            "Número do endereço"
        );

        $this->dom->addChild(
            $this->endereco,
            "nfse:Complemento",
            $std->Complemento,
            true,
            "Complemento do Endereço"
        );

        $this->dom->addChild(
            $this->endereco,
            "nfse:Bairro",
            $std->Bairro,
            true,
            "Nome do bairro"
        );

        $this->dom->addChild(
            $this->endereco,
            "nfse:CodigoMunicipio",
            $std->CodigoMunicipio,
            true,
            "Código de identificação do município conforme tabela do IBGE"
        );

        $this->dom->addChild(
            $this->endereco,
            "nfse:Uf",
            $std->Uf,
            true,
            "Sigla da unidade federativa"
        );

        $this->dom->addChild(
            $this->endereco,
            "nfse:Cep",
            $std->Cep,
            true,
            "Número do CEP"
        );
    }

    public function buildContato($std)
    {

        $this->dom->addChild(
            $this->contato,
            "nfse:Telefone",
            $std->Telefone,
            true,
            "Telefone para contato"
        );

        $this->dom->addChild(
            $this->contato,
            "nfse:Email",
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
            "nfse:RazaoSocial",
            '',
            true,
            "Razão Social do intermediário"
        );

        $cpfCnpj = $this->dom->createElement('CpfCnpj');
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
    }

    public function buildConstrucaoCivil()
    {

        $construcaoCivil = $this->dom->createElement('ConstrucaoCivil');
        $this->infRps->appendChild($construcaoCivil);

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
    }

    public function cancelamento($std)
    {
        $pedido = $this->dom->createElement('nfse:Pedido');

        $this->dom->appendChild($pedido);

        $infPedidoCancelamento = $this->dom->createElement('nfse:InfPedidoCancelamento');

        $IdentificacaoNfse = $this->dom->createElement('nfse:IdentificacaoNfse');

        $this->dom->addChild(
            $IdentificacaoNfse,
            "nfse:Numero",
            $std->Numero,
            true,
            "Número da Nota Fiscal de Serviço Eletrônica Formato AAAANNNNNNNNNNN"
        );

        $this->dom->addChild(
            $IdentificacaoNfse,
            "nfse:Cnpj",
            $std->cnpj,
            true,
            "CNPJ"
        );

        $this->dom->addChild(
            $IdentificacaoNfse,
            "nfse:InscricaoMunicipal",
            $std->InscricaoMunicipal,
            true,
            "Número de inscrição municipal"
        );

        $this->dom->addChild(
            $IdentificacaoNfse,
            "nfse:CodigoMunicipio",
            $std->CodigoMunicipio,
            true,
            "Código de identificação do município conforme1-1tabela do IBGE"
        );

        $infPedidoCancelamento->appendChild($IdentificacaoNfse);

        $this->dom->addChild(
            $infPedidoCancelamento,
            "nfse:CodigoCancelamento",
            $std->CodigoCancelamento,
            true,
            "Código de cancelamento com base na tabela de Erros e Alertas"
        );

        $pedido->appendChild($infPedidoCancelamento);

        $this->dom->appendChild($pedido);

        return $this->dom->saveXML();

    }

    public function consultaSituacaoLote($std)
    {

        $prestador = $this->dom->createElement('nfse:Prestador');
        $Protocolo = $this->dom->createElement('nfse:Protocolo');
        
        $this->dom->addChild(
            $prestador,
            "nfse:Cnpj",
            $std->cnpj,
            true,
            "Número do CNPJ do prestador"
        );

        $this->dom->addChild(
            $prestador,
            "nfse:InscricaoMunicipal",
            $std->InscricaoMunicipal,
            true,
            "Número de Inscrição Municipal do prestador"
        );

        $Protocolo->nodeValue =  $std->protocolo;

        $this->dom->appendChild($prestador);

        $this->dom->appendChild($Protocolo);

        return $this->dom->saveXML();
    }

    public function consultarNfsePorRps($std)
    {

        $prestador = $this->dom->createElement('nfse:Prestador');
        
        $IdentificacaoRps = $this->dom->createElement('nfse:IdentificacaoRps');
        
        $this->dom->addChild(
            $prestador,
            "nfse:Cnpj",
            $std->cnpj,
            true,
            "Número do CNPJ do prestador"
        );

        $this->dom->addChild(
            $prestador,
            "nfse:InscricaoMunicipal",
            $std->InscricaoMunicipal,
            true,
            "Número de Inscrição Municipal do prestador"
        );

        $this->dom->addChild(
            $IdentificacaoRps,
            "nfse:Numero",
            $std->Numero,
            true,
            "Número do RPS"
        );

        $this->dom->addChild(
            $IdentificacaoRps,
            "nfse:Serie",
            $std->Serie,
            true,
            "Número de série do RPS"
        );

        $this->dom->addChild(
            $IdentificacaoRps,
            "nfse:Tipo",
            '1',
            true,
            "Código de tipo de RPS.
            1 –RPS
            2 –Nota Fiscal Conjugada (Mista)
            3 –Cupom"
        );

        $this->dom->appendChild($IdentificacaoRps);

        $this->dom->appendChild($prestador);

        return $this->dom->saveXML();
    }
}
