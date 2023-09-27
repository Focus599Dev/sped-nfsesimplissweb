<?php

namespace NFePHP\NFSe\SIMPLISSWEB;

use DOMDocument;
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

        $method = 'RecepcionarLoteRps';

        $method2 = 'EnviarLoteRpsEnvio';

        $request = $this->envelopXML($xml, $method, $method2);

        $request = $this->envelopSoapXML($request);

        $request = Signer::sign(
            $this->certificate,
            $request,
            'Rps',
            'Id',
            $this->algorithm,
            $this->canonical
        );

        $request = Signer::sign(
            $this->certificate,
            $request,
            'EnviarLoteRpsEnvio',
            'Id',
            $this->algorithm,
            $this->canonical
        );


        $this->lastRequest = $request;

        $soapAction = 'http://www.sistema.com.br/Sistema.Ws.Nfse/INfseService/RecepcionarLoteRps';

        $response = $this->sendRequest($request, $this->soapUrl, $soapAction);
       
        echo $response;

        echo $this->lastRequest;

        $this->lastResponse = $this->removeStuffs($response);

        return $this->lastResponse;
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
