<template>
    <Head title="Log in"/>
    <div class="landing-wrapper">
        <div class="auth-page-content registration_bg">
            <!-- Full-height container to center content -->
            <BContainer fluid class="min-vh-100 d-flex justify-content-center align-items-center">
                <BRow class="justify-content-center w-100">
                    <BCol md="4" lg="5" xl="5">
                        <BCard no-body variant="light">
                            <BCardBody class="p-4">

                                <!-- Event Title -->
                                <div class="row mb-4 justify-content-center">
                                    <div class="text-primary mt-1">
                                        <img src="@assets/images/event/event_title2.png"
                                             alt=""
                                             class="img-fluid">
                                    </div>
                                </div>

                                <!-- Registration Success Message -->
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img class="bx-tada"
                                             src="@assets/images/event/solido.png"
                                             alt=""
                                             style="width:auto; height:100px;">
                                    </div>
                                    <div class="flex-grow-1 ms-4 mt-3">
                                        <h6 class="mb-0 fs-16 text-success text-uppercase fw-semibold">
                                            Registration Successful!
                                        </h6>
                                        <p class="fs-12 mt-2 mb-0 text-muted">
                                            Thank you for registering. <br />
                                            Your information has been submitted successfully!
                                        </p>
                                    </div>
                                </div>

                                <!-- Mobile App Login Notice -->
                                <div class="alert alert-info mt-4">
                                    <strong class="d-block mb-2 text-center">
                                        Mobile App Login (Coming Soon)
                                    </strong>
                                    <p class="mb-2 text-muted small text-center">
                                        Our iOS and Android apps are still under review and will be released soon. <br />
                                        Once available, you can log in by following these steps:
                                    </p>
                                    <ul class="mb-0">
                                        <li>
                                            Open the <strong>Event Mobile App</strong> on iOS or Android.
                                        </li>
                                        <li>
                                            Enter the <strong>email address</strong> you used during registration.
                                        </li>
                                        <li>
                                            Receive a <strong>One-Time Password (OTP)</strong> sent to your email.
                                        </li>
                                        <li>
                                            Enter the OTP to securely access your account.
                                        </li>
                                    </ul>
                                </div>

                                <!-- 🚨 Danger/Release Announcement -->
                                <div class="alert alert-danger mt-3 mb-0 text-center">
                                    <strong>App Release Announcement</strong><br>
                                    When the iOS and Android apps are officially launched,
                                    the download links will be posted here.
                                </div>

                            </BCardBody>
                        </BCard>
                    </BCol>
                </BRow>
            </BContainer>
        </div>
    </div>
</template>

<script>
export default {
    layout: null,
    data() {
        return {
            showModal: false,
        }
    }
}
</script>

<style scoped>
.landing-wrapper {
  width: 100%;
  display: flex;
  flex-direction: column;
}

.auth-page-content {
  flex: 1; /* takes remaining height */
  display: flex;
  flex-direction: column;
}
</style>
