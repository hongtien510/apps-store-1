$(document).ready(function(){
	$('img.hinhphu1').click(function(){
		var source = $('img.hinhphu1').attr("src");
		//alert (source);
		$('img.hinhchinh').attr("src", source);
	});
	$('img.hinhphu2').click(function(){
		var source = $('img.hinhphu2').attr("src");
		//alert (source);
		$('img.hinhchinh').attr("src", source);
	});	
	$('img.hinhphu3').click(function(){
		var source = $('img.hinhphu3').attr("src");
		//alert (source);
		$('img.hinhchinh').attr("src", source);
	});	
	$('img.hinhphu4').click(function(){
		var source = $('img.hinhphu4').attr("src");
		//alert (source);
		$('img.hinhchinh').attr("src", source);
	});	
	$('img.hinhphu5').click(function(){
		var source = $('img.hinhphu5').attr("src");
		//alert (source);
		$('img.hinhchinh').attr("src", source);
	});
    
    $('.order').click(function(){
        
        $('#dathang').show();
    });
    
    $('.close_dathang').click(function(){
        
        $('#dathang').hide();
    });
    
	$('.close_thongbao').click(function(){
		$('#thongbao').hide();
	});
	
	
	
});

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



function DatHang(hoten, sdt, email, diachi, ghichu, sanpham)
{
    /*
    alert(hoten);
    alert(sdt);
    alert(email);
    alert(diachi);
    alert(ghichu);
    alert(sanpham);
    */
    if(hoten == "" || sdt == "" || email == "" || diachi == "")
    {
        document.getElementById("warning").innerHTML = "Bạn chưa nhập đủ thông tin";
        return false;
    }
    else
    {
        if(checkphone(sdt)==false)
        {
            document.getElementById("warning").innerHTML = "Số điện thoại không đúng";
            return false;
        }
        else
            if(checkmail(email)==false)
            {
                document.getElementById("warning").innerHTML = "Email không đúng";
                return false;
            }
    }

	
	document.getElementById("warning").innerHTML = "<span style='color:#00ccff'>Sending Email...</span><img class='loader' src='"+taaa.appdomain+"/application/layouts/tmpstore/images/loader.gif'/>";

	//alert(taaa.appdomain + '/ajax');
	$.ajax({
		//url:taaa.appdomain + '/ajax',
		url:'/appfb/ishalistore/ajax',
		type:'post',
		data:{hoten:hoten, sdt:sdt, email:email, diachi:diachi, ghichu:ghichu, sanpham:sanpham},
		success:function(data){
			var obj = jQuery.parseJSON(data);
			if(obj.result==1)
			{
				$('#dathang').hide();
				ThongBao('Gửi Mail thành công.<br/>Bạn kiểm tra mail trong hộp thư đến, hoặc trong Spam');
				document.getElementById("warning").innerHTML = "<span style='color:#00ccff'>Gửi Email thành công<br/>Chúng tôi sẽ liên hệ tới bạn sớm nhất</span>";
            }
			else
                document.getElementById("warning").innerHTML = "Gửi Email không thành công<br/>Bạn hãy thử thực hiện lại thao tác";
		}
	});
	
}


function ThongBao(nd)
{
	$('#nd_thongbao').html(nd);
	$('#thongbao').show();
}

function danglentuong_bk(title, cap, des, link, pic) {
	FB.ui(
	  {
		method: 'feed',
		name: title,
		link: link,
		caption: cap,
		picture: pic,
		message: 'Message',
		description: des
	  }
	);
}

function danglentuong(title, cap, des, link, pic) {
	/* FB.ui(
	  {
		method: 'feed',
		name: title,
		link: link,
		caption: cap,
		picture: pic,
		message: 'Message',
		description: des
	  }
	); */
	alert(FB);
}


function ChangeTabActive(idsp, idtab, bg1, co1, bg2, co2)
{
	$('.menu_tab').removeClass('active');
	$('#'+idtab).addClass('active');
	
	changeColorTab(bg1, co1, bg2, co2);
	ShowContentTab(idtab);
}

	// $("ul.ul_list_tab li").css("background","#f0f0f0");
	// $("ul.ul_list_tab li").css("color","#000000");
	// $("ul.ul_list_tab li").css("border-color","#ffd000");
	
	// $("ul.ul_list_tab li.active").css("background","#ffd000");
	// $("ul.ul_list_tab li.active").css("color","#ffffff");
	// $(".ctn_tab").css("border-color","#ffd000");
	// $(".list_tab").css("border-bottom-color","#ffd000");

function changeColorTab(bg1, co1, bg2, co2)
{
	
	$("ul.ul_list_tab li").css("background",bg1);
	$("ul.ul_list_tab li a").css("color",co1);
	$("ul.ul_list_tab li").css("border-color",bg2);
	
	$("ul.ul_list_tab li.active").css("background",bg2);
	$("ul.ul_list_tab li.active a").css("color",co2);
	$(".ctn_tab").css("border-color",bg2);
	$(".list_tab").css("border-bottom-color",bg2);
}

function ShowContentTab(idtab)
{
/*
	$.ajax({
		url:taaa.appdomain+'/product/thongtinsanphamxuly',
		type:'post',
		data:{idsp:idsp, idtab:idtab},
		success:function(data){
			document.getElementById('ctn_tab').innerHTML = data;
		}
	});
*/
	//alert('12345');
	$('.ctn_tab').hide();
	$('#ctn_tab'+idtab).show();
}





















