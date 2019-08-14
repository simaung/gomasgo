<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

if (!function_exists('verify_request')) {
    function verify_request() {
        $CI = & get_instance();
        // Get all the headers
        $headers = $CI->input->request_headers();

        if($headers['Authorization'] <> ''){
            // Extract the token
            $token = $headers['Authorization'];

            // Use try-catch
            // JWT library throws exception if the token is not valid
            try {
                // validate the token
                // successfull validation will return the decoded user data else returns false
                $data = AUTHORIZATION::validateToken($token);
                if($data === false){
                    $status = REST_Controller::HTTP_UNAUTHORIZED;
                    $response = ['status' => $status, 'msg' => 'Unauthorized Access!'];
                    $CI->response($response, $status);

                    exit();
                } else {
                    return $data;
                }
            } catch (Exception $e) {
                // Token is invalid
                // Send the unauthorized access message
                $status = REST_Controller::HTTP_UNAUTHORIZED;
                $response = ['status' => $status, 'msg' => 'Unauthorized Access!'];
                $CI->response($response, $status);
            }
        }else{
            $status = REST_Controller::HTTP_UNAUTHORIZED;
            $response = ['status' => $status, 'msg' => 'Unauthorized Access!'];
            $CI->response($response, $status);
        }
        
    }
}