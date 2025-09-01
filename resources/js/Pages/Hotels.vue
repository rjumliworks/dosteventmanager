<template>
    <Head title="Recommended Hotels " />
    <div class="landing-wrapper landing">
            <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
            <div class="container"><a class="navbar-brand" href="/" target="_self">
                <img src="/images/logo-dark.png" class="card-logo card-logo-dark" alt="logo dark" height="17">
                <img src="" class="card-logo card-logo-light" alt="logo light" height="17"></a>
                <button class="navbar-toggler py-0 fs-20 text-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-expanded="false">
                    <i class="mdi mdi-menu"></i>
                </button>
                <div id="navbarSupportedContent" class="collapse navbar-collapse" is-nav="false">
                     <ul class="navbar-nav ms-auto mt-2 mt-lg-0" id="navbar-example">
                        <li class="nav-item">
                            <a class="nav-link" href="/" target="_self">
                                <BButton>
                                    Back to Home
                                </BButton>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <section class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                              <h3 class="mb-1 fs-18 fw-semibold">Choose the Hotel that's right for you</h3>
                            <p class="text-muted fs-14 mb-4">Simple pricing. View hotels on Google Maps from the venue location.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12" v-for="(list,index) in hotels" v-bind:key="index">
                <!-- <div class="col-sm-7 col-lg-12 order-1 order-lg-2 col-10 order-1 ms-auto">
                    <div><img src="/images/banner/handa.jpg" alt="" class="img-fluid"></div>
                </div> -->
                   <div class="card plan-box mb-0">
                            <div class="card-body p-2 m-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1 fs-12 fw-semibold">{{list.name}}</h5>
                                        <p class="text-muted fs-12 mb-0">{{ list.contact_no }}</p>
                                         <p class="text-muted fs-12 mb-0">{{ list.location.address }}</p>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-light rounded-circle text-primary">
                                             <img :src="'/images/avatars/'+list.avatar" alt="user-img" class="img-thumbnail rounded-circle avatar-sm"/>
                                        </div>
                                    </div>
                                </div>
                                <hr class="text-muted"/>
                                <div>
                                    <!-- <ul class="list-unstyled text-muted vstack gap-3 ff-secondary">
                                        <li v-for="(a,index) in list.rates" v-bind:key="index">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 text-success me-1"><i
                                                        class="ri-checkbox-circle-fill fs-15 align-middle"></i></div>
                                                <div class="flex-grow-1">{{ a.rate }} </div>
                                            </div>
                                        </li>
                                       
                                    </ul> -->
                                    <div class="mt-4">
                                        <a class="btn btn-soft-success w-100" :href="list.link"
                                            target="_self">
                                            <img :src="'/images/avatars/'+list.avatar" alt="">
                                        </a>
                                    </div>
                                    <div class="mt-4">
                                        <a class="btn btn-soft-success w-100" :href="list"
                                            target="_self">View Hotel </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </section>
</div>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default { 
    layout: null,
    components: {Multiselect, InputLabel, TextInput, Map},
    props: ['dropdowns','hotels'],
    data() {
        return {
            tos: false,
            agree: false,
            showModal: false
        }
    },
    methods: {
    }
};
</script>
<style scoped>
.landing-video {
  width: 90%;
  height: auto;
  max-height: 80vh;
  object-fit: cover;
  border-radius: 8px;
}

@media (max-width: 576px) {
  .landing-video {
    max-height: 33vh;
    border-radius: 0;
  }
}
 .question {
    font-size: 20px !important;
}
.details {
    font-size: 14px !important;
}
.showmobile {
    display: none;
}
.hidemobile1 {
    display: block;
}
.rstitle1 {
    font-size: 16px;
}
.rsdef1 {
    font-size: 13px;
}
.rsfont {
    font-size: 14px;
}
@media only screen and (max-width: 768px) {
    .logo {
        display: block;
        margin: 0 auto;
        text-align: center;
        margin-top: 20px;
    }
    .cntr {
        text-align: center;
    }
    .question {
        font-size: 14px !important;
    }
    .details {
        font-size: 11px !important;
    }
    .rightpic {
        display: none;
    }
    .hidemobile {
        display: none;
    }
    .showmobile {
        display: block;
    }
    .hidemobile1 {
        display: none;
    }
    .rstitle {
        margin-top: -20px;
        font-size: 15px;
    }
    .rsdef {
        margin-bottom: -50px;
        font-size: 13px;
    }
    .rstitle1 {
        font-size: 14px;
    }
    .rsdef1 {
        margin-top: 10px;
        font-size: 12px;
    }
    .rsdetails {
        font-size: 13px;
    }
    .rsfont {
        font-size: 12px;
    }
}</style>