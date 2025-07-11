<template>
     <!-- style="--vz-modal-width: 750px;" -->
    <b-modal v-model="showModal" style="--vz-modal-width: 600px;" header-class="p-3 bg-light" title="Create Payroll Cycle" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow>
                <BCol lg="12" class="mt-1">
                    <InputLabel for="name" value="Type" :message="form.errors.payroll_id"/>
                    <Multiselect :options="payrolls" :searchable="true" label="name" v-model="form.payroll_id" placeholder="Select Payroll type" @input="handleInput('payroll_id')"/>
                </BCol>
                <BCol lg="6" class="mt-1">
                    <InputLabel for="name" value="Month" :message="form.errors.month"/>
                    <Multiselect :options="months" :searchable="true" label="name" v-model="form.month" placeholder="Select Semester" @input="handleInput('month')"/>
                </BCol>
                <BCol lg="6" class="mt-1 mb-3">
                    <InputLabel for="name" value="Year"  :message="form.errors.year"/>
                    <TextInput id="name" v-model="form.year" type="text" class="form-control" placeholder="Please enter year" @input="handleInput('year')" :light="true"/>
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-n1 mb-n4"/></BCol>
                <BCol lg="12" style="margin-top: 13px; margin-bottom: 10px;">
                    <div class="d-flex position-relative">
                        <div class="flex-shrink-0 fs-12" :class="(form.errors.is_regular) ? 'text-danger' : ''">
                            Is payroll cycle for regular employees?
                        </div>
                        <div class="flex-grow-1 ms-2"></div>
                        <div class="flex-shrink-0">
                            <div class="d-inline-block" v-for="(list,index) in types"  v-bind:key="index">
                                <div class="custom-control custom-radio mb-3 ms-4">
                                    <input type="radio" id="customRadio1" class="custom-control-input me-2" @input="handleInput('is_regular')" :value="list.value" v-model="form.is_regular">
                                    <label class="custom-control-label fs-12 fw-normal" for="customRadio1">{{list.name}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-n2 mb-n4"/></BCol>
                <BCol lg="6" class="mt-1">
                    <InputLabel for="name" value="Start"  :message="form.errors.start"/>
                    <TextInput id="name" v-model="form.start" type="date" class="form-control" placeholder="Please enter start date" @input="handleInput('start')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-1">
                    <InputLabel for="name" value="End"  :message="form.errors.end"/>
                    <TextInput id="name" v-model="form.end" type="date" class="form-control" placeholder="Please enter end date" @input="handleInput('end')" :light="true"/>
                </BCol>
                <BCol lg="12" v-if="form.is_regular === 0" class="mt-1">
                    <InputLabel for="name" value="Type" :message="form.errors.type"/>
                    <Multiselect :options="options" :searchable="true" label="name" v-model="form.type" placeholder="Select Type" @input="handleInput('type')"/>
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
    components: { Multiselect, InputLabel, TextInput },
    props: ['payrolls'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                month: null,
                year: new Date().getFullYear(),
                is_regular: null,
                payroll_id: null,
                start: null,
                end: null,
                type: null,
                option: 'cycle'
            }),
            months: ['January','February','March','April','May','June','July','August','September','October','November','December']
            .map((name, index) => ({
                value: index + 1,
                name: name
            })),
            types: [ {'value': 1,'name': 'Yes'},{'value': 0,'name': 'No'}],
            options: [ {'value': '1st','name': '1st Quincena'},{'value': '2nd','name': '2nd Quincena'}],
            showModal: false
        }
    },
    
    watch: {
        'form.month': {
            handler: 'updateDates',
            immediate: false
        },
        'form.year': {
            handler: 'updateDates',
            immediate: false
        },
        'form.is_regular': {
            handler: 'updateDates',
            immediate: false
        },
        "form.start"(){
            this.form.errors.start = null;
        },
        "form.end"(){
            this.form.errors.end = null;
        }
    },
    methods: {
        show(data){
            this.selected = data;
            this.showModal = true;
        },
        submit(){
            this.form.post('/payrolls',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('success',true);
                    this.form.clearErrors();
                    this.form.reset();
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.showModal = false;
            this.form.reset();
        },
       updateDates() {
            if (this.form.is_regular === 1) {
                this.form.type = null;

                if (this.form.month !== null && this.form.year !== null) {
                    const year = this.form.year;
                    const monthIndex = this.form.month - 1;

                    const startDate = new Date(Date.UTC(year, monthIndex, 1));
                    this.form.start = startDate.toISOString().split('T')[0];

                    const endDate = new Date(Date.UTC(year, monthIndex + 1, 0));
                    this.form.end = endDate.toISOString().split('T')[0];
                } else {
                    this.form.start = null;
                    this.form.end = null;
                }
            } else if (this.form.is_regular === 0) {
                this.form.start = null;
                this.form.end = null;
            } else {
                this.form.start = null;
                this.form.end = null;
                this.form.type = null;
            }
        }
    },


}
</script>