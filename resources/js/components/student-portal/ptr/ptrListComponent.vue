<template>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 :class="'m-0 font-weight-bold text-'+app_color">
            Pre-training Review
            </h6>
        </div>
        <div class="card-body">
            <div class="list-group">            
            <a :href="'/my_ptr/'+ep.ep.process_id" target="_blank" class="list-group-item list-group-item-action list-group-item-primary" v-for="(ep,index) in epack" :key="index">Process #: {{ep.ep.process_id}}</a>
            </div>

        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            app_color:app_color,
            epack:epack
        }
    },
}
</script>