<?php

namespace App\Services;

class FileService
{

    public function addFile($model, $request, $isAvatar = false)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,png,jpeg,gif,svg,mp4|max:10240',
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $fileName = time() . '.' . $extension;
        $path = $extension == 'mp4' ? 'uploads/videos/' : 'uploads/images/';

        if ($file && !$isAvatar) {
            $file->storeAs($path, $fileName, 'public');

            $model->file = '/storage/' . $path . $fileName;
            $model->isVideo = $extension == 'mp4';
        }

        if ($isAvatar) {
            $file->storeAs($path, $fileName, 'public');

            $model->avatar = '/storage/' . $path . $fileName;
        }

        return $model;
    }
}
