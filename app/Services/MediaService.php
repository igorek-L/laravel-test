<?php

namespace App\Services;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class MediaService
{
    /**
     * @param $path
     * @param $name
     * @param $configKey
     */
    public function resizeAndSaveImageByConfig($path, $name, $configKey)
    {
        // resize and save  image
        $fileExtension = pathinfo($name)['extension'];
        $fileName =  pathinfo($name)['filename'];
        $absolutePath = public_path().$path;

        foreach (app('config')->get('imageSizes')[$configKey] as $key => $value) {
            $newFileName = $fileName . '_' . $key . '_' . $value['width'] . 'x' . $value['height'] . '.' . $fileExtension;
            Image::make($absolutePath . $name)
                ->resize($value['width'], $value['height'])->save($absolutePath . $newFileName);
        }
    }

    public function saveImage($file)
    {
        $folderFormat = date('Y/m/d');

        Storage::makeDirectory($this->getAbsolutePath($folderFormat));

        $fileExtention = $this->getExtension($file);

        $newFileName = $this->generateNewFileName() . '.' . $fileExtention;

        // save original image
        $file->move($this->getAbsolutePath($folderFormat), $newFileName);

        return [
            'path' => $this->getRelativePath($folderFormat),
            'image' => $newFileName,
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
