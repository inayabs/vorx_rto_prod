<template>
  <div>
    <div class="row">
      <div class="col-md-6" v-if="typeof coe.id === 'undefined'">
        <div class="form-group">
          <label for="coe"></label>
          <input
            type="file"
            class="form-control"
            style="border:none !important"
            @change="uploadFile"
            id="coe"
          />
          
        </div>
      </div>
      <div class="col-md-6" v-else>
        <label for="coe"></label><br>
        <span>
          <h5 class="pl-3"><i class="far fa-file fa-1x"></i> {{coe.name}}</h5>
        </span>
      </div>
      <div class="col-md-6 text-right" v-if="typeof coe.id !== 'undefined'">
        <div class="form-group">
          <label for="send-coe"></label><br>
          <button class="btn btn-warning" @click="send"><i class="fab fa-telegram-plane"></i> Send</button>
          <button class="btn btn-success" @click="view"><i class="fas fa-eye"></i> View</button>
          <button v-if="student.student_type_id == 1" class="btn btn-danger" @click="remove"><i class="fas fa-trash"></i> Delete</button>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="package">Orientation Date:</label>
          <date-picker
            :masks="{ L: 'DD/MM/YYYY' }"
            v-model="orientation_date"
            locale="en"
          ></date-picker>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";

export default {
  created() {
      this.offer_letter_id = this.$parent.offerData.id;
      this.fetchData();
  },
  props: ["offerData", "offerid", "refs"],
  data() {
    return {
      coe: {},
      student_id : window.student_id,
      student: {},
      offer_letter_id : null,
      offerLetter: {},
      orientation_date: null,
      // agents: window.agents,
    };
  },
  methods : {
      send() {
        let vm = this;

         swal.fire({
            title: `Are you sure to email COE?`,
            html: '<i>Student will also receive logins for Student Portal Access.</i>',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, send it!'
        }).then((result) => {
            if (result.value) {

              swal.fire({
                  title: 'Processing...',
                  html: 'Generating logins and sending COE',// add html attribute if you want or remove
                  allowOutsideClick: false, 
                  onBeforeOpen: () => {
                      swal.showLoading()
                  },
              });

              axios.post( '/offer-letter/coe/send',
              {
                student_id : vm.student_id,
                coe : vm.coe,
                orientation_date: vm.orientation_date,
              }
              ).then(function(res){
                  // console.log(res);
                  if(res.data.status == 'success'){
                      swal.fire(
                          'Success!',
                          'COE sent successfully.',
                          'success'
                      )
                      vm.fetchData();
                  }
              })
              .catch(function(err){
                  console.log(err)
                  // Toast.fire({
                  //     position: 'top-end',
                  //     type: 'error', title: 'Attachment was not saved',
                  // })
              });

            }
        })
      },
      remove() {
        let vm = this
         swal.fire({
            title: 'Are you sure delete COE?',
            // html: html,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
              axios.get('/offer-letter/coe/remove/'+ vm.coe.id)
              .then(function (res) {
                  // handle success
                  if(res.data.status == 'success'){     
                      swal.fire(
                          'Success!',
                          'COE deleted successfully.',
                          'success'
                      )
                      vm.coe = {};
                  }else{
                    swal.fire(
                          'Success!',
                          res.data.message,
                          'error'
                      )
                  }
                  
              })
              .catch(function (error) {
                  // handle error
                  console.log(error)
              })
            }

        })
      },
      view() {
        window.open('/storage/student/new/attachments/'+this.coe.student_id+'/'+this.coe.hash_name+'.'+this.coe.ext, '_blank');
      },
      fetchData() {
          let vm = this
            axios.get('/offer-letter/coe/fetch/'+ vm.offer_letter_id)
            .then(function (res) {
                // handle success
                if(res.data.coe != null){
                    vm.coe = res.data.coe
                    vm.student = res.data.student;
                    // console.log(vm.coe);
                }
                if(res.data.od != null){
                  // console.log(res.data.od)
                  // console.log(moment(res.data.od, 'YYYY-MM-DD')._d)
                  vm.orientation_date = moment(res.data.od, 'YYYY-MM-DD')._d
                }
            })
            .catch(function (error) {
                // handle error
                console.log(error)
            })
      },
      uploadFile(e) {
          if(e.target.files.length > 0){
              let file = e.target.files[0]
              let vm = this
              
              swal.fire({
                  title: 'Uploading COE...',
                  // html: '',// add html attribute if you want or remove
                  allowOutsideClick: false,
                  onBeforeOpen: () => {
                      swal.showLoading()
                  },
              });
  
              let formData = new FormData();
  
              formData.append('files', file);
              formData.append('offer_letter_id', vm.offer_letter_id);
  
  
              axios.post( '/offer-letter/coe/upload',
              formData,
              {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  }
              }
              ).then(function(res){
                  console.log(res);
                  if(res.data.status == 'success'){
                      swal.fire(
                          'Success!',
                          'COE uploaded successfully.',
                          'success'
                      )
                      vm.fetchData();
                  }
              })
              .catch(function(err){
                  console.log(err)
                  // Toast.fire({
                  //     position: 'top-end',
                  //     type: 'error', title: 'Attachment was not saved',
                  // })
              });
          }
      }
  }
};
</script>