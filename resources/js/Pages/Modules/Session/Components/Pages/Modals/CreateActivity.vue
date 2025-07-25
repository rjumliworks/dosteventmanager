<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 750px;" header-class="p-3 bg-light" :title="(!editable) ? 'Create Activity' : 'Edit Activity'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3">
        
                <BCol lg="12" class="mt-3">
                    <InputLabel for="due" value="Activity" :message="form.errors.activity"/>
                    <TextInput v-model="form.activity" type="text" class="form-control" placeholder="Please enter title" @input="handleInput('activity')" :light="true"/>
                </BCol>
                 <BCol lg="6" class="mt-0">
                    <InputLabel for="role" value="Schedule" />
                    <Multiselect :options="scheduleOptions" v-model="form.schedule_id" label="name" :message="form.errors.schedule_id" placeholder="Select Schedule" ref="multiselect2"/>
                </BCol>
                <BCol lg="3" class="mt-0">
                    <InputLabel for="due" value="Start Time" :message="form.errors.capacity"/>
                    <TextInput v-model="form.start_time" type="time" class="form-control" placeholder="Please enter capacity" @input="handleInput('capacity')" :light="true"/>
                </BCol>
                <BCol lg="3" class="mt-0">
                    <InputLabel for="due" value="End Time" :message="form.errors.capacity"/>
                    <TextInput v-model="form.end_time" type="time" class="form-control" placeholder="Please enter capacity" @input="handleInput('capacity')" :light="true"/>
                </BCol>
                <BCol lg="12" class="mt-1">
                    <div class="d-flex">
                        <div style="width: 100%;">
                            <InputLabel for="conforme" value="Speaker" :message="form.errors.speaker"/>
                            <Multiselect 
                            :options="speakers" 
                            v-model="form.speaker" 
                            label="name"
                            @input="handleInput('speaker')"
                            object
                            :searchable="true" 
                            @search-change="searchUser"
                            placeholder="Select Speaker"/>
                        </div>
                        <div class="flex-shrink-0">
                            <b-button @click="openAdd()" style="margin-top: 20px;" variant="light" class="waves-effect waves-light ms-1"><i class="ri-add-circle-fill"></i></b-button>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12" class="mt-1"><hr class="text-muted"/></BCol>
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
    <AddSpeaker @selected="set" ref="speaker"/>
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import AddSpeaker from './AddSpeaker.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput, Multiselect, AddSpeaker },
    props: ['id','schedules'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                activity: null,
                start_time: null,
                end_time: null,
                speaker: null,
                session_id: this.id,
                schedule_id: null,
                option: 'activity'
            }),
            speakers: [],
            showModal: false,
            editable: false
        }
    },
    computed: {
        scheduleOptions() {
            return this.schedules.map(sched => {
                const date = new Date(sched.date);
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const formatted = new Intl.DateTimeFormat('en-US', options).format(date);
                return {
                    value: sched.id,
                    name: formatted
                };
            });
        }
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
            this.form.activity = data.activity;
            this.form.start_time = data.start_time;
            this.form.end_time = data.end_time;
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
        set(data){
            console.log(data);
            this.speakers.push(data);
            this.form.speaker = data;
        },
        openAdd(){
            this.$refs.speaker.show(this.form.customer);
        },
        searchUser: _.debounce(function(string) {
            (string) ? this.fetchUsers(string) : '';
        }, 300),
        fetchUsers(string){
            axios.get('/search',{
                params: {
                    option: 'speakers',
                    code: string
                }
            })
            .then(response => {
                this.speakers = response.data;
            })
            .catch(err => console.log(err));
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