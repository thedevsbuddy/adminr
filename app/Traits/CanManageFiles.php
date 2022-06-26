<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait CanManageFiles
{
    public UploadedFile|null $file;
    public string|null $dir;
    public string|null $saveFileName;
    public string|null $uploadedFileName;
    public string|null $uploadedFilePath;
    public string|null $uploadedFileExt;
    public array|null $uploadedFileNames;
    public array|null $uploadedFilePaths;
    public array|null $uploadedFileExts;
    public string|null $destination;

    public function uploadFile($file, $dir = null, $fileNamePrefix = null): static
    {
        $this->file = $file;
        $this->dir = $dir;

        $fileName = Str::random(64);
        $fileExtension = $this->file->getClientOriginalExtension();
        $uploadsHome = "uploads/";

        $this->saveFileName = $fileNamePrefix . $fileName . "." . strtolower($fileExtension);
        $this->dir = $this->dir ? $uploadsHome . $this->dir . "/" : $uploadsHome . "/";
        $this->destination = storage_path() . '/app/public/' . $this->dir;
        $this->uploadedFileName = $this->saveFileName;
        $this->uploadedFilePath = 'storage/' . $this->dir . $this->saveFileName;
        $this->uploadedFileExt = $fileExtension;

        $this->file->move($this->destination, $this->saveFileName);

        return $this;
    }


    public function uploadFiles($files, $dir = null, $fileNamePrefix = null): static
    {
        $this->dir = $dir;
        $uploadsHome = "uploads/";
        $this->dir = $this->dir ? $uploadsHome . $this->dir . "/" : $uploadsHome . "/";

        foreach ($files as $file) {
            $fileName = Str::random(64);
            $fileExtension = $file->getClientOriginalExtension();
            $this->saveFileName = $fileNamePrefix . $fileName . "." . strtolower($fileExtension);
            $this->destination = storage_path() . '/app/public/' . $this->dir;
            $this->uploadedFileNames[] = $this->saveFileName;
            $this->uploadedFilePaths[] = 'storage/' . $this->dir . $this->saveFileName;
            $this->uploadedFileExts[] = $fileExtension;

            $file->move($this->destination, $this->saveFileName);
        }

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->uploadedFileName;
    }

    public function getFilePath(): ?string
    {
        return $this->uploadedFilePath;
    }

    public function getFileExt(): ?string
    {
        return $this->uploadedFileExt;
    }


    public function getFileNames(): ?array
    {
        return $this->uploadedFileNames;
    }

    public function getFilePaths(): ?array
    {
        return $this->uploadedFilePaths;
    }

    public function getFileExts(): ?array
    {
        return $this->uploadedFileExts;
    }

    public function deleteFile($path)
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
                $this->deleteFile(base_path() . '/storage/app/public/' . Str::replace('storage/', '', $path));
            } else {
                $this->deleteFile(base_path() . '/storage/app/public/' . $path);
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
        if (File::isDirectory($path)) {
            File::deleteDirectory($path);
        }
        return $this;
    }

    public function clean()
    {
        $this->file = null;
        $this->dir = null;
        $this->saveFileName = null;
        $this->dir = null;
        $this->destination = null;
        $this->uploadedFileName = null;
        $this->uploadedFilePath = null;
        $this->uploadedFileExt = null;
    }
}
