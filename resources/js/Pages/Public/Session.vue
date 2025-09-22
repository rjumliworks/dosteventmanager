<template>
    <div class="auth-page-wrapper d-flex flex-column">
        <div class="auth-page-content d-flex justify-content-center"
             style="background-color:#EFF0F3; min-height:100vh; overflow:hidden;">
            <div class="row p-5">
                <!-- Header Info -->
                <div class="col-lg-12 text-center mb-3">
                    <img src="@assets/images/logos/dost.png" alt="" class="avatar-xs mb-1">
                    <img src="@assets/images/logos/bagongpilipinas.png" alt="" class="avatar-xs mb-1">
                    <h1 class="mb-0 ff-secondary fw-semibold text-capitalize lh-base fs-22">
                        <span class="text-primary">{{ selected.title }}</span>
                    </h1>
                    <h1 class="mb-0 ff-secondary fw-semibold text-capitalize lh-base fs-14">
                        <span class="text-warning">{{ selected.event.name }}</span>
                    </h1>
                    <h1 class="mb-0 ff-secondary fw-semibold text-capitalize lh-base fs-12">
                        <span class="text-success">{{ selected.venue.address }}</span>
                    </h1>
                    <!-- <p class="text-muted mb-2 fs-12">{{ selected.detail.description }}</p> -->
                </div>

                <!-- QR / Camera Box -->
                <div class="col-lg-5" style="margin-top: 65px;">
                    <div class="text-center">
                        <div class="position-relative d-inline-block" style="width:700px; height:400px;">
                            <img src="/images/hands.png"
                                 alt="Phone Frame"
                                 class="img-fluid position-absolute"
                                 style="top:-40%; left:0; width:100%;" />

                            <div class="position-absolute qr-box" style="top:58%; left:53.2%; transform:translate(-50%, -50%);">
                                <img v-if="!showScanner"
                                    :src="selected.qr"
                                    alt="QR Code"
                                    style="width: 100%; height: 100%; object-fit: contain;"
                                />
                                <div v-show="showScanner" id="qr-reader" class="qr-child"></div>
                                <video v-show="showCamera"
                                    ref="cameraPreview"
                                    autoplay
                                    playsinline
                                    class="qr-child">
                                </video>
                                <img v-if="capturedImage && !showCamera && !showScanner"
                                    :src="capturedImage"
                                    class="qr-child" />
                                <div v-if="countdown > 0" class="countdown-overlay">
                                    {{ countdown }}
                                </div>
                            </div>

                            <b-form-group class="text-center position-absolute" style="top:104%; left:58%; transform:translate(-50%, -50%); width:200px;">
                                <b-form-checkbox switch v-model="scannerToggle">
                                    {{ scannerToggle ? 'Stop Scanner' : 'Start Scanner' }}
                                </b-form-checkbox>
                            </b-form-group>
                        </div>
                    </div>
                </div>

                <!-- Attendance Table -->
                <div class="col-lg-6 mt-4">
                    <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle d-flex justify-content-center align-items-center" style="height:120px;">
                            <div class="d-flex w-100 justify-content-center align-items-center" v-if="error">
                                <div class="p-4 w-100 border rounded bg-danger-subtle text-center">
                                    <p class="mb-0 text-danger fw-semibold">Hi, {{ error.name }}</p>
                                    <p class="mb-0 text-danger fs-11" v-if="error.type == 'not'">You are <b>not registered</b> as a participant. Please go to the <b>Sessions tab</b> to complete your registration</p>
                                    <p class="mb-0 text-danger fs-11" v-else>Your attendance has already been recorded</p>
                                </div>
                            </div>
                            <div v-else-if="participant.avatar" class="pt-1 ps-1 profile-wrapper">
                                <div class="row g-4">
                                    <div class="col-auto">
                                        <div>
                                            <img :src="participant.avatar" alt="user-img" class="avatar-lg">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="p-2 mt-1">
                                            <p class="text-primary text-opacity-75 mb-1">Welcome, and thank you..</p>
                                            <h3 class="text-primary mb-1">{{ participant.participant.firstname }} {{ participant.participant.lastname }}</h3>
                                            <p class="text-primary text-muted fs-14">Attendance confirmed on <b class="text-primary">{{participant.attended_at}}</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="d-flex w-100 justify-content-center align-items-center">
                                <div class="p-4 w-100 border rounded bg-dark-subtle text-center">
                                    <p class="mb-0 text-dark fs-12">Please use the <b>QR Scanner</b> in the application to scan the provided QR code.</p>
                                    <p class="mb-0 text-muted fs-11">If you are using the mobile browser, please allow camera access to enable QR code scanning.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3">
                                    <div style="height:2.5rem; width:2.5rem;">
                                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                            <i class="ri-file-list-3-line text-primary fs-24"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-14"><span class="text-body">List of Attendees</span></h5>
                                    <p class="text-muted fs-12">
                                        Shows participants who have successfully scanned the QR code.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-white rounded-bottom">
                            <div class="table-responsive table-card"
                                 style="height:calc(100vh - 550px); overflow-x:hidden;">
                                <table class="table table-nowrap align-middle mb-0">
                                    <thead class="bg-light thead-fixed">
                                        <tr class="fs-11">
                                            <th class="text-center">#</th>
                                            <th>Name</th>
                                            <th class="text-center">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="session.data.attendees.length">
                                        <tr v-for="(list,index) in session.data.attendees"
                                            :key="index"
                                            :class="['fs-12',{ 'fw-semibold bg-success-subtle': index === 0 }]">
                                            <td class="text-center">{{ index + 1 }}</td>
                                            <td>{{ list.participant.firstname }} {{ list.participant.lastname }}</td>
                                            <td class="text-center">{{ list.attended_at }}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr><td colspan="3" class="text-center text-muted">No participants found.</td></tr>
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
import { useForm } from '@inertiajs/vue3'
import { Html5Qrcode } from 'html5-qrcode'

export default {
    layout: null,
    props: ['session'],
    data() {
        return {
            selected: this.session.data,
            scannerToggle: false,  
            showScanner: false,     
            showCamera: false,      
            capturedImage: null,   
            countdown: 0,
            qrScanner: null,
            cameraStream: null,
            form: useForm({
                session: this.session.data.key,
                participant: null,
                image: null,
                option: 'attendance'
            }),
            error: null,
            code: this.generateRandomKey(10),
            participant: {}
        }
    },
    watch: {
        scannerToggle(val) {
            if (val) this.startScanner()
            else this.stopScanner()
        }
    },
    mounted() {
        this.setupEchoListener()
    },
    methods: {
        setupEchoListener() {
            window.Echo.channel('session')
                .listen('SessionEvent', (event) => {
                if(this.code == event.code){
                    switch(event.type){
                        case 'attendance':
                            if (!this.session.data.attendees.some(a => a.id === event.data.id)) {
                                this.session.data.attendees.unshift(event.data);
                                this.startCamera(event.data.participant_id);
                            }
                        break;
                        case 'attendance-error':
                            this.error = event.data;
                        break;
                        case 'attendance-image':
                            this.participant = event.data;
                        break;
                    }
                }
            })
        },
        async startScanner() {
            await this.$nextTick()
            this.error = null;
            this.showScanner = true
            this.capturedImage = null
            const config = { fps: 10, qrbox: { width: 200, height: 200 } }

            this.qrScanner = new Html5Qrcode("qr-reader")
            try {
                await this.qrScanner.start(
                    { facingMode: "environment" },
                    config,
                    async (decodedText) => {
                        await this.qrScanner.stop()
                        this.qrScanner.clear()
                        this.qrScanner = null
                        this.showScanner = false
                        this.startCamera(decodedText)
                    },
                    (err) => console.warn(err)
                )
            } catch (err) {
                console.error("Scanner error:", err)
            }
        },
        stopScanner() {
            this.showScanner = false
            if (this.qrScanner) {
                this.qrScanner.stop().then(() => this.qrScanner.clear()).catch(()=>{})
                this.qrScanner = null
            }
        },
        async startCamera(code) {
            this.error = null;
            try {
                this.showCamera = true
                this.cameraStream = await navigator.mediaDevices.getUserMedia({ video: true })
                this.$refs.cameraPreview.srcObject = this.cameraStream
                this.countdown = 5
                while (this.countdown > 0) {
                    await new Promise(r => setTimeout(r, 1000))
                    this.countdown--
                }
                this.capturePhoto()
                this.stopCamera()
                this.submit(code)
            } catch (err) {
                console.error("Camera error:", err)
            }
        },
        capturePhoto() {
            const video = this.$refs.cameraPreview
            const canvas = document.createElement("canvas")
            canvas.width = 200
            canvas.height = 200
            const ctx = canvas.getContext("2d")
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height)
            this.form.image = canvas.toDataURL("image/png")
        },
        stopCamera() {
            if (this.cameraStream) {
                this.cameraStream.getTracks().forEach(t => t.stop())
                this.cameraStream = null
            }
            this.showCamera = false
        },
        submit(code) {
            this.form.code = this.code;
            this.form.participant = code
            this.form.put('/sessions/update', { preserveScroll: true })
        },
        generateRandomKey(length) {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
            let result = ''
            for (let i = 0; i < length; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length))
            }
            return result
        }
    },
    beforeUnmount() {
        this.stopScanner()
        this.stopCamera()
    }
}
</script>
<style scoped>
/* Parent container controls final size */
.qr-box {
  width: 310px;        /* ✅ change here for bigger/smaller box */
  height:310px;
  position: relative;
  overflow: hidden;
}

/* All child layers fill exactly the same area */
.qr-child {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;   /* ensures camera/photo scales uniformly */
}

/* Centered countdown */
.countdown-overlay {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 2rem;
  color: #fff;
  text-shadow: 0 0 5px #000;
  font-weight: bold;
}

</style>