<template>
    <Head title="Log in"/>
     <div>
        <div class="modal-body login-modal p-5">
            <h5 class="text-white fs-18 mb-1 mt-n4">Registration Form</h5>
            <p class="text-white-50 fs-12 mb-4">Please fill out the form carefully to ensure all information is accurate.</p>
            <div class="vstack gap-2 justify-content-center">
               <form class="customform mb-n5" style="color: white;">
                    <BRow class="g-3 mb-3"> 
                        <BCol lg="12" class="mt-n2 mb-0">
                            <hr class="text-muted"/>
                        </BCol>
                        <BCol lg="12" class="mt-0">
                            <InputLabel for="name" value="Full Name" :message="form.errors.fullname"/>
                            <b-row class="g-3 mb-2 mt-n3">
                                <b-col lg>
                                    <div class="input-group mb-0">
                                        <input type="text" v-model="form.firstname" placeholder="First name" class="form-control" style="width: 28%; min-height: 38.4px !important; background-color: #f5f6f7; text-transform: uppercase;">
                                        <input type="text" v-model="form.middlename" placeholder="Middle name" class="form-control" style="width: 28%; min-height: 38.4px !important; background-color: #f5f6f7; text-transform: uppercase;">
                                        <input type="text" v-model="form.lastname" placeholder="Last name" class="form-control" style="width: 28%; min-height: 38.4px !important; background-color: #f5f6f7; text-transform: uppercase;">
                                        <input type="text" v-model="form.suffix" placeholder="Suffix" class="form-control" style="width: 16%; min-height: 38.4px !important; background-color: #f5f6f7; text-transform: uppercase;">
                                    </div>
                                </b-col>
                            </b-row>
                        </BCol>
                    </BRow>
               </form>
            </div>
        </div>
       
        <div class="modal-body p-5">
            <form class="customform">
                <BRow class="g-3" style="margin-top: -35px;"> 
                    
                   <BCol lg="6" class="mt-1">
                        <InputLabel for="name" value="Email Address" :message="form.errors.email"/>
                        <TextInput id="name" v-model="form.email" type="text" class="form-control" placeholder="Please enter email" @input="handleInput('email')" style="text-transform: lowercase;" :light="true"/>
                    </BCol>
                    <BCol lg="6" class="mt-1">
                        <InputLabel for="name" value="Contact no." :message="form.errors.contact_no"/>
                        <TextInput id="name" v-model="form.contact_no" type="text" class="form-control" placeholder="Please enter contact no." @input="handleInput('contact_no')" :light="true"/>
                    </BCol>
                    <BCol lg="6" class="mt-0">
                        <InputLabel for="name" value="Birth Date" :message="form.errors.birthdate"/>
                        <TextInput id="name" v-model="form.birthdate" type="date" class="form-control" placeholder="Please enter birthdate" @input="handleInput('birthdate')" :light="true"/>
                    </BCol>
                    <BCol lg="6" class="mt-0">
                        <InputLabel for="region" value="Sex" :message="form.errors.sex_id"/>
                        <Multiselect :options="dropdowns.sexs" label="name" v-model="form.sex_id" placeholder="Select Sex" @input="handleInput('sex_id')"/>
                    </BCol>
                    <BCol lg="6" class="mt-1">
                        <InputLabel for="name" value="Designation" :message="form.errors.designation"/>
                        <TextInput id="name" v-model="form.designation" type="text" class="form-control" placeholder="Please enter designation" @input="handleInput('designation')" style="text-transform: uppercase;" :light="true"/>
                    </BCol>
                    <BCol lg="6" class="mt-1">
                        <InputLabel for="name" value="Affiliation" :message="form.errors.affiliation"/>
                        <TextInput id="name" v-model="form.affiliation" type="text" class="form-control" placeholder="Please enter affiliation" @input="handleInput('affiliation')" style="text-transform: uppercase;" :light="true"/>
                    </BCol>
                    <BCol lg="12" class="mt-0"><hr class="text-muted"/></BCol>
                    <BCol lg="12">
                        <div class="mt-n3 form-check">
                            <input type="checkbox" v-model="form.check" class="form-check-input" id="checkTerms">
                            <label class="form-check-label" for="checkTerms"><i>I agree to the</i> <span class="fw-semibold text-primary" @click="tos = true">Terms of Service</span> <i>and Privacy Policy</i></label>
                        </div>
                    </BCol>
                    
                </BRow>
                <div class="text-end mt-2">
                    <!-- <button @click="submit('ok')" class="btn btn-primary btn-md" type="button" :disabled="!form.check">
                        <div class="btn-content">Submit Now</div>
                    </button> -->
                    <BButton variant="primary" class="w-100 mt-2" type="submit" :disabled="form.processing" @click="submit">Register</BButton>
                </div>
            </form>
        </div>
    </div>

     <BModal v-model="showModal" style="--vz-modal-width: 800px;" hide-footer body-class="p-0" header-class="p-0"
        class="v-modal-custom" content-class="border-0 overflow-hidden" centered hide-header-close>
        <div class="modal-body login-modal p-5">
          
            <div class="vstack gap-2 justify-content-center">
               <form class="customform mb-n5" style="color: white;">
                    <BRow class="g-3 mb-3"> 
                     
                        <BCol lg="12" class="mt-0">
                            <div class="row justify-content-center " >
                                <img src="@assets/images/event/event_title.png" alt="" class="img-fluid" >
                            </div>
                        </BCol>
                    </BRow>
               </form>
            </div>
        </div>
       
        <div class="modal-body p-4 mt-n2 mb-2">
            <form class="customform">
                <BRow class="g-3">
                <BCol lg="12" class="text-center">
                    <div class="mb-3">
                        <i class="ri-error-warning-fill text-warning" style="font-size: 40px;"></i>
                        <div class=" text-warning fs-9" style="margin-top: -5px ;"> Disclaimer </div>
                    </div>

                    <p class="text-muted fs-6">
                        The Department of Science and Technology (DOST) is committed to protecting and 
                        respecting your personal data privacy. All information collected will be used 
                        solely for documentation purposes and will not be published on any platform.
                    </p>
                </BCol>

                <BCol lg="12" class="text-center mt-2">
                    <b-button @click="hide" variant="primary" class="px-4">
                    I Understand
                    </b-button>
                </BCol>
                </BRow>
            </form>
        </div>

    </BModal>

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
                contact_no: null,
                affiliation: null,
                designation: null,
                sex_id: null,
                birthdate: null,
                is_4ps: false,
                is_pwd: false,
                is_ip: false,
                type_id: 16,
                signature: null,
            }),
            showModal: false
        }
    },
    mounted(){
        this.showModal = true;
    },
    methods: {
        submit(){
            this.form.post('/',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.form.clearErrors();
                    this.form.reset();
                },
                
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.showModal = false;
        },
    }
}
</script>
<style scoped>
.auth-page-wrapper {
    background-color: hsl(201, 80%, 82%);
}
</style>
