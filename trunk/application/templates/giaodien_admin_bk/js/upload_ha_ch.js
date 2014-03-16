var array_img_ul_ch = new Array();
var j=0;
(function () {
	var input = document.getElementById("images_ch"), 
		formdata = false;
	if (window.FormData) {
  		formdata = new FormData();
	}
	
 	input.addEventListener("change", function (evt) {
	$('p.loading_img_ch').show();
 		var i = 0, len = this.files.length, img, reader, file;
        if(len>4)
        {
            $('p.loading_img_ch').hide();
            alert("Bạn chỉ được chọn 4 hình để làm hình phụ");
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
				
				//url: "http://localhost/appfb/ishalistore/application/modules/upload/upload_ch.php",
				url: taaa.appdomain + "/application/modules/upload/upload_ch.php",
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
					//$('.image_list_ch').html("");
					for(i=0; i<len; i++){
						array_img_ul_ch[j++]=getData[i]['name'];
						$('.image_list_ch').append("<li class='"+getData[i]['class']+"'>"+getData[i]['name_old']+" <a onclick = \"UPLOAD2.del_img_upload_ha('"+getData[i]['name']+"')\" href='javascript:;'>xóa</a></li>");
					}
					$('p.loading_img_ch').fadeOut();
                    Get_String_Img_Ch();
				}
			});
		}
	}, false);
}());

function Get_String_Img_Ch()
{
    $.ajax({
			url: taaa.appdomain + "/application/modules/upload/upload_ch.php",
			type: "POST",
			data: {arrimg:array_img_ul_ch, act:'get_img_upload'},
			success: function (data) {
				//alert(data);
                document.getElementById('string_img_upload_ch').value = data;
			}
	});
}

var UPLOAD2;
$(document).ready(function(){
UPLOAD2={
	del_img_upload_ha:function(obj)
	{
		$.ajax({
			url: taaa.appdomain + "/application/modules/upload/upload_ch.php",
			type: "POST",
			data: {image:obj, arrimg:array_img_ul_ch, act:'del_img_upload'},
			success: function (data) {
				getData = $.parseJSON(data);
				var classing = getData.classimg;
				var arr_img_ul_ch = getData.arr_img_ul_ch;
				array_img_ul_ch = arr_img_ul_ch;
				$('li.'+classing).fadeOut();
				Get_String_Img_Ch();
			}
		});
	}

},
	$('li.hinhanh_post').click(function(){
		$('.ct_post_ha_ch').slideToggle('show')
	})
});