<?php
/**
 * category template
 */
$cid = get_query_var('cat');
$categoryparentpath = get_category_parents($cid);
$cat = get_category($cid);
$catparent = get_category($cat->category_parent);
function custom_get_canonical_url($url){
    global $cid;
    return  '<link rel="canonical" href="' . get_category_link($cid) . '" />' . "\n";
}
add_filter('custom_get_canonical_url','custom_get_canonical_url');
function v1_page_title($title)
{
    global $cat,$catparent;
    $seotitle = get_option("seo-title-".get_query_var('cat'));
    #$title['site']=$title['title'];
    $title['title'] = $seotitle?$seotitle:$cat->cat_name;
    if(!is_null($catparent->cat_name)){
        $title['title'].=', '.$catparent->cat_name;
    }
    return $title;
}
add_filter('document_title_parts', 'v1_page_title', 10, 1);



if($cid==3){
    get_template_part('category/category', 'others');
}
else if (startWith($categoryparentpath, 'products')) {

    get_template_part('category/category', 'products');

} else {

    get_template_part('category/category', 'others');
}
get_footer();
