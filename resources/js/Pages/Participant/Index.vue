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
                                <div class="avatar-sm"><img src="/images/avatars/avatar.jpg" alt="user-img" class="img-thumbnail rounded-circle"></div>
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
        <div class="row">
            
        </div>
       

        <footer class="footer p-2" >
            <ul class="nav nav-pills nav-justified card-footer-tabs">
                <li class="nav-item">
                    <Link href="/participant" class="nav-link">
                        <i class="fs-20 ri-home-3-fill"></i>
                    </Link>
                </li>
                <li class="nav-item">
                    <Link href="/sessions" class="nav-link">
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
<style>
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

</style>