<template>
    <modal
        name="pay-modal"
        transition="nice-modal-fade"
        classes="demo-modal-class"
        :min-width="200"
        :min-height="200"
        :pivot-y="0.1"
        :adaptive="true"
        :scrollable="true"
        :reset="true"
        width="40%"
        height="auto"
    >
    <div class="card">
    <div class="card-header">
      <span><span style="font-size:20px;">Online Payment </span><span style="font-size:12px;"><i>(<b>student fields can be updated through <a href="/student-profile">student profile</a></b>)</i></span></span>
    </div>
    <form class="row" @submit.prevent id="payment-form" hidden>
    </form>
    <div class="card-body">
      <!-- <div>
        <a href="javascript:void(0)" class="btn btn-sm btn-info float-right" @click="getDetails()"><i class="fas fa-paste"></i> Use Details</a>
      </div> -->
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Receipt Email</label>
            <input type="email" class="form-control border-0 bg-white" v-model="receipt_email" disabled>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Name on Card</label>
            <input type="text" class="form-control border-0 bg-white" v-model="name_on_card" disabled>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="">Full Address</label>
            <input type="text" class="form-control" v-model="full_address">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Postal Code</label>
            <input type="text" class="form-control" v-model="postal_code">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Phone</label>
            <input type="text" class="form-control" v-model="phone">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for=""><span class="font-weight-bold">Amount
                    <a
                    href="#"
                    data-toggle="tooltip"
                    :class="'a-'+app_color"
                    :title="'Additional service fee will be charged.'"
                    data-placement="right"
                    >
                    <i class="fas fa-info-circle"></i>
                </a>
                </span> </label><span style="font-size: 74%;opacity: 73%;">( AUD )</span>
            
            <input type="number" class="form-control" name="amount" min="0" step="0.01" placeholder="AUD" v-model="amount">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Credit/Debit Card</label>
            <div id="card-element">
                <card
                    v-model="card_no"
                    :class="{complete}"
                    stripe="pk_test_51I7Bg3FU7cjv0OpgYeZ1COg6QrukVb8DqG7CmYTG7riv01SbFqTpbL0SeHVvg6qcy37q6cg2xHZBhSGTWlt4WLpZ007qEFk5xz"
                    :options="stripeOptions"
                    @change="change($event)"
                />
                <div id="card-errors" role="alert" v-text="errorMessage"></div>

            <!-- A Stripe Element will be inserted here. -->
            </div>
          </div>

          <!-- Used to display form errors. -->
          <div id="card-errors" role="alert"></div>
        </div>
        <div class="col-md-12">
          <button :class="'btn btn-success pull-right'" :disabled="payment_submit" @click="pay">
              <span v-if="payment_submit==false">Submit Payment</span>
              <span v-else><i class="fas fa-circle-notch fa-spin"></i> Please wait...</span>
          </button>
          <!-- <button :class="'btn btn-success pull-right'" :disabled="true" @click="pay"><i class="fas fa-circle-notch fa-spin"></i> Please wait...</button> -->
        </div>
      </div>
    </div>
    </div>
    </modal>
</template>
<script>
import { Card, createToken } from 'vue-stripe-elements-plus'
export default {
    components:{
      Card
    },
    data(){
        return{
            app_color:app_color,
            accept_terms:false,
            user:user,
            errors:[],
            amount:'',
            payment_submit:false,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            complete:false,
            errorMessage:'',
            stripeOptions:{
                style:{
                    base: {
                        color: '#32325d',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                        color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    },
                },
                hidePostalCode:true
            },
            receipt_email:'',
            name_on_card:'',
            full_address:'',
            postal_code:'',
            phone:'',
            amount:null,
            card_no:null,
        }
    },
    mounted(){
      this.receipt_email = this.student.contact_detail.email;
      this.name_on_card = this.student.party.name;
      this.postal_code = this.student.contact_detail.postcode;
      this.phone = this.student.contact_detail.phone_mobile;
    },
    props:['course','student'],
    computed:{
      classObject:function(){
        if(this.accept_terms==false){
          return true
        }else{
          return false
        }
      }
    },
    methods:{
      getDetails(){
        
      },
      pay(){
        this.payment_submit = true;
          
        let customer_id = '';
        let dis = this;

        axios.get(`/student-portal/online-payment/stripe/getcustomer/${this.student.student_id}`).then(
          response=>{
            customer_id = response.data;
            var options = {
              name:customer_id,
              email:this.receipt_email
            }
      
            createToken(options).then(
              result=>{
                console.log('result ni');
                  if(typeof result.token == 'undefined'){
                      swal.fire({
                          type: 'error',
                          title: 'Something went wrong.',
                          text: 'Token not found'
                      })
                  }

                  if(result.error){
                      // console.log(result.error);
                      this.errorMessage = result.error.message
                      
                      Toast.fire({
                        type: "error",
                        title: "Something went wrong..",
                        position: "top-end",
                      });
                      dis.payment_submit = false;
                  }else{

                    var form = document.getElementById('payment-form');
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', result.token.id);
                    form.appendChild(hiddenInput);
                    // this.stripeToken = result.token.id;
                    // Submit the form
                    // alert(token.id);
                    // form.submit();
                    axios.post('/student-portal/online-payment/stripe/pay',{
                        // payment_details:this.payment_details,
                        stripe_token:result.token.id,
                        funded_course_id:this.course.id,
                        // offer_letter_course_detail_id:this.payment_data.offer_letter_course_detail_id,
                        amount:this.amount,
                        customer_id:customer_id,
                        receipt_email:this.receipt_email,
                        // firstname:this.student_details.student.party.person.firstname,
                        // lastname:this.student_details.student.party.person.lastname,
                        name_on_card:this.name_on_card,
                        full_address:this.full_address,
                        postal_code:this.postal_code,
                        phone:this.phone
                    }).then(
                        response=>{
                            if(response.data.status=='success'){
                                dis.payment_submit = false;

                                this.$parent.getPayments();
                                this.remaining_balance = response.data.remaining_balance
                                this.amount = '';
                                
                                swal.fire(
                                    'Success!',
                                    response.data.message,
                                    'success'
                                ).then(
                                  result=>{
                                    dis.$modal.hide('pay-modal');
                                  }
                                );
                                // location.href = '/student_fees'
                            }else{
                                this.errors = response.data.errors
                                swal.close();
                            }
                        }
                    ).catch(
                        err=>{
                            Toast.fire({
                              type: "error",
                              title: err.response.data.message,
                              position: "top-end",
                            });
                            this.errorMessage = err;
                            dis.payment_submit = false;
                        }
                    );
                  }

                }
              ).catch(
                  erz=>{
                      Toast.fire({
                        type: "error",
                        title: erz.response.data.message,
                        position: "top-end",
                      });
                      console.log(erz);
                      dis.payment_submit = false;
                  }
              ) 
          }
        ).catch(
          erro=>{
            Toast.fire({
              type: "success",
              title: erro,
              position: "top-end",
            });

            dis.payment_submit = false;
          }
        )

      },
      change(event){
          if (event.error) {
              this.errorMessage = event.error.message;
          } else {
              this.errorMessage = '';
          }
      },
      next(){
        // alert(this.csrf);
        if(this.amount==''||this.amount==0){
          this.errors = {
            amount:'The amount field is required'
          }
        }else{
          var encoded_id = btoa(this.course.id)
          // console.log(encoded_id);
          location.href="/student-portal/online-payment/"+encoded_id
        }
      }
    },
    watch:{
      amount:function(newVal){
        if(newVal!=''){
          this.errors = []
        }
      }
    },
    computed:{
      btnClass(){
        if(this.errorMessage!=''){
            return true
        }else{
            return false
        }
      }
    }
}
</script>
<style scoped>
.size-modal-content {
  padding: 10px;
  margin: 10px;
  font-style: 13px;
}
.v--modal-overlay[data-modal="size-modal"] {
  background: rgba(0, 0, 0, 0.5);
}
.demo-modal-class {
  border-radius: 5px;
  background: #f7f7f7;
  box-shadow: 5px 5px 30px 0px rgba(46, 61, 73, 0.6);
}

.StripeElement{
    border-color: rgba(0, 0, 0, 0.5) ;
    display: block;
    width: 100%;
    height: calc(1.6em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 0.9rem;
    font-weight: 400;
    line-height: 1.6;
    color: #6e707e;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #d1d3e2;
    border-radius: 0.35rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .StripeElement--invalid {
    border-color: #fa755a;
    }
    #card-errors{
        color: #fa755a;
    }
</style>