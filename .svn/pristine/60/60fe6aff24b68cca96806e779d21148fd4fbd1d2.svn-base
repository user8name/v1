<?php
/*
Plugin Name: v1 products
Plugin URI:
Description: v1 products
Version: 1.0
Author: Zeke Su
Author URI:
License: GPLv2 or later
 */
global $v1_products;

//register_theme_directory(WP_CONTENT_DIR . '/themes');

if (!class_exists('v1products')) {
    class v1products
    {
        public $_version = '1.0.0';
        public $host = '';
        public $https = '';
        public $domain = 'matexcel.com';

        public function v1products()
        {
            $this->host = $_SERVER['HTTP_HOST'];
            $this->https = $_SERVER['HTTPS'];

        }

        public function add_actions()
        {
            /**
             * 在 ewcfg12.php 增加如下代码
             * require_once($_SERVER['DOCUMENT_ROOT'].'/wp-config.php');
             *
             *  if(!is_user_logged_in() || !current_user_can('level_10')){
             *      echo 'Please log in.';
             *      die();
             *  }
             *
             * 在index.php增加
             * header('location:/');
             * exit;
             */
            //add_filter( 'the_content',  array(&$this,'the_content' ));
            //add_action('admin_menu', array(&$this,'wporg_options_page'));

            add_action('admin_bar_menu', array(&$this, 'custom_toolbar_link'), 999);
            //add_action('init', array(&$this,'custom_rewrite_rule'), 10, 0);
            add_filter('query_vars', array(&$this, 'add_query_vars_filter'));
            add_filter('rewrite_rules_array', array(&$this, 'add_rewrite_rules'));
            add_action("template_redirect", array(&$this, 'add_template_redirect'));
            add_action("sm_buildmap", array(&$this, 'products_sitemap'));

        }

        public function add_template_redirect()
        {
            $pdf = get_query_var('pdf');
            if ($pdf == 'down') {
                require 'v1-pdf.php';
                die;
            }
        }

        public function add_rewrite_rules($aRules)
        {

            $aNewRules = array(
                'p/([^/]+)/(.*)$' => 'index.php?vpid=$matches[1]',
                '^pdf/?$' => 'index.php?pdf=down',
            );
            $aRules = $aNewRules + $aRules;
            return $aRules;
        }

        public function custom_rewrite_rule()
        {
            add_rewrite_rule('p/([^/]+)/(.*)$', 'index.php?vpid=$matches[1]', 'top');
        }

        public function add_query_vars_filter($vars)
        {
            $vars[] = "vpid";
            $vars[] = "pdf";
            //var_dump($vars);
            return $vars;
        }

        public function custom_toolbar_link($wp_admin_bar)
        {
            $args = array(
                'id' => 'v1products',
                'title' => 'Products Management',
                'href' => WP_CONTENT_URL.'/plugins/v1-products/wp_productslist.php',
                'meta' => array(
                    'class' => 'v1products',
                    'title' => 'Products Management',
                    'target' => '_blank',
                ),
            );
            $wp_admin_bar->add_node($args);

            $args = array(
                'id' => 'v1products-task',
                'title' => 'Products Batch Upload',
                'href' => WP_CONTENT_URL.'/plugins/v1-products/wp_products_taskslist.php',
                'meta' => array(
                    'class' => 'v1products',
                    'title' => 'Products Batch Upload',
                    'target' => '_blank',
                ),
                'parent' => 'v1products',
            );
            //$wp_admin_bar->add_node($args);

            $args = array(
                'id' => 'v1products-sync',
                'title' => 'Synchro Products Category',
                'href' => WP_CONTENT_URL.'/plugins/v1-products/wp_products_categorieslist.php',
                'meta' => array(
                    'class' => 'v1products',
                    'title' => 'Synchro Products Category',
                    'target' => '_blank',
                ),
                'parent' => 'v1products',
            );
            $wp_admin_bar->add_node($args);

        }

        public function the_content($content)
        {
            if (is_single()) {
                //$content =str_replace('www.domain.net',$this->host,$content);
            }

            return $content;
        }

        public function wporg_options_page()
        {
            add_menu_page(
                'WPOrg',
                'WPOrg Options',
                'manage_options',
                'wporg',
                array(&$this, 'wporg_options_page_html'),
                plugin_dir_url(__FILE__) . 'images/icon_wporg.png',
                20
            );
        }

        public function wporg_options_page_html()
        {
            // check user capabilities
            if (!current_user_can('manage_options')) {
                return;

            }

            //include_once(dirname( __FILE__ ).'/wp_productslist.php');
        }

        public function products_sitemap() {
            //$gsg = &GoogleSitemapGenerator::GetInstance();
            //if($gsg!=null) $gsg->AddUrl("http://blog.uri/tags/hello/",time(),"daily",0.5);
        }
       

        //激活时调用
        public function activation()
        {

        }
        //停用时调用
        public function deactivation()
        {

        }
    }
}

if (class_exists('v1products')) {
    $v1_products = new v1products();

    register_activation_hook(__FILE__, array(&$v1_products, 'activation'));
    register_deactivation_hook(__FILE__, array(&$v1_products, 'deactivation'));

    //加载filter
    $v1_products->add_actions();

}
