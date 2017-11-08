# think-cas
### **一般使用eg.**
~~~
<?php
use PhpCas\Cas;
require_once '../src/Cas.php';

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
~~~


***

### **thinkphp 调用**

~~~
<?php
namespace app\index\controller;
use think\oauth\driver\Sso;
class Index
{
    public function index()
    {
        $default = [
            'cas_server_url' => 'https://xxx/cas/',//sso服务器地址
            'cas_disable_server_validation' => TRUE,
            'cas_debug' => FALSE,
            'cas_server_ca_cert' => ''
        ];
        $sso=new Sso($default);
        $sso->login();     
    }
}
~~~