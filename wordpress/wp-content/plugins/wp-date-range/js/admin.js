jQuery(function($){
  $('.clear-datepicker').on('click', function(){
    $(this).parent().children('input.datepicker').val('');
  });
  

  $('#post_format, #post_separator').on('change', function(){
    var $sep = $('#post_separator').val();
	var $dateformat =  $('#post_format option:selected').text().replace(' ', $sep).replace(' ', $sep);
	$('#formated-date').html($dateformat);
  });
  
});	