<?php
				'imt_responsive_settings_small',
				'imt_responsive_settings_medium',
				'imt_responsive_settings_large',
				'imt_custom_page_entry_infos');
foreach($arr as $value){
	delete_option($value);
}