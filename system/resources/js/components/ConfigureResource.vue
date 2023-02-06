<template>
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <p class="card-title m-0">Manage Admin Panel Permissions for <strong v-if="resource">{{ resource.name }}</strong></p>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-bordered m-0">
                        <thead>
                        <tr>
                            <th>Permissions</th>
                            <th v-for="role in roles" :key="role.id">
                                {{ role.name }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="permission in permissions" :key="permission.id">
                            <td>{{ permission.name.replaceAll('_', ' ') }}</td>
                            <td v-for="role in roles" :key="role.id">
                                <div class="form-group mb-0 d-flex align-items-center">
                                    <div class="custom-control text-center custom-switch ml-3" style="margin-top: -8px;">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               @change="syncPermissions(role.name, permission.id)"
                                               :checked='resourcePermissions["\""+role.name+"\""].includes(permission.id)'
                                               :id="role.name + permission.id">
                                        <label class="custom-control-label initial"
                                               :for="role.name + permission.id"></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
<!--                        <tr v-for="role in roles" :key="role.id">-->
<!--                            <td>{{ role.name }}</td>-->
<!--                            <td v-for="permission in permissions" :key="permission.id">-->
<!--                                <div class="form-group mb-0 d-flex align-items-center">-->
<!--                                    <div class="custom-control text-center custom-switch ml-3" style="margin-top: -8px;">-->
<!--                                        <input type="checkbox"-->
<!--                                               class="custom-control-input" :id="role.name + permission.id">-->
<!--                                        <label class="custom-control-label initial"-->
<!--                                               :for="role.name + permission.id"></label>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </td>-->
<!--                        </tr>-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <p class="card-title m-0">Configure <strong v-if="resource">{{ resource.name }}</strong> API Resource</p>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-bordered m-0">
                        <thead>
                        <tr>
                            <th>Route</th>
                            <th>Authenticated / Public</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(route, key) in apiRoutes" :key="key">
                            <td>{{ key }}</td>
                            <td>
                                <div class="form-group mb-0 d-flex align-items-center">
                                    <label v-if="middlewares[key]">Authenticated:</label>
                                    <label v-else>Public:</label>
                                    <div class="custom-control text-center custom-switch ml-3" style="margin-top: -8px;">
                                        <input type="checkbox" v-model="middlewares[key]"
                                               class="custom-control-input"  @change="updateApiMiddlewares" :id="key">
                                        <label class="custom-control-label initial"
                                               :for="key"></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</template>


<script>
    export default {
        name: "ConfigureResource",
        props: [
            "crudid",
            "routes",
        ],
        data() {
            return {
                isBusy: false,
                resourceId: null,
                resource: null,
                apiRoutes: JSON.parse(this.routes),
                middlewares: this.getMiddlewaresList(),
                roles: [],
                permissions: [],
                resourcePermissions: []
            }
        },
        mounted(){
          this.resourceId = this.crudid;
          this.getResource();
          this.getRoles();
        },

        methods: {
            getResource() {
                this.isBusy = true;

                axios.get(BASE_URL + "/" + ROUTE_PREFIX + "/get-resource/" + this.crudid)
                    .then(response => this.resource = response.data.data)
                    .catch(err => console.error(err));

                this.isBusy = false;
            },

            getRoles() {
                axios.get(BASE_URL + "/" + ROUTE_PREFIX + "/get-roles")
                    .then(response => {
                        this.roles = response.data.data;
                        this.getPermissions();
                    })
                    .catch(err => console.error(err));
            },

            getPermissions() {
                axios.get(BASE_URL + "/" + ROUTE_PREFIX + "/get-permissions/" + this.crudid)
                    .then(response => {
                        this.permissions = response.data.data.map((p) => {
                            return {
                                ...p,
                                roles: p.roles.map((r) => r.id)
                            }
                        });
                        this.preparePermissionsWithRoles();
                    })
                    .catch(err => console.error(err));
            },

            preparePermissionsWithRoles(){
                this.roles.forEach((role) => {
                    this.resourcePermissions["\""+role.name+"\""] = this.permissions
                        .filter((p) => p.roles.includes(role.id))
                        .map((p) => p.id);
                });

                console.log(this.resourcePermissions);
            },

            updateApiMiddlewares() {
                axios.post(BASE_URL + "/" + ROUTE_PREFIX + "/update-api-middleware/" + this.crudid, this.middlewares)
                    .then(response => {
                        toastr.success(response.data.message);
                        // console.log(response.data);
                        this.getResource();
                    })
                    .catch(err => console.error(err));
            },

            getMiddlewaresList(){
                if(this.routes.includes("restore") && this.routes.includes("forceDestroy")) {
                    return {
                        "index": JSON.parse(this.routes).index.includes("auth:sanctum"),
                        "show":  JSON.parse(this.routes).show.includes("auth:sanctum"),
                        "store":  JSON.parse(this.routes).store.includes("auth:sanctum"),
                        "update":  JSON.parse(this.routes).update.includes("auth:sanctum"),
                        "destroy":  JSON.parse(this.routes).destroy.includes("auth:sanctum"),
                        "restore":  JSON.parse(this.routes).restore.includes("auth:sanctum"),
                        "forceDestroy":  JSON.parse(this.routes).forceDestroy.includes("auth:sanctum")
                    };
                } else {
                    return {
                        "index": JSON.parse(this.routes).index.includes("auth:sanctum"),
                        "show":  JSON.parse(this.routes).show.includes("auth:sanctum"),
                        "store":  JSON.parse(this.routes).store.includes("auth:sanctum"),
                        "update":  JSON.parse(this.routes).update.includes("auth:sanctum"),
                        "destroy":  JSON.parse(this.routes).destroy.includes("auth:sanctum")
                    };
                }
            },

            syncPermissions(role, permission){
                if(this.resourcePermissions["\""+role+"\""].includes(permission)){
                    let index = this.resourcePermissions["\""+role+"\""].indexOf(permission);
                    this.resourcePermissions["\""+role+"\""].splice(index, 1);
                } else {
                    this.resourcePermissions["\""+role+"\""].push(permission);
                }

                axios.post(BASE_URL + "/" + ROUTE_PREFIX + "/sync-role-permissions", {resource: this.resource.id, permissions: JSON.stringify({...this.resourcePermissions})})
                    .then(response => toastr.success(response.data.message))
                    .catch(err => console.error(err));
            }
        }

    }
</script>

<style lang="scss" scoped>

</style>
