<template>
   <div>
        <table class="table">
                <thead class="thead-dark">
                    <tr>
                    <th :class="['background-'+app_color]" width="5%" scope="col">#</th>
                    <th  :class="['background-'+app_color]" width="10%" scope="col">Unit Code</th>
                    <th :class="['background-'+app_color]" width="50%" scope="col">Unit Title</th>
                    <th  :class="['background-'+app_color]"  scope="col">Start / End Dates</th>
                    <th  :class="['background-'+app_color]" width="10%" scope="col">Training Hours</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(cc,index) in tt.details" :key="index">
                        <td>{{cc.order}}</td>
                        <td >{{cc.course_unit_code}}</td>
                        <td>{{cc.unit.description}}</td>
                        <td>{{cc.start_date | dateformat}} - {{cc.end_date | dateformat}}</td>
                        <td>{{cc.training_hours}}</td>
                    </tr>
                </tbody>
        </table> 
    </div> 
</template>
<script>
import moment from "moment"
export default {
    props:['course'],
    data(){
        return{
            app_color:app_color,
            tt:{},
            class_id: this.$props.course.attendance?this.$props.course.attendance.class_id:''
        }
    },
    created(){
        this.getTimeTable();
    },
    filters:{
        dateformat: function(date) {
        if (!date) return "";
        date = moment(date).format("DD/MM/YYYY");
        return date;
        },  
    },
    methods:{
        getTimeTable(){
            // if(this.class_id!=''){
                axios.get('/student_courses/gettimetable/'+this.$props.course.student_id+'/'+this.$props.course.course_code).then(
                    response=>{
                        this.tt = response.data
                        console.log(response.data);
                    }
                ).catch();
            // }
        },
        backgroundColor(e){
            
        let css = []
        if(typeof e.is_break !== 'undefined'){
            css.push('isBreak')
        }
        if(typeof e.isRotate !== 'undefined'){
            css.push('isRotate')
        }
        console.log(css);
        return css
        },
        getHolidays(arr) {
        console.log(arr)

        let html = '<ul style="margin-left: 10% !important;">';

        arr.forEach(v => {
            html += `<li style="text-align:left !important; color: #ff5757 !important;">${v.name} - ${v.date} (${v.weekday})</li>`;
        })
        html += '</ul><br><span><i>Note: If a holiday comes at scheduled day, the training will be moved to very next available day by default.<i></span>';

        swal.fire({
            type: 'warning',
            title: 'Holidays:',
            html: html
        })

        },
    }
}
</script>
<style scoped>
  .holiday-info {
    cursor: pointer !important;
  }
  .dateError {
    border: 1px solid red !important;
  }
  .isBreak {
    background-color: #ffb8b8 !important;
  }
  .boxBreak{
    width: 15px;
    height: 15px;
    background-color: #ffb8b8 !important;
  }
  .isRotate {
    background-color: #d1ffd1 !important;
  }
  .boxRotate{
    width: 15px;
    height: 15px;
    background-color: #d1ffd1 !important;
  }
  .boxText {
    margin: -1px 5px;
  }
</style>