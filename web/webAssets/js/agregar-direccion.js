$(document).ready(function() {

    // Taller - Edit
    $('#form-checkbox-num-externo').change(function() {
		// $(this).closest('div').parent('div').prev().remove();

		if(this.checked) {
            console.log("Change if");
            $("#form-input-num-externo").val("S/N");
            $("#form-input-num-externo").prop('disabled', true);
		}
		else{
            console.log("Change else");
            $("#form-input-num-externo").val("");
            $("#form-input-num-externo").prop('disabled', false);
		}
    });

    $('#form-checkbox-num-externo').mousedown(function() {
        if (!$(this).is(':checked')) {
            console.log("Mouse");
            $("#form-input-num-externo").val("S/N");
            $("#form-input-num-externo").prop('disabled', true);
        }
	});
    
});