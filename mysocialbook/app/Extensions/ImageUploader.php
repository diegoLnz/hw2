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

    public function upload(Request $request, $fieldName)
    {
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

        $user = AccountManager::currentUser();

        if (!$user) {
            return ['error' => 'Utente non autenticato'];
        }

        $baseDirectory = 'storage/';
        $userDirectory = 'posts/' . $user->username;
        $fileName = $this->getFileName($baseDirectory.$userDirectory, $file);
        return ['path' => $file->storeAs($userDirectory, $fileName, 'public'), 'error' => ""];
    }

    private function getFileName(string $directory, $file)
    {
        $files = File::allFiles($directory);
        $fileCount = count($files);
        return 'post' . ($fileCount + 1) . '.' . $file->getClientOriginalExtension();
    }
}
