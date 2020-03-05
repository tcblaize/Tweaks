<?php
/** 
 * Code goes in theme functions.php
 * This fixes an issue with Smush Pro where it's enqueued scripts are conflicting with other scripts in WP-ADMIN
 * The code basically forces wp smush scripts to only load on the wp smush pages in admin.
 * One could hook into the enque scripts of other plugins to apply this logic to them
 */

// load smush scripts only on the smush admin pages
add_action( 'wp_smush_enqueue', 'wp_smush_fix_conflict_with_tickera_func', 99 );
function wp_smush_fix_conflict_with_tickera_func( $status ){
    global $post_type;
    if(!(isset($_GET['page']) && ($_GET['page'] == 'smush'))){ 
        return false;
    }
    return $status;
}
