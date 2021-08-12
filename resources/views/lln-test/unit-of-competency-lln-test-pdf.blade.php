<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    @if($app_setting->training_organisation_id == '6074')
    <!-- CEA PDF STYLES -->
    <link type="text/css" href="{{public_path()}}/custom/unit-of-competency-lln-test/pdf-style-cea.css"
        rel="stylesheet" />
    @elseif($app_setting->training_organisation_id == '45633')
    <!-- PCA PDF STYLES -->
    <link type="text/css" href="{{public_path()}}/custom/unit-of-competency-lln-test/pdf-style-pca.css"
        rel="stylesheet" />
    @else
    <!-- DEAFAULT PDF STYLES -->
    <link type="text/css" href="{{public_path()}}/custom/unit-of-competency-lln-test/pdf-style.css" rel="stylesheet" />
    @endif
    
    <title>Language, Literacy and Numeracy (LLN) Test</title>
    <style type="text/css">
    .horizontal-blackline {
        border-bottom: 1px solid #000;
        height: 20px;
        width: 100%
    }

    .lightgreen-bg-color {
        background: #78b526;
    }

    .padding-10 {
        padding: 10px;
    }

    .green-box {
        background: #78b526;
        padding: 4px 10px;
        color: #fff;
        margin-right: 15px;
        display: inline-block;
        line-height: 0.8;
    }

    .signature-pad {
        position: absolute;
        left: 0;
        top: 0;
        width: 200px;
        height: 300px;
    }
    </style>
</head>
<!-- Page 1 -->

<body class="exo2-regular position-relative">
    <div>
        <div class="col-xs-12 no-padding position-relative">
            <div class="pdf-wrapper">
                <div style="margin: 0 10px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="20%">
                                <div class="logo-wrapper">
                                    <!-- <img src="{{ $logo_url }}" alt=""> -->
                                    <img src="{{ $logo_url }}" alt="">
                                </div>
                            </td>
                            <td width="80%" class="proximanova-bold">
                                <p class="primary-font-color px-12-font text-right line-height-1point2">Guide and
                                    Mapping</p>
                                <p class="secondary-font-color px-16-font text-right line-height-1point2">Language,
                                    Literacy and Numeracy (LLN) Test</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div class="pdf-wrapper">
                    <p
                        class="section-header proximanova-bold primary-font-color px-14-font text-justify text-uppercase">
                        <span>Introduction</span></p>
                    <p class="proximanova-bold primary-font-color px-12-font text-justify"><span>Language, Literacy and
                            Numeracy Indicator – What is it?</span></p>
                    <p class="px-11-font text-justify line-height-1point2">The purpose of a Language, Literacy and Numeracy Indicator is to give an idea of your language, literacy and numeracy skills and to determine if you have the appropriate level to undertake the nominated course.</p>
                    <p class="px-11-font text-justify line-height-1point2">This is not an exam and the marks will not reflect on your outcome from your course. This is however, a tool that will ensure you receive the most appropriate learning strategies.</p>
                    <br>
                    <p class="proximanova-bold primary-font-color px-12-font text-justify"><span>So why do I have to sit an assessment?</span></p>
                    <p class="px-11-font text-justify line-height-1point2">Learning a new skill is a complex and highly variable process for anyone. It involves drawing on experiences and skills currently held as well as taking on some entirely new skills, and applying the combination in an altered or even radically new environment.</p>
                    <p class="px-11-font text-justify line-height-1point2">In order to learn new vocational skills, a learner will draw on their current LL&N skills, and will be developing these skills within the context of their training, work and the chosen industry. In many case vocational learning will involve taking new LL&N skills to become competent. For this reason we try and evaluate your level of LL&N prior to you setting out to learn new LL&N skills.</p>
                    <br>
                    <p class="proximanova-bold primary-font-color px-12-font text-justify"><span>What happens if I don’t do well in the assessment?</span></p>
                    <p class="px-11-font text-justify line-height-1point2">Don’t Panic!!! This is not the end of the world. If you do poorly in the LL&N assessment, we need to work out why. Was it nerves, you having a bad day, or is it a learning difficulty. Whatever the case, we will evaluate your result and discuss any issues raised with you. Depending on the severity, we may recommend you see a LL&N specialist councilor or undertake development courses to build your LL&N level to such that will allow you to undertake a career in your chosen field. The minimum required passing marks are 60.</p>
                    <br>
                    <p class="px-11-font text-justify line-height-1point2">If you have any concerns, please speak to your trainer/assessor.</p>
                    <br>
                    <br>
                    <p
                        class="section-header proximanova-bold primary-font-color px-14-font text-justify text-uppercase">
                        <span>Office use only</span></p>
                    <table width="100%" class="table">
                        <tbody>
                            <tr>
                                <td width="50%" valign="top">
                                    <span class="proximanova-bold primary-font-color">Student’s Assessment Marks:</span>
                                    <table width="100%" class="table default-bordered-table">
                                        <tbody>
                                            <tr>
                                                <td width="50%" class="text-center proximanova-bold">Possible Mark</td>
                                                <td width="50%" valign="top">60</td>
                                            </tr>
                                            <tr>
                                                <td width="50%" class="text-center proximanova-bold">Students Mark</td>
                                                <td width="50%" valign="top"> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td width="50%" valign="top">
                                    <!-- <p class="proximanova-bold primary-font-color">Office use only</p>  -->
                                    <span class=" proximanova-bold">Assessor’s Name:</span>
                                    <div class="text-input-line" style="width: 60%;">
                                        <span class="line-height-1 px-11-font" style="position:absolute; top: 3px;">
                                            @if(isset($lln_test['assessor_name']) && $lln_test['assessor_name'] != null)
                                            {{ $lln_test['assessor_name'] }}
                                            @endif
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <p
                        class="section-header proximanova-bold primary-font-color px-14-font text-justify text-uppercase">
                        <span>Applicant Details</span></p>
                    <p class="proximanova-bold primary-font-color px-12-font text-justify"><span>Please complete by
                            printing all your details</span></p>

                    <div>
                        <span class="line-height-1 px-11-font proximanova-bold">Name:</span>
                        <div class="text-input-line" style="width: 40%;">
                            <span class="line-height-1 px-11-font" style="position:absolute; top: 3px;">
                                <span style="padding:0 30px">
                                    @if(isset($lln_test['given_name']) && $lln_test['given_name'] != null)
                                    {{ $lln_test['given_name'] }}
                                    @endif
                                </span>
                                <span style="padding-left:50px">
                                    @if(isset($lln_test['last_name']) && $lln_test['last_name'] != null)
                                    {{ $lln_test['last_name'] }}
                                    @endif</span>
                            </span>
                        </div>
                    </div>
                    <p class="px-11-font text-justify line-height-1point2">
                        <span style="padding:0 60px">(Given Name)</span>
                        <span>(Last Name)</span>
                    </p>
                    <br>
                    <div>
                        <span class="line-height-1 px-11-font proximanova-bold">Date of Birth:</span>
                        <div class="text-input-line" style="width: 20%;">
                            <span class="line-height-1 px-11-font" style="position:absolute; top: 3px;">
                                @if(isset($lln_test['date_of_birth'] ) && $lln_test['date_of_birth'] != null)
                                {{ \Carbon\Carbon::parse($lln_test['date_of_birth'])->format('d/m/Y') }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <br>
                    <p class="px-11-font text-justify line-height-1point2 proximanova-bold">Describe your reasons for
                        undertaking this training program? </p>
                    <div class="textbox long">
                        @if(isset($lln_test['describe_reasons']) && $lln_test['describe_reasons'] != null)
                        {{ $lln_test['describe_reasons'] }}
                        @endif
                    </div>

                </div>





                <div class="footer bottom-placement px-10-font text-center" style="margin-top: -10px;">
                    <p style="margin-bottom: 2px;">© {{ $app_setting->training_organisation_name }} | Version 1.1 | RTO
                        No. {{ $app_setting->training_organisation_id }} </p>
                    <p class="">Page 1 of 3</p>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
<!-- End Page 1 -->
<!-- Page 2 -->

<body class="exo2-regular position-relative">
    <div>
        <div class="col-xs-12 no-padding position-relative">
            <div class="pdf-wrapper">
                <div style="margin: 0 10px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="20%">
                                <div class="logo-wrapper">
                                    <!-- <img src="{{ $logo_url }}" alt=""> -->
                                    <img src="{{ $logo_url }}" alt="">
                                </div>
                            </td>
                            <td width="80%" class="proximanova-bold">
                                <p class="primary-font-color px-12-font text-right line-height-1point2">Guide and Mapping</p>
                                <p class="secondary-font-color px-16-font text-right line-height-1point2">Language, Literacy and Numeracy (LLN) Test</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div class="pdf-wrapper">
                    <p
                        class="section-header proximanova-bold primary-font-color px-14-font text-justify text-uppercase">
                        <span>Getting Started</span></p>
                    <!-- Question 1 -->
                    <p class="px-11-font text-justify line-height-1point2 proximanova-bold"><span
                            class="primary-font-color">Question 1.</span> Fill in the correct word from the brackets and
                        complete the sentence. (10 Marks)</p>
                    <span class="px-11-font text-justify line-height-1point2">
                        <span class="line-height-1 px-11-font">A.) The </span>
                        <div class="text-input-line" style="width: 20%;">
                            <span class="line-height-1 px-11-font proximanova-bold"
                                style="position:absolute; top: 3px;">
                                @if(isset($lln_test['question1_a1']) && $lln_test['question1_a1'] != null)
                                {{ $lln_test['question1_a1'] }}
                                @endif

                            </span>
                        </div>
                        <span class="line-height-1 px-11-font">(personal/personnel) officer made a habit of losing his</span>
                        <div class="text-input-line" style="width: 20%;">
                            <span class="line-height-1 px-11-font proximanova-bold"
                                style="position:absolute; top: 3px;">
                                @if(isset($lln_test['question1_a2']) && $lln_test['question1_a2'] != null)
                                {{ $lln_test['question1_a2'] }}
                                @endif
                            </span>
                        </div>
                        <span class="line-height-1 px-11-font">(patience/patients) when meetings didn’t proceed</span>
                        <span class="line-height-1 px-11-font">As</span>
                        <div class="text-input-line" style="width: 20%;">
                            <span class="line-height-1 px-11-font proximanova-bold"
                                style="position:absolute; top: 3px;">
                                @if(isset($lln_test['question1_a3']) && $lln_test['question1_a3'] != null)
                                {{ $lln_test['question1_a3'] }}
                                @endif
                            </span>
                        </div>
                        <span class="line-height-1 px-11-font">(planned/planed).</span>
                    </span>
                    <br>
                    <div class="clearfix"></div>
                    <br>
                    <span class="px-11-font text-justify line-height-1point2">
                        <span class="line-height-1 px-11-font">B.) At </span>
                        <div class="text-input-line" style="width: 20%;">
                            <span class="line-height-1 px-11-font proximanova-bold"
                                style="position:absolute; top: 3px;">
                                @if(isset($lln_test['question1_b1']) && $lln_test['question1_b1'] != null)
                                {{ $lln_test['question1_b1'] }}
                                @endif
                            </span>
                        </div>
                        <span class="line-height-1 px-11-font"> (presence/ present),</span>
                        <div class="text-input-line" style="width: 20%;">
                            <span class="line-height-1 px-11-font proximanova-bold"
                                style="position:absolute; top: 3px;">
                                @if(isset($lln_test['question1_b2']) && $lln_test['question1_b2'] != null)
                                {{ $lln_test['question1_b2'] }}
                                @endif
                            </span>
                        </div>
                        <span class="line-height-1 px-11-font">(preferable/preferential) consideration is given to those
                            who have held office in</span>
                        <span class="line-height-1 px-11-font">The</span>
                        <div class="text-input-line" style="width: 20%;">
                            <span class="line-height-1 px-11-font proximanova-bold"
                                style="position:absolute; top: 3px;">
                                @if(isset($lln_test['question1_b3']) && $lln_test['question1_b3'] != null)
                                {{ $lln_test['question1_b3'] }}
                                @endif
                            </span>
                        </div>
                        <span class="line-height-1 px-11-font"> (passed/past).</span>
                    </span>
                    <br>
                    <br>
                    <!-- Question 2 -->
                    <p class="px-11-font text-justify line-height-1point2 proximanova-bold"><span
                            class="primary-font-color">Question 2.</span> Fill in the missing one or two letters in the
                        following words: (10 Marks)</p>
                    <table width="30%" class="table default-bordered-table">
                        <tbody>
                            <tr>
                                <td>
                                    <span class="px-11-font text-justify line-height-1point2">
                                        <span class="line-height-1 px-11-font">advanta</span>
                                        <div class="text-input-line" style="width: 15%;">
                                            <span class="line-height-1 px-11-font proximanova-bold"
                                                style="position:absolute; top: 3px;">
                                                @if(isset($lln_test['question2_1']) && $lln_test['question2_1'] != null)
                                                {{ $lln_test['question2_1'] }}
                                                @endif

                                            </span>
                                        </div>
                                        <span class="line-height-1 px-11-font">eous</span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="px-11-font text-justify line-height-1point2">
                                        <span class="line-height-1 px-11-font">calend</span>
                                        <div class="text-input-line" style="width: 15%;">
                                            <span class="line-height-1 px-11-font proximanova-bold"
                                                style="position:absolute; top: 3px;">
                                                @if(isset($lln_test['question2_2']) && $lln_test['question2_2'] != null)
                                                {{ $lln_test['question2_2'] }}
                                                @endif
                                            </span>
                                        </div>
                                        <span class="line-height-1 px-11-font">r</span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="px-11-font text-justify line-height-1point2">
                                        <span class="line-height-1 px-11-font">counc</span>
                                        <div class="text-input-line" style="width: 15%;">
                                            <span class="line-height-1 px-11-font proximanova-bold"
                                                style="position:absolute; top: 3px;">
                                                @if(isset($lln_test['question2_3']) && $lln_test['question2_3'] != null)
                                                {{ $lln_test['question2_3'] }}
                                                @endif
                                            </span>
                                        </div>
                                        <span class="line-height-1 px-11-font">l</span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="px-11-font text-justify line-height-1point2">
                                        <span class="line-height-1 px-11-font">hurr</span>
                                        <div class="text-input-line" style="width: 15%;">
                                            <span class="line-height-1 px-11-font proximanova-bold"
                                                style="position:absolute; top: 3px;">
                                                @if(isset($lln_test['question2_4']) && $lln_test['question2_4'] != null)
                                                {{ $lln_test['question2_4'] }}
                                                @endif
                                            </span>
                                        </div>
                                        <span class="line-height-1 px-11-font">dly</span>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <!-- Question 3 -->
                    <p class="px-11-font text-justify line-height-1point2 proximanova-bold"><span
                            class="primary-font-color">Question 3.</span> Please read the following and answer the
                        questions below: (10 Marks)</p>
                    <p class="px-11-font text-justify line-height-1point2">Telephone inquiries should be dealt with
                        clearly with the exact nature of the enquiry, the time, and return contact information recorded.
                        Customer satisfaction may result if information regarding the products and services is
                        given.These include security at special events, general crowd control, security within a shop
                        and site monitoring.</p>
                    <p class="px-11-font text-justify line-height-1point2">Advertising and websites can instigate
                        inquiries, and should be well presented, with details of the services available. Telephone
                        inquiries may sometimes be best resolved by sending the person some information via email or
                        post.</p>
                    <br>
                    <p class="px-11-font text-justify line-height-1point2 proximanova-bold">1. What 2 pieces of
                        information should be recorded with every telephone enquiry?</p>
                    <div class="textbox long">
                        @if(isset($lln_test['question3_1']) && $lln_test['question3_1'] != null)
                        {{ $lln_test['question3_1'] }}
                        @endif
                    </div>
                    <p class="px-11-font text-justify line-height-1point2 proximanova-bold">1. What 2 pieces of
                        information should be recorded with every telephone enquiry?</p>
                    <div class="textbox long">
                        @if(isset($lln_test['question3_2']) && $lln_test['question3_2'] != null)
                        {{ $lln_test['question3_2'] }}
                        @endif
                    </div>
                    <br>
                    <!-- Question 4 -->
                    <p class="px-11-font text-justify line-height-1point2 proximanova-bold"><span
                            class="primary-font-color">Question 3.</span> Calculate the following: (10 Marks)</p>
                    <p class="px-11-font text-justify line-height-1point2 proximanova-bold"> A.) Subtraction (with no
                        calculator)</p>
                    <table width="50%" class="table default-bordered-table">
                        <thead>
                            <tr>
                                <th class="proximanova-bold px-12-font white-font-color text-center" width="30%">1
                                </th>
                                <th class="proximanova-bold px-12-font white-font-color text-center" width="30%">2
                                </th>
                                <th class="proximanova-bold px-12-font white-font-color text-center" width="30%">3
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">476<br>- 250</td>
                                <td valign="top" class="text-center">578<br>- 400</td>
                                <td valign="top" class="text-center">14175<br>- 175</td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    @if(isset($lln_test['question4_a1']) && $lln_test['question4_a1'] != null)
                                    {{ $lln_test['question4_a1'] }}
                                    @endif
                                </td>
                                <td valign="top" class="text-center">
                                    @if(isset($lln_test['question4_a2']) && $lln_test['question4_a2'] != null)
                                    {{ $lln_test['question4_a2'] }}
                                    @endif
                                </td>
                                <td valign="top" class="text-center">
                                    @if(isset($lln_test['question4_a3']) && $lln_test['question4_a3'] != null)
                                    {{ $lln_test['question4_a3'] }}
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <p class="px-11-font text-justify line-height-1point2 proximanova-bold">B.) Subtraction of
                        Percentages (with No calculator) </p>
                    <table width="50%" class="table default-bordered-table">
                        <tbody>
                            <tr>
                                <td width="10%" class="text-center proximanova-bold">1</td>
                                <td width="30%" valign="top">$30.00 + 10% GST = </td>
                                <td width="30%" valign="top">
                                    @if(isset($lln_test['question4_b1']) && $lln_test['question4_b1'] != null)
                                    {{ $lln_test['question4_b1'] }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center proximanova-bold">2</td>
                                <td valign="top">$65.00 + 10% GST = </td>
                                <td valign="top">
                                    @if(isset($lln_test['question4_b2']) && $lln_test['question4_b2'] != null)
                                    {{ $lln_test['question4_b2'] }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center proximanova-bold">3</td>
                                <td valign="top">$35.00 - 10% GST = </td>
                                <td valign="top">
                                    @if(isset($lln_test['question4_b3']) && $lln_test['question4_b3'] != null)
                                    {{ $lln_test['question4_b3'] }}
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <p class="px-11-font text-justify line-height-1point2 proximanova-bold">C.) Addition (with No
                        calculator) </p>
                    <table width="50%" class="table default-bordered-table">
                        <tbody>
                            <tr>
                                <td width="10%" class="text-center proximanova-bold">1</td>
                                <td width="30%" valign="top">3 x 5 =</td>
                                <td width="30%" valign="top">
                                    @if(isset($lln_test['question4_c1']) && $lln_test['question4_c1'] != null)
                                    {{ $lln_test['question4_c1'] }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center proximanova-bold">2</td>
                                <td valign="top">12 x 3 =</td>
                                <td valign="top">
                                    @if(isset($lln_test['question4_c2']) && $lln_test['question4_c2'] != null)
                                    {{ $lln_test['question4_c2'] }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center proximanova-bold">3</td>
                                <td valign="top">8 x 5 =</td>
                                <td valign="top">
                                    @if(isset($lln_test['question4_c3']) && $lln_test['question4_c3'] != null)
                                    {{ $lln_test['question4_c3'] }}
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>



                    <div class="footer bottom-placement px-10-font text-center" style="margin-top: -10px;">
                        <p style="margin-bottom: 2px;">© {{ $app_setting->training_organisation_name }} | Version 1.1 | RTO No. {{ $app_setting->training_organisation_id }} </p>
                        <p class="">Page 2 of 3</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- End Page 2 -->
<!-- Page 3 -->

<body class="exo2-regular position-relative">
    <div>
        <div class="col-xs-12 no-padding position-relative">
            <div class="pdf-wrapper">
                <div style="margin: 0 10px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="20%">
                                <div class="logo-wrapper">
                                    <!-- <img src="{{ $logo_url }}" alt=""> -->
                                    <img src="{{ $logo_url }}" alt="">
                                </div>
                            </td>
                            <td width="80%" class="proximanova-bold">
                                <p class="primary-font-color px-12-font text-right line-height-1point2">Guide and
                                    Mapping</p>
                                <p class="secondary-font-color px-16-font text-right line-height-1point2">Language,
                                    Literacy and Numeracy (LLN) Test</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div class="pdf-wrapper">
                    <!-- Question 5 -->
                    <p class="px-11-font text-justify line-height-1point2 proximanova-bold"><span
                            class="primary-font-color">Question 5.</span> Please answer the following questions;
                        regarding the Australian Passport of Simon Antony Roberts: (10 Marks)</p>
                    <br>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="50%">
                                    <img src="{{public_path()}}/custom/unit-of-competency-lln-test/images/question5.png"
                                        alt="" class="img-responsive" style="width: 95%;">
                                </td>
                                <td width="50%" valign="top">

                                    <div>
                                        <span class="line-height-1 px-11-font proximanova-bold">A.) What is the Date of
                                            Expiry?</span>
                                        <div class="text-input-line" style="width: 50%;">
                                            <span class="line-height-1 px-11-font" style="position:absolute; top: 3px;">

                                                @if(isset($lln_test['question5_a'] ) && $lln_test['question5_a'] !=
                                                null)
                                                {{ \Carbon\Carbon::parse($lln_test['question5_a'])->format('d/m/Y') }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="line-height-1 px-11-font proximanova-bold">B.) Date of
                                            Birth?</span>
                                        <div class="text-input-line" style="width: 68%;">
                                            <span class="line-height-1 px-11-font" style="position:absolute; top: 3px;">
                                                @if(isset($lln_test['question5_b'] ) && $lln_test['question5_b'] !=
                                                null)
                                                {{ \Carbon\Carbon::parse($lln_test['question5_b'])->format('d/m/Y') }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="line-height-1 px-11-font proximanova-bold">C.) What is the Document
                                            No?</span>
                                        <div class="text-input-line" style="width: 50%;">
                                            <span class="line-height-1 px-11-font" style="position:absolute; top: 3px;">
                                                @if(isset($lln_test['question5_c']) && $lln_test['question5_c'] != null)
                                                {{ $lln_test['question5_c'] }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="line-height-1 px-11-font             proximanova-bold">D.) What is
                                            Place of Birth?</span>
                                        <div class="text-input-line" style="width: 55%;">
                                            <span class="line-height-1 px-11-font" style="position:absolute; top: 3px;">
                                                @if(isset($lln_test['question5_d']) && $lln_test['question5_d'] != null)
                                                {{ $lln_test['question5_d'] }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="line-height-1 px-11-font proximanova-bold">E.) What is the
                                            Nationality?</span>
                                        <div class="text-input-line" style="width: 55%;">
                                            <span class="line-height-1 px-11-font" style="position:absolute; top: 3px;">
                                                @if(isset($lln_test['question5_e']) && $lln_test['question5_e'] != null)
                                                {{ $lln_test['question5_e'] }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <!-- Question 6 -->
                    <p class="px-11-font text-justify line-height-1point2 proximanova-bold"><span
                            class="primary-font-color">Question 6.</span> Tick the correctly spelt words. (10 Marks)</p>
                    <br>
                    <div
                        class="checkbox {{isset($lln_test['question6_1']) && in_array($lln_test['question6_1'], [true, 1]) ? 'checked' : ''}}">
                        <label class="label label-checkbox dark-grey-font-color px-10-font">1. itinery</label></div>
                    <div
                        class="checkbox {{isset($lln_test['question6_2']) && in_array($lln_test['question6_2'], [true, 1]) ? 'checked' : ''}}">
                        <label class="label label-checkbox dark-grey-font-color px-10-font">2. Pilat</label></div>
                    <div
                        class="checkbox {{isset($lln_test['question6_3']) && in_array($lln_test['question6_3'], [true, 1]) ? 'checked' : ''}}">
                        <label class="label label-checkbox dark-grey-font-color px-10-font">3. Immediately</label></div>
                    <div
                        class="checkbox {{isset($lln_test['question6_4']) && in_array($lln_test['question6_4'], [true, 1]) ? 'checked' : ''}}">
                        <label class="label label-checkbox dark-grey-font-color px-10-font">4. Arrangement</label></div>
                    <br>
                    <br>
                    <p
                        class="section-header proximanova-bold primary-font-color px-14-font text-justify text-uppercase">
                        <span>Office use only</span></p>
                    <div
                        class="checkbox {{isset($lln_test['question6_1']) && in_array($lln_test['question6_1'], [true, 1]) ? 'checked' : ''}}">
                        <label class="label label-checkbox dark-grey-font-color px-10-font"> I have assessed this
                            applicant/student.I find that the applicant/student has sufficient language, literacy and
                            numeracy skills.</label></div>
                    <div
                        class="checkbox {{isset($lln_test['question6_1']) && in_array($lln_test['question6_1'], [true, 1]) ? 'checked' : ''}}">
                        <label class="label label-checkbox dark-grey-font-color px-10-font">I find that the
                            applicant/student does not have sufficient language, literacy and numeracy skills.</label>
                    </div>
                    <br>
                    <div>
                        <span class="line-height-1 px-11-font proximanova-bold">Assessor /RTO Representative’s
                            Signature:</span>
                        <div class="text-input-dot" style="width: 150px;margin-top: 5px; ">
                            <span class="line-height-1 position-relative">
                                @if(isset($student_signature) && $student_signature != null)
                                <!-- <img src="{{ $student_signature }}" alt="" style="width: 300px;margin-top: -40px;"> -->
                                <div class="type-signature px-18-font" style="margin-top: -5px;">
                                    {{isset($student_signature) ? $student_signature : ''}}</div>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div>
                        <span class="line-height-1 px-11-font proximanova-bold">Date:</span>
                        <div class="text-input-line" style="width: 20%;">
                            <span class="line-height-1 px-11-font" style="position:absolute; top: 3px;">

                                @if(isset($lln_test['assessor_date'] ) && $lln_test['assessor_date'] != null)
                                {{ \Carbon\Carbon::parse($lln_test['assessor_date'])->format('d/m/Y') }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="footer bottom-placement px-10-font text-center" style="margin-top: -10px;">
                        <p style="margin-bottom: 2px;">© {{ $app_setting->training_organisation_name }} | Version 1.1 |
                            RTO No. {{ $app_setting->training_organisation_id }} </p>
                        <p class="">Page 3 of 3</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- End Page 3 -->

</html>