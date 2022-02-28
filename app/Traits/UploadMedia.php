<?php

namespace App\Traits;

use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait UploadMedia
{
    public function uploadEmployeeImageFile($folderName)
    {

        $temporaryFile = TemporaryFile::where('folder', $folderName)->first();

        if ($temporaryFile) {
            $this->image = $temporaryFile->filename;
            $this->save();
            $this->addMedia(storage_path('app/public/employees/tmp/' . $folderName . '/' . $temporaryFile->filename))
                ->toMediaCollection('images');

//            rmdir(storage_path('app/public/employees/tmp/' . $fileName));
//            $temporaryFile->delete();
        }

//      create separate folder of employee and upload image into that
//        $filename->storeAs('employees/' . $this->id, $filename->getClientOriginalName());
//        $filename->storeAs('employees','employee'. $this->id .'.'.$filename->extension(), 'public');

//        Image::make(storage_path('app/public/employees/' . $this->id . '/' . $filename->getClientOriginalName()))
//            ->fit(50, 50)
//            ->save(storage_path('app/public/employees/' . $this->id . '/' . $filename->getClientOriginalName()));

//        $folder = uniqid() . '-' . now()->timestamp;
//        $filename->storeAs('employees/' . $folder, $filename->getClientOriginalName());
//
//        $this->image = $filename;
//        $this->save();
        Log::info('Filename ' .  $temporaryFile->filename . ' uploaded successfully..!!');
    }
}