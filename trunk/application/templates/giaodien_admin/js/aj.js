function has_added_app(pageid, pagename, userid, appid, status)
{
		var link = taaa.fbappdomain + "/admin/index/installpage?pageid="+pageid+"&pagename="+pagename+"&userid="+userid+"&appid="+appid+"&status="+status;
		top.location.href = link;
}
 

