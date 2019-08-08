<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Email Settings
| -------------------------------------------------------------------
| Configuration of outgoing mail server.
| */

$config['protocol']     = 'smtp';
$config['smtp_host']    = 'smtp.mail.yahoo.com';
$config['smtp_port']    = '587';
$config['smtp_timeout'] = '60';
$config['smtp_user']    = 'gomasgo.umrah@yahoo.com';
$config['smtp_pass']    = 'umroh123';
$config['smtp_secure']  = 'tls';
$config['charset']      = 'utf-8';
$config['mailtype']     = 'html';
$config['wordwrap']     = TRUE;
$config['newline']      = "\r\n";
$config['from_email']   = "gomasgo.umrah@yahoo.com";
$config['from_name']    = "System Gomasgo Umrah";
$config['reply_to']     = "gomasgo.umrah@yahoo.com";
