<template>
    <b-col lg="12">
        <b-card no-body>
            <div class="bg-success-subtle">
                <b-card-body class="pb-0 px-4">
                     <b-row class="mb-3">
                        <b-col md>
                            <b-row class="align-items-center g-3">
                                <b-col md>
                                    <div>
                                        <h4 class="fw-semibold text-success">{{ selected.title }}</h4>
                                        <div class="hstack gap-3 flex-wrap">
                                            <div><i class="ri-hashtag align-bottom me-1"></i>{{selected.code}}</div>
                                            <div class="vr" style="width: 1px;"></div>
                                            <div>Event : <span class="fw-medium">{{selected.event.name }}</span></div>
                                            <div class="vr" style="width: 1px;"></div>
                                            <!-- <div>Current Capacity : <span class="fw-medium">{{selected.detail.attendees}}/{{ selected.detail.capacity }}</span></div>
                                            <div class="vr" style="width: 1px;"></div> -->
                                            <div>Date : 
                                                <span class="fw-medium" v-if="selected.event.start == selected.event.end">{{selected.event.start}}</span>
                                                <span class="fw-medium" v-else>{{selected.event.start}} - {{selected.event.end}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="auto">
                            <div class="hstack gap-4 flex-wrap mt-2">
                                <Link href="/events">
                                    <div class="text-muted" @click="hide()">  
                                        <i class="ri-close-circle-fill fs-16"></i> Close
                                    </div>
                                </Link>
                                
                            </div>
                        </b-col>
                    </b-row>
                    
                </b-card-body>
            </div>
        </b-card>
    </b-col>
</template>
<script>
export default {
    props:['selected'],
    computed: {
        dateRangeText() {
            const schedules = this.selected?.schedules || [];

            if (schedules.length === 0) return 'No date';

            let start = schedules[0].date;
            let end = schedules[0].date;

            schedules.forEach(s => {
                if (s.date < start) start = s.date;
                if (s.date > end) end = s.date;
            });

            const formatDate = (dateStr) => {
                const date = new Date(dateStr);
                return date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            };

            return start === end
                ? formatDate(start)
                : `${formatDate(start)} - ${formatDate(end)}`;
        }
    }
}
</script>