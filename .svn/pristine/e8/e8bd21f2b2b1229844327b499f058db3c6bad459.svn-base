<?php
/**
 * Template Name: career-pub
 */
$act = trim($_REQUEST['act']);
$email = "";


if ($act == "send"){
    $firstname = stripslashes(trim($_REQUEST['firstname']));
    $lastname = stripslashes(trim($_REQUEST['lastname']));
    $phone = stripslashes(trim($_REQUEST['phone']));

    $email = stripslashes(trim($_REQUEST['email']));


    $code = isset($_REQUEST['g-recaptcha-response']) ? $_REQUEST['g-recaptcha-response'] : '';
    $resps = post_data('https://www.recaptcha.net/recaptcha/api/siteverify', ['secret' => CustomConfig::RECAPTCHASERVERS, 'response' => $code]);
    $resp = json_decode($resps, true);
    if (isset($resp['success']) && $resp['success'] == true) {
    } else {
        showalert("verification failed!");
    }

    $filename='';
    $attachment='';
    $mediaType='';
    if ($_FILES ['myfile'] != "none" && $_FILES ['myfile']['name'] != "" && isset($_FILES ['myfile'] ['size']) && $_FILES ['myfile'] ['size']!=0)
    {
        $time_limit = 60;
        set_time_limit ( $time_limit );
        $mediaType = $_FILES ['myfile'] ['type'];
        $filename = $_FILES ['myfile'] ['name'];
        $file_size = $_FILES ['myfile'] ['size'];
        $fp = fopen ( $_FILES ['myfile'] ['tmp_name'], "rb" );
        $attachment = fread ( $fp, $file_size);
        fclose ( $fp );
    }else
    {
        showalert("please upload file！");
    }
    $content = "<table cellpadding='0' width='100%' cellspacing='0' border='0' style='line-height:32px;  text-align:left;margin:auto;'>
	<tr><td colspan='2' style='background-color:#f5f5f5; padding-left:10px;'>Information</td></tr>
	<tr>
	  <td style='padding-left:10px;  width:200px'>First Name: </td>
	  <td>" . $firstname . "</td>
    </tr>
    <tr>
	  <td style='padding-left:10px;  width:200px'>Last Name: </td>
	  <td>" . $lastname . "</td>
    </tr>
    <tr>
    <td style='padding-left:10px;'>Email:</td>
    <td>" . $email . "</td>
    </tr>
    <tr>
	  <td style='padding-left:10px;'>Phone number:</td>
	  <td>" . $phone . "</td>
	</tr>
  </table>";
    $title ='[Career][ME]-'.$firstname.' '.$lastname.'- '.date('F j, Y',time());

    $to_email='contact@matexcel.com';
    if($email == 'cdcd2013@outlook.com' || $email=='test@it.abace-biology.com'){
        $to_email=$email;
    }

    $set = array(
        'from' => '',
        'to' => $to_email,
        'subject' => $title,
        'body' => $content,
        'smtpserver'=>'',
        'smtpport'=>'',
        'smtpusername'=>'',
        'smtppwd'=>'',
        'enableSsl'=>'false',
        'filename'=>$filename,
        'attachmentString'=>base64_encode($attachment),
        'mediaType'=>$mediaType,

    );



    $result = send_email_custom_main($set);

    if (isset($result->SendEmailResult) && strpos($result->SendEmailResult,'Success')!==false) {

    }else{
        $result=send_email_custom_spare($set);
        if (isset($result->SendEmailResult) && strpos($result->SendEmailResult,'Success')===false) {
            showalert("The content delivery failed. Please resubmit it later!");
        }
    }
}else {
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


get_header();?>


    <!--banner start css html-->
    <div class="inside_banner services_bgimg">
        <h2>Success!</h2>
        <p>Thank you for your submission.</p>
        <p>Your resume has been successfully sent to our HR.</p>
    </div>

    <div class="inside_nav">
        <div class="inside_nav_title"><?php get_breadcrumbs() ?></div>
    </div>

    <div class="container_center inquiry_center">
        <div class="main_center_c2">


            <div class="table-responsive clearfix" style="margin-bottom:50px;">
                <table>

                    <tr>
                        <td width="25%" style="font-weight:bold;">First Name:</td>
                        <td><?php echo $firstname ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;">Last Name:</td>
                        <td><?php echo $lastname ?></td>
                    </tr>

                    <tr>
                        <td style="font-weight:bold;">Email:</td>
                        <td><?php echo $email ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;">Phone number:</td>
                        <td><?php echo $phone ?></td>
                    </tr>

                </table>
            </div>

        </div>

    </div>



<?php get_footer();
?>