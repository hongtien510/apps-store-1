	
$(document).ready(function(){
    
	if(getParameterValue('result') == 1)
		ThongBao("Thêm mới thành công",2000);
	if(getParameterValue('result') == 2)
		ThongBao("Chỉnh sửa thành công",2000);
	if(getParameterValue('result') == 3)
		ThongBao("Xóa thành công",2000);
        
  
    $('.dangxuatadmin').click(function(){
        alert('bb');
        /*
        $.ajax({
		url:taaa.appdomain + '/admin/loginadmin/xulydangxuat',
		type:'post',
		data:{},
		success:function(data){
		  //alert(data);
            alert("Đăng xuất thành công");
            window.location="../admin";
		}
	   });
       */	
    });
    
    $('.close_thongbao').live('click',function(){
        $('#thongbao').hide(); 
        $('#bg_thongbao').hide();
    });
	
	$('.close_thongbao2').live('click',function(){
		$('#thongbao').hide(); 
        $('#bg_thongbao').hide();
		var link = taaa.appdomain+'/admin/login/';
		window.location = link;
    });
	
	$('.close_thongbao3').live('click',function(){
		$('#thongbao').hide(); 
        $('#bg_thongbao').hide();
		var link = taaa.appdomain+'/admin/config/';
		window.location = link;
    });
    
    $("select[id='parent_id']").change(function(){
        var parent_id = $(this).val();
        var idloaisp = $('#idloaisp').val();
        //alert(parent_id);
        //alert(idloaisp);
        //return false;
        $.ajax({
			url:taaa.appdomain + '/admin/category/getorder',
			type:'post',
			data:{parent_id:parent_id, idloaisp:idloaisp},
			success:function(data){
			         if(data == 'ko')
                     {
                        ThongBaoLoi('Danh mục này đang chứa danh mục con');
                        $("#parent_id option[value=0]").prop("selected", "selected");
                        return false;
                     }
                     else
                     {
                        var order = parseInt(data)+1;
                        $("input[id='vitri']").val(order);
                     }
                    
				}
			});
    });
    /*
    $("input[name='btn_get_image_on_fb']").click(function(){
        $.ajax({
            url:taaa.appdomain+'/admin/product/getalbumfb',
            type:'post',
            data:{},
            success:function(data){
                $('#popup_content').fadeIn();
                $('#popup_content').html(data);
                window.scroll(0,0);
                FB.Canvas.scrollTo(0,0);
            }
        }); 
    });
    */
    $('.select_album_fb').live('change',function(){
        var album_id = $(this).val();
        if(album_id == 'ko')
        {
            $('.list_image_fb').html("");
            return false;
        } 
        $('.loading_photo').show();
        $.ajax({
            url:taaa.appdomain+'/admin/product/getphotobyalbum',
            type:'post',
            data:{album_id:album_id},
            success:function(data){
                $('.loading_photo').hide();
                $('.list_image_fb').html(data);
            }
        });
    });
    
    $(".img_fb input[type='checkbox']").live('change',function(){
        
        if($(this).is(':checked'))
            $(this).parent().parent().parent().addClass('selected');
        else
            $(this).parent().parent().parent().removeClass('selected');
    });
    
    $(".img_fb input[type='radio']").live('change',function(){
        $('ul.ul_list_img_fb li').removeClass('selected');

        //$(".img_fb input[type='radio']").prop('checked', false);
        //$(this).prop('checked', true);
        if($(this).is(':checked'))
        {
            $(this).parent().parent().parent().addClass('selected');
            //var photo_main = $(this).val();
            //$("input[name='photo_main_sanpham']").val(photo_main);
        } 
        else
            $(this).parent().parent().parent().removeClass('selected');
    });
    
    $(".ul_list_img_fb a").live('click',function(){
        var del = confirm('Bạn có chắc chắn xóa!');
        if(del == true)
        {
            var li = $(this).closest('li');
            li.css("background-color","#FF3700");
            li.fadeOut(400, function(){
                li.remove();
            });
            return false;
        }
        else
        {
            return false;
        }
    });
    
    $(".delete_photo_facebook").live('click',function(){
        
        var del = confirm('Bạn có chắc chắn xóa!');
        if(del == true)
        {
            var tr = $(this).closest('tr');
            tr.css("background-color","#FF3700");
            tr.fadeOut(400, function(){
                tr.remove();
            });
            return false;
        }
        else
        {
            return false;
        }
    });
    
    $('.select_parent_cat').change(function(){
        var parent_cat_id = $(this).val();
        $.ajax({
            url:taaa.appdomain+'/admin/product/getchildcat',
            type:'post',
            data:{parent_cat_id:parent_cat_id},
            success:function(data){
                if(data == "")
                {
                    $('select.select_child_cat').html('<option value="koo">Chọn danh mục</option>');
                    $('.div_select_child_cat').hide();
                    //$("input[name=btn_get_image_on_fb]").removeAttr("disabled");
                    $("a.btn_get_image_on_fb").removeClass("disabled_btn");
                }
                else
                {
                    $('select.select_child_cat').html(data);
                    $('.div_select_child_cat').show();
                    //$("input[name=btn_get_image_on_fb]").attr("disabled", "disabled");
                    $("a.btn_get_image_on_fb").addClass("disabled_btn");
                }
            }
        });
    });
    
    $('.select_child_cat').change(function(){
        var idCat = $(this).val();
        if(idCat != 'ko')
        {
            //$("input[name=btn_get_image_on_fb]").removeAttr("disabled");
            $("a.btn_get_image_on_fb").removeClass("disabled_btn");
        }
        else
        {
            //$("input[name=btn_get_image_on_fb]").attr("disabled", "disabled");
            $("a.btn_get_image_on_fb").addClass("disabled_btn");
        }
    });
    
    $('a[name=save_add_product]').click(function(){
        var parent_cat = $('select[name=select_parent_cat]').val();
        var child_cat = $('select[name=select_child_cat]').val();
        
        if(child_cat == 'ko' || parent_cat == 'ko')
        {
            ThongBaoLoi('Chưa chọn danh mục');
            return false;
        }
        for(i = 1; i<=50; i++)
        {
           var name_sp = $("input[name='name_sp["+i+"]']").val();
           if (name_sp == "")
           {
                ThongBaoLoi('Nhập đầy đủ tên sản phẩm');
                return false;
           }
        }
        $.ajax({
            url:taaa.appdomain+'/admin/product/processadd',
            type:'post',
            data:$("form#form_add_product").serialize(),
            success:function(data){
                if(data==1)
                {
                    ThongBao('Thêm mới sản phẩm thành công',2000);
                    window.location = '../product';    
                }
                else
                    ThongBaoLoi('Thêm mới không thành công');
                }
        });
    });
    
    $('.search_child_cat').live('change',function(){
        var child_cat = $(this).val();
        var parent_cat = $('.search_parent_cat').val();
        if(child_cat == 0)
        {
            window.location = 'product?idcat=' + parent_cat;
        }
        else
        {
            window.location = 'product?idcat=' + parent_cat + '&idchildcat=' + child_cat;
        }
    });
    
    $('input[name=open_giagiam]').change(function(){
        if($(this).is(':checked'))
        {
            $('.div_giagiam').show();
            $('.div_phantram_giagiam').show();
        }
        else
        {
            $('.div_giagiam').hide();
            $('.div_phantram_giagiam').hide();
            
            $('input[name=giagiam]').val('');
            $('input[name=sale_off]').val('');
        }
    });
    
    $("input[name=giagiam]").live('keyup',function(e){
        var giaban = $('input[name=giaban]').val();
        var giagiam = $(this).val();

        if(giaban == "" || giaban == 0)
        {
            ThongBaoLoi('Nhập giá bán');
            return false;
        }
        else
        {
            giaban = parseFloat(giaban);
            giagiam = parseFloat(giagiam);
            var phantram = 100 - ((giagiam/giaban)*100);
            $('input[name=sale_off]').val(number_format(phantram));
        }
    });
    
    $("input[name=sale_off]").live('keyup',function(e){
        var giaban = $('input[name=giaban]').val();
        var sale_off = $(this).val();
        
        if(giaban == "" || giaban == 0)
        {
            ThongBaoLoi('Nhập giá bán');
            return false;
        }
        else
        {
            giaban = parseFloat(giaban);
            sale_off = parseFloat(sale_off);
            var giagiam = giaban -((sale_off * giaban)/100)
            $('input[name=giagiam]').val(number_format(giagiam));
        }
    });
    
    $('input[name=btnsubmit]').click(function(){
        var tensp = $('input[name=tensp]').val();
        var idcat = $('select[name=idcat]').val();
        var giaban = $('input[name=giaban]').val();
        //var mota = $('.cke_wysiwyg_frame').contents().find('.cke_editable').html()
        var checked_hinh_chinh = $('input[type=radio]').is(':checked');
        if(tensp == "")
        {
            ThongBaoLoi('Nhập tên sản phẩm');
            return false;
        }
        if(giaban == "" || giaban == '0')
        {
            ThongBaoLoi('Nhập giá bán');
            return false;
        }
        if(checked_hinh_chinh == false)
        {
            ThongBaoLoi('Chọn hình chính');
            return false;
        }
        if(idcat == 0)
        {
            ThongBaoLoi('Chọn danh mục sản phẩm');
            return false;
        }
        else
        {
            $('#form_update_sanpham').submit();
            /*
            $.ajax({
                url:taaa.appdomain+'/admin/product/checkhavechildcat',
                type:'post',
                data:{idcat:idcat},
                success:function(data){
                    if(data > 0)
                    {
                        ThongBaoLoi('Danh mục này đang chứa danh mục con nên không thể chọn danh mục cha này');
                        return false;
                    }
                    else
                    {
                        $.ajax({
                            url:taaa.appdomain+'/admin/product/xulyupdate',
                            type:'post',
                            data:$("form#form_update_sanpham").serialize(),
                            success:function(data){
                                //alert(data); return false;
                                
                                if(data == 1)
                                {
                                    ThongBao('Cập nhật sản phẩm thành công',2000);
                                    //window.location = '../product';
                                }
                                else
                                {
                                    ThongBaoLoi('Cập nhật sản phẩm không thành công');
                                    return false;
                                }
                                
                            }
                        });
                    }
                }
            });
            */
        }
    });
    
});

function download_photo_fb(status, count_photo)
{
    $('#popup_content').fadeIn();
    var loading = taaa.appdomain + '/application/templates/giaodien_admin/images/ajax-loader.gif';
    var html = '<div class="header_popup_content">Chọn hình đại diện cho sản phẩm<p onclick="close_popup()" class="close_popup"><img src="'+taaa.appdomain+'/application/templates/giaodien_admin/images/delete.png"/></p></div><div class="popup_content"><img class="loading" alt="loading..." src="'+loading+'"/></div>';
    $('#popup_content').html(html);
    $.ajax({
            url:taaa.appdomain+'/admin/product/getalbumfb',
            type:'post',
            data:{status:status, count_photo:count_photo},
            success:function(data){
                //$('#popup_content').fadeIn();
                $('#popup_content').html(data);
                window.scroll(0,0);
                FB.Canvas.scrollTo(0,0);
            }
        });
}

function number_format (number, decimals, dec_point, thousands_sep) {
	// Strip all characters but numerical ones.
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number,
		prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		dec = (typeof dec_point === 'undefined') ? '' : dec_point,
		s = '',
		toFixedFix = function (n, prec) {
			var k = Math.pow(10, prec);
			return '' + Math.round(n * k) / k;
		};
	// Fix for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('');
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1).join('0');
	}
	return s.join(dec);
}

function show_photo_facebook(status, count_photo)
{
    if(status == 'add')
    {
        var content_table = $('table.show_photo_fb').html().trim();
        if(content_table == "")
            var ct_table = '1';
        else
            var ct_table = '2';
            
        var rowCount = $('.show_photo_fb tr').length;
        $.ajax({
            url:taaa.appdomain+'/admin/product/showphotofb',
            type:'post',
            data:$("form#form_list_image_fb").serialize()+"&stt="+rowCount+"&ct_table="+ct_table,
            success:function(data){
                if(data == 0)
                {
                    $('.warning').show();
                    setTimeout(function(){$('.warning').fadeOut();},2000);
                }
                else
                {
                    $('table.show_photo_fb').append(data);
                    $('#popup_content').fadeOut();
                    $('a[name=save_add_product]').show();
                }
                
            }
        });
    }
    else
    {
        $.ajax({
            url:taaa.appdomain+'/admin/product/showphotofbupdate',
            type:'post',
            data:$("form#form_list_image_fb").serialize()+"&count_photo="+count_photo,
            success:function(data){
                if(data == 0)
                {
                    $('.warning').show();
                    setTimeout(function(){$('.warning').fadeOut();},2000);
                }
                else
                {
                    $('ul.ul_list_img_fb').append(data);
                    $('#popup_content').fadeOut();
                }
            }
        });
    }
    
}



function ChangeListPage(idpage)
{
	if(idpage != 0)
		window.location = "?idpage="+idpage;
}

/*
function LoginAdmin(ops)
{
    UserAdmin = ops.useradmin;
    PassAdmin = ops.passadmin;
    
    //alert(UserAdmin);
    //alert(PassAdmin);
    
    $.ajax({
		url:taaa.appdomain + '/admin/login/xulylogin',
		type:'post',
		data:{useradmin: UserAdmin, passadmin:PassAdmin},
		success:function(data){
			if(data==1)
            {
                alert("Đăng nhập thành công");
				var link = taaa.appdomain+'/admin/category/';
				window.location = link;
            }
            else
                alert("Đăng nhập không thành công");
		}
	});	
}
*/

function checkmail(email){
	var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
	var returnval=emailfilter.test(email)
	return returnval;
}

//Kiem tra SDT
function checkphone(phone)
{
	if(phone.length<10)
		return false;
	var phonefilter = /^[0-9]+$/;
	var returnval = phonefilter.test(phone);
		return returnval;
}




function RegisterAdmin(ops)
{

	IdUserFb = ops.iduser_fb;
	UserAdmin = ops.useradmin;
    PassAdmin = ops.passadmin;
    RePassAdmin = ops.repassadmin;
    HoTenAdmin = ops.hotenadmin;
    EmailAdmin = ops.emailadmin;
    DienThoaiAdmin = ops.dienthoaiadmin;
	

    //alert(UserAdmin);
    // alert(PassAdmin);
    // alert(RePassAdmin);
    // alert(HoTenAdmin);
    // alert(EmailAdmin);
    // alert(DienThoaiAdmin);

	if(UserAdmin=="" || PassAdmin=="" || RePassAdmin=="" || HoTenAdmin=="" || EmailAdmin=="" || DienThoaiAdmin=="")
	{
		document.getElementById('warning_register').innerHTML = "Vui lòng nhập đủ thông tin.";
		return false;
	}
	else
	{
		if(PassAdmin.length < 6)
		{
			document.getElementById('warning_register').innerHTML = "Mật khẩu nhập tối thiểu 6 ký tự.";
			return false;
		}
		else
			if(PassAdmin != RePassAdmin)
			{
				document.getElementById('warning_register').innerHTML = "2 mật khẩu không giống nhau.";
				return false;
			}
			else
				if(checkmail(EmailAdmin)==false)
				{
					document.getElementById('warning_register').innerHTML = "Email chưa đúng định dạng.";
					return false;
				}
				else
					if(checkphone(DienThoaiAdmin)==false)
					{
						document.getElementById('warning_register').innerHTML = "Số điện thoại chưa đúng định dạng.";
						return false;
					}
					else
					{
						document.getElementById('warning_register').innerHTML = "";
					}
	}
	
	kiemtraTenDangNhap(UserAdmin);

}

function kiemtraTenDangNhap(UserName)
{

	$.ajax({
		url:taaa.appdomain + '/admin/register/kiemtratendangnhap',
		type:'post',
		data:{username: UserName},
		success:function(data){
			if(data==0)
			{
				document.getElementById('warning_register').innerHTML = "Tên đăng nhập này đã có người đăng ký.";
				return false;
			}
			else
			{
				$.ajax({
				url:taaa.appdomain + '/admin/register/xulyregister',
				type:'post',
				data:{iduserfb:IdUserFb, useradmin: UserAdmin, passadmin:PassAdmin, hotenadmin:HoTenAdmin, emailadmin:EmailAdmin, dienthoaiadmin:DienThoaiAdmin},
				success:function(data){
						if(data==1)
						{
							ThongBaoLoi2("Đăng ký thành công");
						}
						else
							ThongBaoLoi("Đăng ký không thành công");
					}
				});

			}
			
		}
	});

}

function kiemtraIdUserFB(IdUserFB)
{
	$.ajax({
		url:taaa.appdomain + '/admin/register/kiemtraiduserfb',
		type:'post',
		data:{IdUserFB: IdUserFB},
		success:function(data){
			if(data!=1)
            {
				ThongBaoLoi2("IDFB : "+data+"<br/>Tài khoản FB này đã tạo tài khoản<br/>Nếu bạn quên mật khẩu hãy liên hệ với Admin");
            }
		}
	});
}




function getParameterValue(name)
{
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( window.location.href );
	if( results == null ) return "";
	else return results[1];
}


function ThongBao(nd,time)
{
	$('#bg_thongbao').show();
	$('#thongbao').show();
	$('#thongbao').html("<p class='title_tb'>Thông Báo</p><div class='content_tb'>"+nd+"</div>");
	myVar = setTimeout(function(){$('#thongbao').hide(); $('#bg_thongbao').hide();return false},time);
}

function ThongBaoLoi(nd)
{
    $('#bg_thongbao').show();
	$('#thongbao').show(); 
	$('#thongbao').html("<p class='title_tb'>Thông Báo</p><div class='content_tb'><p>" +nd+ "</p><p class='dong_thongbao close_thongbao'>Đóng</p>");
	//myVar = setTimeout(function(){$('#thongbao').hide(); $('#bg_thongbao').hide();return false},time);
    scrollToTop();
}

function ThongBaoLoi2(nd)
{
    $('#bg_thongbao').show();
	$('#thongbao').show(); 
	$('#thongbao').html("<p class='title_tb'>Thông Báo</p><div class='content_tb'><p>" +nd+ "</p><p class='dong_thongbao close_thongbao2'>Đóng</p>");
	//myVar = setTimeout(function(){$('#thongbao').hide(); $('#bg_thongbao').hide();return false},time);
    scrollToTop();
}

function ThongBaoLoi3(nd)
{
    $('#bg_thongbao').show();
	$('#thongbao').show(); 
	$('#thongbao').html("<p class='title_tb'>Thông Báo</p><div class='content_tb'><p>" +nd+ "</p><p class='dong_thongbao close_thongbao3'>Đóng</p>");
	//myVar = setTimeout(function(){$('#thongbao').hide(); $('#bg_thongbao').hide();return false},time);
    scrollToTop();
}

function ThongBaoDongY(nd, link)
{
    $('#bg_thongbao').show();
	$('#thongbao').show(); 
	$('#thongbao').html("<p class='title_tb'>Thông Báo</p><div class='content_tb'><p>" +nd+ "</p><p class='dong_thongbao' onclick=\"CloseThongBaoDongY('"+link+"')\">Đóng</p>");
    scrollToTop();
}

function CloseThongBaoDongY(link)
{
	$('#thongbao').hide(); 
	$('#bg_thongbao').hide();
	//window.location = link;
	top.location.href = link;
    scrollToTop();
}

function ThemLoaiSanPham(parent_id, tenlsp, vitri, anhien)
{
    if(anhien==true) anhien=1; else anhien = 0;

    if(tenlsp=="")
    {
        ThongBaoLoi('Tên loại sản phẩm không được để trống');
        return false;
    }
    if(isNaN(vitri) == true)
    {
        ThongBaoLoi('Vị trí không hợp lệ');
        return false;
    }
    $.ajax({
        url:taaa.appdomain+'/admin/category/xulyadd',
        type:'post',
        data:{parent_id:parent_id, tenlsp:tenlsp, vitri:vitri, anhien:anhien},
        success:function(data){
            //alert(data);return false;
            if(data==1)
            {
                ThongBao('Thêm mới loại sản phẩm thành công',2000);
                window.location = '../category';
            }
            else
                ThongBaoLoi('Thêm mới không thành công');
        }
        
    });

   
}

function CapNhatLoaiSanPham(parent_id, idcategory, tenlsp, vitri, anhien)
{
    if(anhien==true) anhien=1; else anhien = 0;
    
    if(tenlsp=="")
    {
        ThongBaoLoi('Tên loại sản phẩm không được để trống');
        return false;
    }
    if(isNaN(vitri) == true)
    {
        ThongBaoLoi('Vị trí không hợp lệ');
        return false;
    }
    $.ajax({
        url:taaa.appdomain+'/admin/category/xulyupdate',
        type:'post',
        data:{parent_id:parent_id, idcategory:idcategory, tenlsp:tenlsp, vitri:vitri, anhien:anhien},
        success:function(data){
            //alert(data);
           
            if(data==1)
            {
                ThongBao('Cập nhật loại sản phẩm thành công',2000);
                window.location = '../category';
            }
            else
                ThongBaoLoi('Cập nhật không thành công');
            
        }
        
    });
}

function ThemMoiSanPham(masp, tensp, thuocloaisp, giaban, giagiam, sale_off, spmoi, string_img_upload, string_img_upload_ch, mota, hethang, anhien, showindex, titlefb, metafb)
{
    /*
    alert(masp);
    alert(tensp);
    alert(thuocloaisp);
    alert(giaban);
    alert(giagiam);
    alert(sale_off);
    alert(spmoi);
    alert(string_img_upload);
    alert(string_img_upload_ch);
    alert(mota);
    alert(hethang);
    alert(anhien);
    alert(showindex);
    alert(titlefb);
    alert(metafb);
    return false;
    */
    if(anhien==true) anhien=1; else anhien = 0;
    if(hethang==true) hethang=1; else hethang = 0;
    if(showindex==true) showindex=1; else showindex = 0;
    if(spmoi==true) spmoi=1; else spmoi = 0;
    
    if(tensp == "")
    {
        document.getElementById('tensp').focus();
        ThongBaoLoi('Tên sản phẩm không được để trống');
		return false;
    }
    if(thuocloaisp == 0)
    {
        document.getElementById('thuocloaisp').focus();
        ThongBaoLoi('Chọn loại sản phẩm');
		return false;
    }
    if(giaban == "")
    {
        document.getElementById('giaban').focus();
        ThongBaoLoi('Giá bán không được để trống');
		return false;
    }
    
    $.ajax({
        url:taaa.appdomain+'/admin/product/xulyadd',
        type:'post',
        data:{masp:masp, tensp:tensp, thuocloaisp:thuocloaisp, giaban:giaban , giagiam:giagiam , sale_off:sale_off , spmoi:spmoi ,string_img_upload:string_img_upload, string_img_upload_ch:string_img_upload_ch, mota:mota, hethang:hethang, anhien:anhien, showindex:showindex, titlefb:titlefb, metafb:metafb},
        success:function(data){
            if(data==1)
            {
                ThongBao('Thêm mới sản phẩm thành công',2000);
                window.location = '../product';    
            }
            else
                ThongBaoLoi('Thêm mới không thành công');
            
        }
        
    });
  
    
}




function delete_category(idCat)
{
    var conf = confirm('Bạn có chắc chắc muốn xóa!');
    if(conf == true)
    {
        $.ajax({
            url:taaa.appdomain+'/admin/category/delete',
            type:'post',
            data:{idCat:idCat},
            success:function(data){
                if(data == 'ko')
                {
                    ThongBaoLoi('Vẩn còn sản phẩm thuộc danh mục này');
                    return false;
                }
                if(data == 'koo')
                {
                    ThongBaoLoi('Vẩn còn danh mục con thuộc danh mục này');
                    return false;
                }
                if(data == '1')
                {
                    location.reload();
                }
                
            }
        });
    } 
    else
    {
        return false;
    }
}

function DeleteProduct(idsp)
{
    var flag = confirm('Bạn có chắc chắn muốn xóa sản phẩm này');
    if(flag==true)
    {
        $.ajax({
            url:taaa.appdomain+'/admin/product/xulydelete',
            type:'post',
            data:{idsp:idsp},
            success:function(data){
               
                if(data==1)
                    ThongBao('Xóa sản phẩm thành công',2000);
                else
                    ThongBaoLoi('Xóa không thành công');
                    
                location.reload();
                
            }
            
        });
    }
    else
        return false;
}

function SearchCategory(idcat)
{
    if(idcat == -1)
    {
        return false;
    }
    if(idcat == 0)
    {
        window.location = 'product';
    }
    else
        window.location = 'product?idcat=' + idcat;
}

function searchProduct(event, keyword)
{
    keyword = keyword.trim();
    keyword = keyword.replace(/ /g, "_");
    var key = event.keyCode || event.charCode;//13
    if(key == 13)//Nhan Enter
    {
        window.location = 'search?key=' + keyword;
    }
    return false;   
}

//Get URL
function getParameterValue(name)
{
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( window.location.href );
	if( results == null ) return "";
	else return results[1];
}

function LoginAdmin(user, pass)
{
    //alert(user);
    //alert(pass);

    $.ajax({
        url:taaa.appdomain+'/admin/login/xulylogin',
        type:'post',
        data:{user:user, pass:pass},
        success:function(data){
            if(data==1)
            {
                ThongBao('Đăng nhập thành công',2000);
				var link = taaa.fbappdomain+'/admin/';
                //window.location = link;
				top.location.href = link;
            }
            else
            {
                ThongBaoLoi('Đăng nhập không thành công');
                return false;    
            }
        }
    });
}

function DangXuat()
{
    var flag = confirm('Bạn có chắc chắn muốn đăng xuất');
    if(flag==true)
        window.location = taaa.appdomain+'/admin/login/dangxuat';
    else
        return false;
}


function ChangePass(iduserfb, oldpass, newpass, newrepass)
{
	//alert(iduserfb);
	//alert(oldpass);
	//alert(newpass);
	//alert(newrepass);
	
	if(oldpass == "" || newpass == "" || newrepass == "")
	{
		document.getElementById('warning').innerHTML = 'Vui lòng nhập đủ thông tin.';
		return false;
	}
	else
	{
		if(newpass.length<6)
		{
			document.getElementById('warning').innerHTML = 'Mật khẩu mới tối thiểu 6 ký tự.';
			return false;
		}
		else
		{
			if(newpass != newrepass)
			{
				document.getElementById('warning').innerHTML = 'Nhập lại mật khẩu mới chưa giống nhau.';
				return false;
			}
		}
	}
	
	$.ajax({
        url:taaa.appdomain+'/admin/changepass/xulychangepass',
        type:'post',
        data:{iduserfb:iduserfb, oldpass:oldpass, newpass:newpass, newrepass:newrepass},
        success:function(data){
            if(data==-1)
			{
				document.getElementById('warning').innerHTML = 'Mật khẩu cũ chưa đúng.';
				return false;
			}
			if(data==0)
			{
				document.getElementById('warning').innerHTML = 'Đổi mật khẩu chưa thành công, vui lòng thực hiện lại thao tác.';
				return false;
			}
			if(data==1)
			{
				ThongBaoLoi2("Thay đổi mật khẩu thành công.<br/>Bạn cần phải đăng nhập lại");
				return false;
			}
			
        }
    });
	
}

function LuuThongTinSP(idsp, keytab, noidung)
{
	alert(idsp);
	alert(keytab);
	alert(noidung);
	//alert('12345679');
	//return false;
}

function customerLoadWindow(pageURL, title,w,h) {

	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}

function openChangeStCart(class_name)
{
    //alert(class_name);
    $('.'+class_name).toggle();
}



function deleteCart(idCart)
{
    var flag = confirm('Bạn có chắc chắn muốn xóa đơn hàng này');
    if(flag==true)
    {
       $.ajax({
            url:taaa.appdomain+'/admin/cart/deletecart',
            type:'post',
            data:{idCart:idCart},
            success:function(data){
                if(data == 1)
                {
                    window.location.reload();
                }
                else
                {
                    alert(data);
                }
    			
            }
        }); 
    }
    else
    {
        return false;
    }
}

function filterStatusCart(status)
{
    if(status == "")
        link = taaa.appdomain+"/admin/cart";
    else
        link = taaa.appdomain+"/admin/cart?st="+status;
    window.location = link
    
}


function searchOrder(event, keyword)
{
	keyword = keyword.trim();
	keyword = keyword.replace(/ /g, "_");
	var key = event.keyCode || event.charCode;//13
    if(key == 13)//Nhan Enter
    {
		if(keyword == "")
			link = taaa.appdomain+"/admin/cart";
		else 
			link = taaa.appdomain+"/admin/cart/search?keyword="+keyword;
	}
	window.location = link
}

function viewCart(idCart)
{
    //alert(idCart);return false;
    change_status_has_view_cart(idCart);
       $.ajax({
            url:taaa.appdomain+'/admin/cart/viewcart',
            type:'post',
            data:{idCart:idCart},
            success:function(data){
                $('#popup_content').fadeIn();
                $('#popup_content').html(data);
                //window.scroll(0,0);
                FB.Canvas.scrollTo(0,0);
            }
        }); 
}


function ChangeStCart(idCart, status, text)
{
    $.ajax({
        url:taaa.appdomain+'/admin/cart/changestatus',
        type:'post',
        data:{idCart:idCart, status:status},
        success:function(data){
            if(data == 1)
            {
                $('.status_cart_'+idCart).removeClass('orange');
                $('.status_cart_'+idCart).removeClass('green');
                $('.status_cart_'+idCart).removeClass('grey');
                if(status == 1) $('.status_cart_'+idCart).addClass('green');
                if(status == 2) $('.status_cart_'+idCart).addClass('grey');
                $('.status_cart_'+idCart).html(text);
                $('.st_cart').fadeOut();
            }
            else
            {
                alert(data);
            }
			
        }
    });
}

function change_status_has_view_cart(idCart)
{
    $.ajax({
        url:taaa.appdomain+'/admin/cart/changestatus2',
        type:'post',
        data:{idCart:idCart},
        success:function(data){
            if(data == 1)
            {
                $('.status_cart_'+idCart).removeClass('orange');
                $('.status_cart_'+idCart).removeClass('green');
                $('.status_cart_'+idCart).removeClass('grey');
                $('.status_cart_'+idCart).addClass('green');
                $('.status_cart_'+idCart).html('Chưa giao');
            }
            else
            {
                return false;
            }
			
        }
    });
}

function close_popup()
{
    $('#popup_content').fadeOut();
}

function scrollToTop()
{
    window.scrollTo(0,0);
	FB.Canvas.scrollTo(0,0);
}

