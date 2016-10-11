<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'aws.phar';

use Aws\Ses\SesClient;

class EmailSending {

    public function sendemail($fromemail, $toemail, $subject, $data = array()) {
        $client = SesClient::factory(array(
                    'key' => 'AKIAIR2WEYV5NSDPV5AQ',
                    'secret' => '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',
                    'region' => 'us-west-2'
        ));

        //Now that you have the client ready, you can build the message 
        $msg = array();
        $msg['Source'] = $fromemail;
        //ToAddresses must be an array
        $msg['Destination']['ToAddresses'][] = $toemail;

        $msg['Message']['Subject']['Data'] = $subject;
        $msg['Message']['Subject']['Charset'] = "UTF-8";

        $content = "";
        if ($data) {
            $content = $this->setTemplate($data);
        }

        $msg['Message']['Body']['Text']['Data'] = "Text data of email";
        $msg['Message']['Body']['Text']['Charset'] = "UTF-8";
        $msg['Message']['Body']['Html']['Data'] = $content;
        $msg['Message']['Body']['Html']['Charset'] = "UTF-8";

        try {
            $result = $client->sendEmail($msg);
            $msg_id = $result->get('MessageId');
            $status = "sent";
        } catch (Exception $e) {
            $status = "failed";
        }
        return $status;
    }

    function setTemplate($data) {
        $content = '<!-- 
                    * Template Name: Unify - Responsive Bootstrap Template
                    * Description: Business, Corporate, Portfolio and Blog Theme.
                    * Version: 1.6
                    * Author: @htmlstream
                    * Website: http://htmlstream.com
                   -->
                   <!doctype html>
                   <html xmlns="http://www.w3.org/1999/xhtml">
                       <head>
                           <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

                           <style type="text/css">
                               .ReadMsgBody {width: 100%; background-color: #ffffff;}
                               .ExternalClass {width: 100%; background-color: #ffffff;}
                               body     {width: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased;font-family: Arial, Helvetica, sans-serif}
                               table {border-collapse: collapse;}

                               @media only screen and (max-width: 640px)  {
                                   body[yahoo] .deviceWidth {width:440px!important; padding:0;}    
                                   body[yahoo] .center {text-align: center!important;}  
                               }

                               @media only screen and (max-width: 479px) {
                                   body[yahoo] .deviceWidth {width:280px!important; padding:0;}    
                                   body[yahoo] .center {text-align: center!important;}  
                               }
                           </style>
                       </head>
                       <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" yahoo="fix" style="font-family: Arial, Helvetica, sans-serif">

                           <!-- Wrapper -->
                           <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                               <tr>
                                   <td width="100%" valign="top" bgcolor="#ffffff" style="padding-top:20px">

                                       <!--Start Header-->
                                       <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                                           <tr>
                                               <td style="padding: 6px 0px 0px" bgcolor="#f7f7f7">
                                                   <table width="650" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                                                       <tr>
                                                           <td width="100%" >
                                                               <!--Start logo-->
                                                               <table  border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">
                                                                   <tr>
                                                                       <td class="center" style="padding: 20px 0px 10px 0px">
                                                                           <a href="' . base_url() . '">Sheep Fund</a>
                                                                       </td>
                                                                   </tr>
                                                               </table><!--End logo-->
                                                               <!--Start nav-->
                                                               <table  border="0" cellpadding="0" cellspacing="0" align="right" class="deviceWidth">
                                                                   <tr>
                                                                       <td  class="center" style="font-size: 13px; color: #272727; font-weight: light; text-align: center; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: middle; padding: 20px 0px 10px 0px;">
                                                                           <a href="' . base_url('search') . '" style="text-decoration: none; color: #3b3b3b;">PRODUCTS</a>
                                                                           &nbsp; &nbsp;                           
                                                                       </td>
                                                                   </tr>
                                                               </table><!--End nav-->
                                                           </td>
                                                       </tr>
                                                   </table>
                                               </td>
                                           </tr>
                                       </table> 
                                       <!--End Header-->

                                       <!--Start Midlle Picture -->
                                       <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                                           <tr>
                                               <td class="center">
                                                   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">';
                                                    if(isset($data['messageTitle'])){
                                                        $content .= '<tr>
                                                            <td  class="center" style="background-color: '.(isset($data['messageTitleColor']) ? $data['messageTitleColor'] : "green").' ;font-size: 16px; color: #FFFFFF; font-weight: bold; text-align: center; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: middle; padding: 10px 20px 0; ">
                                                                ' . @$data['messageTitle'] . '
                                                            </td>
                                                        </tr>';
                                                    }
                                                    $content .='<tr>
                                                        <td><br/>
                                                            ' . @$data['messageBody'] . '
                                                        </td>
                                                    </tr>';
        if(isset($data['btnLink']) && isset($data['btnText'])){
        $content .= '                                  <tr>
                                                           <td style=" padding: 0 0 20px 20px;">
                                                               <table  align="center">
                                                                   <tr>
                                                                       <td  valign="top" style="padding: 7px 15px; text-align: center; background-color: #3498db;" class="center">
                                                                           <a style="color: #fff; font-size: 12px; font-weight: bold; text-decoration: none; font-family: Arial, sans-serif; text-alight: center;" href="' . $data['btnLink'] . '">' . $data['btnText'] . '</a>
                                                                       </td>                                   
                                                                   </tr>
                                                               </table>
                                                           </td>
                                                       </tr>';
        }
        $content .= '                   </table>
                                               </td>       
                                       </table>
                                       <!--End Midlle Picture -->

                                       <!--Start Support-->
                                       <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                                           <tr>
                                               <td width="100%" bgcolor="#a5d1da" class="center">
                                                   <table  border="0" cellpadding="0" cellspacing="0" align="center"> 
                                                       <tr>
                                                           <td  class="center" style="font-size: 16px; color: #ffffff; font-weight: bold; text-align: center; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: middle; padding: 0px 10px; ">
                                                               Copyright © Sheepfund 2016                            
                                                           </td>
                                                       </tr>
                                                   </table>
                                               </td>
                                           </tr>
                                       </table>
                                       <!--End Support-->

                                       <div style="height:15px">&nbsp;</div><!-- divider-->


                                   </td>
                               </tr>
                           </table> 
                           <!-- End Wrapper -->
                       </body>
                   </html>';
        
        return $content;
    }

}

?>