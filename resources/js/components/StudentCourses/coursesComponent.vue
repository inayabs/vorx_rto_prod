<template>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 :class="'m-0 font-weight-bold text-'+app_color">
            My Courses
            </h6>
        </div>
        <div class="card-body">
            <div>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a v-for="(course,index) in courses" :key="course.id"
                        :class="'nav-item nav-link-'+app_color+' '+(index==0?'active':'')"
                        data-toggle="tab"
                        :href="'#course'+course.id"
                        role="tab"
                        :aria-controls="'course'+course.id"
                        aria-selected="false"
                        >
                        {{course.course.code}} - {{course.course.name}} 
                        <span class="badge badge-pill badge-secondary" v-if="course.status_id==1">Not Studying</span>
                        <span class="badge badge-pill badge-warning" v-else-if="course.status_id==2||course.status_id==3">Studying</span>
                        <span class="badge badge-pill badge-success" v-else-if="course.status_id==4">Finished</span>
                        </a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div
                        v-for="(course,index) in courses"
                        :key="course.id"
                        :class="'tab-pane fade'+(index==0?' show active':'')"
                        :id="'course'+course.id"
                        role="tabpanel"
                        aria-labelledby="nav-info-tab"
                        >
                        <student-portal-courseTabs :courses="courses[index]"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import courseTabs from './courseTabsComponent.vue';
export default {
    name:'MyCourses',
    components:{
        courseTabs
    },
    data(){
        return{
            app_color:app_color,
            student:window.student,
            courses:[]
        }
    },
    mounted(){
        this.getStudentCourses();
    },
    methods:{
        getStudentCourses(){
            // var student_type = this.student.student_type_id;

            // if(student_type==2){//domestic
                axios.get('/student_courses/getDomCourses/'+this.student.student_id).then(
                    response=>{
                        this.courses = response.data;
                    }
                );
            // }else if(student_type==1){//intl

            // }
        },
        getBadge(status_id){
            
        }
    }
}
</script>