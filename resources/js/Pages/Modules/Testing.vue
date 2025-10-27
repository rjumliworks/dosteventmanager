<template>
<BRow>
    <div class="col-md-12">
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
                        <h5 class="mb-0 fs-14"><span class="text-body">Fakebook</span></h5>
                        <p class="text-muted text-truncate-two-lines fs-12">Logs and tracks recorded date and time entries for events, actions, or attendance.</p>
                    </div>
                    <div class="flex-shrink-0" style="width: 45%;">
                        
                    </div>
                </div>
            </div>
            <div class="car-body bg-white border-bottom shadow-none">
                <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                    <b-col lg>
                        <div class="input-group mb-1">
                            <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                            <input type="text" v-model="keyword" placeholder="Search Event" class="form-control" style="width: 70%;">
                           
                            <!-- <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                                <i class="bx bx-refresh search-icon"></i>
                            </span> -->
                            <b-button type="button" variant="primary" @click="openCreate">
                                <i class="ri-add-circle-fill align-bottom me-1"></i> Create
                            </b-button>
                        </div>
                    </b-col>
                </b-row>
            </div>
            <div class="card bg-white border-bottom shadow-none" no-body>
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <ul class="nav nav-tabs nav-tabs-custom nav-primary fs-12" role="tablist">
                            <li class="nav-item">
                                <BLink @click="viewStatus(null,null)" class="nav-link py-3 active" data-bs-toggle="tab" role="tab" aria-selected="true">
                                <i class="ri-apps-2-line me-1 align-bottom"></i> All Users
                                </BLink>
                            </li>
                        </ul>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body bg-white rounded-bottom">
                <div class="table-responsive table-card" style="margin-top: -39px; height: calc(100vh - 465px); overflow: auto;">
                    <table class="table align-middle table-centered mb-0">
                        <thead class="table-light thead-fixed">
                            <tr class="fs-11">
                                <th style="width: 3%;"></th>
                                <th>Email</th>
                                <th style="width: 7%;" class="text-center">Date</th>
                                <th style="width: 6%;"></th>
                            </tr>
                        </thead>
                        <tbody class="table-white fs-12">
                            <tr v-for="(list,index) in lists" v-bind:key="index">
                                <td class="text-center"> 
                                    {{ index+1 }}
                                </td>
                                <td>
                                    <h5 class="fs-13 mb-0 fw-semibold text-primary text-uppercase">{{list.email}}</h5>
                                </td>
                                <td class="text-center">{{ list.created_at }}</td>
                                
                                <td class="text-end">
                                    <b-button @click="openEdit(list,index)" variant="soft-warning" class="me-1" v-b-tooltip.hover title="Edit" size="sm">
                                        <i class="ri-pencil-fill align-bottom"></i>
                                    </b-button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</BRow>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            index: null,
        }
    },
    mounted() {
        this.setupEchoListener();
    },
    methods: {
        setupEchoListener() {
            window.Echo.channel('session')
            .listen('SessionEvent', (event) => {
                console.log(event);
                this.lists.unshift(event.data);
                // switch(event.type){
                //     case 'question':
                //         this.selected.questions.unshift(event.data);
                //     break;
                //     case 'register':
                //         this.selected.participants.unshift(event.data);
                //     break;
                //     case 'cancel':
                //         const index = this.selected.participants.findIndex(p => p.participant.code === event.data.participant.code);
                //         if (index !== -1) {
                //             this.selected.participants.splice(index, 1);
                //         }
                //     break;
                //     case 'attendance':
                //         const index2 = this.selected.participants.findIndex(p => p.code === event.data.code);
                //         this.selected.participants[index2] = event.data;
                //     break;
                // }
            });
        },
    }
}
</script>