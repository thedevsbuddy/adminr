<?php

namespace Devsbuddy\AdminrEngine\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BuildModelService extends AdminrEngineService
{
    protected string $modelTargetPath;

    public function prepare(Request $request): static
    {
        parent::prepare($request);
        $this->modelTargetPath = base_path() . "/app/Models/$this->modelName.php";
        return $this;
    }

    public function buildModel(): static
    {
        try {
            $modelStub = $this->hasSoftdeletes
                ? $this->getModelStub('ModelWithSoftdeletes')
                : $this->getModelStub('Model');
            $stubPath = $this->hasSoftdeletes
                ? $this->getModelStub('ModelWithSoftdeletes', true)
                : $this->getModelStub('Model', true);

            $modelStub = $this->processStub($modelStub);

            $this->makeDirectory($this->modelTargetPath);
            File::put($stubPath, $modelStub);
            File::copy($stubPath, $this->modelTargetPath);

            return $this;
        } catch (\Exception | \Error $e) {
            throw $e;
        }
    }

    public function processStub($stub): array|string
    {
        $stub = str_replace('{{MODEL_CLASS}}', $this->modelName, $stub);
        $stub = str_replace('{{TABLE_NAME}}', $this->tableName, $stub);
        return str_replace('{{MEDIA_ATTRIBUTE_STATEMENT}}', $this->getMediaAttributeStatement(), $stub);
    }

    protected function getMediaAttributeStatement(): string
    {
        $mediaAttributeStmt = '';

        foreach ($this->request->get('migrations') as $migration) {
            if ($migration['data_type'] == 'file') {
                if ($migration['file_type'] == 'single') {
                    $mediaAttributeStmt .= "public function " . Str::camel($migration['field_name']) . "(): Attribute\n\t";
                    $mediaAttributeStmt .= "{\n\t\t";
                    $mediaAttributeStmt .= "return Attribute::make(\n\t\t\t";
                    $mediaAttributeStmt .= "get: function (\$value) {\n\t\t\t\t";
                    $mediaAttributeStmt .= "if (Str::contains(request()->url(), 'api')){\n\t\t\t\t\t";
                    $mediaAttributeStmt .= "return asset(\$value);\n\t\t\t\t";
                    $mediaAttributeStmt .= "}\n\t\t\t\t";
                    $mediaAttributeStmt .= "return \$value;\n\t\t\t";
                } else {
                    $mediaAttributeStmt .= "public function " . Str::camel($migration['field_name']) . "(): Attribute\n\t";
                    $mediaAttributeStmt .= "{\n\t\t";
                    $mediaAttributeStmt .= "return Attribute::make(\n\t\t\t";
                    $mediaAttributeStmt .= "get: function (\$value) {\n\t\t\t\t\t";
                    $mediaAttributeStmt .= "\$return = [];\n\t\t\t";
                    $mediaAttributeStmt .= "if (Str::contains(request()->url(), 'api')){\n\t\t\t\t\t";
                    $mediaAttributeStmt .= "foreach(json_decode(\$value) as \$val){\n\t\t\t\t\t\t";
                    $mediaAttributeStmt .= "\$return[] = asset(\$val);\n\t\t\t\t\t";
                    $mediaAttributeStmt .= "}\n\t\t\t\t\t";
                    $mediaAttributeStmt .= "return \$return;\n\t\t\t\t";
                    $mediaAttributeStmt .= "}\n\t\t\t";
                    $mediaAttributeStmt .= "\$return = [];\n\t\t\t\t";
                    $mediaAttributeStmt .= "foreach(json_decode(\$value) as \$val){\n\t\t\t\t\t";
                    $mediaAttributeStmt .= "\$return[] = \$val;\n\t\t\t\t";
                    $mediaAttributeStmt .= "}\n\t\t\t\t";
                    $mediaAttributeStmt .= "return \$return;\n\t\t\t";
                }
                $mediaAttributeStmt .= "}\n\t\t";
                $mediaAttributeStmt .= ");\n\t";
                $mediaAttributeStmt .= "}\n\n\t";
            }
        }

        return $mediaAttributeStmt;
    }

    public function rollback(): static
    {
        if (isset($this->modelName) && !is_null($this->modelName)) {
            if (isset($this->modelTargetPath) && !is_null($this->modelTargetPath)) {
                $this->deleteFile($this->modelTargetPath);
            }
        }
        return $this;
    }
}
