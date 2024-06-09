<?php

namespace App\Http\Controllers;

use App\BusinessLogic\NasaBL;
use App\Extensions\ApiExtensions;

class NasaController extends Controller
{
    public function getPicOfTheDay()
    {
        $jsonResp = NasaBL::getResponse();

        $pic = [
            'date' => $jsonResp->date,
            'explanation' => $jsonResp->explanation,
            'url' => $jsonResp->url
        ];

        $picId = NasaBL::SavePicIfNotExists($pic);
        if ($picId == 0)
        {
            $response = ApiExtensions::setResponse("KO", "Errore durante il salvataggio della APOD", 400);
            return $response->toJson();
        }

        $picWithId = [
            'date' => $jsonResp->date,
            'explanation' => $jsonResp->explanation,
            'url' => $jsonResp->url,
            'post_id' => $picId
        ];

        http_response_code(200);
        return json_encode($picWithId);
    }
}