<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 750px;" header-class="p-3 bg-light" title="View Date Time Record" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform" v-if="selected">
            <BRow>
               <div class="col-md-12">
                    <div>
                        <h4 class="fw-semibold fs-16 mb-1">{{ selected.user.profile.firstname }} {{ selected.user.profile.lastname }}</h4>
                        <div class="hstack gap-3 flex-wrap fs-12">
                            <div><span class="text-muted">Date :</span> {{selected.date}}</div>
                            <div class="vr" style="width: 1px;"></div>
                            <div><span class="text-muted">Date Created :</span> {{selected.created_at}}</div>
                        </div>
                    </div>
               </div>
                <div class="col-md-12 mb-n3">
                    <hr class="text-muted"/>
                </div>
                <div class="col-md-12 mt-3 mb-n3">
                    <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3">
                                    <div style="height:2rem;width:2rem;">
                                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                            <i class="ri-alarm-fill text-primary fs-20"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 mt-n1 fs-12"><span class="text-body">Daily Time Logs</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-11">Tracks attendance times and logs any changes for accurate records.</p>
                                </div>
                            
                            </div>
                        </div>
                        <div class="card-body bg-white rounded-bottom">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-1">
                                    <thead class="bg-primary fs-11 thead-fixed">
                                        <tr class="text-white">
                                            <th class="text-center" style="width: 20%;">Type</th>
                                            <th class="text-center" style="width: 20%;">Time</th>
                                            <th class="text-center" style="width: 25%;">IP Address</th>
                                            <th class="text-center" style="width: 25%;">PC Name</th>
                                            <th  style="width: 10%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-12">
                                        <tr>
                                            <td class="text-center text-muted">Time In (AM)</td>
                                            <td class="text-center" :class="selected.am_in_at && selected.am_in_at.is_updated ? 'fst-italic' : ''">{{ (selected.am_in_at) ? selected.am_in_at.time : '-' }}</td>
                                            <td class="text-center">{{ (selected.am_in_at) ? selected.am_in_at.ip : '-' }}</td>
                                            <td class="text-center">{{ (selected.am_in_at) ? selected.am_in_at.pcname : '-' }}</td>
                                            <td class="text-center">
                                                <b-button v-if="selected.am_in_at" @click="openEdit(selected.id,selected.am_in_at,'Time In (AM)')" variant="soft-warning" v-b-tooltip.hover title="Edit" size="sm">
                                                    <i class="ri-pencil-fill align-bottom"></i>
                                                </b-button>
                                                <b-button v-else @click="openTime(selected.id,'Time In (am)')" variant="soft-info" v-b-tooltip.hover title="Edit" size="sm">
                                                    <i class="ri-add-circle-fill align-bottom"></i>
                                                </b-button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center text-muted">Time Out (AM)</td>
                                            <td class="text-center" :class="selected.am_out_at && selected.am_out_at.is_updated ? 'fst-italic' : ''">{{ (selected.am_out_at) ? selected.am_out_at.time : '-' }}</td>
                                            <td class="text-center">{{ (selected.am_out_at) ? selected.am_out_at.ip : '-' }}</td>
                                            <td class="text-center">{{ (selected.am_out_at) ? selected.am_out_at.pcname : '-' }}</td>
                                            <td class="text-center">
                                                <b-button v-if="selected.am_out_at" @click="openEdit(selected.id,selected.am_out_at,'Time Out (AM)')" variant="soft-warning" v-b-tooltip.hover title="Edit" size="sm">
                                                    <i class="ri-pencil-fill align-bottom"></i>
                                                </b-button>
                                                <b-button v-else @click="openTime(selected.id,'Time Out (am)')" variant="soft-info" v-b-tooltip.hover title="Edit" size="sm">
                                                    <i class="ri-add-circle-fill align-bottom"></i>
                                                </b-button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center text-muted">Time In (PM)</td>
                                            <td class="text-center" :class="selected.pm_in_at && selected.pm_in_at.is_updated ? 'fst-italic' : ''">{{ (selected.pm_in_at) ? selected.pm_in_at.time : '-' }}</td>
                                            <td class="text-center">{{ (selected.pm_in_at) ? selected.pm_in_at.ip : '-' }}</td>
                                            <td class="text-center">{{ (selected.pm_in_at) ? selected.pm_in_at.pcname : '-' }}</td>
                                            <td class="text-center">
                                                <b-button v-if="selected.pm_in_at" @click="openEdit(selected.id,selected.pm_in_at,'Time In (PM)')" variant="soft-warning" v-b-tooltip.hover title="Edit" size="sm">
                                                    <i class="ri-pencil-fill align-bottom"></i>
                                                </b-button>
                                                <b-button v-else @click="openTime(selected.id,'Time In (pm)')" variant="soft-info" v-b-tooltip.hover title="Edit" size="sm">
                                                    <i class="ri-add-circle-fill align-bottom"></i>
                                                </b-button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center text-muted">Time Out (PM)</td>
                                            <td class="text-center" :class="selected.pm_out_at && selected.pm_out_at.is_updated ? 'fst-italic' : ''">{{ (selected.pm_out_at) ? selected.pm_out_at.time : '-' }}</td>
                                            <td class="text-center">{{ (selected.pm_out_at) ? selected.pm_out_at.ip : '-' }}</td>
                                            <td class="text-center">{{ (selected.pm_out_at) ? selected.pm_out_at.pcname : '-' }}</td>
                                            <td class="text-center">
                                                <b-button v-if="selected.pm_out_at" @click="openEdit(selected.id,selected.pm_out_at,'Time Out (PM)')" variant="soft-warning" v-b-tooltip.hover title="Edit" size="sm">
                                                    <i class="ri-pencil-fill align-bottom"></i>
                                                </b-button>
                                                <b-button v-else @click="openTime(selected.id,'Time Out (pm)')" variant="soft-info" v-b-tooltip.hover title="Edit" size="sm">
                                                    <i class="ri-add-circle-fill align-bottom"></i>
                                                </b-button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </BRow>
        </form>
          <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
        </template>
    </b-modal>
    <Time @update="updateData" ref="time"/>
    <Edit @update="updateData" ref="edit"/>
</template>
<script>
import Edit from './Edit.vue';
import Time from './Time.vue';
export default {
    components: { Edit, Time },
    data(){
        return {
            currentUrl: window.location.origin,
            selected: null,
            type: null,
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.selected = data;
            this.showModal = true;
        },
        openEdit(id,data,type){
            this.type = type;
            this.$refs.edit.show(id,data,type);
        },
        openTime(id,type){
            this.type = type;
            this.$refs.time.show(id,type);
        },
        updateData(data){
            this.selected = data;
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>