<div class="datepicker-box">

  <div class="datepicker-item">
    <label for="<?php echo DATE_RANGE_FROM; ?>"><?php echo __('From:', 'wp-date_range' ); ?></label>
    <input readonly="readonly" type="text" class="datepicker" name="<?php echo DATE_RANGE_FROM; ?>" id="<?php echo DATE_RANGE_FROM; ?>" value="<?php echo $from; ?>" />
    <a class="clear-datepicker"><span style="display:none;"><?php echo __('Clear', 'wp-date_range' ); ?></span></a>
  </div>
    <div class="datepicker-item">
    <label for="<?php echo DATE_RANGE_TO; ?>"><?php echo __('To:', 'wp-date_range' ); ?></label>
    <input readonly="readonly" type="text" class="datepicker" name="<?php echo DATE_RANGE_TO; ?>" id="<?php echo DATE_RANGE_TO; ?>" value="<?php echo $to;  ?>" />
    <a class="clear-datepicker"><span style="display:none;"><?php echo __('Clear', 'wp-date_range' ); ?></span></a>
  </div>

  <div class="clearboth"></div>

</div>