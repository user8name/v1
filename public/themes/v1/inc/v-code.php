<?php


/* 验证码函数
函数参数：
1 $num 验证码个数，
2 $type 字符类型，0为数字，1为数字+小写字母，2为数字+大小写字母
3 $height 图片高
4 $size 字体大小
5 $radian1 字体随机弧度起始位
6 $radian2 字体随机弧度结束位
7 $y 验证码垂直位置
*/
function image_check_code($num=4,$type=0,$height=30,$size=14,$radian1=-50,$radian2=50,$y=30){
    ob_clean();
//1、随机验证码 //$num 是多少个； $type 是类型，0为数字，1为数字+小写字母，2为数字+大小写字母
    $str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; //定义验证码可选范
    $arr=array(9,35,strlen($str)-1);
    $string="";
    for($i=0; $i<$num;$i++){
        $string.=$str[rand(0,$arr[$type])];
    }
//2、创建画布，即图片源，以及背景颜色和字体颜色
    $width=$num*($size+2);
    $im=imagecreatetruecolor($width,$height);
    $bg=imagecolorallocate($im,200,200,200);
    $color[]=imagecolorallocate($im,128,35,4);
    $color[]=imagecolorallocate($im,45,128,4);
    $color[]=imagecolorallocate($im,131,131,250);
    $color[]=imagecolorallocate($im,166,9,174);
    $color[]=imagecolorallocate($im,173,163,37);
    $color[]=imagecolorallocate($im,30,115,121);
    $color[]=imagecolorallocate($im,0,128,128);
    $color[]=imagecolorallocate($im,128,128,0);
    imagefill($im,0,0,$bg); //设置背景色
//3、创建干扰线
    for($i=1; $i<300; $i++){ //添加 点
        $line_color=imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255)); //随机色
        imagesetpixel($im,rand(0,$width),rand(0,$height),$line_color);
    }
    for($i=1; $i<30; $i++){ //添加 弧线
        $line_color=imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255)); //随机色
        imagearc($im,rand(0,$width),rand(0,$height),rand(0,$width),rand(0,$height),rand(0,100),rand(0,360),$line_color);
    }

//4、转换验证码 到图片
    for($i=0; $i<$num; $i++){
//imagettftext 参数1是图片源，2是字体大小，3是弧形度，4是水平位置，5是垂直位置，6是字颜色，7是字体，8是验证码字符串

        imagettftext($im,$size,rand($radian1,$radian2),6+($i*$size),$y-10,$color[rand(0,7)],get_template_directory()."/css/msyhbd.ttf",$string[$i]);
    }
    $_SESSION['validate_code']=$string;

//5、输出图片
    header('Content-Type: image/png');
    imagepng($im);
//释放资源内存
    imagedestroy($im);

}

image_check_code(4,2,60,36,-40,40,60);