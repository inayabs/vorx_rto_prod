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
    <h4>Add Course</h4>
    <form @submit.prevent="create">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="firstname" class="">Firstname</label>
                    <input type="text" class="form-control" id="firstname" v-model="fields.firstname" :class="[errors && errors.firstname ? 'border-danger' : '']"  />
                    <div v-if="errors && errors.firstname" class="badge badge-danger" :class="[isValid ? 'd-none': 'd-inline-block']">{{ errors.firstname[0] }}</div>
                 </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lastname" class="">Lastname</label>
                    <input type="text" class="form-control" id="lastname" v-model="fields.lastname" :class="[errors && errors.lastname ? 'border-danger' : '']"  />
                    <div v-if="errors && errors.lastname" class="badge badge-danger" :class="[isValid ? 'd-none': 'd-inline-block']">{{ errors.lastname[0] }}</div>
                 </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    
  </div>
</modal>
</template>
<script>
    import FormMixin from '../../mixins/FormMixin'
    export default {
        name: 'SizeModalTest',
        props: ['id', 'firstname', 'lastname'],
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        mixins: [ FormMixin ],
        // name: 'createTrainer',
        data() {
            return {
                // Form Attributes
                'action': '/trainer',
                'method': 'post',
                isActive: true,
            }
        },
        methods: {
          beforeOpen (e) {
            console.log(e);
            this.trainer.id = e.params.id || null;
            this.trainer.name = e.params.firstname;
            this.trainer.code = e.params.lastname;
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