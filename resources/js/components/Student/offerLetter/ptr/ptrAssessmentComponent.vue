<template>
    <div>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
            <h6>Instructions</h6>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p>Please review the information that student has provided on this form and if the information provided is not clear enough, interview the student and ask to elaborate.  The information provided through the PTR is important to determine eligibility and applicability for the training.</p>
                <p>
                Please make sure that you consider all the documents submitted by the student along with the application and other documents.
                </p>
            </div>
        </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th width="80%" :class="['background-'+app_color]">Assesment requirements</th>
                    <th :class="['background-'+app_color]">Yes</th>
                    <th :class="['background-'+app_color]">No</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td>
                            <span>Is the course chosen aligned to the student’s employment history/ career objectives and aspirations?</span>
                        </td>
                        <td>
                            <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.course_align_student.yes">
                        </td> 
                        <td>
                            <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.course_align_student.no">
                        </td>
                    </tr>  
                    <tr>
                        <td>
                            <span>The student is fully aware of the course training and assessment arrangements i.e. attendance requirements, course progress requirements training and assessment methods, and any practical training requirements?</span>
                        </td>  
                        <td>
                            <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.training_and_assessment_awareness.yes">
                        </td> 
                        <td>
                            <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.training_and_assessment_awareness.no">
                        </td>
                    </tr>     
                    <tr>
                        <td>
                            <span v-if="student_type==1">The student is fully aware of their rights and obligations as an international student?</span>
                            <span v-else>The student is fully aware of their rights and obligations as a student?</span>
                        </td>  
                        <td>
                            <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.rights_and_obligation_awareness.yes">
                        </td> 
                        <td>
                            <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.rights_and_obligation_awareness.no">
                        </td>
                    </tr>     
                    <tr>
                        <td>
                            <span>Have you identified any support identified during the process?</span>
                        </td>  
                        <td>
                            <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.support_identified.yes">
                        </td> 
                        <td>
                            <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.support_identified.no">
                        </td>
                    </tr>    
                    <tr>
                        <td>
                            <span>Training and assessment strategy is suitable and based on the student’s learning needs and learning styles?</span>
                        </td>  
                        <td>
                            <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.training_and_asses_strat.yes">
                        </td> 
                        <td>
                            <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.training_and_asses_strat.no">
                        </td>
                    </tr>    
                    <tr>
                        <td>
                            <span>Is the training suitable and appropriate based on the student’s achievements, career history, experience, future goals, objectives, capabilities and career aspirations?</span>
                        </td>  
                        <td>
                            <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.suitable_and_appropriate.yes">
                        </td> 
                        <td>
                            <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.suitable_and_appropriate.no">
                        </td>
                    </tr>    
                    <tr>
                        <td>
                            <span>The student is aware of RPL and CT arrangements and application process?</span>
                        </td>  
                        <td>
                            <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.arrangment_awareness.yes">
                        </td> 
                        <td>
                            <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.arrangment_awareness.no">
                        </td>
                    </tr>   
                    <tr>
                        <th colspan="3" :class="['background-'+app_color]">Authorised Person’s declaration</th>
                    </tr> 
                    <tr>
                        <td>
                            <span>Based on the information provided on this form, the student meets the requirements for this course.</span>
                        </td>  
                        <td>
                            <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.student_meets_requirements.yes">
                        </td> 
                        <td>
                            <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.student_meets_requirements.no">
                        </td>
                    </tr>    
            </tbody>
        </table>
        
        <div class="row">
            <div class="col-lg-12">
                <label for="">Comments:</label>
                <textarea name="" id="" cols="30" rows="3" class="form-control" v-model="assessment.comments"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <label for="">Authorised Person's Name:</label>
                <input type="text" class="form-control" v-model="assessment.auth_person_name">
            </div>
            <div class="col-lg-6">
                <label for="">Authorised Person's Position:</label>
                <input type="text" class="form-control" v-model="assessment.auth_person_position">
            </div>
        </div><br>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <p><input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="assessment.auth_person_signature_check"><span>Electronic Transactions (Queensland) Act 2001/Electronic Transactions (Victoria) Act 2000 establishes the regulatory framework for transactions to be completed electronically. This form requires you to tick the boxes and put your name as a electronic signature before submission. By ticking the box and putting the name in signature panel, you indicate your approval of the contents of this electronic offer letter and acceptance agreement. </span></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <label for="">Authorised Person's Signature:</label>
                <input type="text" :disabled="assessment.auth_person_signature_check!=true" id="auth_person_signature" class="form-control type-signature" v-model="assessment.auth_person_signature">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <label for="">Date:</label>
                <span style="font-size: 74%;opacity: 73%;">( DD/M/YYYY )</span>
                <date-picker
                v-model="assessment.auth_date"
                locale="en"
                :masks="{L:'DD/MM/YYYY'}"
                :max-date="new Date()"
                />
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            app_color:app_color
        }
    },
    props:['assessment','student_type']
}
</script>
<style scoped>
    @import url('/public/fonts/brush-script-mt/brush script mt kursiv.ttf');

    .type-signature {
        font-family: 'Brush Script MT', cursive;
        font-size:30px;
    }
</style>