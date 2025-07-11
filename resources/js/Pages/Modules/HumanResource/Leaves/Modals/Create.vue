<template>
     <!-- style="--vz-modal-width: 750px;" -->
    <b-modal v-model="showModal" style="--vz-modal-width: 700px;" header-class="p-3 bg-light" title="Application for Leave" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
            
        <form class="customform">
            <BRow class="g-3 mdiv">
                <BCol lg="6" class="mt-3">
                    <InputLabel for="name" value="Type of Leave" :message="form.errors.type_id"/>
                    <Multiselect
                        v-model="form.type" :groups="true"
                        :options="dropdowns.leaves"
                        label="name"
                        object
                        placeholder="Select type"
                    />
                </BCol>
                <BCol lg="6" class="mt-3">
                    <InputLabel for="name" value="Details of Leave" :message="form.errors.detail_id"/>
                    <Multiselect :options="filteredDetails" :searchable="true" label="name" object v-model="form.detail" placeholder="Select Detail" @input="handleInput('detail_id')"/>
                </BCol>
                <BCol lg="12" v-if="form.detail?.others === 'specify' || form.detail?.others === 'specify illness' || form.detail?.others === 'specify reason'" class="mt-1">
                    <InputLabel for="name" value="Details" :message="form.errors.details"/>
                    <TextInput id="name" v-model="form.details" type="text" class="form-control" :placeholder="form.detail.others" @input="handleInput('details')" :light="true"/>
                </BCol>
                <BCol lg="12" class="mt-0"><hr class="text-muted"/></BCol>
                <BCol lg="12" class="mt-0">
                    <Multiselect :options="['Single Day','Range','Multiple Dates (non-continuous)']" :searchable="true" label="name" v-model="dateType" placeholder="Select Date type"/>
                </BCol>
                <template v-if="dateType == 'Single Day'">
                    <BCol lg="6" class="mt-2">
                        <InputLabel for="name" value="Date"  :message="form.errors.dates"/>
                        <flat-pickr v-model="date" :config="single" placeholder="Select date" class="form-control flatpickr-input" style="min-height: 38.4px !important; border-color: #e9ebec; background-color: #f5f6f7;"></flat-pickr>
                    </BCol>
                    <BCol lg="6" class="mt-2">
                        <InputLabel for="name" value="Time of Day"  :message="form.errors.date"/>
                        <Multiselect :options="['Whole Day','AM','PM']" label="name" v-model="form.timeOfDay" placeholder="Select Date type"/>
                    </BCol>
                </template>
                <template v-if="dateType == 'Range'">
                    <BCol lg="12" class="mt-2">
                        <InputLabel for="name" value="Date"  :message="form.errors.dates"/>
                        <flat-pickr v-model="date" :config="range" placeholder="Select date" class="form-control flatpickr-input" style="min-height: 38.4px !important; border-color: #e9ebec; background-color: #f5f6f7;"></flat-pickr>
                    </BCol>
                </template>
                <template v-if="dateType == 'Multiple Dates (non-continuous)'">
                    <BCol lg="12" class="mt-2">
                        <InputLabel for="name" value="Date"  :message="form.errors.dates"/>
                        <flat-pickr v-model="date" :config="multiple" placeholder="Select dates" class="form-control flatpickr-input" style="min-height: 38.4px !important; border-color: #e9ebec; background-color: #f5f6f7;"></flat-pickr>
                    </BCol>
                </template>
            </BRow>
        </form>
        <form>
            <BRow>
                <BCol lg="12" class="mt-3">
                    <div class="mt-0 form-check fs-14">
                        <input type="checkbox" v-model="check" class="form-check-input" id="checkTerms">
                        <label class="form-check-label fs-12" for="checkTerms">Please check the box if you have dates selected that are AM or PM only, not whole day</label>
                    </div>
                </BCol>
                <BCol lg="12" style="max-height: 250px; overflow: auto;"  id="my-modal-content"> 
                    <div v-if="check" class="mt-3">
                        <div v-for="(date, index) in form.dates" :key="index" class="mb-2">
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="ri-calendar-line search-icon"></i></span>
                                <input type="text" :value="formatDateWithWeekday(date.date)" placeholder="Search Employee" class="form-control" style="width: 20%;" readonly>
                                <Multiselect class="white" style="width: 30%;" :options="['Whole Day','AM','PM']" v-model="date.timeOfDay" 
                                :searchable="true" 
                                :allow-empty="false"  
                                :can-clear="false"
                                :append-to-body="true"
                                 append-to="#my-modal-content"
                                placeholder="Select Status" />
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
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import flatPickr from "vue-flatpickr-component";
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { Multiselect, InputLabel, TextInput, flatPickr },
    props: ['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                user_id: null,
                type: null,
                type_id: null,
                detail_id: null,
                details: null,
                timeOfDay: 'Whole Day',
                dates: [],
                option: 'leave'
            }),
            check: false,
            date: null,
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
            dateType: null,
            showModal: false
        }
    },
    computed: {
        filteredDetails() {
            if (!this.form.type || !this.form.type.name) {
                return [];
            }
            const selectedTypeName = this.form.type.name;
            const matches = this.dropdowns.details.filter(detail => {
                if (!detail.type) return false;
                const typeArray = detail.type.split(',').map(val => val.trim());
                return typeArray.includes(selectedTypeName);
            });
            if (matches.length === 0) {
                const others = this.dropdowns.details.find(detail => detail.id === 24 || detail.value === 24);
                return others ? [others] : [];
            }
            if (matches.length == 1) {
                const others = this.dropdowns.details.find(detail => detail.type == this.form.type.name);
                if(others){
                    [others];
                    this.form.detail = others;
                }else{
                    [];
                }
            }
            return matches;
        }
    },
    watch: {
        'form.detail': {
            immediate: true,
            handler(newVal) {
                if(newVal){
                    this.form.detail_id = newVal.value;
                }else{
                    this.form.detail_id = null;
                }
            }
        },
        'form.type': {
            immediate: true,
            handler(newVal) {
                if (!newVal || !newVal.name) {
                    this.form.detail = null;
                    return;
                }
                const selectedTypeName = newVal.name;
                const matches = this.dropdowns.details.filter(detail => {
                    if (!detail.type) return false;
                    const typeArray = detail.type.split(',').map(val => val.trim());
                    return typeArray.includes(selectedTypeName);
                });
                if (matches.length === 0) {
                    const others = this.dropdowns.details.find(
                        detail => detail.id === 24 || detail.value === 24
                    );
                    (others) ? this.form.detail = others : this.form.detail = null;
                } else {
                    const validIds = matches.map(d => d.id || d.value);
                    if (!validIds.includes(this.form.detail?.id || this.form.detail?.value)) {
                        this.form.detail = null; 
                    }
                }

                if (this.form.type && !this.form.type.is_after) {
                    this.single.minDate = new Date().setDate(new Date().getDate() + 1);
                    this.range.minDate = new Date().setDate(new Date().getDate() + 1);
                    this.multiple.minDate = new Date().setDate(new Date().getDate() + 1);
                }else{
                    this.single.minDate = null;
                    this.range.minDate = null;
                    this.multiple.minDate = null;
                }

                if(newVal){
                    this.form.type_id = newVal.value;
                }else{
                    this.form.type_id = null;
                }
            }
        },
        date(newVal) {
            if (!newVal) return;
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
        },
        'form.timeOfDay'(val) {
            if (this.dateType === 'Single Day' && this.form.dates?.length === 1) {
                this.form.dates[0].timeOfDay = val;
            }
        }
    },
    methods: { 
        show(data){
            this.selected = data;
            this.showModal = true;
        },
        submit(){
            this.form.post('/leaves',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.form.clearErrors();
                    this.form.reset();
                    this.hide();
                },
            });
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
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>