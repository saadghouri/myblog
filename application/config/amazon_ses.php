<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Config for the Amazon Simple Email Service library
 *
 * @see ../libraries/Amazon_ses.php
 */
// Amazon credentials
$config['amazon_ses_secret_key'] = 'Lla61ZCh8BwKQ7ilOZ6z5UXdFDgUl/3Ym7FjYMQ9';
$config['amazon_ses_access_key'] = 'AKIAIR2WEYV5NSDPV5AQ';

// Adresses
$config['amazon_ses_from'] = 'no-reply@inrentory.com';
$config['amazon_ses_from_name'] = 'inRENTory';
$config['amazon_ses_reply_to'] = 'no-reply@inrentory.com';

// Path to certificate to verify SSL connection (i.e. 'certs/cacert.pem') 
$config['amazon_ses_cert_path'] = 'certs/amanzon_ses.pem';

// Charset to be used, for example UTF-8, ISO-8859-1 or Shift_JIS. The SMTP
// protocol uses 7-bit ASCII by default
$config['amazon_ses_charset'] = 'UTF-8';