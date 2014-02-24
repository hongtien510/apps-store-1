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
    //alert(taaa.appdomain + 'ajax');
	
	$.ajax({
		url:taaa.appdomain + '/ajax',
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

function danglentuong(title, cap, des, link, pic) {
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
























