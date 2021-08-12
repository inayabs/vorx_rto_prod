<template>
  <modal name="size-modal"
        transition="nice-modal-fade"
        classes="demo-modal-class"
        :min-width="200"
        :min-height="200"
        :pivot-y="0.1"
        :adaptive="true"
        :scrollable="true"
        :reset="true" 
        width="40%"
        height="auto"
        @before-open="beforeOpen"
        @opened="opened"
        @closed="closed"
        @before-close="beforeClose">
  <div class="size-modal-content">
    <h4>Add Trainer</h4>
    <form @submit.prevent="saveTrainer">
        <div class="row">
            <div class="col-md-6">
                <div :class="['form-group', errors.firstname ? 'has-error' : '']" >
                  <label for="firstname">Firstname</label>
                  <input 
                    id="firstname" 
                    name="firstname" 
                    value=""  
                    autofocus="autofocus" 
                    class="form-control" 
                    type="text" 
                    v-model="trainer.firstname">
                  <span v-if="errors.firstname" :class="['badge badge-danger']">{{ errors.firstname[0] }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div :class="['form-group', errors.lastname ? 'has-error' : '']" >
                  <label for="lastname">Lastname</label>
                  <input 
                    id="lastname" 
                    name="lastname" 
                    value=""  
                    autofocus="autofocus" 
                    class="form-control" 
                    type="text" 
                    v-model="trainer.lastname">
                  <span v-if="errors.lastname" :class="['badge badge-danger']">{{ errors.lastname[0] }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div :class="['form-group', errors.email ? 'has-error' : '']" >
                  <label for="email">Email</label>
                  <input 
                    id="email" 
                    name="email" 
                    value=""  
                    autofocus="autofocus" 
                    class="form-control" 
                    type="type" 
                    v-model="trainer.email">
                  <span v-if="errors.email" :class="['badge badge-danger']">{{ errors.email[0] }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div :class="['form-group', errors.phone_number ? 'has-error' : '']" >
                  <label for="phone_number">Phone Number</label>
                  <input 
                    id="phone_number" 
                    name="phone_number" 
                    value=""  
                    autofocus="autofocus" 
                    class="form-control" 
                    type="type" 
                    v-model="trainer.phone_number" >
                  <span v-if="errors.phone_number" :class="['badge badge-danger']">{{ errors.phone_number[0] }}</span>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    
  </div>
</modal>
</template>
<script>
const Toast = swal.mixin({
        toast: true, position: 'top-end', showConfirmButton: false, timer: 3000
    });

  export default {
    name: 'SizeModalTest',
    props: ['id', 'firstname', 'lastname', 'email', 'phone_number'],
    mounted() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
    },
    data () {
      return {
        trainerList : [],
        trainer : {
            id : '',
            firstname: '',
            lastname: '',
            email: '',
            phone_number: '',
        },
        trainer_id : '',
        csrf: '',
        errors: [],
        success : false  
      }
    },
    methods: {
        saveTrainer() {
          let dataform = new FormData();
          dataform.append('firstname', this.trainer.firstname);
          dataform.append('lastname', this.trainer.lastname);
          dataform.append('email', this.trainer.email);
          dataform.append('phone_number', this.trainer.phone_number);
          
            //   Add
            let vm = this;
            axios.post('/trainer', dataform)
            .then(response => {
                if(response.data.status == "errors"){
                  this.errors = response.data.errors;
                }else{        
                  this.errors = [];
                  this.trainer.firstname = '';
                  this.trainer.lastname = '';
                  this.trainer.email = '';
                  this.trainer.phone_number = '';
                  this.success = true;
                  Toast.fire({
                    type: 'success', title: 'Data is saved successfully',
                  });
                  this.$parent.fetchTrainers();
                  this.$modal.hide('size-modal'); 
                }
            })
            .catch(err => {
              // console.log(window.Toast);
              console.log(err);
              // this.errors = err.data.errors;
              // this.success = false;
            }); 
        },
        beforeOpen (e) {
            console.log(e);
            this.trainer.id = e.params.id || null;
            this.trainer.firstname = e.params.firstname;
            this.trainer.lastname = e.params.lastname;
            this.trainer.email = e.params.email;
            this.trainer.phone_number = e.params.phone_number;
            this.edit = e.params.edit || false;
            this.trainer_id = e.params.trainer_id || null;
        // this.fetchCourses();
        },
        beforeClose (e){

        },
        opened (e) {
        // e.ref should not be undefined here
            // console.log('opened', e)
            // console.log('ref', e.ref)
        },
        closed (e) {
            console.log('closed', e)
        }
    }
  }
</script>

<style>
  .size-modal-content {
    padding: 10px;
    margin: 10px;
    font-style: 13px;
  }
  .v--modal-overlay[data-modal="size-modal"] {
    background: rgba(0, 0, 0, 0.5);
  }
  .demo-modal-class {
    border-radius: 5px;
    background: #F7F7F7;
    box-shadow: 5px 5px 30px 0px rgba(46,61,73, 0.6);
  }
</style>