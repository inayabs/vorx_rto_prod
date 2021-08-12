<template>
  <div>
      <table class="table responsive-table">
      <thead>
        <tr>
          <th v-bind:class="'background-'+app_color">#</th>
          <!-- <th v-bind:class="'background-'+app_color">Course</th> -->
          <th v-bind:class="'background-'+app_color">Serial #</th>
          <!-- <th v-bind:class="'background-'+app_color">Manual #</th> -->
          <th v-bind:class="'background-'+app_color">Released Date</th>
          <!-- <th v-bind:class="'background-'+app_color">Released</th> -->
          <!-- <th v-bind:class="'background-'+app_color">Reissued Date</th> -->
          <!-- <th v-bind:class="'background-'+app_color">Reissued</th> -->
          <th v-bind:class="'background-'+app_color">Created</th>
          <!-- <th v-bind:class="'background-'+app_color">Completion Date</th> -->
          <!-- <th v-bind:class="'background-'+app_color">Enrolment Date</th> -->
          <th v-bind:class="'background-'+app_color">Actions</th>
        </tr>
      </thead>
        <tbody>
            <tr v-for="(certs,index) in certificate.details" :key="certs.id">
                <td>{{ certs.id}}</td>
                <td>{{ certs.soa_number}}</td>
                <td>{{ certs.release_date}}</td>
                <td>{{ certs.created_at}}</td>
                <td>
                    <div class="btn-group" role="group">
                    <button
                        v-bind:class="'btn btn-'+app_color+' dropdown-toggle btn-sm'"
                        type="button"
                        id="dropdownMenu1"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >Action</button>
                    <ul
                        class="dropdown-menu dropdown-menu-right multi-level"
                        role="menu"
                        aria-labelledby="dropdownMenu"
                    >
                        <li>
                        <a
                            class="dropdown-item"
                            href="javascript:void(0)"
                            @click="viewCertificate(certs.id)"
                        >
                            <i class="fas fa-eye"></i> View
                        </a>
                        </li>
                        <li>
                        <a
                            class="dropdown-item"
                            href="javascript:void(0)"
                            @click="editCompletion(certificate.details[index])"
                        >
                            <i class="fas fa-edit"></i> Edit Completion
                        </a>
                        </li>
                        <li>
                        <a
                            class="dropdown-item"
                            href="javascript:void(0)"
                            @click="editCertificate(index)"
                        >
                            <i class="fas fa-save"></i> Save Certificate
                        </a>
                        </li>
                        <li>
                        <a
                            class="dropdown-item"
                            href="javascript:void(0)"
                            @click="trashCertofocate(certs.id)"
                        >
                            <i class="fas fa-trash"></i> Delete
                        </a>
                        </li>
                    </ul>
                    </div>
                </td>
            </tr>
        </tbody>
      </table>
  </div>
</template>

<script>
export default {
    props : ['certificate','course'],
    data() {
        return {
            app_color : app_color,
            roles :null,
        }
    },
    mounted(){
      if(this.$root.$refs.studentbase != undefined){
        this.roles = this.$root.$refs.studentbase.urole;
      }
    },
    methods: {
        trashCertofocate(certificate) {
            let vm = this
            if(vm.roles != 'Staff'){
              const Toast = swal.mixin({
                  toast: true,
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 3000
              });
              swal.fire({
                  title: "Are you sure ?",
                  text: "You wont be able to revert this!",
                  type: "warning",
                  width: "25%",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "Yes, delete it!"
                  })
                  .then(result => {
                  if (result.value) {
                      axios
                      .delete(`/certificate_issuance/${certificate}`)
                      .then(res => {
                           vm.$emit("updateData", {status : 'update', data: certificate});
                          Toast.fire({
                          type: "success",
                          title: res.data.message
                          });
                      })
                      .catch(err => {
                          Toast.fire({
                          type: "error",
                          title: 'ERROR'
                          });
                      });
                  }
              });
            }else{
              Toast.fire({
                type: "error",
                title: "Opss.. Not Authorized",
                position: "top-end",
              });
            }

        },
        viewCertificate(id){
            window.open(`/certificate_issuance/preview/${id}`, "_blank");
        },
        editCompletion(completion){
            let vm = this;

            if(vm.roles != 'Staff'){
              vm.$emit("editCompletion", {
                  units: completion.units,
                  edit: true,
                  id: completion.id,
                  soa_number: completion.soa_number
              });
              // console.log(completion);
              $(`#nav-completion-tab-${vm.course}`).tab("show");
            }else{
              Toast.fire({
                type: "error",
                title: "Opss.. Not Authorized",
                position: "top-end",
              });
            }
          }
  },
}
</script>

<style>
</style>
