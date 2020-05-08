<?php

namespace NFePHP\NFSe\SIMPLISSWEB;

use NFePHP\Common\Strings;
use NFePHP\NFSe\SIMPLISSWEB\Common\Signer;
use NFePHP\NFSe\SIMPLISSWEB\Common\Tools as ToolsBase;
use NFePHP\NFSe\SIMPLISSWEB\Make;

class Tools extends ToolsBase
{
    public function enviaRPS($xml)
    {

        if (empty($xml)) {
            throw new InvalidArgumentException('$xml');
        }

        $xml = Strings::clearXmlString($xml);

        $servico = 'enviar';

        $xsd = 'ReqEnvioLoteRPS.xsd';

        $this->lastRequest = htmlspecialchars_decode($xml);

        $request = Signer::sign(
            $this->certificate,
            $xml,
            'EnviarLoteRpsEnvio',
            'Id',
            $this->algorithm,
            $this->canonical
        );
        var_dump('ae');
        $request = $this->envelopXML($xml, $servico);

        $request = $this->envelopSoapXML($request);
        echo $request;
        die;
        $response = $this->sendRequest($request, $this->soapUrl);

        $response = strip_tags($response);

        $response = htmlspecialchars_decode($response);

        return $response;
    }

    public function CancelaNfse($std)
    {

        $make = new Make();

        $xml = $make->cancelamento($std);

        $xml = Strings::clearXmlString($xml);

        $servico = 'cancelar';

        $request = $this->envelopXML($xml, $servico);

        $request = $this->envelopSoapXML($request);

        $response = $this->sendRequest($request, $this->soapUrl);

        $response = strip_tags($response);

        $response = htmlspecialchars_decode($response);

        return $response;
    }

    public function consultaSituacaoLoteRPS($std)
    {

        $make = new Make();


        $xml = $make->consulta($std, $codigoCidade);

        $xml = Strings::clearXmlString($xml);

        $servico = 'consultarLote';

        $request = $this->envelopXML($xml, $servico);

        $request = $this->envelopSoapXML($request);

        $response = $this->sendRequest($request, $this->soapUrl);

        $response = strip_tags($response);

        $response = htmlspecialchars_decode($response);

        return $response;
    }
}
