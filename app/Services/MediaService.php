<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

/**
 * Class MediaService
 * @package App\Services
 */
class MediaService
{
    /**
     * @param $path
     * @param $name
     * @param $configKey
     */
    public function resizeAndSaveImageByConfig($path, $name, $configKey): void
    {
        // resize and save  image
        $fileExtension = pathinfo($name)['extension'];
        $fileName = pathinfo($name)['filename'];
        $absolutePath = public_path() . $path;

        foreach (app('config')->get('imageSizes')[$configKey] as $key => $value) {
            $newFileName = $fileName . '_' . $key . '_' . $value['width'] . 'x' . $value['height'] . '.' . $fileExtension;
            Image::make($absolutePath . $name)
                ->resize($value['width'], $value['height'])->save($absolutePath . $newFileName);
        }
    }

    /**
     * @param object $file
     * @return array
     */
    public function saveImage(object $file): array
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
    public function generateNewFileName(): string
    {
        return Str::random(40);
    }

    /**
     * @param $folderFormat
     * @return string
     */
    public function getRelativePath($folderFormat): string
    {
        return '/images/' . $folderFormat . '/';
    }

    /**
     * @param $folderFormat
     * @return string
     */
    public function getAbsolutePath($folderFormat): string
    {
        return public_path() . '/images/' . $folderFormat . '/';
    }

    /**
     * @param $file
     * @return string
     */
    public function getExtension($file): string
    {
        return pathinfo($file->getClientOriginalName())['extension'];
    }
}
