<?php

namespace App\Helpers;


class ResponseHelper {


    /**
     * SuccessResponse common method for succes response.
     * @param  $dataset Array  
     * @param  $msg string
     * @return Array 
     */
    public static function successResponse($dataset , $code = 200 ,  $msg = 'Data Inserted Successfully'){

        $data['status'] = 1;
        $data['message'] = $msg;
        $data['code'] = $code;
        $data['data'] = $dataset;
        return $data;

    }


     /**
     * FailedResponse common method for failed response.
     * @param  $msg string
     * @return Array 
     */
    public static function failedResponse($msg , $code){

        $data['status'] = 0;
        $data['message'] = $msg;
        $data['code'] = $code;
        $data['data'] = [];
        return $data;
    }

}

