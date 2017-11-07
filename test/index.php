<?php
use think\cas\Cas;
require_once './src/Cas.php';
//use think\cas\Cas;

$config = array(
    'cas_server_url' => 'https://sso.pplive.cn/cas/',
    'cas_disable_server_validation' => TRUE,
    'cas_debug' => FALSE,
    'cas_server_ca_cert' => ''
);
$cas = new Cas($config);

function login($cas) {
    $cas->force_auth();
}

login($cas);

//var_dump($cas->user());
//$cas->logout('http://localhost/think-cas/');