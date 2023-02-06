<?php

namespace Adminr\System\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BuildApiResourceService extends AdminrBuilderService
{
    protected string $apiResourceTargetPath;

    public function prepare(Request $request): static
    {
        parent::prepare($request);
        $this->apiResourceTargetPath = app_path() . "/Http/Resources/" . $this->modelName . "Resource.php";
        return $this;
    }

    public function buildApiResource(): static
    {
        try {
            $apiResourceStub = $this->getResourceStub('ApiResource');
            $stubPath = $this->getResourceStub('ApiResource', true);
            $apiResourceStub = $this->processStub($apiResourceStub);
            $this->makeDirectory($this->apiResourceTargetPath);
            File::put($stubPath, $apiResourceStub);
            File::copy($stubPath, $this->apiResourceTargetPath);

            return $this;
        } catch (\Exception | \Error $e) {
            throw $e;
        }
    }

    public function processStub($stub): array|string
    {
        return str_replace('{{MODEL_CLASS}}', $this->modelName, $stub);
    }

    public function rollback(): static
    {
        if (isset($this->migrationFileName) && !is_null($this->migrationFileName)) {
            if (isset($this->apiResourceTargetPath) && !is_null($this->apiResourceTargetPath)) {
                $this->deleteFile($this->apiResourceTargetPath);
            }
        }
        return $this;
    }
}
