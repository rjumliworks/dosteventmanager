<script setup>
import { router } from '@inertiajs/vue3';
import { layoutMethods } from "@/Shared/State/helpers";
const logout = () => {
  router.post('/logout');
};
</script>

<script>
import simplebar from "simplebar-vue";
export default {
  data() {
    return {
      currentUrl: window.location.origin,
      text: null,
      value: null,
      myVar: 1,
    };
  },
  components: {
    simplebar
  },

  methods: {
    ...layoutMethods,
    toggleHamburgerMenu() {
      var windowSize = document.documentElement.clientWidth;
      let layoutType = document.documentElement.getAttribute("data-layout");

      document.documentElement.setAttribute("data-sidebar-visibility", "show");
      let visiblilityType = document.documentElement.getAttribute("data-sidebar-visibility");

      if (windowSize > 767)
        document.querySelector(".hamburger-icon").classList.toggle("open");

      //For collapse horizontal menu
      if (
        document.documentElement.getAttribute("data-layout") === "horizontal"
      ) {
        document.body.classList.contains("menu") ?
          document.body.classList.remove("menu") :
          document.body.classList.add("menu");
      }

      //For collapse vertical menu

      if (visiblilityType === "show" && (layoutType === "vertical" || layoutType === "semibox")) {
        if (windowSize < 1025 && windowSize > 767) {
          document.body.classList.remove("vertical-sidebar-enable");
          document.documentElement.getAttribute("data-sidebar-size") == "sm" ?
            document.documentElement.setAttribute("data-sidebar-size", "") :
            document.documentElement.setAttribute("data-sidebar-size", "sm");
        } else if (windowSize > 1025) {
          document.body.classList.remove("vertical-sidebar-enable");
          document.documentElement.getAttribute("data-sidebar-size") == "lg" ?
            document.documentElement.setAttribute("data-sidebar-size", "sm") :
            document.documentElement.setAttribute("data-sidebar-size", "lg");
        } else if (windowSize <= 767) {
          document.body.classList.add("vertical-sidebar-enable");
          document.documentElement.setAttribute("data-sidebar-size", "lg");
        }
      }

      //Two column menu
      if (document.documentElement.getAttribute("data-layout") == "twocolumn") {
        document.body.classList.contains("twocolumn-panel") ?
          document.body.classList.remove("twocolumn-panel") :
          document.body.classList.add("twocolumn-panel");
      }
    },
    toggleMenu() {
      this.$parent.toggleMenu();
    },
    toggleRightSidebar() {
      this.$parent.toggleRightSidebar();
    },
    initFullScreen() {
      document.body.classList.toggle("fullscreen-enable");
      if (
        !document.fullscreenElement &&
        /* alternative standard method */
        !document.mozFullScreenElement &&
        !document.webkitFullscreenElement
      ) {
        // current working methods
        if (document.documentElement.requestFullscreen) {
          document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
          document.documentElement.webkitRequestFullscreen(
            Element.ALLOW_KEYBOARD_INPUT
          );
        }
      } else {
        if (document.cancelFullScreen) {
          document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        }
      }
    },
    toggleDarkMode() {

      if (document.documentElement.getAttribute("data-bs-theme") == "dark") {
        document.documentElement.setAttribute("data-bs-theme", "light");
      } else {
        document.documentElement.setAttribute("data-bs-theme", "dark");
      }

      const mode = document.documentElement.getAttribute("data-bs-theme")
      this.changeMode({
        mode: mode,
      });
    },
    removeItem(cartItem) {
      this.cartItems = this.cartItems.filter(item => item.id !== cartItem.id)
      this.$emit("cart-item-price", this.cartItems.length);
    },
    openInNewTab(url) {
      window.open(url, '_blank');
    }
  },

  mounted() {
    document.addEventListener("scroll", function () {
      var pageTopbar = document.getElementById("page-topbar");
      if (pageTopbar) {
        document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50 ? pageTopbar.classList.add(
          "topbar-shadow") : pageTopbar.classList.remove("topbar-shadow");
      }
    });
    if (document.getElementById("topnav-hamburger-icon"))
      document.getElementById("topnav-hamburger-icon").addEventListener("click", this.toggleHamburgerMenu);

  },
};
</script>

<template>
  <header id="page-topbar">
    <div class="layout-width">
      <div class="navbar-header">
        <div class="d-flex">
          <!-- LOGO -->
          <div class="navbar-brand-box horizontal-logo">
            <Link href="/" class="logo logo-dark">
              <span class="logo-sm">
                <img src="@assets/images/logo-sm.png" alt="" height="22" />
              </span>
              <span class="logo-lg">
                <img src="@assets/images/logo-dark.png" alt="" height="25" />
              </span>
            </Link>

            <Link href="/" class="logo logo-light">
              <span class="logo-sm">
                <img src="@assets/images/logo-sm.png" alt="" height="22" />
              </span>
              <span class="logo-lg">
                <img src="@assets/images/logo-light.png" alt="" height="25" />
              </span>
            </Link>
          </div>

          <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
            id="topnav-hamburger-icon">
            <span class="hamburger-icon">
              <span></span>
              <span></span>
              <span></span>
            </span>
          </button>

        </div>

        <div class="d-flex align-items-center">
          <BDropdown class="dropdown d-md-none topbar-head-dropdown header-item" variant="ghost-secondary" dropstart
            :offset="{ alignmentAxis: 55, crossAxis: 15, mainAxis: 0 }"
            toggle-class="btn-icon btn-topbar rounded-circle arrow-none"
            menu-class="dropdown-menu-lg dropdown-menu-end p-0">
            <template #button-content>
              <i class="bx bx-search fs-22"></i>
            </template>
            <BDropdownItem aria-labelledby="page-header-search-dropdown">
              <form class="p-3">
                <div class="form-group m-0">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username" />
                    <BButton variant="primary" type="submit">
                      <i class="mdi mdi-magnify"></i>
                    </BButton>
                  </div>
                </div>
              </form>
            </BDropdownItem>
          </BDropdown>

          <!-- <BDropdown class="dropdown" variant="ghost-secondary" dropstart
            :offset="{ alignmentAxis: 55, crossAxis: 15, mainAxis: -50 }"
            toggle-class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle arrow-none"
            menu-class="dropdown-menu-end">
          
            <BLink href="javascript:void(0);" class="dropdown-item notify-item language py-2"
              v-for="(entry, key) in languages" :data-lang="entry.language" :title="entry.title"
              @click="setLanguage(entry.language, entry.title, entry.flag)" :key="key">
              <img :src="entry.flag" alt="user-image" class="me-2 rounded" height="18">
              <span class="align-middle">{{ entry.title }}</span>
            </BLink>
          </BDropdown> -->

          <BDropdown class="dropdown" variant="ghost-secondary" dropstart
            :offset="{ alignmentAxis: 57, crossAxis: 0, mainAxis: -42 }"
            toggle-class="btn-icon btn-topbar rounded-circle mode-layout ms-1 arrow-none"
            menu-class="p-0 dropdown-menu-end">
            <template #button-content>
              <i class="bx bx-category-alt fs-22"></i>
            </template>
            <div class="p-3 border-top-0 dropdown-head border-start-0 border-end-0 border-dashed border dropdown-menu-lg">
              <BRow class="align-items-center">
                <BCol>
                  <h6 class="m-0 fw-semibold fs-15">Web Apps</h6>
                </BCol>
                <BCol cols="auto">
                  <BLink href="#!" class="btn btn-sm btn-soft-info">
                    View 
                    <i class="ri-arrow-right-s-line align-middle"></i>
                  </BLink>
                </BCol>
              </BRow>
            </div>

            <div class="p-2">
              <BRow class="g-0">
                <BCol>
                  <BLink class="dropdown-icon-item" @click="openInNewTab('/dashboard')">
                    <img src="@assets/images/apps/laboratory.png" alt="lab"/>
                    <span>HRMIS</span>
                  </BLink>
                </BCol>
                <BCol>
                  <BLink class="dropdown-icon-item" @click="openInNewTab('/inventory')">
                    <img src="@assets/images/apps/inventory.png" alt="invent" />
                    <span>TRACE</span>
                  </BLink>
                </BCol>
                <BCol>
                  <BLink class="dropdown-icon-item" @click="openInNewTab('/calendar')">
                    <img src="@assets/images/apps/calendar.png" alt="chatbox" />
                    <span>VRAMS</span>
                  </BLink>
                </BCol>
              </BRow>
              <!-- <BRow class="g-0">
                <BCol>
                  <BLink class="dropdown-icon-item" @click="openInNewTab('/services')">
                    <img src="@assets/images/apps/testservices.png" alt="test" />
                    <span>Services</span>
                  </BLink>
                </BCol>
                <BCol>
                  <BLink class="dropdown-icon-item" @click="openInNewTab('/inventory')">
                    <img src="@assets/images/apps/referral.png" alt="bitbucket" />
                    <span>Referral</span>
                  </BLink>
                </BCol>
                <BCol>
                  <BLink class="dropdown-icon-item" @click="openInNewTab('/chatbox')">
                    <img src="@assets/images/apps/chatbox.png" alt="dribbble" />
                    <span>Chatbox</span>
                  </BLink>
                </BCol>
              </BRow> -->
            </div>
          </BDropdown> 

       

          <div class="ms-1 header-item d-none d-sm-flex">
            <BButton type="button" variant="ghost-secondary" class="btn-icon btn-topbar rounded-circle"
              data-toggle="fullscreen" @click="initFullScreen">
              <i class="bx bx-fullscreen fs-22"></i>
            </BButton>
          </div>

          <div class="ms-1 header-item d-none d-sm-flex">
            <BButton type="button" variant="ghost-secondary" class="btn-icon btn-topbar rounded-circle light-dark-mode"
              @click="toggleDarkMode">
              <i class="bx bx-moon fs-22"></i>
            </BButton>
          </div>

          <!-- <BDropdown variant="ghost-dark" dropstart class="ms-1 dropdown"
            :offset="{ alignmentAxis: 57, crossAxis: 0, mainAxis: -42 }"
            toggle-class="btn-icon btn-topbar rounded-circle arrow-none" id="page-header-notifications-dropdown"
            menu-class="dropdown-menu-lg dropdown-menu-end p-0" auto-close="outside">
            <template #button-content>
              <i class='bx bx-bell fs-22'></i>
              <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"><span
                  class="notification-badge">3</span><span class="visually-hidden">unread
                  messages
                </span>
              </span>
            </template>
            <div class="dropdown-head bg-primary bg-pattern rounded-top dropdown-menu-lg">
              <div class="p-3">
                <BRow class="align-items-center">
                  <BCol>
                    <h6 class="m-0 fs-16 fw-semibold text-white">
                      Notifications
                    </h6>
                  </BCol>
                  <BCol cols="auto" class="dropdown-tabs">
                    <BBadge variant="light-subtle" class="bg-light-subtle text-body fs-13"> 4 New</BBadge>
                  </BCol>
                </BRow>
              </div>
            </div>
            <BTabs nav-class="dropdown-tabs nav-tab-custom bg-primary px-2 pt-2">
              <BTab title=" All (4) " class="tab-pane fade py-2 ps-2 show" id="all-noti-tab" role="tabpanel">
                <simplebar data-simplebar style="max-height: 300px" class="pe-2">
                  <div class="text-reset notification-item d-block dropdown-item position-relative">
                    <div class="d-flex">
                      <div class="avatar-xs me-3 flex-shrink-0">
                        <span class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                          <i class="bx bx-badge-check"></i>
                        </span>
                      </div>
                      <div class="flex-grow-1">
                        <BLink href="#!" class="stretched-link">
                          <h6 class="mt-0 mb-2 lh-base">
                            Your <b>Elite</b> author Graphic Optimization
                            <span class="text-secondary">reward</span> is
                            ready!
                          </h6>
                        </BLink>
                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                          <span><i class="mdi mdi-clock-outline"></i> Just 30 sec ago</span>
                        </p>
                      </div>
                      <div class="px-2 fs-15">
                        <input class="form-check-input" type="checkbox" />
                      </div>
                    </div>
                  </div>

                  

                  <div class="text-reset notification-item d-block dropdown-item position-relative">
                    <div class="d-flex">
                      <div class="avatar-xs me-3 flex-shrink-0">
                        <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-16">
                          <i class="bx bx-message-square-dots"></i>
                        </span>
                      </div>
                      <div class="flex-grow-1">
                        <BLink href="#!" class="stretched-link">
                          <h6 class="mt-0 mb-2 fs-13 lh-base">
                            You have received <b class="text-success">20</b> new messages in the conversation
                          </h6>
                        </BLink>
                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                          <span><i class="mdi mdi-clock-outline"></i> 2 hrs
                            ago</span>
                        </p>
                      </div>
                      <div class="px-2 fs-15">
                        <input class="form-check-input" type="checkbox" />
                      </div>
                    </div>
                  </div>

                  <div class="my-3 text-center">
                    <BButton type="button" variant="soft-success">
                      View All Notifications
                      <i class="ri-arrow-right-line align-middle"></i>
                    </BButton>
                  </div>
                </simplebar>
              </BTab>

              <BTab title="Requests" class="tab-pane fade py-2 ps-2" id="messages-tab" role="tabpanel"
                aria-labelledby="messages-tab">
                <simplebar data-simplebar style="max-height: 300px" class="pe-2">
                  

                  <div class="my-3 text-center">
                    <BButton type="button" variant="soft-success">
                      View All Requests
                      <i class="ri-arrow-right-line align-middle"></i>
                    </BButton>
                  </div>
                </simplebar>
              </BTab>

              <BTab title="Referrals" class="p-4">
                <simplebar data-simplebar style="max-height: 300px" class="pe-2">
                  <div class="w-25 w-sm-50 pt-3 mx-auto">
                  </div>
                  <div class="text-center pb-5 mt-2">
                    <h6 class="fs-14 fw-semibold lh-base">
                      Hey! You have no any referrals
                    </h6>
                  </div>
                </simplebar>
              </BTab>
            </BTabs>
          </BDropdown> -->

          <BDropdown variant="link" class="ms-sm-3 header-item topbar-user" toggle-class="rounded-circle arrow-none" menu-class="dropdown-menu-end" :offset="{ alignmentAxis: -14, crossAxis: 0, mainAxis: 0 }">
            <template #button-content>
              <span class="d-flex align-items-center">
                <img class="rounded-circle header-profile-user" :src="$page.props.user.data.avatar" :alt="$page.props.user.data.username">
                <span class="text-start ms-xl-2">
                  <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ $page.props.user.data.name }}</span>
                  <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">Staff</span>
                </span>
              </span>
            </template>
            <h6 class="dropdown-header fs-10">Welcome {{ $page.props.user.data.username }}!</h6>
            <Link class="dropdown-item" href="/profile"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle"> Profile</span>
            </Link>
              <Link class="dropdown-item" href="/DTR"><i class="ri-calendar-todo-fill text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle"> DTR</span>
            </Link>
            <div class="dropdown-divider"></div>
            <Link class="dropdown-item" href="/confirm-password"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle"> Lock screen</span>
            </Link>

            <!-- Authentication -->
            <form method="POST" @submit.prevent="logout" class="dropdown-item">
              <BButton variant="none" type="submit" class="btn p-0"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> Logout</BButton>
            </form>
          </BDropdown>
        </div>
      </div>
    </div>
  </header>
</template>