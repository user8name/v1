<?php

if (!is_user_logged_in() || !current_user_can('level_10')) {
    echo 'Please log in.';
    die();
}

$q = '';
if (isset($_GET['q'])) {
    $q = $_GET['q'];
}

$qv = '';
if (isset($_GET['qv'])) {
    $qv = $_GET['qv'];
}

if ($q == 'stats') {
    global $wpdb;
    if ($qv == 'year') {
        echo '<table>';
        for ($i = 1; $i <= 12; $i++) {
            $firstday = date('Y-m-01', strtotime('2018-' . $i . '-01')) . ' 00:00:00';
            $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day")) . ' 23:59:59';
            $insertcount = $wpdb->get_var($wpdb->prepare('SELECT count(*) as insertcount FROM `wp_products` WHERE isdel=0 and `itime` between %s and %s', $firstday, $lastday));
            $updatecount = $wpdb->get_var($wpdb->prepare('SELECT count(*) as updatecount FROM `wp_products` WHERE isdel=0 and itime<>utime and `utime` between %s and %s', $firstday, $lastday));
            $deletecount = $wpdb->get_var($wpdb->prepare('SELECT count(*) as deletecount FROM `wp_products` WHERE isdel=1 and `utime` between %s and %s', $firstday, $lastday));
            $insertcount2 = $wpdb->get_var($wpdb->prepare('SELECT count(*) as insertcount FROM `wp_posts` WHERE `post_status`=%s and `post_type`=%s and `post_date` between %s and %s', 'publish', 'page', $firstday, $lastday));
            $updatecount2 = $wpdb->get_var($wpdb->prepare('SELECT count(*) as updatecount FROM `wp_posts` WHERE  `post_status`=%s and `post_type`=%s and `post_date`<>`post_modified` and `post_modified` between %s and %s', 'publish', 'page', $firstday, $lastday));
            $deletecount2 = $wpdb->get_var($wpdb->prepare('SELECT count(*) as deletecount FROM `wp_posts` WHERE  `post_status`=%s and `post_type`=%s and `post_modified` between %s and %s', 'trash', 'page', $firstday, $lastday));

            echo '<tr>';
            echo '<td>' . $insertcount . '</td>';
            echo '<td>' . $updatecount . '</td>';
            echo '<td>' . $deletecount . '</td>';
            echo '<td>' . $insertcount2 . '</td>';
            echo '<td>' . $updatecount2 . '</td>';
            echo '<td>' . $deletecount2 . '</td>';
            echo '</tr>';
        }
        echo '</tr></table>';
    
        $firstday = date('Y-m-01', strtotime('2018-01-01')) . ' 00:00:00';
        $lastday = date('Y-m-d', strtotime("$firstday +12 month -1 day")) . ' 23:59:59';

        $rows1 = $wpdb->get_results($wpdb->prepare('SELECT ID,post_title,post_date,post_modified,post_status FROM `wp_posts` WHERE  (`post_status`=%s)  and `post_type`=%s and (`post_date` between %s and %s) order by `post_date` asc', 'publish', 'page', $firstday, $lastday));

        $rows2 = $wpdb->get_results($wpdb->prepare('SELECT ID,post_title,post_date,post_modified,post_status FROM `wp_posts` WHERE  (`post_status`=%s)  and `post_type`=%s and (`post_modified` between %s and %s) order by `post_modified` asc', 'publish',  'page', $firstday, $lastday));
        ?>
            insert:<br />
            <table>
            <tr  style="background:#86b02b">
            <td>title</td><td>url</td><td>insert time</td>
            </tr>
            <?php foreach ($rows1 as $row) {
                        setup_postdata($row);
                        ?>
            <tr>
            <td><?php echo $row->post_title ?></td><td><?php echo get_permalink($row->ID) ?></td><td><?php echo $row->post_date ?></td>
            </tr>
                <?php
                wp_reset_postdata();
            }
                    ?>
            </table>

            update:<br />
            <table>
            <tr  style="background:#86b02b">
            <td>title</td><td>url</td><td>update time</td>
            </tr>
            <?php foreach ($rows2 as $row) {
                        setup_postdata($row);
                        ?>
            <tr>
            <td><?php echo $row->post_title ?></td><td><?php echo get_permalink($row->ID) ?></td><td><?php echo $row->post_modified ?></td>
            </tr>
                <?php
                wp_reset_postdata();
            }
                    ?>
            </table>
      

        <?php

    } else {
        if ($qv == '') {
            $qv = date("Y-m-d h:i:sa", strtotime('now'));
        }

        $firstday = date('Y-m-01', strtotime($qv)) . ' 00:00:00';
        $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day")) . ' 23:59:59';

        $insertcount = $wpdb->get_var($wpdb->prepare('SELECT count(*) as insertcount FROM `wp_products` WHERE isdel=0 and `itime` between %s and %s', $firstday, $lastday));
        $updatecount = $wpdb->get_var($wpdb->prepare('SELECT count(*) as updatecount FROM `wp_products` WHERE isdel=0 and itime<>utime and `utime` between %s and %s', $firstday, $lastday));
        $deletecount = $wpdb->get_var($wpdb->prepare('SELECT count(*) as deletecount FROM `wp_products` WHERE isdel=1 and `utime` between %s and %s', $firstday, $lastday));
        $insertcount2 = $wpdb->get_var($wpdb->prepare('SELECT count(*) as insertcount FROM `wp_posts` WHERE `post_status`=%s and `post_type`=%s and `post_date` between %s and %s', 'publish', 'page', $firstday, $lastday));
        $updatecount2 = $wpdb->get_var($wpdb->prepare('SELECT count(*) as updatecount FROM `wp_posts` WHERE  `post_status`=%s and `post_type`=%s and `post_date`<>`post_modified` and `post_modified` between %s and %s', 'publish', 'page', $firstday, $lastday));
        $deletecount2 = $wpdb->get_var($wpdb->prepare('SELECT count(*) as deletecount FROM `wp_posts` WHERE  `post_status`=%s and `post_type`=%s and `post_modified` between %s and %s', 'trash', 'page', $firstday, $lastday));
        $rows = $wpdb->get_results($wpdb->prepare('SELECT ID,post_title,post_date,post_modified,post_status FROM `wp_posts` WHERE  (`post_status`=%s or `post_status`=%s)  and `post_type`=%s and (`post_date` between %s and %s or `post_modified` between %s and %s)', 'publish', 'trash', 'page', $firstday, $lastday, $firstday, $lastday));

        ?>

        <html>
        <body>
        <h3>From <?php echo $firstday . ' to ' . $lastday ?></h3>
        <h3>Products infomation</h3>
        <table>
        <tr style="background:#86b02b">
        <td>insertcount</td><td>updatecount</td><td>deletecount</td>
        </tr>
        <tr>
        <td><?php echo $insertcount ?></td><td><?php echo $updatecount ?></td><td><?php echo $deletecount ?></td>
        </tr>
        </table>
        <h3>Services infomation</h3>
        <table>
        <tr  style="background:#86b02b">
        <td>insertcount</td><td>updatecount</td><td>deletecount</td>
        </tr>
        <tr>
        <td><?php echo $insertcount2 ?></td><td><?php echo $updatecount2 ?></td><td><?php echo $deletecount2 ?></td>
        </tr>
        </table>
        <?php if (count($rows) > 0) {?>
        <h3>Services list</h3>
        <table>
        <tr  style="background:#86b02b">
        <td>title</td><td>url</td><td>insert time</td><td>update time</td><td>status</td>
        </tr>
        <?php foreach ($rows as $row) {
                    setup_postdata($row);
                    ?>
        <tr>
        <td><?php echo $row->post_title ?></td><td><?php echo get_permalink($row->ID) ?></td><td><?php echo $row->post_date ?></td><td><?php echo $row->post_modified ?></td><td><?php echo $row->post_status ?></td>
        </tr>
            <?php
            wp_reset_postdata();
        }
                ?>
        </table>
                <?php    
                }
                ?>
        </body>
        </html>

<?php }} elseif ($q == 'export') {
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:attachment;filename=" . $qv . ".xls");
    if ($qv == 'category') {
        echo 'Category' . chr(9);
        echo 'Description' . chr(9);
        echo 'Url' . chr(13);

        $cats = get_categories(array('hide_empty' => false, 'orderby' => 'term_order'));
        foreach ($cats as $obj) {
            if (get_option("cat-is-show-$obj->term_id") != '1') {
                continue;
            }
            echo $obj->name . chr(9);
            $short_des = get_option("short-des-$obj->term_id");
            if ($short_des != "") {

            } else {
                $short_des = $obj->description;
            }
            $short_des = wp_trim_words($short_des, 250, '...');
            $short_des = str_replace(chr(9), '', $short_des);
            $short_des = str_replace(chr(13), '', $short_des);
            echo $short_des . chr(9);
            echo get_category_link($obj->term_id) . chr(13);
        }
    }

}?>
