<template>
    <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">Automations</h6>
            </div>
            <div class="card-body">
                <div>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a v-bind:class="'nav-item nav-link-'+app_color+' active'" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true" >Enrolment List</a>
                            <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-email-warning-tab" data-toggle="tab" href="#nav-email-warning" role="tab" aria-controls="nav-email-warning" aria-selected="false" >Fees Email Warning</a>
                            <!-- <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-attachments-tab" data-toggle="tab" href="#nav-attachments" role="tab" aria-controls="nav-attachments" aria-selected="false" >Attachments</a> -->
                            
                            <!-- WARNING LETTER FOR ATTENDANCE -->
                            <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-ew-attendance-tab" data-toggle="tab" href="#nav-ew-attendance" role="tab" aria-controls="nav-ew-attendance" aria-selected="false" >Attendance Email Warning</a>

                            <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-ew-attendance-tab" data-toggle="tab" href="#nav-pd-plan" role="tab" aria-controls="nav-pd-plan" aria-selected="false" >PD Plan</a>

                            <!-- AGENT REMINDER -->
                            <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-agent-reminder-tab" data-toggle="tab" href="#nav-agent-reminder" role="tab" aria-controls="nav-agent-reminder" aria-selected="false" >Agent Reminder</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                            <enrolment-list></enrolment-list>
                        </div>
                        <div class="tab-pane fade" id="nav-email-warning" role="tabpanel" aria-labelledby="nav-email-warning-tab">
                            <!-- <email-warning></email-warning> -->
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a v-bind:class="'nav-item nav-link-'+app_color+' active'" id="nav-ew-tab" data-toggle="tab" href="#nav-ew" role="tab" aria-controls="nav-ew" aria-selected="true" >Templates</a>
                                    <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-config-ew-tab" data-toggle="tab" href="#nav-config-ew" role="tab" aria-controls="nav-config-ew" aria-selected="false" >Configuration</a>

                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-ew" role="tabpanel" aria-labelledby="nav-ew-tab">
                                    <email-warning></email-warning>
                                </div>
                                <div class="tab-pane fade" id="nav-config-ew" role="tabpanel" aria-labelledby="nav-config-ew-tab">
                                    <email-warning-config></email-warning-config>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="tab-pane fade" id="nav-attachments" role="tabpanel" aria-labelledby="nav-attachments-tab">
                            <agent-attachment></agent-attachment>
                        </div> -->
                        
                        <!-- WARNING LETTER FOR ATTENDANCE -->
                        <div class="tab-pane fade" id="nav-ew-attendance" role="tabpanel" aria-labelledby="nav-ew-attendance-tab">
                            <!-- <email-warning></email-warning> -->
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a v-bind:class="'nav-item nav-link-'+app_color+' active'" id="nav-ew-att-tab" data-toggle="tab" href="#nav-ew-att" role="tab" aria-controls="nav-ew-att" aria-selected="true" >Templates</a>
                                    <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-config-ew-att-tab" data-toggle="tab" href="#nav-config-ew-att" role="tab" aria-controls="nav-config-ew-att" aria-selected="false" >Configuration</a>

                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-ew-att" role="tabpanel" aria-labelledby="nav-ew-att-tab">
                                    <attendance-email-warning></attendance-email-warning>
                                </div>
                                <div class="tab-pane fade" id="nav-config-ew-att" role="tabpanel" aria-labelledby="nav-config-ew-att-tab">
                                    <attendance-email-warning-config></attendance-email-warning-config>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-pd-plan" role="tabpanel" aria-labelledby="nav-pd-plan">
                            <!-- <email-warning></email-warning> -->
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a v-bind:class="'nav-item nav-link-'+app_color+' active'" id="nav-pd-planz-tab" data-toggle="tab" href="#nav-pd-planz" role="tab" aria-controls="nav-pd-planz" aria-selected="true" >PD Plan</a>
                                    <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-pd-plan-tab" data-toggle="tab" href="#nav-pd-plan-template" role="tab" aria-controls="nav-pd-plan" aria-selected="false" >Templates</a>
                                    <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-contact-pd-plan-tab" data-toggle="tab" href="#nav-contact-pd-plan" role="tab" aria-controls="nav-contact-pd-plan" aria-selected="false" >Email segments</a>
                                    <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-config-pd-plan-tab" data-toggle="tab" href="#nav-config-pd-plan" role="tab" aria-controls="nav-config-pd-plan" aria-selected="false" >Configuration</a>

                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-pd-planz" role="tabpanel" aria-labelledby="nav-pd-planz-tab">
                                    <pd-plan-component :pdVars="pdVars"/>
                                </div>
                                <div class="tab-pane fade" id="nav-pd-plan-template" role="tabpanel" aria-labelledby="nav-pd-plan-tab">
                                    <pd-plan-email-template :pdVars="pdVars"></pd-plan-email-template>
                                </div>
                                <div class="tab-pane fade" id="nav-contact-pd-plan" role="tabpanel" aria-labelledby="nav-contact-pd-plan-tab">
                                   <email-segments :pdVars="pdVars" />
                                </div>
                                <div class="tab-pane fade" id="nav-config-pd-plan" role="tabpanel" aria-labelledby="nav-config-pd-plan-tab">
                                    <pd-configuration :pdVars="pdVars"></pd-configuration>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-agent-reminder" role="tabpanel" aria-labelledby="nav-agent-reminder-tab">
                            <!-- <email-warning></email-warning> -->
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a v-bind:class="'nav-item nav-link-'+app_color+' active'" id="nav-agent-rem-tab" data-toggle="tab" href="#nav-agent-rem" role="tab" aria-controls="nav-agent-rem" aria-selected="true" >Templates</a>
                                    <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-config-agent-rem-tab" data-toggle="tab" href="#nav-config-agent-rem" role="tab" aria-controls="nav-config-agent-rem" aria-selected="false" >Configuration</a>

                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-agent-rem" role="tabpanel" aria-labelledby="nav-agent-rem-tab">
                                    <agent-reminder-email-template></agent-reminder-email-template>
                                </div>
                                <div class="tab-pane fade" id="nav-config-agent-rem" role="tabpanel" aria-labelledby="nav-config-agent-rem-tab">
                                    <agent-email-reminder-config></agent-email-reminder-config>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    
</template>


<script>
// import ToolbarActions from "../../components/globals/ToolbarActionsComponent.vue";
import EnrolmentList from "./autoEnrolmentListComponent.vue";
import EmailWarningConfig from "./autoEmailWarningConfigComponent.vue";
import EmailWarning from "../email-sending/emailTemplateComponent.vue";
import AttendanceEmailWarning from "./attendance/emailTemplateComponent.vue";
import AttendanceEmailWarningConfig from "./attendance/autoEmailWarningAttendanceComponent.vue";
import PdPlanEmailTemplate from "./pd-plan/emailTemplateComponent.vue";
import PdConfiguration from "./pd-plan/configurationComponent.vue";
import EmailSegments from "./pd-plan/emailSegmentsComponent";
import PdPlanComponent from "./pd-plan/pdPlanComponent";
import AgentReminderEmailTemplate from "./agent-reminder/emailTemplateComponent.vue";
import AgentEmailReminderConfig from "./agent-reminder/agentEmailReminderConfigComponent.vue";

export default {
  // mounted() {
  //     console.log('Component mounted.')
  // }
  components: {
      // ToolbarActions,
      EnrolmentList,
      EmailWarningConfig,
      EmailWarning,
      AttendanceEmailWarning,
      AttendanceEmailWarningConfig,
      PdPlanEmailTemplate,
      PdConfiguration,
      EmailSegments,
      PdPlanComponent,
      AgentReminderEmailTemplate,
      AgentEmailReminderConfig
  },
  mounted(){
      this.fetchPdVars();
  },
  data() {
    return {
      app_color: app_color,
      pdVars:[
      ],
      update:false,
    //   enrolment_list: window.enrolment_list
    };
  },
  methods:{
      fetchPdVars(){
          axios.get('/pdplan/fetchVars').then(
              response=>{
                  response.data.pd_plans.forEach(function(data){
                      if(data.email_to!=''){
                          data.email_to = JSON.parse(data.email_to);
                      }
                  });
                  this.pdVars = response.data
              }
          );
      }
  },
  watch:{
      update(){
          this.fetchPdVars();
      },
  }
};
</script>

<style>
.tab-pane {
  border: 1px solid #e0dfdf;
  border-top: none;
  padding: 1.3rem;
  border-bottom-right-radius: 5px;
  border-bottom-left-radius: 5px;
  background-color: #ffffff;
}
</style>