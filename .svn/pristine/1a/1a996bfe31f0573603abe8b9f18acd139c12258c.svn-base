<?php
require_once get_template_directory() . '/inc/custom-config.php';
require_once get_template_directory() . '/theme-options.php';
require_once get_template_directory() . '/theme-shortcode.php';
require_once get_template_directory() . '/theme-customfield.php';
require_once get_template_directory() . '/class-page.php';
require_once get_template_directory() . '/inc/disable-css-js.php';

function v1_setup()
{
    //add_theme_support('title-tag');
    register_nav_menus(array(
        'top' => __('Top Menu', 'v1'),
        //'product'   => __( 'Product Menu', 'v1' ),
        //'service'   => __( 'Service Menu', 'v1' )
    ));
    add_theme_support('post-formats', array('aside', 'gallery', 'link'));

}
add_action('after_setup_theme', 'v1_setup');

function rename_post_formats($safe_text)
{

    if ($safe_text == 'Aside') {
        return 'Product';
    }

    if ($safe_text == 'Gallery') {
        return 'Service';
    }

    if ($safe_text == 'Link') {
        return 'Application';
    }

    return $safe_text;

}
//add_filter('esc_html', 'rename_post_formats');

function v1_scripts()
{

    // Theme stylesheet.
//    wp_enqueue_style('v1-style', get_stylesheet_uri());
    wp_enqueue_style('v1-bootstrap', get_theme_file_uri('/css/bundle.min.css'), array(), '2.3');
    //wp_enqueue_style('v1-agriculture', get_theme_file_uri('/css/style.css'), array(), '2.1');
    //wp_enqueue_style('v1-validationEngine-jquery', get_theme_file_uri('/css/validationEngine.jquery.css'), array(), '1.0');


    // Load the script.
    wp_enqueue_script('v1-jquery', get_theme_file_uri('/js/bundle.min.js'), array(), '2.1');
	wp_enqueue_script('v1-base64', get_theme_file_uri('/nosvg/ajax/jquery.base64.js'), array(), '2.1');
	wp_enqueue_script('v1-xload', get_theme_file_uri('/nosvg/ajax/jquery.xload.js'), array(), '2.1');
    //wp_enqueue_script('v1-bootstrap-js', get_theme_file_uri('/js/nav.js'), array(), '1.0');
    //wp_enqueue_script('v1-respond', get_theme_file_uri('/js/banner.min.js'), array(), '1.0');
    //wp_enqueue_script('v1-stickup', get_theme_file_uri('/js/scrolltopcontrol.js'), array(), '1.0');
    //wp_enqueue_script('v1-stickup', get_theme_file_uri('/js/table.js'), array(), '1.0');
    //wp_enqueue_script('v1-jquery-validationEngine', get_theme_file_uri('/js/jquery.validationEngine.js'), array(), '1.1');
    //wp_enqueue_script('v1-jquery-validationEngine-en', get_theme_file_uri('/js/jquery.validationEngine-en.js'), array(), '2.1');

}
add_action('wp_enqueue_scripts', 'v1_scripts');

function v1_widgets_init()
{
    /*
    register_sidebar(array(
        'name' => __('Product Sidebar', 'v1'),
        'id' => 'productbar',
        'description' => __('Add widgets here to appear in your sidebar on product pages.', 'v1'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Service Sidebar', 'v1'),
        'id' => 'servicebar',
        'description' => __('Add widgets here to appear in your sidebar on service pages.', 'v1'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Contact Sidebar', 'v1'),
        'id' => 'contactbar',
        'description' => __('Add widgets here to appear in your sidebar on contact pages.', 'v1'),
        'before_widget' => '<div class="se-part">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    */
    register_sidebars(4, array(
        'name' => __('Footer Sidebar %d', 'v1'),
        'id' => 'footerbar',
        'description' => __('Add widgets here to appear in all page footer.', 'v1'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'v1_widgets_init');

function get_breadcrumbs($cid=0)
{
    global $wp_query;

    if (!is_home()) {

        // Add the Home link
        echo '<a href="' . get_option('home') . '">Home</a> / ';

        if (is_category()) {
            $catpath = " " . get_category_parents(get_query_var('cat'), true, " / ") . "";
            $catpath = str_replace('<a href="http://www.matexcel.com/category/products/">Products</a>','Products',$catpath);
            echo $catpath;
        } elseif (is_archive() && !is_category()) {
            echo "Archives";
        } elseif (is_search()) {

            echo "Search Results";
        } elseif (is_404()) {
            echo "404 Not Found";
        } elseif (is_single()) {
            $category = get_the_category();
            $category_id = get_cat_ID($category[0]->cat_name);
            echo ' ' . get_category_parents($category_id, true, " / ");
            echo the_title('', '', false) . "";
        } elseif (is_page()) {
            $post = $wp_query->get_queried_object();

            if ($post->post_parent == 0) {

                echo "" . the_title('', '', false) . "";

            } else {
                $title = the_title('', '', false);
                $ancestors = array_reverse(get_post_ancestors($post->ID));
                array_push($ancestors, $post->ID);

                foreach ($ancestors as $ancestor) {
                    if ($ancestor != end($ancestors)) {
                        echo '<a href="' . get_permalink($ancestor) . '">' . strip_tags(apply_filters('single_post_title', get_the_title($ancestor))) . '</a> / ';
                    } else {
                        echo '' . strip_tags(apply_filters('single_post_title', get_the_title($ancestor))) . '';
                    }
                }
            }
        }

    }else{
        //自定义页面也在这里
        if($cid!=0){
            echo '<a href="' . get_option('home') . '">Home</a> / ';
            $catpath = ' ' . get_category_parents($cid, true, " / ");
            $catpath = str_replace('<a href="http://www.matexcel.com/category/products/">Products</a>','Products',$catpath);
            echo $catpath;
        }
    }
}

function v1_get_svg($args = array())
{
    // Make sure $args are an array.
    if (empty($args)) {
        return __('Please define default parameters in the form of an array.', 'v1');
    }

    // Define an icon.
    if (false === array_key_exists('icon', $args)) {
        return __('Please define an SVG icon filename.', 'v1');
    }

    // Set defaults.
    $defaults = array(
        'icon' => '',
        'title' => '',
        'desc' => '',
        'fallback' => false,
    );

    // Parse args.
    $args = wp_parse_args($args, $defaults);

    // Set aria hidden.
    $aria_hidden = ' aria-hidden="true"';

    // Set ARIA.
    $aria_labelledby = '';

    /*
     * Twenty Seventeen doesn't use the SVG title or description attributes; non-decorative icons are described with .screen-reader-text.
     *
     * However, child themes can use the title and description to add information to non-decorative SVG icons to improve accessibility.
     *
     * Example 1 with title: <?php echo twentyseventeen_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ) ) ); ?>
     *
     * Example 2 with title and description: <?php echo twentyseventeen_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ), 'desc' => __( 'This is the description', 'textdomain' ) ) ); ?>
     *
     * See https://www.paciellogroup.com/blog/2013/12/using-aria-enhance-svg-accessibility/.
     */
    if ($args['title']) {
        $aria_hidden = '';
        $unique_id = uniqid();
        $aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';

        if ($args['desc']) {
            $aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
        }
    }

    // Begin SVG markup.
    $svg = '<svg class="icon icon-' . esc_attr($args['icon']) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

    // Display the title.
    if ($args['title']) {
        $svg .= '<title id="title-' . $unique_id . '">' . esc_html($args['title']) . '</title>';

        // Display the desc only if the title is already set.
        if ($args['desc']) {
            $svg .= '<desc id="desc-' . $unique_id . '">' . esc_html($args['desc']) . '</desc>';
        }
    }

    /*
     * Display the icon.
     *
     * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
     *
     * See https://core.trac.wordpress.org/ticket/38387.
     */
    $svg .= ' <use href="#icon-' . esc_html($args['icon']) . '" xlink:href="#icon-' . esc_html($args['icon']) . '"></use> ';

    // Add some markup to use as a fallback for browsers that do not support SVGs.
    if ($args['fallback']) {
        $svg .= '<span class="svg-fallback icon-' . esc_attr($args['icon']) . '"></span>';
    }

    $svg .= '</svg>';

    return $svg;
}

/**
 * Custom walker class.
 */
class WPDocs_Walker_Nav_Menu extends Walker_Nav_Menu
{

    /**
     * Starts the list before the elements are added.
     *
     * Adds classes to the unordered list sub-menus.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        // Depth-dependent classes.
        $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent
        $display_depth = ($depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'dropdown-menu',
        );
        $class_names = implode(' ', $classes);

        // Build HTML for output.
        $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
    }

    /**
     * Start the element output.
     *
     * Adds main/sub-classes to the list items and links.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        global $wp_query;
        $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent

        // Depth-dependent classes.
        $depth_classes = array(
            '',
        );
        $depth_class_names = esc_attr(implode(' ', $depth_classes));

        // Passed classes.
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

        // Build HTML.
        //$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
        if ($class_names != '') {
            $output .= $indent . '<li class="' . $class_names . '">';
        } else {
            $output .= $indent . '<li>';
        }

        // Link attributes.
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        if (in_array("dropdown", $item->classes)) {
            $attributes .= ' class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"';
        }
        //$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

        // Build HTML output and pass through the proper filter.
        $item_output = sprintf('%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters('the_title', $item->title, $item->ID),
            $args->link_after,
            $args->after
        );
        //wp_nav_menu_objects run first
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

function wpdocs_add_menu_parent_class($items)
{
    $parents = array();

    // Collect menu items with parents.
    foreach ($items as $item) {
        if ($item->menu_item_parent && $item->menu_item_parent > 0) {
            $parents[] = $item->menu_item_parent;
        }
        //var_dump($item);
    }

    // Add class.
    foreach ($items as $item) {
        if (in_array('current_page_item', $item->classes)) {
            $item->classes = array('active');
        } else {
            $item->classes = array();
        }
        if (in_array($item->ID, $parents)) {
            $item->classes[] = 'dropdown';
            $item->title = $item->title . ' <span class="caret"></span>';
            //$item->post_title = $item->title;
            //var_dump($item);
        }
    }
    return $items;
}

add_filter('wp_nav_menu_objects', 'wpdocs_add_menu_parent_class');

// 搜索筛选
function v1_search_filter($query)
{
    if (!$query->is_admin && $query->is_search) {
        $query->set('post__not_in', array(22,24)); // 文章或者页面的ID
    }
    return $query;
}
add_filter('pre_get_posts', 'v1_search_filter');


function v1_page_template($template)
{

    $url = strtolower($_SERVER['REQUEST_URI']);
    $vpid = get_query_var('vpid');
    if (!empty($vpid)) {
        $new_template = locate_template(array('content/content-product.php'));
        if ('' != $new_template) {
            return $new_template;
        }
    }
    return $template;
}

add_filter('template_include', 'v1_page_template', 99);

function startWith($str, $needle)
{
    return stripos($str, $needle) === 0;
}

function v1_paging($current_page, $pagesize, $total, $url = "", $echo = false,$page='page')
{

    $total_page = intval($total / $pagesize) + 1;

    //$current_page = empty($_GET['page']) ? 1 : $_GET['page'];
    $previous_page = $current_page - 1;
    $next_page = $current_page + 1;

    if ($previous_page == 0) {
        $previous_page = 1;
    }

    if ($next_page > $total_page) {
        $next_page = $current_page;
    }

    $txt='';

    if ($echo) {
        //echo '<a href="' . $url . '?page=1">First Page</a>';
        echo '<a href="' . $url . '?'.$page.'=1">First Page</a>';
        echo '<a href="' . $url . '?'.$page.'=' . $previous_page . '">Previous</a>';
/*
        for ($i = 1; $i < $total_page; $i++):
            if ($current_page == $i) {
                echo '<a href="' . $url . '?page=' . $i . '">' . $i . '</a>';
            } else {
                echo '<a href="' . $url . '?page=' . $i . '">' . $i . '</a>';
            }

        endfor;
        */
        echo '<a href="' . $url . '?'.$page.'=' . $next_page . '">Next</a>';
        echo '<a href="' . $url . '?'.$page.'=' . $total_page . '">Last Page</a>';

    }else{
        $txt.='<a href="' . $url . '?'.$page.'=1">First Page</a>';
        $txt.='<a href="' . $url . '?'.$page.'=' . $previous_page . '">Previous</a>';
/*
        for ($i = 1; $i < $total_page; $i++):
            if ($current_page == $i) {
                $txt.='<a href="' . $url . '?page=' . $i . '">' . $i . '</a>';
            } else {
                $txt.='<a href="' . $url . '?page=' . $i . '">' . $i . '</a>';
            }

        endfor;
        */
        $txt.='<a href="' . $url . '?'.$page.'=' . $next_page . '">Next</a>';
        $txt.='<a href="' . $url . '?'.$page.'=' . $total_page . '">Last Page</a>';
    }
    return $txt;
}


//移除admin_bar的logo
function remove_wp_logo()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'remove_wp_logo');

//移除左侧文字
add_filter('admin_footer_text', '_admin_footer_left_text');

function _admin_footer_left_text($text)
{

    $text = '';

    return $text;

}
//移除版本信息
add_filter('update_footer', '_admin_footer_right_text', 11);

function _admin_footer_right_text($text)
{

    $text = '';

    return $text;

}



// 移除wordpress核心更新提示
//add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );


// 移除wordpress插件更新提示
//remove_action( 'load-update-core.php', 'wp_update_plugins' );
//add_filter( 'pre_site_transient_update_plugins', create_function( '$b', "return null;" ) );


function custom_loginlogo() {

    echo'<style type="text/css"> h2 a {background-image: url('.get_template_directory_uri().'/images/logo.png) !important; } </style>';
    
} 
add_action('login_head', 'custom_loginlogo');

function custom_loginlogo_url($url) {

    return '/';
    
}
add_filter( 'login_headerurl', 'custom_loginlogo_url');

function custom_login_headertitle($title) {

    return '';
    
}
add_filter( 'login_headertitle', 'custom_login_headertitle');

function custom_login_title($title) {

    return 'Log In';
    
}
add_filter( 'login_title', 'custom_login_title');

//remove_action( 'wp_head', '_wp_render_title_tag', 1 );
//add_filter( 'no_texturize_tags', 'my_no_texturzie_tags' );
function my_no_texturzie_tags( $tags ) {
	
    $tags[] = 'mycode';
	return $tags;
}
//add_filter( 'run_wptexturize', '__return_false' );


function v1_robots_txt($output,$public)
{


	if(is_main_domain()){
        $output .=PHP_EOL.'Disallow: /inquiry/?q=*';
        $output .=PHP_EOL.'Disallow: /pdf/?q=*';
        $output .=PHP_EOL.'Disallow: /?*s=*';
        $output .=PHP_EOL.'Disallow: /*/nosvg/*';
        $output .=PHP_EOL.'Allow: /?st=1&s=HAp*';
        $output .=PHP_EOL.'Allow: /?st=1&s=tcp*';
        $output .=PHP_EOL.'Allow: /?st=1&s=bioglass*';
        $output .=PHP_EOL.'Allow: /?st=1&s=Silicate+Powder*';
        $output .=PHP_EOL.'Allow: /?st=1&s=Stainless+steel+Powder*';
        $output .=PHP_EOL.'Allow: /?st=1&s=Titanium-based*';
        $output .=PHP_EOL.'Allow: /?st=1&s=Cobalt-based*';
        $output .=PHP_EOL.'Allow: /?st=1&s=Nickel-based*';
        $output .=PHP_EOL.'Allow: /?st=1&s=Aluminum-based*';
        $output .=PHP_EOL.'Allow: /?st=1&s=Copper-based*';
        $output .=PHP_EOL.'Allow: /?st=1&s=Collagen*';
        $output .=PHP_EOL.'Allow: /?st=1&s=Chitosan*';
        $output .=PHP_EOL.'Allow: /?st=1&s=ECM*';
        $output .=PHP_EOL.'Allow: /?st=1&s=Hydrogel*';
        $output .=PHP_EOL.'Allow: /?st=1&s=Silk*';
        $output .=PHP_EOL;
	}else{
        $output='User-agent: * '.PHP_EOL.'Disallow: / '.PHP_EOL;
    }
    return $output;

}
add_filter('robots_txt', 'v1_robots_txt',0,2);


function get_ip()
{
    if ($_SERVER['HTTP_CLIENT_IP']) {
        $onlineip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ($_SERVER['HTTP_X_FORWARDED_FOR']) {
        $onlineip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $onlineip = $_SERVER['REMOTE_ADDR'];
    }
    return $onlineip;
}

function add_query_vars_filter($vars)
{
    $vars[] = "captcha";
    return $vars;
}
add_filter('query_vars','add_query_vars_filter');

/**
 *
 * START session
 *
 */
function register_session(){
    if( !session_id() )
        session_start();
}
add_action('init','register_session');


function add_template_redirect()
{
    $captcha = get_query_var('captcha');

    if ($captcha == '1') {
        require dirname(__FILE__).'/inc/v-code.php';
        die;
    }
}
add_action("template_redirect", 'add_template_redirect');


function tin_ajax_verificationcaptcha(){
    $fieldId=$_REQUEST['fieldId'];
    $code = trim($_REQUEST['fieldValue']);
    $validate_code=isset($_SESSION['validate_code'])?$_SESSION['validate_code']:'';
    $validate_code=strtolower($validate_code);
    $code=strtolower($code);
    if ($code !== $validate_code || $validate_code=="") {
        $result=[$fieldId,false,""];
    }else{
        $result=[$fieldId,true,""];
    }
    header( 'content-type: application/json; charset=utf-8' );
    echo json_encode( $result );
    exit;
}
add_action( 'wp_ajax_verificationcaptcha', 'tin_ajax_verificationcaptcha' );
add_action( 'wp_ajax_nopriv_verificationcaptcha', 'tin_ajax_verificationcaptcha' );

function no_wordpress_errors(){
    return 'Something is wrong!';
}
add_filter( 'login_errors', 'no_wordpress_errors' );

add_filter('xmlrpc_methods',function($methods){unset($methods ['pingback.ping']); return $methods; });

add_filter( 'xmlrpc_enabled', '__return_false' );


function tin_ajax_lodingrecaptcha(){
    $ip=get_ip();
    if (isset($_SESSION[$ip])){
        $add_data=$_SESSION[$ip];
    }else{
        $add_data=@file_get_contents('https://api.cd-web.org/getip.ashx?ip='.$ip.'&token=ESetaY6d5MQiI9eh!9vHTGcks6xzU1P8',false);
        $add_data=json_decode($add_data,true);
        $_SESSION[$ip]=$add_data;
    }


    $result=['status'=>1,'src'=>'https://www.google.com/recaptcha/api.js?render='.CustomConfig::RECAPTCHAHTML.'&hl=en'];
    if (isset($add_data['status']) && isset($add_data['status'])=='1' && isset($add_data['data'][0]['country']) && $add_data['data'][0]['country']=="China"){
        $result=['status'=>0,'src'=>'https://www.recaptcha.net/recaptcha/api.js?render='.CustomConfig::RECAPTCHAHTML.'&hl=en'];
    }

    header( 'content-type: application/json; charset=utf-8' );
    echo json_encode( $result );
    exit;
}
add_action( 'wp_ajax_lodingrecaptcha', 'tin_ajax_lodingrecaptcha' );
add_action( 'wp_ajax_nopriv_lodingrecaptcha', 'tin_ajax_lodingrecaptcha' );


function tin_ajax_userSubscribe(){

    $code = $_REQUEST['grecaptcharesponse'];
    $resps=post_data('https://www.recaptcha.net/recaptcha/api/siteverify',['secret'=>CustomConfig::RECAPTCHASERVERS,'response'=>$code]);
    $resp = json_decode($resps, true);
    $response='0';
    if (isset($resp['success']) && $resp['success'] == true) {
        $email=$_POST['email'];
        $site_name='Matexcel';
        $body="<p><img width='20%' src='".home_url()."/public/themes/v1/images/logo.png' alt=''></p>";
        $body.="<p><strong>Thank you for subscribing to our Newsletter</strong></p>";
        $body.="<p>You just registered to ".$site_name." newsletter through our website with the eamil address: ".$email." and we would thank you for that.</p>";
        $body.="<p>Best regards,</p>";
        $body.="<p>".$site_name."</p>";
        $set = array(
            'subject'=>'Newsletter - '.$site_name,
            'body'=>$body,
            'from'=>'contact@matexcel.com',
            'entity'=>[
                'S_Id' => session_id(),
                'S_Email' => $email,
                'S_Ip' => get_ip(),
                'S_Domain' => $site_name,
                'S_Website'=>home_url()
            ],

        );
        $result=send_email_subscribe_main($set);

        $response='0';
        if (isset($result->SubscribeResult) && strpos($result->SubscribeResult,'Success')!==false) {
            $response='1';
        }
    }


    header( 'content-type: application/json; charset=utf-8' );
    echo $response;
    exit;
}
add_action( 'wp_ajax_userSubscribe', 'tin_ajax_userSubscribe' );
add_action( 'wp_ajax_nopriv_userSubscribe', 'tin_ajax_userSubscribe' );