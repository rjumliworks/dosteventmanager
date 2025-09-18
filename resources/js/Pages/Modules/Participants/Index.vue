<template>
<Head title="Participants"/>
<PageHeader title="List of Participants" pageTitle="List" />
    <BRow>
        <div class="col-md-12">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-group-2-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Participants</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Logs and tracks recorded date and time entries for events, actions, or attendance.</p>
                        </div>
                        <div class="flex-shrink-0" style="width: 45%;">
                            
                        </div>
                    </div>
                </div>
                <div class="car-body bg-white border-bottom shadow-none">
                    <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                        <b-col lg>
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                <input type="text" v-model="keyword" placeholder="Search Event" class="form-control" style="width: 60%;">
                                <Multiselect class="white" style="width: 17%;" :options="types" v-model="filter.type" label="name" :searchable="true" placeholder="Select Type" />
                                 <span @click="openPrint()" class="input-group-text" v-b-tooltip.hover title="Print" style="cursor: pointer;"> 
                                    <i class="ri-printer-fill search-icon"></i>
                                </span>
                                <span @click="openUpload()" class="input-group-text" v-b-tooltip.hover title="Upload" style="cursor: pointer;"> 
                                    <i class="ri-upload-cloud-fill search-icon"></i>
                                </span>
                                <b-button type="button" variant="primary" @click="openCreate">
                                    <i class="ri-add-circle-fill align-bottom me-1"></i> Create
                                </b-button>
                            </div>
                        </b-col>
                    </b-row>
                </div>
                <div class="card bg-white border-bottom shadow-none" no-body>
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <ul class="nav nav-tabs nav-tabs-custom nav-primary fs-12" role="tablist">
                                <li class="nav-item">
                                    <BLink @click="viewStatus(null,null)" class="nav-link py-3 active" data-bs-toggle="tab" role="tab" aria-selected="true">
                                    <i class="ri-apps-2-line me-1 align-bottom"></i> All Hotels
                                    </BLink>
                                </li>
                            </ul>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white rounded-bottom">
                    <div class="table-responsive table-card" style="margin-top: -39px; height: calc(100vh - 465px); overflow: auto;">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="table-light thead-fixed">
                                <tr class="fs-11">
                                    <th style="width: 4%;"></th>
                                    <th>Name</th>
                                    <th style="width: 15%;" class="text-center">Email</th>
                                    <th style="width: 15%;" class="text-center">Mobile</th>
                                    <th style="width: 15%;" class="text-center">Type</th>
                                    <th style="width: 10%;" class="text-center">Status</th>
                                    <th style="width: 10%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(list,index) in lists" v-bind:key="index" :class="[(list.is_active == 0) ? 'table-warnings' : '']">
                                    <td>
                                        <div class="avatar-xs chat-user-img online">
                                            <img :src="list.avatar" alt="" class="avatar-xs rounded-circle">
                                            <span v-if="list.is_active" class="user-status text-success"></span>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="fs-13 mb-0 text-dark text-uppercase">{{list.lastname}}, {{list.firstname}} {{list.middlename[0]}}.</h5>
                                        <p class="fs-12 text-muted mb-0 text-uppercase">{{list.affiliation}} ({{ list.designation }})</p>
                                    </td>
                                    <td class="text-center fs-12">{{list.email}}</td>
                                    <td class="text-center fs-12">{{list.contact_no}}</td>
                                    <td class="text-center fs-12">{{list.type.name}}</td>
                                    <td class="text-center fs-12">
                                        <span v-if="list.is_completed" class="badge bg-success">Completed</span>
                                        <span v-else class="badge bg-danger">Incomplete</span>
                                    </td>
                                    <td class="text-end">
                                        <b-button variant="soft-primary" @click="openUpdate(list,index)" v-b-tooltip.hover title="Edit" size="sm" class="edit-list">
                                            <i class="ri-pencil-fill align-bottom"></i>
                                        </b-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <Pagination class="ms-2 me-2 mt-n1" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                </div>
            </div>
        </div>
    </BRow>
    <Create ref="create"/>
    <Upload ref="upload"/>
    <Update @success="updateList" :types="types" ref="update"/>
</template>
<script>
import _ from 'lodash';
import Upload from './Modals/Upload.vue';
import Create from './Modals/Create.vue';
import Update from './Modals/Update.vue';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Create, Upload, Update, Multiselect },
    props: ['types'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
                type: null
            },
            index: null
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal);
        },
        "filter.type"(newVal){
            this.fetch();
        }
    },
    created(){
        this.fetch();
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/participants';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    type: this.filter.type,
                    count: 10,
                    option: 'lists'
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;          
                }
            })
            .catch(err => console.log(err));
        },
        updateList(data){
            console.log(data);
            this.lists[this.index] = data;
        },
        openCreate(){
            this.$refs.create.show();
        },
        openUpload(){
            this.$refs.upload.show();
        },
        openUpdate(data,index){
            this.index = index;
            this.$refs.update.edit(data);
        },
        openPrint(){
            window.open('/print?option=lists'
                
            );
        },
    }
}
</script>