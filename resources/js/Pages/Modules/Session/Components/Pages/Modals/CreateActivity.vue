<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 800px;" header-class="p-3 bg-light" :title="(!editable) ? 'Create Session' : 'Edit Session'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3">
        
                <BCol lg="12" class="mt-3">
                    <InputLabel for="due" value="Title" :message="form.errors.name"/>
                    <TextInput v-model="form.title" type="text" class="form-control" placeholder="Please enter title" @input="handleInput('title')" :light="true"/>
                </BCol>
                <BCol lg="9" class="mt-0">
                    <InputLabel for="role" value="Venue" />
                    <Multiselect :options="venueOptions" v-model="form.venue_id" label="name" :message="form.errors.venue_id" placeholder="Select Venue" ref="multiselect2"/>
                </BCol>
                <BCol lg="3" class="mt-0">
                    <InputLabel for="due" value="Capacity" :message="form.errors.capacity"/>
                    <TextInput v-model="form.capacity" type="text" class="form-control" placeholder="Please enter capacity" @input="handleInput('capacity')" :light="true"/>
                </BCol>
                <BCol lg="12" class="mt-0">
                    <InputLabel for="due" value="Description" :message="form.errors.description"/>
                    <Textarea v-model="form.description" type="text" class="form-control" placeholder="Please enter description" @input="handleInput('description')" :light="true"/>
                </BCol>
                <BCol lg="12" class="mt-1"><hr class="text-muted"/></BCol>
                <BCol :lg="(dateType) ? '6' : '12'" class="mt-n2">
                    <InputLabel for="name" value="Type" :message="form.errors.dates"/>
                    <Multiselect :options="['Single Day','Range','Multiple Dates (non-continuous)']" :searchable="true" label="name" v-model="dateType" placeholder="Select Date type"/>
                </BCol>
                <template v-if="dateType == 'Single Day'">
                    <BCol lg="3" class="mt-n2">
                        <InputLabel for="name" value="Date"  :message="form.errors.dates"/>
                        <flat-pickr v-model="date" :config="single" placeholder="Select date" class="form-control flatpickr-input" style="min-height: 38.4px !important; border-color: #e9ebec; background-color: #f5f6f7;"></flat-pickr>
                    </BCol>
                    <BCol lg="3" class="mt-n2">
                        <InputLabel for="name" value="Time of Day"  :message="form.errors.date"/>
                        <Multiselect :options="['Whole Day','AM','PM','Custom']" label="name" v-model="form.timeOfDay" placeholder="Type"/>
                    </BCol>
                </template>
                <template v-if="dateType == 'Range'">
                    <BCol lg="6" class="mt-n2">
                        <InputLabel for="name" value="Date"  :message="form.errors.dates"/>
                        <flat-pickr v-model="date" :config="range" placeholder="Select date" class="form-control flatpickr-input" style="min-height: 38.4px !important; border-color: #e9ebec; background-color: #f5f6f7;"></flat-pickr>
                    </BCol>
                </template>
                <template v-if="dateType == 'Multiple Dates (non-continuous)'">
                    <BCol lg="6" class="mt-n2">
                        <InputLabel for="name" value="Date"  :message="form.errors.dates"/>
                        <flat-pickr v-model="date" :config="multiple" placeholder="Select dates" class="form-control flatpickr-input" style="min-height: 38.4px !important; border-color: #e9ebec; background-color: #f5f6f7;"></flat-pickr>
                    </BCol>
                </template>
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import flatPickr from "vue-flatpickr-component";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import Textarea from '@/Shared/Components/Forms/Textarea.vue';
export default {
    components: { InputLabel, TextInput, Textarea, Multiselect, flatPickr },
    props: ['id'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                title: null,
                capacity: null,
                description: null,
                event_id: this.id,
                venue_id: null,
                dates: [],
                timeOfDay: 'Whole Day',
                option: 'session'
            }),
            check: false,
            date: null,
            dateType: null,
            single:{
                mode: "single",
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'F j, Y',
                minDate: new Date().setDate(new Date().getDate() + 1),
                disable: [
                    function(date) {
                        return (date.getDay() === 0 || date.getDay() === 6);
                    }
                ]
            },
            range: {
                mode: "range",
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'F j, Y',
                minDate:'',
            },
            multiple: {
                mode: "multiple",
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'F j, Y',
                minDate: new Date().setDate(new Date().getDate() + 1),
                disable: [
                    function(date) {
                        return (date.getDay() === 0 || date.getDay() === 6);
                    }
                ]
            },
            showModal: false,
            editable: false
        }
    },
    computed: {
        venueOptions() {
            return this.venues.map(venue => ({
            value: venue.id,
            name: `${venue.name} - ${venue.establishment}`
            }));
        }
    },
    watch: {
        dateType(){
            this.form.dates = [];
        },
        date(newVal) {
            if(newVal){
                if (this.dateType === 'Single Day') {
                    this.form.dates = [{
                        date: this.formatDate(newVal),
                        timeOfDay: this.form.timeOfDay || 'Whole Day'
                    }];
                }else if (this.dateType === 'Range') {
                    const parts = newVal.split(' to ');
                    if (parts.length === 2) {
                        const start = new Date(parts[0]);
                        const end = new Date(parts[1]);
                        const datesInRange = [];
                        for (let d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
                            if (d.getDay() !== 0 && d.getDay() !== 6) {
                                datesInRange.push({
                                    date: this.formatDate(new Date(d)),
                                    timeOfDay: 'Whole Day'
                                });
                            }
                        }
                        this.form.dates = datesInRange;
                    }
                }else if (this.dateType === 'Multiple Dates (non-continuous)') {
                    const dateStrings = newVal.split(',').map(str => str.trim());
                    this.form.dates = dateStrings.map(d => ({
                        date: this.formatDate(new Date(d)),
                        timeOfDay: 'Whole Day'
                    }));
                }
            }else{
                this.form.dates = [];
            }
        },
    },
    methods: { 
        show(){
            this.form.reset();
            this.editable = false;
            this.showModal = true;
        },
        edit(data){
            this.editable = true;
            this.form.id = data.id;
            this.form.name = data.name;
            this.form.establishment = data.establishment;
            this.form.address = data.address;
            this.showModal = true;
        },
        submit(){
            if(this.editable){
                this.form.put('/sessions/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.hide();
                    },
                });
            }else{
                this.form.post('/sessions',{
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
            this.editable = false;
            this.showModal = false;
        },
         formatDate(date) {
            const d = new Date(date);
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },
        formatDateWithWeekday(dateString) {
            const date = new Date(dateString);
            const day = date.getDate();
            const month = date.toLocaleString('en-US', { month: 'short' });
            const year = date.getFullYear();
            const weekday = date.toLocaleString('en-US', { weekday: 'long' });
            return `${month} ${day}, ${year} (${weekday})`;
        },
    }
}
</script>