<?php

namespace App\Http\Controllers;

use App\BusinessLogic\NasaBL;
use App\Extensions\AccountManager;
use App\Extensions\ApiExtensions;

class NasaController extends Controller
{
    public function getPicOfTheDay()
    {
        $jsonResp = NasaBL::getApodResponse();

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

    public function nasaVideoLibrary()
    {
        return view('nasa-video-library')
        ->with('user', AccountManager::currentUser());
    }

    public function videoListForSearch(string $searchString)
    {
        $jsonResp = NasaBL::getVideoLibraryResponse($searchString);
        $resp = [];
        $counter = 0;
        
        foreach ($jsonResp->collection->items as $item)
        {
            $itemResp = NasaBL::getResponse($item->href);
            
            foreach ($itemResp as $url) {
                if (substr($url, -4) === '.mp4') {
                    if ($counter < 50) {
                        $resp[] = $url;
                        $counter++;
                        break;
                    } else {
                        break 2;
                    }
                }
            }
            
            if ($counter >= 100) {
                break;
            }
        }

        return response()->json($resp);
    }
}