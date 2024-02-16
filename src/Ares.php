<?php

namespace Ewebovky\Ares;

use RestClient;

const BASE_URL = "https://ares.gov.cz/ekonomicke-subjekty-v-be/rest";

class Ares
{
    public function searchSubjects(string|int $search)
    {
        if ($this->verifyIC($search)) {
            return array($this->vratEkonomickySubjekt($search));
        } else {
            return $this->vyhledejEkonomickeSubjekty($search);
        }
    }

    public function vratEkonomickySubjekt(int $ico)
    {
        $api = new RestClient(['base_url' => BASE_URL]);

        $result = $api->get("ekonomicke-subjekty/" . $ico);

        if ($result->info->http_code == 200) {
            return $result->decode_response();
        }

        return $result;
    }

    public function vyhledejEkonomickeSubjekty(string $company)
    {
        $api = new RestClient([
            'base_url' => BASE_URL,
        ]);

        $headers = [
            'accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $parameters = [
            'obchodniJmeno' => $company
        ];

        $result = $api->post("ekonomicke-subjekty/vyhledat", json_encode($parameters), $headers);

        if ($result->info->http_code == 200) {
            return $result->decode_response()->ekonomickeSubjekty;
        }

        return $result;
    }

    public function verifyIC($ic)
    {
        $ic = preg_replace('#\s+#', '', $ic);

        if (!preg_match('#^\d{8}$#', $ic)) {
            return false;
        }

        // kontrolní součet
        $a = 0;
        for ($i = 0; $i < 7; $i++) {
            $a += $ic[$i] * (8 - $i);
        }

        $a = $a % 11;
        if ($a === 0) {
            $c = 1;
        } elseif ($a === 1) {
            $c = 0;
        } else {
            $c = 11 - $a;
        }

        return (int) $ic[7] === $c;
    }

    public function overitDIC($dic)
    {
        $soap = new \SoapClient('http://adisrws.mfcr.cz/adistc/axis2/services/rozhraniCRPDPH.rozhraniCRPDPHSOAP?wsdl');

        return $soap->getStatusNespolehlivyPlatce(['dic' => $dic]);
    }
}
