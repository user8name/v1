<?php
/**
 * 为 WordPress 分类目录的描述添加可视化编辑器
 */
// 移除HTML过滤
remove_filter( 'pre_term_description', 'wp_filter_kses' );
remove_filter( 'pre_link_description', 'wp_filter_kses' );  
remove_filter( 'pre_link_notes', 'wp_filter_kses' );  
remove_filter( 'term_description', 'wp_kses_data' );
//为分类编辑界面添加可视化编辑器的“描述”框
//add_filter('edit_category_form_fields', 'cat_description');
function cat_description($tag)
{
	?>

		<tr class="form-field">
			<th scope="row" valign="top"><label for="description"><?php _ex('Description', 'Taxonomy Description'); ?></label></th>
			<td>
				<?php
				$settings = array('wpautop' => true, 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => '15', 'textarea_name' => 'description' );
				wp_editor(wp_kses_data($tag->description), 'cat_description', $settings);
				?>
				<br />
				<span class="description"><?php _e('The description is not prominent by default; however, some themes may show it.'); ?></span>
			</td>
		</tr>

	<?php
}
//移除默认的“描述”框
//add_action('admin_head', 'remove_default_category_description');
function remove_default_category_description()
{
    global $current_screen;
	if ( $current_screen->id == 'edit-category' )
	{
		?>
		<script type="text/javascript">
			jQuery(function($) {
				$('textarea#description').closest('tr.form-field').remove();
			});
		</script>
		<?php
	}
}


// 分类添加字段  
function cp_add_category_field(){  
    echo '<div class="form-field">  
            <label for="cat-pic">Cover Photo</label>  
            <input name="cat-pic" id="cat-pic" type="text" value="" size="40">  
            <p>The cover photo.</p>  
          </div>';  
    echo '<div class="form-field">  
          <label for="banner-pic">Banner Photo</label>  
          <input name="banner-pic" id="banner-pic" type="text" value="" size="40">  
          <p>The banner photo.</p>  
        </div>';  
    echo '<div class="form-field">  
            <label for="seo-title">SEO title</label>  
            <input name="seo-title" id="seo-title" type="text" value="" size="40">  
            <p>The SEO title.</p>  
          </div>';    
    echo '<div class="form-field">  
            <label for="seo-des">SEO description</label>  
            <input name="seo-des" id="seo-des" type="text" value="" size="40">  
            <p>The SEO description.</p>  
        </div>'; 
    echo '<div class="form-field">  
        <label for="short-des">Short description</label>  
        <textarea name="short-des" id="short-des"></textarea>
        <p>The short description.</p>  
        </div>'; 
    echo '<div class="form-field">  
        <label for="cat-is-show">Whether to show</label>  
        <input name="cat-is-show" id="cat-is-show" type="checkbox" value="1">  
        <p>Whether to show.</p>  
    </div>';                
            
}  
add_action('category_add_form_fields','cp_add_category_field',10,2);  
  
// 分类编辑字段  
function cp_edit_category_field($tag){  
    echo '<tr class="form-field">  
            <th scope="row"><label for="cat-pic">Cover Photo</label></th>  
            <td>  
                <input name="cat-pic" id="cat-pic" type="text" value="';  
                echo get_option('cat-pic-'.$tag->term_id).'" size="40"/><br>  
                <span class="cat-pic">The cover photo.</span>  
            </td>  
        </tr>';   
    echo '<tr class="form-field">  
        <th scope="row"><label for="banner-pic">Banner Photo</label></th>  
        <td>  
            <input name="banner-pic" id="banner-pic" type="text" value="';  
            echo get_option('banner-pic-'.$tag->term_id).'" size="40"/><br>  
            <span class="banner-pic">The banner photo.</span>  
        </td>  
    </tr>';   
    echo '<tr class="form-field">  
        <th scope="row"><label for="seo-title">SEO title</label></th>  
        <td>  
            <input name="seo-title" id="seo-title" type="text" value="';  
            echo get_option('seo-title-'.$tag->term_id).'" size="40"/><br>  
            <span class="seo-title">The SEO title.</span>  
        </td>  
    </tr>';    
    echo '<tr class="form-field">  
        <th scope="row"><label for="seo-des">SEO description</label></th>  
        <td>  
            <input name="seo-des" id="seo-des" type="text" value="';  
            echo get_option('seo-des-'.$tag->term_id).'" size="40"/><br>  
            <span class="seo-des">The SEO description.</span>  
        </td>  
    </tr>';  
    echo '<tr class="form-field">  
        <th scope="row"><label for="short-des">Short description</label></th>  
        <td>  
            <textarea name="short-des" id="short-des">';  
            echo get_option('short-des-'.$tag->term_id).'</textarea><br>  
            <span class="short-des">The short description.</span>  
        </td>  
    </tr>';  
    echo '<tr class="form-field">  
        <th scope="row"><label for="cat-is-show">Whether to show</label></th>  
        <td>  
            <input name="cat-is-show" id="cat-is-show" type="checkbox" value="1" '.checked( '1', get_option('cat-is-show-'.$tag->term_id) ,false).' /><br>  
            <span class="cat-is-show">Whether to show.</span>  
        </td>  
    </tr>';        

}  
add_action('category_edit_form_fields','cp_edit_category_field',10,2);  
  
// 保存数据  
function cp_taxonomy_metadate($term_id){  
    if(isset($_POST['cat-pic'])){  
        //判断权限--可改  
        if(!current_user_can('manage_categories')){  
            return $term_id;  
        }  
        // 封面  
        $cat_pic_key = 'cat-pic-'.$term_id; // key 选项名为 cat-pic-1 类型  
        $cat_pic_value = $_POST['cat-pic']; // value  

        $banner_pic_key = 'banner-pic-'.$term_id; // key 选项名为 cat-pic-1 类型  
        $banner_pic_value = $_POST['banner-pic']; // value  


        $seo_title_key = 'seo-title-'.$term_id; // key  
        $seo_title_value = $_POST['seo-title']; // value  

        $seo_des_key = 'seo-des-'.$term_id; // key  
        $seo_des_value = $_POST['seo-des']; // value  

        $short_des_key = 'short-des-'.$term_id; // key  
        $short_des_value = $_POST['short-des']; // value  

        $cat_is_show_key = 'cat-is-show-'.$term_id; // key  
        $cat_is_show_value = $_POST['cat-is-show']; // value  

        // 更新选项值  
        update_option( $cat_pic_key, $cat_pic_value );   
        update_option( $banner_pic_key, $banner_pic_value );  
        update_option( $seo_title_key, $seo_title_value );   
        update_option( $seo_des_key, $seo_des_value );  
        update_option( $short_des_key, $short_des_value );  
        update_option( $cat_is_show_key, $cat_is_show_value ); 

    }  
}  
  
// 虽然要两个钩子，但是我们可以两个钩子使用同一个函数  
add_action('created_category','cp_taxonomy_metadate',10,1);  
add_action('edited_category','cp_taxonomy_metadate',10,1);  