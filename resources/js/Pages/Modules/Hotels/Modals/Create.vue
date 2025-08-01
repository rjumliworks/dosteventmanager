<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 750px;" header-class="p-3 bg-light" :title="(!editable) ? 'Create Hotel' : 'Edit Hotel'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3">
        
                <BCol lg="12" class="mt-3">
                    <InputLabel for="due" value="Name" :message="form.errors.name"/>
                    <TextInput v-model="form.name" type="text" class="form-control" placeholder="Please enter event name" @input="handleInput('name')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-0">
                    <InputLabel for="due" value="Email" :message="form.errors.description"/>
                    <TextInput v-model="form.email" type="text" class="form-control" placeholder="Please enter email" @input="handleInput('email')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-0">
                    <InputLabel for="due" value="Contact no." :message="form.errors.year"/>
                    <TextInput v-model="form.contact_no" type="text" class="form-control" placeholder="Please enter contact" @input="handleInput('contact_no')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-0">
                    <InputLabel for="due" value="Link" :message="form.errors.start"/>
                    <TextInput v-model="form.link" type="text" class="form-control" placeholder="Please enter link" @input="handleInput('link')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-0">
                    <div class="d-flex">
                        <div style="width: 100%;">
                            <InputLabel value="Address" :message="form.errors.address"/>
                            <TextInput readonly v-model="address" type="text" class="form-control" placeholder="Please enter address" @input="handleInput('address')" :light="true" />
                        </div>
                        <div class="flex-shrink-0">
                            <b-button @click="addLocation(index)" style="margin-top: 20px;" variant="light" class="waves-effect waves-light ms-1"><i class="ri-map-pin-fill"></i></b-button>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12" class="mt-0">
                    <hr class="text-muted"/>
                </BCol>
                <BCol lg="12" class="mt-n1">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-semibold">Rates</span>
                        <div class="d-flex gap-0">
                            <b-button size="sm" variant="light" @click="addRate"><i class="ri-add-line"></i> Add Rate</b-button>
                        </div>
                    </div>
                    <BCol lg="12" class="mt-n1 mb-n2"><hr class="text-muted"/></BCol>

                    <div v-for="(item, index) in form.rates" :key="index" class="mb-2">
                        <div class="row g-3">
                            <div class="col-md-4">
                                 <TextInput v-model="item.name" type="text" class="form-control" placeholder="Name" :light="true"/>
                            </div>
                            <div class="col-md-4">
                                <TextInput v-model="item.detail" type="text" class="form-control" placeholder="Detail" :light="true"/>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex gap-0">
                                    <Amount @amount="val => updateAmount(index, val)" ref="testing" :readonly="false"/>
                                    <b-button variant="danger" @click="removeRate(index)" class="ms-2" :disabled="form.rates.length === 1"><i class="ri-delete-bin-fill"></i></b-button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </BCol>
            </BRow>
        </form>
           
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
    <Location :regions="dropdowns.regions" @submit="handleSubmit" ref="location"/>
</template>
<script>
import _ from 'lodash';
import Location from './Location.vue';
import { useForm } from '@inertiajs/vue3';
import Amount from '@/Shared/Components/Forms/Amount.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput, Location, Amount },
    props: ['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                name: null,
                email: null,
                contact_no: null,
                link: null,
                address: null,
                region_code: null,
                province_code: null,
                municipality_code: null,
                barangay_code: null,
                latitude: null,
                longitude: null,
                is_active: true,
                rates: [],
                option: 'hotel'
            }),
            address: null,
            showModal: false,
            editable: false
        }
    },
    methods: { 
        show(){
            this.form.reset();
            this.showModal = true;
        },
        updateAmount(index, val) {
            this.form.rates[index].rate = val;
        },
        submit(){
            this.form.post('/hotels',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('success',true);
                    this.hide();
                },
            });
        },
        addLocation(){
            this.$refs.location.openEdit();
        },
        handleSubmit(data) {
            this.address = data.address;
            const index = data.index;

            if (index !== undefined) {
                this.form.venue = data.form.venue;
                this.form.address = data.form.info;
                this.form.region_code = data.form.region;
                this.form.province_code = data.form.province.value;
                this.form.municipality_code = data.form.municipality.value;
                this.form.barangay_code = data.form.barangay.value;
                this.form.latitude = data.form.latitude;
                this.form.longitude = data.form.longitude;
            }
        },
        addRate() {
            this.form.rates.push({
                name: null,
                detail: null,
                rate: null
            });
        },
        removeRate(index) {
            if (this.form.rates.length > 1) {
                this.form.rates.splice(index, 1);
            }
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.reset();
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>