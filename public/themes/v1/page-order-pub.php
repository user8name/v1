<?php
/**
 * Template Name: Order Pub
 */

$act = trim($_REQUEST['act']);
$email = "";

$extend = "";
if (is_main_domain()) {
} else {
    $extend = "[external]";
}
$typeid	=trim($_REQUEST['typeid'])+0;
	
if ($typeid !=1 AND $typeid !=2)
{
    showalert("data wrong！");
}

$name	=stripslashes(trim($_REQUEST['name1']));
$organization	=stripslashes(trim($_REQUEST['organization']));
$email		=stripslashes(trim($_REQUEST['email']));
$phone		=stripslashes(trim($_REQUEST['phone']));
$shipping		=stripslashes(trim($_REQUEST['shipping']));

$filename=$mediaType=$attachment='';
if ($act == "send") {
    $Marked = CustomConfig::TSMARKED;
    if($extend==''){
        $Marked = CustomConfig::MSMARKED;
    }

    $code=isset($_REQUEST['g-recaptcha-response'])?$_REQUEST['g-recaptcha-response']:'';
    $resps=post_data('https://www.recaptcha.net/recaptcha/api/siteverify',['secret'=>CustomConfig::RECAPTCHASERVERS,'response'=>$code]);
    $resp=json_decode($resps,true);
    if (isset($resp['success']) && $resp['success']==true){
    }else{
        showalert("verification failed!");
    }
    $ip = get_ip();

    if ($typeid == 1)
	{
		//上传文件
		//filename=string&mediaType=string&attachment=string&attachment=string

		if ($_FILES ['myfile'] != "none" && $_FILES ['myfile']['name'] != "" && isset($_FILES ['myfile'] ['size']) && $_FILES ['myfile'] ['size']!=0)
		{  
			$time_limit = 60;  
			set_time_limit ( $time_limit );  
			$mediaType = $_FILES ['myfile'] ['type'];  
			$filename = $_FILES ['myfile'] ['name'];  
			$file_size = $_FILES ['myfile'] ['size'];  
			$fp = fopen ( $_FILES ['myfile'] ['tmp_name'], "rb" );  
			//$attachment = addslashes ( fread ( $fp, filesize($_FILES ['myfile'] ['tmp_name']) ) );  
			$attachment = fread ( $fp, $file_size);  
			fclose ( $fp );  

			//file_put_contents("a.pdf",$attachment);
			//exit;
			//$mediaType=".".strtolower(trim(substr(strrchr($filename, '.'), 1)));
		}else
		{
			showalert("please upload file！");
		}
	}
	else
	{
		$shippingaddress	=stripslashes(trim($_REQUEST['shippingaddress']));
        $fedexshipping	=stripslashes(trim($_REQUEST['fedexshipping']));
		$billingaddress	=stripslashes(trim($_REQUEST['billingaddress']));
		$specialrequirement=stripslashes(trim($_REQUEST['specialrequirement']));
		
		$quotenumber=stripslashes(trim($_REQUEST['quotenumber']));
		$catalognumber=stripslashes(trim($_REQUEST['catalognumber']));
		$quantitytoorder=stripslashes(trim($_REQUEST['quantitytoorder']));

		$cardtype	=stripslashes(trim($_REQUEST['cardtype']));
		$cardnumber	=stripslashes(trim($_REQUEST['cardnumber']));
		$expirydate=stripslashes(trim($_REQUEST['expirydate']));
		$nameoncard=stripslashes(trim($_REQUEST['nameoncard']));
		$cvv=stripslashes(trim($_REQUEST['cvv']));
    }
    
    $content="<table width='100%' align='center' border='0' id='table1'>
		<tr bgcolor='#2C4D90'>
			<td colSpan='2' bgcolor='#E0EDE0'>&nbsp;&nbsp;<font face='Verdana' style='font-size: 11pt; font-weight: 700'>Contact Information</font></td>
		</tr>
		<tr><td align='left' width='157'>Name:</td><td align='left'><b>".$name."</b></td></tr>
		<tr><td align='left' width='157'>Organization:</td><td align='left'><b>".$organization."</b></td></tr>
		<tr><td align='left' width='157'>Email:</td><td align='left'><b>".$email."</b></td></tr>
        <tr><td align='left' width='157'>Phone:</td><td align='left'><b>".$phone."</b></td></tr>";

    if ($typeid ==1 )
    {
        $content.= "<tr><td align='left' width='157'>Fedex/UPS/DHL Account for Shipping:</td><td align='left'><b>".$shipping."</b></td></tr>";
    }

        if ($typeid ==2 )
	{	

		$content1=$content."
		<tr><td align='left' width='157'>Shipping Address:</td><td align='left'><b>".$shippingaddress."</b></td></tr>
		<tr><td align='left' width='157'>Fedex/UPS/DHL Account for Shipping:</td><td align='left'><b>".$fedexshipping."</b></td></tr>
		<tr><td align='left' width='157'>Billing Address:</td><td align='left'><b>".$billingaddress."</b></td></tr>
		<tr><td align='left' width='157'>Other inquiries:</td><td align='left'><b>".$specialrequirement."</b></td></tr>
		<tr bgcolor='#2C4D90'>
			<td colSpan='2' bgcolor='#E0EDE0'>&nbsp;&nbsp;<font face='Verdana' style='font-size: 11pt; font-weight: 700'>Product Information</font></td>
		</tr>
		<tr><td align='left' width='157'>Quote Number:</td><td align='left'><b>".$quotenumber."</b></td></tr>
		<tr><td align='left' width='157'>Catalog Number(s):</td><td align='left'><b>".$catalognumber."</b></td></tr>
		<tr><td align='left' width='157'>Quantity:</td><td align='left'><b>".$quantitytoorder."</b></td></tr></table><br>";

        $content.="
		<tr><td align='left' width='157'>Shipping Address:</td><td align='left'><b>".$shippingaddress."</b></td></tr>
		<tr><td align='left' width='157'>Fedex/UPS/DHL Account for Shipping:</td><td align='left'><b>".$fedexshipping."</b></td></tr>
		<tr><td align='left' width='157'>Billing Address:</td><td align='left'><b>".$billingaddress."</b></td></tr>
		<tr><td align='left' width='157'>Other inquiries:</td><td align='left'><b>".$specialrequirement."</b></td></tr>
		<tr bgcolor='#2C4D90'>
			<td colSpan='2' bgcolor='#E0EDE0'>&nbsp;&nbsp;<font face='Verdana' style='font-size: 11pt; font-weight: 700'>Product Information</font></td>
		</tr>
		<tr><td align='left' width='157'>Quote Number:</td><td align='left'><b>".$quotenumber."</b></td></tr>
		<tr><td align='left' width='157'>Catalog Number(s):</td><td align='left'><b>".$catalognumber."</b></td></tr>
		<tr><td align='left' width='157'>Quantity:</td><td align='left'><b>".$quantitytoorder."</b></td></tr>
		<tr bgcolor='#2C4D90'>
			<td colSpan='2' bgcolor='#E0EDE0'>&nbsp;&nbsp;<font face='Verdana' style='font-size: 11pt; font-weight: 700'>Card Information </font></td>
		</tr>
		<tr><td align='left' width='157'>Card Type:</td><td align='left'><b>".$cardtype."</b></td></tr>
		<tr><td align='left' width='157'>Card Number:</td><td align='left'><b>".$cardnumber."</b></td></tr>
		<tr><td align='left' width='157'>Expiration Date:</td><td align='left'><b>".$expirydate."</b></td></tr>
		<tr><td align='left' width='157'>Name on Card:</td><td align='left'><b>".$nameoncard."</b></td></tr>";
	}else{
            $content1 = $content."</table>";
    }



	
	if ($typeid ==2 )
	{	
		$content.="<tr><td align='left' width='157'> CVV:</td><td align='left'><b>".$cvv."</b></td></tr>";
	}
	$content.="<tr><td align='left' width='157'>IP:</td><td align='left'><b>".$ip." (<!--IPMARK:".$ip."--> )</b></td></tr></table>";
	
	$title = "";
	$Device = 'PC';
	if (is_mobile())
	{

		$Device = 'Mobile';
	}
	
    $set = array(
        'markId' => $Marked,
        'sid' => session_id(),
        'email' => $email,
        'subject' => $title." Order Information",
        'body' => $content,
        'device'=>$Device,
        'filename'=>$filename,
        'attachmentString'=>base64_encode($attachment),
        'mediaType'=>$mediaType,

    );
    $result = send_email_inquiry_main($set);
    if (isset($result->SendMailForInquiryResult) && strpos($result->SendMailForInquiryResult,'Success')!==false) {

    }else{
        $result=send_email_inquiry_spare($set);
        if (isset($result->SendMailForInquiryResult) && strpos($result->SendMailForInquiryResult,'Success')===false) {
            showalert("The content delivery failed. Please resubmit it later!");
        }
    }
    
    if ($email == 'cdcd2013@outlook.com') {
    }
}else{
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
		<div class="inquiry_title">Orders submitted successfully, thank you!</div>
		<div class="main_center_c2">

			<div class="inside_left">
				<?php echo $content1;?>

			</div>

			<div class="inside_right">
				<h2>Contact Us</h2>
				                    <p>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/tel-1.png"><img src="<?php echo get_template_directory_uri() ;?>/nosvg/tel-black.svg" height="22" style="padding: 15px 0 0 0;">
                    </p>
                    <p>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/fax-1.png"><img src="<?php echo get_template_directory_uri() ;?>/nosvg/fax-black.svg" height="22" style="padding: 15px 0 0 0;">
                    </p>
				<p>Address: <img src="<?php echo get_template_directory_uri() ;?>/nosvg/n_add2.svg" height="44" style="padding: 15px 0 0 0;"></p>
				<p>Email:
        <a href="mailto:info@<?php echo do_shortcode('[v1_get_domain]'); ?>">info@<?php echo do_shortcode('[v1_get_domain]'); ?></a>
				</p>
			</div>
		</div>

	</div>



<?php get_footer();
?>