<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.pptv.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 柳英伟 <448332799@qq.com> 
// +----------------------------------------------------------------------

namespace think\oauth\driver;
use think\cas\Cas;
use think\Config;

class Cas {

    private $config = [];
    private $sso;

    public function __construct($config = []) {
        $default = [
            'cas_server_url' => '',//sso服务器地址
            'cas_disable_server_validation' => TRUE,
            'cas_debug' => FALSE,
            'cas_server_ca_cert' => ''
        ];
        $this->config   = array_merge($default, $config);
        $this->sso= new Cas($this->config);
    }
    
    public function login(){
        $this->sso->force_auth();
    }
    
    public function getUserInfo(){
        return $this->sso->user();
    }
    
    public function logout($url){
        $this->sso->logout($url);
    }

}
