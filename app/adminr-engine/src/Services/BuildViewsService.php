<?php

namespace Devsbuddy\AdminrEngine\Services;

use Devsbuddy\AdminrEngine\Database;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BuildViewsService extends AdminrEngineService
{
    protected $viewIndexTargetPath;
    protected $viewCreateTargetPath;
    protected $viewEditTargetPath;


    /**
     * Prepares the service to generate views
     *
     * @param Request $request
     * @return $this|AdminrEngineService
     */
    public function prepare(Request $request)
    {
        parent::prepare($request);
        $this->viewIndexTargetPath = base_path() . "/resources/views/adminr/$this->modelEntities/index.blade.php";
        $this->viewCreateTargetPath = base_path() . "/resources/views/adminr/$this->modelEntities/create.blade.php";
        $this->viewEditTargetPath = base_path() . "/resources/views/adminr/$this->modelEntities/edit.blade.php";
        return $this;
    }


    /**
     * Generates index view
     *
     * @return $this
     * @throws \Exception
     */
    public function buildIndexView()
    {
        try {
            $indexStub = $this->getViewStub('index');
            $stubPath = $this->getViewStub('index', true);
            $indexStub = $this->processStub($indexStub);

            $this->makeDirectory($this->viewIndexTargetPath);
            File::put($stubPath, $indexStub);
            File::copy($stubPath, $this->viewIndexTargetPath);

            return $this;
        } catch (\Exception $e) {
            throw $e;
        } catch (\Error $e) {
            throw $e;
        }
    }

    /**
     * Generates create view
     *
     * @return $this
     * @throws \Exception
     */
    public function buildCreateView()
    {
        try {
            $createStub = $this->getViewStub('create');
            $stubPath = $this->getViewStub('create', true);
            $createStub = $this->processStub($createStub);

            $this->makeDirectory($this->viewCreateTargetPath);
            File::put($stubPath, $createStub);
            File::copy($stubPath, $this->viewCreateTargetPath);

            return $this;
        } catch (\Exception $e) {
            throw $e;
        } catch (\Error $e) {
            throw $e;
        }
    }

    /**
     * Generates edit view
     *
     * @return $this
     * @throws \Exception
     */
    public function buildEditView()
    {
        try {
            $editView = $this->getViewStub('edit');
            $stubPath = $this->getViewStub('edit', true);
            $editView = $this->processStub($editView);

            $this->makeDirectory($this->viewEditTargetPath);
            File::put($stubPath, $editView);
            File::copy($stubPath, $this->viewEditTargetPath);

            return $this;
        } catch (\Exception $e) {
            throw $e;
        } catch (\Error $e) {
            throw $e;
        }
    }

    /**
     * Processes stubs
     *
     * @param $stub
     * @return mixed
     */
    public function processStub($stub)
    {
        $stub = str_replace('{{FORM_STATEMENT}}', $this->getFormStatement(), $stub);
        $stub = str_replace('{{FORM_EDIT_STATEMENT}}', $this->getEditFormStatement(), $stub);
        $stub = str_replace('{{MODEL_ENTITY}}', $this->modelEntity, $stub);
        $stub = str_replace('{{MODEL_ENTITIES}}', $this->modelEntities, $stub);
        $stub = str_replace('{{LIST_TABLE_HEAD_STATEMENT}}', $this->getListTableHeadStatement(), $stub);
        $stub = str_replace('{{ENTITIES_LIST_STATEMENT}}', $this->getEntitiesListStatement(), $stub);
        $stub = str_replace('{{EMPTY_DATA_STATEMENT}}', $this->getEmptyDataStatement(), $stub);
        $stub = str_replace('{{CKEDITOR_STATEMENT}}', $this->getCkeditorStatement(), $stub);
        $stub = str_replace('{{IMAGE_UPLOAD_STATEMENT}}', $this->getImageUploadStatement(), $stub);
        $stub = str_replace('{{IMAGE_UPDATE_STATEMENT}}', $this->getImageUpdateStatement(), $stub);
        $stub = str_replace('{{TRASHED_BUTTONS}}', $this->getTrashedButtonsStatement(), $stub);

        return $stub;
    }


    /**
     * Generate form for create
     *
     * @return string
     */
    private function getFormStatement()
    {
        $migrations = $this->request->get('migrations');

        $formStmt = "<div class=\"row\">\n";
        foreach ($migrations as $migration) {
            if ($migration['data_type'] != 'file') {
                if ($migration['show_form']) {
                    $formStmt .= $this->getInputField($migration) . "\n";
                }
            }
        }
        $formStmt .= "\t\t\t\t\t\t</div>\n";

        return $formStmt;
    }

    /**
     * Generate form for edit
     *
     * @return string
     */
    private function getEditFormStatement()
    {
        $migrations = $this->request->get('migrations');

        $formStmt = "<div class=\"row\">\n";
        foreach ($migrations as $migration) {
            if ($migration['data_type'] != 'file') {
                if ($migration['show_form']) {
                    $formStmt .= $this->getEditInputField($migration) . "\n";
                }
            }
        }
        $formStmt .= "\t\t\t\t\t\t</div>\n";

        return $formStmt;
    }

    /**
     * Generates input fields for create
     *
     * @param $migration
     * @return mixed
     */
    private function getInputField($migration)
    {
        $isLongText = in_array($migration['data_type'], Database::longTextDataTypes());
        if ($isLongText) {
            $longTextInput = $this->getViewStub('textarea-input');
            return $this->processInputStubs($longTextInput, $migration);
        } else {
            $inputFile = $this->getViewStub(Database::htmlDataType($migration['data_type']) . '-input');
            return $this->processInputStubs($inputFile, $migration);
        }
    }

    /**
     * Generates input fields for edit
     *
     * @param $migration
     * @return mixed
     */
    private function getEditInputField($migration)
    {
        $isLongText = in_array($migration['data_type'], Database::longTextDataTypes());
        if ($isLongText) {
            $longTextInput = $this->getViewStub('textarea-edit-input');
            return $this->processInputStubs($longTextInput, $migration);
        } else {
            $inputFile = $this->getViewStub(Database::htmlDataType($migration['data_type']) . '-edit-input');
            return $this->processInputStubs($inputFile, $migration);
        }
    }

    /**
     * Processes input stubs
     *
     * @param $stub
     * @param $migration
     * @return mixed
     */
    private function processInputStubs($stub, $migration)
    {
        $stub = str_replace('{{MODEL_ENTITY}}', $this->modelEntity, $stub);
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


    /**
     * Generates CKEDITOR for rich text type field
     *
     * @return string
     */
    private function getCkeditorStatement()
    {
        $migrations = $this->request->get('migrations');

        $ckeditorStmt = "";
        foreach ($migrations as $migration) {
            if ($migration['is_rich_text']) {
                $ckeditorStmt = "<script src=\"https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js\"></script>
    <script>
        CKEDITOR.replace( '.ckeditor');
    </script>";
            }
        }

        return $ckeditorStmt;
    }



    private function getOldFileStatement()
    {
        $oldFileStmt = "";
        foreach ($this->request->get('migrations') as $migration){
            if($migration['data_type'] == 'file'){
                if($migration['file_type'] == 'single'){
                    $oldFileStmt .= "{{ explode('/', $" . $this->modelEntity . "->" . Str::snake($migration['field_name']) . ")[count(explode('/', $" . $this->modelEntity . "->" . Str::snake($migration['field_name']) . ")) - 1] }}";
                } else {
                    $oldFileStmt .= "{{ count(json_decode($" . $this->modelEntity . "->" . Str::snake($migration['field_name']) . ")) }} files";
                }
            }
        }
        return $oldFileStmt;
    }

    private function getOptionsStmt($migration)
    {
        $optionsStmt = "";
        if($migration['data_type'] == 'enum'){
            $optionsStmt .= "<option value=\"\">--Select ".Str::title($migration['field_name'])."--</option>\n\t\t";
            foreach (preg_split('/[,\s?]+/', $migration['enum_values']) as $val){
                $optionsStmt .= "<option value=\"".strtolower($val)."\">".Str::title($val)."</option>\n\t\t";
            }
        }

        return $optionsStmt;
    }
    /**
     * Generates image upload statement
     *
     * @return string
     */
    private function getImageUploadStatement()
    {
        $migrations = $this->request->get('migrations');
        $imageUploadStmt = "\n";
        foreach ($migrations as $migration) {
            if ($migration['data_type'] == 'file') {
                $imageUploadStmt .= $this->getInputField($migration) . "\n";
            }
        }
        return $imageUploadStmt;
    }


    /**
     * Generates image update statement
     *
     * @return string
     */
    private function getImageUpdateStatement()
    {
        $migrations = $this->request->get('migrations');
        $imageUploadStmt = "";
        foreach ($migrations as $migration) {
            if ($migration['data_type'] == 'file') {
                $imageUploadStmt .= $this->getEditInputField($migration) . "\n";
            }
        }
        return $imageUploadStmt;
    }

    /**
     * Generate table head statement and
     * return statement lines
     */
    protected function getListTableHeadStatement()
    {
        $migrations = $this->request->get('migrations');

        $tableHeadStmt = "<th>#</th>";
        foreach ($migrations as $migration) {
            if ($migration['show_index'] == true) {
                $tableHeadStmt .= "\n\t\t\t\t\t\t\t\t<th>" . Str::ucfirst($migration['field_name']) . "</th>";
            }
        }

        return $tableHeadStmt;
    }

    /**
     * Generate table body statement and
     * return statement lines
     */
    protected function getEntitiesListStatement()
    {
        $migrations = $this->request->get('migrations');

        $tableBodyStmt = "<td>{{++\$index}}</td>";
        foreach ($migrations as $migration) {
            if ($migration['show_index'] == true) {
                if ($migration['data_type'] == 'file') {
                    if ($migration['file_type'] == 'single') {
                        $tableBodyStmt .= "\n\t\t\t\t\t\t\t\t\t<td><img src='{{ asset($" . $this->modelEntity . "->" . Str::snake($migration['field_name']) . ") }}'  class=\"img-thumb\" alt='" . Str::title(Str::replace('_', ' ', $migration['field_name'])) . "' /></td>";
                    } else {
                        $tableBodyStmt .= "\n\t\t\t\t\t\t\t\t\t<td><img src='{{ asset(json_decode($" . $this->modelEntity . "->" . Str::snake($migration['field_name']) . ")[0]) }}'  class=\"img-thumb\" alt='" . Str::title(Str::replace('_', ' ', $migration['field_name'])) . "' /></td>";
                    }
                } else {
                    $tableBodyStmt .= "\n\t\t\t\t\t\t\t\t\t<td>{{ $" . $this->modelEntity . "->" . Str::snake($migration['field_name']) . " }}</td>";
                }
            }
        }

        return $tableBodyStmt;
    }

    /**
     * Generate table body statement and
     * return statement lines
     */
    protected function getEmptyDataStatement()
    {
        $migrations = collect($this->request->get('migrations'))->filter(function ($migr) {
            return $migr['show_index'];
        })->toArray();
        return "<tr><td colspan=\"" . (count($migrations) + 4) . "\" class=\"text-center\">No data available for " . Str::ucfirst($this->modelEntities) . "</td></tr>";
    }

    /**
     * Generate Trashed Buttons statement and
     * return statement lines
     */
    protected function getTrashedButtonsStatement()
    {
        $trashedButtonsStmt = "<a href=\"{{ route(config('app.route_prefix').'." . $this->modelEntities . ".index') }}\" class=\"btn btn-sm btn-primary m-0 mr-3\">
                             <svg class=\"h-3 w-3\">
                                 <use xlink:href=\"{{ coreUiIcon('cil-apps') }}\"></use>
                             </svg>
                             View all
                        </a>
                        <a href=\"{{ route(config('app.route_prefix').'." . $this->modelEntities . ".index') }}?trashed=true\" class=\"btn btn-sm btn-primary m-0 mr-3\">
                             <svg class=\"h-3 w-3\">
                                 <use xlink:href=\"{{ coreUiIcon('cil-trash') }}\"></use>
                             </svg>
                             Trashed
                        </a>";

        return $this->hasSoftdeletes ? $trashedButtonsStmt : null;
    }

    public function rollback()
    {
        if (isset($this->modelEntities) && !is_null($this->modelEntities)) {
            $this->deleteDir(base_path() . '/resources/views/adminr/' . $this->modelEntities);
        }
        return $this;
    }

}
