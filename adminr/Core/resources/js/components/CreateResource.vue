<template>
  <div class="create-resource-component">
    <form method="post" @submit.prevent="generateCrud">
      <div class="row justify-content-start align-items-center">
        <div class="col-lg-6">
          <div class="form-group">
            <label for="model_name">Model name <span class="text-danger font-weight-bold">*</span></label>
            <input type="text" id="model_name" @input="validateModelName" v-model="model"
                   class="form-control" :class="{ 'is-invalid': errors.model === true }"
                   placeholder="E.g: Article">
          </div>
        </div>
        <div class="col-lg-2">
          <div class="form-group text-center">
            <label>Has SoftDeletes?</label>
            <div class="custom-control text-center custom-switch">
              <input type="checkbox" class="custom-control-input"
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
        <div class="col-lg-2">
          <div class="form-group text-center">
            <label title="Do you want to create API resources?" data-toggle="tooltip">API Resource?</label>
            <div class="custom-control text-center custom-switch">
              <input type="checkbox" class="custom-control-input" v-model="api_resource"
                     id="api_resource">
              <label class="custom-control-label" for="api_resource"></label>
            </div>
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
            <select v-model="migration.data_type" class="form-control mb-3"
                    @change="(e) => onDataTypeSelect(e, index)">
              <option v-for="type in dataTypes" :key="type" :value="type"
                      :selected="type === migration.data_type">{{ type }}
              </option>
            </select>

            <div class="form-group" v-show="migration.data_type === 'slug'">
              <label>Select field</label>
              <small class="text-danger d-block mb-3">Generate slug / Unique Identifier from.</small>
              <select v-model="migration.slug_from" class="form-control">
                <option
                    v-for="m in migrations.filter(mig => mig.field_name !== migration.field_name)"
                    :value="m.field_name">{{ m.field_name }}
                </option>
              </select>
            </div>

            <div class="form-group" v-show="migration.data_type === 'file'">
              <label>File Type</label>
              <select v-model="migration.file_type" class="form-control" :id="'file_type_' + index">
                <option value="single">Single File</option>
                <option value="multiple">Multiple Files</option>
              </select>
            </div>

            <div class="form-group" v-show="migration.data_type === 'file'">
              <label title="Default is all file type" data-toggle="tooltip">Accepted file Types</label>
              <input type="text" v-model="migration.accept" placeholder="E.g .png, .jpg, .svg"
                     class="form-control" :id="'accept_' + index">
            </div>

            <div class="form-group"
                 v-show="migration.data_type === 'text' || migration.data_type === 'longText'">
              <label>Rich text editor</label>
              <div class="custom-control custom-switch">
                <input type="checkbox" v-model="migration.is_rich_text" class="custom-control-input"
                       :id="'is_rich_text_' + index">
                <label class="custom-control-label initial" :for="'is_rich_text_' + index"></label>
              </div>
            </div>

            <div class="form-group" v-show="migration.data_type === 'foreignId'">
              <label>Select Model</label>
              <select v-model="migration.related_model" class="form-control"
                      :id="'related_model_' + index"
                      @change="(e) => onModelSelect(index, e.target.value)">
                <option value="auth">Auth User</option>
                <option v-for="(model, x) in modelList" :key="x" :value="model.name">{{
                    model.name
                  }}
                </option>
              </select>
            </div>

            <div class="form-group"
                 v-show="migration.related_model != null && migration.related_model != 'auth'">
              <label>Show column in dropdown</label>
              <select v-model="migration.related_model_label" class="form-control"
                      :id="'related_model_label_' + index">
                <option v-for="(column, j) in migration.related_model_columns" :key="j"
                        :value="column">{{ column }}
                </option>
              </select>
            </div>

            <div class="form-group" v-show="migration.data_type === 'enum'">
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
                  <small title="This field will be shown in index if ticked."
                         data-toggle="tooltip">
                    In Index
                  </small>
                </th>
                <th>
                  <small title="This field will be shown in create and edit if ticked."
                         data-toggle="tooltip">
                    In Form
                  </small>
                </th>
                <th>
                  <small title="This field will be searchable if ticked."
                         data-toggle="tooltip">
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
                      <input type="checkbox" v-model="migration.nullable"
                             class="custom-control-input" :id="'nullable_' + index"
                             :class="{ 'disabled': migration.data_type === 'foreignId' || migration.data_type === 'uuid' }"
                             :disabled="migration.data_type === 'foreignId' || migration.data_type === 'uuid'">
                      <label class="custom-control-label initial"
                             :for="'nullable_' + index"></label>
                    </div>
                  </div>
                </td>

                <td>
                  <div class="form-group mb-0 text-center">
                    <div class="custom-control text-center custom-switch">
                      <input type="checkbox" v-model="migration.show_index"
                             class="custom-control-input" :id="'show_index_' + index"
                             :class="{ 'disabled': migration.data_type === 'uuid' }"
                             :disabled="migration.data_type === 'uuid'">
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
                             :class="{ 'disabled': migration.data_type === 'file' || migration.data_type === 'uuid' }"
                             :disabled="migration.data_type === 'file' || migration.data_type === 'uuid'">
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
                             :class="{ 'disabled': migration.data_type === 'file' || migration.data_type === 'foreignId' || migration.data_type === 'uuid' }"
                             :disabled="migration.data_type === 'file' || migration.data_type === 'foreignId' || migration.data_type === 'uuid'">
                      <label class="custom-control-label initial"
                             :for="'can_search_' + index"></label>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="form-group mb-0 text-center">
                    <div class="custom-control text-center custom-switch">
                      <input type="checkbox" v-model="migration.unique"
                             class="custom-control-input" :id="'unique_' + index"
                             :class="{ 'disabled': migration.data_type === 'file' || migration.data_type === 'foreignId' || migration.data_type === 'uuid' }"
                             :disabled="migration.data_type === 'file' || migration.data_type === 'foreignId' || migration.data_type === 'uuid'">
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
                    <button type="button"
                            @click.stop="migration.configuring = !migration.configuring"
                            class="btn btn-sm btn-primary d-inline-flex align-items-center"
                            :class="{ 'disabled': migration.data_type === 'file' }"
                            :disabled="migration.data_type === 'file'">
                      <a-icon name="build" class="h-4 w-4 mr-2"/>
                      Configure
                    </button>
                    <transition name="fade">
                      <div class="configure-modal position-absolute bg-white shadow rounded text-left p-3"
                           v-if="migration.configuring">
                        <h5 class="mb-4">Configure form view for admin panel.</h5>
                        <div class="form-group mb-3">
                          <label class="text-dark">Col LG ({{ migration.col_lg }})</label>
                          <input class="form-control-range" type="range" min="1" max="12" step="1" v-model="migration.col_lg"/>
                        </div>
                        <div class="form-group mb-3">
                          <label class="text-dark">Col MD ({{ migration.col_md }})</label>
                          <input class="form-control-range bg-primary" type="range" min="1" max="12" step="1" v-model="migration.col_md"/>
                        </div>
                        <div class="form-group mb-3">
                          <label class="text-dark">Col SM ({{ migration.col_sm }})</label>
                          <input class="form-control-range bg-primary" type="range" min="1" max="12" step="1" v-model="migration.col_sm"/>
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
                     :class="{ 'disabled': migration.data_type === 'file' }"
                     :disabled="migration.data_type === 'file'"/>
            </div>
          </td>
          <td>
            <div class="d-flex">
              <div class="btn-group mr-2" role="group" aria-label="Order the fields">
                <button class="btn btn-sm btn-icon btn-primary" @click.prevent="addInput(index)"><i
                    class="fas fa-plus"></i></button>

                <button class="btn btn-sm btn-icon btn-secondary"
                        @click.prevent="updateOrderUp(index)" :disabled="index === 0" type="button">
                  <i class="fas fa-arrow-up"></i>
                </button>
                <button class="btn btn-sm btn-icon btn-secondary"
                        @click.prevent="updateOrderDn(index)"
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
        <button class="btn btn-primary btn-sm d-flex align-items-center" type="submit" :disabled="isGenerating">
          <i class="fas fa-spinner fa-spin mr-2" v-if="isGenerating"></i>
          <a-icon name="sitemap" class="h-4 w-4 mr-2" v-else/>
          {{ isGenerating ? "Generating..." : "Generate" }}
        </button>
      </div>
    </form>
  </div>
</template>


<script setup>
import {onMounted, reactive, ref} from "vue";
import toast from '../Composables/Toast'

const props = defineProps({
  datatypes: Object,
})

const pattern = /[\s|\-\.\d_*@#$%^&()!~`/\\,+=]/;
const pattern2 = /[\s|\-\.\d*@#$%^&()!~`/\\,+=]/;
const modelList = ref([]);
const isGenerating = ref(false);
const model = ref('');
const softdeletes = ref(false);
const build_api = ref(true);
const api_resource = ref(false);
const dataTypes = ref(props.datatypes);
const migrations = ref([
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
]);
const errors = reactive({model: false})

function getModelList() {
  axios.get("/get-model-list")
      .then(response => {
        modelList.value = response.data;
      })
}

function addInput(index) {
  migrations.value.splice(index + 1, 0, {
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
  });

}

function removeInput(index) {
  migrations.value.splice(index, 1)
}

function generateCrud() {
  if (model.value == null || model.value === '') {
    toast.error("Please type model name to continue!");
    errors.value = {model: true};
    return;
  }

  isGenerating.value = true;
  let postData = {
    migrations: migrations.value,
    model: model.value,
    softdeletes: softdeletes.value,
    build_api: build_api.value,
  };

  axios.post("/generate", postData)
      .then(response => {
        isGenerating.value = false;
        if (response.data.status === 'success') {
          toast.success(response.data.message);
        } else {
          toast.error(response.data.message);
        }
        setTimeout(() => {
          window.location.href = ADMINR_URL + "/manage/" + response.data.entities;
        }, 1500);
      })
      .catch(err => {
        isGenerating.value = false;
        toast.error(err);
        console.error(err);
      });
}

function updateOrderUp(index) {
  let migration = migrations.value[index];
  migrations.value.splice(index, 1)
  migrations.value.splice(index - 1, 0, migration);
}

function updateOrderDn(index) {
  let migration = migrations.value[index];
  migrations.value.splice(index, 1)
  migrations.value.splice(index + 1, 0, migration);
}

function validateModelName(e) {
  return model.value = e.target.value.split(pattern.value).map((t) => t ? t[0].toUpperCase() + t.slice(1) : '').join('').trim();
}

function onModelSelect(index, model) {
  if (model == 'auth') return;
  let postData = {
    "model": model,
  }
  axios.post("/get-model-columns", postData)
      .then(response => {
        migrations.value[index].related_model_label = null;
        migrations.value[index].related_model_columns = response.data;
      })
      .catch(err => {
        toastr.error(err);
      });
}

function onDataTypeSelect(e, index) {
  if (e.target.value === 'uuid') {
    migrations.value[index].unique = true;
    migrations.value[index].show_form = false;
    migrations.value[index].show_index = false;
    migrations.value[index].nullable = false;
    migrations.value[index].can_search = false;
  } else {
    migrations.value[index].unique = false;
    migrations.value[index].show_form = true;
    migrations.value[index].show_index = true;
    migrations.value[index].nullable = false;
    migrations.value[index].can_search = false;
  }
}

onMounted(() => {
  getModelList();
})
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

.fade-enter-active,
.fade-leave-active {
  transition: opacity .5s;
}

.fade-enter,
.fade-leave-to

  /* .fade-leave-active below version 2.1.8 */
{
  opacity: 0;
}
</style>
