<?php

namespace Adminr\Core\Services;

use Adminr\Core\Contracts\AdminrBuilderInterface;
use Adminr\Core\Database;
use Adminr\Core\Traits\HasStubs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class AdminrViewsBuilderService implements AdminrBuilderInterface
{
    use HasStubs;

    protected Fluent $resource;
    protected array $migrations;
    private AdminrBuilderService $builderService;

    public function __construct(AdminrBuilderService $service)
    {
        $this->builderService = $service;
        $this->migrations = $service->request->get('migrations');
        $this->resource = new Fluent([
            'name' => $this->builderService->resourceInfo->name,
            'files' => $this->builderService->resourceInfo->file->views,
        ]);
    }

    public function prepare(): static
    {
        $this->prepareIndexView();
        $this->prepareCreateView();
        $this->prepareEditView();
        return $this;
    }

    private function prepareIndexView()
    {
        $stub = $this->processStub($this->getViewStub('index'));
        File::put($this->resource->files->path->temp.'/'.$this->resource->files->files->index, $stub);
    }
    private function prepareCreateView()
    {
        $stub = $this->processStub($this->getViewStub('create'));
        File::put($this->resource->files->path->temp.'/'.$this->resource->files->files->create, $stub);
    }
    private function prepareEditView()
    {
        $stub = $this->processStub($this->getViewStub('edit'));
        File::put($this->resource->files->path->temp.'/'.$this->resource->files->files->edit, $stub);
    }

    public function processStub(string $stub): array|string
    {
        $stub = str_replace('{{FORM_STATEMENT}}', $this->getFormStatement(), $stub);
        $stub = str_replace('{{FORM_EDIT_STATEMENT}}', $this->getEditFormStatement(), $stub);
        $stub = str_replace('{{MODEL_ENTITY}}', $this->builderService->modelEntity, $stub);
        $stub = str_replace('{{MODEL_ENTITIES}}', $this->builderService->modelEntities, $stub);
        $stub = str_replace('{{LIST_TABLE_HEAD_STATEMENT}}', $this->getListTableHeadStatement(), $stub);
        $stub = str_replace('{{ENTITIES_LIST_STATEMENT}}', $this->getEntitiesListStatement(), $stub);
        $stub = str_replace('{{EMPTY_DATA_STATEMENT}}', $this->getEmptyDataStatement(), $stub);
        $stub = str_replace('{{CKEDITOR_STATEMENT}}', $this->getCkeditorStatement(), $stub);
        $stub = str_replace('{{IMAGE_UPLOAD_STATEMENT}}', $this->getImageUploadStatement(), $stub);
        $stub = str_replace('{{IMAGE_UPDATE_STATEMENT}}', $this->getImageUpdateStatement(), $stub);
        return str_replace('{{TRASHED_BUTTONS}}', $this->getTrashedButtonsStatement(), $stub);
    }

    public function build(): static
    {
        return $this;
    }

    public function rollback(): static
    {
       return $this;
    }
    private function getFormStatement(): string
    {
        $formStmt = "<div class=\"row\">\n";
        foreach ($this->migrations as $migration) {
            if ($migration['data_type'] != 'file') {
                if ($migration['show_form']) {
                    $formStmt .= $this->getInputField($migration) . "\n";
                }
            }
        }
        $formStmt .= "\t\t\t\t\t\t</div>\n";

        return $formStmt;
    }

    private function getEditFormStatement(): string
    {
        $formStmt = "<div class=\"row\">\n";
        foreach ($this->migrations as $migration) {
            if ($migration['data_type'] != 'file') {
                if ($migration['show_form']) {
                    $formStmt .= $this->getEditInputField($migration) . "\n";
                }
            }
        }
        $formStmt .= "\t\t\t\t\t\t</div>\n";

        return $formStmt;
    }

    private function getInputField($migration)
    {
        $isLongText = in_array($migration['data_type'], Database::longTextDataTypes());
        if ($migration['related_model'] != 'auth') {
            if ($isLongText) {
                $longTextInput = $this->getViewStub('textarea-input');
                return $this->processInputStubs($longTextInput, $migration);
            } else {
                $inputFile = $this->getViewStub(Database::htmlDataType($migration['data_type']) . '-input');
                return $this->processInputStubs($inputFile, $migration);
            }
        }
    }

    private function getEditInputField($migration): null|array|string
    {
        $isLongText = in_array($migration['data_type'], Database::longTextDataTypes());
        if ($migration['related_model'] != 'auth') {
            if ($isLongText) {
                $longTextInput = $this->getViewStub('textarea-edit-input');
                return $this->processInputStubs($longTextInput, $migration);
            } else {
                $inputFile = $this->getViewStub(Database::htmlDataType($migration['data_type']) . '-edit-input');
                return $this->processInputStubs($inputFile, $migration);
            }
        }
        return null;
    }

    private function processInputStubs($stub, $migration): array|string
    {
        $stub = str_replace('{{MODEL_ENTITY}}', $this->builderService->modelEntity, $stub);
        $stub = str_replace('{{FIELD_NAME}}', Str::snake($migration['field_name']), $stub);
        $stub = str_replace('{{FIELD_NAME_LABEL}}', Str::title(Str::replace('_', ' ', $migration['field_name'])), $stub);
        $stub = str_replace('{{FIELD_NAME_LABEL}}', Str::studly($migration['field_name']), $stub);
        $stub = str_replace('{{ACCEPT_FILE_STATEMENT}}', $migration['accept'] ?? '*/*', $stub);
        $stub = str_replace('{{MULTIPLE_TYPE_STATEMENT}}', $migration['file_type'] == 'single' ? '' : 'multiple', $stub);
        $stub = str_replace('{{OLD_FILE_STATEMENT}}', $this->getOldFileStatement(), $stub);
        $stub = str_replace('{{REQUIRED_STATEMENT}}', $migration['nullable'] ? '' : 'required', $stub);
        $stub = str_replace('{{COL_SM}}', "col-sm-" . $migration['col_sm'], $stub);
        $stub = str_replace('{{COL_MD}}', "col-md-" . $migration['col_md'], $stub);
        $stub = str_replace('{{COL_LG}}', "col-lg-" . $migration['col_lg'], $stub);
        $stub = str_replace('{{OPTIONS_STATEMENT}}', $this->getOptionsStmt($migration), $stub);
        if ($migration['is_rich_text']) {
            $stub = str_replace('{{CKEDITOR_CLASS}}', "ckeditor", $stub);
        } else {
            $stub = str_replace('{{CKEDITOR_CLASS}}', "", $stub);
        }

        return $stub;
    }

    private function getCkeditorStatement(): string
    {
        $ckeditorStmt = "";
        foreach ($this->migrations as $migration) {
            if ($migration['is_rich_text']) {
                $ckeditorStmt = "<script src=\"https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js\"></script>
    <script>
        CKEDITOR.replace( '.ckeditor');
    </script>";
            }
        }

        return $ckeditorStmt;
    }



    private function getOldFileStatement(): string
    {
        $oldFileStmt = "";
        foreach ($this->migrations as $migration) {
            if ($migration['data_type'] == 'file') {
                if ($migration['file_type'] == 'single') {
                    $oldFileStmt .= "{{ collect(explode('/', $" . $this->builderService->modelEntity . "->" . Str::snake($migration['field_name']) . "))->last() }}";
                } else {
                    $oldFileStmt .= "{{ count(json_decode($" . $this->builderService->modelEntity . "->" . Str::snake($migration['field_name']) . ")) }} files";
                }
            }
        }
        return $oldFileStmt;
    }

    private function getOptionsStmt($migration): string
    {
        $optionsStmt = "";
        if ($migration['data_type'] == 'enum') {
            $optionsStmt .= "<option value=\"\">--Select " . Str::title($migration['field_name']) . "--</option>\n\t\t";
            foreach (preg_split('/[,\s?]+/', $migration['enum_values']) as $val) {
                $optionsStmt .= "<option value=\"" . strtolower($val) . "\">" . Str::title($val) . "</option>\n\t\t";
            }
        } else if ($migration['data_type'] == 'foreignId') {
            $optionsStmt .= "<option value=\"\">--Select " . Str::title($migration['related_model']) . "--</option>\n\t\t\t\t\t\t\t\t\t\t";
            $optionsStmt .= "@foreach($" . Str::camel(Str::plural($migration['related_model'])) . " as \$index => $" . Str::camel(Str::singular($migration['related_model'])) . ")\n\t\t\t\t\t\t\t\t\t\t\t";
            $optionsStmt .= "<option value=\"{{\$" . Str::camel(Str::singular($migration['related_model'])) . "->id}}\">{{\$" . Str::camel(Str::singular($migration['related_model'])) . "->" . Str::snake($migration['related_model_label']) . "}}</option>\n\t\t\t\t\t\t\t\t\t\t";
            $optionsStmt .= "@endforeach";
        }

        return $optionsStmt;
    }

    private function getImageUploadStatement(): string
    {
        $imageUploadStmt = "\n";
        foreach ($this->migrations as $migration) {
            if ($migration['data_type'] == 'file') {
                $imageUploadStmt .= $this->getInputField($migration) . "\n";
            }
        }
        return $imageUploadStmt;
    }

    private function getImageUpdateStatement(): string
    {
        $imageUploadStmt = "";
        foreach ($this->migrations as $migration) {
            if ($migration['data_type'] == 'file') {
                $imageUploadStmt .= $this->getEditInputField($migration) . "\n";
            }
        }
        return $imageUploadStmt;
    }

    protected function getListTableHeadStatement(): string
    {
        $tableHeadStmt = "<th>#</th>";
        foreach ($this->migrations as $migration) {
            if ($migration['show_index']) {
                $tableHeadStmt .= "\n\t\t\t\t\t\t\t\t<th>" . Str::ucfirst($migration['field_name']) . "</th>";
            }
        }

        return $tableHeadStmt;
    }

    protected function getEntitiesListStatement(): string
    {
        $tableBodyStmt = "<td>{{++\$index}}</td>";
        foreach ($this->migrations as $migration) {
            if ($migration['show_index']) {
                if ($migration['data_type'] == 'file') {
                    if ($migration['file_type'] == 'single') {
                        $tableBodyStmt .= "\n\t\t\t\t\t\t\t\t\t<td><img src='{{ asset($" . $this->builderService->modelEntity . "->" . Str::snake($migration['field_name']) . ") }}'  class=\"img-thumb\" alt='" . Str::title(Str::replace('_', ' ', $migration['field_name'])) . "' /></td>";
                    } else {
                        $tableBodyStmt .= "\n\t\t\t\t\t\t\t\t\t<td><img src='{{ asset(json_decode($" . $this->builderService->modelEntity . "->" . Str::snake($migration['field_name']) . ")[0]) }}'  class=\"img-thumb\" alt='" . Str::title(Str::replace('_', ' ', $migration['field_name'])) . "' /></td>";
                    }
                } else {
                    $tableBodyStmt .= "\n\t\t\t\t\t\t\t\t\t<td>{{ $" . $this->builderService->modelEntity . "->" . Str::snake($migration['field_name']) . " }}</td>";
                }
            }
        }

        return $tableBodyStmt;
    }

    protected function getEmptyDataStatement(): string
    {
        $migrations = collect($this->migrations)->filter(function ($migr) {
            return $migr['show_index'];
        })->toArray();
        return "<tr><td colspan=\"" . (count($migrations) + 4) . "\" class=\"text-center\">No data available for " . Str::ucfirst($this->builderService->modelEntities) . "</td></tr>";
    }

    protected function getTrashedButtonsStatement(): ?string
    {
        $trashedButtonsStmt = "<a href=\"{{ route(config('adminr.route_prefix').'." . $this->builderService->modelEntities . ".index') }}\" class=\"btn btn-sm btn-primary m-0 mr-3\">
                             <svg class=\"h-3 w-3\">
                                 <use xlink:href=\"{{ coreUiIcon('cil-apps') }}\"></use>
                             </svg>
                             View all
                        </a>
                        <a href=\"{{ route(config('adminr.route_prefix').'." . $this->builderService->modelEntities . ".index') }}?trashed=true\" class=\"btn btn-sm btn-primary m-0 mr-3\">
                             <svg class=\"h-3 w-3\">
                                 <use xlink:href=\"{{ coreUiIcon('cil-trash') }}\"></use>
                             </svg>
                             Trashed
                        </a>";

        return $this->builderService->hasSoftDelete ? $trashedButtonsStmt : null;
    }

}
