
/* Module-specific javascript can be placed here */

$(document).ready(function() {
	
	$('#div_OEModule_OphCoCvi_models_Element_OphCoCvi_ClericalInfo_info_email').hide();
	$('#OEModule_OphCoCvi_models_Element_OphCoCvi_ClericalInfo_preferred_info_fmt_id').change(function(){
		var label_name = $('#OEModule_OphCoCvi_models_Element_OphCoCvi_ClericalInfo_preferred_info_fmt_id').find(":selected").text();
		if (label_name.toLowerCase().indexOf("email") >= 0) {
			$('#div_OEModule_OphCoCvi_models_Element_OphCoCvi_ClericalInfo_info_email').show();
		} else {
			$('#div_OEModule_OphCoCvi_models_Element_OphCoCvi_ClericalInfo_info_email').hide();
		}
	});

			handleButton($('#et_save'),function() {
					});
	
	handleButton($('#et_cancel'),function(e) {
		if (m = window.location.href.match(/\/update\/[0-9]+/)) {
			window.location.href = window.location.href.replace('/update/','/view/');
		} else {
			window.location.href = baseUrl+'/patient/episodes/'+OE_patient_id;
		}
		e.preventDefault();
	});

	handleButton($('#et_deleteevent'));

	handleButton($('#et_canceldelete'));

	handleButton($('#et_print'),function(e) {
		printIFrameUrl(OE_print_url, null);
		
        iframeId = 'print_content_iframe',
        $iframe = $('iframe#print_content_iframe');
        
        $iframe.load(function() {
    		enableButtons();
    		e.preventDefault();            
            console.log('IFrame loaded');
            try{
                var PDF = document.getElementById(iframeId);
                PDF.focus();
                PDF.contentWindow.print();
            } catch (e) {
                alert("Exception thrown: " + e);
            }                                    
        });
        
	});

	$('select.populate_textarea').unbind('change').change(function() {
		if ($(this).val() != '') {
			var cLass = $(this).parent().parent().parent().attr('class').match(/Element.*/);
			var el = $('#'+cLass+'_'+$(this).attr('id'));
			var currentText = el.text();
			var newText = $(this).children('option:selected').text();

			if (currentText.length == 0) {
				el.text(ucfirst(newText));
			} else {
				el.text(currentText+', '+newText);
			}
		}
	});
	
	
});

function ucfirst(str) { str += ''; var f = str.charAt(0).toUpperCase(); return f + str.substr(1); }

function eDparameterListener(_drawing) {
	if (_drawing.selectedDoodle != null) {
		// handle event
	}
}
