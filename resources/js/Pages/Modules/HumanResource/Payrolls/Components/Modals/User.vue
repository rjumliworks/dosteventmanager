<template>
    <!-- style="--vz-modal-width: 600px;" -->
    <b-modal v-model="showModal" style="--vz-modal-width: 700px;" header-class="p-3 bg-light" title="Select Employee" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3">
                <!-- <BCol lg="12" class="mt-3">
                    <div class="d-flex">
                        <div style="width: 100%;">
                            <InputLabel for="name" value="Employee Selection Mode" :message="form.errors.year"/>
                            <Multiselect :options="['All Regular Employees','Custom Employees','Except Employees']" v-model="form.type" label="name" :allow-empty="false" :searchable="true" placeholder="Select Month" />
                        </div>
                        <div class="flex-shrink-0" v-if="form.type != 'All Regular Employees'">
                            <b-button @click="openAdd()" style="margin-top: 20px;" variant="light" class="waves-effect waves-light ms-1"><i class="ri-add-circle-fill"></i></b-button>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12" class="mt-0" v-if="form.type">
                    <hr class="text-muted"/>
                </BCol>
                <BCol lg="12" class="mt-0" v-if="form.type == 'All Regular Employees'">
                    <div class="alert alert-primary alert-dismissible alert-label-icon rounded-label fade show material-shadow" role="alert">
                        <i class="ri-user-smile-line label-icon"></i>All <b>regular employees</b> will be automatically included in this payroll cutoff.
                    </div>
                </BCol>
                <BCol lg="12" class="mt-0" v-if="form.type == 'Custom Employees'">
                    <div class="alert alert-warning alert-dismissible alert-label-icon rounded-label fade show material-shadow" role="alert">
                        <i class="ri-user-smile-line label-icon"></i>Select <b>specific employees</b> to include in this payroll cutoff.
                    </div>
                </BCol>
                <BCol lg="12" class="mt-0" v-if="form.type == 'Except Employees'">
                    <div class="alert alert-danger alert-dismissible alert-label-icon rounded-label fade show material-shadow" role="alert">
                        <i class="ri-user-smile-line label-icon"></i>All regular employees will be included <b>except</b> those you manually exclude.
                    </div>
                </BCol>
                 <BCol lg="12" class="mt-n1">
                    <div class="col-sm-auto">
                        <div class="avatar-group">
                            <div class="avatar-group-item material-shadow"  v-for="(list, index) of employees" :key="index">
                                <a href="javascript: void(0);" class="d-inline-block" v-b-tooltip.hover :title="list.name">
                                    <img :src="list.avatar" alt="" class="rounded-circle avatar-xs">
                                </a>
                            </div>
                        </div>
                    </div>
                </BCol> -->
                <BCol lg="12">
                    <BRow class="g-3">
                        <BCol lg="12"><hr class="text-muted mb-0 mt-0"/></BCol>
                        <BCol lg="12">
                            <div class="row text">
                                <div class="col-md-4" v-if="is_regular">
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="customRadio1" class="custom-control-input me-2" value="All Regular Employees" v-model="form.type">
                                        <label class="custom-control-label fw-normal fs-12" for="customRadio1">All Regular Employees</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="customRadio2" class="custom-control-input me-2" value="Custom Employees" v-model="form.type">
                                        <label class="custom-control-label fw-normal fs-12" for="customRadio2">Custom Employees</label>
                                    </div>
                                </div>
                                <div class="col-md-4" v-if="is_regular">
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="customRadio2" class="custom-control-input me-2" value="Except Employees" v-model="form.type">
                                        <label class="custom-control-label fw-normal fs-12" for="customRadio2">Except Employees</label>
                                    </div>
                                </div>
                            </div>
                        </BCol>
                        <BCol lg="12"><hr class="text-muted mt-n3"/></BCol>
                        <BCol lg="12">
                            <form class="app-search d-none d-md-block mb-n3" style="margin-top: -33px;">
                                <div class="position-relative">
                                    <input type="text" class="form-control" placeholder="Search Employee" autocomplete="off" id="search-options" />
                                    <span class="mdi mdi-magnify search-widget-icon"></span>
                                    <span @click="clear()" class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                                </div>
                                <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                                    <SimpleBar data-simplebar >
                                        <div class="notification-list">
                                            <b-link @click="chooseUser(list)" v-for="(list, index) of names" :key="index" class="d-flex dropdown-item notify-item py-2">
                                                <img :src="list.avatar" class="me-3 rounded-circle avatar-xs" alt="user-pic" />
                                                <div class="flex-1">
                                                    <h6 class="m-0">{{ list.name}}</h6>
                                                    <span class="fs-11 mb-0 text-muted">{{list.position}}</span>
                                                </div>
                                            </b-link>
                                        </div>
                                    </SimpleBar>
                                </div>
                            </form>
                            <hr class="text-muted" style="margin-top: 10px;"/>
                        </BCol>
                        <BCol lg="12" class="mt-n1">
                            <div class="col-sm-auto">
                                <div class="avatar-group">
                                    <div class="avatar-group-item material-shadow"  v-for="(list, index) of employees" :key="index">
                                        <a href="javascript: void(0);" class="d-inline-block" v-b-tooltip.hover :title="list.name">
                                            <img :src="list.avatar" alt="" class="rounded-circle avatar-xs">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </BCol>
                        <BCol lg="12" class="mt-2"  v-if="(existing && existing.length > 0) || (incomplete && incomplete.length > 0)">
                            <hr class="text-muted" style="margin-top: 4px;"/>
                            <div class="alert alert-warning alert-dismissible alert-additional fade show mb-0 material-shadow" role="alert"
                                v-if="(existing && existing.length > 0) || (incomplete && incomplete.length > 0)">
                                <div class="alert-body">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="ri-alert-line fs-16 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="alert-heading fs-14">Notice: Some users were skipped</h5>
                                            <p class="mb-0 fs-11">
                                                The following users were not processed due to the reasons listed below.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert-content">
                                    <!-- Existing payroll users -->
                                    <div v-if="existing && existing.length > 0">
                                        <p class="mb-1 fw-semibold">Users with existing payroll:</p>
                                        <div class="row">
                                            <div class="col-6">
                                                <ul class="mb-2">
                                                    <li v-for="(id) in existing.filter((_, i) => i % 2 === 0)" :key="'exist-left-' + id">
                                                        {{ getEmployeeName(id) }}
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-6">
                                                <ul class="mb-2">
                                                    <li v-for="(id) in existing.filter((_, i) => i % 2 !== 0)" :key="'exist-right-' + id">
                                                        {{ getEmployeeName(id) }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Incomplete DTR users -->
                                    <div v-if="incomplete && incomplete.length > 0" class="mt-3">
                                        <p class="mb-1 fw-semibold">Users with incomplete DTR:</p>
                                        <div class="row">
                                            <div class="col-6">
                                                <ul class="mb-0">
                                                    <li v-for="(id) in incomplete.filter((_, i) => i % 2 === 0)"
                                                        :key="'incomplete-left-' + id">
                                                        {{ getEmployeeName(id) }}
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-6">
                                                <ul class="mb-0">
                                                    <li v-for="(id) in incomplete.filter((_, i) => i % 2 !== 0)"
                                                        :key="'incomplete-right-' + id">
                                                        {{ getEmployeeName(id) }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </BCol>
                       
                    </BRow>
                </BCol>
            </BRow>
        </form>

        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
    <Add :is_regular="is_regular" @users="updateUsers" ref="add"/>
</template>

<script>
import _ from 'lodash';
import Add from './Add.vue';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { Multiselect, TextInput, InputLabel, Add },
    props: ['is_regular','id'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: this.id,
                type: null,
                users: [],
                option: 'users'
            }),
            names: [],
            employees: [],
            keyword: null,
            existing: [],
            incomplete: [],
            showModal: false
        }
    },
    watch: {
        "form.type"(newVal){
            this.form.users = [];
        }
    },
    mounted() {
        this.isCustomDropdown();
    },
    methods: { 
        show(){
            this.employees = [];
            this.existing = [];
            this.incomplete = [];
            this.showModal = true;
        },
        checkSearchStr: _.debounce(function (string) {
            this.keyword = string;
            this.search();
        }, 500),
        search(){
            axios.get('/search', {
                params: {
                    keyword: this.keyword,
                    is_regular: this.is_regular,
                    option: 'users'
                }
            })
            .then(response => {
                if(response){ 
                    this.scholar = {};
                    this.names = response.data; 
                }
            })
            .catch(err => console.log(err));
        },
        getEmployeeName(id) {
            const emp = this.employees.find(e => e.value === id);
            return emp ? emp.name : `User ID: ${id}`;
        },
        chunkArray(array, parts) {
            const result = [[], []];
            array.forEach((item, index) => {
                result[index % parts].push(item);
            });
            return result;
        },
        chooseUser(data){
            if (!this.employees.some(user => user.value === data.value)) {
                this.employees.unshift(data);
            }
            this.keyword = null;
            document.getElementById("search-options").value = "";
            document.getElementById("search-options").focus();
        }, 
        updateUsers(data){
            data.forEach(user => {
                if (!this.form.users.some(u => u === user.value)) {
                    this.form.users.unshift(user.value);
                    this.employees.unshift(user);
                }
            });
        },
        submit(){
            this.form.users = this.employees.map(emp => emp.value);
            this.form.post('/payrolls',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.existing = response.props.flash.data.exist;
                    this.incomplete = response.props.flash.data.incomplete;
                    if(
                        (this.existing.length === 0 && this.incomplete.length === 0)
                    ){
                        this.hide(); 
                    }
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.showModal = false;
        },
        isCustomDropdown() {
            var searchOptions = document.getElementById("search-close-options");
            var dropdown = document.getElementById("search-dropdown");
            var searchInput = document.getElementById("search-options");

            searchInput.addEventListener("focus", () => {
                var inputLength = searchInput.value.length;
                if (inputLength > 0) {
                    dropdown.classList.add("show");
                    searchOptions.classList.remove("d-none");
                } else {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchInput.addEventListener("keyup", () => {
                var inputLength = searchInput.value.length;
                if (inputLength > 0) {
                    dropdown.classList.add("show");
                    searchOptions.classList.remove("d-none");
                    this.checkSearchStr(searchInput.value);
                } else {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchOptions.addEventListener("click", () => {
                searchInput.value = "";
                dropdown.classList.remove("show");
                searchOptions.classList.add("d-none");
            });

            document.body.addEventListener("click", (e) => {
                if (e.target.getAttribute("id") !== "search-options") {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });
        }
    }
}
</script>
<style scoped>
    .dropdown-menu-lg {
        width: 95%;
    }
</style>