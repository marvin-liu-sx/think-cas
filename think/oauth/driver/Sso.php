<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.pptv.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 柳英伟 <448332799@qq.com> 
// +----------------------------------------------------------------------

namespace think\oauth\driver;
use PhpCas\Cas;

class Sso {

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
        $this->sso= new Cas();
        $this->sso->config=$this->config;
    }
    /**
     * 登陆
     */
    public function login(){
        $this->sso->force_auth();
    }
    /**
     * 获取用户信息
     * @return type
     */
    public function getUserInfo(){
        return $this->sso->user();
    }
    /**
     * 退出登陆
     * @param type $url
     */
    public function logout($url){
        $this->sso->logout($url);
    }
    /**
     * 检查用户是否经过身份验证
     */
    public function checkOauth(){
        $this->sso->is_authenticated();
    }

}
