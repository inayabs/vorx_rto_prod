<template>
  <div>
    <div class="card">
      <div class="card-header" :id="`headingOne${offerid}`">
        <h2 class="mb-0">
          <button
            v-if="courses[0]['package_id'] != null"
            class="btn btn-link"
            type="button"
            data-toggle="collapse"
            :data-target="`#collapseOne${offerid}`"
            aria-expanded="false"
            :aria-controls="`collapseOne${offerid}`"
          >Package: ( {{ courses[0]['package']['description'] }} )</button>
          <button
            v-else
            class="btn btn-link"
            type="button"
            data-toggle="collapse"
            :data-target="`#collapseOne${offerid}`"
            aria-expanded="false"
            :aria-controls="`collapseOne${offerid}`"
          >Non-Package: ( {{ courses[0]['course_matrix'].detail.code }} - {{ courses[0]['course_matrix'].detail.name }} )</button>
        </h2>
      </div>
      <div
        :id="`collapseOne${offerid}`"
        :class="{'collapse':true ,'show' : offerid == refs.id}"
        :aria-labelledby="`headingOne${offerid}`"
        data-parent="#accordionExample"
      >
        <div class="card-body" v-if="courses[0]['package_id'] != null">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li v-for="(course, index) in course_list" :key="index" class="nav-item">
              <a
                :class="[index == 0 ? 'active' : true, 'nav-item nav-link-'+app_color+' act' ]"
                id="personal-info-tab"
                data-toggle="tab"
                :href="`#${course.course_code}-${course.id}-info`"
                role="tab"
                aria-controls="personal-info"
                aria-selected="true"
              >{{ course.course_code }}</a>
            </li>
          </ul>
          <!-- <pre>{{ courses }}</pre> -->
          <div class="tab-content" id="myTabContent">
            <detail
              v-for="(course, index) in course_list"
              :key="course.id"
              :class="{'tab-pane fade mb-3' : true,'show active': index == 0 }"
              :course="course"
              :subjects="course.courseSubjects"
              :extraUnits="course.courseExtraUnits"
              :extraUnitsval="course.slct_extraUnits_val"
              :id="`${course.course_code}-${course.id}-info`"
            ></detail>
            <!-- <detail
              v-for="(course, index) in courses"
              :key="course.id"
              :class="{'tab-pane fade mb-3' : true,'show active': index == 0 }"
              role="tabpanel"
              :course="course"
              :student_details="offer"
              :id="`${course.course_code}-${course.id}-info`"
            ></detail>-->
          </div>
        </div>
        <div class="card-body" v-else>
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li v-for="(course, index) in course_list" :key="index" class="nav-item">
              <a
                :class="[index == 0 ? 'active' : true, 'nav-item nav-link-'+app_color+' act' ]"
                id="personal-info-tab"
                data-toggle="tab"
                :href="`#${course.course_code}-${course.id}-info`"
                role="tab"
                aria-controls="personal-info"
                aria-selected="true"
              >{{ course.course_code }}</a>
            </li>
          </ul>
          <!-- <pre>{{ courses }}</pre> -->
          <div class="tab-content" id="myTabContent">
            <detail
              v-for="(course, index) in course_list"
              :key="course.id"
              :class="{'tab-pane fade mb-3' : true,'show active': index == 0 }"
              :course="course"
              :subjects="course.courseSubjects"
              :extraUnits="course.courseExtraUnits"
              :extraUnitsval="course.slct_extraUnits_val"
              :id="`${course.course_code}-${course.id}-info`"
            ></detail>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import detail from "./courseDetailComponent.vue";
export default {
  components: { detail },
  props: ["courses", "refs", "offerid", "offer"],
  data() {
    return {
      app_color: app_color,
      wh_List: [],
      course_list: [],
    };
  },
  mounted() {
    this.getCourse();
  },
  methods: {
    getCourse() {
      if(this.courses[0]['package_id'] == null){
        axios({
          method: "get",
          url: `/student/getCourse/${window.student_id}/${this.courses[0].id}`,
        })
          .then((res) => {
            let vm = this;
            vm.wh_List = res.data.warningLetterList.reverse();
            vm.course_list = res.data.course_details.reverse();
          })
          .catch((err) => console.log(err));
      }else{
        let ids = [];
            this.courses.forEach(element => {
            ids.push(element.id);
          });
          axios({
          method: "get",
          url: `/student/getCourse/${window.student_id}/${ids}`,
        })
          .then((res) => {
            let vm = this;
            vm.wh_List = res.data.warningLetterList.reverse();
            vm.course_list = res.data.course_details.reverse();
          })
          .catch((err) => console.log(err));
        }
      
    },
  },
};
</script>