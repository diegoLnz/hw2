<?php

namespace App\Extensions;

use Storage;
use App\Extensions\AccountManager;
use App\Models\User;
use Illuminate\Http\Request;
use File;

class ImageUploader {
    private $allowedExtensions = ['jpg', 'jpeg', 'png'];

    /**
     * 10 MB
     */
    private $maxFileSize = 10000000;

    public function __construct()
    {}

    public function upload(Request $request, string $fieldName, string $username = null, string $mainDirectory = "posts")
    {
        if ($username == null)
        {
            $user = AccountManager::currentUser();
            $username = $user->username;
        }

        if (!$request->hasFile($fieldName) || !$request->file($fieldName)->isValid()) {
            return ['error' => 'Nessun file caricato o file non valido'];
        }

        $file = $request->file($fieldName);
        
        if (!in_array($file->getClientOriginalExtension(), $this->allowedExtensions)) {
            return ['error' => 'Non è ammessa tale estensione'];
        }
        
        if ($file->getSize() > $this->maxFileSize) {
            return ['error' => 'Il file supera la dimensione massima supportata'];
        }

        $baseDirectory = 'storage/';
        $semiDirectory = $baseDirectory.$mainDirectory;
        if (!is_dir($semiDirectory)) {
            mkdir($semiDirectory);
        }

        $userDirectory = $mainDirectory.'/' . $username;
        $fileName = $this->getFileName($baseDirectory.$userDirectory, $file);
        return ['path' => $file->storeAs($userDirectory, $fileName, 'public'), 'error' => ""];
    }

    private function getFileName(string $directory, $file)
    {
        if (!is_dir($directory)) {
            mkdir($directory);
        }

        $relativeDirectory = str_replace('storage/', '', $directory);
        $baseName = 'post';
        $extension = $file->getClientOriginalExtension();
        $counter = 1;

        do {
            $fileName = $baseName . $counter . '.' . $extension;
            $filePath = $relativeDirectory . '/' . $fileName;
            $counter++;
        } while (Storage::disk('public')->exists($filePath));

        return $fileName;
    }
}
