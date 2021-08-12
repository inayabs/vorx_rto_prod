<template>
    <div>
        <!-- <div class="row mb-3">
            <div class="col-md-12 pull-right text-right">
                <button class="btn btn-success" @click="saveChanges()" ><i class="far fa-save"></i> Save Changes</button>
            </div>
        </div> -->

        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" v-if="no_add == false">
                        <div class="row">
                            <div class="col-md-10 col-sm-10 col-xs-10 pr-0">
                                <textarea name="" id="" v-model="note.remarks" class="form-control notes-text"></textarea>
                            </div>
                            <!-- <div class="col-md-2 col-sm-2 col-xs-2 pr-0 pl-0">
                                <select name="" id="" v-model="note.student_status_id" class="form-control student-status">
                                    <option v-for="(status,key) in studentStatuses" :key="key" v-bind:value="key">{{status}}</option>
                                    
                                </select>
                            </div> -->
                            <div class="col-md-2 col-sm-2 col-xs-2 pl-0">
                                <button v-if="edit == false" @click="saveChanges" class="btn btn-success notes-save form-control">Save</button>
                                <button v-else @click="saveChanges" class="btn btn-info notes-save form-control">Update</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 mb-4">
                            <div v-for="(note,key) in notes" :key="note.id" v-bind:class='"border-left-success card  shadow h-100 py-2 mb-2"'>
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <!-- <div v-bind:class='"text-sm text-left font-weight-bold text-primary text-uppercase mb-3"'>
                                        <span>{{note.student_status.status}}</span> 
                                    </div> -->
                                    <div class="clearfix"></div>
                                    <div class="h6 mb-0 text-justify text-gray-800">{{note.remarks}}</div>
                                    <!-- <div class="text-xs text-right font-weight-bold text-mute text-uppercase mt-1"><em>{{note.created_at | DateFormat}} - {{note.user.party.name}}</em></div> -->
                                    <div class="text-sm text-rigth text-mute text-uppercase mt-1">
                                        <a class="text-primary mr-1" @click="editNote(key)"><i class="fas fa-edit"></i></a>
                                        <a class="text-danger" @click="deleteNote(key)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <!-- <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div> -->
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
</template>
<script>

    import moment from "moment";
    import { mapGetters, mapMutations } from "vuex";
    export default {
        components: {
            // DynamicForm
        },
        props: {
            noAdd: Boolean,
        },
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        data() {
            return {
                csrfToken: '',
                no_add : false,
                student_id: window.student_id,
                // notes: [],
                note: {
                    student_id: window.student_id,
                },
                edit: false,

            };
        },
        computed : {
            notes(){
                return this.$store.getters.notes;
            }
        },
        methods: {
            ...mapMutations(['updateNote']),
            saveChanges() {
                let vm = this;

                axios.post('/student-notes',{
                    note: this.note,
                    edit: this.edit,
                    _token: this.csrfToken
                })
                .then(res => {
                    if(res.data.status == 'success'){
                        
                        if(vm.edit == true){
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
                        
                        vm.note = {
                           student_id: window.student_id,
                        };
                        let data = {
                            edit: vm.edit,
                            note: vm.note,
                            res: res.data.data
                        }
                        vm.edit = false;
                        vm.updateNote(data);
                        
                        // vm.fetchData();
                        vm.$parent.student_type = res.data.student_type != null ? res.data.student_type : vm.$parent.student_type;
                        // this.agent = res.data.agent;
                    }else{
                         Toast.fire({
                            position: 'top-end',
                            type: 'error', title: 'Opss.. was not saved successfully',
                        })
                    }
                })
                .catch(err => console.log(err));
            },
            editNote(key) {
                this.note = this.notes[key];
                this.edit = true;
            },
            deleteNote(key) {
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
                        let note = vm.notes[key];
                        // console.log(note.id);
                        axios.delete('/student-notes/'+note.id)
                        .then(function(res){
                        vm.files = res.data;
                        if(res.data.status == 'success'){
                            swal.fire(
                                'Deleted!',
                                'Note has been deleted.',
                                'success'
                            )
                            // vm.fetchData();
                            let data = {
                                deleted: true,
                                note_id: res.data.data.id
                            }
                            vm.updateNote(data);
                        }
                        })
                        .catch(function(error){
                        });
                    }
                });
            }
        },
        filters: {
            DateFormat: function (date) {
                return date ? moment(date).format('DD/MM/YYYY hh:mm:ss') : '';
            }, 
        }
    }
</script>

<style>
    .tab-pane {
        border: 1px solid #e0dfdf;
        border-top: none;
        padding: 1.3rem;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
        background-color: #ffffff;
    }
    /* .horizontal-line-wrapper{
        background-color: #36b9cc;
    } */
    textarea{
        resize: none;
    }
    .notes-text{
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .notes-save{
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        height: 100%;
    }
    .student-status{
        border-radius: 0;
        height: 100%;
    }

</style>