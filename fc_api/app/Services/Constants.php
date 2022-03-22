<?php

/**
 * REQUEST AND RESPONSE CONSTANT
 */
define('RESPONSE_YES', 'yes');
define('RESPONSE_NO', 'no');
define('RESPONSE_NULL', 'NULL');

/**
 *  Message while responsing json
 * Auth and staff and groupPermission Message
 */

define('MSG_DATA_FOUND', 'Record found.');
define('MSG_DATA_NOT_FOUND', 'Record not found.');
define('MSG_SELECT_SEARCH_PARAMETER', 'Please select at least one search parameter.');
define('MSG_USER_LOGIN_SUCCESS', 'You are successfully logged in.');
define('MSG_USER_FOUND', 'User found.');
define('MSG_UNAUTHORISED_USER', 'You are unauthorised user.');
define('MSG_USER_LOGIN_FAIL', 'Username or password are incorrect.');
define('MSG_USER_LOGOUT_SUCCESS', 'You are successfully logged out.');
define('MSG_USER_INSERTION_FAILED', 'Employee has failed to create.');
define('MSG_USERNAME_ALREADY_EXIST', 'Username already exist.');
define('MSG_EMAIL_ALREADY_EXIST', 'Email already exist.');
define('MSG_USER_EDIT_SUCESS', 'Employee edited successfully');
define('MSG_USER_INSERTION_SUCESS', 'Employee added successfully.');
define('MSG_USER_DELETION_SUCESS', 'Employee has been  deleted successfully.');
define('MSG_GROUP_PERMISSION_INSERTION_SUCESS', 'Group permission has been changed successfully.');
define('MSG_PASSWORD_CHANGE_SUCESS', 'Password change successfully.');
define('MSG_PROFILE_CHANGE_SUCESS', 'Profile hase been changed successfully.');
define('MSG_GROUP_PERMISSION_RESET_SUCCESS', 'Group permission has been reseted successfully.');

/**
 * Forgot Password
 */
define('MSG_FORGOT_PASSWORD_MAIL', 'OTP has been sent to your email address');
define('MSG_MAIL_SEND_ERROR', 'Mail send error');
define('MSG_OTP_EXPIRE', 'You passport code is expired.');
define('MSG_WRONG_OTP', 'You have enterd wrong otp.');
define('MSG_PASSCODE_VERYFIED_SUCCESS', 'OTP has been verified successfully.');

/**
 * Mail Subject
 */
define('MSG_FORGOT_PASSWORD_SUBJECT', 'Forgot Your Password');

/**
 * APPLICATION PATH
 */

/* RAHUL LOCAL SERVER */
define('STORAGE_PATH', "C:/Trillium/ti_api/public/");
define('APP_API_PATH', "http://localhost:8000/");

/**
 * Mail Settings
 */
define('MAIL_USERNAME', "test.dynamic@gmail.com");
define('MAIL_PASSWROD', "1u1YA551");
define('MAIL_SMTP_SECURE', "tls");
define('MAIL_HOST', "smtp.gmail.com");
// define('MAIL_PORT', 465);
define('MAIL_PORT', 587);
define('MAIL_SENDER', "support@smartrxhub.ca");
define('MAIL_SENDER_NAME', "Trillium");
/**
 * APPLICATION SETTINGS
 */
define('APPLICATION_EVENT_LOG', TRUE);
define('APPLICATION_FORGOT_PASSWORD_MINUTE', 30);
// define('APPLICATION_INFO', array("app_name" => "Trillium", "app_logo" => "data/images/application/logo.png"));