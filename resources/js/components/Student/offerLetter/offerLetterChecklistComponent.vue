<template>
  <div>
     <div class="row mb-3">
        <div class="col-md-12 pull-right text-right">
          <button class="btn btn-success" @click="saveChanges()">
            <i class="far fa-save"></i> Save Changes
          </button>
        </div>
      </div>
    <div class="row justify-content-md-center">
      <div class="col-md-8">
        <ul class="list-group">
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                v-model="checklist.c1[1]"
                true-value="1"
                class="custom-control-input"
                :id="`${checknumber}c1`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c1`"
              >Complete ETI International Student Enrolment Form</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                v-model="checklist.c1[2]"
                true-value="1"
                class="custom-control-input"
                :id="`${checknumber}c2`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c2`"
              >Please make sure that form has got all the information filled in for student</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c1[3]"
                true-value="1"
                :id="`${checknumber}c3`"
              />
              <label class="custom-control-label" :for="`${checknumber}c3`">Passport copy</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                v-model="checklist.c1[4]"
                true-value="1"
                class="custom-control-input"
                :id="`${checknumber}c4`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c4`"
              >Details of all academic studies in the past, including High School graduation certificate, Diploma or university degree transcripts. If the document is not written in English, please provide a certified English Language Translation.</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                v-model="checklist.c1[5]"
                true-value="1"
                class="custom-control-input"
                :id="`${checknumber}c5`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c5`"
              >Any evidence of English language proficiency such as IELTS, TOEFL, Cambridge or Pearson English Test results/Evidence of achieving the required ACSF level in LLN test (copy of the checked LLN test)</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                v-model="checklist.c1[6]"
                true-value="1"
                class="custom-control-input"
                :id="`${checknumber}c6`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c6`"
              >If the student does not have any official English test results, student will need to write LLN test.</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                v-model="checklist.c1[7]"
                true-value="1"
                class="custom-control-input"
                :id="`${checknumber}c7`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c7`"
              >LLN test and Pre training review will be done before the training commencement.</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                v-model="checklist.c1[8]"
                true-value="1"
                class="custom-control-input"
                :id="`${checknumber}c8`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c8`"
              >If the student is onshore and has completed any certificate IV level or higher qualification from Australia, the student will need to give the copy of the qualification. This will address the English Requirements.</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                v-model="checklist.c1[9]"
                true-value="1"
                class="custom-control-input"
                :id="`${checknumber}c9`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c9`"
              >Any gap in the study needs to be justified by providing the documents ( if applicable )</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c1[10]"
                true-value="1"
                :id="`${checknumber}c10`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c10`"
              >In case of con current COE's, if the student is studying somewhere else as well/student declaration/verification form ( for concurrent courses )</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c1[11]"
                true-value="1"
                :id="`${checknumber}c12`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c12`"
              >SSVF financial assessment has been done and the student meets the requirements.</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c1[12]"
                true-value="1"
                :id="`${checknumber}c13`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c13`"
              >(Does not apply for short courses and onshore student)</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c1[13]"
                true-value="1"
                :id="`${checknumber}c14`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c14`"
              >A statement addressing Genuine Temporary Entrant Criteria has been given and has been checked by ETI delegate (We can waive it for short courses like security) and onshore)</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                :id="`${checknumber}c15`"
                v-model="checklist.c1[14]"
                true-value="1"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c15`"
              >CT/RPL checked if Applicable( if CT has been granted the CT must be updated on the VETtrek and timetable must be in the file and copy given to the student before the training commencement.</label>
            </div>
          </li>
          <li
            class="list-group-item active"
          >Please note ETI cannot issue any COE and offer letter (except conditional offer letter) without the above documents. You are reminded that you CANNOT use conditional offer letter to apply for a visa.</li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c2[1]"
                true-value="1"
                :id="`${checknumber}c16`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c16`"
              >CoE will only be issued if the following documents are in place:</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c2[2]"
                true-value="1"
                :id="`${checknumber}c17`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c17`"
              >Evidence of minimum payment – receipt from the bank</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c2[3]"
                true-value="1"
                :id="`${checknumber}c18`"
              />
              <label class="custom-control-label" :for="`${checknumber}c18`">Invoice from the Agent</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c2[4]"
                true-value="1"
                :id="`${checknumber}c19`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c19`"
              >SIGNED OFFER LETTER AND ENROLMENT ACCEPTANCE</label>
            </div>
          </li>
          <li class="list-group-item active">Orientation Docs</li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c3[1]"
                true-value="1"
                :id="`${checknumber}c20`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c20`"
              >Student Induction Checklist</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c3[2]"
                true-value="1"
                :id="`${checknumber}c21`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c21`"
              >Receipt of Student Handbook/Acknowledgement of receipt of Student Handbook and Preenrolment information</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c3[3]"
                true-value="1"
                :id="`${checknumber}c22`"
              />
              <label class="custom-control-label" :for="`${checknumber}c22`">LLN Test</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c3[4]"
                true-value="1"
                :id="`${checknumber}c23`"
              />
              <label class="custom-control-label" :for="`${checknumber}c23`">Pre-Training Review</label>
            </div>
          </li>
          <li class="list-group-item active">Academics</li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c4[1]"
                true-value="1"
                :id="`${checknumber}c24`"
              />
              <label class="custom-control-label" :for="`${checknumber}c24`">Student Assessments</label>
            </div>
          </li>
          <li class="list-group-item active">Miscellaneous</li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c5[1]"
                true-value="1"
                :id="`${checknumber}c25`"
              />
              <label class="custom-control-label" :for="`${checknumber}c25`">Receipts</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c5[2]"
                true-value="1"
                :id="`${checknumber}c26`"
              />
              <label class="custom-control-label" :for="`${checknumber}c26`">Payment Plan</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c5[3]"
                true-value="1"
                :id="`${checknumber}c27`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c27`"
              >Warning letters if applicable</label>
            </div>
          </li>
          <li class="list-group-item">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                v-model="checklist.c5[4]"
                true-value="1"
                :id="`${checknumber}c28`"
              />
              <label
                class="custom-control-label"
                :for="`${checknumber}c28`"
              >Statement of Attainment/Certificates/Record of Results</label>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["checknumber","cl"],
  data() {
    return {
      checklist: {
        c1: {
          1: "",
          2: "",
          3: "",
          4: "",
          5: "",
          6: "",
          7: "",
          8: "",
          9: "",
          10: "",
          11: "",
          12: "",
          13: "",
          14: ""
        },
        c2: {
          1: "",
          2: "",
          3: "",
          4: ""
        },
        c3: {
          1: "",
          2: "",
          3: "",
          4: ""
        },
        c4: {
          1: ""
        },
        c5: {
          1: "",
          2: "",
          3: "",
          4: ""
        }
      }
    };
  },
  // created(){
  //   console.log(this.cl);
  //   console.log(this.checklist);
  // },
  methods : {
    saveChanges(){
       const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
      });
      axios.post(`/offer-letter/checklist/${window.student_id}`,this.checklist).then(res=>{
        // console.log(res);
        if(res.data.status == 'success'){
          Toast.fire({
              type: "success",
              title: "Added Successfuly"
            });
        }else{
          Toast.fire({
              type: "error",
              title: res.data.message
            });
        }
      }).catch(err=>{
        // console.log(err);
      })
    }
  },
  watch:{
    cl: function(newval){
        // this.checklist = newval;
    }
  }

};
</script>