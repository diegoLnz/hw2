<?php

namespace App\Http\Controllers;

use App\BusinessLogic\NasaBL;
use App\Extensions\AccountManager;
use App\Extensions\ApiExtensions;
use App\Models\NasaSavedVideo;

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
        $maxItems = 50;
        
        foreach ($jsonResp->collection->items as $item)
        {
            if ($counter >= $maxItems)
                break;

            $resp[] = $item->data[0]->title;

            $counter++;
        }

        return response()->json($resp);
    }

    public function getVideoFromTitle($title)
    {
        $path = NasaBL::getCollectionPathFromTitle($title);
        $itemResp = NasaBL::getResponse($path);
            
        foreach ($itemResp as $url) {
            if (substr($url, -4) === '.mp4') {
                $video = NasaSavedVideo::where('video_path', $url)
                    ->where('user_id', AccountManager::currentUser()->id)
                    ->first();

                return view('nasa-video-detail')
                    ->with(['url' => $url])
                    ->with(['isLiked' => $video != null])
                    ->with('user', AccountManager::currentUser());
            }
        }

        return view('nasa-video-detail')
            ->with(['url' => ""])
            ->with('user', AccountManager::currentUser());
    }

    public function saveVideo($title)
    {
        $path = NasaBL::getCollectionPathFromTitle($title);
        $result = NasaBL::saveOrDeleteVideo($path);
        return ['isSuccess' => $result];
    }
}