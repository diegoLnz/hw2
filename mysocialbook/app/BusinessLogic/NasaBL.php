<?php

namespace App\BusinessLogic;

use App\Extensions\CurlHelper;
use App\Extensions\NasaConfig;
use App\Models\NasaImage;
use App\Models\NasaPost;
use DB;

class NasaBL
{
    public static function getResponse()
    {
        $apiKey = NasaConfig::getApiKey();
        $curlHelper = new CurlHelper();
        $response = $curlHelper->get("https://api.nasa.gov/planetary/apod?api_key=$apiKey");
        return json_decode($response);
    }

    public static function SavePicIfNotExists($picData): int
    {
        $image = NasaImage::where('network_path', $picData['url'])->first();
        if ($image)
        {
            return $image->id;
        }

        $imgId = self::saveImage($picData['url']);
        if($imgId == 0){
            return 0;
        }

        $picToSave = [
            "post_description" => $picData['explanation'],
            "publish_date" => $picData['date'],
            "image_id" => $imgId
        ];

        $nasaPost = NasaPost::create($picToSave);

        return $nasaPost->id;
    }

    private static function saveImage(string $path): int
    {
        $img = [
            "network_path" => $path
        ];
        $image = NasaImage::create($img);
        return $image->id;
    }
}