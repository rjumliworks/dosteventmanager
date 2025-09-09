<template>
    <Head title="Log in"/>
    <div class="landing-wrapper d-flex justify-content-center align-items-center">
        <div class="auth-page-content registration_bg">
            <BContainer fluid class="h-100 ">
                <BRow class="justify-content-center align-items-center h-100">
                    <BCol md="8" lg="10" xl="8" >
                        <BCard no-body class="" style="height:100%" >
                            <BCardBody class="p-4 ">
                                
                                <div class="row mb-4 justify-content-center " >
                                        <div class="text-primary mt-1 t">
                                            <img src="@assets/images/event/event_title2.png" alt="" class="img-fluid" >
                                        </div>
                                </div>

                                <div class="text-center fw-bold fs-3 text-success mb-5 mt-5 px-10">
                                    Your information has been submitted successfully  , Please check your email for verification. Thank you.
                                </div>

                                <!-- <div class="text-center"> 
                                    <h5 >Download the App</h5>
                                    <b-row>
                                        <b-col lg="6">
                                            <b-button> Android</b-button>
                                        </b-col>
                                        <b-col lg="6">
                                            <b-button class="">IOS</b-button>
                                        </b-col>
                                    </b-row>
                                     <h5 class="text-muted mt-3">Click the button to see instructions.</h5>
                                </div> -->

                            </BCardBody>
                        </BCard>
                    </BCol>

                </BRow>
            </BContainer>
        </div>
    </div>



</template>
<script >
import { useForm } from '@inertiajs/vue3';
import Checkbox from '@/Shared/Components/Forms/Checkbox.vue';
import InputError from '@/Shared/Components/Forms/InputError.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import Multiselect from '@/Shared/Components/Forms/Multiselect.vue';
// import DisclaimerModal from '../Pages/Registration/Modals/Disclaimer.vue';

export default {
    layout: null,
    components: {   InputError, InputLabel, TextInput, Multiselect  },
    props: ['dropdowns'],
    data() {
        return {
             form: useForm({
                firstname:null,
                middlename : null,
                lastname : null,
                suffix: null,
                email: null,
                affiliation: null,
                designation: null,
                contact_no: null,
                sex_id: null,
                birthdate: null,
                is_4ps: false,
                is_pwd: false,
                is_ip: false,
                captcha: null
            }),
            showModal: false,
            formSubmitted : false,
            inputed_captcha: null,
            event_sessions: {},
            

            //captcha
            captchaUrl: '/captcha?' + Date.now(),
            captcha: null,
            userInput: "",
            error: "",
            success: ""
        }
    },

    mounted(){
        this.showModal = true;
        this.refreshCaptcha()
    },



    methods: {

        getError(field) {
            return this.form.errors[field] ? this.form.errors[field][0] : '';
        },

        refreshCaptcha() {
            this.captcha = this.captchaUrl = '/captcha?' + Date.now(); // always flat, always new
        },
            

        submit(){ 
            this.loading = true;
            this.form.post('/', {
                onSuccess: () => {
                    this.loading = false;
                    this.form.reset();   
                    this.formSubmitted = true;               
                },
            });

            if(this.form.captcha){
                this.captchaModal = false;
            }
          
        },

        hide(){
            this.showModal = false;
        },
        
        saveSignature() {
            this.form.signature = this.$refs.signaturePad.saveSignature()
        },

        clearSignature() {
            this.$refs.signaturePad.clearSignature()
        },

        
        getEventSessions() {
            axios.get('/attendance/register',{
                params : {
                    option: 'event_sessions'
                }
            })
            .then(response => {
                if(response){
                    this.event_sessions = response.data;   
                }
            })
            .catch(err => console.log(err));
        },
    },

    submit(){
        this.form.post('/',{
            preserveScroll: true,
            onSuccess: (response) => {
                this.form.clearErrors();
                this.form.reset();
            },
        });
    },


    // captcha
    randomCode(len = 5) {
      const chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
      return Array.from({ length: len }, () => chars[Math.floor(Math.random() * chars.length)]).join("");
    },
    refresh() {
      this.code = this.randomCode();
      this.input = "";
      this.isValid = null;
      this.message = "";
    },
    check() {
      this.isValid = this.input.trim().toUpperCase() === this.code;
      this.message = this.isValid ? "Correct ✅" : "Incorrect ❌";
      this.$emit("verified", this.isValid);
    }    
    
}
</script>
<style scoped>
.landing-wrapper {
  min-height: 100vh;  /* full viewport */
  width: 100%;
  display: flex;
  flex-direction: column;
}

.auth-page-content {
  flex: 1;           /* take all remaining height */
  display: flex;
  flex-direction: column;
}
</style>
