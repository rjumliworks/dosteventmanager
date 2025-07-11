    
<template>
    <BModal v-model="showModal" style="--vz-modal-width: 1000px;" hide-footer body-class="p-0" header-class="p-0"
        class="v-modal-custom" content-class="border-0" centered hide-header-close>
        <div class="modal-body login-modal p-5">
            <h5 class="text-white fs-18 mb-1 mt-n4">Document Form</h5>
            <p class="text-white-50 fs-12 mb-4">Please fill out the form carefully to ensure all information is accurate.</p>
            <div class="vstack gap-2 justify-content-center">
               <form class="customform mb-n5">
                    <BRow class="g-3 mb-4"> 
                        <BCol lg="12" class="mt-n2 mb-0">
                            <hr class="text-muted"/>
                        </BCol>
                        
                        <BCol lg="12" class="mt-0">
                            <InputLabel for="name" value="Subject" :color="'white'" :message="form.errors.subject"/>
                            <TextInput id="name" v-model="form.subject" type="text" class="form-control" placeholder="Please enter subject" @input="handleInput('subject')" :light="true"/>
                        </BCol>
                       
                        <BCol lg="4" class="mt-0">
                            <InputLabel for="name" value="Document Type" :color="'white'" :message="form.errors.type_id"/>
                            <Multiselect :options="dropdowns.types" :searchable="true" label="name" v-model="form.type_id" placeholder="Select type" @input="handleInput('type_id')"/>
                        </BCol>
                        
                        <BCol lg="4" class="mt-0">
                            <InputLabel for="name" value="Document Date" :color="'white'" :message="form.errors.documented_at"/>
                            <TextInput id="name" v-model="form.documented_at" type="date" class="form-control" placeholder="Please enter date" @input="handleInput('documented_at')" :light="true"/>
                        </BCol>

                        <BCol lg="4" class="mt-0">
                            <InputLabel for="name" value="Received Date" :color="'white'" :message="form.errors.received_at"/>
                            <TextInput id="name" v-model="form.received_at" type="date" class="form-control" placeholder="Please enter date" @input="handleInput('received_at')" :light="true"/>
                        </BCol>

                        <!-- <BCol lg="4" class="mt-0">
                            <InputLabel for="name" value="Subject" :color="'white'" :message="form.errors.subject"/>
                            <TextInput id="name" v-model="form.subject" type="text" class="form-control" placeholder="Please enter subject" @input="handleInput('subject')" :light="true"/>
                        </BCol> -->
                    </BRow>
               </form>
            </div>
        </div>
        
        <div class="modal-body p-5">
            <form class="customform">
                
                <BRow class="g-3" style="margin-top: -30px;"> 
                    <BCol lg="6" class="mt-0">
                        <InputLabel for="name" value="Sender" :message="form.errors.sender_id"/>
                        <Multiselect :options="[]" :searchable="true" label="name" v-model="form.sender_id" placeholder="Select Sender" @input="handleInput('sender_id')"/>
                    </BCol>
                    <BCol lg="6" class="mt-0">
                        <InputLabel for="name" value="Company" :message="form.errors.company_id"/>
                        <Multiselect :options="[]" :searchable="true" label="name" v-model="form.company_id" placeholder="Select Company" @input="handleInput('company_id')"/>
                    </BCol>
                    <BCol lg="12" class="mt-1 mb-4">
                        <InputLabel for="name" value="Keywords" :message="form.errors.keywords"/>
                        <Multiselect :options="[]" :searchable="true" label="name" v-model="form.keywords" placeholder="Type Keywords" @input="handleInput('keywords')"/>
                    </BCol>
                </BRow>
             
                <div class="text-end mt-2">
                    <button @click="submit('ok')" class="btn btn-primary btn-md" type="button" :disabled="!form.check">
                        <div class="btn-content">Submit Now</div>
                    </button>
                </div>
            </form>
        </div>
    </BModal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default { 
    layout: null,
    components: {Multiselect, InputLabel, TextInput },
    props: ['dropdowns'],
    data() {
        return {
            showModal: false,
            form: useForm({
                subject: null,
                remarks: null,
                keywords: null,
                actions: null,
                is_incoming: null,
                is_completed: null,
                sender_id: null,
                company_id: null,
                type_id: null,
                routed_by: null,
                documented_at: null,
                received_at: null,
                option: 'document'
            }),
            units: [],
            filteredPositions: []
        };
    },
    watch: {
        "form.type_id"(newVal){
           
        },
    },
    methods: {
        show(){
            this.showModal = true;
        },
        submit(){
            this.form.post('/documents',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.form.clearErrors();
                    this.form.reset();
                    this.hide();
                },
            });
        },
        fetchUnits(code){
            axios.get('/search',{
                params: {
                    option: 'units',
                    code: code
                }
            })
            .then(response => {
                this.units = response.data;
            })
            .catch(err => console.log(err));
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.showModal = false;
        },
    },
};
</script>