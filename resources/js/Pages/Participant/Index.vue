<template>
<Head title="DOSTIX" />
    <div class="layout-wrapper landing">
        <div class="mobile-curved-header">
            <div class="bg-overlay bg-overlay-pattern"></div>
     
            <section class="section pb-0 " id="hero" style="margin-top: -28px;">
                <b-container>
                    <div class="profile-wrapper ms-2 me-2">
                        <div class="row g-2">
                            <div class="col-auto">
                                <div class="avatar-sm"><img :src="'/images/avatars/'+participant.avatar" alt="user-img" class="img-thumbnail rounded-circle"></div>
                            </div>
                            <div class="col">
                                <div class="p-2">
                                    <h4 class="fs-14 text-white text-uppercase fw-semibold mb-0">{{participant.firstname}} {{ participant.lastname }}</h4>
                                    <p class="fs-12 text-white">{{participant.contact_no}}</p>
                                    
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </b-container>
            </section>
        </div>
        <section class="bg-light p-3" style="margin-top: 80px;">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body p-2">
                        <div class="row align-items-center mt-3">
                            <div class="col-6">
                                <h6 class="text-muted text-uppercase fw-semibold text-truncate fs-14 mb-2">Total Points Garnered</h6>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-xs">
                                                <div class="avatar-title bg-primary-subtle text-primary rounded">
                                                    <i class="ri-trophy-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 ms-3 mt-1">
                                                <h4 class="fs- mb-0">0</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center"><img src="/images/logo-sm.png" class="img-fluid avatar-md float-end" alt=""></div>
                            </div>
                        </div>
                        <div class="mt-1 pt-2">
                            <div class="progress progress-lg rounded-pill">
                                <div class="progress-bar bg-primary rounded-0" role="progressbar" aria-valuenow="25" aria-valuemin="0"
                                    style="width: 25%;"></div>
                                <div class="progress-bar bg-info rounded-0" role="progressbar" aria-valuenow="18" aria-valuemin="0"
                                    style="width: 18%;"></div>
                                <div class="progress-bar bg-success rounded-0" role="progressbar" aria-valuenow="22" aria-valuemin="0"
                                    style="width: 22%;"></div>
                                <div class="progress-bar bg-warning rounded-0" role="progressbar" aria-valuenow="16" aria-valuemin="0"
                                    style="width: 16%;"></div>
                                <div class="progress-bar bg-danger rounded-0" role="progressbar" aria-valuenow="19" aria-valuemin="0"
                                    style="width: 19%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div data-simplebar class="mt-4" style="max-height: 215px;"> 
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 avatar-xs">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded">
                                            <i class="ri-walk-fill"></i>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-3 mt-2">
                                        <h6 class="fs-13 mb-0">Total Exhibits Visited</h6>
                                        <!-- <small class="text-muted">2 min Ago</small> -->
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="text-danger">0 / 3</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 avatar-xs">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded">
                                            <i class=" ri-calendar-2-fill"></i>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-3 mt-2">
                                        <h6 class="fs-13 mb-0">Total Sessions Registered</h6>
                                        <!-- <small class="text-muted">5 days Ago</small> -->
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="text-success">0 / 1</span>
                            </div>
                        </div>
                    </li>
                    <!-- <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="assets/images/users/avatar-2.jpg" alt="" class="avatar-xs rounded" />
                                    </div>
                                    <div class="flex-shrink-0 ms-2">
                                        <h6 class="fs-14 mb-0">Emily Slater</h6>
                                        <small class="text-muted">8 days Ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="text-success">$354.90</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 avatar-xs">
                                        <div class="avatar-title bg-secondary-subtle text-secondary rounded">
                                            <i class="ri-paypal-fill"></i>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-2">
                                        <h6 class="fs-14 mb-0">Paypal</h6>
                                        <small class="text-muted">1 month Ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="text-danger">-$12.22</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="assets/images/users/avatar-3.jpg" alt="" class="avatar-xs rounded" />
                                    </div>
                                    <div class="flex-shrink-0 ms-2">
                                        <h6 class="fs-14 mb-0">Harvey Wells</h6>
                                        <small class="text-muted">4 month Ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="text-success">-$459.78</span>
                            </div>
                        </div>
                    </li> -->
                </ul>
            </div>
            <hr class="text-muted"/>
             <video
                class="landing-video"
                src="/images/videos/teaser.mp4"
                autoplay
                muted
                loop
                playsinline
                controls
                >
            </video>


            <!-- <div class="card border">
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        <div class="avatar-sm">
                            <div class="avatar-title bg-light rounded-circle fs-20 text-primary">
                                <i class="bx bxs-window-alt"></i>
                            </div>
                        </div>
                        <div class="ms-3 mt-1">
                            <p class="fw-semibold fs-13 text-truncated mb-0">Total Exhibits Visited</p>
                            <h5 class="mb-0 text-muted fs-12">0 / 3</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border mt-n3">
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        <div class="avatar-sm">
                            <div class="avatar-title bg-light rounded-circle fs-20 text-primary">
                                <i class="bx bxs-window-alt"></i>
                            </div>
                        </div>
                        <div class="ms-3 mt-1">
                            <p class="fw-semibold fs-13 text-truncated mb-0">Total Sessions Registered</p>
                            <h5 class="mb-0 text-muted fs-12">0 / 1</h5>
                        </div>
                    </div>
                </div>
            </div> -->
        </section>
        <footer class="footer p-2" >
            <ul class="nav nav-pills nav-justified card-footer-tabs">
                <li class="nav-item">
                    <Link href="/participant" class="nav-link">
                        <i class="fs-20 ri-home-3-fill"></i>
                    </Link>
                </li>
                <li class="nav-item">
                    <Link href="/exhibits" class="nav-link">
                        <i class="fs-20 ri-file-text-fill"></i>
                    </Link>
                </li>
                <li class="nav-item">
                    <Link href="/qrcode" class="nav-link">
                        <button class="btn btn-primary btn-md position-relative p-0 avatar-md rounded-circle" style="margin-top: -55px;" type="button">
                            <div class="btn-content">
                                <span class="avatar-title bg-transparent text-reset">
                                    <i class='fs-24 ri-qr-code-line'></i>
                                </span>
                            </div>
                        </button>
                    </Link>
                </li>
                <li class="nav-item">
                    <Link href="/schedules" class="nav-link">
                        <i class="fs-20 ri-calendar-fill"></i>
                    </Link>
                </li>
                <li class="nav-item">
                    <Link href="/settings" class="nav-link">
                        <i class='fs-20 ri-settings-4-fill'></i>
                    </Link>
                </li>
            </ul>
        </footer>
        <b-button variant="danger" @click="topFunction" class="btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </b-button>
  </div>
</template>
<script>
import Mobile from './Footer/Mobile.vue';
import Web from './Footer/Web.vue';
export default {
    components: { Mobile, Web },
    layout: null,
    data(){
        return {
            participant: this.$page.props.participant.data,
            isMobile: false,
        }
    },
    methods: {
        async logout() {
            try {
                await axios.get('/participant/logout')
                window.location.href = '/participant/login' // redirect manually after logout
            } catch (error) {
                console.error('Logout failed:', error)
            }
        },
        topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        },
        checkDevice() {
            this.isMobile = window.innerWidth <= 768;
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

        this.checkDevice();
        window.addEventListener('resize', this.checkDevice);
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.checkDevice);
    },
}
</script>
<style scoped>
    .footer {
        left: 0;
        position: fixed;
        border-top: .1rem solid;
        border-color: #e4e2e2;
    }
    .mobile-curved-header {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 95px;
        background: linear-gradient(to bottom, #405189 0%, #2f3a58 100%);
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
        z-index: 0;
        overflow: hidden;
    }
.landing-video {
  width: 100%;
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
</style>