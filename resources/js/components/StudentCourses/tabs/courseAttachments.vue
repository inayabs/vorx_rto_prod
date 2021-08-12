<template>
    <div>
        <!-- <h3>Documents</h3> -->
        <div class="col-md-12">
            <div class="row my-3" v-for="itm in attachments" :key="itm.id">
                <div class="col-md-6">
                    <i class="fas fa-file-pdf fa-2x"></i> <span class="ml-2">{{itm.name}} </span>
                </div>
                <div class="col-md-6 text-right">
                    <a v-bind:href="'/course/attachment/preview/'+itm.id" v-bind:key='itm.id' target="_blank" class="btn btn-success"><i class="fas fa-eye"></i> View</a>
                    <a v-bind:href="'/course/attachment/download/'+itm.id" v-bind:key='itm.id' target="_blank" class="btn btn-primary"><i class="fas fa-download"></i> Download</a>
                </div>
            </div>

        </div>

    </div>
</template>
<script>
export default {
    name:'courseAttachments',
    components:{
        
    },
    props:['course'],
    data(){
        return{
            app_color:app_color,
            attachments: [],
        }
    },
    created() {
        this.fetch();
    },
    methods: {
        fetch() {
            let vm = this;
            console.log('documents')
            console.log(vm.course.course_code);
            axios.get('/student-portal/single/course-attachments/'+vm.course.course_code)
            .then(function (res) {
                // handle success
                vm.attachments = res.data;
                
                console.log(res.data);
            })
            .catch(function (err) {
                // handle error
                console.log(err);
            })
        },
    }
}
</script>