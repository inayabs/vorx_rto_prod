<template>
    <div>
        <div class="row mb-2 d-flex justify-content-between">
        
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">
                    My Classes
                </h6>
            </div>
            <div class="card-body" v-if="appointed_classes!=''">
                <div>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a v-for="(ap,index) in appointed_classes" :key="ap.id"
                            :class="'nav-item nav-link-'+app_color+' '+(index==0?'active':'')"
                            data-toggle="tab"
                            :href="'#course'+ap.id"
                            role="tab"
                            :aria-controls="'course'+ap.id"
                            aria-selected="false"
                            >
                            {{ap.desc}} - {{ap.course_code}} 
                            <span class="badge badge-pill badge-secondary" v-if="ap.class_status=='Not yet taken'">Not yet taken</span>
                            <span class="badge badge-pill badge-warning" v-else-if="ap.class_status=='Ongoing'">Ongoing</span>
                            <span class="badge badge-pill badge-success" v-else-if="ap.class_status=='Finish'">Finished</span>
                            </a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div
                            v-for="(ap,index) in appointed_classes"
                            :key="ap.id"
                            :class="'tab-pane fade'+(index==0?' show active':'')"
                            :id="'course'+ap.id"
                            role="tabpanel"
                            aria-labelledby="nav-info-tab"
                            >
                            <tportal-class-units :class_details="ap" @statUp="statUp()"/>
                            <!-- <student-portal-courseTabs :courses="courses[index]"/> -->
                        </div>
                    </div>
                </div>
                <!-- <div class="accordion" id="accordion1">
                    <div class="card-header" id="heading1">
                        <h2 class="mb-0">
                            <button
                            class="btn btn-link collapsed"
                            type="button"
                            data-toggle="collapse"
                            :data-target="'#collapse1'"
                            aria-expanded="false"
                            :aria-controls="'collapse1'"
                            >Ka trainer vuh</button>
                        </h2>
                    </div>
                    <div
                    :id="'collapse1'"
                    class="collapse"
                    :aria-labelledby="'heading1'"
                    :data-parent="'#accordion1'"
                    >
                        <div class="card-body">
                            hahah
                        </div>
                    </div>
                </div> -->
            </div>
            <div v-else class="card-body">
                No Classes were assigned yet.
            </div>
        </div>
    </div>
</template>
<script>
import trainerClassUnits from "./trainerClassUnits";
export default {
    components:{
        trainerClassUnits
    },
    data(){
        return{
            app_color:app_color,
            appointed_classes:[],
            trainer:window.trainer
        }
    },
    mounted(){
        this.get_classes();
    },
    methods:{
        statUp(){
            this.get_classes(); 
        },
        get_classes(){
            axios.get('/classes/trainer-classes/'+this.trainer.id+'/gettrainerclasses').then(
                response=>{
                    this.appointed_classes = response.data;
                }
            ).catch();
        }
    }
}
</script>