<template>

    <Head title="Human Resource - Date Time Record" />

   <body>
    <div class="account-pages my-4 pt-sm-5">
        <div class="container">
                
           
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="text-center mb-4">
                        <img src="/images/logo-sm.png" alt="" class="avatar-md mb-2">
                        <p class="fs-15 fw-semibold text-p text-uppercase">Department of Science & Technology - IX</p>
                        <p class="fs-13 text-muted" style="margin-top: -20px;">Human Resource - Date Time Record</p>
                    </div>
                    <div class="card border bg-primary">
                        <h4 class="text-white p-3" style="margin-bottom: -28px;">{{ currentDate}}</h4>
                        <div class="card-body mt-4 mb-n3 bg-white bg-soft">
                            <h1 style="font-size: 140px; margin-top: -10px; margin-bottom: -2px;" class="text-primary text-center dfw-medium" v-text="currentTime"></h1>
                        </div>
                    
                        <div class="card-body border-top bg-soft" style="background-color: white; ">
                            <div class="p-2">
                                <div class="text-center">
                                   <div class=" mt-n2 mb-n2">
                                        <b-tabs v-model="activebutton" pills nav-class="bg-light rounded nav-justified fw-bold" content-class="mt-3">
                                            <b-tab title="AM IN" v-on:click="swap('Time In (am)','0')"></b-tab>
                                            <b-tab title="AM OUT" v-on:click="swap('Time Out (am)','1')"></b-tab>
                                            <b-tab title="PM IN" v-on:click="swap('Time In (pm)','2')"></b-tab>
                                            <b-tab title="PM OUT" v-on:click="swap('Time Out (pm)','3')"></b-tab>
                                        </b-tabs>
                                    </div>
                                    <input @keyup.enter="find" v-model="form.username" autofocus type="text" class="form-control form-control-lg text-center" style="font-size: 30px; text-transform: uppercase; background-color: #eff2f7;">
                                </div>
                                <template v-if="user">
                                    <div v-if="status == 'New' || status == 'Success'" class="alert alert-success alert-dismissible alert-additional mt-3 mb-n1" role="alert">
                                        <div class="alert-body">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <img :src="user.avatar" alt="" class="rounded-circle" style="height: 2.5rem; width: 2.5rem;">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="alert-heading mb-0">{{user.name}}</h5>
                                                    <p class="mb-0"> {{user.division}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert-content">
                                            <p class="mb-0" v-html="user.message.message"></p>
                                        </div>
                                    </div>
                                    <div v-else :class="'alert alert-'+user.message.status+' alert-dismissible bg-'+user.message.status+' mt-3 text-white alert-label-icon mb-xl-0'" role="alert">
                                        <i class="ri-error-warning-line label-icon"></i><span v-html="user.message.message"></span>
                                     </div>
                                </template>
                                <template v-if="status == 'Error'">
                                    <div class="alert alert-danger alert-dismissible bg-danger mt-3 text-white alert-label-icon mb-xl-0" role="alert">
                                        <i class="ri-error-warning-line label-icon"></i><strong>Danger</strong> - Your record could not be found. Please contact the administrator for assistance.
                                     </div>
                                </template>

                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>2025 © DOST-IX ICT TEAM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</template>
<script>
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'  };
    const options1 = { hour12: false  };
    const twelve = new Date("2022-03-25 11:00:00").toLocaleTimeString("en-US",options1);
    const twelvethirty = new Date("2022-03-25 12:30:00").toLocaleTimeString("en-US",options1);
    const one = new Date("2022-03-25 15:00:00").toLocaleTimeString("en-US",options1);
    import { useForm } from '@inertiajs/vue3';
import { isError } from 'lodash';
    export default {
        layout: null,
        data() {
            return {
                currentUrl: window.location.origin,
                currentDate: null,
                currentTime: null,
                currentTime2: null,
                user: '',
                activebutton: 0,
                inactive: false,
                message: '',
                status: '',
                form: useForm({
                    username: null,
                    type:'Time In (am)',
                    option: 'dtr'
                }),
            };
        },

        created(){
            this.filter();
        },

        mounted() {
            setInterval(() => {
                this.currentSecond = new Date().toLocaleTimeString([],{seconds: '2-digit'});
                this.currentTime = new Date().toLocaleTimeString("en-US");
                this.currentDate = new Date().toLocaleDateString("en-US",options);
            }, 1000);
        },

        methods: {
            find(){
                this.user = ''; 
                this.inactive = false;
                
                this.form.post('/dtr',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        if(response.props.flash.info == 'Error'){
                            this.status = response.props.flash.info;
                            setInterval(() => {
                                this.status = null;
                            }, 9000);
                        }else{
                            this.status = response.props.flash.info;
                            this.user = response.props.flash.data;
                            this.form.username = null;
                            setInterval(() => {
                                this.user = null;
                                this.status = null;
                            }, 9000);
                        } 
                    },
                });
            },

            filter(){
                this.currentTime2 = new Date().toLocaleTimeString("en-US",options1);
                if(this.currentTime2 < twelve){
                    this.activebutton = 0; this.form.type = 'Time In (am)';
                }else if(this.currentTime2 >= twelve && this.currentTime2 < twelvethirty){
                    this.activebutton = 1; this.form.type = 'Time Out (am)';
                }else if(this.currentTime2 >= twelvethirty && this.currentTime2 < one){
                    this.activebutton = 2; this.form.type = 'Time In (pm)';
                }else{
                    this.activebutton = 3; this.form.type = 'Time Out (pm)';
                }
            },

            swap(type,action){
                this.form.type = type;
                this.activebutton = action;
                setInterval(() => {
                    this.filter();
                    this.user = '';
                }, 20000); 
            }
        }
    }
</script>
<style>
.nav-pills .nav-link {
    font-weight: bold;
    font-size: 16px;
}
</style>