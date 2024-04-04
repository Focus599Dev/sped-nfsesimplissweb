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


        $this->lastRequest = $this->removeStuffs($request);

        $soapAction = 'http://www.sistema.com.br/Sistema.Ws.Nfse/INfseService/RecepcionarLoteRps';

        $response = $this->sendRequest($request, $this->soapUrl, $soapAction);
        
        echo $response;

        echo $request;

        $this->lastResponse = $this->removeStuffs($response);

        return $this->lastResponse;
    }

    public function CancelaNfse($std)
    {

        $make = new Make();

        $xml = $make->cancelamento($std);

        $xml = Strings::clearXmlString($xml);

        $method = 'CancelarNfse';

        $method2 = 'CancelarNfseEnvio';

        $request = $this->envelopXML($xml, $method, $method2);

        $request = $this->envelopSoapXML($request);

        $soapAction = 'http://www.sistema.com.br/Sistema.Ws.Nfse/INfseService/CancelarNfse';

        $response = $this->sendRequest($request, $this->soapUrl, $soapAction);
        
        $this->lastResponse = $this->removeStuffs($response);

        return $this->lastResponse;
    }

    public function consultaSituacaoLoteRPS($std, $codigoCidade)
    {

        $make = new Make();

        $xml = $make->consultaSituacaoLote($std);

        $xml = Strings::clearXmlString($xml);

        $method = 'ConsultarSituacaoLoteRps';

        $method2 = 'ConsultarSituacaoLoteRpsEnvio';

        $request = $this->envelopXML($xml, $method, $method2);

        $request = $this->envelopSoapXML($request);

        $soapAction = 'http://www.sistema.com.br/Sistema.Ws.Nfse/INfseService/ConsultarSituacaoLoteRps';

        $response = $this->sendRequest($request, $this->soapUrl, $soapAction );

        echo $response;
        
        echo $request;

        $this->lastResponse = $this->removeStuffs($response);

        return $this->lastResponse;
    }

    public function ConsultarNfsePorRps($std, $codigoCidade)
    {

        $make = new Make();

        $xml = $make->consultarNfsePorRps($std);

        $xml = Strings::clearXmlString($xml);

        $method = 'ConsultarNfsePorRps';

        $method2 = 'ConsultarNfseRpsEnvio';

        $request = $this->envelopXML($xml, $method, $method2);

        $request = $this->envelopSoapXML($request);

        $soapAction = 'http://www.sistema.com.br/Sistema.Ws.Nfse/INfseService/ConsultarNfsePorRps';

        $response = $this->sendRequest($request, $this->soapUrl, $soapAction );

        echo $response;
        
        echo $request;

        $this->lastResponse = $this->removeStuffs($response);

        return $this->lastResponse;
    }
}
