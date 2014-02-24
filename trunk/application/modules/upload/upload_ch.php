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
	if(!isset($_SESSION['sl_old_ch']))
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
		$_SESSION['sl_old_ch']=$sl;
		echo json_encode($array);
		
	}else
	{
	if($_SESSION['sl_old_ch'] >= $sl)$_SESSION['sl_old_ch']=0;
	$j=0;
		for($i = $_SESSION['sl_old_ch']; $i<$sl; $i++)
		{
			$name_old = $_FILES["images"]["name"][$i];
			$name = time().'_'.$name_old;
			move_uploaded_file( $_FILES["images"]["tmp_name"][$i], "../../layouts/tmpstore/images/upload/images/" . $name);
			$array[$j]['name_old'] = $name_old;
			$array[$j]['name'] = $name;
			$array[$j]['class'] = replace($name);
			$j++;
		}
		$_SESSION['sl_old_ch']=$sl;
		echo json_encode($array);
	}
	
}
if($act =="del_img_upload")
{
	$arr_img_ul_ch = $_POST['arrimg'];
	$image = $_POST['image'];
	if(file_exists('../../layouts/tmpstore/images/upload/images/'.$image)){
		unlink('../../layouts/tmpstore/images/upload/images/'.$image);
		foreach ($arr_img_ul_ch as $k => $v){
			if($arr_img_ul_ch[$k]==$image)
				unset($arr_img_ul_ch[$k]);
		}
	}
	$class = replace($image);
	$kq = array('classimg'=>$class, 'arr_img_ul_ch'=>$arr_img_ul_ch);
	echo json_encode($kq);
}


if($act =="get_img_upload")
{
	$arr_img_ul_ch = @$_POST['arrimg'];

	$str_img_ul = "";
	if(isset($arr_img_ul_ch)){
	foreach ($arr_img_ul_ch as $k => $v){
		if($v!='undefined' || $v!=""){
			$str_img_ul .= ','.$v;
		}
	}
	echo $str_img_ul = substr($str_img_ul,1,strlen($str_img_ul));
	}
}



























