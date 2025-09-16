<template>
    <Head title="Home Page" />
    <div>
        <nav class="navbar navbar-expand-lg navbar-landing " id="navbar" >
            <div class="container"><a class="navbar-brand" href="/" target="_self">
            <img src="/images/logo-dark.png" class="card-logo card-logo-dark" alt="logo dark" height="17">
            <img src="" class="card-logo card-logo-light" alt="logo light" height="17"></a>
            <button class="navbar-toggler py-0 fs-20 text-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-expanded="false">
                <i class="mdi mdi-menu"></i>
            </button>
            <div id="navbarSupportedContent" class="collapse navbar-collapse" is-nav="false">
                <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                    <li class="nav-item"><a class="nav-link active" href="#home" target="_self">Home</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="#schedules" target="_self">Schedules</a></li> -->
                    <li class="nav-item"><Link class="nav-link" href="/highlights" target="_self">Highlights</Link></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="/hotels" target="_self">Hotels</a></li> -->
                    <li class="nav-item"><a class="nav-link" href="#about" target="_self">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact" target="_self">Contact</a></li>
                      <li class="nav-item sm-align-item-start">    

                        <div>
                            <b-dropdown variant="light" id="dropdown-grouped" text="Downloadables" class="m-2">
                                <b-dropdown-group  header="Media Brief">
                                <b-dropdown-item-button><a href="https://tinyurl.com/4kx5zdye" target="_blank">Part 1</a></b-dropdown-item-button>
                                <b-dropdown-item-button><a href="https://tinyurl.com/3uw8axk4" target="_blank">Part 2</a></b-dropdown-item-button>
                                </b-dropdown-group>
                                <b-dropdown-divider></b-dropdown-divider>
                                <b-dropdown-group  header="Programme">
                                    <b-dropdown-item-button><a href="https://tinyurl.com/cxnsvfxb" target="_blank">Summary of Activities</a></b-dropdown-item-button>
                                    <b-dropdown-item-button><a href="https://tinyurl.com/rs2x7cer" target="_blank">Day 1-3 Schedule</a></b-dropdown-item-button>
                                </b-dropdown-group>
                                <b-dropdown-divider></b-dropdown-divider>
                                <b-dropdown-item-button>
                                <a href="https://tinyurl.com/ydern4n9" target="_blank">Manifestation</a>
                                </b-dropdown-item-button>
                            </b-dropdown>
                            </div>
                    </li>
                </ul>
            
            </div>
        </div>
        </nav>
           
        <section id="home" class="py-5 position-relative header-bg">
            <b-container >
                <b-row class="align-items-center gy-4">
                    
                    <b-col class="justify-content-center mt-3">
                        <div  class="mb-5 responsive-title-img text-center hidemobile">
                            <img src="@assets/images/event/web_logos.png" alt="" class="img-fluid rounded-pill" style="height: 80px;">
                        </div>
                        <div  class="mb-5 responsive-title-img text-center showmobile" >
                            <img src="@assets/images/event/logos.png" alt="" class="img-fluid" style="height: 80px;">
                        </div>
                        <div class="mb-3 responsive-title-img">
                            <img src="@assets/images/event/event_title.png" alt="" class="img-fluid">
                            </div>

                        <BRow>
                            <b-col lg="6" >
                                    <div class="lead right-countdown mt-3 mb-3 event-display">
                                        <span class="fs-20 text-white">Event Countdown</span>
                                        <h3 v-if="timeLeft.total > 0">
                                        <h1 class="fw-bolder event-countdown" >{{ timeLeft.days }}d {{ timeLeft.hours }}h {{ timeLeft.minutes }}m {{ timeLeft.seconds }}s </h1>
                                        </h3>
                                        <h3 class="fw-bolder" style="font-size: 50px;color: yellow;" v-else>
                                            The event has started!
                                        </h3>
                                            <a href="/registration" class="align-content-center ">
                                                <BButton variant="danger" class="submit-btn bx-tada w-80 mt-3 mb-3 fw-bold h-100 border btn-lg border-solid " type="submit"  >
                                                    REGISTER NOW
                                                </BButton>
                                            </a>

                                            <ul class="treding-keywords list-inline mb-0 mt-3 fs-13 venue-scheed-wrapper">
                                                <li class="list-inline-item text-danger fw-semibold">
                                                    <i class="ri-map-pin-fill align-middle text-warning fs-20 me-2"></i>
                                                    <span class="venue-text">
                                                        Palacio Del Sur, Marcian Garden Hotel, Zamboanga City
                                                    </span>
                                                </li>
                                                <li class="list-inline-item fw-semibold">
                                                    <i class="ri-calendar-fill align-middle text-warning fs-20 me-2"></i> 
                                                    <span class="schedule-text" >
                                                        September 23-25, 2025
                                                    </span>
                                                </li>        
                                        </ul>

                                        
                                    </div>
                                </b-col>

                                <b-col lg="6">
                                    <div class="position-relative home-img mt-lg-0 border border-solid border-2 mb-sm-3"  
                                            data-aos="fade-up" 
                                                data-aos-duration="5000" 
                                                data-aos-delay="500">
                                            <b-col md="12" class="d-flex justify-content-center align-items-center">
                                                <iframe width="560" height="315" src="https://www.youtube.com/embed/CX7uQgYo8zI?si=v2oaq5OqAl2IOX88&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                            </b-col>


                                        </div>
                                </b-col>
                        </BRow>

                    </b-col>
                </b-row>
            </b-container>
        </section>>
    
        <section class="py-5 position-relative">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-0">
                            <h3 class="mb-1 fs-18 fw-semibold">Events About</h3>
                            <p class="text-muted fs-14 mb-4">Explore and Enjoy!</p>
                        </div>
                    </div>
                </div>
             
                <div class="row align-items-center mt-2 gy-4">
                    <div class="col-lg-6">
                        <div class="text-muted ps-lg-5">
                            <h5 class="fs-12 text-uppercase text-success">RSTW 2025</h5>
                            <h4 class="fs-16 fw-semibold mb-3">Regional Science, Technology, and Innovation Week</h4>
                            <p class="mb-4">A flagship celebration showcasing how science, technology, and innovation (STI) empower communities and drive national progress. Aligned with the call “Handa Pilipinas sa Bagong Pilipinas,” RSTW promotes awareness, preparedness, and resilience through science-based solutions. It brings together researchers, innovators, local governments, and the public to highlight how STI can address regional challenges, support disaster readiness, improve livelihoods, and build a more inclusive, forward-looking nation.</p>
                            
                        </div>
                    </div>
                    <div class="col-lg-6">
                           <div class="text-muted ps-lg-5">
                            <h5 class="fs-12 text-uppercase text-success">Mindanao Leg</h5>
                            <h4 class="fs-16 fw-semibold  mb-3">Handa Pilipinas sa Bagong Pilipinas</h4>
                            <p class="mb-4">A unified call to action for a more resilient, responsive, and forward-looking nation. Rooted in the spirit of preparedness and innovation, this movement embodies the collective efforts of government, communities, and individuals in building a safer, more progressive Philippines under the vision of "Bagong Pilipinas." It highlights proactive disaster risk reduction, good governance, sustainable development, and inclusive growth to ensure that every Filipino is ready for the challenges and opportunities of a new era.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="py-5 bg-primary position-relative">
            <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
            <b-container class="hidemobile">
                <b-row class="align-items-center gy-4">
                    <b-col sm>
                        <div>
                            <h4 class="text-white mb-0 fw-semibold">Be one of our Participants!</h4>
                        </div>
                    </b-col>
                    <b-col sm="auto" >
                        <div>
                            <a href="/registration">
                            <BButton variant="danger" class="submit-btn bx-tada w-80 mt-2 mb-2 fw-bold h-100 border btn-md border-solid" type="submit"  >
                                REGISTER NOW
                            </BButton>
                            </a>
                        </div>
                    </b-col>
                </b-row>
            </b-container>
            <b-container class="showmobile"> 
                <b-row class="align-items-center gy-3">
                <div class="d-grid mt-n3 mb-n5 text-center" >
                   <a href="/registration">
                    <BButton type="button" variant="danger" class="submit-btn w-80 h-100 fw-semibold">REGISTER NOW</BButton>
                    </a>
                    
                </div></b-row>
            </b-container>
        </section>

        <section class="py-5 position-relative" id="about">
            <b-container class="mt-4">
                <b-row>
                <div class="ml-5 fs-1 mb-3  fw-medium" >
                About Us!
                </div>
                <b-col lg="8">
                <p class="fs-16 lh-base" 
                    data-aos="fade-left" 
                    data-aos-duration="5000" 
                    data-aos-delay="500">
                   <b class="text-primary"> The Department of Science and Technology Region IX (DOST IX)</b> is committed to 
                    driving inclusive growth and sustainable development in the Zamboanga Peninsula
                     through science, technology, and innovation. With programs that empower communities,
                      support local industries, and enhance disaster resilience, DOST IX serves as a catalyst
                       for progress in the region. From technology transfer to research and development, 
                       we bring science closer to the people.                
                    </p>
                </b-col>

                <b-col lg="4">
                <div class="col-lg-6 lead mx-auto fs-16 lh-base text-center" 
                    data-aos="fade-left" 
                    data-aos-duration="5000" 
                    data-aos-delay="500">
                    <img src="@assets/images/logos/logo-sm.png" alt="" class="dost-logo" >

                    </div>
                </b-col>
            </b-row>
            </b-container>
        
        </section>

        <section id="venue" class="bg-primary position-relative"
                data-aos="fade-up" 
                data-aos-duration="5000" 
                data-aos-delay="500">

                <div>
                    <img src="@assets/images/event/zc_bg.svg" class="img-fluid w-100" alt="Full width image"  >
                </div>
        </section>
           </div>

        <footer class="custom-footer bg-dark py-5 position-relative" id="contact">
            <b-container>
                <b-row>
                    <b-col lg="7" class="mt-4 hidemobile">
                        <div>
                            <div>
                                <img src="images/event/rstw2025.png" alt="logo light" height="100%" width="150">
                            </div>
                            <div class="mt-4 fs-13 hidemobile">
                                <p>Department of Science and Technology - IX</p>
                                <p class="ff-secondary">Siyensya, Teknolohiya at Inobasyon : Kabalikat sa Matatag, Maginhawa, at Panatag na Kinabukasan. Providing Solutions and Opening Opportunities in the Green Economy</p>
                            </div>
                        </div>
                    </b-col>

                    <b-col lg="5" class="ms-lg-auto hidemobile">
                        <b-row>
                            <b-col sm="12" class="mt-4 text-end">
                                <h4 class="text-white mb-0">Contact Details</h4>
                                <div class="text-muted mt-4 fs-13">
                                    <ul class="list-unstyled ff-secondary footer-list">
                                        <li>
                                            Department of Science and Technology Regional Office No. IX 
                                        </li>
                                        <li>
                                            Pettit Barracks, Zamboanga City, Philippines
                                        </li>
                                        <li>
                                            Tel.: (062) 991-1024 
                                        </li>
                                        <li>
                                            Email: ord@ro9.dost.gov.ph
                                        </li>
                                    </ul>
                                </div>
                            </b-col>           
                        </b-row>
                    </b-col>
                </b-row>

                <b-row class="text-center text-sm-start align-items-center mt-5">
                    <b-col sm="6" class="mb-3 mt-n5 showmobile">
                        <img src="images/goodwash.png" alt="logo light" height="100%" width="150">
                    </b-col>
                    <b-col sm="6">
                        <div>
                            <p class="copy-rights mb-0 currentyear">{{ new Date().getFullYear() }} © DOST-IX ICT
                            </p>
                        </div>
                    </b-col>
                    <b-col sm="6">
                        <div class="text-sm-end mt-3 mt-sm-0">
                            <ul class="list-inline mb-0 footer-social-link">
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-facebook-fill"></i>
                                        </div>
                                    </b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-github-fill"></i>
                                        </div>
                                    </b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-linkedin-fill"></i>
                                        </div>
                                    </b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-google-fill"></i>
                                        </div>
                                    </b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-dribbble-line"></i>
                                        </div>
                                    </b-link>
                                </li>
                            </ul>
                        </div>
                    </b-col>
                </b-row>
            </b-container>
        </footer>
             
        <b-button variant="danger" @click="topFunction" class="btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </b-button>
   

     <BModal v-model="showModal" style="--vz-modal-width: 800px;" hide-footer body-class="p-0" header-class="p-0"
        class="v-modal-custom" content-class="border-0 overflow-hidden" centered hide-header-close>
        <div class="modal-body login-modal p-5">
            <h5 class="text-white fs-18 mb-1 mt-n4">Registration Form</h5>
            <p class="text-white-50 fs-12 mb-4">Please fill out the form carefully to ensure all information is accurate.</p>
            <div class="vstack gap-2 justify-content-center">
               <form class="customform mb-n5" style="color: white;">
                    <BRow class="g-3 mb-3"> 
                        <BCol lg="12" class="mt-n2 mb-0">
                            <hr class="text-muted"/>
                        </BCol>
                        <BCol lg="12" class="mt-0">
                            <InputLabel for="name" value="Full Name" :message="form.errors.fullname"/>
                            <b-row class="g-3 mb-2 mt-n3">
                                <b-col lg>
                                    <div class="input-group mb-0">
                                        <input type="text" v-model="form.firstname" placeholder="First name" class="form-control" style="width: 28%; min-height: 38.4px !important; background-color: #f5f6f7; text-transform: uppercase;">
                                        <input type="text" v-model="form.middlename" placeholder="Middle name" class="form-control" style="width: 28%; min-height: 38.4px !important; background-color: #f5f6f7; text-transform: uppercase;">
                                        <input type="text" v-model="form.lastname" placeholder="Last name" class="form-control" style="width: 28%; min-height: 38.4px !important; background-color: #f5f6f7; text-transform: uppercase;">
                                        <input type="text" v-model="form.suffix" placeholder="Suffix" class="form-control" style="width: 16%; min-height: 38.4px !important; background-color: #f5f6f7; text-transform: uppercase;">
                                    </div>
                                </b-col>
                            </b-row>
                        </BCol>
                    </BRow>
               </form>
            </div>
        </div>
       
        <div class="modal-body p-5">
            <form class="customform">
                <BRow class="g-3" style="margin-top: -35px;"> 
                   <BCol lg="6" class="mt-1">
                        <InputLabel for="name" value="Email Address" :message="form.errors.email"/>
                        <TextInput id="name" v-model="form.email" type="text" class="form-control" placeholder="Please enter email" @input="handleInput('email')" style="text-transform: lowercase;" :light="true"/>
                    </BCol>
                    <BCol lg="6" class="mt-1">
                        <InputLabel for="name" value="Contact no." :message="form.errors.contact_no"/>
                        <TextInput id="name" v-model="form.contact_no" type="text" class="form-control" placeholder="Please enter contact no." @input="handleInput('contact_no')" :light="true"/>
                    </BCol>
                    <BCol lg="6" class="mt-0">
                        <InputLabel for="name" value="Birth Date" :message="form.errors.birthdate"/>
                        <TextInput id="name" v-model="form.birthdate" type="date" class="form-control" placeholder="Please enter birthdate" @input="handleInput('birthdate')" :light="true"/>
                    </BCol>
                    <BCol lg="6" class="mt-0">
                        <InputLabel for="region" value="Sex" :message="form.errors.sex_id"/>
                        <Multiselect :options="dropdowns.sexs" label="name" v-model="form.sex_id" placeholder="Select Sex" @input="handleInput('sex_id')"/>
                    </BCol>
                    <BCol lg="6" class="mt-1">
                        <InputLabel for="name" value="Designation" :message="form.errors.designation"/>
                        <TextInput id="name" v-model="form.designation" type="text" class="form-control" placeholder="Please enter designation" @input="handleInput('designation')" style="text-transform: uppercase;" :light="true"/>
                    </BCol>
                    <BCol lg="6" class="mt-1">
                        <InputLabel for="name" value="Affiliation" :message="form.errors.affiliation"/>
                        <TextInput id="name" v-model="form.affiliation" type="text" class="form-control" placeholder="Please enter affiliation" @input="handleInput('affiliation')" style="text-transform: uppercase;" :light="true"/>
                    </BCol>
                    <BCol lg="12" class="mt-0"><hr class="text-muted"/></BCol>
                    <BCol lg="12">
                        <div class="mt-n3 form-check">
                            <input type="checkbox" v-model="form.check" class="form-check-input" id="checkTerms">
                            <label class="form-check-label" for="checkTerms"><i>I agree to the</i> <span class="fw-semibold text-primary" @click="tos = true">Terms of Service</span> <i>and Privacy Policy</i></label>
                        </div>
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
    
    <b-modal v-model="message" hide-footer class="v-modal-custom" modal-class="zoomIn" body-class="p-0" centered hide-header-close style="z-index: 5000;">
        <div class="text-end me-4">
            <button type="button" class="btn-close text-end" @click="check()"></button>
        </div>
        <div class="text-center px-5 pt-2">
            <div class="mt-2">
                 <div class="avatar-md mx-auto">
                    <div class="avatar-title rounded-circle bg-light">
                        <i v-if="$page.props.flash.status" class="ri-checkbox-circle-fill text-success h1 mb-0"></i>
                        <i v-else class="ri-close-circle-fill text-danger h1 mb-0"></i>
                    </div>
                </div>
                <h5 class="mb-1 mt-4 fs-14">{{$page.props.flash.message }}</h5>
                <p v-if="$page.props.flash.info" class="text-muted fs-12">{{$page.props.flash.info }}</p>
            </div>
        </div>
        <div class="modal-footer bg-light p-3 mt-5 justify-content-center">
            <p class="mb-0 text-muted fs-10">Thank you for signing up! We look forward to your participation</p>
        </div>
    </b-modal>
</template>
<script>
import AOS from 'aos';
import 'aos/dist/aos.css';
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
            form: useForm({
                firstname: null,
                lastname: null,
                middlename: null,
                suffix: null,
                contact_no: null,
                email: null,
                type_id: 16,
                sex_id: null,
                designation: null,
                affiliation: null,
                birthdate: null,
                check: false,
            }),

            targetDate: new Date('2025-09-23T00:00:00'),
            timeLeft: {
              total: 0,
              days: 0,
              hours: 0,
              minutes: 0,
              seconds: 0
            },
            coordinates: {},
            countdownInterval: null,

            tos: false,
            agree: false,
            showModal: false
        }
    },
    methods: {

        updateCountdown() {
            const now = new Date();
            const diff = this.targetDate - now;

            if (diff > 0) {
              this.timeLeft.total = diff;
              this.timeLeft.days = Math.floor(diff / (1000 * 60 * 60 * 24));
              this.timeLeft.hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
              this.timeLeft.minutes = Math.floor((diff / (1000 * 60)) % 60);
              this.timeLeft.seconds = Math.floor((diff / 1000) % 60);
            } else {
              this.timeLeft.total = 0;
              clearInterval(this.countdownInterval);
            }
        },
        submit(){
            this.form.post('/',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.form.clearErrors();
                    this.form.reset();
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        openRegister(){
            
            this.showModal = true;
        },
        topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        },
        hide(){
            this.showModal = false;
        },
        check(){
            this.$page.props.flash = {};
            this.message = false;
        },
        handleCoordinates(coords) {
            this.coordinates = coords;
            this.form.longitude = this.coordinates.lng;
            this.form.latitude = this.coordinates.lat;
        },
    },
    mounted() {
        AOS.init();
        this.updateCountdown();
        this.countdownInterval = setInterval(this.updateCountdown, 1000);

        let backtoTop = document.getElementById("back-to-top");
        if (backtoTop) {
            backtoTop = document.getElementById("back-to-top");
            window.onscroll = function () {
                if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                    backtoTop.style.display = "block";
                } else {
                    backtoTop.style.display = "none";
                }
            };
        }
        window.addEventListener('scroll', function (ev) {
            ev.preventDefault();
            var navbar = document.getElementById("navbar");
            if (navbar) {
                if (document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50) {
                    navbar.classList.add("is-sticky");
                } else {
                    navbar.classList.remove("is-sticky");
                }
            }
        });
    },
    computed: {
        message() {
            return (this.$page.props.flash.message) ?  true : false;
        }
    },
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