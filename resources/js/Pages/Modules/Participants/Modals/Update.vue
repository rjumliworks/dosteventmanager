<template>
    <b-modal v-model="showModal" size="lg" header-class="p-3 bg-light" title="Update Participant" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3 mt-2">
                <BCol lg="6" class="mt-1">
                    <InputLabel for="firstname" value="Firstname" :message="form.errors.firstname"/>
                    <TextInput id="firstname" v-model="form.firstname" type="text" class="form-control" placeholder="Please enter firstname" @input="handleInput('firstname')" :light="true" />
                </BCol>
                <BCol lg="6" class="mt-1">
                    <InputLabel for="middlename" value="Middlename" :message="form.errors.middlename"/>
                    <TextInput id="middlename" v-model="form.middlename" type="text" class="form-control" placeholder="Please enter middlename" @input="handleInput('middlename')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-1">
                    <InputLabel for="lastname" value="Lastname" :message="form.errors.lastname"/>
                    <TextInput id="lastname" v-model="form.lastname" type="text" class="form-control" placeholder="Please enter lastname" @input="handleInput('lastname')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-1">
                    <InputLabel for="lastname" value="Suffix" :message="form.errors.lastname"/>
                    <TextInput id="lastname" v-model="form.suffix" type="text" class="form-control" placeholder="Please enter suffix" @input="handleInput('suffix')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-1">
                    <InputLabel for="email" value="Email" :message="form.errors.email"/>
                    <TextInput id="email" v-model="form.email" type="email" class="form-control" placeholder="Please enter email" @input="handleInput('email')" :light="true"/>
                </BCol>
                
                <BCol lg="6" class="mt-1">
                    <InputLabel for="mobile" value="Mobile" :message="form.errors.contact_no"/>
                    <TextInput id="mobile" v-model="form.contact_no" type="text" class="form-control" placeholder="Please enter mobile" @input="handleInput('contact_no')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-1">
                    <InputLabel for="mobile" value="Birthdate" :message="form.errors.contact_no"/>
                    <TextInput id="mobile" v-model="form.birthdate" type="date" class="form-control" placeholder="Please enter mobile" @input="handleInput('birthdate')" :light="true"/>
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-0 mb-1"/></BCol>
                <BCol lg="6"  style="margin-top: 13px; margin-bottom: -12px;">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="customRadio1" class="custom-control-input me-2" value="2" v-model="form.sex_id">
                                <label class="custom-control-label fw-normal fs-12" for="customRadio1">Male</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="customRadio2" class="custom-control-input me-2" value="3" v-model="form.sex_id">
                                <label class="custom-control-label fw-normal fs-12" for="customRadio2">Female</label>
                            </div>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-n1 mb-n3"/></BCol>
                <BCol lg="6" class="mt-1">
                    <InputLabel for="email" value="Affiliation" :message="form.errors.affiliation"/>
                    <TextInput id="email" v-model="form.affiliation" type="email" class="form-control" placeholder="Please enter affiliation" @input="handleInput('affiliation')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-1">
                    <InputLabel for="email" value="Designation" :message="form.errors.designation"/>
                    <TextInput id="email" v-model="form.designation" type="text" class="form-control" placeholder="Please enter designation" @input="handleInput('designation')" :light="true"/>
                </BCol>
                <BCol lg="12" class="mt-0">
                    <InputLabel for="role" value="Type"/>
                    <Multiselect :options="types" v-model="form.type_id" label="name" :message="form.errors.role" placeholder="Select Type" ref="multiselect2"/>
                </BCol>
            </BRow>
        </form>
          <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    props: ['types'],
    components: {InputLabel, TextInput, Multiselect },
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                firstname: null,
                lastname: null,
                middlename: null,
                suffix: null,
                email: null,
                contact_no: null,
                birthdate: null,
                sex_id: null,
                type_id: null,
                designation: null,
                affiliation: null,
                option: 'user'
            }),
            showModal: false,
            editable: false
        }
    },
    methods: { 
        show(){
            this.form.reset();
            this.editable = false;
            this.showModal = true;
        },
        edit(data){
            this.form.id = data.id;
            this.form.firstname = data.firstname;
            this.form.middlename = data.middlename;
            this.form.lastname = data.lastname;
            this.form.email = data.email;
            this.form.contact_no = data.contact_no;
            this.form.suffix = data.suffix;
            this.form.sex_id = data.sex.id;
            this.form.designation = data.designation;
            this.form.affiliation = data.affiliation;
            this.form.type_id = data.type.id;
            this.form.birthdate = data.birthdate;
            this.editable = true;
            this.showModal = true;
        },
        submit(){
            if(this.editable){
                this.form.put('/participants/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('success',this.$page.props.flash.data.data);
                        this.form.reset();
                        this.hide();
                    }
                });
            }else{
                this.form.post('/participants',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.hide();
                    },
                });
            }
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.reset();
            this.form.clearErrors();
            this.$refs.multiselect2.clear();
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>