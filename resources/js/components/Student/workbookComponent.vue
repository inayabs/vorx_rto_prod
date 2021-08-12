<template>
    <div>
        <div id="accordion">
            <div class="card" v-for="(itm, key) in courses" :key="key">
                <div class="card-header" :id="'heading'+key">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" :data-target="'#collapse'+key" aria-expanded="true" :aria-controls="'collapse'+key">
                            <span v-if="itm.course_code == '@@@@'">Unit of Competency <span v-if="itm.uc_description != null"> - {{ itm.uc_description }}</span></span>
                            <span v-else>{{itm.course.code}} - {{itm.course.name}}</span>
                        </button>
                    </h5>
                </div>
                <div :id="'collapse'+key" :class="['collapse', key == 0 ? 'show' : '']" :aria-labelledby="'heading'+key" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 pl-5" v-if="toType(workbook[itm.course_code]) !== 'undefined'">
                                <h4><i class="far fa-file fa-1x"></i>
                                    <span>{{workbook[itm.course_code].name}}</span>
                                </h4>
                            </div>
                            <div class="col-md-6" v-else>
                                <input type="file" @change="processFile" :StudentCourse="itm.id" class="" name="" id="">
                            </div>
                            <div class="col-md-6 text-right" v-if="toType(workbook[itm.course_code]) !== 'undefined'">
                                <button class="btn btn-success" title="Download workbook" @click="download(workbook[itm.course_code].id)"><i class="fas fa-download"></i></button>
                                <!-- <button class="btn btn-warning" title="Notify Assigned Person (Email)" v-if="automate.length > 0"><i class="fas fa-paper-plane"></i></button> -->
                                <button class="btn btn-danger" @click="remove(workbook[itm.course_code])" title="Remove workbook"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
  data(){
      return {
          app_color: app_color,
          courses : [],
          student_id : window.student_id,
          automate: [],
          workbook: {}
      }
  },
  created() {
    this.fetchData();
  },
  methods : {
        toType(obj) {
            return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
        },
      remove(data) {
          let vm = this;
          swal.fire({
            title: 'Are you sure delete workbook?',
            // html: html,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {

                 swal.fire({
                    title: 'Deleting Workbook...',
                    // html: '',// add html attribute if you want or remove
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        swal.showLoading()
                    },
                });

                axios.get('/student/course/workbook/delete/'+ data.id)
                .then(function (res) {
                    // handle success
                    // console.log(res)
                    if(res.data.status = 'success'){
                        swal.fire(
                          'Success!',
                          res.data.message,
                          'success'
                        )
                        let wb = vm.workbook;
                        delete wb[data.course_code];
                        vm.workbook = wb;
                        vm.fetchData();

                        // console.log(vm.workbook);

                    }else{
                        swal.fire(
                          'Opps!',
                          res.data.message,
                          'error'
                        )
                    }
                })
                .catch(function (error) {
                    // handle error
                    console.log(error)
                    swal.fire(
                        'Opps!',
                        'something is wrong',
                        'error'
                    )
                })
            }
        })

      },
      download(id) {
          window.location = '/student/course/workbook/download/'+ id;
          
      },
      uploadFile(e) {
          if(e.target.files.length > 0){
              let file = e.target.files[0]
              let student_course_id = e.target.attributes.studentcourse.value
              let vm = this
              swal.fire({
                  title: 'Uploading Workbook...',
                  // html: '',// add html attribute if you want or remove
                  allowOutsideClick: false,
                  onBeforeOpen: () => {
                      swal.showLoading()
                  },
              });
  
              let formData = new FormData();
  
              formData.append('files', file);
              formData.append('student_id', vm.student_id);
              formData.append('student_course_id', student_course_id);
  
  
              axios.post( '/student/course/workbook/upload',
              formData,
              {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  },
                  // onUploadProgress: function( progressEvent ) {
                  //     this.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) );
                  // }.bind(this)
              }
              ).then(function(res){
                //   console.log(res);
                  if(res.data.status == 'success'){
                      swal.fire(
                          'Success!',
                          'Workbook uploaded successfully.',
                          'success'
                      )
                    //   vm.workbook[res.data.file.course_code] = res.data.file;
                    vm.fetchData();
                  // vm.fetchAttachments();
                  // // console.log(vmFile);
                  // // console.log('SUCCESS!!');
                  // vm.uploadPercentage = 0;
                  // vm.onDrag = 0;
                  // vm.progressBar = 0;
                  // }else{
                  // Toast.fire({
                  //     position: 'top-end',
                  //     type: 'error', title: 'Attachment was not uploaded',
                  // })
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
      },
      processFile(e) {
          let vm = this
          let event = e

          if(vm.automate.length > 0 && e.target.files.length > 0){
              let html = '<span style="font-weight: 700;">Once uploaded, email will be sent to:</span><br><ul style="margin-left: 10% !important;">'
              vm.automate.forEach(el => {
                  html += '<li style="text-align:left !important; list-style-type: none; margin: 3px 0;"> <i class="far fa-envelope" style="color: green;"></i> '+el.email+'</li>';
              })
              html += '</ul>'

              swal.fire({
                title: 'Are you sure?',
                html: html,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, upload it!'
            }).then((result) => {
                if (result.value) {
                    vm.uploadFile(event)
                }
            })
              
          }else if(vm.automate.length < 1 && e.target.files.length > 0) {
              vm.uploadFile(event)
          }
      },
      fetchData() {
            let vm = this
            axios.get('/student/course/workbook/fetch/'+ vm.student_id)
            .then(function (res) {
                // handle success
                // console.log(res)
                vm.courses = res.data.student_courses
                vm.automate = res.data.automate
                if(typeof vm.courses !== 'undefined' && vm.courses.length > 0){
                    vm.courses.forEach( e => {
                        if(typeof e.student_workbook_attachment[0] !== 'undefined'){
                            // console.log('naa')
                            vm.workbook[e.course_code] = e.student_workbook_attachment[0];
                        }
                    })

                }

                // console.log(vm.workbook);
            })
            .catch(function (error) {
                // handle error
                console.log(error)
            })
      },
  }
}
</script>