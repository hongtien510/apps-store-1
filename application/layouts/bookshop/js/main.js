$(document).ready(function(){
    $(function(){
      autoCenter()
        $(window).resize(function(){autoCenter()})
        function autoCenter(){
            var windowWidth = $(window).width();
            var windowHeight = $(window).height();
            var widthPopup = $('.ctn-msg').width();
            var heightPopup = $('.ctn-msg').height();
            var leftPopup = (windowWidth - widthPopup)/2;
            var topPopup = (windowHeight - heightPopup)/4;
			$('.ctn-msg').css({"left":leftPopup});
            $('.ctn-msg').css({"top":topPopup});
        }
    });
    
    $("input[name='button-dathang']").click(function(){
        var name = $("#name").val();
        var phone = $("#phone").val();
        var email = $("#email").val();
        var city = $("#city").val();
        var district = $("#district").val();
        var address = $("#address").val();
        var idpage = $('#idpage').val();
        var comment = $('#comment').val();

        var status = 0;
        if(name == "" || phone == "" || email == "" || city == "" || district == "" || address == "")
        {
            $('.message').html("<span class='warning'>Bạn vui lòng nhập đầy đủ thông tin</span>");
            return false;
        }
        else
        {
            if(!checkphone(phone))
            {
                $('.message').html("<span class='warning'>Số điện thoại không đúng</span>");
                return false;
            }
            if(!checkmail(email))
            {
                $('.message').html("<span class='warning'>Email không đúng</span>");
                return false;
            }
            status = 1;
            var loading = APP_DOMAIN + '/application/layouts/bookshop/images/loader.gif';
            $('.message').html("<img src='"+loading+"'/>");
        }
        if(status == 1)
        {
            $.ajax({
				url:APP_DOMAIN + '/ajax/dathang',
				type:'post',
				data:{idpage:idpage, name:name, phone:phone, email:email, city:city, district:district, address:address, comment:comment},
				success:function(data){
                    if(data == 1)
                    {
                        $("#name").val("");
                        $("#phone").val("");
                        $("#email").val("");
                        $("#city").val("");
                        $("#district").val("");
                        $("#address").val("");
                        $('#idpage').val("");
                        $('#comment').val("");
                        $('.message').html("<span class='success'>Gửi Email thành công</span>");
                        var nd = "Đặt hàng thành công.<br/>Gửi Email thành công";
                        var link = APP_DOMAIN +'?idpage='+ idpage;
                        showMessage(nd, link);
                    }
                    else
                    {
                        $('.message').html("<span class='warning'>Gửi Email không thành công</span>");
                        return false;
                    }
				}
			});
        }
    });
    
    $("select[name='sort']").change(function(){
        var sort = $(this).val();
        var tab = getParameterValue('tab');
        var ltab = "";
        if(tab != "")
            ltab = '&tab='+tab;
        
        //alert(ID_PAGE);
        var controller = $('.controllerName').html();
        var page = $('.getPageSort').html();
        var id = $('.getIdCategory').html();
        var idp = $('.getIdParent').html();
        
        var _id = "";
        if(id != "")
        {
            _id = "&id="+id;
        }
        var _idp = "";
        if(idp != "")
        {
            _idp = "&idp="+idp;
        }
        /*
        alert(controller);
        alert(page);
        alert(id);
        alert(idp);
        return false;
        */
        if(controller == 'index')
        {
            var link = APP_DOMAIN +"/"+ controller +"?idpage="+ ID_PAGE +ltab+"&sort="+ sort;
            window.location = link;
        }
        if(controller == 'category')
        {
            var link = APP_DOMAIN +"/"+ controller +"?idpage="+ ID_PAGE +ltab+"&sort="+ sort + _id + _idp;
            window.location = link;
        }
    });
    
    $('.refesh').click(function(){
        location.reload();
    });
    
    $('.next').click(function(){
        //alert('next');
    });
    
    $('.back').click(function(){
        window.history.back();
    });
    
    $('.btn_find_cart').click(function(){
        var key = $('input[name=key_find_cart]').val();
        var act = "";
        if(checkmail(key) == true)
        {
            act = "email";
        }
        else
        {
            if(checkphone(key) == true)
            {
                act = "phone";
            }
            else
            {
                if(key.substring(0,2) == "DH")
                {
                    act = "dh";
                }
                else
                {
                    act = "other";
                }
            }
        }
        if(act == "other")
        {
            $('input[name=key_find_cart]').val('');
            $('p.warning').html('Dữ liệu nhập vào không không đúng định dạng');
            setTimeout(function(){$('p.warning').html('');},3000);
            return false;
        }
        var link = APP_DOMAIN +"/giohang/list?idpage="+ ID_PAGE +"&act="+ act +"&key="+ key +"&menu=4";
        window.location = link;
    });
    
});

//Kiem tra Email
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

function muahang(idsp)
{
    var soluong = $("select[name='amount']").val();
    //var size = $("select[name='size']").val();
    if(soluong === undefined) soluong = 1;
    //if(size === undefined) size = 'M';

    $.ajax({
		url:APP_DOMAIN + '/ajax/muahang',
		type:'post',
		data:{idsp:idsp, soluong:soluong},
		success:function(data){
            //alert(data);return false;
           var link = APP_DOMAIN + '/giohang?idpage=' + ID_PAGE;
           window.location = link;
		}
	});
}

function muahang_bk(idsp)
{
    var soluong = $("select[name='amount']").val();
    var size = $("select[name='size']").val();
    if(soluong === undefined) soluong = 1;
    if(size === undefined) size = 'M';

    $.ajax({
		url:APP_DOMAIN + '/ajax/muahang',
		type:'post',
		data:{idsp:idsp, soluong:soluong, size:size},
		success:function(data){
		      alert(data);return false;
           var link = APP_DOMAIN + '/giohang?idpage=356730004423499';
           window.location = link;
		}
	});
}

function changeCart(event, idsp)
{
    soluong = $('#sl_'+idsp).val();
    size = $('#size_'+idsp).val();

    var key = event.keyCode || event.charCode;
    if(key != 8 && key != 46)//8 va 46 la nhan nut Backspace
    {
        if(!isNaN(soluong))
        {
            $.ajax({
        		url:APP_DOMAIN + '/ajax/changecart',
        		type:'post',
        		data:{idsp:idsp, soluong:soluong, size:size},
        		success:function(data){
        		  //alert(data);
                   var link = APP_DOMAIN + '/giohang';
                   window.location = link;
        		}
        	});
        }
    }
    return false;   
}



function deleteCart(idsp)
{
    $.ajax({
		url:APP_DOMAIN + '/ajax/deletecart',
		type:'post',
		data:{idsp:idsp},
		success:function(data){
            //alert(data);
            var link = APP_DOMAIN + '/giohang';
            window.location = link;
		}
	});
}


function showMessage(content, link)
{
    $('.bg-msg').show();
    $('.ctn-msg').show();
    $('.ctn-msg').html("<div class='header-msg'>Thông báo</div><div class='content-msg'><p class='detail-msg'>"+content+"</p><p onclick=\"closeMessage('"+link+"')\" class='close-msg'>Đóng</p></div>");

}
function showMessageNotClose(content, time)
{
    $('.bg-msg').show();
    $('.ctn-msg').show();
	$('.ctn-msg').html("<div class='header-msg'>Thông báo</div><div class='content-msg'><p class='detail-msg'>"+content+"</p></div>");
	setTimeout(function(){
		$('.bg-msg').fadeOut();
		$('.ctn-msg').fadeOut();
	},time);
}

function closeMessage(link)
{
    window.location = link;
}

function searchProduct(event, keyword)
{
    keyword = keyword.trim();
    keyword = keyword.replace(/ /g, "_");
    var key = event.keyCode || event.charCode;//13
    if(key == 13)//Nhan Enter
    {
        var link = APP_DOMAIN + '/search?key=' + keyword;
        window.location = link;
    }
    return false;   
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

