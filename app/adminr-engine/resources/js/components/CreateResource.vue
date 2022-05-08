<template>
    <div class="create-resource-component">
        <form method="post" @submit.prevent="generateCrud">
            <div class="row justify-content-start align-items-center">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="model_name">Model name</label>
                        <input type="text" id="model_name" @input="validateModelName" v-model="model"
                               class="form-control" :class="{'is-invalid': errors.model === true}"
                               placeholder="E.g: Article">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group text-center">
                        <label>Has SoftDeletes?</label>
                        <div class="custom-control text-center custom-switch">
                            <input type="checkbox" name="resource_has_softdeletes" class="custom-control-input"
                                   v-model="softdeletes" id="resource_has_softdeletes">
                            <label class="custom-control-label" for="resource_has_softdeletes"></label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group text-center">
                        <label>Generate APIs?</label>
                        <div class="custom-control text-center custom-switch">
                            <input type="checkbox" class="custom-control-input" v-model="build_api"
                                   id="resource_has_media">
                            <label class="custom-control-label" for="resource_has_media"></label>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="font-weight-bold">
                        <strong>Note:</strong> <code>id</code> field and <code>timestamps</code> field will be generated
                        by default!
                    </div>
                </div>
            </div>
            <hr>
            <table class="table table-bordered w-100">
                <thead>
                <tr>
                    <th>Field Name</th>
                    <th>Data Type</th>
                    <th>Options</th>
                    <th>Default Value</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(migration, index) in migrations" :key="index">
                    <td>
                        <input type="text"
                               @input="migration.field_name = migration.field_name.split(pattern2).map((t) => t ? t[0].toLowerCase() + t.slice(1).toLowerCase() : '').join('_').trim()"
                               v-model="migration.field_name" class="form-control">
                    </td>
                    <td>
                        <select v-model="migration.data_type" class="form-control mb-3">
                            <option v-for="type in dataTypes"
                                    :key="type" :value="type" :selected="type === migration.data_type">{{ type }}
                            </option>
                        </select>

                        <div class="form-group" v-if="migration.data_type === 'slug'">
                            <label>Select field</label>
                            <small class="text-danger d-block mb-3">Generate slug / Unique Identifier from.</small>
                            <select v-model="migration.slug_from" class="form-control">
                                <option v-for="m in migrations.filter(mig => mig.field_name !== migration.field_name)"
                                        :value="m.field_name">{{ m.field_name }}
                                </option>
                            </select>
                        </div>

                        <div class="form-group" v-if="migration.data_type === 'file'">
                            <label>File Type</label>
                            <select v-model="migration.file_type"
                                    class="form-control" :id="'file_type_' + index">
                                <option value="single">Single File</option>
                                <option value="multiple">Multiple Files</option>
                            </select>
                        </div>

                        <div class="form-group" v-if="migration.data_type === 'file'">
                            <label>Accepted file Types</label>
                            <input type="text" v-model="migration.accept" placeholder="E.g .png, .jpg, .svg"
                                   class="form-control" :id="'accept_' + index">
                        </div>

                        <div class="form-group"
                             v-if="migration.data_type === 'text' || migration.data_type === 'longText'">
                            <label>Rich text editor</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" v-model="migration.is_rich_text"
                                       class="custom-control-input" :id="'is_rich_text_' + index">
                                <label class="custom-control-label initial"
                                       :for="'is_rich_text_' + index"></label>
                            </div>
                        </div>

                        <div class="form-group"
                             v-if="migration.data_type === 'foreignId'">
                            <label>Select Model</label>
                            <select v-model="migration.related_model"
                                    class="form-control" :id="'related_model_' + index"
                                    @change="(e) => onModelSelect(index, e.target.value)">
                                <!-- TODO: add model list from the api -->
                                <option v-for="(model, x) in modelList" :key="x" :value="model.name">{{ model.name }}</option>
                            </select>
                        </div>

                        <div class="form-group"
                             v-if="migration.related_model != null">
                            <label>Show column in dropdown</label>
                            <select v-model="migration.related_model_label"
                                    class="form-control" :id="'related_model_label_' + index">
                                <!-- TODO: add model list from the api -->
                                <option v-for="(column, j) in migration.related_model_columns" :key="j" :value="column">{{ column }}</option>
                            </select>
                        </div>

                        <div class="form-group" v-if="migration.data_type === 'enum'">
                            <label>Enum values</label>
                            <small class="text-danger d-block mb-3">Please use comma separated values.</small>
                            <input type="text" v-model="migration.enum_values" class="form-control"/>
                        </div>
                    </td>
                    <td>
                        <table class="table table-bordered m-0 p-0">
                            <thead>
                            <tr>
                                <th>
                                    <small title="This field will be optional if ticked." data-toggle="tooltip">
                                        Null
                                    </small>
                                </th>
                                <th>
                                    <small title="This field will be shown in index if ticked." data-toggle="tooltip">
                                        In Index
                                    </small>
                                </th>
                                <th>
                                    <small title="This field will be shown in create and edit if ticked." data-toggle="tooltip">
                                        In Form
                                    </small>
                                </th>
                                <th>
                                    <small title="This field will be searchable if ticked." data-toggle="tooltip">
                                        Can Search
                                    </small>
                                </th>
                                <th>
                                    <small title="This field will be unique if ticked." data-toggle="tooltip">
                                        Unique
                                    </small>
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td>
                                    <div class="form-group mb-0 text-center">
                                        <div class="custom-control text-center custom-switch">
                                            <input type="checkbox" v-model="migration.nullable" class="custom-control-input"
                                                   :id="'nullable_' + index" :disabled="migration.data_type === 'foreignId'">
                                            <label class="custom-control-label initial"
                                                   :for="'nullable_' + index"></label>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group mb-0 text-center">
                                        <div class="custom-control text-center custom-switch">
                                            <input type="checkbox" v-model="migration.show_index"
                                                   class="custom-control-input" :id="'show_index_' + index">
                                            <label class="custom-control-label initial"
                                                   :for="'show_index_' + index"></label>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group mb-0 text-center">
                                        <div class="custom-control text-center custom-switch">
                                            <input type="checkbox" v-model="migration.show_form"
                                                   class="custom-control-input" :id="'show_form_' + index"
                                                   :class="{'disabled': migration.data_type === 'file'}"
                                                   :disabled="migration.data_type === 'file'">
                                            <label class="custom-control-label initial"
                                                   :for="'show_form_' + index"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group mb-0 text-center">
                                        <div class="custom-control text-center custom-switch">
                                            <input type="checkbox" v-model="migration.can_search"
                                                   class="custom-control-input" :id="'can_search_' + index"
                                                   :class="{'disabled': migration.data_type === 'file' || migration.data_type === 'foreignId'}"
                                                   :disabled="migration.data_type === 'file' || migration.data_type === 'foreignId'">
                                            <label class="custom-control-label initial"
                                                   :for="'can_search_' + index"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group mb-0 text-center">
                                        <div class="custom-control text-center custom-switch">
                                            <input type="checkbox" v-model="migration.unique" class="custom-control-input"
                                                   :id="'unique_' + index"
                                                   :class="{'disabled': migration.data_type === 'file' || migration.data_type === 'foreignId'}"
                                                   :disabled="migration.data_type === 'file' || migration.data_type === 'foreignId'">
                                            <label class="custom-control-label initial"
                                                   :for="'unique_' + index"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                            <tbody>
                            <tr>
                                <td colspan="5">
                                    <div class="form-group mb-0 text-center position-relative">
                                        <button type="button" @click.stop="migration.configuring = !migration.configuring"
                                                class="btn btn-sm btn-primary"
                                                :class="{'disabled': migration.data_type === 'file'}"
                                                :disabled="migration.data_type === 'file'">
                                            <i class="fas fa-cog"></i> Configure
                                        </button>
                                        <transition name="fade">
                                            <div
                                                class="configure-modal position-absolute bg-white shadow rounded text-left p-3"
                                                v-if="migration.configuring">
                                                <h5 class="mb-4">Configure form view for admin panel.</h5>
                                                <div class="form-group mb-3">
                                                    <label class="text-dark">Col LG ({{ migration.col_lg }})</label>
                                                    <input class="form-control-range bg-primary" type="range" min="1"
                                                           max="12" step="1" v-model="migration.col_lg"/>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="text-dark">Col MD ({{ migration.col_md }})</label>
                                                    <input class="form-control-range bg-primary" type="range" min="1"
                                                           max="12" step="1" v-model="migration.col_md"/>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="text-dark">Col SM ({{ migration.col_sm }})</label>
                                                    <input class="form-control-range bg-primary" type="range" min="1"
                                                           max="12" step="1" v-model="migration.col_sm"/>
                                                </div>
                                            </div>
                                        </transition>
                                    </div>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" v-model="migration.default" class="form-control"
                                   :class="{'disabled': migration.data_type === 'file'}"
                                   :disabled="migration.data_type === 'file'"/>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex">
                            <div class="btn-group mr-2" role="group" aria-label="Order the fields">
                                <button class="btn btn-sm btn-icon btn-primary" @click.prevent="addInput(index)"><i
                                    class="fas fa-plus"></i></button>

                                <button class="btn btn-sm btn-icon btn-secondary" @click.prevent="updateOrderUp(index)"
                                        :disabled="index === 0" type="button">
                                    <i class="fas fa-arrow-up"></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-secondary" @click.prevent="updateOrderDn(index)"
                                        :disabled="index === migrations.length - 1" type="button">
                                    <i class="fas fa-arrow-down"></i>
                                </button>

                                <button class="btn btn-sm btn-danger" @click.prevent="removeInput(index)"
                                        :disabled="index === 0"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="form-group mb-0">
                <button class="btn btn-primary btn-sm" type="submit" :disabled="isGenerating">
                    <i class="fas fa-spinner fa-spin" v-if="isGenerating"></i>
                    {{ isGenerating ? "Generating..." : "Generate" }}
                </button>
            </div>
        </form>
    </div>
</template>


<script>
export default {
    name: "create-resource",
    props: [
        "datatypes",
    ],
    data() {
        return {
            pattern: /[\s|\-\.\d_*@#$%^&()!~`/\\,+=]/,
            pattern2: /[\s|\-\.\d*@#$%^&()!~`/\\,+=]/,
            modelList: [],
            isGenerating: false,
            model: '',
            softdeletes: false,
            build_api: true,
            dataTypes: this.datatypes,
            migrations: [
                {
                    data_type: 'string',
                    field_name: '',
                    file_type: 'single',
                    accept: null,
                    nullable: false,
                    show_index: true,
                    show_form: true,
                    is_rich_text: false,
                    enum_values: '',
                    can_search: false,
                    unique: false,
                    default: null,
                    configuring: false,
                    slug_from: null,
                    related_model: null,
                    related_model_columns: [],
                    related_model_label: null,
                    col_sm: 12,
                    col_md: 12,
                    col_lg: 12
                },
            ],
            errors: {model: false},
        }
    },

    mounted() {
        this.getModelList();
    },

    methods: {
        addInput: function (index) {
            this.migrations.splice(index + 1, 0, {
                data_type: 'string',
                field_name: '',
                file_type: 'single',
                accept: null,
                nullable: false,
                show_index: true,
                show_form: true,
                is_rich_text: false,
                can_search: false,
                enum_values: '',
                unique: false,
                default: null,
                configuring: false,
                slug_from: null,
                related_model: null,
                related_model_columns: [],
                related_model_label: null,
                col_sm: 12,
                col_md: 12,
                col_lg: 12
            })

        },
        getModelList: function () {
            axios.get(BASE_URL + "/" + ROUTE_PREFIX + "/get-model-list")
                .then(response => {
                    this.modelList = response.data;
                })
        },
        removeInput: function (index) {
            this.migrations.splice(index, 1)
        },
        // Generate CRUD method
        generateCrud() {
            if (this.model == null || this.model === '') {
                toastr.error("Please type model name to continue!");
                this.errors.model = true;
                return;
            }

            this.isGenerating = true;
            let postData = {
                migrations: this.migrations,
                model: this.model,
                softdeletes: this.softdeletes,
                build_api: this.build_api,
            };

            axios.post(BASE_URL + "/" + ROUTE_PREFIX + "/generate", postData)
                .then(response => {
                    this.isGenerating = false;
                    if (response.data.status === 'success') {
                        toastr.success(response.data.message);
                    } else {
                        toastr.error(response.data.message);
                    }
                    setTimeout(()=>{
                        window.location.href = BASE_URL + "/" + ROUTE_PREFIX + "/manage/" + response.data.entities;
                    }, 1500);
                })
                .catch(err => {
                    this.isGenerating = false;
                    toastr.error(err);
                    console.error(err);
                });
        },

        updateOrderUp(index) {
            let migration = this.migrations[index];
            this.migrations.splice(index, 1)
            this.migrations.splice(index - 1, 0, migration);
        },
        updateOrderDn(index) {
            let migration = this.migrations[index];
            this.migrations.splice(index, 1)
            this.migrations.splice(index + 1, 0, migration);
        },

        validateModelName(e) {
            return this.model = e.target.value.split(this.pattern).map((t) => t ? t[0].toUpperCase() + t.slice(1) : '').join('').trim();
        },

        onModelSelect(index, model){
            let postData = {
                "model": model,
            }
            axios.post(BASE_URL + "/" + ROUTE_PREFIX + "/get-model-columns", postData)
                .then(response => {
                    this.migrations[index].related_model_label = null;
                    this.migrations[index].related_model_columns = response.data;
                })
                .catch(err => {
                    toastr.error(err);
                });
        }

        // validateMediaFieldName(e) {
        //     return this.mediaField = e.target.value.split(this.pattern).map((t) => t ? t[0].toLowerCase() + t.slice(1).toLowerCase() : '').join('_').trim();
        // }
    }

}
</script>

<style lang="scss" scoped>

.configure-modal {
    width: 400px;
    height: auto;
    bottom: calc(100% + 12px);
    left: 50%;
    transform: translateX(-50%);

    :after {
        content: '';
        height: 0;
        width: 0;
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        border-top: 10px solid white;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
    }

}

.create-resource-component {

    .form-control {
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        border-radius: 0;
    }

    .custom-control-label:not(.initial) {
        transform: scale(1.3);
    }
}

.fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
}

.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
{
    opacity: 0;
}
</style>
