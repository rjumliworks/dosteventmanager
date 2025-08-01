<template>
    <PageHeader title="Participants" pageTitle="List" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px); overflow: auto;" ref="box">

            <b-row class="g-2 mb-2 mt-n2">
                <b-col lg>
                    <div class="input-group mb-1">
                        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                        <input type="text" v-model="filter.keyword" placeholder="Search User" class="form-control" style="width: 60%;">
                        <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                            <i class="bx bx-refresh search-icon"></i>
                        </span>
                        <b-button type="button" variant="primary" @click="openCreate()">
                            <i class="ri-add-circle-fill align-bottom me-1"></i> Create
                        </b-button>
                    </div>
                </b-col>
            </b-row>
            <div class="table-responsive">
                <table class="table table-nowrap align-middle mb-0">
                    <thead class="table-light">
                        <tr class="fs-11">
                            <th style="width: 4%;"></th>
                            <th>Name</th>
                            <th style="width: 15%;" class="text-center">Email</th>
                            <th style="width: 15%;" class="text-center">Mobile</th>
                            <th style="width: 15%;" class="text-center">Type</th>
                            <th style="width: 15%;" class="text-center">Status</th>
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
                                <span v-if="list.is_active" class="badge bg-success">Active</span>
                                <span v-else class="badge bg-danger">Inactive</span>
                            </td>
                            <td class="text-end">
                                <b-button variant="soft-success" @click="openActivation('activation',list,index)" v-b-tooltip.hover title="Lock" size="sm" class="remove-list me-1">
                                    <i class="ri-lock-2-fill align-bottom"></i>
                                </b-button>
                                <b-button variant="soft-warning" @click="openActivation('verification',list,index)" v-b-tooltip.hover title="Verify" size="sm" class="remove-list me-1">
                                    <i class="ri-mail-send-fill align-bottom"></i>
                                </b-button>
                                <b-button variant="soft-primary" @click="openEdit(list,index)" v-b-tooltip.hover title="Edit" size="sm" class="edit-list">
                                    <i class="ri-pencil-fill align-bottom"></i>
                                </b-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
            </div>

        </div>
    </div>
    <Create ref="create"/>
</template>
<script>
import _ from 'lodash';
import Create from './Modals/Create.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Create },
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
                    count: ((window.innerHeight-350)/58),
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
        openCreate(){
            this.$refs.create.show();
        }
    }
}
</script>