<template>
    <tr>
        <td class="col-2">
            <input type="text" v-model="migration.field_name" class="form-control" :disabled="migration.id === 1">
        </td>
        <td class="col-2">
            <select v-model="migration.data_type" class="form-control" :disabled="migration.id === 1">
                <option v-for="type in dataTypes"
                        :key="type" :value="type" :selected="type == migration.data_type">{{ type }}
                </option>
            </select>
        </td>
        <td class="col-4">
            <table class="table table-bordered m-0 p-0">
                <thead>
                <tr>
                    <th>
                                            <span title="This field will be optional if ticked." data-toggle="tooltip">
                                                Null
                                            </span>
                    </th>
                    <th>
                                            <span title="This field will be shown in the form if ticked." data-toggle="tooltip">
                                                In Form
                                            </span>
                    </th>
                    <th>
                                            <span title="This field will be indexed for faster searching if ticked." data-toggle="tooltip">
                                                Index
                                            </span>
                    </th>
                    <th>
                                            <span title="This field will be shown in index if ticked." data-toggle="tooltip">
                                                Show In Index
                                            </span>
                    </th>
                </tr>
                </thead>
                <tbody>
                <td>
                    <div class="form-group mb-0 text-center">
                        <div class="custom-control text-center custom-switch">
                            <input type="checkbox" :disabled="migration.id === 1" v-model="migration.nullable" class="custom-control-input" :id="'nullable_' + migration.id">
                            <label class="custom-control-label initial" :for="'nullable_' + migration.id"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group mb-0 text-center">
                        <div class="custom-control text-center custom-switch">
                            <input type="checkbox" :disabled="migration.id === 1" v-model="migration.in_form" class="custom-control-input" :id="'in_form_' + migration.id">
                            <label class="custom-control-label initial" :for="'in_form_' + migration.id"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group mb-0 text-center">
                        <div class="custom-control text-center custom-switch">
                            <input type="checkbox" :disabled="migration.id === 1" v-model="migration.index" class="custom-control-input" :id="'index_' + migration.id">
                            <label class="custom-control-label initial" :for="'index_' + migration.id"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group mb-0 text-center">
                        <div class="custom-control text-center custom-switch">
                            <input type="checkbox" :disabled="migration.id === 1" v-model="migration.show_index" class="custom-control-input" :id="'show_index_' + migration.id">
                            <label class="custom-control-label initial" :for="'show_index_' + migration.id"></label>
                        </div>
                    </div>
                </td>

                </tbody>
            </table>
        </td>
        <td class="col-2">Default Value</td>
        <td class="col-2">&nbsp;</td>
    </tr>
</template>

<script>
    export default {
        name: "Migration",

        props: [
            'migration'
        ],
        data(){

        }
    }
</script>

<style scoped>

</style>