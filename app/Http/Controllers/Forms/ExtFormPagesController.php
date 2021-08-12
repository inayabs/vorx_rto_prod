<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Course;

class ExtFormPagesController extends Controller
{
    //
    public function complaints_and_appeals_pca(){
        $courses = Course::all();
        $pages = [
            [
                'component'=>[
                    [
                        'title'=>'Course Details',
                        'inputs'=>[
                            [
                                'type'=>'inputgroup',
                                'name'=>'student_id',
                                'label'=>'Student ID',
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type' => 'multiselect',
                                'name' => 'course',
                                'multiselect' => false,
                                'label'=> 'The Course you are applying for',
                                'selections' => $courses,
                                'mTrackBy' => 'code',
                                'mLabel' => 'name',
                                'col_size' => 6,
                            ],
                        ]
                    ],
                    [
                        'title'=>'Personal Details',
                        'inputs'=>[
                            [
                                'type'=>'text',
                                'name'=>'student_name',
                                'label'=>'Full Name',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'position',
                                'label'=>'Position of Complainant/Appellant',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'number',
                                'name'=>'phone',
                                'label'=>'Phone No:',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'email',
                                'label'=>'Email',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'address',
                                'label'=>'Adress',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>12
                            ],
                            [
                                'type'=>'card',
                                'label'=>'If the complainant is student, please provide the following details',
                                'col_size'=>12
                            ]
                        ]
                    ],
                ]
            ],
            [
                'component'=>[
                    [
                        'title'=>'Complain/Appeal Details',
                        'inputs'=>[
                            [
                                'type'=>'card',
                                'label'=>'Complain Details',
                                'col_size'=>12  
                            ],
                            [
                                'type'=>'date',
                                'name'=>'complaint_date',
                                'label'=>'Date the cause of complaint occured',
                                // 'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'multiselect',
                                'name'=>'complaint_reason',
                                'label'=>'Reason for complaint',
                                'required'=>true,
                                'multiselect'=>false,
                                'mTrackBy'=>'id',
                                'col_size'=>6,
                                'selections'=>[
                                    [
                                        'id'=>0,
                                        'value'=>'General Operations'
                                    ],
                                    [
                                        'id'=>1,
                                        'value'=>'Assessment'
                                    ],
                                    [
                                        'id'=>2,
                                        'value'=>'ESOS related complaint'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'complained_before',
                                // 'label' => 'Have you complained about the issue before?',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value'=>false,
                                        'description'=>'Have you complained about the issue before?'
                                    ],
                                ]
                            ],
                            [
                                'type'=>'date',
                                'name'=>'complained_before_date',
                                'label'=>'If yes, please give the date, the complaint was lodged',
                                // 'required'=>false,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'card',
                                'label'=>'Appeal Details',
                                'col_size'=>12
                            ],
                            [
                                'type'=>'date',
                                'name'=>'appeal_date',
                                'label'=>'Date to which this appeal refers to',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'multiselect',
                                'name'=>'appeal_reason',
                                'label'=>'Reason for the appeal',
                                // 'required'=>true,
                                'multiselect'=>false,
                                'mTrackBy'=>'id',
                                'col_size'=>12,
                                'selections'=>[
                                    [
                                        'id'=>0,
                                        'value'=>'Assessment outcome'
                                    ],
                                    [
                                        'id'=>1,
                                        'value'=>'Any outcome of any application for request'
                                    ],
                                    [
                                        'id'=>2,
                                        'value'=>'Any disciplinary action taken against you'
                                    ],
                                ]
                            ],
                            [
                                'type'=>'text',
                                'name'=>'appeal_reason_spec',
                                'label'=>'Other (please specify)',
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>12
                            ],
                        ]
                    ],
                ]
            ],
            [
                'component'=>[
                    [
                        'title'=>'Complaint/Appeal summary',
                        'inputs'=>[
                            [
                                'type'=>'textarea',
                                'name'=>'complaint_summary',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'Complaint/Appeal summary (please give detailed explanation of complaint/appeal and attach any supporting evidence)',
                                'value'=>''
                            ],
                            [
                                'type'=>'card',
                                'label'=>'Declaration'
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'accurate',
                                // 'label' => 'Have you complained about the issue before?',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value'=>false,
                                        'description'=>'All the information provided in this form is correct and accurate to the best of my knowledge.'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'happy',
                                // 'label' => 'Have you complained about the issue before?',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value'=>false,
                                        'description'=>'I am happy to attend any meeting with relevant person required to resolve the issue'
                                    ],
                                ]
                            ],
                            [
                                'type'=>'signature',
                                'name'=>'complainant_signature',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>"Signature",
                                'value'=>'',
                                'required'=>true
                            ],
                            [
                                'type'=>'date',
                                'name'=>'complain_date',
                                'col_size'=>3,
                                'label'=>"Date:",
                                'value'=>'',
                                'required'=>true
                            ],
                        ]
                    ]
                ]
            ],
            [
                'component'=>[
                    [
                        'title'=>'Office use only',
                        'inputs'=>[
                            [
                                'type'=>'text',
                                'name'=>'receiving_staff_member',
                                'label'=>'Receiving staff member',
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'date',
                                'name'=>'office_date',
                                'label'=>'Date:',
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'method_of_lodgement',
                                'label'=>'Method of lodgement',
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'panel_members',
                                'label'=>'Name of members in panel for resolving the issue',
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'actions_proposed',
                                'label'=>'Actions proposed by panel',
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'implementations_of_proposed_action',
                                'label'=>'Implementation of proposed action by',
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'outcome',
                                'label'=>'Outcome',
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'method_to_communicate_outcome',
                                'label'=>'Method to communicate the outcome with the complainant',
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'complainant_response',
                                'label'=>'Response of the complainant/appellant',
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'student_declaration',
                                // 'label' => 'Student Declaration:',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'description' => '<b> I have acknowledge that i have been communicated the outcome of the complaint/appeal lodged by me.</b>',
                                    ],
                                    [
                                        'description' => '<b> I agree to the decision made by the panel and happy to accept it.</b>',
                                    ],
                                    [
                                        'description' => '<b> I disagree to the decision made by the panel and would like to escalate it to an external body and I have been advised of all the required information in this regard.</b>',
                                    ],
                                ],
                            ],
                            [
                                'type'=>'signature',
                                'name'=>'staff_signature',
                                'label'=>'Staff Signature',
                                // 'readOnly'=>true,
                                // 'required'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'date',
                                'name'=>'staff_date',
                                'label'=>'Date',
                                // 'readOnly'=>true,
                                // 'required'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'staff_name',
                                // 'required'=>true,
                                'label'=>'Print name',
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            ['br'],
                            [
                                'type'=>'signature',
                                'name'=>'pca_rep_signature',
                                'label'=>'Signature of PCA`s representative',
                                // 'readOnly'=>true,
                                // 'required'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'date',
                                'name'=>'pca_rep_date',
                                'label'=>'Date',
                                // 'readOnly'=>true,
                                // 'required'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'pca_rep_name',
                                'label'=>'Print name',
                                // 'readOnly'=>true,
                                // 'required'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                        ]
                    ]
                ]
            ]
        ];

        return $pages;
    }
    
    public function application_for_release_letter_pca(){
        $courses = Course::all();
        $pages = [
            [
                'component'=>[
                    [
                        'title'=>'Course Details',
                        'inputs'=>[                            
                            [
                                'type' => 'inputgroup',
                                'name' => 'student_id',
                                'label' => 'Student ID',
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type' => 'multiselect',
                                'name' => 'course',
                                'multiselect' => false,
                                'label'=> 'Course',
                                'selections' => $courses,
                                'mTrackBy' => 'code',
                                'mLabel' => 'name',
                                'col_size' => 6,
                            ],
                            [
                                'type' => 'date',
                                'name' => 'course_start_date',
                                'label' => 'Course start date',
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type' => 'date',
                                'name' => 'release_effective_from',
                                'label' => 'Release effective from',
                                'value'=>'',
                                'col_size'=>6
                            ],
                        ]
                    ],
                    [
                        'title'=>'Student`s Personal Details',
                        'inputs'=>[
                            [
                                'type'=>'text',
                                'name'=>'student_name',
                                'label'=>'Full Name',
                                'required'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type' => 'date',
                                'name' => 'student_dob',
                                'label' => 'Date of birth',
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type' => 'text',
                                'name' => 'phone_home',
                                'label' => 'Telephone',
                                // 'required'=> true,
                                'col_size'=>6,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'address',
                                'label' => 'Address',
                                'required' => true,
                                'col_size' => 12,
                            ],
                        ]
                    ]
                ]
            ],
            [
                'component'=>[
                    [
                        'title'=>'Student Declaration',
                        'inputs'=>[
                            [
                                'type' => 'check-description',
                                'name' => 'student_declaration',
                                // 'label' => 'Student Declaration:',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'description' => '<b> I understand that this application does not guarantee the issue of a release letter.
                                        </b>',
                                    ],
                                    [
                                        'description' => '<b> I understand that I have to provide the necessary documents requested by Phoenix College of Australia PCA (such as
                                        offer letter from another provider).</b>',
                                    ],
                                    [
                                        'description' => '<b> I understand that I have to maintain my enrolment at Phoenix College of Australia (PCA) while the application is being
                                        processed.</b>',
                                    ],
                                    [
                                        'description' => '<b> I declare that all the information provided in this form is accurate and correct and no false/fake document has been
                                        attached.</b>',
                                    ],
                                    [
                                        'description' => '<b>I acknowledge that I have read and understood all the requirements for this request.',
                                    ],
                                    [
                                        'description' => '<b>I acknowledge that I understand all the relevant policies and procedures in regard to this change, including PCA’s Fee
                                        Charges and Refund Policy and procedure.</b>',
                                    ],
                                    [
                                        'description' => '<b> I acknowledge that I have been advised to contact DEPARTMENT OF HOME AFFAIRS regarding any visa changes to the
                                        student visa.</b>',
                                    ],
                                    [
                                        'description' => '<b> I understand that I must pay my all dues as one of the requirements for getting a release letter</b>',
                                    ],
                                    [
                                        'description' => '<b>I am aware of my appeal rights.</b>',
                                    ],
                                    [
                                        'description' => '<b>I understand that I must discuss the issue with the student support officer before applying for the release letter.</b>',
                                    ],
                                    [
                                        'description' => '<b> I understand that processing time for the application for the release letter is 10 working days.</b>',
                                    ],
                                    // [
                                    //     'description' => '<b>Statement addressing Genuine Temporary Entrant Criteria</b> (not required in cases of Security courses and if student is onshore)',
                                    // ],
                                ],
                            ],
                            [
                                'type'=>'signature',
                                'name'=>'student_signature',
                                'col_size'=>6,
                                'rows'=>4,
                                'label'=>"Student Signature",
                                'value'=>'',
                                'required'=>true,
                            ],
                            [
                                'type'=>'date',
                                'name'=>'declaration_date',
                                'label'=>'Date',
                                'required'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                        ]
                    ]
                ]
            ],
            [
                'component'=>[
                    [
                        'title'=>'Office use only',
                        'inputs'=>[
                            [
                                'type' => 'text',
                                'name' => 'received_by',
                                'label' => 'Received by',
                                // 'required'=> true,
                                'col_size'=>6,
                            ],
                            [
                                'type' => 'date',
                                'name' => 'office_use_date',
                                'label' => 'Date',
                                // 'required'=> true,
                                'col_size'=>6,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'outcome_of_the_request',
                                'label' => 'Outcome of the request',
                                // 'required'=> true,
                                'col_size'=>6,
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'release_granted',
                                // 'label' => 'Have you complained about the issue before?',
                                'col_size' => 6,
                                'content' => [
                                    [
                                        'value'=>false,
                                        'description'=>'<b>Release granted</b>'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'text',
                                'name' => 'reason_for_decision',
                                'label' => 'Reason for the decision',
                                // 'required'=> true,
                                'col_size'=>6,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'processed_by',
                                'label' => 'Processed by',
                                // 'required'=> true,
                                'col_size'=>6,
                            ],
                            [
                                'type' => 'date',
                                'name' => 'process_date',
                                'label' => 'Process Date',
                                // 'required'=> true,
                                'col_size'=>6,
                            ],
                        ]
                    ]
                ]
            ]
        ];
        return $pages;
    }
    
    public function application_for_deferment_pca(){
        $courses = Course::all();
        $pages = [
            [
                'component'=>[
                    [
                        'title'=>'Student`s Personal Details',
                        'inputs'=>[
                            [
                                'type'=>'text',
                                'name'=>'student_name',
                                'label'=>'Full Name',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'date',
                                'name'=>'dob',
                                'label'=>'Date of birth',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type' => 'multiselect',
                                'name' => 'course',
                                'multiselect' => false,
                                'label'=> 'The Course you are applying for',
                                'selections' => $courses,
                                'mTrackBy' => 'code',
                                'mLabel' => 'name',
                                'col_size' => 6,
                            ],
                            [
                                'type'=>'text',
                                'name'=>'address',
                                'label'=>'Adress',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'number',
                                'name'=>'phone',
                                'label'=>'Phone No:',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'email',
                                'label'=>'Email',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'number',
                                'name'=>'mobile',
                                'label'=>'Mobile',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'request_reason',
                                'label' => 'Please tick the reason for request',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value'=>false,
                                        'description'=>'Medical grounds'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Exceptional reasons'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Change of mind'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Other'
                                    ],
                                ]
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'request_reason_spec',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'Complaint/Appeal summary (please give detailed explanation of complaint/appeal and attach any supporting evidence)',
                                'value'=>''
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'request_reason',
                                'label' => 'Documents attached',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value'=>false,
                                        'description'=>'Meducal certificate'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Travel documents'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Mails'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Suporting certificates'
                                    ],
                                ]
                            ],
                            [
                                'type'=>'card',
                                'label'=>'Please tick what is being requested',
                                'col_size'=>12
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'request_reason',
                                // 'label' => 'Please tick what is being requested',
                                'col_size' => 5,
                                'content' => [
                                    [
                                        'value'=>false,
                                        'description'=>'Deferment'
                                    ]
                                ]
                            ],
                            [
                                'type'=>'date',
                                'name'=>'deferment_date_from',
                                'label'=>'Date from',
                                'value'=>'',
                                'col_size'=>3
                            ],
                            [
                                'type'=>'date',
                                'name'=>'deferment_date_to',
                                'label'=>'Date to',
                                'value'=>'',
                                'col_size'=>3
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'suspension',
                                // 'label' => 'Please tick what is being requested',
                                'col_size' => 5,
                                'content' => [
                                    [
                                        'value'=>false,
                                        'description'=>'Suspension'
                                    ]
                                ]
                            ],
                            [
                                'type'=>'date',
                                'name'=>'suspension_date_from',
                                'label'=>'Date from',
                                'value'=>'',
                                'col_size'=>3
                            ],
                            [
                                'type'=>'date',
                                'name'=>'suspension_date_to',
                                'label'=>'Date to',
                                'value'=>'',
                                'col_size'=>3
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'suspension',
                                // 'label' => 'Please tick what is being requested',
                                'col_size' => 5,
                                'content' => [
                                    [
                                        'value'=>false,
                                        'description'=>'Cancellation/withdrawal date effective from'
                                    ]
                                ]
                            ],
                            [
                                'type'=>'date',
                                'name'=>'cancel_date',
                                // 'label'=>'Date from',
                                'value'=>'',
                                'col_size'=>3
                            ],
                            [
                                'col_size'=>12,
                                'type'=>'card',
                                // 'label'=>'Instructions for all students ',
                                'content'=>[
                                    [
                                    'type'=>'paragraph',
                                    'body'=>'Prior to completing the PTR, make sure you have sufficient information about the course. In particular, you must have access to the following:
                                        <ul>
                                            <li>Please note that in case of International Students, the institute will grant a deferral of your commencement or temporary suspension of your studies only if there are compelling and compassionate circumstances and the evidence has been attached and students are advised to contact the Department of Home Affairs as it may affect your visa status </li>
                                            <li>I have been advised of all the relevant consequences of the outcome of my request</li>
                                            <li>I have been advised of all the relevant information in relation to the request made on this form</li>
                                            <li>I am aware of my appeal rights</li>
                                            <li>I have been advised that the time for processing of the application is 10 working days</li>
                                        </ul>
                                    '
                                    ]
                                ],
                            ],
                            [
                                'type'=>'signature',
                                'name'=>'student_signature',
                                'col_size'=>6,
                                'rows'=>4,
                                'label'=>"Student Signature",
                                'value'=>'',
                                'required'=>true,
                            ],
                            [
                                'type'=>'date',
                                'name'=>'process_date',
                                'label'=>'Date',
                                'required'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                        ]
                    ]
                ]
            ],
            [
                'component'=>[
                    [
                        'title'=>'Office use only',
                        'inputs'=>[
                            [
                                'type'=>'signature',
                                'name'=>'finance_signature',
                                'col_size'=>6,
                                'rows'=>4,
                                'label'=>"Finance approval",
                                'value'=>'',
                                // 'required'=>true,
                            ],
                            [
                                'type'=>'date',
                                'name'=>'approval_date',
                                'label'=>'Date',
                                // 'required'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'signature',
                                'name'=>'request_received_signature',
                                'col_size'=>6,
                                'rows'=>4,
                                'label'=>"Request received",
                                'value'=>'',
                                // 'required'=>true,
                            ],
                            [
                                'type'=>'date',
                                'name'=>'receive_date',
                                'label'=>'Date',
                                // 'required'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'complained_before',
                                'label' => 'Decision of request',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value'=>false,
                                        'description'=>'Granted'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Not granted'
                                    ],
                                ]
                            ],
                            [
                                'type'=>'text',
                                'name'=>'granted_by',
                                'label'=>'Decision granted by',
                                // 'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'signature',
                                'name'=>'request_received_signature',
                                'col_size'=>3,
                                'rows'=>4,
                                'label'=>"Request received",
                                'value'=>'',
                                // 'required'=>true,
                            ],
                            [
                                'type'=>'date',
                                'name'=>'receive_date',
                                'label'=>'Date',
                                // 'required'=>true,
                                'value'=>'',
                                'col_size'=>3
                            ],
                        ]
                    ]
                ]
            ]
        ];
        return $pages;
    }  
    
    public function student_general_form_pca(){
        $courses = Course::all();
        $pages = [
            [
                'component'=>[
                    [
                        'title'=>'Personal Details',
                        'inputs'=>[
                            [
                                'type'=>'inputgroup',
                                'name'=>'student_id',
                                'label'=>'Student ID',
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type' => 'multiselect',
                                'name' => 'course',
                                'multiselect' => false,
                                'label'=> 'The Course you are applying for',
                                'selections' => $courses,
                                'mTrackBy' => 'code',
                                'mLabel' => 'name',
                                'col_size' => 6,
                            ],
                            [
                                'type'=>'text',
                                'name'=>'student_name',
                                'label'=>'Student full name',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type' => 'date',
                                'name' => 'student_dob',
                                'label' => 'Date of birth',
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'number',
                                'name'=>'phone',
                                'label'=>'Phone No:',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'email',
                                'label'=>'Email',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'address',
                                'label'=>'Adress',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>12
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'request',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'What is being requested',
                                'value'=>''
                            ],
                            [
                                'type'=>'signature',
                                'name'=>'student_signature',
                                'col_size'=>6,
                                'rows'=>4,
                                'label'=>"Student Signature",
                                'value'=>'',
                                'required'=>true,
                            ],
                            [
                                'type'=>'date',
                                'name'=>'submit_date',
                                'label'=>'Date',
                                'required'=>true,
                                'value'=>now(),
                                'col_size'=>6
                            ],
                        ]
                    ]
                ]
            ],
            [
                'component'=>[
                    [
                        'title'=>'Office use only',
                        'inputs'=>[
                            [
                                'type'=>'text',
                                'name'=>'processed_by',
                                'label'=>'Processed by',
                                // 'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'signature',
                                'name'=>'staff_sign',
                                'col_size'=>6,
                                'rows'=>4,
                                'label'=>"Signature",
                                'value'=>'',
                                // 'required'=>true
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'comment',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'Comment',
                                'value'=>''
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'student_outcome_notification',
                                // 'label' => 'Have you complained about the issue before?',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value'=>false,
                                        'description'=>'Notify the student the outcome of the request'
                                    ],
                                ]
                            ],
                            [
                                'type'=>'date',
                                'name'=>'check_date',
                                'label'=>'Date',
                                // 'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>3
                            ],
                        ]
                    ]
                ]
            ]
        ];
        
        return $pages;
    }

    public function qualification_request_form_pca(){
        $courses = Course::all();
        $pages = [
            [
                'component'=>[
                    [
                        'title'=>'Student`s Personal Details',
                        'inputs'=>[
                            [
                                'type'=>'inputgroup',
                                'name'=>'student_id',
                                'label'=>'Student ID',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type' => 'multiselect',
                                'name' => 'course',
                                'multiselect' => false,
                                'label'=> 'Course',
                                'selections' => $courses,
                                'mTrackBy' => 'code',
                                'mLabel' => 'name',
                                'col_size' => 6,
                            ],
                            [
                                'type'=>'text',
                                'name'=>'student_name',
                                'label'=>'Full Name',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'usi',
                                'label'=>'USI',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'number',
                                'name'=>'phone',
                                'label'=>'Phone No:',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'email',
                                'label'=>'Email',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'address',
                                'label'=>'Adress',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>12
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'type_of_document',
                                'label' => 'Please tick the type of document being requested',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value'=>false,
                                        'description'=>'Full qualification'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Provisional result'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Statement of result'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Statement of attainment'
                                    ],
                                ]
                            ],
                            [
                                'type'=>'signature',
                                'name'=>'student_signature',
                                'col_size'=>6,
                                'rows'=>4,
                                'label'=>"Signature",
                                'value'=>'',
                                'required'=>true
                            ],
                            [
                                'type'=>'date',
                                'name'=>'acknowledgement_date',
                                'col_size'=>6,
                                'label'=>"Date:",
                                'value'=>now(),
                                'required'=>true
                            ],
                        ]
                    ],
                ]
            ],
            [
                'component'=>[
                    [
                        'title'=>'Office use only',
                        'inputs'=>[
                            [
                                'type'=>'date',
                                'name'=>'finance_approval_date',
                                'col_size'=>6,
                                'label'=>"Finance approval date:",
                                'value'=>'',
                                // 'required'=>true
                            ],
                            [
                                'type'=>'date',
                                'name'=>'academic_approval_date',
                                'col_size'=>6,
                                'label'=>"Academic approval date:",
                                'value'=>'',
                                // 'required'=>true
                            ],
                            [
                                'type'=>'text',
                                'name'=>'issued_by',
                                'col_size'=>6,
                                'label'=>"Issued by",
                                'value'=>'',
                                // 'required'=>true
                            ],
                            [
                                'type'=>'date',
                                'name'=>'issued_date',
                                'col_size'=>6,
                                'label'=>"Date:",
                                'value'=>'',
                                // 'required'=>true
                            ],
                            
                        ]
                    ]
                ]
            ]
        ];

        return $pages;
    }

    public function refund_request_form_pca(){
        $courses = Course::all();
        $pages = [
            [
                'component'=>[
                    [
                        'title'=>'Student`s Personal Details',
                        'inputs'=>[
                            [
                                'type'=>'inputgroup',
                                'name'=>'student_id',
                                'label'=>'Student ID',
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'student_name',
                                'label'=>'Full Name',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'date',
                                'name'=>'student_dob',
                                'label'=>'Date of birth',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'number',
                                'name'=>'phone',
                                'label'=>'Phone No:',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type' => 'multiselect',
                                'name' => 'course',
                                'multiselect' => false,
                                'label'=> 'Course',
                                'selections' => $courses,
                                'mTrackBy' => 'code',
                                'mLabel' => 'name',
                                'col_size' => 6,
                            ],
                            [
                                'type'=>'date',
                                'name'=>'course_start_date',
                                'label'=>'Course start date',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'address',
                                'label'=>'Adress',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>12
                            ],
                        ]
                    ],
                    [
                        'title'=>'Refund details',
                        'inputs'=>[
                            [
                                'type'=>'text',
                                'name'=>'refund_reason',
                                'label'=>'Reason for refund',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'tooltip'=>'Please provide the relevant documents as evidence to support your request for refund.',
                                'col_size'=>12
                            ],
                        ]
                    ],
                    [
                        'title'=>'Bank Transfer(Please enter your bank account details in which you would like to receive your refund)',
                        'inputs'=>[
                            [
                                'type'=>'text',
                                'name'=>'bank_name',
                                'label'=>'Bank name',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'bank_branch',
                                'label'=>'Bank branch',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'account_name',
                                'label'=>'Account name',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'bsb',
                                'label'=>'BSB',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'account_number',
                                'label'=>'Account number',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'text',
                                'name'=>'swift_code',
                                'label'=>'Swift code',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                        ]
                    ],
                    [
                        'title'=>'Acknowledgement',
                        'inputs'=>[
                            [
                                'type' => 'check-description',
                                'name' => 'acknowledgement',
                                // 'label' => 'Have you complained about the issue before?',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value'=>false,
                                        'description'=>'I understand that my request for a refund will be processed in accordance with PCA`s refund policy.'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'I also understand that my 20 days to access the complaints and appeals process, should I not agree with the outcome or decision.'
                                    ],
                                ]
                            ],
                            [
                                'type'=>'signature',
                                'name'=>'student_signature',
                                'col_size'=>6,
                                'rows'=>4,
                                'label'=>"Signature",
                                'value'=>'',
                                'required'=>true
                            ],
                            [
                                'type'=>'date',
                                'name'=>'acknowledgement_date',
                                'col_size'=>6,
                                'label'=>"Date:",
                                'value'=>now(),
                                'required'=>true
                            ],
                        ]
                    ]
                ]
            ],
            [
                'component'=>[
                    [
                        'title'=>'Office use only',
                        'inputs'=>[
                            [
                                'type'=>'signature',
                                'name'=>'request_received_sign',
                                'col_size'=>6,
                                'rows'=>4,
                                'label'=>"Request received(Signature)",
                                'value'=>'',
                                // 'required'=>true
                            ],
                            [
                                'type'=>'date',
                                'name'=>'request_received_sign_date',
                                'col_size'=>6,
                                'label'=>"Date:",
                                'value'=>'',
                                // 'required'=>true
                            ],
                            [
                                'type'=>'text',
                                'name'=>'refund_applicable',
                                'label'=>'Refund applicable',
                                // 'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'staff_comments',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'Comments',
                                'value'=>''
                            ],
                            [
                                'type'=>'date',
                                'name'=>'letter_date',
                                'label'=>'Date the letter was sent',
                                // 'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            ['br'],
                            [
                                'type'=>'signature',
                                'name'=>'processed_by',
                                'col_size'=>6,
                                'rows'=>4,
                                'label'=>"Refund processed(Signature)",
                                'value'=>'',
                                // 'required'=>true
                            ],
                            [
                                'type'=>'date',
                                'name'=>'processed_date',
                                'label'=>'Date',
                                // 'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                        ]
                    ]
                ]
            ]
        ];

        return $pages;
    }

    public function critical_incident_report_form_pca(){
        $pages = [
            [
                'component'=>[
                    [
                        'title'=>'Critical incident report form',
                        'inputs'=>[
                            [
                                'type' => 'check-description',
                                'name' => 'incident_type',
                                'label' => 'Type of incident',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value'=>false,
                                        'description'=>'Injury to staff'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Property damage'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Injury to student'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Vehicle accident'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Theft/loss'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Environmental damage'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Fire'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Assault'
                                    ],
                                    [
                                        'value'=>false,
                                        'description'=>'Damage'
                                    ],
                                ]
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'incident_type_spec',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'If other, please specify',
                                'value'=>''
                            ],
                        ]
                    ],
                ],
            ],
            [
                'component'=>[
                    [
                        'title'=>'Details of incident',
                        'inputs'=>[
                            [
                                'type'=>'date',
                                'name'=>'incident_date',
                                'label'=>'Date',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'time',
                                'name'=>'incident_time',
                                'label'=>'Time',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type' => 'text',
                                'name' => 'location',
                                'label' => 'Location',
                                // 'required' => true,
                                'col_size' => 12,
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'detailed_info',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'Detailed information of what activity was undergoing when it happened',
                                'value'=>''
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'description_of_injury',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'Description of injury',
                                'value'=>''
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'description_of_incident',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'Description of incident',
                                'value'=>''
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'description_of_damage',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'Description of damage',
                                'value'=>''
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'other_services',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'Were any other services involved/attended? (If yes, please attach a copy of the report)',
                                'value'=>''
                            ],
                            [
                                'type' => 'text',
                                'name' => 'received_by',
                                'label' => 'Received by',
                                // 'required' => true,
                                'col_size' => 6,
                            ],
                        ]
                    ],
                ]
                
            ],
            [
                'component'=>[
                    [
                        'title'=>'Person/people involved',
                        'inputs'=>[
                            [
                                'type'=>'dynamic-table',
                                'name'=>'persons_involved',
                                // 'label'=>'Person/s Involved',
                                'headers'=>['Name','Contact number','Address'],
                                'max_rows'=>3,
                                'value'=>[["","",""]],
                                'col_size'=>12
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'pca_recomended_action',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'Complaint/Appeal summary (please give detailed explanation of complaint/appeal and attach any supporting evidence)',
                                'value'=>''
                            ],
                            [
                                'type'=>'text',
                                'name'=>'student_name',
                                'label'=>'Full Name',
                                'required'=>true,
                                // 'readOnly'=>true,
                                'value'=>'',
                                'col_size'=>6
                            ],
                            [
                                'type'=>'signature',
                                'name'=>'signature',
                                'col_size'=>6,
                                'rows'=>4,
                                'label'=>"Signature",
                                'value'=>'',
                                'required'=>true
                            ],
                            [
                                'type'=>'date',
                                'name'=>'sign_date',
                                'col_size'=>3,
                                'label'=>"Date:",
                                'value'=>'',
                                'required'=>true
                            ],
                        ]
                    ],
                ]
                
            ]
        ];

        return $pages;
    }
}
