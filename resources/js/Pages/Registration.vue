<template>
    <Head title="Registration Form"/>
    <div class="landing-wrapper d-flex justify-content-center align-items-center">
        <div class="auth-page-content registration_bg ">
            <BContainer >
              
                <BRow class="justify-content-center">
                    <BCol md="8" lg="10" xl="8" class="mt-4">
                        <BCard no-body class="h">
                            <BCardBody class="p-4 ">
                                
                                <div class="row mb-4 justify-content-center " >
                                    <div class="text-primary mt-1 t">
                                        <img src="@assets/images/event/event_title2.png" alt="" class="img-fluid" >
                                    </div>
                                </div>

                                <div class="row mb-2 mt-n1">
                                    <div class="col-12 mt-n3 mb-n2">
                                        <hr class="text-muted"/>
                                    </div>
                                    <div class="col-2 col-sm-1">
                                        <img src="@assets/images/logo-sm.png" alt="" class="avatar-sm">
                                    </div>
                                      <div class="col-10 col-sm-11 mt-1">
                                        <div class="text-primary mt-1">
                                            <h4 class="fs-14 fw-semibold">Registration Form</h4>
                                            <p class="mt-n2 fs-12 text-muted" >Please fill out the form carefully to ensure all information is accurate.</p>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-n3">
                                        <hr class="text-muted"/>
                                    </div>
                                </div>
                                <div v-if="status" class="alert alert-success text-success">
                                    {{ status }}
                                </div>

                                <div class="p-2 mt-n3">
                                    <form class="customform" @submit.prevent="submit">
                                        <BRow>      
                                            <BCol lg="6" class="mt-1">
                                                <InputLabel value="First Name*" :message="form.errors.firstname"/>
                                                <TextInput v-model="form.firstname" type="text" class="form-control" placeholder="Enter Firstname" :class="['form-control', form.errors.firstname ? 'is-invalid' : '']"/>
                                            </BCol>
                                            <BCol lg="6" class="mt-1">
                                                <InputLabel value="Middle Name" :message="form.errors.middlename"/>
                                                <TextInput v-model="form.middlename" type="text" class="form-control" placeholder="Enter Middlename" :class="['form-control', form.errors.middlename ? 'is-invalid' : '']"/>
                                            </BCol>
                                            <BCol lg="6" class="mt-0">
                                                <InputLabel value="Last Name*" :message="form.errors.lastname"/>
                                                <TextInput v-model="form.lastname" type="text" class="form-control" placeholder="Enter Surname" :class="['form-control', form.errors.lastname ? 'is-invalid' : '']"/>
                                            </BCol>
                                            <BCol lg="6" class="mt-0">
                                                <InputLabel value="Suffix" />
                                                <TextInput v-model="form.suffix" type="text" class="form-control" placeholder="e.g Jr." />
                                                
                                            </BCol>
                                             <BCol lg="6" class="mt-1">
                                                <InputLabel value="Email Address*" :message="form.errors.email"/>
                                                <TextInput v-model="form.email" type="email" class="form-control" placeholder="Enter Email Address" :class="['form-control', form.errors.email ? 'is-invalid' : '']"/>
                                            </BCol>
                                            <BCol lg="6" class="mt-1">
                                                <InputLabel value="Contact Number*" :message="form.errors.contact_no"/>
                                                <TextInput v-model="form.contact_no" type="text" class="form-control" placeholder="+63" :class="['form-control', form.errors.contact_no ? 'is-invalid' : '']"/>
                                            </BCol>
                                            <BCol lg="6" class="mt-1">
                                                <InputLabel value="Agency/Firm Address" :message="form.errors.affiliation"/>
                                                <TextInput v-model="form.affiliation" type="text" class="form-control" placeholder="Enter Agency/Firm Address" :class="['form-control', form.errors.affiliation ? 'is-invalid' : '']"/>
                                            </BCol>
                                       
                                            <BCol lg="6" class="mt-1">
                                                <InputLabel value="Designation/Position" :message="form.errors.designation"/>
                                                <TextInput v-model="form.designation" type="text" class="form-control" placeholder="Enter Designation/Postion" :class="['form-control', form.errors.designation ? 'is-invalid' : '']"/>
                                            </BCol>

                                            <BCol lg="6" class="mt-1">
                                                <InputLabel value="Sex*" :message="form.errors.sex_id"/>
                                                <Multiselect :options="dropdowns.sexs"  v-model="form.sex_id" :searchable="true" placeholder="Select Sex"/>
                                            </BCol>

                                            <BCol lg="6" class="mt-1">
                                                <InputLabel value="Birthday*" :message="form.errors.birthdate"/>
                                                <TextInput type="date" v-model="form.birthdate" class="form-control"/>
                                                
                                            </BCol>
                                            <BCol lg="12"><hr class="text-muted"/></BCol>
                                            <BCol lg="12">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 ms-0">
                                                        <p class="fs-11 mb-0 text-muted">Please check if applicable</p>
                                                    </div>
                                                    <div class="flex-shrink-0 text-end">
                                                         <div class="d-flex justify-content-center float-end">
                                                            <b-form-checkbox v-model="form.is_4ps" name="is_4ps" class="mx-2">4PS</b-form-checkbox>
                                                            <b-form-checkbox v-model="form.is_pwd" name="is_pwd" class="mx-2">PWD</b-form-checkbox>
                                                            <b-form-checkbox v-model="form.is_ip" name="is_ip" class="mx-2">IP</b-form-checkbox>
                                                        </div>
                                                    </div>
                                                </div>
                                            </BCol>
                                            <BCol lg="12"><hr class="text-muted mt-2"/></BCol>
                                            <BCol lg="6" class="mt-0 mb-3">
                                                <p class="fs-11 mb-2 text-muted">Please enter your signature</p>
                                                <SignaturePad ref="signaturePad" class="signature-pad" style="border: 1px solid #ddd; width: 100%; height: 140px; border-radius: 10px;"/>
                                            </BCol>
                                            <BCol lg="6" class="mt-0 mb-3">
                                                <p class="fs-11 mb-0 text-muted">Enter the CAPTCHA you see in the image below</p>
                                                <div class="text-center pt-2 ">
                                                    <img  :src="captchaUrl" @click="refreshCaptcha" alt="captcha" style="width: 100%; height: auto; object-fit: contain; cursor: pointer;"/>
                                                </div>
                                                <TextInput type="text" v-model="form.captcha" placeholder="Enter CAPTCHA" class="form-control text-center mb-3 mt-2"/>
                                            </BCol>
                                            <BCol lg="12" class="mt-n4 mb-3"><hr class="text-muted"/></BCol>
                                            <BCol lg="12" class="mb-3 mt-n2">
                                                <b-form-checkbox v-model="is_agree" name="is_agree">
                                                    <a @click="openConsentForm()" class="text-info">Consent Form
                                                        <span class="text-muted">(Please read and check this consent form to proceed)</span>
                                                    </a>
                                                </b-form-checkbox>
                                            </BCol>
                                    
                                            <BCol lg="12" class="text-center mt-4">
                                                <div class="mt-1">
                                                    <BButton :disabled="!is_agree || form.processing" variant="primary" class="w-100 header-bg" type="submit" @click="generateCaptcha" style="margin-top:-50px">Register</BButton>
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
            <div class="mt-n4">

                <div class=" mb-1" >
                    <i class="ri-error-warning-fill text-warning" style="font-size: 50px;"></i>
                    <div class="fw-semibold text-warning fs-14 mt-n2 mb-3" >
                        Disclaimer
                    </div>
                </div>
                <div class="text-muted">
                    The DOST is committed to protect and respect your personal data privacy. 
                    All information collected will only be used for documentation purposes only and 
                    will not be published in any platform.
                </div>
            </div>
        </div>
        <template v-slot:footer>
            <div class="d-flex justify-content-center w-100 mb-4">
                <b-button @click="hideDisclaimer" variant="primary">
                I Understand
                </b-button>
            </div>
        </template>
    </b-modal>

    <b-modal v-model="showNoSignatureModal"  modal-class="zoomIn"  class="v-modal-custom" centered no-close-on-backdrop>
        <div class="text-center px-5 pt-2">
            <div class="mt-2">

                <div class=" mb-1" >
                    <i class="ri-close-line text-danger" style="font-size: 80px;"></i>
                    <div class=" text-danger fs-2" style="margin-top:-30px ;">
                        Error
                    </div>
                </div>
                <div class="mb-1 mt-3 fs-5 ">
                    Please sign first to proceed.
                </div>
            </div>
        </div>
        <template v-slot:footer>
            <div class="d-flex justify-content-center w-100 mb-4">
                <b-button @click="hideNoSignatureModel" variant="primary">
                Okay
                </b-button>
            </div>
        </template>
    </b-modal>

    <b-modal v-model="formSubmitted" hide-footer class="v-modal-custom" modal-class="zoomIn" body-class="p-0" centered hide-header-close style="z-index: 5000;">
        <div class="text-end me-4">
            <button type="button" class="btn-close text-end" @click="check()"></button>
        </div>
        <div class="text-center px-5 pt-2">
            <div class="mt-2">
                    <div class="avatar-md mx-auto">
                    <div class="avatar-title rounded-circle bg-light">
                        <i v-if="$page.props.flash.status" class="ri-checkbox-circle-fill text-success h1 mb-0"></i>
                        <i v-else class="ri-close-circle-fill text-danger h1 mb-0"></i>
                    </div>
                </div>
                <h5 class="mb-1 mt-4 fs-14">{{$page.props.flash.message }}</h5>
                <p v-if="$page.props.flash.info" class="text-muted fs-12">{{$page.props.flash.info }}</p>
            </div>
        </div>
        <div class="modal-footer bg-light p-3 mt-5 justify-content-center">
            <p class="mb-0 text-muted fs-10">Any suggestions please contact
                <b-link href="" target="_blank" class="link-secondary fw-semibold">DOST IX</b-link>
            </p>
        </div>
    </b-modal>

    <b-modal v-model="formConsent" hide-footer class="v-modal-custom" size="lg" modal-class="zoomIn" body-class="p-0" centered hide-header-close style="z-index: 5000;">
        <div class="px-5 pt-2">
  <div>
    <h5 class="mb-1 mt-4 fs-14 text-center mb-3">CONSENT FORM</h5>

    <p class="fs-12 fw-bold">
      I, whose name and signature appear on this platform, hereby expressly agree, consent, and authorize DOST IX to collect and process the following personal information related to me:
    </p>
    <ul class="number-list">
      <li>Name</li>
      <li>Agency/Firm Address</li>
      <li>Designation/Position</li>
      <li>Contact Nos.</li>
      <li>Email Address</li>
      <li>Sex</li>
      <li>Birthday/Age</li>
      <li>4Ps/PWD/IP</li>
      <li>Photos taken during the conduct of meetings/trainings</li>
    </ul>

    <p class="fs-12 fw-bold">
      I agree that the above-mentioned personal information shall be processed for the following purposes:
    </p>
    <ul class="number-list">
      <li>Generation of Directory of Participants</li>
      <li>Issuance of Certificates</li>
      <li>Conduct of Impact Assessments</li>
      <li>Upload of pictures to DOST IX Website and Facebook Page</li>
      <li>Documents for Annual Reports and other publications</li>
      <li>Issuance of Billing Statements</li>
    </ul>

    <p class="fs-12 fw-bold">
      I agree that the above-mentioned personal information shall be processed in the following manner:
    </p>
    <ul class="number-list">
      <li>Storage in a database</li>
      <li>Storage in filing cabinets</li>
      <li>Storage on computer files</li>
    </ul>

    <p class="fs-12 fw-bold">
      I agree that the above-mentioned personal information may be disclosed to the following recipients for the following purposes:
    </p>
    <ul class="number-list">
      <li>Recipient – Authorized DOST IX personnel</li>
      <li>Purpose – For documentation</li>
    </ul>

    <p class="fs-12 fw-bold">
      I agree that the above-mentioned personal information will be retained or stored for as long as the purposes for which they are being processed have not been satisfied.
    </p>

    <p class="fs-12">
      I am aware of my rights under the Data Privacy Act, including the following:
    </p>
    <ul class="number-list">
      <li>The right to access my personal information</li>
      <li>The right to object to the processing of my personal information</li>
      <li>The right to erasure or blocking of my personal information</li>
      <li>The right to be informed of the existence of processing my personal information</li>
      <li>The right to damages</li>
      <li>The right to lodge a complaint before the National Privacy Commission</li>
    </ul>

    <p class="fs-12 fw-bold">
      I understand that in case of complaints, concerns, or questions regarding the processing of my personal information, I may address them to:
    </p>
    <ul class="number-list">
      <li>Data Privacy Officer</li>
      <li>Department of Science and Technology IX</li>
      <li>Pettit Barracks, Zamboanga City, 7000, Philippines</li>
      <li>Tel No. (062) 991-1024 | Email: ord@ro9.dost.gov.ph</li>
    </ul>

    <p class="fs-12">
      This consent and authorization remain valid and subsisting for a limited period consistent with the purpose above or until otherwise revoked or cancelled in writing.
    </p>

    <div class="d-flex justify-content-center w-100 mb-3 mt-5">
      <b-button @click="hide()" variant="primary">I Understand</b-button>
    </div>
  </div>

  <Checkbox />
</div>

    </b-modal>

</template>
<script >
import { useForm } from '@inertiajs/vue3';
import Checkbox from '@/Shared/Components/Forms/Checkbox.vue';
import InputError from '@/Shared/Components/Forms/InputError.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import Multiselect from '@/Shared/Components/Forms/Multiselect.vue';
import SignaturePad from "vue3-signature-pad";


export default {
    layout: null,
    components: {   InputError, InputLabel, TextInput, Multiselect, SignaturePad   },
    props: ['dropdowns'],
    data() {
        return {
             form: useForm({
                type_id: null,
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
                signature: null,
                captcha: null
            }),
            showModal: false,
            formSubmitted : false,
            formConsent : false,
            showNoSignatureModal:false,
            inputed_captcha: null,
            event_sessions: {},
            is_agree: false,
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
    watch: {
        "is_agree"(val){
            if(val){
                 this.formConsent = true;
            }
        },
    },
    methods: {
        clearSignature() {
            this.$refs.signaturePad.clearSignature();
        },
        openConsentForm(){
            this.formConsent = true;
        },
        getError(field) {
            return this.form.errors[field] ? this.form.errors[field][0] : '';
        },
        refreshCaptcha() {
            this.captcha = this.captchaUrl = '/captcha?' + Date.now(); // always flat, always new
            this.form.captcha = null;
        },
        
        async submit() {
            this.loading = true;

            if (!this.$refs.signaturePad || this.$refs.signaturePad.isEmpty()) {
                this.showNoSignatureModal = true;
                this.loading = false;
                this.form.signature = null;
                return;
            }
            const dataUrl = this.$refs.signaturePad.toDataURL("image/png");
            const blob = await fetch(dataUrl).then(res => res.blob());
            this.form.signature = blob;
            this.form.type_id = 16;

            this.form.post('/', {
                onSuccess: () => {
                    this.loading = false;
                    this.form.reset();   
                    this.refreshCaptcha();
                },
                onError: () => {
                    this.loading = false;
                }
            });
        },
        hideDisclaimer(){
            this.showModal = false;
        },
        hideNoSignatureModel(){
            this.showNoSignatureModal = false;
        },
        hide(){
            this.showModal = false;
            this.formConsent  =  false;
            this.is_agree  =  true;
        },
    }
}
</script>
<style scoped>
.auth-page-wrapper {
    background-color: hsl(201, 80%, 82%);
}
canvas {
  border: 1px solid #ccc;
}
.captcha-box img {
  cursor: pointer;
  border: 1px solid #ddd;
  padding: 5px;
  background: #f9f9f9;
  border-radius: 6px;
}
.number-list {
  list-style-type: decimal; /* changes bullets to numbers */
}
</style>
