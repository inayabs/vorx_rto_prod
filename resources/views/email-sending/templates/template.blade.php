<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style type="text/css">
        .no-padding {padding: 0;}
        .no-margin {margin: 0;}
        ul.rto-code {padding: none;text-align: center;margin-top: 15px;font-size: 14px;font-weight: bold;}
        ul.rto-code li {list-style: none;display: inline;padding: 0 10px;border-right: 1px solid #363636;}
        ul.rto-code li:last-child {border: 0;}
    </style>
</head>

<body style="font-family: '0Malgun Gothic', Arial, sans-serif; margin: 0; padding: 0; width: 100%;
    -webkit-text-size-adjust: none; -webkit-font-smoothing: antialiased; position: relative;">
    <div class="main-wrapper" style="padding: 20px;">
        <table class="table-responsive" align="center" width="800" style="box-shadow: 0px 0px 3px #cccccc;">
            <tbody class="">
                <tr>
                    <td colspan="2">
                        <div class="clearfix" style="height:40px;"></div>
                    </td>
                </tr>
                <tr>
                    <td width="50%" style="padding-left: 60px;">
                        <img src="http://eti.edu.au/wp-content/themes/ETI%20theme/assets/images/logos/ETI-coloredtext-logo.png"
                            style="margin: 0 auto;display: block; width: 200px;">
                    </td>
                    <td style="font-size: 10px;padding-right: 60px;" width="50%">
                        <p style="font-weight: bold;font-size: 9px; margin:3px 0 0;">Elite Training Institute Pty Ltd
                        </p>
                        <p style="font-size: 9px; margin:3px 0 0;"><span style="font-weight: bold;">ADDRESS:</span>
                            Level 7, 20 Otter Street, Collingwood, VIC 3066, Australia</p>
                        <p style="font-size: 9px; margin:3px 0 0;"><span style="font-weight: bold;">Ph. VIC:</span> 03
                            9088 0255</p>
                        <p style="font-size: 9px; margin:3px 0 0;"><span style="font-weight: bold;">Ph. QLD:</span> 07
                            3154 2859</p>
                        <p style="font-size: 9px; margin:3px 0 0;"><span style="font-weight: bold;">EMAIL:</span>
                            info@eti.edu.au</p>
                        <p style="font-size: 9px; margin:3px 0 0;"><span style="font-weight: bold;">WEBSITE:</span>
                            www.eti.edu.au</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 0 60px;">
                        <ul class="rto-code ">
                            <li>RTO Provider No. 40965</li>
                            <li>CRICOS Code 03470A</li>
                            <li>Nationally Recognised Training</li>
                        </ul>
                        <div class="clearfix" style="height: 20px;"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 0 60px;">
                        <div class="title">
                            <!-- <h1 class="" style="color: #147347;font-size: 32px;text-align: center;margin: 30px 0;">Title Here</h1> -->
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%" style="padding-left: 60px;">
                        <p class="no-margin" style="font-size:14px;">Dear {{ $username }},</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 14px;padding: 0 60px;">
                        <div class="email-container">
                            <div class="clearfix"></div>
                            <div class="clearfix" style="height: 20px;"></div>
                            <p style="font-size: 14px;">Please find attached learning material for SITHCCC019 - Produce
                                cakes,pastries and bread.</p>
                            <p style="font-size: 14px;">START DATE- 27.01.2020<br>DUE DATE - 09.02.2020</p>
                            <p>Note: "Please attend kitchen class as per your schedule otherwise your assessments will
                                be marked incompetent."</p>
                            <div class="clearfix" style="height:50px;"></div>
                            <p class="no-margin">Thanks & Kind regards,</p>
                            <p class="no-margin">Elite Training Institute </p>

                        </div>
                        <div class="clearfix" style="height:30px;"></div>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
{!! html_entity_decode($emailContent) !!}
