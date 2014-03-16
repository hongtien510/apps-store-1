var array_img_ul = new Array();
var j=0;
(function () {
	var input = document.getElementById("images"), 
		formdata = false;
	if (window.FormData) {
  		formdata = new FormData();
	}
	
 	input.addEventListener("change", function (evt) {
	$('p.loading_img').show();
 		var i = 0, len = this.files.length, img, reader, file;
        if(len>1)
        {
            $('p.loading_img').hide();
            alert("Bạn chỉ được chọn 1 hình để làm hình hiển thị chính");
            return false;
        }
		for ( ; i < len; i++ ) {
			file = this.files[i];
			if (!!file.type.match(/image.*/)) {
				if (formdata) {
					formdata.append("images[]", file);  
				}
			}	
		}
		if (formdata) {
			$.ajax({
				//url: taaa.appdomain + "/application/modules/upload/upload.php",
				url: taaa.appdomain + "/application/modules/upload/upload.php",
				type: "POST",
				data: formdata,
				processData: false,
				contentType: false,
				success: function (res) {
				//alert(res);
				
				var getData = $.parseJSON(res);
				var i;
				var len = getData.length;
					//alert(len);
					//$('.image_list').html("");
					for(i=0; i<len; i++){
						array_img_ul[j++]=getData[i]['name'];
						$('.image_list').append("<li class='"+getData[i]['class']+"'>"+getData[i]['name_old']+" <a onclick = \"UPLOAD.del_img_upload('"+getData[i]['name']+"')\" class='del_img img_upload_"+i+"' href='javascript:;'>xóa</a></li>");
					}
					$('p.loading_img').fadeOut();
                    Get_String_Img();
				}
			});
		}
	}, false);
}());

function Get_String_Img()
{
    $.ajax({
			url: taaa.appdomain + "/application/modules/upload/upload.php",
			type: "POST",
			data: {arrimg:array_img_ul, act:'get_img_upload'},
			success: function (data) {
				//alert(data);
                document.getElementById('string_img_upload').value = data;
			}
	});
}

function Count_Img_Upload(max)
{
    $.ajax({
			url: taaa.appdomain + "/application/modules/upload/upload.php",
			type: "POST",
			data: {arrimg:array_img_ul, act:'count_img_upload'},
			success: function (data) {
			//	var obj = jQuery.parseJSON(data);
					
                        //alert(data);
                        //alert("Anh khong duoc lon hon " + max);
                        //return false;        
			}
	});
}

var UPLOAD;
$(document).ready(function(){
UPLOAD={
	del_img_upload:function(obj)
	{
	//alert(obj);
		$.ajax({
			url: taaa.appdomain + "/application/modules/upload/upload.php",
			type: "POST",
			data: {image:obj, arrimg:array_img_ul, act:'del_img_upload'},
			success: function (data) {
				getData = $.parseJSON(data);
				var classing = getData.classimg;
				var arr_img_ul = getData.arr_img_ul;
				array_img_ul = arr_img_ul;
                //alert(array_img_ul.length);
				$('li.'+classing).fadeOut();
                Get_String_Img();
			}
		});
        
	},
    
},


$('.btn_abc').click(function(){
	$.ajax({
			url: taaa.appdomain + "/application/modules/upload/upload.php",
			type: "POST",
			data: {arrimg:array_img_ul, act:'get_img_upload'},
			success: function (data) {
				alert(data);
			}
	});
});

});
