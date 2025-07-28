<template>
    <div class="auth-page-wrapper d-flex flex-column">
        <div class="auth-page-content d-flex justify-content-center align-items-center" style="background-color: #EFF0F3; min-height: 100vh; overflow: hidden;">

            <div class="row justify-content-center align-items-center">
                <div class="col-lg-12">
                    <div class="text-center mb-4">
                        <!-- <div class="row mb-2">
                            <div class="col-2">
                                <img src="@assets/images/logo-sm.png" alt="" class="avatar-sm">
                            </div>
                            <div class="col-10">
                                <div class="text-primary mt-1">
                                    <h4 class="fs-16 fw-semibold">DOSTIX - RSTW</h4>
                                    <p class="mt-n2">Information Management System</p>
                                </div>
                            </div>
                        </div> -->
                          
                        <img src="@assets/images/logo-sm.png" alt="" class="avatar-xs mb-1">
                        <h1 class="mb-0 ff-secondary fw-semibold text-capitalize lh-base fs-20"><span class="text-primary">{{ session.title }}</span></h1>
                        <h1 class="mb-0 ff-secondary fw-semibold text-capitalize lh-base fs-14"><span class="text-warning">{{ session.event.name }}</span></h1>
                        <p class="text-muted mb-2 fs-12">{{ session.detail.description }}</p>
                    </div>
                </div>
                <div class="col-lg-6 mt-0">
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
                                    <h5 class="mb-0 fs-14"><span class="text-body">Registration Form</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-12">Please review the participant details and event information carefully before completing the registration process.</p>
                                </div>
                                <!-- <div class="flex-shrink-0" style="width: 15%;"></div> -->
                            </div>
                        </div>
                        <div class="card-body bg-white rounded-bottom">
                            <div class="vstack gap-2 justify-content-center">
                                <form class="customform mt-3 mb-0">
                                    <BRow class="g-3 p-3"> 
                                        <BCol lg="12" class="mt-n3">
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
                                        <BCol lg="12" class="mt-n2"><hr class="text-muted"/></BCol>
                                        <BCol lg="6" class="mt-n1">
                                            <InputLabel for="name" value="Email Address" :message="form.errors.email"/>
                                            <TextInput id="name" v-model="form.email" type="text" class="form-control" placeholder="Please enter email" @input="handleInput('email')" style="text-transform: lowercase;" :light="true"/>
                                        </BCol>
                                        <BCol lg="6" class="mt-n1">
                                            <InputLabel for="name" value="Contact no." :message="form.errors.contact_no"/>
                                            <TextInput id="name" v-model="form.contact_no" type="text" class="form-control" placeholder="Please enter contact no." @input="handleInput('contact_no')" :light="true"/>
                                        </BCol>
                                        <BCol lg="6" class="mt-0">
                                            <InputLabel for="name" value="Birth Date" :message="form.errors.birthdate"/>
                                            <TextInput id="name" v-model="form.birthdate" type="date" class="form-control" placeholder="Please enter birthdate" @input="handleInput('birthdate')" :light="true"/>
                                        </BCol>
                                        <BCol lg="6" class="mt-0">
                                            <InputLabel for="region" value="Sex" :message="form.errors.sex_id"/>
                                            <Multiselect :options="dropdowns.sexs" label="name" v-model="form.sex_id" :message="form.errors.sex_id" placeholder="Select Sex" @input="handleInput('sex_id')"/>
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
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-n2">
                        <button class="btn btn-light flex-fill btn-lg fs-13" type="button">Login</button>
                        <button @click="submit()" class="btn btn-primary flex-fill btn-lg fs-13" type="button">Sign Up</button>
                    </div> 
                </div>
            </div>
        </div>
        <b-button variant="danger" @click="topFunction" class="btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </b-button>
    </div>
    <b-modal v-model="tos" hide-footer size="lg" class="v-modal-custom" modal-class="zoomIn" body-class="p-0" centered hide-header-close style="z-index: 5000;">
        <div class="text-end me-4">
            <button type="button" class="btn-close text-end" @click="tos = false"></button>
        </div>
        <div class="px-5 pt-0 mb-5 fs-12">
            <h5 class="mb-4">Terms of Service</h5>
            <span class="fs-12">I hereby give my consent for the collection, processing, and storage of my personal data in accordance with the provisions of the Data Privacy Act of the Philippines (Republic Act No. 10173) and its implementing rules and regulations.
            I understand that my personal data may include but is not limited to my name, contact information, identification documents, and any other information that may be considered personal under the law.
            I authorize DOST-IX to collect, use, and disclose my personal data for the following purposes:</span>
            <br /><br />
            1. Communication<br />
            2. Account Management<br />
            3. Legal Compliance<br />
            4. Security <br /><br />
            I understand that my personal data will be used solely for the stated purposes and will not be shared with any third parties without my explicit consent, except as required by law.<br /><br />

            By checking the box below or providing my electronic consent, I acknowledge that I have read and understood this consent statement and agree to the processing of my personal data as described herein.
        </div>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    layout: null,
    props: ['session','dropdowns'],
    components: {Multiselect, InputLabel, TextInput},
    data(){
        return {
            form: useForm({
                firstname: null,
                lastname: null,
                middlename: null,
                suffix: null,
                contact_no: null,
                email: null,
                type_id: 16,
                sex_id: null,
                designation: null,
                affiliation: null,
                birthdate: null,
                sessions: [this.session.id],
                check: false,
            }),
            tos: false,
            agree: false
        }
    },
    methods: { 
        submit(){
            this.form.post('/registration',{
                preserveScroll: true,
                onSuccess: (response) => {
                    // this.form.clearErrors();
                    // this.form.reset();
                    // this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        }
    }
}
</script>