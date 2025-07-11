<template>
<Head title="Documents"/>
<PageHeader title="List of Documents" pageTitle="List" />
<BRow>
    <div class="col-md-12">
        <div class="card bg-light-subtle shadow-none border">
            <div class="card-header bg-light-subtle">
                <div class="d-flex mb-n3">
                    <div class="flex-shrink-0 me-3">
                        <div style="height:2.5rem;width:2.5rem;">
                            <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                <i class="ri-alarm-fill text-primary fs-24"></i>
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-0 fs-14"><span class="text-body">Documents</span></h5>
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
                            <input type="text" v-model="filter.keyword" placeholder="Search Dtr" class="form-control" style="width: 70%;">
                            <input type="date" v-model="filter.date" class="form-control">
                            <!-- <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                                <i class="bx bx-refresh search-icon"></i>
                            </span> -->
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
                                <i class="ri-apps-2-line me-1 align-bottom"></i> All Documents
                                </BLink>
                            </li>
                            <li class="nav-item">
                                <BLink @click="viewStatus(null,null)" class="nav-link py-3" data-bs-toggle="tab" role="tab" aria-selected="true">
                                <i class="ri-article-fill me-1 align-bottom"></i> Incoming Documents
                                </BLink>
                            </li>
                            <li class="nav-item">
                                <BLink @click="viewStatus(null,null)" class="nav-link py-3" data-bs-toggle="tab" role="tab" aria-selected="true">
                                <i class="ri-article-line me-1 align-bottom"></i> Outgoing Documents
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
                    <table class="table align-middle table-centered mb-0">
                        <thead class="table-light thead-fixed">
                            <tr class="fs-11">
                                <th style="width: 3%;"></th>
                                <th>Subject</th>
                                <th style="width: 15%;" class="text-center">Document Type</th>
                                <th style="width: 12%;" class="text-center">Date Encoded</th>
                                <th style="width: 12%;" class="text-center">Date Routed</th>
                                <th style="width: 12%;" class="text-center">Date Tagged</th>
                                <th style="width: 5%;" class="text-center">Comments</th>
                                <th style="width: 6%;"></th>
                            </tr>
                        </thead>
                        <tbody class="table-white fs-12">
                            <tr v-for="(list,index) in lists" v-bind:key="index" >
                                <!-- <td class="text-center">{{ (meta.current_page - 1) * meta.per_page + index + 1 }}.</td>
                                <td>{{ list.user.profile.firstname }} {{ list.user.profile.lastname }}</td>
                                <td class="text-center">{{ list.date }}</td>
                                <td class="text-center">{{ (list.am_in_at) ? list.am_in_at.time : '-' }}</td>
                                <td class="text-center">{{ (list.am_out_at) ? list.am_out_at.time : '-' }}</td>
                                <td class="text-center">{{ (list.pm_in_at) ? list.pm_in_at.time : '-' }}</td>
                                <td class="text-center">{{ (list.pm_out_at) ? list.pm_out_at.time : '-' }}</td>
                                <td class="text-center">-</td>
                                <td class="text-end">
                                    <b-button @click="openView(list)" variant="soft-info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                                        <i class="ri-eye-fill align-bottom"></i>
                                    </b-button>
                                </td> -->
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
<Create :dropdowns="dropdowns" ref="create"/>
</template>
<script>
import _ from 'lodash';
import Create from './Modals/Create.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Create },
    props: ['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
                date: null,
                type: null
            },
            index: null
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal);
        },
        "filter.date"(newVal){
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
            page_url = page_url || '/documents';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    date: this.filter.date,
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
        openCreate(){
            this.$refs.create.show();
        }
    }
}
</script>