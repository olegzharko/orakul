<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function add_card_clients($card_id, $clients)
    {
        if ($card_id && count($clients)) {
            foreach ($clients as $client) {
                $card_client = new Contact();
                $card_client->card_id = $card_id;
                $card_client->full_name = $client['full_name'];
                $card_client->phone = $client['phone'];
                $card_client->save();
            }
        }
    }

    public function update_card_client($card_id, $clients)
    {
        Contact::where('card_id', $card_id)->delete();

        $this->add_card_clients($card_id, $clients);
    }
}
