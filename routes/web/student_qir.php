<?php
Route::middleware(['rto'])->group(function () {
    // Qualification Issuance Register (SOA and Certificates)
    Route::get('/qualification-issuance-register/search/{qir}', 'CertificateIssuance\QualificationIssuanceRegisterController@search');
    Route::get('/qualification-issuance-register/info', 'CertificateIssuance\QualificationIssuanceRegisterController@qir_info');
    Route::get('/qualification-issuance-register/filter/{filter}','CertificateIssuance\QualificationIssuanceRegisterController@qir_filter');
    Route::get('/qualification-issuance-register/generate/{filter}','CertificateIssuance\QualificationIssuanceRegisterController@generate_qir');
    
    Route::resource('/qualification-issuance-register', 'CertificateIssuance\QualificationIssuanceRegisterController');
    
    // Register for Recording Construction Induction (SOA)
    
    Route::get('/rrci-soa/info', 'CertificateIssuance\RRCIController@rrci_info');
    Route::get('/rrci-soa/search/{qir}', 'CertificateIssuance\RRCIController@search');
    Route::get('/rrci-soa/filter/{filter}','CertificateIssuance\RRCIController@qir_filter');
    Route::get('/rrci-soa/generate/{filter}','CertificateIssuance\RRCIController@generate_qir');
    
    Route::resource('/rrci-soa', 'CertificateIssuance\RRCIController');
});