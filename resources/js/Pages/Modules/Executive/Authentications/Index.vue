<template>
    <PageHeader title="Authentication Logs" pageTitle="List" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px); overflow: auto;" ref="box">

            <b-row class="g-2 mb-2 mt-n2">
                <b-col lg>
                    <div class="input-group mb-1">
                        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                        <input type="text" v-model="filter.keyword" placeholder="Search Logs" class="form-control" style="width: 60%;">
                        <!-- <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                            <i class="bx bx-refresh search-icon"></i>
                        </span> -->
                    </div>
                </b-col>
            </b-row>
            <div class="table-responsive">
                <table class="table table-nowrap align-middle mb-0">
                    <thead class="table-light">
                        <tr class="fs-11">
                            <th></th>
                            <th style="width: 35%;">Browser</th>
                            <th style="width: 15%;" class="text-center">IP Address</th>
                            <th style="width: 20%;" class="text-center">Location</th>
                            <th style="width: 17%;" class="text-center">Date</th>
                            <th style="width: 10%;" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(list,index) in lists" v-bind:key="index">
                            <td>
                                <div class="flex-shrink-0 avatar-xs">
                                    <div class="avatar-title bg-light text-primary rounded-3 fs-15">
                                        <i :class="'ri-'+list.type+'-fill '+list.attempt"></i>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5 class="fs-13 mb-0 text-dark">{{list.platform}} <span class="fs-12 text-muted">({{list.browser}})</span></h5>
                                <p v-if="list.location" class="fs-12 text-muted mb-0">{{ list.location.city }},  {{ list.location.state_name }}, {{ list.location.country }}</p>
                                <p v-else class="fs-12 text-muted mb-0">Not Available</p>
                            </td>
                            <td class="text-center">{{list.ip}} </td>
                            <td class="text-center text-muted fs-11">{{list.location.timezone}} ({{list.location.postal_code}})</td>
                            <td class="text-center text-muted fs-11">{{list.created_at}}</td>
                            <td class="text-center">
                                <span :class="(!list.is_failed) ? 'badge bg-success' : 'badge bg-danger'">
                                    <span v-if="list.is_suspicious">Suspicious</span>
                                    <span v-if="!list.is_failed">Successful</span>
                                    <span v-else>Failed</span>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
            </div>

        </div>
    </div>
</template>
<script>
import _ from 'lodash';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination },
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
                    option: 'authentications'
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
        }
    }
}
</script>