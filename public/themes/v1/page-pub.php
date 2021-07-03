<?php
/**
 * Template Name: Inquiry Pub
 */
$act = trim($_REQUEST['act']);
$email = "";

$extend = "";
if (is_main_domain()) {
} else {
    $extend = "[external]";
}

    $name = stripslashes(trim($_REQUEST['name1']));
    $phone = stripslashes(trim($_REQUEST['phone']));
    $email = stripslashes(trim($_REQUEST['email']));
    $address = stripslashes(trim($_REQUEST['address']));
    $services = stripslashes(trim($_REQUEST['services']));
    $description = stripslashes(trim($_REQUEST['description']));
    $message = stripslashes(trim($_REQUEST['message']));


    if ($act == "send") {
        $Marked = CustomConfig::TSMARKED;
        if ($extend == '') {
            $Marked = CustomConfig::MSMARKED;
        }
        $code = isset($_REQUEST['g-recaptcha-response']) ? $_REQUEST['g-recaptcha-response'] : '';
        $resps = post_data('https://www.recaptcha.net/recaptcha/api/siteverify', ['secret' => CustomConfig::RECAPTCHASERVERS, 'response' => $code]);
        $resp = json_decode($resps, true);
        if (isset($resp['success']) && $resp['success'] == true) {
        } else {
            showalert("verification failed!");
        }


        $ip = get_ip();
        $content = "<table cellpadding='0' width='100%' cellspacing='0' border='0' style='line-height:32px;  text-align:left;margin:auto;'>
	<tr><td colspan='2' style='background-color:#f5f5f5; padding-left:10px;'>Information</td></tr>
	<tr>
	  <td style='padding-left:10px;  width:200px'>Name: </td>
	  <td>" . $name . "</td>
    </tr>
    <tr>
	  <td style='padding-left:10px;  width:200px'>Phone: </td>
	  <td>" . $phone . "</td>
    </tr>
    <tr>
	  <td style='padding-left:10px;'>Address:</td>
	  <td>" . $address . "</td>
	</tr>
    <tr>
    <td style='padding-left:10px;'>E-mail:</td>
    <td>" . $email . "</td>
    </tr>
    <tr>
	  <td style='padding-left:10px;'>Services &amp; Products of Interest:</td>
	  <td>" . $services . "</td>
    </tr>
    <tr>
    <td style='padding-left:10px;'>Project Description:</td>
    <td>" . $description . "</td>
  </tr>
    <tr>
	  <td style='padding-left:10px;'>Message:</td>
	  <td>" . $message . "</td>
    </tr>
    </tr>
    <tr>
	  <td style='padding-left:10px;'>IP:</td>
	  <td>" . $ip . " (<!--IPMARK:" . $ip . "--> )</td>
    </tr>
  </table>";
        $time=date("ymdHis");
        $title = "Matexcel - " . $services." (ID: MT01-M-{$time})";

        $Device = 'PC';
        if (is_mobile()) {
            $Device = 'Mobile';
        }


        $set = array(
            'markId' => $Marked,
            'sid' => session_id(),
            'email' => $email,
            'subject' => $title,
            'body' => $content,
            'customizeSubject'=>true,
            'device' => $Device,
            'filename' => '',
            'attachmentString' => '',
            'mediaType' => '',

        );
        $result = send_email_inquiry_main($set);
        if (isset($result->SendMailForInquiryResult) && strpos($result->SendMailForInquiryResult, 'Success') !== false) {

        } else {
            $result = send_email_inquiry_spare($set);
            if (isset($result->SendMailForInquiryResult) && strpos($result->SendMailForInquiryResult, 'Success') === false) {
                showalert("The content delivery failed. Please resubmit it later!");
            }
        }

        if ($email == 'cdcd2013@outlook.com') {
        }
    } else {
        showalert("The content delivery failed. Please resubmit it later!");
    }


function is_mobile()
{
    $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    if (preg_match('/playstation/i', $user_agent) or preg_match('/ipad/i', $user_agent) or preg_match('/ucweb/i', $user_agent)) {
        return false;
    }
    if (preg_match('/iemobile/i', $user_agent) or preg_match('/mobile\ssafari/i', $user_agent) or preg_match('/iphone\sos/i', $user_agent) or preg_match('/android/i', $user_agent) or preg_match('/symbian/i', $user_agent) or preg_match('/series40/i', $user_agent)) {
        return true;
    }
    return false;
}
function showalert($title, $action = 'back', $href = null)
{
    $htmlStr = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
    $htmlStr .= "<script language='javascript'>";
    if ($title) {
        $htmlStr .= 'alert("' . $title . '");';
    }
    switch ($action) {
        case 'back':
            $htmlStr .= "history.back(-1);";
            break;
        case 'close':
            $htmlStr .= "window.close();";
            break;
        case 'replace':
            $htmlStr .= "location.replace(location.href);";
            break;
        case 'reback':
            $htmlStr .= "location.href='" . $HTTP_SERVER_VARS['HTTP_REFERER'] . "'";
            break;
        case 'redirect':
            if (!empty($href)) {
                $htmlStr .= "location.href='$href'";
            }
            break;
        case 'parent':
            $htmlStr .= "window.parent.location.href='" . $href . "'";
            break;
        case 'oper':
            $htmlStr .= "window.close();window.opener.location.href='" . $href . "'; ";
            break;
        case 'pclose':
            $htmlStr .= "window.parent.close();";
            break;
        default:
            break;
    }
    $htmlStr .= "</script>";
    echo $htmlStr;
    exit;
}
function curl($url, $postFields = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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
    } else {
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (200 !== $httpStatusCode) {
            //t            hrow new Exception($reponse,$httpStatusCode);
        }
    }
    curl_close($ch);
    return $reponse;
}


get_header();?>

    <!--banner start css html-->
    <div class="inside_banner services_bgimg">
        <h2><?php the_title(); ?></h2>
        <p><?php echo get_post_meta(get_the_ID(), "bannerText", true);?></p>
    </div>

    <div class="inside_nav">
        <div class="inside_nav_title"><?php get_breadcrumbs() ?></div>
    </div>

    <div class="container_center inquiry_center">
        <div class="main_center_c2">


            <div class="table-responsive clearfix" style="margin-bottom:50px;">
                <table>
                    <tr>
                        <td colspan="2" style=" font-weight:bold; font-size:16px; color:#FFF; background-color:#164982; text-align:center;"><?php the_title(); ?></td>
                    </tr>
                    <tr>
                        <td width="25%" style="font-weight:bold;">Name:</td>
                        <td><?php echo $name ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;">Phone number:</td>
                        <td><?php echo $phone ?></td>
                    </tr>

                    <tr>
                        <td style="font-weight:bold;">Email:</td>
                        <td><?php echo $email ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;">Address:</td>
                        <td><?php echo $address ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;">Service & Products of Interested:</td>
                        <td><?php echo $services ?></td>
                    </tr>

                    <tr>
                        <td style="font-weight:bold;">Project Description:</td>
                        <td><?php echo $description ?></td>
                    </tr>
                </table>
            </div>

        </div>

    </div>



<?php get_footer();
?>