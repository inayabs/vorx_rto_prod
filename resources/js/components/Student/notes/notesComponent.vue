<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header ">
                        <button class="btn btn-primary float-right "  @click="createNote"> <i class="fas fa-plus"></i> Add notes</button>
                    </div>
                    <div class="card-body custom-card-body" id="cardbody-custom" style="max-height:400px;overflow: overlay;" >
                        <note-list  @deleteNote="deleteSelected($event)" @selectedNote="noteSelected($event)" :notes='noteslist'/>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <note-content :triggerType="triggerType" :noteData="noteData" @updateNoteList="updateNoteLists($event)" />
            </div>
        </div>
    </div>
</template>
<script>
import noteList from './listComponent.vue';
import noteContent from './contentComponent.vue'
export default {
    components : { noteList , noteContent },
    data(){
        return {
            triggerType : '',
            noteslist : [],
            noteData : {}
        }
    },
    mounted(){
        this.fetchData();
    },
    methods: {
        fetchData() {
                axios({
                    method: 'get',
                    url: '/student-notes/'+ window.student_id
                })
                .then(res => {
                   res.data.forEach(function(d){
                        d.active = null;
                    });
                    this.noteslist = res.data
                })
                .catch(err => console.log(err));
            },

        createNote(){
            this.noteData = {};
            this.activeStatus('waka')
            return this.triggerType = 'create'
            
            // return this.createNotes = !this.createNotes;
        },
        
        noteSelected(event){
            this.activeStatus(event.index);
            this.triggerType = 'view'
            this.noteData = event.note;
        },
        activeStatus(index){
            console.log(index);
            if(index == 'waka'){
                this.noteslist.map((value,key) =>{
                        value.active = '';
                })
            }else{
                this.noteslist.map((value,key) =>{
                    if(key == index){
                    value.active = 'active';
                    }else{
                        value.active = '';
                    }
                })
            }
           
            
        },
        updateNoteLists(data){
            let vm = this;
            vm.noteslist.unshift(data);
            vm.noteslist.sort(function(a,b){
                // console.log(a);
                    return new Date(b.date_notes) - new Date(a.date_notes);
            });
            
        },
        deleteSelected(event){
            let vm = this;
            vm.noteslist.splice(event,1);
            vm.triggerType = ''
            vm.noteData = {};
            
        }
    },
   
}
</script>
<style scoped>
 #cardbody-custom::-webkit-scrollbar {
    width: 6px;
}

#cardbody-custom::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
    border-radius: 0;
}

#cardbody-custom::-webkit-scrollbar-thumb {
    border-radius: 0;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
}


</style>
