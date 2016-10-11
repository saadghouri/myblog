<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aemail {

    var $url = 'https://android.googleapis.com/gcm/send';
    var $serverApiKey = "AIzaSyD1kXMyZFPmIUOLPUSg_52d3N5dJ4TqaaI";
    var $devices = array();
    var $final_message = "";
    var $b_name = "inRENTory";
    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    function set_tamplate($tamplate_code, $att, $escalation_email = false) {
        $this->CI->load->helper('url');
        //if(!isset($att['p_by']))
        //    $att['p_by'] = "inRENTory.Inc";

        if (!isset($att['b_name']))
            $this->b_name = $att['p_by'];
        else
            $this->b_name = $att['b_name'];

        $building_logo = "";
        if (isset($att['b_id'])) {
            $building_logo = $this->CI->building_model->get_att($att['b_id'], 'top_logo');
            $att['logo_url'] = SITE_URL . "app_images/" . $building_logo;
        }


        if (!isset($att['logo_url']))
            $att['logo_url'] = "http://inrentory.com/app_images/top_bar_logo.jpg";

        $att['p_by'] = "inRENTory";
        if (isset($att['link']))
            $att['link'] = SITE_URL . 'api/login/launchApp?buildingId=' . $att['b_id'] . '&url=' . $att['link'];

        switch ($tamplate_code) {
            case 1:
                $this->final_message = '
                <!doctype html>
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <meta name="viewport" content="initial-scale=1.0" />
                    <meta name="format-detection" content="telephone=no" />
                    <title></title>
                    <style type="text/css">
                        body {
                            width: 100%;
                            margin: 0;
                            padding: 0;
                            -webkit-font-smoothing: antialiased;
                        }
                        @media only screen and (max-width: 600px) {
                            table[class="table-row"] {
                                float: none !important;
                                width: 98% !important;
                                padding-left: 20px !important;
                                padding-right: 20px !important;
                            }
                            table[class="table-row-fixed"] {
                                float: none !important;
                                width: 98% !important;
                            }
                            table[class="table-col"], table[class="table-col-border"] {
                                float: none !important;
                                width: 100% !important;
                                padding-left: 0 !important;
                                padding-right: 0 !important;
                                table-layout: fixed;
                            }
                            td[class="table-col-td"] {
                                width: 100% !important;
                            }
                            table[class="table-col-border"] + table[class="table-col-border"] {
                                padding-top: 12px;
                                margin-top: 12px;
                                border-top: 1px solid #E8E8E8;
                            }
                            table[class="table-col"] + table[class="table-col"] {
                                margin-top: 15px;
                            }
                            td[class="table-row-td"] {
                                padding-left: 0 !important;
                                padding-right: 0 !important;
                            }
                            table[class="navbar-row"] , td[class="navbar-row-td"] {
                                width: 100% !important;
                            }
                            img {
                                max-width: 100% !important;
                                display: inline !important;
                            }
                            img[class="pull-right"] {
                                float: right;
                                margin-left: 11px;
                                max-width: 125px !important;
                                padding-bottom: 0 !important;
                            }
                            img[class="pull-left"] {
                                float: left;
                                margin-right: 11px;
                                max-width: 125px !important;
                                padding-bottom: 0 !important;
                            }
                            table[class="table-space"], table[class="header-row"] {
                                float: none !important;
                                width: 98% !important;
                            }
                            td[class="header-row-td"] {
                                width: 100% !important;
                            }
                        }
                        @media only screen and (max-width: 480px) {
                            table[class="table-row"] {
                                padding-left: 16px !important;
                                padding-right: 16px !important;
                            }
                        }
                        @media only screen and (max-width: 320px) {
                            table[class="table-row"] {
                                padding-left: 12px !important;
                                padding-right: 12px !important;
                            }
                        }
                        @media only screen and (max-width: 458px) {
                            td[class="table-td-wrap"] {
                                width: 100% !important;
                            }
                        }
                    </style>
                </head>
                <body style="font-family: Arial, sans-serif; font-size:13px; color: #444444; min-height: 200px;" bgcolor="#E4E6E9" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0" >';
                if (isset($att['link']) && !$escalation_email) {
                    $this->final_message .= '<a href="' . $att['link'] . '">';
                }
                $this->final_message .= '<table width="100%" height="100%" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0" >
                        <tr><td width="100%" align="center" valign="top" bgcolor="#E4E6E9" style="background-color:#E4E6E9; min-height: 200px;">
                            <table><tr><td class="table-td-wrap" align="center" width="458">

                            <table class="table-row" style="table-layout: auto;margin-top: 4px;padding-right: 24px; padding-left: 24px; width: 450px; background-color: #ffffff;" bgcolor="#ffffff" width="450" cellspacing="0" cellpadding="0" border="0"><tbody><tr height="55px" style="font-family: Arial, sans-serif; line-height: 19px; color: #438eb9; font-size: 13px; height: 55px;">
                               <td class="table-row-td" style="height: 55px; padding-right: 16px; font-family: Arial, sans-serif; line-height: 19px; color: #438eb9; font-size: 13px; font-weight: normal; vertical-align: middle;" valign="middle" align="left">
                                 <a href="#" style="color: #438eb9; text-decoration: none; padding: 0px; font-size: 18px; line-height: 20px; height: 50px; background-color: transparent;">
                                  <img src="' . $att['logo_url'] . '" />
                                 </a>
                               </td>
                             
                               <td class="table-row-td" style="height: 55px; font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; text-align: right; vertical-align: middle;" align="right" valign="middle">
                                 <a href="#" style="color: #438eb9; text-decoration: none; font-size: 15px; background-color: transparent;">
                                   Powered By ' . $att['p_by'] . '
                                 </a>
                               </td>
                            </tr></tbody></table>

                            <table class="table-space" height="2" style="height: 2px; font-size: 0px; line-height: 0; width: 450px; background-color: #6FB3E0;" width="450" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="2" style="height: 2px; width: 450px; background-color: #6FB3E0;" width="450" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table>
                            <table class="table-space" height="8" style="height: 8px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="8" style="height: 8px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

                            <table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
                                

                                <table class="table-col" align="left" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="378" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" align="left">
                                    <div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px;">
                                        ' . $att['content'] . '
                                    </div>
                                </td></tr></tbody></table>
                            </td></tr></tbody></table>

                            <table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

                            <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

                            ';

                if (isset($att['link'])) {
                    $this->final_message .= '<table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
                              <table class="table-col" align="left" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="378" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" align="left">
                                <div style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; text-align: center;">
                                  <a href="' . $att['link'] . '" style="color: #ffffff; text-decoration: none; margin: 0px; text-align: center; vertical-align: baseline; border: 4px solid #6fb3e0; padding: 4px 9px; font-size: 15px; line-height: 21px; background-color: #6fb3e0;">&nbsp; ' . $att['button_title'] . ' &nbsp;</a>
                              </div>
                              <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 378px; background-color: #ffffff;" width="378" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 378px; background-color: #ffffff;" width="378" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
                              </td></tr></tbody></table>
                          </td></tr></tbody></table>';
                }

                $this->final_message .='
                      <table class="table-row-fixed" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-fixed-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 1px; padding-right: 1px;" valign="top" align="left">
                        <table class="table-col" align="left" width="448" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="448" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
                            ';
                //if(isset($att['b_phone'])){
                if (false) {
                    $this->final_message .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td width="100%" align="center" bgcolor="#f5f5f5" style="font-family: Arial, sans-serif; line-height: 24px; color: #bbbbbb; font-size: 13px; font-weight: normal; text-align: center; padding: 9px; border-width: 1px 0px 0px; border-style: solid; border-color: #e3e3e3; background-color: #f5f5f5;" valign="top">
                                Please do not reply to this email, as it is unattended. Should you have any questions, you can reach the building administration at
                                <a href="#" style="color: #428bca; text-decoration: none; background-color: transparent;">' . $att['b_phone'] . '</a>
                                <br>
                            </td></tr></tbody></table>';
                } else {
                    $this->final_message .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td width="100%" align="center" bgcolor="#f5f5f5" style="font-family: Arial, sans-serif; line-height: 24px; color: #bbbbbb; font-size: 13px; font-weight: normal; text-align: center; padding: 9px; border-width: 1px 0px 0px; border-style: solid; border-color: #e3e3e3; background-color: #f5f5f5;" valign="top">
                                Questions, comments, suggestions? Use the app, because we want to know!
                                <br>
                            </td></tr></tbody></table>';
                }
                $this->final_message .= '</td></tr></tbody></table>
                    </td></tr></tbody></table>
                    <table class="table-space" height="1" style="height: 1px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="1" style="height: 1px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
                    <table class="table-space" height="36" style="height: 36px; font-size: 0px; line-height: 0; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="36" style="height: 36px; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table></td></tr></table>
                </td></tr>
                </table>';
                if (isset($att['link']) && !$escalation_email) {
                    $this->final_message .= '</a>';
                }
                $this->final_message .= '</body></html>';
                break;
            case 2:
                $this->final_message = '<!doctype html>
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <meta name="viewport" content="initial-scale=1.0" />
                    <meta name="format-detection" content="telephone=no" />
                    <title></title>
                    <style type="text/css">
                        body {
                            width: 100%;
                            margin: 0;
                            padding: 0;
                            -webkit-font-smoothing: antialiased;
                        }
                        @media only screen and (max-width: 600px) {
                            table[class="table-row"] {
                                float: none !important;
                                width: 98% !important;
                                padding-left: 20px !important;
                                padding-right: 20px !important;
                            }
                            table[class="table-row-fixed"] {
                                float: none !important;
                                width: 98% !important;
                            }
                            table[class="table-col"], table[class="table-col-border"] {
                                float: none !important;
                                width: 100% !important;
                                padding-left: 0 !important;
                                padding-right: 0 !important;
                                table-layout: fixed;
                            }
                            td[class="table-col-td"] {
                                width: 100% !important;
                            }
                            table[class="table-col-border"] + table[class="table-col-border"] {
                                padding-top: 12px;
                                margin-top: 12px;
                                border-top: 1px solid #E8E8E8;
                            }
                            table[class="table-col"] + table[class="table-col"] {
                                margin-top: 15px;
                            }
                            td[class="table-row-td"] {
                                padding-left: 0 !important;
                                padding-right: 0 !important;
                            }
                            table[class="navbar-row"] , td[class="navbar-row-td"] {
                                width: 100% !important;
                            }
                            img {
                                max-width: 100% !important;
                                display: inline !important;
                            }
                            img[class="pull-right"] {
                                float: right;
                                margin-left: 11px;
                                max-width: 125px !important;
                                padding-bottom: 0 !important;
                            }
                            img[class="pull-left"] {
                                float: left;
                                margin-right: 11px;
                                max-width: 125px !important;
                                padding-bottom: 0 !important;
                            }
                            table[class="table-space"], table[class="header-row"] {
                                float: none !important;
                                width: 98% !important;
                            }
                            td[class="header-row-td"] {
                                width: 100% !important;
                            }
                        }
                        @media only screen and (max-width: 480px) {
                            table[class="table-row"] {
                                padding-left: 16px !important;
                                padding-right: 16px !important;
                            }
                        }
                        @media only screen and (max-width: 320px) {
                            table[class="table-row"] {
                                padding-left: 12px !important;
                                padding-right: 12px !important;
                            }
                        }
                        @media only screen and (max-width: 458px) {
                            td[class="table-td-wrap"] {
                                width: 100% !important;
                            }
                        }
                    </style>
                </head>
                <body style="font-family: Arial, sans-serif; font-size:13px; color: #444444; min-height: 200px;" bgcolor="#E4E6E9" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
                    <table width="100%" height="100%" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0">
                        <tr><td width="100%" align="center" valign="top" bgcolor="#E4E6E9" style="background-color:#E4E6E9; min-height: 200px;">
                            <table><tr><td class="table-td-wrap" align="center" width="458">
                            
                            <table class="table-row" style="table-layout: auto;margin-top: 4px;padding-right: 24px; padding-left: 24px; width: 450px; background-color: #ffffff;" bgcolor="#ffffff" width="450" cellspacing="0" cellpadding="0" border="0"><tbody><tr height="55px" style="font-family: Arial, sans-serif; line-height: 19px; color: #438eb9; font-size: 13px; height: 55px;">
                               <td class="table-row-td" style="height: 55px; padding-right: 16px; font-family: Arial, sans-serif; line-height: 19px; color: #438eb9; font-size: 13px; font-weight: normal; vertical-align: middle;" valign="middle" align="left">
                                 <a href="#" style="color: #438eb9; text-decoration: none; padding: 0px; font-size: 18px; line-height: 20px; height: 50px; background-color: transparent;">
                                  <img src="' . $att['logo_url'] . '" />
                                 </a>
                               </td>
                             
                               <td class="table-row-td" style="height: 55px; font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; text-align: right; vertical-align: middle;" align="right" valign="middle">
                                 <a href="#" style="color: #438eb9; text-decoration: none; font-size: 15px; background-color: transparent;">
                                   Powered By ' . $att['p_by'] . '
                                 </a>
                               </td>
                            </tr></tbody></table>

                            <table class="table-space" height="2" style="height: 2px; font-size: 0px; line-height: 0; width: 450px; background-color: #6FB3E0;" width="450" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="2" style="height: 2px; width: 450px; background-color: #6FB3E0;" width="450" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table>
                            <table class="table-space" height="8" style="height: 8px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="8" style="height: 8px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

                            <table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
                                <table class="table-col" align="left" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="378" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" align="left">
                                    <div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px;">
                                        ' . $att['content'] . '
                                    </div>
                                </td></tr></tbody></table>
                            </td></tr></tbody></table>

                            <table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

                            <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

                            <table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
                              <table class="table-col" align="left" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="378" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" align="left">
                                <div style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; text-align: center;">
                                  <a href="' . $att['link'] . '" style="color: #ffffff; text-decoration: none; margin: 0px; text-align: center; vertical-align: baseline; border: 4px solid #6fb3e0; padding: 4px 9px; font-size: 15px; line-height: 21px; background-color: #6fb3e0;">&nbsp; ' . $att['button_title'] . ' &nbsp;</a>
                                </div>
                                <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 378px; background-color: #ffffff;" width="378" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 378px; background-color: #ffffff;" width="378" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
                              </td></tr></tbody></table>
                            </td></tr></tbody></table>

                            <table class="table-row-fixed" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-fixed-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 1px; padding-right: 1px;" valign="top" align="left">
                                <table class="table-col" align="left" width="448" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="448" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td width="100%" align="center" bgcolor="#f5f5f5" style="font-family: Arial, sans-serif; line-height: 24px; color: #bbbbbb; font-size: 13px; font-weight: normal; text-align: center; padding: 9px; border-width: 1px 0px 0px; border-style: solid; border-color: #e3e3e3; background-color: #f5f5f5;" valign="top">
                                        Questions, comments, suggestions? Use the app, because we want to know!
                                        <br>
                                    </td></tr></tbody></table>
                                </td></tr></tbody></table>
                            </td></tr></tbody></table>
                            <table class="table-space" height="1" style="height: 1px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="1" style="height: 1px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
                            <table class="table-space" height="36" style="height: 36px; font-size: 0px; line-height: 0; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="36" style="height: 36px; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table></td></tr></table>
                        </td></tr>
                    </table>
                </body>
                </html>';
                break;
            case 3:
                $this->final_message = '
                <!doctype html>
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <meta name="viewport" content="initial-scale=1.0" />
                    <meta name="format-detection" content="telephone=no" />
                    <title></title>
                    <style type="text/css">
                        body {
                            width: 100%;
                            margin: 0;
                            padding: 0;
                            -webkit-font-smoothing: antialiased;
                        }
                        @media only screen and (max-width: 600px) {
                            table[class="table-row"] {
                                float: none !important;
                                width: 98% !important;
                                padding-left: 20px !important;
                                padding-right: 20px !important;
                            }
                            table[class="table-row-fixed"] {
                                float: none !important;
                                width: 98% !important;
                            }
                            table[class="table-col"], table[class="table-col-border"] {
                                float: none !important;
                                width: 100% !important;
                                padding-left: 0 !important;
                                padding-right: 0 !important;
                                table-layout: fixed;
                            }
                            td[class="table-col-td"] {
                                width: 100% !important;
                            }
                            table[class="table-col-border"] + table[class="table-col-border"] {
                                padding-top: 12px;
                                margin-top: 12px;
                                border-top: 1px solid #E8E8E8;
                            }
                            table[class="table-col"] + table[class="table-col"] {
                                margin-top: 15px;
                            }
                            td[class="table-row-td"] {
                                padding-left: 0 !important;
                                padding-right: 0 !important;
                            }
                            table[class="navbar-row"] , td[class="navbar-row-td"] {
                                width: 100% !important;
                            }
                            img {
                                max-width: 100% !important;
                                display: inline !important;
                            }
                            img[class="pull-right"] {
                                float: right;
                                margin-left: 11px;
                                max-width: 125px !important;
                                padding-bottom: 0 !important;
                            }
                            img[class="pull-left"] {
                                float: left;
                                margin-right: 11px;
                                max-width: 125px !important;
                                padding-bottom: 0 !important;
                            }
                            table[class="table-space"], table[class="header-row"] {
                                float: none !important;
                                width: 98% !important;
                            }
                            td[class="header-row-td"] {
                                width: 100% !important;
                            }
                        }
                        @media only screen and (max-width: 480px) {
                            table[class="table-row"] {
                                padding-left: 16px !important;
                                padding-right: 16px !important;
                            }
                        }
                        @media only screen and (max-width: 320px) {
                            table[class="table-row"] {
                                padding-left: 12px !important;
                                padding-right: 12px !important;
                            }
                        }
                        @media only screen and (max-width: 458px) {
                            td[class="table-td-wrap"] {
                                width: 100% !important;
                            }
                        }
                    </style>
                </head>
                <body style="font-family: Arial, sans-serif; font-size:13px; color: #444444; min-height: 200px;" bgcolor="#E4E6E9" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
                    <table width="100%" height="100%" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0">
                        <tr><td width="100%" align="center" valign="top" bgcolor="#E4E6E9" style="background-color:#E4E6E9; min-height: 200px;">
                            <table><tr><td class="table-td-wrap" align="center" width="458">

                                            <table class="table-row" style="table-layout: auto;margin-top: 4px;padding-right: 24px; padding-left: 24px; width: 450px; background-color: #ffffff;" bgcolor="#ffffff" width="450" cellspacing="0" cellpadding="0" border="0"><tbody><tr height="55px" style="font-family: Arial, sans-serif; line-height: 19px; color: #438eb9; font-size: 13px; height: 55px;">
                   <td class="table-row-td" style="height: 55px; padding-right: 16px; font-family: Arial, sans-serif; line-height: 19px; color: #438eb9; font-size: 13px; font-weight: normal; vertical-align: middle;" valign="middle" align="left">
                     <a href="#" style="color: #438eb9; text-decoration: none; padding: 0px; font-size: 18px; line-height: 20px; height: 50px; background-color: transparent;">
                      <img src="' . $att['logo_url'] . '" />
                     </a>
                   </td>
                 
                   <td class="table-row-td" style="height: 55px; font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; text-align: right; vertical-align: middle;" align="right" valign="middle">
                     <a href="#" style="color: #438eb9; text-decoration: none; font-size: 15px; background-color: transparent;">
                       Powered By ' . $att['p_by'] . '
                     </a>
                   </td>
                </tr></tbody></table>

                            <table class="table-space" height="2" style="height: 2px; font-size: 0px; line-height: 0; width: 450px; background-color: #6FB3E0;" width="450" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="2" style="height: 2px; width: 450px; background-color: #6FB3E0;" width="450" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table>
                            <table class="table-space" height="8" style="height: 8px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="8" style="height: 8px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

                            <table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
                                

                                <table class="table-col" align="left" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="378" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" align="left">
                                    <div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px;">
                                        ' . $att['content'] . '
                                    </div>
                                </td></tr></tbody></table>
                            </td></tr></tbody></table>

                            <table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

                            <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

                            <table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
                              <table class="table-col" align="left" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="378" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" align="left">
                                <div style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; text-align: center;">
                                  <a href="' . $att['link'] . '" style="color: #ffffff; text-decoration: none; margin: 0px; text-align: center; vertical-align: baseline; border: 4px solid #6fb3e0; padding: 4px 9px; font-size: 15px; line-height: 21px; background-color: #6fb3e0;">&nbsp; ' . $att['button_title'] . ' &nbsp;</a>
                              </div>
                              <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 378px; background-color: #ffffff;" width="378" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 378px; background-color: #ffffff;" width="378" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
                          </td></tr></tbody></table>
                      </td></tr></tbody></table>

                      <table class="table-row-fixed" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-fixed-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 1px; padding-right: 1px;" valign="top" align="left">
                        <table class="table-col" align="left" width="448" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="448" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td width="100%" align="center" bgcolor="#f5f5f5" style="font-family: Arial, sans-serif; line-height: 24px; color: #bbbbbb; font-size: 13px; font-weight: normal; text-align: center; padding: 9px; border-width: 1px 0px 0px; border-style: solid; border-color: #e3e3e3; background-color: #f5f5f5;" valign="top">
                                Questions, comments, suggestions? Use the app, because we want to know!
                                <br>
                            </td></tr></tbody></table>
                        </td></tr></tbody></table>
                    </td></tr></tbody></table>
                    <table class="table-space" height="1" style="height: 1px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="1" style="height: 1px; width: 450px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
                    <table class="table-space" height="36" style="height: 36px; font-size: 0px; line-height: 0; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="36" style="height: 36px; width: 450px; background-color: #e4e6e9;" width="450" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table></td></tr></table>
                </td></tr>
                </table>
                </body>
                </html>';
                break;
            default:
                $return_result = false;
        }
    }

    /*
      Send the email
      @param $message The message to send
      @param $data Array of data to accompany the message
     */

    function send($f, $to, $subject,$message) {
        if ($message != "") {
            $f = "no-reply@inrentory.com";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= 'From: <no-reply@inrentory.com>' . "\r\n";

            //mail($to,$subject,$this->final_message,$headers);
            $this->CI->load->library('unit_test');
            $this->CI->load->library('amazon_ses');
            $this->CI->amazon_ses->from($f, 'Sheep Fund');
            $this->CI->amazon_ses->to($to);
            $this->CI->amazon_ses->subject($subject);
            $this->CI->amazon_ses->message($message);
            return $this->CI->amazon_ses->send();
        }
    }

    function set_email_content($email_content) {
        $this->final_message = $email_content;
    }

    /*
     * Get Email Content
     * 
     */

    function email_content() {
        return $this->final_message;
    }

}

/* End of file Someclass.php */