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
                            <Link class="nav-link" href="/" target="_self">
                                <BButton>
                                    Back to Home
                                </BButton>
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    

          <section class="section" id="highlights">
        <div class="container">
           <div class="text-center mb-5">
                <h3 class="mb-1 fs-18 fw-semibold">Explore Event Highlights</h3>
                <p class="text-muted fs-14 mb-4">Highlight for this event</p>
            </div>

            <div class="scrolling-wrapper col-lg-12">

            <b-card
                title="Rapid Earthquake Damage Assessment System"
                data-aos="fade-up-left"
                data-aos-duration="5000"
                data-aos-delay="500"
                class="card-item text-center"
            >
                <img src="@assets/images/event/highlight2.png" class="img-fluid rounded shadow" style="height: 400px;" >
                <p class="lead pt-3 text-justify text-muted fs-14 lh-base">
                <b> REDAS (Rapid Earthquake Damage Assessment System) </b>is a software 
                    developed by PHIVOLCS in 2002 under a DOST GIA Project. The software can simulate earthquake
                    hazards such as ground shaking, liquefaction, landslides, and tsunami. The software can also
                    compute earthquake impacts in terms of physical damage, casualties, and economic loss. Although
                    REDAS was originally conceived for use in earthquake hazard and impact assessment, other multi-hazard
                    maps including hydrometeorological hazards such as floods, storm surge and rain-induced landslides 
                    are already incorporated into the software and can likewise be displayed by users. Participants 
                    are also taught how to develop their own exposure database using android application. REDAS was
                    developed by PHIVOLCS and is now being shared to local government units as a tool for emergency 
                    preparedness, contingency planning and more importantly for mainstreaming disaster risk reduction
                    into the local development planning process.
                </p>
                <p class="pt-2">
                For more information visit
                <a
                    href="https://www.phivolcs.dost.gov.ph/index.php/redas"
                    target="_blank"
                    rel="noopener noreferrer"
                ><u>DOST PHIVOLCS Website</u></a>
                </p>
            </b-card>

            <b-card
                title="Storm Surge"
                data-aos="flip-right"
                data-aos-duration="5000"
                data-aos-delay="100"
                class="card-item text-center"
            >
                <img src="@assets/images/event/storm_surge1.png" class="img-fluid rounded shadow m-3" style="height: 400px;">
                 <img src="@assets/images/event/storm_surge2.png" class="img-fluid rounded shadow m-3" style="height: 400px;">
                <p class="lead pt-3 text-justify text-muted fs-14 lh-base">
                    What is <b>Storm Surge?
                    (Also known as “Daluyong ng Bagyo”)</b> is the abnormal rise in sea level that occurs
                    during tropical cyclones or “bagyo”. It is caused by strong winds and low atmospheric
                    pressures produced by tropical cyclones. As the tropical cyclone approaches the coast,
                    strong winds push the ocean water over the low-lying coastal areas, which can lead to 
                    flooding. This makes storm surges very dangerous.
                </p>

                <p class="pt-2">
                For more information visit
                <a
                    href="https://www.pagasa.dost.gov.ph/information/storm-surge"
                    target="_blank"
                    rel="noopener noreferrer"
                ><u>DOST PAGASA Website</u></a>
                </p>

            </b-card>

            <b-card
                title="GeoRisk Philippines"
                data-aos="flip-left"
                data-aos-duration="5000"
                data-aos-delay="500"
                class="card-item text-center"
            >
                <img src="@assets/images/event/georisk1.png" class="img-fluid rounded shadow m-3" style="height: 400px;">
                <img src="@assets/images/event/georisk2.png" class="img-fluid rounded shadow m-3" style="height: 370px;">
               
                <p class="pt-2">
                For more information visit
                <a
                    href="https://georisk.gov.ph/"
                    target="_blank"
                    rel="noopener noreferrer"
                ><u>Georisk PH Website</u></a>
                </p>
            </b-card>

      
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