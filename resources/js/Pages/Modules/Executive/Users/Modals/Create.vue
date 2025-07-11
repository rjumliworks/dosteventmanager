<template>
    <b-modal v-model="showModal" size="lg" header-class="p-3 bg-light" :title="(!editable) ? 'Create User' : 'Edit User'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow>
                <BCol lg="12">
                    <div>
                        <h6 class="mb-1">General Information</h6>
                        <p class="text-muted fs-11 mt-n1">Please ensure the user's profile information is accurate and valid. </p>
                    </div>
                    <div>
                        <BRow class="g-3">
                            <BCol lg="12"><hr class="text-muted mt-n1 mb-n4"/></BCol>
                            <BCol lg="4" class="mt-1">
                                <InputLabel for="firstname" value="Firstname" :message="form.errors.firstname"/>
                                <TextInput id="firstname" v-model="form.firstname" type="text" class="form-control" placeholder="Please enter firstname" @input="handleInput('firstname')" :light="true" />
                            </BCol>
                            <BCol lg="4" class="mt-1">
                                <InputLabel for="middlename" value="Middlename" :message="form.errors.middlename"/>
                                <TextInput id="middlename" v-model="form.middlename" type="text" class="form-control" placeholder="Please enter middlename" @input="handleInput('middlename')" :light="true"/>
                            </BCol>
                             <BCol lg="4" class="mt-1">
                                <InputLabel for="lastname" value="Lastname" :message="form.errors.lastname"/>
                                <TextInput id="lastname" v-model="form.lastname" type="text" class="form-control" placeholder="Please enter lastname" @input="handleInput('lastname')" :light="true"/>
                            </BCol>
                            <BCol lg="4" class="mt-1">
                                <InputLabel for="email" value="Email" :message="form.errors.email"/>
                                <TextInput id="email" v-model="form.email" type="email" class="form-control" placeholder="Please enter email" @input="handleInput('email')" :light="true"/>
                            </BCol>
                            <BCol lg="4" class="mt-1">
                                <InputLabel for="username" value="Username" :message="form.errors.username"/>
                                <TextInput id="username" v-model="form.username" type="text" class="form-control" placeholder="Please enter username" @input="handleInput('username')" :light="true"/>
                            </BCol>
                            
                            <BCol lg="4" class="mt-1">
                                <InputLabel for="mobile" value="Mobile" :message="form.errors.mobile"/>
                                <TextInput id="mobile" v-model="form.mobile" type="text" class="form-control" placeholder="Please enter mobile" @input="handleInput('mobile')" :light="true"/>
                            </BCol>
                            <BCol lg="12"><hr class="text-muted mt-0 mb-1"/></BCol>
                            <BCol lg="6"  style="margin-top: 13px; margin-bottom: -12px;">
                               <div class="row">
                                    <div class="col-md-4">
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="customRadio1" class="custom-control-input me-2" value="Male" v-model="form.gender">
                                            <label class="custom-control-label fw-normal fs-12" for="customRadio1">Male</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="customRadio2" class="custom-control-input me-2" value="Female" v-model="form.gender">
                                            <label class="custom-control-label fw-normal fs-12" for="customRadio2">Female</label>
                                        </div>
                                    </div>
                                </div>
                            </BCol>
                            <BCol lg="12"><hr class="text-muted mt-n1 mb-n3"/></BCol>
                            <BCol lg="12" class="mt-0">
                                <InputLabel for="username" value="Laboratory" />
                                <Multiselect :options="dropdowns.laboratories" label="name" v-model="form.laboratory_id" :message="form.errors.laboratory_id" placeholder="Select Laboratory" ref="multiselect1"/>
                            </BCol>
                            <BCol :lg="(has_lab) ? 6 : 12" class="mt-1">
                                <InputLabel for="role" value="Role" />
                                <Multiselect :options="dropdowns.roles" v-model="form.role" label="name" object :message="form.errors.role_id" placeholder="Select Role" ref="multiselect2"/>
                            </BCol>
                            <BCol lg="6" v-if="has_lab" class="mt-1">
                                <InputLabel for="laboratory_type" value="Laboratory type" />
                                <Multiselect :options="dropdowns.types" label="name" v-model="form.laboratory_type" :message="form.errors.laboratory_type" placeholder="Select Laboratory type" ref="multiselect3"/>
                            </BCol>
                        </BRow>
                    </div>    
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
    components: {InputLabel, TextInput, Multiselect },
    props: ['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                firstname: null,
                lastname: null,
                middlename: null,
                username: null,
                email: null,
                mobile: null,
                gender: null,
                profile_id: null,
                laboratory_id: null,
                laboratory_type: null,
                role_id: null,
                role: null,
                option: 'user'
            }),
            has_lab: false,
            showModal: false,
            editable: false
        }
    },
    watch: {
        "form.role"(newVal){
            if(newVal){
                if(newVal.has_lab){
                    this.has_lab = 1
                }else{
                    this.has_lab = 0
                }
                this.form.role_id = newVal.value;
            }else{
                this.has_lab = 0;
                this.form.role_id = null;
            }
        }
    },
    methods: { 
        show(){
            this.showModal = true;
        },
        edit(data){
            console.log(data);
            this.form.id = data.id;
            this.form.email = data.email;
            this.form.firstname = data.firstname;
            this.form.middlename = data.middlename;
            this.form.lastname = data.lastname;
            this.form.username = data.username;
            this.form.mobile = data.mobile;
            this.form.gender = data.gender;
            this.form.profile_id = data.profile_id;
            this.form.laboratory_id = data.assigned_laboratory_id,
            this.form.laboratory_type = data.assigned_type_id,
            this.form.role = {
                value: data.assigned_role_id.id,
                name: data.assigned_role_id.name,
                has_lab: data.assigned_role_id.has_lab
            };
            this.editable = true;
            this.showModal = true;
        },
        submit(){
            if(this.editable){
                this.form.put('/executive/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        // this.$emit('update',this.$page.props.flash.data.data);
                        this.form.reset();
                        this.hide();
                    }
                });
            }else{
                this.form.post('/executive',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('update',true);
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
            this.$refs.multiselect1.clear();
            this.$refs.multiselect2.clear();
            (this.has_lab) ? this.$refs.multiselect3.clear() : '';
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>