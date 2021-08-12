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
    <h4 :class="'modal-header-'+app_color">Add Agent</h4>
    <form @submit.prevent="saveAgent">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputAgentCode">Company Name</label>
                    <input type="text" class="form-control" v-model="agent.company_name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputAgentName">Agent Name</label>
                    <input type="text" class="form-control" v-model="agent.agent_name">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputAgentName">Email</label>
                    <input type="email" class="form-control" v-model="agent.email">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputAgentCode">Phone Number</label>
                    <input type="text" class="form-control" v-model="agent.phone">
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputAgentCode">Phone Number</label>
                    <input type="text" class="form-control" v-model="agent.phone">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputAgentName">Active</label>
                    <input type="checkbox" class="form-control checkbox" name="vet_flag_status" id="checkbox" v-model="agent.is_active">
                </div>
            </div>
        </div> -->
        
        <button type="submit" :class="'btn btn-'+app_color">Save</button>
    </form>
    
  </div>
</modal>
</template>
<script>
  export default {
    name: 'SizeModalAgent',
    // props: ['id', 'code', 'name'],
    mounted() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
    },
    data () {
      return {
        app_color:app_color,
        // agentList : [],
        agent : {},
        // agent_id : '',
        // edit : false,
        // csrf: '',
      }
    },
    methods: {
        saveAgent() {
            //   Add
            // fetch('agent', {
            //     method: 'POST',
            //     body: JSON.stringify(this.agent),
            //     headers: {
            //         'content-type' : 'application/json',
            //         'X-CSRF-TOKEN' : this.csrf
            //     }
            // })
            // .then(res => res.json())
            // .then(data => {
            //     this.agent.name = '';
            //     this.agent.code = '';
            //     alert('Agent created successfully');
            //     this.$parent.fetchAgents();
            //     this.$modal.hide('size-modal'); 
            // })
            // .catch(err => console.log(err))
            let vm = this;
            axios.post('/agent',{
                agent : this.agent,
                _token: this.csrfToken
            })
            .then(res => {
                if(res.data.status == 'success'){
                    Toast.fire({
                        position: 'top-end',
                        type: 'success',
                        title: 'Agent saved successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // this.agent = {};
                    // console.log(vm.$parent);
                    // vm.$parent.fetchAgents();
                    vm.$modal.hide('size-modal'); 
                }else{
                    Toast.fire({
                        position: 'top-end',
                        type: 'error',
                        title: 'Opss.. was not saved successfully',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
            .catch(err => console.log(err));

        },
        beforeOpen (e) {
            this.agent = {};

        // this.fetchAgents();
        },
        beforeClose (e){
            this.$parent.fetchAgents();
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