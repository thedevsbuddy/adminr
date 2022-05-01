<?php

namespace Devsbuddy\AdminrEngine\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait CanManageFiles
{
    public $file;
    public $dir;
    public $saveFileName;
    public $uploadedFilePath;
    public $uploadedFileName;
    public $uploadedFilePaths;
    public $uploadedFileNames;
    public $destination;


    public function uploadFile($file, $dir = null, $fileNamePrefix = null): static
    {
        $this->file = $file;
        $this->dir = $dir;

        $fileName = Str::random(64);
        $fileExtension = $this->file->getClientOriginalExtension();
        $uploadHomeDir = "uploads/";

        $this->saveFileName = $fileNamePrefix . $fileName . "." . strtolower($fileExtension);
        $this->dir = $this->dir ? $uploadHomeDir . $this->dir . "/" : $uploadHomeDir . "/";
        $this->destination = storage_path() . '/app/public/' . $this->dir;
        $this->uploadedFilePath = 'storage/' . $this->dir . $this->saveFileName;
        $this->uploadedFileName = $this->saveFileName;

        $this->file->move($this->destination, $this->saveFileName);

        return $this;
    }

    public function uploadFiles($files, $dir = null, $fileNamePrefix = null): static
    {
        $this->dir = $dir;

        foreach ($files as $file) {
            $fileName = Str::random(64);
            $fileExtension = $file->getClientOriginalExtension();
            $uploadHomeDir = "uploads/";

            $this->saveFileName = $fileNamePrefix . $fileName . "." . strtolower($fileExtension);
            $this->dir = $this->dir ? $uploadHomeDir . $this->dir . "/" : $uploadHomeDir . "/";
            $this->destination = storage_path() . '/app/public/' . $this->dir;
            $this->uploadedFilePaths[] = 'storage/' . $this->dir . $this->saveFileName;
            $this->uploadedFileNames[] = $this->saveFileName;

            $file->move($this->destination, $this->saveFileName);
        }

        return $this;
    }


    public function getFilePath(): ?string
    {
        return $this->uploadedFilePath;
    }

    public function getFileName(): ?string
    {
        return $this->uploadedFileName;
    }

    public function getFilePaths(): ?array
    {
        return $this->uploadedFilePaths;
    }

    public function getFileNames(): ?array
    {
        return $this->uploadedFileNames;
    }


    public function deleteFile($path): static
    {
        if (File::exists($path)) {
            File::delete($path);
        }
        return $this;
    }


    public function deleteStorageFile($path): static
    {
        if (!is_null($path)) {
            if (explode('/', $path)[0] == 'storage') {
                $this->deleteFile(storage_path() . '/app/public/' . Str::replace('storage/', '', $path));
            } else {
                $this->deleteFile(storage_path() . '/app/public/' . $path);
            }
        }
        return $this;
    }

    public function deleteStorageFiles($files): static
    {
        if (!is_null($files)) {
            foreach ($files as $file) {
                $this->deleteStorageFile($file);
            }
        }
        return $this;
    }


    public function deleteDir($path): static
    {
        $storageDirs = [storage_path(), storage_path().'/app', storage_path().'/framework'];
        if (File::isDirectory($path) && !in_array(File::isDirectory($path), $storageDirs)) {
            File::deleteDirectory($path);
        }
        return $this;
    }


}
