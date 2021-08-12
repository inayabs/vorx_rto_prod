<!DOCTYPE html>
                 <html lang="en">
                   <head>
                     <meta charset="utf-8">
                     <meta http-equiv="X-UA-Compatible" content="IE=edge">
                     <meta name="viewport" content="width=device-width, initial-scale=1">
                     <title>Email Template</title>
                     <style type="text/css">
                       .text-right{text-align: right;}
                       .no-padding {padding: 0;}
                       .no-margin {margin: 0;}
                       ul.rto-code {padding: none;text-align: center;margin-top: 15px;font-size: 14px;font-weight: bold;}
                       ul.rto-code li{list-style: none;display: inline;padding: 0 10px; border-right: 1px solid #363636;}
                       ul.rto-code li:last-child{border:0;}
                     </style>
                   </head>
                   <body  style="font-family: "Malgun Gothic", Arial, sans-serif; margin: 0; padding: 0; width: 100%; -webkit-text-size-adjust: none; -webkit-font-smoothing: antialiased; position: relative;background-color: #EBF0EB;">
                 <div class="main-wrapper" style="padding: 20px;">
                       <table class="table-responsive" align="center" width="' . $pdf . '" style="box-shadow: 0px 0px 3px #cccccc;font-size: 14px;color: #555555;background: #fff;">
                       <tbody class="">
                         <tr>
                           <td colspan="2"><div class="clearfix" style="height:50px;"></div></td>
                         </tr>
                       <tr>
                         <td width="50%" style="padding-left: 60px;">
                           <img src="http:eti.edu.au/wp-content/themes/ETI%20theme/assets/images/logos/ETI-coloredtext-logo.png" style="margin: 0 auto;display: block; width: 180px;">
                         </td>
                         <td style="font-size: 10px;padding-right: 60px;" width="50%">
                           <p style="font-weight: bold;font-size: 9px; margin:3px 0 0;">Elite Training Institute Pty Ltd</p>
                           <p style="font-size: 9px; margin:3px 0 0;"><span style="font-weight: bold;">ADDRESS:</span> Level 7, 20 Otter Street, Collingwood, VIC 3066, Australia</p>
                           <p style="font-size: 9px; margin:3px 0 0;"><span style="font-weight: bold;">Ph. VIC:</span> 03 9088 0255</p>
                           <p style="font-size: 9px; margin:3px 0 0;"><span style="font-weight: bold;">Ph. QLD:</span> 07 3154 2859</p>
                           <p style="font-size: 9px; margin:3px 0 0;"><span style="font-weight: bold;">EMAIL:</span> info@eti.edu.au</p>
                           <p style="font-size: 9px; margin:3px 0 0;"><span style="font-weight: bold;">WEBSITE:</span> www.eti.edu.au</p>
                         </td>
                       </tr>
                        <tr>
                         <td colspan="2" style="padding: 0 60px;">
                         <br>
                          <p style="font-weight: bold;">{{ $date }}</p>
                         </td>
                       </tr>
                       <tr>
                         <td colspan="2" style="padding: 0 60px;">
                           <h1 style="font-weight: bold;font-size: 16px;text-align: center;text-decoration: underline;">{{ $title }}</h1>
                           <br>
                          <p style="text-align:justify;">{{ $content }}</p><br>
                           <div class="clearfix" style="height:50px;"></div>
                         </td>
                       </tr>
                       <tr>
                         <td colspan="2" style="padding: 0 60px;">
                          <p style="text-align: center;font-size: 9px;">ABN: 42 163 187 862 | RTO No. 40965 | CRICOS Code 03470A</p>
                          <div class="clearfix" style="height:10px;"></div>
                         </td>
                       </tr>
                       </tbody>
                     </table>
                 </div>
                   </body>
                 </html>