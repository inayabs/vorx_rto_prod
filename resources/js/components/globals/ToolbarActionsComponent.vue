<template>
<div>
    <div class="row mb-2 d-flex justify-content-between">
        <div class="col-md-6">
            <a :href="this.backUrl" v-bind:class="'btn btn-'+app_color+' text-primary btn-sm text-light'">
                <i class="fas fa-long-arrow-alt-left"></i> Back
            </a>
        </div>
        <div class="col-md-6">
            <div class="float-right">

                <ul class="list-group list-group-horizontal">
                     <li class="list-group-item">
                         <div class="form-group">
                            <div class="custom-control custom-switch my-2">
                            <label class="mr-5">International</label>
                            <input
                                type="checkbox"
                                class="custom-control-input pre-apend"
                                @click="changeStudent_type"
                                v-model="student_type"
                                id="student_type"
                            />
                            <label class="custom-control-label" for="student_type" >Domestic</label>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-group pull-right">
                            <a type="button" v-bind:class="'btn btn-'+app_color+' btn-sm'" v-if="this.add_on('student-details-pdf') == 1" @click="generateStudentDetails()"><i class="fas fa-file-pdf"></i> Generate Student Details</a>
                            <div class="btn-group" role="group" v-if="warningLetterList.length > 0 && this.add_on('email-warning.fees') == 1">
                                <button v-bind:class="'btn btn-'+app_color+' dropdown-toggle btn-sm'" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Warning Letter
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right multi-level" role="menu" aria-labelledby="dropdownMenu">
                                    <li class="dropdown-submenu" v-for="(list, item) in warningLetterList" :key="item">
                                        <a class="dropdown-item" tabindex="-1" href="#">
                                            {{ list.info.name }}
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li class="dropdown-item"><a href="javascript:void(0)" @click="viewEmail(item, list.info.id)" target="_blank">View</a></li>
                                            <li class="dropdown-item" :class="{disabled: list.sent == true}">
                                                <a href="javascript:void(0)" @click="sendEmail(item, list.info.id)">
                                                    Send via Email
                                                    <span v-if="list.sent == true" class="float-right"><i class="fas fa-check text-success"></i></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            </div>
                    </li>
                </ul>

                 
                
                <!-- <div class="btn-group" role="group">
                <button v-bind:class="'btn btn-'+app_color+' dropdown-toggle btn-sm'" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action
                </button>
                <ul class="dropdown-menu dropdown-menu-right multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-submenu">
                        <a class="dropdown-item" tabindex="-1" href="#">
                            submenu
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-item"><a href="javascript:void(0)"  target="_blank">link1</a></li>
                        <li class="dropdown-item"><a href="javascript:void(0)" >link2</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="dropdown-item" tabindex="-1" href="#">Warning Letter History</a>
                    </li>
                    <li>
                        <a class="dropdown-item" tabindex="-1" href="#">link2</a>
                    </li>
                    </ul>
            </div> -->
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: {
        backUrl: String,
        warningLetter: String
    },
    data() {
        return {
            warningLetterList: [],
            warningHistoryList: [],
            emailTrail: [],
            app_color: app_color,
            app_settings: app_settings,
            student_type : ''
        };
    },
    //   components: {},
    created() {
        this.getWarningLetters();
        this.checkStudentType();
    },
    
    methods: {
        checkStudentType(){
            if(window.student_type == 1){
                this.student_type = false;
            }else{
                this.student_type = true;
            }
        },
        changeStudent_type(){
            console.log('changed');
            console.log(this.student_type);
            swal.fire({
                title: 'Are you sure?',
                text: "This will change student type.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.value) {
                    axios.get(`/student_type/change/${window.student_id}/${this.student_type}`).then(res=>{
                        let ress = res.data;
                        if(ress.status == 'success'){
                            if(ress.type == 'domestic'){
                                location.replace(`/student/domestic/${ress.student}`);
                            }else{
                                location.replace(`/student/${ress.student}`);
                            }
                        }
                    })
                }else{
                    this.student_type = !this.student_type;
                }
            })
        },
        getWarningLetters() {
            axios({
                    method: "get",
                    url: this.warningLetter
                })
                .then(res => {
                    // console.log(res);
                    let vm = this;
                    vm.warningLetterList = res.data.warningLetters;
                    vm.warningHistoryList = res.data.warningHistory;
                })
                .catch(err => console.log(err));
        },
        generateStudentDetails() {
            window.open(`/student/details/${window.student_id}/preview`, '_blank');
        },
        viewEmail(item, emailTemp_id) {
            window.open(`/student/warning-letter/${window.student_id}/${emailTemp_id}/preview`, '_blank');
        },
        sendEmail(item, emailTemp_id) {
            // Confirmation    
            swal.fire({
                title: 'Are you sure?',
                text: "This will send a warning letter to student.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, send it!'
            }).then((result) => {
                if (result.value) {
                    // // Loading Alert
                    swal.fire({
                        title: 'Sending Warning Letter',
                        html: 'Please wait...', // add html attribute if you want or remove
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            swal.showLoading()
                        },
                    });
                    // Sending Email 
                    axios({
                        method: 'get',
                        url: `/student/warning-letter/${window.student_id}/${emailTemp_id}/send`,
                    }).then(response => {
                        if (response.data.status == 'success') {
                            swal.fire({
                                title: 'Email sent!',
                                type: 'success',
                                timer: 3000,
                                showConfirmButton: false
                            })
                        } else if (response.data.status == 'notStudying') {
                            // console.log('not studying');
                            Toast.fire({
                                position: 'top-end',
                                type: 'warning',
                                timer: 5000,
                                title: 'The student is currently not studying.',
                            });
                        } else {
                            Toast.fire({
                                position: 'top-end',
                                type: 'error',
                                title: 'Opss.. email was not sent',
                            });
                        }

                    });

                }
            });
        },
        add_on(value) {
            // console.log(this.app_settings.add_on);
            let y = 0;
            if (this.app_settings.add_on != null) {
                let x = this.app_settings.add_on.split(',');
                x.forEach(element => {
                    if (element == value) {
                        y = 1;
                    }
                });
            }
            // return 1 if value matches element
            return y;
        },
    }
};
</script>

<style>
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu>.dropdown-menu {
    top: 0;
    right: 100%;
    margin-top: 0;
    margin-left: -1px;
    -webkit-border-radius: 0 6px 6px 6px;
    -moz-border-radius: 0 6px 6px;
    border-radius: 0 6px 6px 6px;
}

.dropdown-submenu>.dropdown-menu .dropdown-item a {
    width: 100%;
    display: block;
}

.dropdown-submenu>.dropdown-menu .dropdown-item.disabled {
    background-color: #024b67a6;
}

.dropdown-submenu:hover>.dropdown-menu {
    display: block;
}

.dropdown-submenu>a:after {
    display: block;
    content: " ";
    float: left;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 5px 5px 0px;
    border-right-color: #ccc;
    margin-top: 5px;
    margin-left: -10px;
}

.dropdown-submenu:hover>a:after {
    border-left-color: #fff;
}

.dropdown-submenu.pull-left {
    float: none;
}

.dropdown-submenu.pull-left>.dropdown-menu {
    right: -100%;
    margin-right: 10px;
    -webkit-border-radius: 6px 0 6px 6px;
    -moz-border-radius: 6px 0 6px 6px;
    border-radius: 6px 0 6px 6px;
}
</style>
