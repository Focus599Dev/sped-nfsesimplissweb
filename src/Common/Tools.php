<?php

namespace NFePHP\NFSe\SIMPLISSWEB\Common;

use NFePHP\Common\Certificate;
use NFePHP\NFSe\SIMPLISSWEB\Common\Signer;
use NFePHP\Common\Validator;
use NFePHP\NFSe\SIMPLISSWEB\Soap\Soap;

class Tools
{

    public $soapUrl;

    public $config;

    public $soap;

    public $pathSchemas;

    protected $certificate;

    protected $algorithm = OPENSSL_ALGO_SHA1;

    protected $canonical = [false, false, null, null];

    public function __construct($configJson, Certificate $certificate)
    {
        $this->pathSchemas = realpath(
            __DIR__ . '/../../schemas'
        ) . '/';

        $this->certificate = $certificate;

        $this->config = json_decode($configJson);

        if ($this->config->tpAmb == '1') {

            $this->soapUrl = 'http://wspatrocinio.simplissweb.com.br/nfseservice.svc?singleWsdl';
        } else {

            $this->soapUrl = 'http://wshomologacao.simplissweb.com.br/nfseservice.svc?singleWsdl';
        }
    }

    protected function sendRequest($request, $soapUrl, $soapAction)
    {

        $soap = new Soap;

        $response = $soap->send($request, $soapUrl, $soapAction);

        return (string) $response;
    }

    public function envelopXML($xml, $method, $method2)
    {
        $xml = trim(preg_replace("/<\?xml.*?\?>/", "", $xml));

        $this->xml = '<sis:' . $method . '>
                        <sis:' . $method2 . '>' . $xml . '
                        </sis:' . $method2 . '>
                        <sis:pParam>
                            <sis1:P1>' . $this->config->user . '</sis1:P1>
                            <sis1:P2>' . $this->config->password . '</sis1:P2>
                        </sis:pParam>
                    </sis:' . $method . '>';

        return $this->xml;
    }

    public function envelopSoapXML($xml)
    {
        $this->xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sis="http://www.sistema.com.br/Sistema.Ws.Nfse" xmlns:nfse="http://www.sistema.com.br/Nfse/arquivos/nfse_3.xsd" xmlns:xd="http://www.w3.org/2000/09/xmldsig#" xmlns:sis1="http://www.sistema.com.br/Sistema.Ws.Nfse.Cn">
        <soapenv:Header/>
        <soapenv:Body>
        ' . $xml . '</soapenv:Body>
        </soapenv:Envelope>';

        return $this->xml;
    }

    public function getLastRequest()
    {
        return $this->lastRequest;
    }
}
