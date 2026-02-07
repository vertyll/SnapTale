<?php

declare(strict_types=1);

namespace App\Services;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function updateImage($model, $request)
    {
        $image = Image::make($request->file('image'));

        if (!empty($model->image)) {
            $currentImagePath = str_replace('/storage/', '', $model->image);
            if (Storage::disk('public')->exists($currentImagePath)) {
                Storage::disk('public')->delete($currentImagePath);
            }
        }

        $image->crop(
            $request->width,
            $request->height,
            $request->left,
            $request->top
        );

        $extension = $request->file('image')->getClientOriginalExtension();
        $name = time() . '.' . $extension;
        $path = 'files/' . $name;

        Storage::disk('public')->put($path, (string) $image->encode());

        $model->image = Storage::url($path);

        return $model;
    }

    public function addVideo($model, $request)
    {
        $video = $request->file('video');
        $name = time() . '.' . $video->getClientOriginalExtension();
        $path = $video->storeAs('files', $name, 'public');

        $model->video = Storage::url($path);

        return $model;
    }
}
