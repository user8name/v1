<?php
/*
Plugin Name: v1 stats
Plugin URI:
Description: v1 stats 
Version: 1.0
Author: zeke su
Author URI:
License: GPLv2 or later
 */
global $_v1stats;

if (!class_exists('v1stats')) {
    class v1stats
    {
        public $_version = '1.0.0';

        public function v1stats()
        {

        }

        public function add_actions()
        {
            add_action('admin_bar_menu', array(&$this, 'custom_toolbar_link'), 999);
            add_filter('rewrite_rules_array', array(&$this, 'add_rewrite_rules'));
            add_filter('query_vars', array(&$this, 'add_query_vars_filter'));
            add_action("template_redirect", array(&$this, 'add_template_redirect'));
        }

        public function add_rewrite_rules($aRules)
        {

            $aNewRules = array(
                '^v1stats/?$' => 'index.php?v1stats=ok'
            );
            $aRules = $aNewRules + $aRules;
            return $aRules;
        }

        public function add_query_vars_filter($vars)
        {
            $vars[] = "v1stats";
            return $vars;
        }

        public function add_template_redirect()
        {
            $v1stats = get_query_var('v1stats');
            if ($v1stats == 'ok') {
                require 'stats.php';
                die;
            }
        }

        public function custom_toolbar_link($wp_admin_bar)
        {
            $args = array(
                'id' => 'v1stats',
                'title' => 'Stats',
                'href' => '/v1stats/?q=stats',
                'meta' => array(
                    'class' => 'v1stats',
                    'title' => 'Stats',
                    'target' => '_blank',
                ),
            );
            $wp_admin_bar->add_node($args);
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

if (class_exists('v1stats')) {
    $_v1stats = new v1stats();

    register_activation_hook(__FILE__, array(&$_v1stats, 'activation'));
    register_deactivation_hook(__FILE__, array(&$_v1stats, 'deactivation'));

    //加载filter
    $_v1stats->add_actions();

}
