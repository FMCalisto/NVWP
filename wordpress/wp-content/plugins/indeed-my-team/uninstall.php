<?phpif ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();global $wpdb;$wpdb->query("                DELETE a,b,c,d,e FROM {$wpdb->prefix}posts a                LEFT JOIN {$wpdb->prefix}term_relationships b ON (a.ID=b.object_id)                LEFT JOIN {$wpdb->prefix}term_taxonomy c ON (c.term_taxonomy_id=b.term_taxonomy_id)                LEFT JOIN {$wpdb->prefix}terms d ON (c.term_id = d.term_id)                LEFT JOIN {$wpdb->prefix}postmeta e ON (a.ID=e.post_id)                WHERE a.post_type='team';            ");$arr = array(   'imt_post_type_slug',
				'imt_responsive_settings_small',
				'imt_responsive_settings_medium',
				'imt_responsive_settings_large',
				'imt_custom_page_entry_infos');
foreach($arr as $value){
	delete_option($value);
}?>