<template>
    <Head title="Calendar"/>
        <PageHeader title="Calendar Events" pageTitle="List" />
        <BRow>
            <div class="col-md-3">
                <div class="card shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3">
                                <div style="height:2.5rem;width:2.5rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-list-check-2 text-primary fs-24"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-14"><span class="text-body">Scheduled Activities</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-12">Official tasks, meetings, and engagements</p>
                            </div>
                            <div class="flex-shrink-0">
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-bottom bg-white">
                        <div class="align-items-center d-flex">
                            <h5 class="card-title text-dark mb-0 fs-13 fw-semibold flex-grow-1">
                                <span v-if="!showDue">Calendar Event's</span>
                                <span v-else>Calendar Due Dates</span>
                            </h5>
                            <div class="flex-shrink-0">
                                <div class="form-check form-switch form-switch-right form-switch-md">
                                    <label for="navbarscrollspy-showcode" class="form-label text-muted">
                                        <span v-if="!showDue">Other Events</span>
                                        <span v-else>Due Dates</span>
                                    </label>
                                    <input class="form-check-input code-switcher" v-model="showDue" type="checkbox" id="navbarscrollspy-showcode">
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>
            </div>
            <div class="col-md-9">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3">
                                <div style="height:2.5rem;width:2.5rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-calendar-todo-fill text-primary fs-24"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-14"><span class="text-body">Events and Schedules</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-12">A comprehensive list of campuses from various schools, providing location and institutional details</p>
                            </div>
                            <!-- <div class="flex-shrink-0" style="width: 45%;"></div> -->
                        </div>
                    </div>
                    <div class="card-body bg-white rounded-bottom">
                        <FullCalendar ref="fullCalendar" :options="calendarOptions" />
                    </div>
                </div>
            </div>
        </BRow>
    </template>
    <script>
    import _ from 'lodash';
    import "@fullcalendar/core";
    import dayGridPlugin from "@fullcalendar/daygrid";
    import timeGridPlugin from "@fullcalendar/timegrid";
    import listPlugin from "@fullcalendar/list";
    import FullCalendar from "@fullcalendar/vue3";
    import bootstrapPlugin from "@fullcalendar/bootstrap";
    import interactionPlugin, { Draggable } from "@fullcalendar/interaction";
    import Multiselect from "@vueform/multiselect";
    import PageHeader from '@/Shared/Components/PageHeader.vue';
    import Pagination from "@/Shared/Components/Pagination.vue";
    export default {
        components: { PageHeader, Pagination, Multiselect, FullCalendar, },
        data(){
            return {
                currentUrl: window.location.origin,
                lists: [],
                meta: {},
                links: {},
                filter: {
                    year: null,
                    semester: null
                },
                index: null,
                units: [],
                calendarOptions: {
                timeZone: "Asia/Manila",
                droppable: true,
                navLinks: true,
                plugins: [
                    dayGridPlugin,
                    timeGridPlugin,
                    interactionPlugin,
                    bootstrapPlugin,
                    listPlugin,
                ],
                themeSystem: "bootstrap",
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
                },
                windowResize: () => {
                    this.getInitialView();
                },
                initialView: this.getInitialView(),
                initialEvents: [],
                editable: true,
                showNonCurrentDates: false,
                fixedWeekCount: false,
                height: 'calc(100vh - 320px)',
                events: [],
                eventClick: this.editEvent,
            },
            }
        },
        watch: {
            "filter.semester"(newVal){
                this.fetch();
            },
            "filter.year"(newVal){
                this.checkSearchStr(newVal);
            }
        },
        created(){
           this.fetch();
        },
        methods: {
            checkSearchStr: _.debounce(function(string) {
                this.fetch();
            }, 300),
            fetch(page_url){
                page_url = page_url || '/surveys';
                axios.get(page_url,{
                    params : {
                        keyword: this.filter.keyword,
                        semester: this.filter.semester,
                        year: this.filter.year,
                        count: 10, //Math.floor((window.innerHeight-350)/59)
                        option: 'lists'
                    }
                })
                .then(response => {
                    if(response){
                        this.lists = response.data.data;
                        this.meta = response.data.meta;
                        this.links = response.data.links;          
                    }
                })
                .catch(err => console.log(err));
            },
            getInitialView() {
                if (window.innerWidth >= 768 && window.innerWidth < 1200) {
                    return "timeGridWeek";
                } else if (window.innerWidth <= 768) {
                    return "listMonth";
                } else {
                    return "dayGridMonth";
                }
            },
            openCreate(){
                this.$refs.create.show();
            }
        }
    }
    </script>