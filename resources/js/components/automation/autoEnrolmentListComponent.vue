<template>
    <form @submit.prevent>
        <div>
                    <div class="row mb-3">
                        <div class="col-md-12 pull-right text-right">
                            <button class="btn btn-success" @click="saveChanges()"><i class="far fa-save"></i> Save Changes</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                        <h6>Configuration</h6>
                    </div>
                    <div class="form-padding-left-right">
                        <div class="row">
                            <div class="col-lg-6">
                                <div :class="['form-group']" >
                                    <label for="enrolment">Occurrence</label>
                                    <select name="" class="form-control" v-model="automation.type">
                                        <option value="Daily">Daily</option>
                                        <option value="Monthly">Monthly</option>
                                        <option value="Yearly">Yearly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6" v-if="automation.type == 'Yearly'">
                                <div class="form-group">
                                    <label for="enrolment">Month</label>
                                    <select id="month" name="month" class="form-control" v-model="automation.month">
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6" v-if="automation.type == 'Yearly' || automation.type == 'Monthly'">
                                <div class="form-group">
                                    <label for="enrolment">Day</label>
                                    <input type="number" class="form-control" max="31" @keyup="dayRange()" v-model="automation.day">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="enrolment">Time</label>
                                    <input type="time" class="form-control" v-model="automation.time">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="enrolment">Emails -<span class="badge"><i>separate with comma(,)</i></span></label>
                                    <textarea name="" class="form-control" id="" cols="30" rows="10" v-model="emails"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
</template>
<script>
export default {
    data(){
        return{
            automation: {
                day: 1,
                month: '01',
                time: '00:00',
                type: 'Daily',
            },
            emails : '',
            app_color: app_color,
            success : false  
        };
    },
    created(){
        // console.log(window.enrolment_list);
        if(typeof window.enrolment_list != 'undefined' && window.enrolment_list != null){
            console.log(window.enrolment_list.config);
            this.automation = window.enrolment_list.config;
            this.emails = window.enrolment_list.emails;
        }
    },
    methods:{
        dayRange (){
            let day = this.automation.day;
            if(parseInt(day) > 31){
                this.automation.day = 31;
            }else if(parseInt(day) < 1){
                this.automation.day = 1;
            }else{
                this.automation.day = day;
            }
        },
        saveChanges (){
            swal.fire({
                title: 'Saving Changes...',
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    swal.showLoading()
                },
            });

            let vm = this;

            axios.post('/automation/save',{
                config: vm.automation,
                occurrence_type: vm.automation.type,
                month: vm.automation.month,
                day: vm.automation.day,
                time: vm.automation.time,
                type: 'enrolment-list',
                emails: vm.emails, 
            })
            .then(function(res){
                console.log(res.data);
                if(res.data.status == 'success'){
                    swal.fire(
                        'Good job!',
                        'Changes saved successfully!',
                        'success'
                    )
                }else{
                    swal.fire(
                        'Oopss!',
                        res.data.msg,
                        'error'
                    )
                }
            })
            .catch(function (err){
                console.log(err);
            })
        }
    }
}
</script>


<style scoped>
    .note {
        font-style: italic !important;
        font-size: 10px !important;
    }
    .card_logo {
        background-color: #d2d2d2;
    }
    .org_logo {
        width: 200px !important;
        margin: 0 auto;
    }
    .close{
        position: absolute;
        width: 100%;
        text-align: right;
    }
    .reload {
        font-style: italic !important;
        font-size: 10px !important;
        text-decoration: underline;
        color: #fff;
        cursor: pointer;
    }
</style>