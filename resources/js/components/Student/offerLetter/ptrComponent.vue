<template>
    <div>
        <div v-for="(ptrr,index) in ptr" :key="index">
            <div class="accordion" :id="'accordion'+index+ptrr.id">
                <div class="card buddoy" :id="'heading'+index+ptrr.id">
                    <div class="card-header" :id="'heading'+index+ptrr.id">
                        <h2 class="mb-0">
                            <button
                            class="btn btn-link collapsed"
                            type="button"
                            data-toggle="collapse"
                            :data-target="'#collapse'+index+ptrr.id"
                            aria-expanded="false"
                            :aria-controls="'collapse'+index+ptrr.id"
                            >Process #: {{ptrr.epack.process_id}}</button>
                        </h2>
                    </div>
                    <div
                    :id="'collapse'+index+ptrr.id"
                    class="collapse"
                    :aria-labelledby="'heading'+index+ptrr.id"
                    :data-parent="'#accordion'+index+ptrr.id"
                    >
                        <ol-ptr-content :ptr="ptrr" :index="index" @ptrUpdate="ptrUp"/> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
import ptrContent from "./ptrContentComponent.vue";
export default {
    data(){
        return{
            app_color:app_color,
            course_student_align:''
        }
    },
    components:{
        ptrContent
    },
    props:['ptr'],
    methods:{
        ptrUp(){
            this.$emit('ptrUpdate');
        }
    }
}
</script>