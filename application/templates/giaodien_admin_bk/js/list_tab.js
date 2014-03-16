$(document).ready(function(){
/*
	$('.menu_tab').click(function(){
		var nameid = $(this).attr('id');
		$('.menu_tab').removeClass('active');
		$('#'+nameid).addClass('active');
		ShowContentTab(nameid);
	});
*/
});

function ChangeTabActive(idsp, nameid)
{
	$('.menu_tab').removeClass('active');
	$('#'+nameid).addClass('active');
	$link = taaa.appdomain + '/admin/product/thongtinsanpham?idsp='+idsp+'&keytab='+nameid;
	window.location = $link;
}

function ShowContentTab(idsp, idtab)
{
	//alert(idsp);
	//alert(idtab);
	$.ajax({
		url:taaa.appdomain+'/admin/product/thongtinsanphamxuly',
		type:'post',
		data:{idsp:idsp, idtab:idtab},
		success:function(data){
			document.getElementById('ctn_tab').value = data;
		}
	});	
}

