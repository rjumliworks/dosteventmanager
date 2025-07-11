<template>
    <!-- style="--vz-modal-width: 600px;" -->
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Add Deduction" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3">
              
                <BCol lg="12" class="mt-0">
                    <hr class="text-muted"/>
                </BCol>
                <BCol lg="12" class="mt-n2">
                    <InputLabel for="name" value="Deduction" :message="form.errors.deduction_id"/>
                    <Multiselect :options="filteredDeductions" 
                    v-model="form.deduction_id" label="name" 
                    :allow-empty="false"
                    :searchable="!editable" 
                    :disabled="editable" 
                    placeholder="Select Month" />
                </BCol>
                <BCol lg="12" class="mt-1">
                    <InputLabel value="Amount" :message="form.errors.amount"/>
                    <Amount @amount="amount" ref="testing" :readonly="false" @input="handleInput('amount')"/>
                </BCol>
                <BCol lg="12" class="mt-n1" v-if="status">
                    <hr class="text-muted"/>
                </BCol>
                 <BCol lg="12" class="mt-n2 text-center" v-if="status">
                    <InputLabel for="due" value="Please type DELETE to continue."/>
                    <TextInput v-model="keyword" type="text" class="form-control text-center" :light="true"/>
                </BCol>
            </BRow>
        </form>
          <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="openDelete()" v-if="editable" variant="danger" :disabled="(status) ? keyword !== 'DELETE' : false" block>Delete</b-button>
            <b-button @click="submit('ok')" v-if="!status" variant="primary" :disabled="form.processing" block>Update</b-button>
        </template>
    </b-modal>
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import Amount from '@/Shared/Components/Forms/Amount.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { Multiselect, TextInput, InputLabel, Amount },
    props: ['deductions'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                amount: null,
                payroll_id: null,
                deduction_id: null,
                option: 'deduction'
            }),
            names: [],
            keyword: null,
            status: false,
            type: null,
            showModal: false,
            editable: false
        }
    },
    computed: {
        filteredDeductions() {
            if(this.editable){
                return this.deductions;
            }else{
                return this.deductions.filter(item =>
                    item.is_contribution === 0 &&
                    item.is_loan === 0 &&
                    item.is_enrollable === 0 &&
                    item.is_regular === (this.type == 'Plantilla' ? 1 : 0)
                );
            }
        }
    },
    methods: { 
        show(id,type){
            this.editable = false;
            this.status = false;
            this.$refs.testing.empty();
            this.form.reset();
            this.type = type;
            this.form.payroll_id = id;
            this.showModal = true;
        },
        edit(id,type,deduction){
            this.form.id = deduction.id;
            this.form.payroll_id = id;
            this.form.deduction_id = deduction.deduction_id;
            this.$refs.testing.emitValue(deduction.amount);
            this.type = type;
            this.editable = true;
            this.showModal = true;
        },
        amount(val){
            this.form.amount = val;
        },
        submit(){
            if(this.editable){
                this.form.put('/payrolls/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('update',response.props.flash.data.data)
                        this.hide();
                    },
                });
            }else{
                this.form.post('/payrolls',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('update',response.props.flash.data.data)
                        this.hide();
                    },
                });
            }
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        openDelete(){
            if(this.status){
                if(this.keyword == 'DELETE'){
                    this.form.option = 'delete';
                    this.form.put('/payrolls/update',{
                        preserveScroll: true,
                        onSuccess: (response) => {
                            this.$emit('remove',response.props.flash.data.data)
                            this.hide();
                        },
                    });
                }else{
                    this.status = false;
                }
            }else{
                this.status = true;
            }
        },
        hide(){
            this.form.reset();
            this.editable = false;
            this.showModal = false;
            this.status = false;
        }
    }
}
</script>