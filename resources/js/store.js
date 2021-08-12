import Vue from 'vue'
import Vuex from 'vuex'
import moment from 'moment'
import { map } from 'jquery'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        student: {
            info     : {},
            login    : {},
            type     : '',
            contact  : {},
            visa     : {},
            avetmiss : {},
            enrolment: {},
            notes    : {},
            warning_history : {},
            student_type : {},
            funded_course : {},
            invoice : {},
        },
    },
    getters: {
        info     : (state) => state.student.info,
        type     : (state) => state.student.type,
        contact  : (state) => state.student.contact,
        visa     : (state) => state.student.visa,
        avetmiss : (state) => state.student.avetmiss,
        login    : (state) => state.student.login,
        enrolment: (state) => state.student.enrolment,
        notes    : (state) => state.student.notes,
        warning_history : (state) => state.student.warning_history,
        student_type : (state) => state.student.student_type,
        funded_course : (state) => state.student.funded_course,
        invoice : (state) => state.student.invoice,
    },
    actions: {

        async getStudentInfo(context, student_id) {
            await axios.get(`/test/student/${student_id}/show`).then((response) => {
                context.commit("student", response.data);
                context.commit('type', response.data.type)
                context.commit("contact", {
                    contact: response.data.contact_detail,
                    student_details: response.data.latest_offer_letter != null ? response.data.latest_offer_letter.student_details : null
                    }
                );
                context.commit('visa', response.data.visa_details);
                context.commit('avetmiss', response.data.funded_detail);
                context.commit('logins', response.data.party);
                context.commit('enrolment', response.data.enrolment_pack);

                context.commit('notes', response.data.notes);
                context.commit('warning_history', response.data.warning_history);
                context.commit('student_type', response.data.type)
                context.commit('funded_course', response.data.funded_course)
                context.commit('invoice', response.data.invoice)
                swal.close();
            }).catch(err => {
                console.log(err);
            })
        },
        async reportAvetmiss({ commit, state }, report_avetmiss) {
            let student_id = state.student.info.student_id;
            await axios({
                method: "get",
                url: `/student/details/report-avetmiss/${student_id}/${report_avetmiss}`,
            }).then((res) => {

                commit('ravetmiss', report_avetmiss);
            }).catch((err) => console.log(err));
        },
        async verify_usi({ commit, state }){
            let apiBaseUrl = "https://usiapi.vorx.com.au:8443/api/";
            let student_info = {}
            if (state.student.avetmiss.unique_student_id == null){
                swal.fire({
                    title: "Opss.. Unique Student ID must not be empty",
                    type: "error",
                    timer: 3000,
                    showConfirmButton: false,
                });
            }else{
                if (state.student.info.lastname == null){
                    student_info = {
                        singleName: state.student.info.firstname,
                        usi: state.student.avetmiss.unique_student_id,
                        dateOfBirth: state.student.info.date_of_birth != null ? moment(state.student.info.date_of_birth).format('YYYY-MM-DD') : null,
                        orgCode: app_settings.training_organisation_id
                    }
                }else{
                    student_info = {
                        firstName: state.student.info.firstname,
                        familyName: state.student.info.lastname,
                        usi: state.student.avetmiss.unique_student_id,
                        dateOfBirth: state.student.info.date_of_birth != null ? moment(state.student.info.date_of_birth).format('YYYY-MM-DD') : null,
                        orgCode: app_settings.training_organisation_id
                    }
                }
            }


            console.log(student_info);
        }
    },
    mutations: {
        login: (state, data) => state.student.login.user = data,
        avetmiss : (state , data) => {
            let avetmiss_details = {}

            if(data != null){
                let country = []
                if (data.country_id != ''){
                    let arr = data.country_id.split(',')
                    arr.forEach(element => {
                        slct_country.filter(e => {
                            if (e.id == element) country.push(e);
                        });

                    })
                }
                let disabilities = []
                if (data.disability_ids != ''){
                    let arr = data.disability_ids.split(',')
                    arr.forEach(element=>{
                        slct_disability.filter(e=>{
                            if (e.id == element) disabilities.push(e);
                        });

                    })
                }
                let educational_achievements = []
                if (data.prior_educational_achievement_ids != '') {
                    let arr = data.prior_educational_achievement_ids.split(',')
                    arr.forEach(element => {
                        slct_educ_achievement.filter(e => {
                            if (e.id == element) educational_achievements.push(e);
                        });

                    })
                }
                avetmiss_details = {
                    student_id: data.student_id,
                    name_for_encryption: data.name_for_encryption,
                    highest_school_level_completed_id: data.highest_school_level_completed_id,
                    indigenous_status_id: data.indigenous_status_id,
                    location: data.location,
                    language_id: data.language_id,
                    labour_force_status_id: data.labour_force_status_id,
                    country_id: country,
                    disability_flag: data.disability_flag,
                    disability_ids: disabilities,
                    prior_educational_achievement_flag: data.prior_educational_achievement_flag,
                    prior_educational_achievement_ids: educational_achievements,
                    at_school_flag: data.at_school_flag,
                    institute: data.institute,
                    unique_student_id: data.unique_student_id,
                    survey_contact_status: data.survey_contact_status,
                    statistical_area_level_1_id: data.statistical_area_level_1_id,
                    statistical_area_level_2_id: data.statistical_area_level_2_id,
                    aiss_check_date: data.aiss_check_date,
                    year_completed: data.year_completed,
                }
            }else{
                avetmiss_details = {
                    student_id: state.student.info.student_id,
                    name_for_encryption: null,
                    highest_school_level_completed_id: null,
                    indigenous_status_id: null,
                    location: null,
                    language_id: null,
                    labour_force_status_id: null,
                    country_id: null,
                    disability_flag: null,
                    disability_ids: disabilities,
                    prior_educational_achievement_flag: null,
                    prior_educational_achievement_ids: educational_achievements,
                    at_school_flag: null,
                    institute: null,
                    unique_student_id: null,
                    survey_contact_status: null,
                    statistical_area_level_1_id: null,
                    statistical_area_level_2_id: null,
                    aiss_check_date: null,
                    year_completed: null,
                }
            }



            state.student.avetmiss = avetmiss_details
        },

        updateContactInfo : (state,data) => state.student.contact = data,

        updateInfo  : (state, data) => {
            let student_info = {
                student_id: data.student_id,
                name: data.name,
                firstname: data.firstname,
                lastname: data.lastname,
                middlename: data.middlename,
                gender: data.gender,
                prefix: data.prefix,
                date_of_birth: moment(data.date_of_birth)._d,
                report_avetmiss: data.report_avetmiss
            }
            state.student.info = student_info
        },
        student : (state, data) => {
            let student_info = {
                student_id: data.student_id,
                name: data.party.name,
                firstname: data.party.person.firstname,
                lastname: data.party.person.lastname,
                middlename: data.party.person.middlename,
                gender: data.party.person.gender,
                prefix: data.party.person.prefix,
                date_of_birth: moment(data.party.person.date_of_birth)._d,
                report_avetmiss: data.report_avetmiss,
                is_test: data.is_test
            }
            state.student.info = student_info;
        },
        ravetmiss   : (state, data) => state.student.info.report_avetmiss = data,
        type    : (state, data) => state.student.type = data.type,
        contact : (state, data) =>{
            let contact = {}
            if(data.contact.postcode != null){

                contact = {
                    addr_building_property_name     :   data.contact.addr_building_property_name,
                    addr_flat_unit_detail           :   data.contact.addr_flat_unit_detail,
                    addr_postal_delivery_box        :   data.contact.addr_postal_delivery_box,
                    addr_street_name                :   data.contact.addr_street_name,
                    addr_street_num                 :   data.contact.addr_street_num,
                    addr_suburb                     :   { id : data.contact.postcode.id, value : data.contact.postcode.postcode + ' - ' + data.contact.postcode.suburb + ' , ' + data.contact.postcode.state},
                    email                           :   data.contact.email,
                    email_at                        :   data.contact.email_at,
                    emer_address                    :   data.contact.emer_address,
                    emer_name                       :   data.contact.emer_name,
                    emer_relationship               :   data.contact.emer_relationship,
                    emer_telephone                  :   data.contact.emer_telephone,
                    home_address                    :   data.contact.home_address,
                    id                              :   data.contact.id,
                    phone_home                      :   data.contact.phone_home,
                    phone_mobile                    :   data.contact.phone_mobile,
                    phone_work                      :   data.contact.phone_work,
                    postcode                        :   data.contact.postcode.postcode,
                    state_id                        :   data.contact.state_id,
                    student_id                      :   data.contact.student_id

                }
            }else{
                contact = {
                    addr_building_property_name: data.contact.addr_building_property_name,
                    addr_flat_unit_detail: data.contact.addr_flat_unit_detail,
                    addr_postal_delivery_box: data.contact.addr_postal_delivery_box,
                    addr_street_name: data.contact.addr_street_name,
                    addr_street_num: data.contact.addr_street_num,
                    addr_suburb: null,
                    email: data.contact.email,
                    email_at: data.contact.email_at,
                    emer_address: data.contact.emer_address,
                    emer_name: data.contact.emer_name,
                    emer_relationship: data.contact.emer_relationship,
                    emer_telephone: data.contact.emer_telephone,
                    home_address: data.contact.home_address,
                    id: data.contact.id,
                    phone_home: data.contact.phone_home,
                    phone_mobile: data.contact.phone_mobile,
                    phone_work: data.contact.phone_work,
                    postcode: null,
                    state_id: data.contact.state_id,
                    student_id: data.contact.student_id

                }
            }

            let home_addr = ''
            if(data.student_details != null){
                home_addr =  data.student_details.home_address
            }
            contact.home_address = home_addr
            state.student.contact = contact;
        },
        visa    : (state, data) => {
            let visa_detail = {}
            if(data == null){
                visa_detail = {
                    student_id: state.student.info.student_id,
                    nationality: null,
                    passport_number: null,
                    issue_date: null,
                    expiry_date: null,
                    visa_type: null,
                    subclass: null,
                    expiry_date_visa_type: null,
                    applied_for_au_residency: 'No',
                    study_rights: 'No',
                }
            } else{
                let vtype = null
                if( data.type != null ){
                    vtype = {
                        id: data.type.id,
                        value: data.type.visa
                    }
                }
                visa_detail  = {
                    student_id: data.student_id,
                    nationality: data.nationality,
                    passport_number: data.passport_number,
                    issue_date: data.issue_date !=  null ?  moment(data.issue_date)._d : null,
                    expiry_date: data.expiry_date != null ? moment(data.expiry_date)._d : null,
                    visa_type: vtype,
                    subclass: data.subclass,
                    expiry_date_visa_type: data.expiry_date_visa_type != null ? moment(data.expiry_date_visa_type)._d : null,
                    study_rights: data.study_rights,
                    applied_for_au_residency: data.applied_for_au_residency,
                    id: data.id,
                }
            }
            state.student.visa = visa_detail;
        },
        logins : (state,data) => state.student.login = data,
        enrolment : (state,data) => {
                let ep = [];
                data.map((element) => {
                    element.funded_course.forEach(function(fc){
                        if (typeof fc.attendance != 'undefined') {
                            if (fc.attendance != null) {
                                fc.attendance.admod = {};
                            }
                        }
                    });
                    ep.push({
                        process_id : element.process_id,
                        offer_letter : element.offer_letter,
                        student_type: element.student_type,
                        ptr: JSON.parse(element.ptr),
                        funded_course: element.funded_course,
                    })
                })

            state.student.enrolment = ep
        },
        updateEnrolment : (state,data) =>{
            let ep = state.student.enrolment
            ep.map(element=>{
                if(element.process_id == data.process_id){
                    var enrolment = [];
                    enrolment.push({
                        process_id : data.process_id,
                        offer_letter : data.offer_letter,
                        student_type: data.student_type,
                        ptr: JSON.parse(data.ptr),
                        funded_course: data.funded_course,
                    });

                    element = enrolment
                }
            });
            // if(element.process = data.process_id){
            //     element.ptr = data.ptr
            // }
        },
        notes  : (state, data) => state.student.notes = data.reverse(),
        updateNote : (state,data) => {
            let notes = state.student.notes
            if(data.deleted){
                notes = notes.filter(element=>{
                    if(element.id != data.note_id){
                        return element
                    }
                })
            }else{
                if(data.edit){
                    notes.map((element)=>{
                        if(element.id == data.res.id){
                            element.remarks = data.res.remarks
                        }
                    })
                }else{
                    notes.unshift(data.res)
                }
            }
            state.student.notes = notes

        },
        warning_history  : (state, data) => {
            let warning = [];
            data.map((element, key) => {
                warning.push({
                    id : key+1,
                    email_template_type : element.template.name,
                    date_sent : moment(element.date_sent).format('DD/MM/YYYY'),
                    course_code : element.course_code,
                })
            })
            state.student.warning_history = warning
        },
        // attendance  : (state, data) => state.student.attendance = data.reverse(),
        student_type  : (state, data) => state.student.student_type = data,
        funded_course  : (state, data) => //state.student.funded_course = data.reverse(),
            {
                // console.log('funed');
                // console.log(funded_course);
                let fc = [];
                data.map((element) => {

                    if(element.process_id == null){
                        fc.push(element)
                    }
                })
            state.student.funded_course = fc
        },
        invoice  : (state, data) => state.student.invoice = data,

    }
})
