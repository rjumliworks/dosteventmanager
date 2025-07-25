<template>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <td style="border-right: none; border-left: none; cursor: pointer;" @click="openInformation()"><span class="fw-semibold fs-12 ms-2">Other Information</span></td>
            </tr>
            <tr>
                <td style="border-right: none; border-left: none;">
                    <div class="row ms-n2 mb-0">
                        <div class="col-md-12">
                            <div class="d-flex mt-0">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i :class="(selected.managers.length > 1) ? 'ri-team-fill' : 'ri-user-3-fill'"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-1 fs-12 text-muted">Session Manager :</p> 
                                    <h6 class="mb-0 fs-12">
                                        <div class="fw-semibold" v-for="(manager, index) in selected.managers" :key="index">
                                            {{ manager.user.profile.firstname }} {{ manager.user.profile.middlename[0] }}. {{ manager.user.profile.lastname }}
                                        </div>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-12">
                            <div class="d-flex mt-3">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-service-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-1 fs-12 text-muted">Current Status :</p> 
                                    <span :class="'badge '+selected.status.color">{{selected.status.name}}</span>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-md-12">
                            <div class="d-flex mt-3">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-calendar-event-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-1 fs-12 text-muted">Due Date :</p>
                                    <h6 class="text-truncate mb-0 fs-12" v-if="selected.due_at">{{selected.due_at}}</h6>
                                    <h6 class="text-warning mb-0 fs-12" v-else>Not yet set</h6>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </td>
            </tr>
            <!-- <tr>
                <td style="border-right: none; border-left: none;"><span class="fw-semibold fs-12 ms-2">Received Information</span></td>
            </tr>
            <tr>
                <td style="border-right: none; border-left: none;">
                    <div class="row ms-n2 mb-0">
                        <div class="col-md-12">
                            <div class="d-flex mt-0">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-calendar-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-1 fs-12 text-muted">Date Requested :</p> 
                                    <h6 class="text-truncate mb-0 fs-12">{{selected.created_at}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex mt-3">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-account-circle-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-1 fs-12 text-muted">Received By :</p>
                                    <h6 class="text-truncate mb-0"> <span class="fs-12">{{selected.received}}</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border-right: none; border-left: none;"><span class="fw-semibold fs-12 ms-2">Other Information</span></td>
            </tr>
            <tr>
                <td style="border-right: none; border-left: none;">
                    <div class="row ms-n2 mb-0">
                        <div class="col-md-12">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-qr-code-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-1 fs-12 text-muted">Discount :</p> 
                                    <h6 class="text-truncate mb-0 fs-12">
                                        <span >{{selected.payment.discounted.name}} ({{selected.payment.discounted.value }}%)</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex mt-3">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-calendar-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-1 fs-12 text-muted">Purpose of Request :</p>
                                    <h6 class="text-truncate mb-0 fs-12" v-if="selected.purpose">{{selected.purpose.name}}</h6>
                                    <h6 class="text-warning mb-0 fs-12" v-else>Not Available</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr> -->
           
        </tbody>
    </table>
</template>
<script>
export default {
    props: ['selected'],
}
</script>