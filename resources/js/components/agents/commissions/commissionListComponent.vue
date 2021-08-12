<template>
    <div>
        <v-client-table :data="commission_list" :columns="columns" ref="commission_list">
        </v-client-table>
    </div>    
</template>

<script>
export default {

    data() {
        return {
            commission_list : [],
            columns : [
                '#' , 
                'Agent',
                'serial',
                'date',
                'Total Actual Amount Received',
                'Total Computed Commission',
                'Due Commission',
                'Total Deducted Commission',
                'Commission Status'
            ]
        }
    },
    mounted(){
        window.axios.get('commission/list/0').then(response=>{
            console.log(response);
        }).catch(error=>{
            console.log(error);
        })
    }
}
</script>