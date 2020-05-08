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

    protected function sendRequest($request, $soapUrl)
    {

        $soap = new Soap;

        $response = $soap->send($request, $soapUrl);

        return (string) $response;
    }

    public function envelopXML($xml, $method)
    {

        $xml = trim(preg_replace("/<\?xml.*?\?>/", "", $xml));


        return $this->xml;
    }

    public function envelopSoapXML($xml)
    {

        return $this->xml;
    }

    public function getLastRequest()
    {
        return $this->lastRequest;
    }
}
