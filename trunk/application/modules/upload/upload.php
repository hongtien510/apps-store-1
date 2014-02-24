<?php
session_start();
$act = @$_POST['act'];
if(!isset($act)) $act ="";
function replace($str)
{
	$find = array(' ', '.');
	return str_replace($find,'',$str);
}

if($act ==""){
   $sl = count($_FILES['images']['name']);
	if(!isset($_SESSION['sl_old']))
	{
	$j=0;
		for($i = 0; $i<$sl; $i++)
		{
			$name_old = $_FILES["images"]["name"][$i];
			$name = time().'_'.$name_old;
			move_uploaded_file( $_FILES["images"]["tmp_name"][$i], "../../layouts/tmpstore/images/upload/images/" . $name);
			$array[$j]['name_old'] = $name_old;
			$array[$j]['name'] = $name;
			$array[$j]['class'] = replace($name);
			$j++;
		}
		$_SESSION['sl_old']=$sl;
		echo json_encode($array);
		
	}else
	{
	if($_SESSION['sl_old'] >= $sl)$_SESSION['sl_old']=0;
	$j=0;
		for($i = $_SESSION['sl_old']; $i<$sl; $i++)
		{
			$name_old = $_FILES["images"]["name"][$i];
			$name = time().'_'.$name_old;
			move_uploaded_file( $_FILES["images"]["tmp_name"][$i], "../../layouts/tmpstore/images/upload/images/" . $name);
			$array[$j]['name_old'] = $name_old;
			$array[$j]['name'] = $name;
			$array[$j]['class'] = replace($name);
			$j++;
		}
		$_SESSION['sl_old']=$sl;
		echo json_encode($array);
	}
}
if($act =="del_img_upload")
{
	$arr_img_ul = $_POST['arrimg'];
	$image = $_POST['image'];
	if(file_exists('../../layouts/tmpstore/images/upload/images/'.$image)){
		unlink('../../layouts/tmpstore/images/upload/images/'.$image);
		foreach ($arr_img_ul as $k => $v){
			if($arr_img_ul[$k]==$image)
				unset($arr_img_ul[$k]);
		}
	}
	$kq = array('classimg'=>replace($image), 'arr_img_ul'=>$arr_img_ul);
	echo json_encode($kq);
	
}
if($act =="get_img_upload")
{
	$arr_img_ul = @$_POST['arrimg'];
	//print_r($arr_img_ul);
	$str_img_ul = "";
	if(isset($arr_img_ul)){
	foreach ($arr_img_ul as $k => $v){
		if($v!='undefined' || $v!=""){
			$str_img_ul .= ','.$v;
		}
	}
	echo $str_img_ul = substr($str_img_ul,1,strlen($str_img_ul));
	}
}
if($act =="count_img_upload")
{
    
    $dem=0;
    
	$arr_img_ul = @$_POST['arrimg'];
	//echo count($arr_img_ul);
    //for($i=0; $i<count($arr_img_ul); $i++)
    //   if($arr_img_ul[$i]!="")
    //       $dem++;
    print_r($arr_img_ul);       
    echo $count = count($arr_img_ul);
    //$kq = array('count'=>$count);
	//echo json_encode($kq);
}
