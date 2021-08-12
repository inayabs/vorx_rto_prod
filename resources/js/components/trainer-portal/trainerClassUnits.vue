<template>
    <div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a
                :class="'nav-item nav-link-'+app_color+' active'"
                data-toggle="tab"
                :href="'#course1'+class_detail.id"
                role="tab"
                :aria-controls="'course1'"
                aria-selected="false"
                >
                Class Details
                </a>
                <a
                :class="'nav-item nav-link-'+app_color"
                data-toggle="tab"
                :href="'#course2'+class_detail.id"
                role="tab"
                :aria-controls="'course2'"
                aria-selected="false"
                >
                Attendance
                </a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div
                :class="'tab-pane fade show active'"
                :id="'course1'+class_detail.id"
                role="tabpanel"
                aria-labelledby="nav-info-tab"
                >
                <tportal-class-details :class_details="class_detail" @statusUpdate="statUp()"/>
                <!-- <student-portal-courseTabs :courses="courses[index]"/> -->
            </div>
            <div
                :class="'tab-pane'"
                :id="'course2'+class_detail.id"
                role="tabpane2"
                aria-labelledby="nav-info-tab"
                >
                <div v-if="units!=''">
                <tportal-attendance :units="units" :class_details="class_detail"/>
                    <!-- <div v-for="(u,index) in units" :key="index">
                        <tportal-class-attendance :unit="u" :i="index" :class_details="class_detail"/>
                    </div> -->
                </div>
                <div v-else>
                    No units assigned.
                </div>
                <!-- <student-portal-courseTabs :courses="courses[index]"/> -->
            </div>
        </div>
    </div> 
</template>
<script>
import classAttendance from "./classAttendanceComponent"
export default {
    props:['class_details'],
    name:'trainerClassUnits',
    components:{
        classAttendance  
    },
    data(){
        return{
            class_detail:this.$props.class_details,
            app_color:app_color,
            units:[]
        }
    },
    created(){
        this.getTrainerClassUnits();
    },
    methods:{
        statUp(){
            this.$emit('statUp');
        },
        getTrainerClassUnits(){
            axios.get("/classes/trainer-classes/"+this.class_detail.id+"/class-units").then(
                response=>{
                    this.units = response.data;
                }
            );
        },
        getAttendance(){
            console.log();
        }
    }
}
</script>