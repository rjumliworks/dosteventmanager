<template>
    <Head title="Log in"/>
    <div class="landing-wrapper d-flex justify-content-center align-items-center">
        <div class="auth-page-content registration_bg ">
            <BContainer >
              
                <BRow class="justify-content-center  ">
                    <BCol md="8" lg="10" xl="8" >
                        <BCard no-body class="h">
                            <BCardBody class="p-4 ">
                                
                                <div class="row mb-4 justify-content-center " >
                                        <div class="text-primary mt-1 t">
                                            <img src="@assets/images/event/event_title2.png" alt="" class="img-fluid" >
                                        </div>
                                </div>

                                <div class="row mb-2 ">
                                    <div class="col-2 col-sm-1">
                                        <img src="@assets/images/logo-sm.png" alt="" class="avatar-sm">
                                    </div>
                                      <div class="col-10 col-sm-11 ; ">
                                        <div class="text-primary mt-1">
                                            <h4 class="fs-16 fw-semibold">DOST Region IX</h4>
                                            <p class="mt-n2 " >Registration Form</p>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="status" class="alert alert-success text-success">
                                    {{ status }}
                                </div>

                                <div class="p-2 mt-3">
                                    <form class="customform" @submit.prevent="submit">
                                     
                                        <BRow>                        
                                            <BCol lg="6" class="mt-2">
                                                <InputLabel value="First Name*" />
                                                <TextInput v-model="form.firstname" type="text" class="form-control" placeholder="Enter Firstname" 
                                                :class="{ 'is-invalid': form.errors.firstname }"   required/>
                                                <InputError :message="form.errors.firstname" />
                                                
                                            </BCol>
                                            <BCol lg="6" class="mt-2">
                                                <InputLabel value="Middle Name" />
                                                <TextInput v-model="form.middlename" type="text" class="form-control" placeholder="Enter Middlename"  />
                                            </BCol>
                                            <BCol lg="6" class="mt-2">
                                                <InputLabel value="Last Name*" />
                                                <TextInput v-model="form.lastname" type="text" class="form-control" placeholder="Enter Surname"  
                                                 :class="{ 'is-invalid': form.errors.lastname }"   required/>
                                                 <InputError :message="form.errors.lastname" />
                                            </BCol>
                                            <BCol lg="6" class="mt-2">
                                                <InputLabel value="Suffix" />
                                                <TextInput v-model="form.suffix" type="text" class="form-control" placeholder="e.g Jr." />
                                                
                                            </BCol>
                                             <BCol lg="12" class="mt-2">
                                                <InputLabel value="Email Address*" />
                                                <TextInput v-model="form.email" type="email" class="form-control" placeholder="Enter Email Address"
                                                :class="{ 'is-invalid': form.errors.email }"  required />
                                                <InputError :message="form.errors.email" />
                                            </BCol>
                                            <BCol lg="12" class="mt-2">
                                                <InputLabel value="Agency/Firm Address*" />
                                                <TextInput v-model="form.agency_firm_address" type="text" class="form-control" placeholder="Enter Agency/Firm Address" 
                                                :class="{ 'is-invalid': form.errors.agency_firm_address }" required />
                                                <InputError :message="form.errors.agency_firm_address" />
                                            </BCol>
                                       
                                            <BCol lg="6" class="mt-2">
                                                <InputLabel value="Designation/Position*" />
                                                <TextInput v-model="form.designation" type="text" class="form-control" placeholder="Enter Designation/Postion" 
                                                :class="{ 'is-invalid': form.errors.designation }" required/>
                                                 <InputError :message="form.errors.designation" />
                                            </BCol>

                                            <BCol lg="6" class="mt-2">
                                                <InputLabel value="Contact Number*" />
                                                <TextInput v-model="form.contact_number" type="text" class="form-control" placeholder="+63"  
                                                :class="{ 'is-invalid': form.errors.contact_number }" required/>
                                                <InputError :message="form.errors.contact_number" />
                                            </BCol>

                                            <BCol lg="6" class="mt-2">
                                                <InputLabel value="Sex*" />
                                                <Multiselect 
                                                    :options="['Male', 'Female', 'Prefer not to say']" 
                                                    v-model="form.sex"
                                                    :searchable="true"
                                                    placeholder="Select Sex"
                                                    :class="{ 'is-invalid': form.errors.sex }" required/>
                                                <InputError :message="form.errors.sex" />
                                            </BCol>

                                            <BCol lg="6" class="mt-2 mb-3">
                                                <InputLabel value="Birthday*" />
                                                <TextInput type="date" v-model="form.birthday" class="form-control"  
                                                 :class="{ 'is-invalid': form.errors.birthday }"  required  />
                                                <InputError :message="form.errors.birthday" />
                                            </BCol>
                                           <BCol lg="12" class="mt-2 mb-5 text-center">
                                            <InputLabel value="Check if Applicable" /> 
                                            <br>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <b-form-checkbox
                                                    v-model="form.is_4ps"
                                                    name="is_4ps"
                                                    class="mx-2"
                                                >
                                                    4PS
                                                </b-form-checkbox>

                                                <b-form-checkbox
                                                    v-model="form.is_pwd"
                                                    name="is_pwd"
                                                    class="mx-2"
                                                >
                                                    PWD
                                                </b-form-checkbox>

                                                <b-form-checkbox
                                                    v-model="form.is_ip"
                                                    name="is_ip"
                                                    class="mx-2"
                                                >
                                                    IP
                                                </b-form-checkbox>
                                            </div>
                                        </BCol>

                                        <BCol lg="12" class="text-center ">
                                            <div class="mt-1">
                                                <BButton variant="primary" class="w-100 header-bg" type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="submit" style="margin-top:-50px">Register</BButton>
                                            </div>
                                        </BCol>
                                            
                                        </BRow>
                                    </form>
                                </div>
                            </BCardBody>
                        </BCard>
                    </BCol>

                </BRow>
            </BContainer>
        </div>
    </div>

   <b-modal v-model="showModal"  modal-class="zoomIn"  class="v-modal-custom" centered no-close-on-backdrop>
            <div class="text-center px-5 pt-2">
                <div class="mt-2">

                    <div class=" mb-1" >
                        <i class="ri-error-warning-fill text-warning" style="font-size: 80px;"></i>
                        <div class=" text-warning fs-2" style="margin-top:-30px ;">
                            Disclaimer
                        </div>
                    </div>
                    <div class="mb-1 mt-3 fs-5 ">
                        The DOST is committed to protect and respect your personal data privacy. 
                        All information collected will only be used for documentation purposes only and 
                        will not be published in any platform.
                    </div>
                </div>
            </div>
              <template v-slot:footer>
                <div class="d-flex justify-content-center w-100 mb-4">
                    <b-button @click="hide" variant="primary">
                    Understood
                    </b-button>
                </div>
            </template>


    </b-modal>

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
    data() {
        return {
             form: useForm({
                attendee_type: null,
                event_session: null,
                firstname:null,
                middlename : null,
                lastname : null,
                suffix: null,
                email: null,
                agency_firm_address: null,
                designation: null,
                contact_number: null,
                sex: null,
                age: null,
                is_4ps: false,
                is_pwd: false,
                is_ip: false,
                signature: null,
            }),
            showModal: false,
            event_sessions: {},
        }
    },

    mounted(){
        this.showModal = true;
    },

    methods: {

        getError(field) {
            return this.form.errors[field] ? this.form.errors[field][0] : '';
        },

        submit(){ 
            this.loading = true;
            this.form.post('/attendance/register', {
                onSuccess: () => {
                    this.loading = false;
                    this.form.reset();   
                    this.$refs.signaturePad.clearSignature() 
                },
                onFinish: () => {
                    this.loading = false;
                    this.$refs.flash_modal.show();
                    this.formSubmitted = true;

                }
            });
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
<style>
.auth-page-wrapper {
    background-color: hsl(201, 80%, 82%);
}

canvas {
  border: 1px solid #ccc;
}

</style>
