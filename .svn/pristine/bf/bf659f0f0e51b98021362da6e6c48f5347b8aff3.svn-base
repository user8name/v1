<?php
/**
 * Created by PhpStorm.
 * User: lirenjun
 * Date: 2019/7/16
 * Time: 9:35
 */

class CustomConfig{
    const MSDOMAIN='';
    const TSDOMAIN='';

    const MSEMAIL='';
    const TSEMAIL='';

    const MSMARKED='88';
    const TSMARKED='89';
    const USERNAME="cdwebsCerUNX";
    const PASSWORD="sY1oqMI3NTcsG182bd!cD*H5mqA2c!yK";
    const MKEY="45E936AA23134D49BB2B27505F8B8611";
    const TKEY="3F0E60756DCD470BA9948812FA64C080";

    const RECAPTCHASERVERS='6LfifXoaAAAAAIJ9iuRtQi76rGMtNnlP2LfiJ0dX';
    const RECAPTCHAHTML='6LfifXoaAAAAACBZC7Bc-HS5X1_2JSsfhQ5VgEIR';

}
function post_data($url, $postFields) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    if (is_array($postFields) && 0 < count($postFields)) {
        $postBodyString = "";
        foreach ($postFields as $k => $v) {
            $postBodyString .= "$k=" . urlencode($v) . "&";
        }
        unset($k, $v);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
    }
    $reponse = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch), 0);
    }
    else {
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (200 !== $httpStatusCode) {
            //t			hrow new Exception($reponse,$httpStatusCode);
        }
    }
    curl_close($ch);
    return $reponse;
}
/**
 * @return bool
 *
 * 判断是否为主站
 */

function is_main_domain(){
    $domain=$_SERVER['HTTP_HOST'];
    if(preg_match('/matexcel\.com$/i', $domain)){
        return true;
    }else{
        return false;
    }
}


add_action( 'init', function ()
{
    if ( ! session_id() ) {
        session_start();
    }
}, 1 );


function send_email_inquiry_main($data){
    ini_set("soap.wsdl_cache_enabled", "1");

    $opts = array(
        'ssl' => array('verify_peer' => false, 'verify_peer_name' => false,'cache_wsdl'=>0),
        'https' => array(
            'curl_verify_ssl_peer'  => false,
            'curl_verify_ssl_host'  => false
        )
    );

    $s = new SoapClient('https://202011.cd-payment.com/CDHSLWCoreWebService.asmx?wsdl',array('stream_context' => stream_context_create($opts)));
    $u = new SoapHeader('http://tempuri.org/','CertificateSoapHeader',array('UserName'=>CustomConfig::USERNAME,'Password'=>CustomConfig::PASSWORD),true);
    $s->__setSoapHeaders($u);
    $sessionid=session_id();
    if (is_main_domain()){
        $s->SetSiteInfo(array('id'=>$sessionid,'openKey'=>CustomConfig::MKEY));
    }else{
        $s->SetSiteInfo(array('id'=>$sessionid,'openKey'=>CustomConfig::TKEY));
    }
    $response=$s->SendMailForInquiry($data);
    return $response;
}
function send_email_inquiry_spare($data){
    ini_set("soap.wsdl_cache_enabled", "1");

    $opts = array(
        'ssl' => array('verify_peer' => false, 'verify_peer_name' => false,'cache_wsdl'=>0),
        'https' => array(
            'curl_verify_ssl_peer'  => false,
            'curl_verify_ssl_host'  => false
        )
    );

    $s = new SoapClient('https://202012.cd-payment.com/CDHSLWCoreWebService.asmx?wsdl',array('stream_context' => stream_context_create($opts)));
    $u = new SoapHeader('http://tempuri.org/','CertificateSoapHeader',array('UserName'=>CustomConfig::USERNAME,'Password'=>CustomConfig::PASSWORD),true);
    $s->__setSoapHeaders($u);
    $sessionid=session_id();
    if (is_main_domain()){
        $s->SetSiteInfo(array('id'=>$sessionid,'openKey'=>CustomConfig::MKEY));
    }else{
        $s->SetSiteInfo(array('id'=>$sessionid,'openKey'=>CustomConfig::TKEY));
    }
    $response=$s->SendMailForInquiry($data);
    return $response;
}


function send_email_custom_main($data){
    ini_set("soap.wsdl_cache_enabled", "0");

    $opts = array(
        'ssl' => array('verify_peer' => false, 'verify_peer_name' => false,'cache_wsdl'=>0),
        'https' => array(
            'curl_verify_ssl_peer'  => false,
            'curl_verify_ssl_host'  => false
        )
    );

    $s = new SoapClient('https://202011.cd-payment.com/CDHSLWCoreWebService.asmx?wsdl',array('stream_context' => stream_context_create($opts)));

    $u = new SoapHeader('http://tempuri.org/','CertificateSoapHeader',array('UserName'=>CustomConfig::USERNAME,'Password'=>CustomConfig::PASSWORD),true);
    $s->__setSoapHeaders($u);


    $response=$s->SendEmail($data);

    return $response;
}
function send_email_custom_spare($data){
    ini_set("soap.wsdl_cache_enabled", "0");

    $opts = array(
        'ssl' => array('verify_peer' => false, 'verify_peer_name' => false,'cache_wsdl'=>0),
        'https' => array(
            'curl_verify_ssl_peer'  => false,
            'curl_verify_ssl_host'  => false
        )
    );

    $s = new SoapClient('https://202012.cd-payment.com/CDHSLWCoreWebService.asmx?wsdl',array('stream_context' => stream_context_create($opts)));
    $u = new SoapHeader('http://tempuri.org/','CertificateSoapHeader',array('UserName'=>CustomConfig::USERNAME,'Password'=>CustomConfig::PASSWORD),true);
    $s->__setSoapHeaders($u);
    $response=$s->SendEmail($data);
    return $response;
}


function send_email_subscribe_main($data){
    ini_set("soap.wsdl_cache_enabled", "1");

    $opts = array(
        'ssl' => array('verify_peer' => false, 'verify_peer_name' => false,'cache_wsdl'=>0),
        'https' => array(
            'curl_verify_ssl_peer'  => false,
            'curl_verify_ssl_host'  => false
        )
    );

    $s = new SoapClient('https://202011.cd-payment.com/CDHSLWCoreWebService.asmx?wsdl',array('stream_context' => stream_context_create($opts)));


    $u = new SoapHeader('http://tempuri.org/','CertificateSoapHeader',array('UserName'=>CustomConfig::USERNAME,'Password'=>CustomConfig::PASSWORD),true);
    $s->__setSoapHeaders($u);
    $response=$s->Subscribe($data);
    return $response;
}