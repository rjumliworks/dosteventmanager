<template>
<Head title="Documents"/>
<PageHeader title="List of Documents" pageTitle="List" />
<BRow>
    
</BRow>
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
                date: null,
                type: null
            },
            index: null
        }
    },
     mounted() {
        this.setupEchoListener();
    },
    methods: {
        setupEchoListener() {
            window.Echo.channel('system-maintenance')
            .listen('SystemMaintenanceEvent', (event) => {
                alert(event.time);
                console.log(event);
            });
        },
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