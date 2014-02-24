// holds an instance of XMLHttpRequest 
var xmlHttp = createXmlHttpRequestObject(); 
 
// creates an XMLHttpRequest instance 
function createXmlHttpRequestObject()  
{ 
  // will store the reference to the XMLHttpRequest object 
  var xmlHttp; 
  // this should work for all browsers except IE6 and older 
  try 
  { 
    // try to create XMLHttpRequest object 
    xmlHttp = new XMLHttpRequest(); 
  } 
  catch(e) 
  { 
    // assume IE6 or older 
    var XmlHttpVersions = new Array("MSXML2.XMLHTTP.6.0", 
                                    "MSXML2.XMLHTTP.5.0", 
                                    "MSXML2.XMLHTTP.4.0", 
                                    "MSXML2.XMLHTTP.3.0", 
                                    "MSXML2.XMLHTTP", 
                                    "Microsoft.XMLHTTP"); 
    // try every prog id until one works 
    for (var i=0; i<XmlHttpVersions.length && !xmlHttp; i++)  
    { 
      try  
      {  
        // try to create XMLHttpRequest object 
        xmlHttp = new ActiveXObject(XmlHttpVersions[i]); 
      }  
      catch (e) {} 
    } 
  } 
  // return the created object or display an error message 
  if (!xmlHttp) 
    alert("Error creating the XMLHttpRequest object."); 
  else  
    return xmlHttp; 
}
 // HAM XU LY CHINH


function updatestatus_page(status, idpage)
{
//	document.getElementById('loading').style.display='block';
//	document.getElementById('quanlidanhsachtrang').style.display='none';
	var address=taaa.appdomain+"/ishali/index/updatestatus?status="+status+"&idpage="+idpage;
//	  alert(address);
	if(xmlHttp)
	{
		try
		{
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4)  { 
				    if (xmlHttp.status == 200) {
						try {
							var response = xmlHttp.responseText;
//							alert(response);
//							window.top.location = taaa.fbappdomain+'/admin/thisinh';
						//	window.top.location = 'http://apps.facebook.com/tochuccuocthihinh/admin/article';
							
							document.getElementById('an_hien_page_'+idpage).innerHTML=response;
//							document.getElementById('loading').style.display='none';
						}
						catch(e){
							alert("Error reading the response: " + e.toString());
						}
					}
				}
			}			
			xmlHttp.open("GET",address , true);
			xmlHttp.send(null);		
		}
		catch(e)
		{
			alert("Không thể try câp server: " + e.toString()); 
		}
	}	
}


function confirmdelpage(link)
{
	var r=confirm("Bạn chắc chắn muốn xóa trang này");
	if (r==false)
  {
		return false;
  }else
	  {
	  	window.top.location =link;
	  }
}
