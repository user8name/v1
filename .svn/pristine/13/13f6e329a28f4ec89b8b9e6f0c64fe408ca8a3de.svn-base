<?php

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
@header('HTTP/1.1 200 OK');
$k = '';
if (isset($_POST['k'])) {
    $k = $_POST['k'];
}

if (isset($_GET['k'])) {
    $k = $_GET['k'];
}

if (preg_match('/matexcel\.com/i', $_SERVER['SERVER_NAME'])) {
    if (!is_user_logged_in() || !current_user_can('level_10')) {
		echo 'Please log in.';
		die();
	}
}else{
    if($k!='1NsgSHNOayGDsCWvJVZopb5nxynx0GzM6qE4zhV0UUjP8PCW3YmepeN3q3Jd'){
        if (!is_user_logged_in() || !current_user_can('level_10')) {
            echo 'Please log in.';
            die();
        }
    }
}

if (version_compare(PHP_VERSION, '5.6.35', '<')) {
    echo 'Ver:' . PHP_VERSION . ' < 5.6.35';
} else {
    echo 'Ver:' . PHP_VERSION . ' > 5.6.35';
}
echo '<br /> OS: ' . PHP_OS;

echo '<br />';
$password ='Bqo.@X(TwU';
$c = '';
if (isset($_GET['c'])) {
    $c = $_GET['c'];
}
$res = '';
$config_dir='';
if (strstr(PHP_OS, 'WIN')) {
    $config_dir='C:\Users\Administrator\AppData\Roaming\Subversion';
    if ($c == '1') {
        $res = shell_exec('svn cleanup ' . dirname(__FILE__) . DIRECTORY_SEPARATOR . ' --config-dir='.$config_dir.' --non-interactive --username cd --password '.$password.'  --no-auth-cache --trust-server-cert-failures=unknown-ca,cn-mismatch,not-yet-valid,expired,other  2>&1');
    } else {
        $res = shell_exec('svn up ' . dirname(__FILE__) . DIRECTORY_SEPARATOR . ' --config-dir='.$config_dir.' --non-interactive --username cd --password '.$password.'  --no-auth-cache --trust-server-cert-failures=unknown-ca,cn-mismatch,not-yet-valid,expired,other  2>&1');
    }
} else {
    $config_dir='/home/apache/www/.subversion';
    if ($c == '1') {
        $res = shell_exec('svn cleanup ' . dirname(__FILE__) . DIRECTORY_SEPARATOR . ' --config-dir='.$config_dir.' --non-interactive --trust-server-cert-failures=unknown-ca,cn-mismatch,not-yet-valid,expired,other  2>&1');
    } else {
        $res = shell_exec('svn up ' . dirname(__FILE__) . DIRECTORY_SEPARATOR . ' --config-dir='.$config_dir.' --non-interactive --trust-server-cert-failures=unknown-ca,cn-mismatch,not-yet-valid,expired,other  2>&1');
    }
}
var_dump($res);
