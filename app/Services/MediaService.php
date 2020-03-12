<?php

namespace App\Services;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    /**
     * @param $file
     * @return array
     */
    public function uploadImage($file)
    {
        $folderFormat = date('Y/m/d');

        Storage::makeDirectory($this->getAbsolutePath($folderFormat));

        $newFileName = $this->generateNewFileName() . '.' . $this->getExtension($file);

        $file->move($this->getAbsolutePath($folderFormat), $newFileName);

        return [
            'path' =>$this->getRelativePath($folderFormat),
            'image' => $newFileName
        ];
    }

    /**
     * @return string
     */
    public function generateNewFileName()
    {

        return Str::random(40);
    }

    /**
     * @param $folderFormat
     * @return string
     */
    public function getRelativePath($folderFormat)
    {
        return '/images/' . $folderFormat . '/';
    }

    /**
     * @param $folderFormat
     * @return string
     */
    public function getAbsolutePath($folderFormat)
    {
        return public_path() . '/images/' . $folderFormat . '/';
    }

    /**
     * @param $file
     * @return mixed|string
     */
    public function getExtension($file)
    {

        return pathinfo($file->getClientOriginalName())['extension'];
    }

}
