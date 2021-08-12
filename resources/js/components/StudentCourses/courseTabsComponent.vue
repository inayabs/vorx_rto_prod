<template>
    <div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a
                    :class="'nav-item nav-link-'+app_color+' active'"
                    data-toggle="tab"
                    :href="'#info'+this.$props.courses.id"
                    role="tab"
                    aria-controls="info"
                    aria-selected="true"
                >Info</a>
                <a
                    :class="'nav-item nav-link-'+app_color"
                    data-toggle="tab"
                    :href="'#class'+this.$props.courses.id"
                    role="tab"
                    aria-controls="info"
                    aria-selected="true"
                >Class</a>
                <a
                    :class="'nav-item nav-link-'+app_color"
                    data-toggle="tab"
                    :href="'#tt'+this.$props.courses.id"
                    role="tab"
                    aria-controls="info"
                    aria-selected="true"
                >Time table</a>
                <a
                    :class="'nav-item nav-link-'+app_color"
                    data-toggle="tab"
                    :href="'#docs'+this.$props.courses.id"
                    role="tab"
                    aria-controls="info"
                    aria-selected="true"
                >Documents</a>
                <!-- <a
                    :class="'nav-item nav-link-'+app_color"
                    data-toggle="tab"
                    :href="'#fees'+this.$props.courses.id"
                    role="tab"
                    aria-controls="info"
                    aria-selected="true"
                >Fees</a> -->
                
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div
            :class="'tab-pane fade show active'"
            :id="'info'+this.$props.courses.id"
            role="tabpanel"
            aria-labelledby="nav-info-tab"
            >
                <student-portal-domesticCourseDetails :course="this.$props.courses"/>
            </div>
            <div
            :class="'tab-pane fade'"
            :id="'class'+this.$props.courses.id"
            role="tabpanel"
            aria-labelledby="nav-info-tab"
            >
               <student-portal-classDetails :course="this.$props.courses"/>
            </div>
            <div
            :class="'tab-pane fade'"
            :id="'tt'+this.$props.courses.id"
            role="tabpanel"
            aria-labelledby="nav-info-tab"
            >
                <student-portal-timeTable :course="this.$props.courses"/>
            </div>
            <div
            :class="'tab-pane fade'"
            :id="'docs'+this.$props.courses.id"
            role="tabpanel"
            aria-labelledby="nav-info-tab"
            >
                <course-attachments :course="this.$props.courses"/>
            </div>
            <div
            :class="'tab-pane fade'"
            :id="'fees'+this.$props.courses.id"
            role="tabpanel"
            aria-labelledby="nav-info-tab"
            >
                <!-- <student-portal-studentFees :course="this.$props.courses"/> -->
            </div>
        </div>
    </div>
</template>
<script>
import domesticCourseDetails from './tabs/domesticCourseDetails.vue'
import classDetails from './tabs/classDetails.vue';
import timeTable from './tabs/timeTable.vue';
import courseAttachments from './tabs/courseAttachments.vue';
export default {
    name:'courseTabs',
    components:{
        domesticCourseDetails,
        classDetails  ,
        timeTable,
        courseAttachments
    },
    props:['courses'],
    data(){
        return{
            app_color:app_color
        }
    }
}
</script>