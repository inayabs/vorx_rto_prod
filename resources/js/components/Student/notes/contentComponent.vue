<template>
  <div>
    <transition name="slide-fade">
        <div v-if="createNotes" class="right-pane">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-6 m-0 p-0">
                        <div class="form-group">
                            <div class="card-title">
                                <label for="date">Date : </label>
                                <date-picker
                                :popover="{ placement: 'bottom', visibility: 'click' }"
                                v-model="date_notes"
                                mode="single"
                                locale="en"
                                :masks="{ L: 'DD/MM/YYYY', data: 'DD/MM/YYYY' }"
                                ></date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-12  m-0 p-0">
                        <div class="form-group">
                            <label for="date">Remarks : </label>
                            <textarea class="form-control" v-model="remarks" id="exampleFormControlTextarea1" rows="10"></textarea>
                        </div>
                    </div>
                    <a @click="saveNote" class="btn btn-success">Save</a>
                    <a @click="clearNote" class="btn btn-warning">Discard</a>
                    <!-- <a @click="createNotes = !createNotes" class="btn btn-danger">Go somewhere</a> -->
                </div>
            </div>
        </div>
    </transition>
    <transition name="slide-fade">
        <div v-if="viewNotes" class="right-pane">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{noteData.date_notes | dateFormat}}</h5>
                    <p class="card-text">{{ noteData.remarks }}</p>
                     <span>created by : {{ noteData.created_by }}</span>
                </div>
            </div>
        </div>
    </transition>
  </div>
</template>

<script>
import moment from 'moment';
export default {
    props : ['triggerType','noteData'],
     data(){
        return {
            createNotes:false,
            viewNotes:false,
            date_notes : '',
            remarks : '',
        }
    },
    created(){
        this.loadViewData = _.debounce(this.loadViewData,200);
        this.loadCreateData = _.debounce(this.loadCreateData,200);
    },
    methods : {
        loadViewData(){
            return this.viewNotes = !this.viewNotes;
        },
        loadCreateData(){
            return this.createNotes = !this.createNotes;
        },
        saveNote(){

            axios.post('/student-notes',{
                student_id : window.student_id,
                remarks : this.remarks,
                date_notes : this.date_notes,
                edit : false
            }).then(res=>{
                  if(res.data.status == 'success'){
                        if(this.edit == true){
                            Toast.fire({
                                position: 'top-end',
                                type: 'success', title: 'Notes updated successfully',
                            })
                        }else{
                            Toast.fire({
                                position: 'top-end',
                                type: 'success', title: 'Notes added successfully',
                            })
                        }
                        let rData = res.data.data;
                        rData.active = '';
                        this.$emit('updateNoteList',rData);
                        this.clearNote();
                  }
                

            })
        },
        clearNote(){
            this.date_notes = null;
            this.remarks =  null
        }
    },
    watch : {
        triggerType(newVal,oldVal){
            if(newVal == 'create'){
                this.loadCreateData();
            }else if(newVal == 'view'){
                this.loadViewData();
            }else{
                this.createNotes = false;
                this.viewNotes = false;
            }
            
        },
        noteData(newVal,oldVal){
            if(!_.isEmpty(newVal)){
                this.createNotes = false;
                this.viewNotes = false;
                if(newVal.id != oldVal.id){
                    this.loadViewData();
                }else{
                this.viewNotes = true;
                }
            }else{
                this.viewNotes = false;
            }
            
        }
       
    },
    filters : {
        dateFormat(data){
            return moment(data).format('DD/MM/YYYY');
        }
    }
    
}
</script>
<style scoped>

.slide-fade-enter-active {
  transition: all .3s ease-in-out;
}
.slide-fade-leave-active {
  transition: all .3s ;
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
.right-pane {
    position: flex;
}
</style>

