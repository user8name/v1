<?php
$q='';
if(isset($_GET['q'])) {  
    $q=$_GET['q'];
}

global $wpdb;

$product = $wpdb->get_row($wpdb->prepare('SELECT `id`,`cid`,`cat`,`productname`,`description`,`seo_title`,`seo_keywords`,`seo_description`,`seo_url`,`detail` FROM `wp_products` INNER JOIN `wp_products_json` ON `wp_products`.`id`= `wp_products_json`.`productid` WHERE `id`=%d',$q));
//$imgs = $wpdb->get_results($wpdb->prepare('SELECT `imgid`,`productid`,`imgfile` FROM `wp_products_img` WHERE `productid`=%d',$q));
//var_dump($product);
//die;
require 'fpdf/tfpdf.php';
class PDF extends tFPDF
{
    public function Header()
    {
        $domain=$_SERVER['SERVER_NAME'];
        if(preg_match('/matexcel\.com/i', $domain)){
            $domain = 'matexcel.com      ';
        }else{
            $domain = 'material-cell.com';
        }
        $options = get_option( 'v1_theme_options' );
        $this->Image(WP_CONTENT_DIR.'/plugins/v1-products/images/top1.jpg', 0, 0,210,60);
        $this->Image(WP_CONTENT_DIR.'/plugins/v1-products/images/Matexcel_logo-01-01.png', 15, 25,65);

        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(0, 0, 0);
        $this->Ln(10);
        $this->Ln(4);
        $this->Image(WP_CONTENT_DIR.'/plugins/v1-products/images/add.png', 135, 25,2.5);
        $this->MultiCell(179, 5, 'SUITE 210, 17 Ramsey Road, Shirley,', 0, 0, false);
        $this->MultiCell(144, 5, ' NY 11967', 0, 0, false);
        $this->Image(WP_CONTENT_DIR.'/plugins/v1-products/images/tel.png', 135, 35,2.5);
        $this->Cell(157, 5, ' Tell: '.$options['usatel1'], 0, 0, 'R');
        $this->Ln(6);
        $this->Image(WP_CONTENT_DIR.'/plugins/v1-products/images/email.png', 135, 42,2.5);
        $this->Cell(170, 5, 'E-mail: info@' . $domain, 0, 0, 'R');
        $this->Ln(30);



    }

    //Pie de página
    public function Footer()
    {


        $domain=$_SERVER['SERVER_NAME'];
        if(preg_match('/matexcel\.com/i', $domain)){
            $domain = 'matexcel.com';
        }else{
            $domain = 'material-cell.com';
        }
        $options = get_option( 'v1_theme_options' );

        $this->SetY(-28);
        $this->Image(WP_CONTENT_DIR.'/plugins/v1-products/images/bottom1.png', 0, 220,210,80);
        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(31, 73, 125);
        $this->Ln(3);
        $this->Cell(0, 10, 'Matexcel. All rights reserved.', 0, 0, 'R');
        $this->SetTextColor(0, 0, 0);
        $this->Ln(5);
        $this->Cell(0, 10, 'SUITE 210, 17 Ramsey Road, Shirley, NY 11967', 0, 0, 'R');
        $this->Ln(5);


        $this->Cell(0, 10, 'http://www.' . $domain, 0, 0, 'R', 0, 'http://www.' . $domain);

    }
}

//Creación del objeto de la clase heredada
$pdf = new PDF('p', 'mm', 'A4');
//$pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
$pdf->AddFont('MYRIADPRO-REGULAR', '', 'MYRIADPRO-REGULAR.ttf', true);
$pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
$pdf->AddFont('DejaVuBI', '', 'DejaVuSansCondensed-BoldOblique.ttf', true);
$pdf->AddFont('DejaVuI', '', 'DejaVuSansCondensed-Oblique.ttf', true);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->InFooter=false;
$pdf->SetAutoPageBreak(1,65); //底部
$pdf->SetFont('Times', '', 12);
$pdf->bMargin=200;

//title
$pdf->setX(14);
$pdf->SetFillColor(191,191,191);
$pdf->MultiCell(180, 0.2, '', 0, 'L',true);
$pdf->SetFillColor(200);
$pdf->Ln(2);
$pdf->setX(14);
$pdf->SetFont('DejaVu', '', 18);
$pdf->MultiCell(180, 8, $product->productname, 0, 'L');
$pdf->Ln(2);
$pdf->setX(14);
$pdf->MultiCell(180, 0.2, '', 0, 'L',true);
$pdf->Ln(2);
$pdf->SetFont('Times', 'B', 12);
$pdf->setX(14);
$pdf->Cell(50, 7, 'Cat. No. ', 0, 0);
$pdf->SetFont('Times', '', 10);
$pdf->MultiCell(130, 7, $product->cat, 0, 1);
$pdf->Ln(2);
$pdf->setX(14);
$pdf->MultiCell(180, 0.2, '', 0, 'L',true);
$pdf->Ln(2);
$pdf->SetFont('Times', 'B', 12);
$pdf->setX(14);
$pdf->Cell(50, 7, 'Lot. No.', 0, 0);
$pdf->SetFont('Times', '', 10);

$pdf->MultiCell(130, 7, "(See product label)", 0, 1);
$pdf->Ln(5);

$pdf->setX(14);
$pdf->SetFillColor(31,92,152);
$pdf->SetFont('Times', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(180, 10, 'PRODUCT INFORMATION', 0, 1, 'L', 1);
$pdf->Ln(2);
$pdf->SetTextColor(0, 0, 0);
$js = json_decode($product->detail);

$count = 0;
foreach ($js as $key => $value) {
    $pdf->setX(14);
    if($key=='Cat.No.' || $key=='cid'  || strtolower($key)=='common name'  || strtolower($key)=='urltext' || strtolower($key)=='cas number' || strtolower($key)=='keywords')continue;
        $width = 55;
        $width2=125;
        if (strlen($key) > 20) {
            $width = 55;
            $width2=125;
        }

        $pdf->SetFont('Times', 'B', 12);
        $pdf->cell($width, 7, $key, 0, 'L',false);

        //$pdf->SetFont('Times','',12);
        $pdf->SetFont('DejaVu', '', 10);
        if (strtolower($key)=='images'){
            $img=get_template_directory().'/products-img/'.$value.'.jpg';
            if (file_exists($img)) {
                $pdf->Image($img,null,null,0,40);
            }else{
                $img=get_template_directory().'/products-img/'.$value.'.png';
                if (file_exists($img)) {

                    $pdf->Image($img,null,null,0,40);
                } else {
                    $pdf->MultiCell(180, 7, $value, 0, 'L');
                }
            }

        }else{
            $pdf->MultiCell($width2, 7, $value, 0, 'L');
        }


        $count++;

        if ($count > 18) {
            $pdf->AddPage();
            $count = 0;
        }
    $pdf->Ln(2);
    $pdf->setX(14);
    $pdf->MultiCell(180, 0.2, '', 0, 'L',true);
    $pdf->Ln(2);

}



$ProductName =sanitize_title($product->productname);

$name = $ProductName . ".pdf";
//$pdf->Output($name,'I');
$pdf->Output($name, 'I');