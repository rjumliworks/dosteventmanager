<template>
    <Head title="Mobile Carwash" />
    <div class="layout-wrapper landing">
        <section class="section nft-hero job-hero-section bg-light pb-0" id="hero" style="margin-top: -170px;">
            <div class="bg-overlay"></div>
            <BContainer>
                <BRow class="justify-content-between align-items-center">
                    <BCol lg="6">
                        <div>
                            <img src="images/logo-sm.png" alt="logo light" height="70">
                            <img src="images/new.png" alt="logo light" height="90">
                            <img src="images/logo-dark.png" alt="logo light" height="50">
                             <hr class="text-muted"/>
                            <!-- <h1 class="display-6 fw-semibold text-capitalize mb-3 lh-base"><span class="text-primary">DOST-IX</span> RSTW 2024</h1> -->
                            <p class="lead lh-base mb-1">Siyensya, Teknolohiya at Inobasyon :</p>
                            <p class="lead text-muted fs-14 lh-base mb-4">Kabalikat sa Matatag, Maginhawa, at Panatag na Kinabukasan. <br />Providing Solutions and Opening Opportunities in the Green Economy</p>
                            <BButton @click="openRegister()" variant="primary" class="submit-btn w-80 h-100" type="submit">
                            REGISTER NOW</BButton>

                            <ul class="treding-keywords list-inline mb-0 mt-3 fs-13">
                                <li class="list-inline-item text-danger fw-semibold"><i
                                        class="ri-map-pin-fill align-middle"></i> Grand Astsoria Hotel, Zamboanga City :</li>
                                <li class="list-inline-item">
                                    <span class="fw-semibold text-primary">November 21-22, 2024</span>
                                </li>
                              
                            </ul>
                        </div>
                    </BCol>
                    <BCol lg="" class="hidemobile">
                        <div class="position-relative home-img text-center mt-5 mt-lg-0">
                            <img src="/images/job.png" alt="" class="user-img rightpic" style="margin-right: -130px;">

                            <div class="circle-effect">
                                <div class="circle"></div>
                                <div class="circle2"></div>
                                <div class="circle3"></div>
                                <div class="circle4"></div>
                            </div>
                        </div>
                    </BCol>
                </BRow>
            </BContainer>
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
                    <b-col sm="auto">
                        <div>
                            <button @click="openRegister()" class="btn bg-gradient btn-danger">REGISTER NOW</button>
                        </div>
                    </b-col>
                </b-row>
            </b-container>
            <b-container class="showmobile"> 
                <b-row class="align-items-center gy-3">
                <div class="d-grid mt-n3 mb-n5" >
                    <BButton @click="openRegister()" variant="warning" class="submit-btn w-80 h-100 fw-semibold" type="submit">BOOK NOW</BButton>
                </div></b-row>
            </b-container>
        </section>

        <section class="section bg-light" id="plans">
            <div class="bg-overlay bg-overlay-pattern"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h3 class="mb-1 fw-semibold rstitle">Rates and Services</h3>
                            <p class="text-muted mb-4 rsdef">Simple pricing. No hidden fees.</p>
                        </div>
                    </div>
                </div>

                <div class="row gy-4 mt-n5">
                    
                    <div class="col-lg-12">
                        <div class="card mb-0 ribbon-box right">
                            <div class="card-body p-4 m-2">
                                <div class="ribbon-two ribbon-two-danger"><span>Popular</span></div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold rstitle1">G1 - Mobile Good Wash</h5>
                                        <p class="text-muted mb-0 rsdef1">Time-Saving Convenience. Skip the car wash line and get premium service at home. Our services offers car detailing without hassle.</p>
                                    </div>
                                </div>
                                <hr class="text-muted"/>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <ul class="list-unstyled text-muted vstack gap-0 ff-secondary">
                                            <li><i class="ri-checkbox-circle-fill text-success align-middle rsdetails"></i><span class="text-muted ms-1 rsdetails">Detailers Wash</span></li>
                                            <li><i class="ri-checkbox-circle-fill text-success align-middle rsdetails"></i><span class="text-muted ms-1 rsdetails">Interior Cleaning</span></li>
                                            <li><i class="ri-checkbox-circle-fill text-success align-middle rsdetails"></i><span class="text-muted ms-1 rsdetails">Wheel & Tire Detailing</span></li>                  
                                        </ul>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-bordered align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr class="fs-11">
                                                        <th style="width: 25%;" class="text-center">SEDAN</th>
                                                        <th style="width: 25%;" class="text-center">COMPACT</th>
                                                        <th style="width: 25%;" class="text-center">PICK UP</th>
                                                        <th style="width: 25%;" class="text-center">SUV</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="rsfont">
                                                        <td class="text-center">₱300</td>
                                                        <td class="text-center">₱350</td>
                                                        <td class="text-center">₱350</td>
                                                        <td class="text-center">₱350</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card mb-0 ribbon-box right">
                            <div class="card-body p-4 m-2">
                                <div class="ribbon-two ribbon-two-warning"><span>Hot</span></div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold rstitle1">MI - Mobile Premium Wash</h5>
                                        <p class="text-muted mb-0 rsdef1">We bring premium car care, right at your doorstep. No hassle, just clean car.</p>
                                    </div>
                                </div>
                                <hr class="text-muted"/>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div></div>
                                        <ul class="list-unstyled text-muted vstack gap-0 ff-secondary">
                                            <li><i class="ri-checkbox-circle-fill text-success align-middle rsdetails"></i><span class="text-muted ms-1 rsdetails">Detailers Wash</span></li>
                                            <li><i class="ri-checkbox-circle-fill text-success align-middle rsdetails"></i><span class="text-muted ms-1 rsdetails">Interior Vacuum Cleaning</span></li>
                                            <li><i class="ri-checkbox-circle-fill text-success align-middle rsdetails"></i><span class="text-muted ms-1 rsdetails">Interior Sunshield & Anti-Bac Protectant</span></li>
                                            <li><i class="ri-checkbox-circle-fill text-success align-middle rsdetails"></i><span class="text-muted ms-1 rsdetails">Detailers Wash</span></li>
                                            <li><i class="ri-checkbox-circle-fill text-success align-middle rsdetails"></i><span class="text-muted ms-1 rsdetails">Wheel & Tire Detailing</span></li>
                                            <li><i class="ri-checkbox-circle-fill text-success align-middle rsdetails"></i><span class="text-muted ms-1 rsdetails">UV Protectant Carnauba Wax</span></li>                    
                                        </ul>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="table-responsive mt-4">
                                            <table class="table table-nowrap table-bordered align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr class="fs-11">
                                                        <th style="width: 25%;" class="text-center">SEDAN</th>
                                                        <th style="width: 25%;" class="text-center">COMPACT</th>
                                                        <th style="width: 25%;" class="text-center">PICK UP</th>
                                                        <th style="width: 25%;" class="text-center">SUV</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="rsfont">
                                                        <td class="text-center">₱400</td>
                                                        <td class="text-center">₱450</td>
                                                        <td class="text-center">₱450</td>
                                                        <td class="text-center">₱450</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!--end row-->
            </div>
            <!-- end container -->
        </section>

        <footer class="custom-footer bg-dark py-5 position-relative">
            <b-container>
                <b-row>
                    <b-col lg="7" class="mt-4 hidemobile">
                        <div>
                            <div>
                                <img src="images/goodwash.png" alt="logo light" height="100%" width="150">
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
    </div>

    <BModal v-model="showModal" style="--vz-modal-width: 600px;" hide-footer body-class="p-0" header-class="p-0"
        class="v-modal-custom" content-class="border-0 overflow-hidden" centered hide-header-close>
        <div class="modal-body login-modal p-5">
            <h5 class="text-white fs-18 mb-1 mt-n4">Booking Form</h5>
            <p class="text-white-50 fs-12 mb-4">Please fill out the form carefully to ensure all information is accurate.</p>
            <div class="vstack gap-2 justify-content-center">
               <form class="customform mb-n5" style="color: white;">
                    <BRow class="g-3 mb-2"> 
                        <BCol lg="12" class="mt-n2 mb-0">
                            <hr class="text-muted"/>
                        </BCol>
                        <BCol lg="12" class="mt-n1">
                            <InputLabel for="name" value="Fullname" :message="form.errors.firstname"/>
                              <b-row class="g-3 mt-n3">
                                <b-col lg>
                                    <div class="input-group mb-0">
                                        <input type="text" v-model="form.firstname" placeholder="Firstname" class="form-control" style="width: 50%;">
                                        <input type="text" v-model="form.lastname" placeholder="Lastname" class="form-control" style="width: 50%;">
                                    </div>
                                </b-col>
                            </b-row>
                        </BCol>
                        <BCol lg="6" class="mt-0">
                            <InputLabel for="name" value="Email Address" :message="form.errors.email"/>
                            <TextInput id="name" v-model="form.email" type="email" class="form-control" placeholder="Please enter email" @input="handleInput('email')" :light="true"/>
                        </BCol>
                        <BCol lg="6" class="mt-0">
                            <InputLabel for="name" value="Contact no." :message="form.errors.contact_no"/>
                            <TextInput id="name" v-model="form.contact_no" type="text" class="form-control" placeholder="Please enter contact no." @input="handleInput('contact_no')" :light="true"/>
                        </BCol>
                        <BCol lg="6" class="mt-0">
                            <InputLabel for="name" value="Type" :message="form.errors.type"/>
                            <select class="form-select mb-3" v-model="form.type" aria-label="Default select example" style="min-height: 38.4px !important;">
                                <option value="null" selected class="text-muted" disabled>Select type</option>
                                <option value="Sedan">Sedan</option>
                                <option value="Suv">Suv</option>
                                <option value="Auv">Auv</option>
                                <option value="Pickup">Pick up</option>
                            </select>
                        </BCol>
                        <BCol lg="6" class="mt-0">
                            <InputLabel for="name" value="Date & Time" :message="form.errors.date"/>
                              <b-row class="g-3 mt-n3">
                                <b-col lg>
                                    <div class="input-group mb-0">
                                        <input type="date" v-model="form.date" placeholder="Date" class="form-control" style="height: 38.5px; width: 60%;">
                                        <select class="form-select mb-3" v-model="form.time" aria-label="Default select example" style="height: 38.5px; width: 40% ">
                                            <option value="null" selected class="text-muted" disabled>Select Time</option>
                                            <option value="08:00:00">8:00 am</option>
                                            <option value="11:00:00">11:00 am</option>
                                            <option value="14:00:00">2:00 pm</option>
                                            <option value="16:00:00">4:00pm</option>
                                            <option value="18:00:00">6:00pm</option>
                                        </select>
                                    </div>
                                </b-col>
                            </b-row>
                        </BCol>
                        <BCol lg="6" class="mt-n2">
                            <InputLabel for="name" value="Service" :message="form.errors.type"/>
                            <select class="form-select mb-3" v-model="form.service" aria-label="Default select example" style="min-height: 38.4px !important;">
                                <option value="null" selected class="text-muted" disabled>Select type</option>
                                <option value="G1 - Mobile Good Wash">G1 - Mobile Good Wash</option>
                                <option value="M1 - Mobile Premium Wash">M1 - Mobile Premium Wash</option>
                            </select>
                        </BCol>
                    </BRow>
               </form>
            </div>
        </div>
       
        <div class="modal-body p-5">
            <form class="customform">
                <BRow class="g-3" style="margin-top: -35px;"> 
                    <BCol lg="6">
                        <BRow class="g-2"> 
                            <BCol lg="12" class="mt-n1">
                                <InputLabel for="barangay" value="Barangay" :message="form.errors.barangay_code"/>
                                <Multiselect :options="barangays" :searchable="true" label="name" v-model="form.barangay_code" placeholder="Select Barangay" @input="handleInput('barangay_code')"/>
                            </BCol>
                            <BCol lg="12" class="mt-1">
                                <InputLabel for="address" value="Address" :message="form.errors.address"/>
                                <TextInput id="address" v-model="form.address" type="text" class="form-control" placeholder="Please enter street/house no." @input="handleInput('address')" :light="true"/>
                            </BCol>
                        </BRow>
                    </BCol>
                   
                    <BCol lg="12" class="mt-0"><hr class="text-muted"/></BCol>
                </BRow>
                <div class="mt-n1 form-check">
                    <input type="checkbox" v-model="form.check" class="form-check-input" id="checkTerms">
                    <label class="form-check-label" for="checkTerms">I agree to the <span class="fw-semibold">Terms of Service</span> and Privacy Policy</label>
                </div>
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
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default { 
    layout: null,
    components: {Multiselect, InputLabel, TextInput, Map},
    data() {
        return {
            showModal: false,
            form: useForm({
                firstname: null,
                lastname: null,
                contact_no: null,
                email: null,
                type: null,
                barangay_code: null,
                address: null,
                date: null,
                time: null,
                longitude: null,
                latitude: null,
                service: null,
                check: false
            }),
            barangays: [],
            coordinates: {},
            tos: false
        };
    },
    methods: {
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
            this.form.check = false;
            this.showModal = true;
            this.$refs.map.view();
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
<style>
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