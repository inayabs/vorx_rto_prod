<template>
    <div class="card" id="app">
        
        <div class="card border-0 shadow-lg">
            <div class="card-header">
                <span class="font-weight-bold h5"> Online payment checkout</span>
            </div>
            <div class="card-body p-3">
                <form class="row" @submit.prevent id="payment-form">
                    <div class="col-md-12">
                        <div class="form-group">
                            <i><b>Note: input fields can be updated through <a href="/student-profile">student profile</a></b></i>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for=""><span class="font-weight-bold">Receipt Email</span> </label>
                            <input type="email" class="form-control" name="receipt_email" id="receipt_email" v-model="student_details.student_details.email_personal" readonly>
                            <div v-if="errors && errors['receipt_email']" class="badge badge-danger">{{ errors['receipt_email'][0] }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for=""><span class="font-weight-bold">Firstname</span> </label>
                            <input type="text" class="form-control" name="firstname" id="firstname" v-model="student_details.student.party.person.firstname" readonly>
                            <div v-if="errors && errors['firstname']" class="badge badge-danger">{{ errors['firstname'][0] }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for=""><span class="font-weight-bold">Lastname</span> </label>
                            <input type="text" class="form-control" name="lastname" id="lastname" v-model="student_details.student.party.person.lastname" readonly>
                            <div v-if="errors && errors['lastname']" class="badge badge-danger">{{ errors['lastname'][0] }}</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for=""><span class="font-weight-bold">Name on Card</span> </label>
                            <input type="text" class="form-control" name="name_on_card" id="name_on_card" v-model="name_on_card">
                            <div v-if="errors && errors['name_on_card']" class="badge badge-danger">{{ errors['name_on_card'][0] }}</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for=""><span class="font-weight-bold">Full Address</span> </label>
                            <input type="text" class="form-control" name="address" id="address" v-model="student_details.student_details.current_address" readonly>
                            <div v-if="errors && errors['address']" class="badge badge-danger">{{ errors['address'][0] }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for=""><span class="font-weight-bold">Postal Code</span> </label>
                            <input type="text" class="form-control" name="postal_code" id="postal_code" v-model="student_details.student_details.postcode" readonly>
                            <div v-if="errors && errors['postal_code']" class="badge badge-danger">{{ errors['postal_code'][0] }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for=""><span class="font-weight-bold">Phone</span> </label>
                            <input type="number" class="form-control" name="phone" min="0" v-model="student_details.student_details.mobile" readonly>
                            <div v-if="errors && errors['phone']" class="badge badge-danger">{{ errors['phone'][0] }}</div>
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
                            <div v-if="errors && errors['amount']" class="badge badge-danger">{{ errors['amount'][0] }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for=""><span class="font-weight-bold">Remaining Balance</span> </label>
                            <p class="text-right">AU $ {{remaining_balance}}</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="card-element">
                                Credit or debit card
                                </label>
                                <div id="card-element">
                                    <card
                                        :class="{complete}"
                                        stripe="pk_test_51I7Bg3FU7cjv0OpgYeZ1COg6QrukVb8DqG7CmYTG7riv01SbFqTpbL0SeHVvg6qcy37q6cg2xHZBhSGTWlt4WLpZ007qEFk5xz"
                                        :options="stripeOptions"
                                        @change="change($event)"
                                    />
                                    <div id="card-errors" role="alert" v-text="errorMessage"></div>

                                <!-- A Stripe Element will be inserted here. -->
                                </div>

                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>
                        </div>
                    <div class="col-md-12">
                        <button :class="'btn btn-success'" :disabled="btnClass" @click="pay">Submit payment</button>
                    </div><br>
                </form>
            </div>
        </div>
    </div>  
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
            complete:false,
            payment_data:window.payment_data?window.payment_data:'no data',
            student_details:window.student_details?window.student_details:'',
            remaining_balance:window.remaining_balance?window.remaining_balance:'',
            student_user_id:user_id,
            errorMessage:'',
            errors:[],
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
            stripeToken:'',
            name_on_card:'',
            amount:''
            
            // app_color:app_color
        }
    },
    methods:{
        pay(){
            swal.fire({
                title: 'Please wait...',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                swal.showLoading()
                },
            });

            let customer_id='';
            let dis = this;
            axios.get('/student-portal/online-payment/stripe/getcustomer/'+this.student_details.student_id).then(
                response=>{
                    customer_id = response.data;
                    var options = {
                        name:customer_id,
                        email:this.student_details.student_details.email_personal
                    }
                    createToken(options).then(
                        result=>{
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
                                swal.fire({
                                    type: 'error',
                                    title: 'Something went wrong.',
                                    text: result.error.message
                                })
                            }

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
                                payment_details:this.payment_details,
                                stripe_token:result.token.id,
                                funded_course_id:this.payment_data.id,
                                offer_letter_course_detail_id:this.payment_data.offer_letter_course_detail_id,
                                amount:this.amount,
                                customer_id:customer_id,
                                receipt_email:this.student_details.student_details.email_personal,
                                firstname:this.student_details.student.party.person.firstname,
                                lastname:this.student_details.student.party.person.lastname,
                                name_on_card:this.name_on_card,
                                full_address:this.student_details.student_details.current_address,
                                postal_code:this.student_details.student_details.postcode,
                                phone:this.student_details.student_details.mobile
                            }).then(
                                response=>{
                                    if(response.data.status=='success'){
                                        swal.fire(
                                            'Success!',
                                            response.data.message,
                                            'success'
                                        )
                                        this.remaining_balance = response.data.remaining_balance
                                        this.amount = ''
                                        // location.href = '/student_fees'
                                    }else{
                                        this.errors = response.data.errors
                                        swal.close();
                                    }
                                }
                            ).catch(
                                err=>{
                                    this.errorMessage = err;
                                }
                            );
                            }
                        ).catch(
                            erz=>{
                                console.log(erz);
                            }
                        ) 
                }
            );
            
            
            
        },
        change(event){
            if (event.error) {
                this.errorMessage = event.error.message;
                // console.log(event.error.message);
            } else {
                this.errorMessage = '';
            }
        },
    },
    watch:{
        amount:function(disVal){
            if(disVal > this.remaining_balance){
                this.amount = this.remaining_balance
                // console.log('fucl');
            }
        }
    },
    computed:{
        btnClass(){
            // this.errorMessage!=''? '' : 'disabled';
            if(this.errorMessage!=''){
                return true
            }else{
                return false
            }
        }
    }
}
</script>
<style>
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