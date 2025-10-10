<?php

use Kint\Zval\Value;

function res_success($status, $message, $data) {
    $response = [
        'status'  => $status,
        'message' => $message,
        'data'    => $data
    ];

    return $response;
}

function res_notfound($status, $message) {
    $response = [
        'status' => $status,
        'message' => $message
    ];

    return $response;
}

function res_where($res_where = [], $root_where = "") {
    $fix_where = $root_where != "" ? $root_where . " " : "";
    if($res_where) {
        foreach ($res_where as $key => $value) {
            return $fix_where . "" . $key . " = "  . "'" . $value ."'";
        }
    }

    return false;
}