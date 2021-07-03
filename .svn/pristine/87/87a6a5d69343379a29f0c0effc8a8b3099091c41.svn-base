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
    'Product Name',
    'URL',
    'Description',
    'Species',
    'Source',
    'Tag'
];
$exprot_data=[];


$select="SELECT id,cid,cat,productname,description,`detail` FROM  `".$wpdb->prefix."products`  WHERE isdel=0 and cid in(20,61,55,64,59,60,58,63,52,57,56,51,54,53,62)";

global $wpdb;
$data=$wpdb->get_results($select);


foreach ($data as $k=>$v){
    $one_data=[];
    $one_data['Cat.No.']=$v->cat;
    $one_data['Product Name']=$v->productname;
    $url = 'https://www.matexcel.com/p/' . $v->id . '/' . sanitize_title(preg_replace( '/[^A-Za-z0-9\s\-]/', '-',$v->productname)) . '/';
    $one_data['URL']=$url;
    $one_data['Description']=$v->description;
    $one_data['Species']='';
    $one_data['Source']='';
    $one_data['Tag']='';
    $js = json_decode($v->detail, true);
    if ($js['Species']){
        $one_data['Species']=$js['Species'];
    }
    if ($js['Source']){
        $one_data['Source']=$js['Source'];
    }
    if ($js['Tag']){
        $one_data['Source']=$js['Source'];
    }
    $exprot_data[$v->cid][]=$one_data;
}


exportExcel($headerArr,$exprot_data);
function exportExcel($headerArr,$exprot_data)
{
    // 引入类库

//    include('./tools/');  //引入PHP EXCEL类
    require get_template_directory() . '/tools/PHPExcel.php';

    // 文件名和文件类型
    $fileName = "matexcel-".date('Y-m-d',time());
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

    $ii=0;
    foreach ($data as $key=>$value){
        // 设置当前sheet
        $obj->createSheet();
        $obj->setActiveSheetIndex($ii);
        $cat = get_category($key);
        if (!$cat){
            $cat_name='sheet'.$key;
        }else{
            $cat_name=substr($cat->cat_name,20).$key;
        }

        // 设置当前sheet的名称
        $obj->getActiveSheet()->setTitle($cat_name);
        // 列标
        $list = [
            'A', 'B', 'C','D','E','F','G'
        ];

        // 填充第一行数据
        $obb=$obj->getActiveSheet();

        foreach ($headerArr as $k=>$v){
            $obb->setCellValue($list[$k] . '1', $v);
        }

        // 填充第n(n>=2, n∈N*)行数据
        $length = count($value);

        for ($i = 0; $i < $length; $i++) {
            $index=0;
            foreach ($value[$i] as $kk=>$vv){
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
        $ii++;
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
