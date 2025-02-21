<?php

namespace App\Services;

class FileService
{

    public function addFile($model, $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,png,jpeg,gif,svg,mp4|max:10240',
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $fileName = time() . '.' . $extension;
        $path = $extension == 'mp4' ? 'uploads/videos/' : 'uploads/images/';

        if ($file) {
            $file->storeAs($path, $fileName, 'public');

            $model->file = '/storage/' . $path . $fileName;
            $model->isVideo = $extension == 'mp4';
        }

        return $model;
    }
}
