<template>
    <div class="card-body bg-white border-bottom shadow-none">
        <b-row class="mt-n3 mb-2 ms-n4 me-n4">
            <b-col lg>
                <div class="input-group mb-1">
                    <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                    <input type="text"  placeholder="Search Session" class="form-control" style="width: 30%;">
                    <b-button type="button" variant="primary" @click="openCreate">
                        <i class="ri-add-circle-fill align-bottom me-1"></i> Create
                    </b-button>
                </div>
            </b-col>
        </b-row>
    </div>
    <div class="table-responsive table-card" style="height: calc(100vh - 330px);">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="bg-primary text-white">
                <tr class="fs-10">
                    <!-- <th style="width: 4%;"></th> -->
                    <th style="width: 15%;" class="text-center">Time</th>
                    <th class="text-center">Activity</th>
                    <th style="width: 15%;" class="text-center">Person In Charge</th>
                </tr>
            </thead>
            <tbody v-if="activities.length > 0">
                <tr v-for="(list,index) in activities" v-bind:key="index" class="fs-12">
                    <!-- <td>{{ index + 1 }}.</td> -->
                    <td class="text-center">{{list.start_time }} - {{list.end_time }}</td>
                    <td class="text-center">{{list.activity }}</td>
                    <td class="text-center">{{list.speaker.name }}</td>
                    <!-- <td class="text-center">{{list.venue.name}}, {{ list.venue.establishment }}</td>
                    <td class="text-center">{{list.detail.attendees}}/{{ list.detail.capacity }}</td>
                    <td class="text-center">{{ dateRange(list.schedules) }}</td>
                     <td class="text-end">
                        <Link :href="`/sessions/${list.key}`">
                            <b-button variant="soft-info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                                <i class="ri-eye-fill align-bottom"></i>
                            </b-button>
                        </Link>
                        <b-button @click="openEdit(list)" variant="soft-warning" v-b-tooltip.hover title="Edit" size="sm">
                            <i class="ri-pencil-fill align-bottom"></i>
                        </b-button>
                    </td> -->
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="6" class="text-center text-muted">No records found.</td>
                </tr>
            </tbody>
        </table>
    </div>
    <Create :schedules="schedules" :id="id" ref="create"/>
</template>
<script>
import _ from 'lodash';
import Create from './Modals/CreateActivity.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, Create },
    props: ['id','activities','schedules'],
    methods: {
        openCreate(){
            this.$refs.create.show();
        },
        openEdit(list){
            this.$refs.create.edit(list);
        }
    }
}
</script>