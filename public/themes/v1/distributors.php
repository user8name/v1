<?php
/**
 * Template Name: Distributors
 */


$state = $_GET['state'];
if (!$state) $state = "Argentina";
$state=esc_attr($state);
global $wpdb;



$list = $wpdb->get_results($wpdb->prepare('SELECT state,nationalflag FROM `'.$wpdb->prefix.'company` WHERE  `status`=%d GROUP BY state ORDER BY state ' , [0]));
$states = array();
foreach($list as $k => $v)
{
    $states[$v->state] = $v->nationalflag;
}
$rows = $wpdb->get_results($wpdb->prepare('SELECT * FROM `'.$wpdb->prefix.'company` WHERE `state`=%s and `status`=%d order by id ' , [$state,0]));

get_header();
?>
   <link rel="stylesheet" href='<?php echo v1_get_template_directory_uri(); ?>/css/bootstrap.css'>
   <style>
	   .form-group{height: 30px;}
	   .row{height: auto; overflow: hidden;}
	   .disul li{list-style-type: none;}
	   .disul{margin-left: 0; padding-left: 0;}
	   .row {
  margin-right: -20px;
  margin-left: -20px;
}
	   a{color: #164982; text-decoration: none;}
</style>
    <!--banner start css html-->
    <div class="inside_banner about_bgimg">
        <h2><?php the_title(); ?></h2>
        <p><?php echo get_post_meta(get_the_ID(), "bannerText", true);?></p>
    </div>

    <div class="inside_nav">
        <div class="inside_nav_title"><?php get_breadcrumbs() ?></div>
    </div>

    <div class="container_center">
       <div class="main_center_c2" style="margin: 30px auto;">
        <div class="row">
            <div class="col-md-4"><img src="<?php echo get_template_directory_uri();?>/images/aboutus-pic-2.jpg" style="max-width: 100%;"></div>
            <div class="col-md-7">
                <p>To view the contact information for a specific location, select your country or region:</p>
                <form method="get">
                    <p>
                        <select size="1" name="D1" id="sltSelector" class="form-group" onchange="javascript:window.location=this.options[this.selectedIndex].value;">
                            <?php foreach ($list as $k=>$v):?>
                                <option  value="<?php echo get_permalink(get_the_ID());?>?state=<?php echo $v->state;?>" <?php if ($v->state==$state):?>selected<?php endif;?>><?php echo $v->state;?></option>
                            <?php endforeach;?>
                        </select>
                    </p>
                </form>

                <div class="row" style="margin: 15px 0 10px 0">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding: 0">
                        <h2 style="margin: 5px 0"><?php echo $state?></h2>
                    </div>
                    <?php if ($states[$state]):?>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="padding: 0">
                            <img src="<?php echo get_template_directory_uri();?>/images/company/<?php echo $states[$state];?>" width="190" height="108" style="padding:5px;background:#f9f9f9">
                        </div>
                    <?php endif;?>

                </div>
                <?php foreach ($rows as $key=>$value):?>
                    <div class="row" style="padding: 20px 0; border-bottom: 1px #e1edf7 solid">

                            <div class="col-lg-3 col-md-4 col-sm-12 col-sm-12">
                                <ul class="disul">
                                    <li><?php echo $value->company?></li>
                                    <?php if ($value->logo):?>
                                    <li><img src="<?php echo get_template_directory_uri();?>/images/company/<?php echo $value->logo;?>" style="width: 120px; height: 40px; margin-top: 10px;" alt="<?php echo $value->company?>"></li>
                                    <?php endif;?>

                                </ul>
                            </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-sm-12">
                            <ul class="disul">
                                <?php if ($value->address1):?>
                                    <li><?php echo $value->address1;?></li>
                                <?php endif;?>
                                <?php if ($value->address2):?>
                                <li><?php echo $value->address2;?></li>
                                <?php endif;?>
                                <?php if ($value->address3):?>
                                <li><?php echo $value->address3;?></li>
                                <?php endif;?>
                                <?php if ($value->address4):?>
                                <li><?php echo $value->address4;?></li>
                                <?php endif;?>
                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-sm-12">
                            <ul class="disul">
                                <?php if ($value->phone):?>
                                    <li>Phone: <?php echo $value->phone;?></li>
                                <?php endif;?>
                                <?php if ($value->fax):?>
                                <li>Fax: <?php echo $value->fax;?></li>
                                <?php endif;?>
                                <?php if ($value->email):?>
                                <li> Email: <a href='mailto:<?php echo $value->email;?>'><?php echo $value->email;?></a></li>
                                <?php endif;?>
                                <?php if ($value->website):?>
                                <li>Website: <a href='http://<?php echo $value->website;?>'>http://<?php echo $value->website;?></a> </li>
                                <?php endif;?>
                            </ul>
                        </div>


                    </div>
                <?php endforeach;?>

            </div>
        </div>

        <div>


        </div>

    </div>
</div>




<?php get_footer();?>