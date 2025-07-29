<template>
    <div class="auth-page-wrapper d-flex flex-column">
        <div class="auth-page-content d-flex justify-content-center " style="background-color: #EFF0F3; min-height: 100vh; overflow: hidden;">

           <div class="row p-5">
                <div class="col-lg-12">
                    <div class="text-center mb-4">
                        <img src="@assets/images/logo-sm.png" alt="" class="avatar-xs mb-1">
                        <h1 class="mb-0 ff-secondary fw-semibold text-capitalize lh-base fs-24"><span class="text-primary">{{ selected.title }}</span></h1>
                        <h1 class="mb-0 ff-secondary fw-semibold text-capitalize lh-base fs-18"><span class="text-warning">{{ selected.event.name }}</span></h1>
                        <p class="text-muted mb-2 fs-14">{{ selected.detail.description }}</p>
                    </div>
                </div>
                <div class="col-lg-12">
                   <div class="text-center mb-0 mt-n5">
    <div class="position-relative d-inline-block" style="width: 600px;">
        <!-- Phone image -->
        <img src="/images/border.png" alt="Phone Frame" class="img-fluid" style="width: 100%;" />

        <!-- QR code positioned on the phone screen -->
        <img
            :src="selected.qr"
            alt="QR Code"
            class="position-absolute"
            style="top: 53%; left: 51.5%; transform: translate(-50%, -50%); width: 180px;"
        />
    </div>
</div>

                    
                </div>
                <!-- <div class="col-lg-9">
                    <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3">
                                    <div style="height: 2.5rem; width: 2.5rem;">
                                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                            <i class="ri-file-list-3-line text-primary fs-24"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-14"><span class="text-body">Schedule</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-12">Please review the participant details and event information carefully before completing the registration process.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-white rounded-bottom">
                            <div class="table-responsive table-card" style="height: calc(100vh - 400px); overflow-x: hidden;">
                                <table class="table table-nowrap align-middle mb-0">
                                    <thead class="bg-primary text-white thead-fixed">
                                        <tr class="fs-10">
                                            <th style="width: 15%;" class="text-center">Time</th>
                                            <th class="text-center">Activity</th>
                                            <th style="width: 15%;" class="text-center">Person In Charge</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="selected.activities.length > 0">
                                        <tr v-for="(list,index) in selected.activities" v-bind:key="index" class="fs-12">
                                            <td class="text-center">{{list.start_time }} - {{list.end_time }}</td>
                                            <td class="text-center" :class="(list.has_breakdown) ? 'fw-semibold text-primary' : '' ">{{list.activity }}</td>
                                            <td class="text-center">{{(list.speaker) ? list.speaker.name : '-' }}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No records found.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>

        </div>
        <b-button variant="danger" @click="topFunction" class="btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </b-button>
    </div>
</template>
<script>
export default {
    layout: null,
    props: ['session'],
    data(){
        return {
           selected: this.session.data
        }
    },
    methods: { 
       
    }
}
</script>