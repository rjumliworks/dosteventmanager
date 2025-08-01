<template>
    <b-modal v-if="selected" v-model="showModal" style="--vz-modal-width: 700px;" header-class="p-3 bg-light"
        title="View Hotel" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <!-- ...content omitted for brevity... -->
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="row align-items-center g-3">
                    <div class="col-md">
                        <div>
                            <h6><span class="fw-semibold text-primary fs-15">{{ selected.name }}</span></h6>
                            <div class="hstack gap-3  fs-12 flex-wrap">
                                <div>Email :
                                    <span v-if="selected.email" class="fw-medium">{{ selected.email}}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div>
                                <div class="vr" style="width: 1px;"></div>
                                <div>Contact no. :
                                    <span v-if="selected.email" class="fw-medium">{{ selected.contact_no}}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div>
                                <!-- <div class="vr" style="width: 1px;"></div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="text-muted"/>
        <div class="table-responsive table-card">
            <table class="table align-middle table-centered mb-0">
                <thead class="table-light thead-fixed">
                    <tr class="fs-11">
                        <th style="width: 3%;"></th>
                        <th>Name</th>
                        <th style="width: 25%;" class="text-center">Rate</th>
                    </tr>
                </thead>
                <tbody class="table-white fs-12">
                    <tr v-for="(list,index) in selected.rates" v-bind:key="index">
                        <td class="text-center"> 
                            {{ index+1 }}
                        </td>
                        <td>
                            <h5 class="fs-13 mb-0 fw-semibold text-primary">{{list.name}}</h5>
                            <p class="fs-12 text-muted mb-0">{{list.detail }}</p>
                        </td>
                        <td class="text-center">{{ list.rate }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- <ul class="list-unstyled">
            <li v-for="(item, idx) in selected.rates" :key="idx" class="py-1 fs-12">
                <i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> {{ item.sample.code }}
            </li>
        </ul>            -->
        <!-- <hr class="text-muted" v-if="selected.lists.length > 0" />
        <div class="row" v-if="selected.lists.length > 0" style="max-height: 130px; overflow: auto;">
            <div class="col-md-3" v-for="(column, index) in columns" :key="index">
                <ul class="list-unstyled">
                    <li v-for="(item, idx) in column" :key="idx" class="py-1 fs-12">
                        <i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> {{ item.sample.code }}
                    </li>
                </ul>
            </div>
        </div>
        <hr class="text-muted mt-0" />
        <div class="row mt-2">
            <div class="col-sm-6">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i
                                    class="ri-calendar-line"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Report Date :</p>
                            <h5 class="mb-0 fs-12">{{selected.created_at}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i
                                    class="ri-calendar-line"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Released Date :</p>
                            <h5 class="mb-0 fs-12">-</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <template v-slot:footer>
            <b-button @click="hide" variant="light" block>Close</b-button>
            <b-button @click="openResult" variant="primary" block>Preview</b-button>
        </template>
    </b-modal>
</template>

<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                showModal: false,
                selected: null,
            };
        },
        methods: {
            show(data) {
                this.selected = data;
                this.showModal = true;
            },
            hide() {
                this.showModal = false;
            },
        }
    };

</script>
