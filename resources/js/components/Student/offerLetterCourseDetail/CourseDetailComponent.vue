<template>
<div class="app-modal">
  <div class="row mb-2 d-flex justify-content-between">
      <div class="col-md-6">
        <a
          :href='"/student/"+student.id'
          v-bind:class="'btn btn-'+app_color+' btn-sm text-'+app_color+' text-light'"
        >
          <i class="fas fa-long-arrow-alt-left"></i> Back
        </a>
      </div>
    </div>
  <div>
   <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Class ({{student_id}} - {{student.party.name}})
          <a
              :href="'/student/'+student.id"
              :class="'btn btn-'+app_color+' text-primary btn-sm text-light'"
              style="padding: 0px 6px;"
            >
              <i class="fas fa-user fa-sm"></i>
            </a>
        </h6>
        
      </div>
        <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
         
          <li v-for="(detail, index) in course_detail" :key="detail.id"  class="nav-item">
            <a
              :class="['nav-link-'+app_color,{' active' : index == 0}]"
              :id="`${detail.course_code}-tab`"
              data-toggle="tab"
              :href="`#${detail.course_code}`"
              role="tab"
              aria-controls="home"
              aria-selected="true"
            >{{ detail.course_code}} ( {{ detail.status }} )</a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <!-- <div class="tab-pane fade mb-3" id="payments" role="tabpanel" aria-labelledby="payments-tab"></div> -->
          <info-component
            v-for="(detail, index) in course_detail"
            :key="detail.id"
            :class="{'tab-pane fade mb-3' : true,'show active': index == 0 }"
            :id="detail.course_code"
            role="tabpanel"
            :detail="detail"
            :aria-labelledby="`${detail.course_code}-tab`"
          ></info-component>
        </div>
      </div>
      </div>
  </div>
</div>
</template>
<script>
import InfoComponent from "./InfoComponent.vue";
export default {
  components: {
    InfoComponent
  },
  data() {
    return {
      course_detail: [],
      detail: [],
      student_id: window.student_id,
      app_color:app_color,
      student:window.student
    };
  },
  created() {
    this.getData();
  },
  methods: {
    getData() {
      let url = `/offer-letter/${window.offer}/course-detail/show`;
      axios
        .get(url)
        .then(response => {
          this.course_detail = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>