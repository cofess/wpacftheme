jQuery(document).ready(function($){


  $('#wps-erm-clear-logs').on('click', function(e){
     e.preventDefault();

      if (confirm('Are you sure you wish to clear ALL logs?')) {
          $.post(ajaxurl, {action:'wps_clear_logs'}, function(response){

              window.location.reload();

          });
      }

  });

  $('.wps-rm-delete').on('click', function(e){
    e.preventDefault();

    var obj = $(this);
    var row = $(this).parents('tr');
    var rule_id = $(obj).data('rule-id');

    $(row).addClass('remove-in-progress');
    
    if (confirm('Are you sure you wish to remove this rule?')) {
      $.post(ajaxurl, {action:'wps_remove_rule', rule_id:rule_id}, function(response){
        
        $(row).removeClass('remove-in-progress');
        
        if (response.success) {
          $('td',row).slideUp(500);
        } else {
          alert('error');
        }

      });
    } else {
      $(row).removeClass('remove-in-progress');
    }

  }); // remove rule

});