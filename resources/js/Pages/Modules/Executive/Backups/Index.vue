<template>
    <PageHeader title="Backup and Restore" pageTitle="List" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px); overflow: auto;" ref="box">

            <b-row class="g-2 mb-2 mt-n2">
                <b-col lg>
                    <div class="input-group mb-1">
                        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                        <input type="text" v-model="filter.keyword" placeholder="Search Role" class="form-control" style="width: 60%;">
                        <b-button type="button" variant="primary" @click="openCreate()">
                            <i class="ri-database-2-fill align-bottom me-1"></i> Generate
                        </b-button>
                    </div>
                </b-col>
            </b-row>

            <b-row id="folderlist-data">
                <b-col v-for="(folder, index) of latests" :key="index" class="col-md-3 folder-card" style="cursor: pointer;" @click="downloadFile(folder.name)">
                    <b-card no-body class="bg-light shadow-none" id="folder-1">
                        <b-card-body class="mt-4">
                            <div class="text-center">
                                <div class="mb-2">
                                    <i class="ri-folder-zip-fill align-bottom text-success display-5"></i>
                                </div>
                                <h6 class="fs-12 folder-name">{{ folder.name }}</h6>
                            </div>
                            <div class="hstack mt-4 text-muted">
                                <span class="me-auto fs-11">{{folder.date}}</span>
                                <span class="fs-11"><b>{{ folder.size }}</b></span>
                            </div>
                        </b-card-body>
                    </b-card>
                </b-col>
            </b-row>
            <div class="table-responsive">
                    <table class="table table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr class="fs-11">
                                <th></th>
                                <th style="width: 50%;">Name</th>
                                <th style="width: 15%;" class="text-center">Date</th>
                                <th style="width: 15%;" class="text-center">Size</th>
                                <th style="width: 15%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                             <tr v-for="(list,index) in olds" v-bind:key="index" :class="[(list.is_active == 0) ? 'table-warnings' : '']">
                                <td>{{index+1}}</td>
                                <td>
                                    <h5 class="fs-13 mb-0 text-dark">{{list.name}}</h5>
                                </td>
                                <td class="text-center">{{list.date}}</td>
                                <td class="text-center">{{list.size}}</td>
                                
                                <td class="text-end">
                                   <b-button @click="openDownload(list.name)" variant="primary" class="w-md btn-sm waves-effect waves-light">Download</b-button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
            },
            index: null
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal);
        }
    },
    computed: {
        latests() {
            return this.lists.slice(0,4);
        },
        olds() {
            return this.lists.slice(4);
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
            page_url = page_url || '/executive';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    count: ((window.innerHeight-350)/58),
                    option: 'backups'
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data;    
                }
            })
            .catch(err => console.log(err));
        },
        openCreate(){
            this.$refs.create.show();
        },
        openDownload(filePath) {
            window.open(this.currentUrl+'/executive/'+filePath);
        },
    }
}
</script>