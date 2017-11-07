<?php

namespace Cas;

class Cas {

    public $config = array(
        'cas_server_url' => '',
        'phpcas_path' => '../phpCAS',
        'cas_disable_server_validation' => TRUE,
        'cas_debug' => FALSE,
        'cas_server_ca_cert' => ''
    );

    public function __construct() {
        if (!function_exists('curl_init')) {
            show_error('<strong>ERROR:</strong> You need to install the PHP module
				<strong><a href="http://php.net/curl">curl</a></strong> to be able
				to use CAS authentication.');
        }


        $this->phpcas_path = $this->config['phpcas_path'];
        $this->cas_server_url = $this->config['cas_server_url'];
        if (empty($this->phpcas_path)
                or filter_var($this->cas_server_url, FILTER_VALIDATE_URL) === FALSE) {
            cas_show_config_error();
        }
        $cas_lib_file = $this->phpcas_path . '/CAS.php';
        if (!file_exists($cas_lib_file)) {
            show_error("<strong>ERROR:</strong> Could not find a file <em>CAS.php</em> in directory
				<strong>$this->phpcas_path</strong><br /><br />
				Please, check your config file <strong>config/cas.php</strong> and make sure the
				configuration <em>phpcas_path</em> is a valid phpCAS installation.");
        }
        require_once $cas_lib_file;

        if ($this->config['cas_debug']) {
            phpCAS::setDebug();
        }

        // init CAS client
        $defaults = array('path' => '', 'port' => 443);
        $cas_url = array_merge($defaults, parse_url($this->cas_server_url));
        phpCAS::client(SAML_VERSION_1_1, $cas_url['host'], $cas_url['port'], $cas_url['path']);

        // configures SSL behavior
        if ($this->config['cas_disable_server_validation']) {
            phpCAS::setNoCasServerValidation();
        } else {
            $ca_cert_file = $this->configm['cas_server_ca_cert'];
            if (empty($ca_cert_file)) {
                cas_show_config_error();
            }
            phpCAS::setCasServerCACert($ca_cert_file);
        }
    }
    /**
     * 登陆
     */
    public function force_auth() {
        phpCAS::forceAuthentication();
    }

    /**
     *  获取用户信息 
     */
    public function user() {
        if (phpCAS::isAuthenticated()) {
            $userlogin = phpCAS::getUser();
            $attributes = phpCAS::getAttributes();
            return (object) array('userlogin' => $userlogin,
                        'attributes' => $attributes);
        } else {
            show_error("User was not authenticated yet.");
        }
    }

    /**
     *  Logout and redirect to the main site URL,
     *  or to the URL passed as argument
     */
    public function logout($url = '') {

        phpCAS::logoutWithRedirectService($url);
    }

    public function is_authenticated() {
        return phpCAS::isAuthenticated();
    }

}
