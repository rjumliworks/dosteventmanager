<template>
    <div class="auth-page-wrapper d-flex flex-column">
        <div class="auth-page-content d-flex justify-content-center " style="background-color: #EFF0F3; min-height: 100vh; overflow: hidden;">

           <div class="row p-5">
                <div class="col-lg-12">
                    <div class="text-center">
                        <img src="@assets/images/logo-sm.png" alt="" class="avatar-xs mb-1">
                        <h1 class="mb-0 ff-secondary fw-semibold text-capitalize lh-base fs-24"><span class="text-primary">{{ selected.title }}</span></h1>
                        <h1 class="mb-0 ff-secondary fw-semibold text-capitalize lh-base fs-18"><span class="text-warning">{{ selected.event.name }}</span></h1>
                        <h1 class="mb-0 ff-secondary fw-semibold text-capitalize lh-base fs-12"><span class="text-success">{{ selected.venue.address}}</span></h1>
                        <p class="text-muted mb-2 fs-12">{{ selected.detail.description }}</p>
                    </div>
                </div>
                <div class="col-lg-5" style="margin-top: 20px; margin-bottom: -80px;">
                   <div class="text-center">
                       <div class="position-relative d-inline-block" style="width: 700px; height: 400px;">
                            <img src="/images/border.png" alt="Phone Frame" class="img-fluid position-absolute" style="top: -40%; left: 0%; width: 100%;" />
                            <div class="position-absolute" style="top: 53%; left: 51.7%; transform: translate(-50%, -50%); width: 200px; height: 200px;">
                                <img
                                    v-if="!showScanner"
                                    :src="selected.qr"
                                    alt="QR Code"
                                    style="width: 100%; height: 100%; object-fit: contain;"
                                />
                                <div v-else id="qr-reader" style="width: 100%; height: 100%;"></div>
                            </div>
                            <b-form-group class="text-center position-absolute" style="top: 85%; left: 55%; transform: translate(-50%, -50%); width: 200px;">
                                <b-form-checkbox switch v-model="showScanner">
                                    {{ showScanner ? 'Switch to QR Code' : 'Switch to Scanner' }}
                                </b-form-checkbox>
                            </b-form-group>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" style="margin-top: -20px; margin-bottom: -80px;">
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
                                    <h5 class="mb-0 fs-14"><span class="text-body">Attendance</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-12">Shows participants who have successfully scanned the QR code and marked their attendance.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-white rounded-bottom">
                            <div class="table-responsive table-card" style="height: calc(100vh - 400px); overflow-x: hidden;">
                                <table class="table table-nowrap align-middle mb-0">
                                    <thead class="bg-light thead-fixed">
                                        <tr class="fs-11">
                                            <th style="width: 7%;" class="text-center">#</th>
                                            <th>Name</th>
                                            <th style="width: 29%;" class="text-center">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="this.session.data.attendees.length > 0">
                                        <tr v-for="(list,index) in this.session.data.attendees" v-bind:key="index" :class="['fs-12',{ 'fw-semibold bg-success-subtle': index === 0 }]">
                                            <td class="text-center">{{ index+1 }}</td>
                                            <td>{{ list.participant.firstname }} {{ list.participant.lastname }}</td>
                                            <td class="text-center">{{ list.updated_at }}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No participants found.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import { Html5Qrcode } from "html5-qrcode";
export default {
    layout: null,
    props: ['session'],
    data(){
        return {
            selected: this.session.data,
            showScanner: false,
            qrScanner: null,
            form: useForm({
                session: this.session.data.key,
                participant: null,
                option: 'attendance'
            }),
        }
    },
    watch: {
        showScanner(newVal) {
            if (newVal) {
                this.startScanner();
            } else {
                this.stopScanner();
            }
        }
    },
    methods: { 
       async startScanner() {
            await this.$nextTick();
            const config = { fps: 10, qrbox: { width: 200, height: 200 } };
            this.qrScanner = new Html5Qrcode("qr-reader");
            try {
                await this.qrScanner.start(
                    { facingMode: "environment" },
                    config,
                    (decodedText) => {
                        // alert("Scanned QR: " + decodedText);
                        this.submit(decodedText);
                        // You can redirect, emit event, or store this
                        // this.stopScanner();
                        // this.showScanner = false;
                    },
                    (errorMessage) => {
                        console.warn("QR Scan Error", errorMessage);
                    }
                );
            } catch (err) {
                console.error("Failed to start scanner", err);
            }
        },
        stopScanner() {
            if (this.qrScanner) {
                this.qrScanner.stop().then(() => {
                    this.qrScanner.clear();
                    this.qrScanner = null;
                }).catch(err => {
                    console.error("Failed to stop scanner", err);
                });
            }
        },
        submit(code){
            this.form.participant = code;
            this.form.put('/sessions/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    
                },
            });
        }
    },
    beforeDestroy() {
        this.stopScanner();
    }
}
</script>