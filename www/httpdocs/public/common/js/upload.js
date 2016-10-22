var file_up = $("input[type='file']");
$(document).ready(function(){

	$("#uploadimage").on('submit',function(e){
		e.preventDefault();

		var reader = new FileReader();
		reader.readAsDataURL(file_up);

		$.ajax({
			type: "POST"
			, url: 'upload/upload.php'
			, dataType: 'html'
			// , data: { name: $('#file_up').files, length : $('#file_up').files.length }
			, data: new FormData(this)
			, contentType: false       // The content type used when sending data to the server.
			, cache: false             // To unable request pages to be cached
			, processData:false        // To send DOMDocument or non processed data file it is set to false
			, success: function(data){
				// $('#loading').hide();
				$("#message").html(data);

				console.log(data);
				console.log("Done");
			}
			, error:function(data, textStatus, error){
				console.log("Fail");
			}
			// , complete:function(data, textStatus){
			// 	console.log("Complete");
			// }

			// , xhr: function() {  // Custom XMLHttpRequest
			// 	console.log("xhr");
			// 	// var myXhr = $.ajaxSettings.xhr();
			// 	// if(myXhr.upload){ // Check if upload property exists
			// 	// 	myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
			// 	// }
			// 	// return myXhr;
			// }
		});
	});

});


$(function() {

	$(':file').change(function(){
	    var file = this.files[0];
	    file_up = file;
	    if(!file){
	    	console.log('Not choose');
	    	return;
	    }

	    var name = file.name; // abc.gif
	    var size = file.size;
	    var length = file.length; // total files were chosen
	    var type = file.type; // image/gif, image/jpeg, image/png, ...

    	console.log('name: ' + name + ' | type: ' + type);
	});

	function imageIsLoaded(e) {
		// $("#file_up").css("color","green");
		// $('#image_preview').css("display", "block");
		// $('#previewing').attr('src', e.target.result);
		// $('#previewing').attr('width', '250px');
		// $('#previewing').attr('height', '230px');
	};
});
