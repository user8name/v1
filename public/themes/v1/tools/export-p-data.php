<?php
/**
 * Created by PhpStorm.
 * User: lirenjun
 * Date: 2019/10/14
 * Time: 11:43
 * 导出站点中产品以及产品相关url
 */
exit();
set_time_limit(0);
ini_set('memory_limit', '512M');
$headerArr = [
    'Cat.No.',
    'Category',
    'URL',
    'Product Name',
    'Common Name',
    'Synonyms',
    'CAS Number',
    'Morphology & Appearance',
    'Surface coverage',
    'APS',
    'SSA',
    'Sphericity',
    'Purity',
    'Zeta Potential',
    'conductivity',
    'Density',
    'Vickers Hardness',
    '(inherent) viscosity',
    'Floating Rate',
    'transition temp',
    'Melting Point',
    'melt index',
    'optical activity',
    'molecular weight g/mol',
    'refractive index',
    'pH',
    'Components',
    'impurities',
    'Source',
    'absorption',
    'InChI Key',
    'assay',
    'bp',
    'Mw/Mn',
    'solubility',
    'PDI',
    'Quality',
    'grade',
    'Stability',
    'Storage',
    'Storage Buffer',
    'Concentration',
    'Reconstitution',
    'Shipping & Packaging',
    'Application',
    'Usage',
    'Warning',
    'Description',
    'References',
    'Images',
];
$exprot_data=[];


$select="SELECT id,cid,cat,productname,jsontxt FROM wp_products LEFT JOIN wp_products_json ON wp_products.id=wp_products_json.productid WHERE wp_products.isdel=0";
global $wpdb;
$data=$wpdb->get_results($select);
foreach ($data as $k=>$v){
    $one_data=[];
    $jsontxt=json_decode($v->jsontxt,true);
    foreach ($headerArr as $k1=>$v1){
        if ($v1=='Cat.No.'){
            $one_data[$v1]=$v->cat;
        }elseif($v1=='Category'){
            $cat = get_category($v->cid);
            $one_data['Category']=$cat->cat_name;
        }elseif($v1=='URL'){
            $url = home_url().'/p/' . $v->id . '/' . sanitize_title(preg_replace( '/[^A-Za-z0-9\s\-]/', '-',$v->productname)) . '/';
            $one_data[$v1]=$url;
        }else{
            $one_data[$v1]=$jsontxt[$v1];
        }
    }
    $exprot_data[]=$one_data;
}


exportExcel($headerArr,$exprot_data);
function exportExcel($headerArr,$exprot_data)
{
    // 引入类库

//    include('./tools/');  //引入PHP EXCEL类
    require get_template_directory() . '/tools/PHPExcel.php';

    // 文件名和文件类型
    $fileName = "Matexcel-".date('Y-m-d',time());
    $fileType = "xlsx";

    // 模拟获取数据
    $data = $exprot_data;

    $obj = new \PHPExcel();

    // 以下内容是excel文件的信息描述信息
    $obj->getProperties()->setCreator(''); //设置创建者
    $obj->getProperties()->setLastModifiedBy(''); //设置修改者
    $obj->getProperties()->setTitle(''); //设置标题
    $obj->getProperties()->setSubject(''); //设置主题
    $obj->getProperties()->setDescription(''); //设置描述
    $obj->getProperties()->setKeywords('');//设置关键词
    $obj->getProperties()->setCategory('');//设置类型

    // 设置当前sheet
    $obj->setActiveSheetIndex(0);

    // 设置当前sheet的名称
    $obj->getActiveSheet()->setTitle('Matexcel');

    // 列标
    $list = [
        'A', 'B', 'C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
        'AA', 'AB', 'AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX'
    ];

    // 填充第一行数据
    $obb=$obj->getActiveSheet();

    foreach ($headerArr as $k=>$v){
        $obb->setCellValue($list[$k] . '1', $v);
    }

    // 填充第n(n>=2, n∈N*)行数据
    $length = count($data);

    for ($i = 0; $i < $length; $i++) {
        $index=0;
        foreach ($data[$i] as $kk=>$vv){
            $obj->getActiveSheet()->setCellValue($list[$index] . ($i + 2), $vv, \PHPExcel_Cell_DataType::TYPE_STRING);//将其设置为文本格式
            $index++;
        }
    }

    // 设置加粗和左对齐
    foreach ($list as $col) {
        // 设置第一行加粗
        $obj->getActiveSheet()->getStyle($col . '1')->getFont()->setBold(true);
        // 设置第1-n行，左对齐
        for ($i = 1; $i <= $length + 1; $i++) {
            $obj->getActiveSheet()->getStyle($col . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        }
    }

    // 设置列宽
    $obj->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    $obj->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $obj->getActiveSheet()->getColumnDimension('C')->setWidth(15);

    // 导出
    ob_clean();
    if ($fileType == 'xls') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xls');
        header('Cache-Control: max-age=1');
        $objWriter = new \PHPExcel_Writer_Excel5($obj);
        $objWriter->save('php://output');
        exit;
    } elseif ($fileType == 'xlsx') {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx');
        header('Cache-Control: max-age=1');
        $objWriter = \PHPExcel_IOFactory::createWriter($obj, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}
