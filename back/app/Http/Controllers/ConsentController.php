<?php

namespace App\Http\Controllers;

use App\Models\ClientSpouse;
use App\Models\ClientSpouseConsent;
use Illuminate\Http\Request;

class ConsentController extends GeneratorController
{
    public $word;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_consent_spouses($client)
    {
        $client_spouses = null;
        $client_spouses_consent = null;

        $client_spouses = $this->get_client_spouses($client->id);
        $client_spouses_consent = $this->get_client_spouses_consent($client_spouses->id);

        return $client_spouses_consent;
    }

    private function get_client_spouses($client_id)
    {
        $client_spouses = ClientSpouse::where('client_id', $client_id)->first();

        if (!$client_spouses)
            dd('ClientSpouse not found');

        return $client_spouses;
    }

    private function get_client_spouses_consent($client_spouses_id)
    {
        $client_spouses_consent = ClientSpouseConsent::where([
            'client_spouse_id' => $client_spouses_id,
            'active' => 1,
        ])->first();

        if (!$client_spouses_consent)
            dd('ClientSpouseConsent not found');

        return $client_spouses_consent;
    }
}
