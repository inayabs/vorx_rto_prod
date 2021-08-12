<template>
        <div class="card">
            <div class="card-header">
            <b>{{ process_id }}</b> - {{ name }} ( {{ type }} )
            </div>
            <div class="card-body">
                <h5 class="card-title">Course / Units of Competency Applied</h5>
                <div id="accordion">
                    <div v-if="Object.keys(course).length !== 0" class="card">
                        <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Course ( <span>{{ course.name }}</span>  )
                            </button>
                        </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <verifyDetails :stype="type" :pid="process_id" :edata="course" :location="location"></verifyDetails>
                        </div>
                    </div>
                    <div  v-if="units.length > 0"  class="card">
                        <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button :class=" Object.keys(course).length !== 0 ? 'btn btn-link collapsed' : 'btn btn-link'" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Units of Competency ( <span >{{unit_name}} </span> )
                            </button>
                        </h5>
                        </div>
                        <div id="collapseTwo" :class=" course.length != 0 ? 'collapse' : 'collapse show'" aria-labelledby="headingTwo" data-parent="#accordion">
                            <verifyDetails :stype="type" :pid="process_id" :edata="units" :location="location"></verifyDetails>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
import verifyDetails from './enrolmentVerificationDetailsComponent.vue';
export default {
    components : {verifyDetails},
    props :['ea'],
    data() {
        return {
            name : null,
            type : null,
            process_id : null,
            ef : null,
            course : [],
            units : []
        }
    },
    mounted() {
        let vm = this;
        let d = JSON.parse(vm.ea);
        this.ef = d.enrolment_form
        this.name = d.student_name
        this.process_id = d.process_id
        if(d.student_type == 2){
            this.type = 'Domestic'
        }else{
            this.type = 'International'
        }
        if(this.ef.course != undefined){
            this.course = this.ef.course
        }
        if(this.ef.units != undefined){
            this.units = this.ef.units
        }

    },
    computed:{
        unit_name : function(){
            let name = ''
            if(this.units.length > 0){
                name = this.units.map((element)=>{
                    return element.description
                }).join(',')
            }
            return name;
        },
        location :function(){
            // console.log(this.ef);
            // return 'HI';
            if(this.ef != ''){
                let loc = this.ef.addr_suburb.value.split(',');
                return loc[1].trim();
            }else{
                return 'all'
            }
        }
    }
}
</script>