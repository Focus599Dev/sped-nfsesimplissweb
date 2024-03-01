<?php

namespace NFePHP\NFSe\SIMPLISSWEB\Factories;

use NFePHP\NFSe\SIMPLISSWEB\Make;
use NFePHP\Common\Strings;

class Parser
{

    public function __construct($version = '3.0.1')
    {

        $ver = str_replace('.', '', $version);

        $path = realpath(__DIR__ . "/../../storage/txtstructure.json");

        $this->LoteRps = new \stdClass();

        $this->IdentificacaoRps = new \stdClass();

        $this->InfRps = new \stdClass();

        $this->Valores = new \stdClass();

        $this->Servico = new \stdClass();

        $this->ItensServico = new \stdClass();

        $this->cpfCnpj = new \stdClass();

        $this->InscricaoMunicipal = new \stdClass();

        $this->Tomador = new \stdClass();

        $this->Prestador = new \stdClass();

        $this->Endereco = new \stdClass();

        $this->Contato = new \stdClass();

        $this->structure = json_decode(file_get_contents($path), true);

        $this->version = $version;

        $this->make = new Make();
    }

    public function toXml($nota)
    {

        $this->array2xml($nota);

        if ($this->make->monta()) {

            return $this->make->getXML();
        }

        return null;
    }

    protected function array2xml($nota)
    {

        foreach ($nota as $lin) {

            $fields = explode('|', $lin);

            if (empty($fields)) {
                continue;
            }

            $metodo = strtolower(str_replace(' ', '', $fields[0])) . 'Entity';

            if (method_exists(__CLASS__, $metodo)) {

                $struct = $this->structure[strtoupper($fields[0])];

                $std = $this->fieldsToStd($fields, $struct);

                $this->$metodo($std);
            }
        }
    }

    protected function fieldsToStd($dfls, $struct)
    {

        $sfls = explode('|', $struct);

        $len = count($sfls) - 1;

        $std = new \stdClass();

        for ($i = 1; $i < $len; $i++) {

            $name = $sfls[$i];

            if (isset($dfls[$i]))
                $data = $dfls[$i];
            else
                $data = '';

            if (!empty($name)) {

                $std->$name = Strings::replaceSpecialsChars($data);
            }
        }

        return $std;
    }

    private function aEntity($std)
    {
        $this->LoteRps = (object) array_merge((array) $this->LoteRps, (array) $std);
    }

    private function bEntity($std)
    {
        $this->LoteRps = (object) array_merge((array) $this->LoteRps, (array) $std);
    }

    private function cEntity($std)
    {
        $this->LoteRps = (object) array_merge((array) $this->LoteRps, (array) $std);

        $this->make->buildLoteRps($this->LoteRps);

        $this->Prestador = (object) array_merge((array) $this->Prestador, (array) $std);

        $this->make->buildPrestador($this->Prestador);
    }

    private function eEntity($std)
    {
        $this->Tomador = (object) array_merge((array) $this->Tomador, (array) $std);

        $this->make->buildTomador($this->Tomador);

        $this->Endereco = (object) array_merge((array) $this->Endereco, (array) $std);

        $this->make->buildEndereco($this->Endereco);

        $this->Contato = (object) array_merge((array) $this->Contato, (array) $std);

        $this->make->buildContato($this->Contato);
    }

    private function e02Entity($std)
    {
        $this->cpfCnpj = (object) array_merge((array) $this->cpfCnpj, (array) $std);

        $this->InscricaoMunicipal = (object) array_merge((array) $this->InscricaoMunicipal, (array) $std);

        $this->make->buildIdentificacaoTomador($this->InscricaoMunicipal);
    }

    private function h01Entity($std)
    {
        $this->IdentificacaoRps = (object) array_merge((array) $this->IdentificacaoRps, (array) $std);

        $this->make->buildIdentificacaoRps($this->IdentificacaoRps);
    }

    private function mEntity($std)
    {
        $this->Valores = (object) array_merge((array) $this->Valores, (array) $std);

        $this->make->buildValores($this->Valores);
    }

    private function nEntity($std)
    {
        $this->Servico = (object) array_merge((array) $this->Servico, (array) $std);

        $this->make->buildServico($this->Servico);

        $this->ItensServico = (object) array_merge((array) $this->ItensServico, (array) $std);

        $this->make->buildItensServico($this->ItensServico);
    }

    private function wEntity($std)
    {
        $this->InfRps = (object) array_merge((array) $this->InfRps, (array) $std);

        $this->make->buildInfRps($this->InfRps);
    }
}
