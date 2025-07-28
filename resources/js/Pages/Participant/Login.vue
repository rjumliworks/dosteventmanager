<template>
    <Head title="Log in"/>
    <div class="auth-page-wrapper pt-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="auth-page-content">
            <BContainer>

                <BRow class="justify-content-center">
                    <BCol md="8" lg="6" xl="5">
                        <BCard no-body class="mt-4">

                            <BCardBody class="p-4">
                                <div class="row mb-2">
                                    <div class="col-2">
                                        <img src="@assets/images/logo-sm.png" alt="" class="avatar-sm">
                                    </div>
                                    <div class="col-10">
                                        <div class="text-primary mt-1">
                                            <h4 class="fs-16 fw-semibold">DOST-IX Event Manager</h4>
                                            <p class="mt-n2">Event & Attendance Management System</p>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="status" class="alert alert-success text-success">
                                    {{ status }}
                                </div>
                                <div class="p-2 mt-3">
                                    <form class="customform" @submit.prevent="submit">

                                        <div class="p-2 mt-4"><div class="text-muted text-center mb-4 mx-lg-3"><h4 class="">Verify Your Email</h4><p>Please enter the 4 digit code sent to <span class="fw-semibold">example@abc.com</span></p></div><form><div class="row"><div class="col-3"><div class="mb-3"><label for="digit1-input" class="visually-hidden">Dight 1</label><input type="text" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(this, 2)" maxlength="1" id="digit1-input"></div></div><div class="col-3"><div class="mb-3"><label for="digit2-input" class="visually-hidden">Dight 2</label><input type="text" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(this, 3)" maxlength="1" id="digit2-input"></div></div><div class="col-3"><div class="mb-3"><label for="digit3-input" class="visually-hidden">Dight 3</label><input type="text" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(this, 4)" maxlength="1" id="digit3-input"></div></div><div class="col-3"><div class="mb-3"><label for="digit4-input" class="visually-hidden">Dight 4</label><input type="text" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(this, 4)" maxlength="1" id="digit4-input"></div></div></div></form><div class="mt-3"><button class="btn btn-success btn-md w-100" type="button"><!----><div class="btn-content">Confirm</div></button></div></div>

                                    </form>
                                </div>
                            </BCardBody>
                        </BCard>

                    </BCol>
                </BRow>
            </BContainer>
        </div>
    </div>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';
import Checkbox from '@/Shared/Components/Forms/Checkbox.vue';
import InputError from '@/Shared/Components/Forms/InputError.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
defineProps({
    canResetPassword: Boolean,
    status: String
});
const form = useForm({
    email: '',
    password: '',
    remember: false,
});
const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post('/login', {
        onFinish: () => form.reset('password'),
    });
};
</script>
<script>
export default {
    layout: null,
    data() {
        return {
            togglePassword: false
        }
    },
    methods: {
        openRegister(){
            this.$refs.register.show();
        }
    }
}
</script>
<style>
.auth-page-wrapper {
    background-color: hsl(201, 80%, 82%);
}
</style>
