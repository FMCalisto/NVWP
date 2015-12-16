<?php
$options = $this->getOptions();

/*
	echo '<pre>';
	print_r($options);
	echo '</pre>';
*/

  /*

$post_types = get_post_types( array( 'public' => true ), 'objects' );
unset( $post_types['attachment'] );
unset( $post_types['page'] );


$list1 = '';
$langcode = '';
if ( isset( $options['post_lang'])) {
  $langcode = $options['post_lang'];	
}

foreach ($this->langcode as $k=>$v) {
  $sel = '';
  if ($langcode == $k) {
	$sel = ' selected="selected" ';
  }
  $list1 .= '<option ' . $sel . ' value="' . $k . '">' . __($v, 'wp-date_range' ) . ' (' . $k . ')</option>';
}

$fcode = '';
$list2 = '';
$formatcode = '';
if ( isset( $options['post_format'])) {
  $formatcode = $options['post_format'];
  if (count($formatcode) == 3) {
	$formatcode = implode('/', array_keys($formatcode));
  }	
}

foreach($this->formatcode as $k=>$v) {
  $sel = '';
  if ($formatcode == $k) {
	$sel = ' selected="selected" ';
	$fcode = $v;
  }
  $list2 .= '<option ' . $sel . ' value="' . $k . '">' . $v . '</option>';
}


$list3 = '';
$sepcode = '';
$scode = '';
if ( isset( $options['post_separator'])) {
  $sepcode = $options['post_separator'];	
}

foreach ($this->sepcode as $v) {
  $sel = '';
  if ($sepcode == $v) {
	$sel = ' selected="selected" ';
	$scode = $v;
  }

  $list3 .= '<option ' . $sel . ' value="' . $v . '">' . $v . '</option>';
}



$list4 = '';
foreach ( $post_types as $id => $post_type ) {	
	
  $check = '';
  if ( isset( $options['post_types'] ) && in_array( $id, $options['post_types'] ) ) { 
    $check = ' checked="checked" '; 
  } 

  $list4 .= '
	<div>
	  <label>
		  <input ' . $check . ' name="' . esc_attr( 'pagemeta[post_types][]' ) . '" type="checkbox" id="' . esc_attr( 'pagemeta_' . $id ) . '" value="' .esc_attr( $id ) . '" />
		  ' . $id . '
	  </label>
	</div>
  ';
  
}

*/

?>

<div class="wrap">
		<div id="icon-options-general" class="icon32">
<br/>
</div>
<h2><?php echo __('Date range settings', 'wp-date_range'); ?></h2>
<?php echo $msg; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
   
<?php
    wp_nonce_field( DATE_RANGE_NONCE, DATE_RANGE_NONCE . '_nonce' );
?>	


  <table class="form-table">
    <tbody>
  
      <tr valign="top">
        <th scope="row">
          <label for="post_lang"><?php echo __('Language', 'wp-date_range'); ?></label>
        </th>
        <td>
          <select id="post_lang" name="pagemeta[post_lang]">
          <?php echo $list1; ?>
          </select>
        </td>
      </tr>
      
      <tr valign="top">
        <th scope="row">
          <label for="post_format"><?php echo __('Date items', 'wp-date_range'); ?></label>
        </th>
        <td>
          <select id="post_format" name="page_format">
          <?php echo $list2; ?> 
          </select>
        </td>
      </tr>
  
      <tr valign="top">
        <th scope="row">
          <label for="post_separator"><?php echo __('Date separator', 'wp-date_range'); ?></label>
        </th>
        <td>
          <select id="post_separator" name="pagemeta[post_separator]">
          <?php echo $list3; ?>
          </select>
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label><?php echo __('Date format', 'wp-date_range'); ?></label>
        </th>
        <td>
		  <div id="formated-date"><?php echo str_replace(' ', $scode, $fcode); ?></div>
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label><?php echo __('Content type', 'wp-date_range'); ?></label>
        </th>
        <td>
          <?php echo $list4; ?>	
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
			&nbsp;
        </th>
        <td>
			&nbsp;
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label for="post_separator"><?php echo __('Delete options on plugin deactivation', 'wp-date_range'); ?></label>
        </th>
        <td>
          <input name="pagemeta[post_delall]" id="post_delall" type="checkbox" value="1" <?php if ($options['post_delall'] == 1) { ?>checked="checked"<?php } ?> />
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label for="post_separator"><?php echo __('Clean options on setting update', 'wp-date_range'); ?></label>
        </th>
        <td>
          <input name="pagemeta[post_deltype]" id="post_deltype" type="checkbox" value="1" <?php if ($options['post_deltype'] == 1) { ?>checked="checked"<?php } ?> />
        </td>
      </tr>

    </tbody>
  </table>

  <p class="submit">
    <input id="submit" class="button button-primary" type="submit" value="<?php echo esc_attr(__('Save Changes')); ?>" name="submit">
  </p>
</form>
