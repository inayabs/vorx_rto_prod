<template>
    <ul class="list-group" >
        <li v-for="(note,index) in notes" :key='index' @click="viewNote(note,index)" :class="`list-group-item ${note.active}`">
            <h6 class="card-title font-weight-bold">{{ note.date_notes | dateFormat }}<span @click="deleteNote(index)" class="del-notes float-right"><i class="fas fa-trash"></i></span></h6>
            <p class="card-text">{{ note.remarks }}</p>
        </li>
    </ul>
</template>

<script>
import moment from 'moment';
export default {
    props : ['notes'],
    data(){
        return {
            
        }
    },
    methods: {
         viewNote(note,index){
            let vm = this;
            let noteData = {
                id : index,
                date_notes : note.date_notes,
                remarks : note.remarks,
                created_by : note.user.party.name
            } 
            vm.$emit('selectedNote',{note: noteData , index : index});
        },
        deleteNote(index){
            let vm = this;
            swal.fire({
                    title: 'Are you sure to delete Notes?',
                    // text: " think wisely.. :)",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        let note = vm.notes[index];
                        // console.log(note.id);
                        axios.delete('/student-notes/'+note.id)
                        .then(function(res){
                        // vm.files = res.data;
                        if(res.data.status == 'success'){
                            swal.fire(
                                'Deleted!',
                                'Note has been deleted.',
                                'success'
                            )
                              vm.$emit('deleteNote',index);
                        }
                        })
                        .catch(function(error){
                        });
                    }
                });
          
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
.custom-card-body > ul > li:hover{
    background-color: #f5e5e587;
    color: dimgrey;
}
.custom-card-body > ul > li{
    cursor: pointer;
}
.custom-card-body > ul > li.active{
    background-color: #f5e5e587;
    color: dimgrey;
    border-color: #cacaca;
}
.custom-card-body > ul > li > p{
 text-overflow: ellipsis;
  overflow: hidden; 
   white-space: nowrap;
}
.del-notes:hover{
    color:red;
}

</style>