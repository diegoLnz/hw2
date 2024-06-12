<?php

namespace App\Extensions;

use Storage;
use App\Extensions\AccountManager;
use App\Models\User;
use Illuminate\Http\Request;

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

        $userDirectory = 'posts/' . $user->id;
        $fileName = $this->getFileName($user, $userDirectory, $file);
        return ['path' => $file->storeAs($userDirectory, $fileName, 'public')];
    }

    private function getFileName(User $user, string $directory, $file)
    {
        $fileCount = count(Storage::files($directory));
        return 'post' . ($fileCount + 1) . '.' . $file->getClientOriginalExtension();
    }
}
