<?php

class Admin_ProductController extends App_Controller_AdminController {
    
    static $photo = array();
    
    public function init() {
        parent::init();
        $this->_SESSION=new Zend_Session_Namespace();
        
        $facebook = new Ishali_Facebook();
		$idpage = $facebook->getpageid();
        
        if(isset($idpage))
            $_SESSION['idpage'] = $idpage;
    }

    public function indexAction() {
        /*
        if(!isset($this->_SESSION->iduseradmin))
		{
			$link_login = APP_DOMAIN."/admin/login";
			header("Location:$link_login");
		}
        */
		$_SESSION['list_page'] = "1";
		
		$store = App_Models_StoreModel::getInstance();

		
		if($this->_request->getParam("idpage") != "")
        {
			$idpagee = $this->_request->getParam("idpage");
			$_SESSION['idpage'] = $idpagee;
		}
		@$idpage = $_SESSION['idpage'];
		
		$checkSessionIdpage = $store->KiemTraSessionIdPage($idpage);
		if($checkSessionIdpage == 0)
		{
			$this->view->checkSessionIdpage = $checkSessionIdpage;
		}
		else
		{
			if($this->_request->getParam("idcat") != "")
			{
			     $where_child_cat = "";
			     if($this->_request->getParam("idchildcat") != "")
                 {
                    $child_cat = $this->_request->getParam("idchildcat");
                    $where_child_cat = " and a.idloaisp = $child_cat ";
                 }
				$idcat = $this->_request->getParam("idcat");
                //Kiem tra xem danh muc nay cos danh muc con ko
                $sql = "select count(*) as count_child_cat from ishali_loaisp where parent_id = $idcat";
                $count = $store->SelectQuery($sql);
                //print_r($count);
                if($count[0]['count_child_cat'] == 0)
                {
                    $sql = "Select a.idsp, a.idloaisp, b.tenloaisp, b.parent_id, c.tenloaisp as tenloaisp_parent,  a.masp, a.tensp, a.gia, a.giagiam, a.sale_off, a.spmoi, a.hinhchinh, a.anhien, a.showindex 
                    From ishali_sanpham a, ishali_loaisp b LEFT JOIN (select idloaisp, tenloaisp from ishali_loaisp where parent_id = 0 and idpage = '$idpage') c on b.parent_id = c.idloaisp
                    Where a.idloaisp = b.idloaisp and a.idpage = '$idpage' and b.parent_id = '0' and a.idloaisp = '$idcat' $where_child_cat Order by a.idsp desc, ngaycapnhat desc";
                }
                else
                {
                    $sql = "Select a.idsp, a.idloaisp, b.tenloaisp, b.parent_id, c.tenloaisp as tenloaisp_parent,  a.masp, a.tensp, a.gia, a.giagiam, a.sale_off, a.spmoi, a.hinhchinh, a.anhien, a.showindex 
                    From ishali_sanpham a, ishali_loaisp b LEFT JOIN (select idloaisp, tenloaisp from ishali_loaisp where parent_id = 0 and idpage = '$idpage') c on b.parent_id = c.idloaisp
                    Where a.idloaisp = b.idloaisp and a.idpage = '$idpage' and b.parent_id = '$idcat' $where_child_cat Order by a.idsp desc, ngaycapnhat desc";
                }
			}
			else
			{
                $sql = "Select a.idsp, a.idloaisp, b.tenloaisp, b.parent_id, c.tenloaisp as tenloaisp_parent,  a.masp, a.tensp, a.gia, a.giagiam, a.sale_off, a.spmoi, a.hinhchinh, a.anhien, a.showindex 
                From ishali_sanpham a, ishali_loaisp b LEFT JOIN (select idloaisp, tenloaisp from ishali_loaisp where parent_id = 0 and idpage = '$idpage') c on b.parent_id = c.idloaisp
                Where a.idloaisp = b.idloaisp and a.idpage = '$idpage' Order by a.idsp desc, ngaycapnhat desc";
			}
            				
			$data = $store->SelectQuery($sql);
			$this->view->product = $data;
			
            
            
            //$list_loaisp = $store->getAllCategoryByIdPage($idpage, 0);
            //$category = $store->addCategoryIntoMenuAdmin($list_loaisp);
            
            $category = $store->getAllParentCategoryByIdPage($idpage, 0);
            $this->view->category = $category;

			
			$sql = "select donvitien, thongtinsp from ishali_config where idpage = '". $idpage ."'";
			$data = $store->SelectQuery($sql);
			if(count($data) == 0)
			{
				$donvitien = "VNĐ";
				$thongtinsp = 0;
			}
			else
			{
				if($data[0]['donvitien'] == "")
					$donvitien = "VNĐ";
				else
					$donvitien = $data[0]['donvitien'];
			}
			$this->view->donvitien = $donvitien;
		
			$this->view->checkSessionIdpage = $checkSessionIdpage;
			$this->view->idpage = $idpage;
		}
    }
	
    public function addAction() {
        $store = App_Models_StoreModel::getInstance();
        /*
        if(!isset($this->_SESSION->iduseradmin))
			header("Location:../login");
		*/
		$_SESSION['list_page'] = "0";
		
		if($this->_request->getParam("idpage") != "")
        {
			$idpagee = $this->_request->getParam("idpage");
			$_SESSION['idpage'] = $idpagee;
		}
        $idpage = $_SESSION['idpage'];

        //$list_loaisp = $store->getAllCategoryByIdPage($idpage, 0);
        //$category = $store->addCategoryIntoMenuAdmin($list_loaisp);

        $category = $store->getAllParentCategoryByIdPage($idpage, 0);
        $this->view->category = $category;
        
        $sql = "select donvitien, thongtinsp from ishali_config where idpage = '". $idpage ."'";
		$data = $store->SelectQuery($sql);
		if(count($data) == 0)
		{
			$donvitien = "VNĐ";
			$thongtinsp = 0;
		}
		else
		{
			if($data[0]['donvitien'] == "")
				$donvitien = "VNĐ";
			else
				$donvitien = $data[0]['donvitien'];
		}
		$this->view->donvitien = $donvitien;
		
    }
    
    public function getchildcatAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $store = App_Models_StoreModel::getInstance();

		if($this->_request->getParam("idpage") != "")
        {
			$idpagee = $this->_request->getParam("idpage");
			$_SESSION['idpage'] = $idpagee;
		}
        $idpage = $_SESSION['idpage'];
        
        $parent_cat_id = $_POST['parent_cat_id'];
        
        $childCategory = $store->getAllChildCategoryByIdParentCategory($idpage, $parent_cat_id);
        $option = "";
        $i = 1;
        foreach($childCategory as $k=>$v)
        {
            if($i++ == 1) $option .= "<option value='ko'>Chọn danh mục</option>";
            $option .= "<option value='{$v['idloaisp']}'>{$v['tenloaisp']}</option>";
        }
        echo $option;
    }
    
    public function getalbumfbAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $store = App_Models_StoreModel::getInstance();
        $facebook = new Ishali_Facebook();
        $idpage = $_SESSION['idpage'];
        $albums = $facebook->getAlbumsPage($idpage);
        $status = $_POST['status'];
        $count_photo = isset($_POST['count_photo']) ? $_POST['count_photo'] : "0";
        //print_r($albums);
        ?>     
                <div class="header_popup_content">
                    Chọn hình đại diện cho sản phẩm            
                    <p onclick="close_popup()" class="close_popup"><img src="<?php echo APP_DOMAIN ?>/application/templates/giaodien_admin/images/delete.png"/></p>
                </div>
                <div class="popup_content">
                    <form name="form_list_image_fb" id="form_list_image_fb" action="" method="post">
                    <div class="album">
                        <div class="choose">
    						<form action="" method="">
    							<span>chọn hình từ Album</span>
    							<select class="select_album_fb" name="">
    								<option value="ko">Chọn Album</option>
                                    <?php
                                        foreach($albums['data'] as $key=>$value)
                                        {
                                            echo "<option value='{$value['id']}'>{$value['name']}</option>";
                                        }
                                    ?> 
    							</select>
    							<div class="btn"><a onclick="show_photo_facebook('<?php echo $status ?>', '<?php echo $count_photo ?>')" href="#">Chọn</a></div>
    						</form>
    					</div>
                        <p class="warning">Chọn hình ảnh cho sản phẩm</p>
                        <img style="position: absolute; top: 73px; left:30%" class="loading_photo" alt="loading..." src="<?php echo APP_DOMAIN .'/application/templates/giaodien_admin/images/ajax-loader.gif' ?>"/>
                        <div class="list-album list_image_fb"></div>
                        </form>
                    </div>
                </div>
        <?php
    }
    
    public function getphotobyalbumAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        $store = App_Models_StoreModel::getInstance();
        $facebook = new Ishali_Facebook();
        
        $album_id = $_POST['album_id'];
        $photo = $facebook->getPhotoInAlbums("$album_id");
        $namespace = new Zend_Session_Namespace('photo');
        $namespace->data = $photo; 
        
        
        $i = 1;
        ?><ul class="ul_list_img_fb"><?php
        
        foreach($photo['data'] as $key=>$value)
        {
            $class="";
            if($i % 3 == 0) $class = "class='last'";
            ?>
                <li <?php echo $class ?>>
                    <label>
                    <p class="img_fb">
                        <img src="<?php echo $value['picture'] ?>" alt="" title="" />
                        <input type="checkbox" name="list_main_photo[]" value="<?php echo $key ?>" />
                    </p>
                    </label>
                </li>
            <?php
            $i++;
        }
        
        ?>
        </ul>
        <?php
    }
    
    public function showphotofbAction()
    {
        $store = App_Models_StoreModel::getInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        if(isset($_POST['list_main_photo']))
        {
            $list_main_photo = $_POST['list_main_photo'];
            if(count($list_main_photo) == 0)
            {
                echo '0';exit;
            }
            $key_photo = new Zend_Session_Namespace('key_photo');
            $key_photo->data = $list_main_photo; 
            
            $photo_fb = new Zend_Session_Namespace('photo');
            $photo = $photo_fb->data;
            $photo = $photo['data'];
            foreach($list_main_photo as $k=>$v)
            {
                $array_photo[$v] = $photo[$v];
            }
            
            ?>
            
            <?php
            $ct_table = $_POST['ct_table'];
            $i = $_POST['stt'];
            $i = max(1,$i);
            foreach($array_photo as $key=>$value)
            {
                if($ct_table++ == 1)
                {
            ?>
                <tr>
            		<th width="5%">Stt</th>
            		<th width="10%">Hình Ảnh</th>
            		<th width="40%">Tên sản phẩm<span style="color: red;">(*)</span></th>
            		<th width="10%">Giá</th>
            		<th width="30%">Mô tả</th>
                    <th width="5%">SP Mới</th>
            		<th width="5%">Xóa</th>
            	</tr>
            <?php
                }
            ?> 
            
            <tr>
                <td align='center'><?php echo $i ?></td>
                <td align='center'>
                    <img class="hinhchinh_product" src="<?php echo $value['source'] ?>" alt="<?php echo @$value['name'] ?>" title="<?php echo @$value['name'] ?>"/></td>
                    <input type="hidden" name="img_sp[<?php echo $i ?>]" value="<?php echo $value['source'] ?>" />
                <td align='center'>
                    <input name="name_sp[<?php echo $i ?>]" class="name_sp" type="text" name="name" value="<?php echo @$value['name'] ?>" />
                </td>
                <td align='center'>
                    <input name="price_sp[<?php echo $i ?>]" class="price_sp" type="text" name="price" value="" />
                </td>
                <td align='center'>
                    <textarea name="des_sp[<?php echo $i ?>]" class="des_sp"></textarea>
                </td>
                <td align='center'>
                    <input type="checkbox" value="1" name="new_sp[<?php echo $i ?>]" />
                </td>
                <td align='center'>
                    <a href="javascript:;" class='delete_photo_facebook' ><img src="<?php echo APP_DOMAIN . '/application/templates/giaodien_admin/images/delete.png' ?>" alt="xoa" title="Xóa Sản Phẩm"/></a>
                </td>
            </tr>
            <?php
            $i++;
            } 
        }
    }
    
    public function showphotofbupdateAction()
    {
        $store = App_Models_StoreModel::getInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        if(isset($_POST['list_main_photo']))
        {
            $list_main_photo = $_POST['list_main_photo'];
            if(count($list_main_photo) == 0)
            {
                echo '0';exit;
            }
            $key_photo = new Zend_Session_Namespace('key_photo');
            $key_photo->data = $list_main_photo; 
            
            $photo_fb = new Zend_Session_Namespace('photo');
            $photo = $photo_fb->data;
            $photo = $photo['data'];
            foreach($list_main_photo as $k=>$v)
            {
                $array_photo[$v] = $photo[$v];
            }
            
            ?>
            
            <?php
            $i = $_POST['count_photo'];
            foreach($array_photo as $key=>$value)
            {
                $i++;
            ?>   
            
            
            <li>
                <label>
                <p class="img_fb">
                    <img src="<?php echo $value['source'] ?>" alt="" title="">
                    <input type="radio" name="photo_sanpham" value="<?php echo $value['source'] ?>">
                    <input type="hidden" name="photo_sanpham_<?php echo $i ?>" value="<?php echo $value['source'] ?>">
                    <span>Ảnh chính</span>
                </p>
                
                </label>
                <input type="text" name="order_photo_sanpham_<?php echo $i ?>" value="" title="Vị trí hình ảnh hiển thị">
                <a href="javascript:void(0)">
                    <img src="<?php echo APP_DOMAIN . '/application/templates/giaodien_admin/images/delete.png' ?>" alt="del" title="Xóa Hình">
                </a>
            </li>

            <?php
            $i++;
            } 
        }
    }
    
    public function processaddAction()
    {
        $store = App_Models_StoreModel::getInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        $parent_cat = $_POST['select_parent_cat'];
        $child_cat = $_POST['select_child_cat'];
        if($child_cat == 'koo')
            $idloaisp = $parent_cat;
        else
            $idloaisp = $child_cat;

        $idpage = $_SESSION['idpage'];
        
        $img_sp = $_POST['img_sp'];
        $name_sp = $_POST['name_sp'];
        $price_sp = $_POST['price_sp'];
        $des_sp = $_POST['des_sp'];
        $new_sp = isset($_POST['new_sp']) ? $_POST['new_sp'] : array();
        
        $sql = "Insert into ishali_sanpham (`idloaisp`, `tensp`, `gia`, `hinhchinh`, `mota`, `anhien`, `ngaycapnhat`, `spmoi`, `idpage`) value ";
        $i = 0;
        foreach($img_sp as $key=>$value)
        {
            $hinhchinh = $img_sp[$key];
            $tensp = $name_sp[$key];
            $gia = $price_sp[$key];
            $mota = $des_sp[$key];
            $new = isset($new_sp[$key]) ? $new_sp[$key] : "0";
            
            if($i++ == 0) 
                $sql .= "('$idloaisp', '$tensp', '$gia', '$hinhchinh', '$mota', '1', now(), '$new', '$idpage') ";
            else
                $sql .= ",('$idloaisp', '$tensp', '$gia', '$hinhchinh', '$mota', '1', now(), '$new', '$idpage') ";
        }
        //echo $sql;exit;
        echo $store->InsertDeleteUpdateQuery($sql);
    }
    
    
    
     public function xulyaddAction() {
        $store = App_Models_StoreModel::getInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        $idpage = $_SESSION['idpage'];
        
        //masp, tensp, thuocloaisp, giaban ,string_img_upload, string_img_upload_ch, mota, chitiet, hethang, hienthi, titlefb, metafb
        
        $masp = $_POST['masp'];
        $tensp = $_POST['tensp'];
        $thuocloaisp = $_POST['thuocloaisp'];
        $giaban = $_POST['giaban'];
        $giagiam = $_POST['giagiam'];
        $sale_off = $_POST['sale_off'];
        $spmoi = $_POST['spmoi'];
        $hinhchinh = $_POST['string_img_upload'];
        $hinhphu = $_POST['string_img_upload_ch'];
        $mota = $_POST['mota'];
        $hethang = $_POST['hethang'];
        $anhien = $_POST['anhien'];
        $showindex = $_POST['showindex'];
        $titlefb = $_POST['titlefb'];
        $metafb = $_POST['metafb'];
        
        $arrhinhchinh = explode(",",$hinhchinh);
        //print_r($arrhinhchinh);
        $str_hinhchinh = "";
        $dem=0;
        for($i=0; $i<count($arrhinhchinh); $i++)
        {
            if($arrhinhchinh[$i]!="" and $str_hinhchinh == "")
            {
                $str_hinhchinh .= $arrhinhchinh[$i];
                $dem++;
            }
            else
            {
                if($arrhinhchinh[$i]!="" and $str_hinhchinh != "")
                {
                    $str_hinhchinh .= ',' . $arrhinhchinh[$i];
                    $dem++;
                }
            }
            if($dem==1)
                break;    
            
        }
        
        
        $arrhinhphu = explode(",",$hinhphu);
        //print_r($arrhinhphu);
        $str_hinhphu = "";
        $dem=0;
        for($i=0; $i<count($arrhinhphu); $i++)
        {
            if($arrhinhphu[$i]!="" and $str_hinhphu == "")
            {
                $str_hinhphu .= $arrhinhphu[$i];
                $dem++;
            }
            else
            {
                if($arrhinhphu[$i]!="" and $str_hinhphu != "")
                {
                    $str_hinhphu .= ',' . $arrhinhphu[$i];
                    $dem++;
                }
            }
            if($dem==4)
                break;
            
            
        }
       
        
        
        
        $sql = "Insert into ishali_sanpham (";
        $sql.= "masp, idloaisp, tensp, gia, giagiam, sale_off, spmoi, hinhchinh, hinhphu, mota, 
        anhien, hethang, baohanh, ngaycapnhat, showindex, titlefb, metafb, idpage ) ";
        $sql.= "values (";
        $sql.= "'".$masp."', ";
        $sql.= "'".$thuocloaisp."', ";
        $sql.= "N'".$tensp."', ";
        $sql.= "'".$giaban."', ";
        $sql.= "'".$giagiam."', ";
        $sql.= "'".$sale_off."', ";
        $sql.= "'".$spmoi."', ";
        $sql.= "'".$str_hinhchinh."', ";
        $sql.= "'".$str_hinhphu."', ";
        $sql.= "N'".$mota."', ";
        $sql.= "'".$anhien."', ";
        $sql.= "'".$hethang."', ";
        $sql.= "'0', ";
        $sql.= "now(), ";
        $sql.= "'".$showindex."', ";
        $sql.= "'".$titlefb."', ";
        $sql.= "'".$metafb."', ";
        $sql.= "'".$idpage."')";
        
        echo $data = $store->InsertDeleteUpdateQuery($sql);
    }
    
    
    
    public function detailAction() {
        $idpage = $_SESSION['idpage'];
		$_SESSION['list_page'] = "0";
        $store = App_Models_StoreModel::getInstance();
        
        if(isset($_POST['tensp']))
        {
            $idsp = $_POST['idsp'];
            $anhien = isset($_POST['hienthi']) ? $_POST['hienthi'] : 0;
            $spmoi = isset($_POST['spmoi']) ? $_POST['spmoi'] : 0;
            $tensp = $_POST['tensp'];
            $idcat = $_POST['idcat'];
            $giaban = $_POST['giaban'];
            $giagiam = $_POST['giagiam'];
            $sale_off = $_POST['sale_off'];
            $mota = $_POST['mota'];
            
            $photo_main_sanpham = $_POST['photo_sanpham'];
            $photo_sanpham = array();
            $j = 0;
            for($i = 1; $i <= 20; $i++)
            {
                if(isset($_POST["photo_sanpham_$i"]))
                {
                    if($_POST["photo_sanpham_$i"] != $photo_main_sanpham)
                    {
                        $photo_sanpham[$j]['photo'] = $_POST["photo_sanpham_$i"];
                        $photo_sanpham[$j]['order'] = $_POST["order_photo_sanpham_$i"];
                        $j++;
                    }    
                }
                
            }
            
            $sql = "update ishali_sanpham set `anhien` = '$anhien', 
                                                `spmoi` = '$spmoi',
                                                `tensp` = '$tensp',
                                                `idloaisp` = '$idcat',
                                                `gia` = '$giaban',
                                                `giagiam` = '$giagiam',
                                                `sale_off` = '$sale_off',
                                                `mota` = '$mota',
                                                `hinhchinh` = '$photo_main_sanpham'
                    where `idsp` = '$idsp'";
            $data = $store->InsertDeleteUpdateQuery($sql);
            if($data == 1)
            {
                echo "<script>setTimeout(function(){FB.Canvas.scrollTo(0,0); ThongBao('Cập nhật sản phẩm thành công',2000);},2000);</script>";
            }
            //Them anh phu
            $sql = "delete from ishali_sanpham_hinhanh where `idsp` = '$idsp'";
            $store->InsertDeleteUpdateQuery($sql);
            //print_r($photo_sanpham);
            if(count($photo_sanpham) > 0)
            {
                $sql = "insert into ishali_sanpham_hinhanh (`idsp`, `source`, `sapxep`) values ";
                $i = 0;
                foreach($photo_sanpham as $key=>$value)
                {
                    if($i++ == 0)
                        $sql .= "('$idsp', '{$value['photo']}', '{$value['order']}') ";
                    else
                        $sql .= ",('$idsp', '{$value['photo']}', '{$value['order']}') ";
                }
                $store->InsertDeleteUpdateQuery($sql);
            }
        }
        
        
        $idsp = base64_decode($this->_request->getParam("idsp"));
        $sql = "Select * from ishali_sanpham where idsp = ". $idsp ." and idpage = ". $idpage;
        $data = $store->SelectQuery($sql);
        $this->view->product = $data;
        
        $sql = "select * from ishali_sanpham_hinhanh where idsp = '$idsp' order by sapxep";
        $data = $store->SelectQuery($sql);
        $this->view->product_hinhanh = $data;
        
        $list_loaisp = $store->getAllCategoryByIdPage($idpage, 0);
        $category = $store->addCategoryIntoMenuAdmin($list_loaisp);
        $this->view->category = $category;
		
		//Kiem tra co nhap menu ko, ko nhap thi xoa het menu trong ishali_thongtinsp
		$sql = "select menuthongtinsp from ishali_config where idpage = '". $idpage ."'";
		$data = $store->SelectQuery($sql);
		if(count($data)>0)
		{
			if($data[0]['menuthongtinsp'] == "")
			{
				$sql = "Delete from ishali_thongtinsp where idsp = '". $idsp ."'";
				$store->InsertDeleteUpdateQuery($sql);
			}
		}
        
    }
    
    public function xulyupdateAction() {
        $store = App_Models_StoreModel::getInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        //masp, tensp, thuocloaisp, giaban ,string_img_upload, string_img_upload_ch, mota, chitiet, hethang, hienthi, titlefb, metafb
        
        $idsp = $_POST['idsp'];
        $anhien = isset($_POST['hienthi']) ? $_POST['hienthi'] : 0;
        $spmoi = isset($_POST['spmoi']) ? $_POST['spmoi'] : 0;
        $tensp = $_POST['tensp'];
        $idcat = $_POST['idcat'];
        $giaban = $_POST['giaban'];
        $giagiam = $_POST['giagiam'];
        $sale_off = $_POST['sale_off'];
        $mota = $_POST['mota'];
        
        $photo_main_sanpham = $_POST['photo_sanpham'];
        $photo_sanpham = array();
        $j = 0;
        for($i = 1; $i <= 20; $i++)
        {
            if(isset($_POST["photo_sanpham_$i"]))
            {
                if($_POST["photo_sanpham_$i"] != $photo_main_sanpham)
                {
                    $photo_sanpham[$j]['photo'] = $_POST["photo_sanpham_$i"];
                    $photo_sanpham[$j]['order'] = $_POST["order_photo_sanpham_$i"];
                    $j++;
                }    
            }
            
        }
        
        $sql = "update ishali_sanpham set `anhien` = '$anhien', 
                                            `spmoi` = '$spmoi',
                                            `tensp` = '$tensp',
                                            `idloaisp` = '$idcat',
                                            `gia` = '$giaban',
                                            `giagiam` = '$giagiam',
                                            `sale_off` = '$sale_off',
                                            `mota` = '$mota',
                                            `hinhchinh` = '$photo_main_sanpham'
                where `idsp` = '$idsp'";
        echo $data = $store->InsertDeleteUpdateQuery($sql);
        
        //Them anh phu
        $sql = "delete from ishali_sanpham_hinhanh where `idsp` = '$idsp'";
        $store->InsertDeleteUpdateQuery($sql);
        //print_r($photo_sanpham);
        if(count($photo_sanpham) > 0)
        {
            $sql = "insert into ishali_sanpham_hinhanh (`idsp`, `source`, `sapxep`) values ";
            $i = 0;
            foreach($photo_sanpham as $key=>$value)
            {
                if($i++ == 0)
                    $sql .= "('$idsp', '{$value['photo']}', '{$value['order']}') ";
                else
                    $sql .= ",('$idsp', '{$value['photo']}', '{$value['order']}') ";
            }
            $store->InsertDeleteUpdateQuery($sql);
        }
        
        
    }
    
    public function xulydeleteAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $store = App_Models_StoreModel::getInstance();
        $idsp = $_POST['idsp'];
        
        

        $sql = "Select hinhchinh, hinhphu from ishali_sanpham where idsp = " . $idsp;
        $data = $store->SelectQuery($sql);
        
        $hinhchinh = $data[0]['hinhchinh'];
        $arr_hinhphu = $data[0]['hinhphu'];
        
        
        if($hinhchinh != "")
        {
            if(file_exists('application/layouts/tmpstore/images/upload/images/'.$hinhchinh))
            {
                unlink('application/layouts/tmpstore/images/upload/images/'.$hinhchinh);
            }
        }
        

        if($arr_hinhphu != "")
        {
            $hinhphu = explode(",", $arr_hinhphu);
            for($i=0; $i<count($hinhphu); $i++)
            {
                if(file_exists('application/layouts/tmpstore/images/upload/images/'.$hinhphu[$i]))
                {
                    unlink('application/layouts/tmpstore/images/upload/images/'.$hinhphu[$i]);
                }
            }
        }
        

        
        
        $sql = "Delete from ishali_sanpham where idsp = " . $idsp;
        $data = $store->InsertDeleteUpdateQuery($sql);
        echo $data;  
    }
	
	public function thongtinsanphamAction(){
		$store = App_Models_StoreModel::getInstance();
		@$idpage = $_SESSION['idpage'];
		$_SESSION['list_page'] = "0";
		
		$sql = "Select menuthongtinsp from ishali_config where idpage = '". $idpage ."'";
		$data = $store->SelectQuery($sql);
		$menu = $data[0]['menuthongtinsp'];
		$list_menu = explode(";", $menu);
		$this->view->list_menu = $list_menu;
		
		$idsp = @$_GET['idsp'];
		if(@$_GET['keytab']=="")
			$keytab = 1;
		else
			$keytab = @$_GET['keytab'];
		
		$this->view->idsp = $idsp;
		$this->view->keytab = $keytab;
		
		
		$slTab = count($list_menu);
		$sql = "Delete from ishali_thongtinsp where idsp = '". $idsp ."' and keytab > '". $slTab ."'";
		$store->InsertDeleteUpdateQuery($sql);
		
		

		$sql = "select tensp from ishali_sanpham where idsp = '". $idsp ."'";
		$data = $store->SelectQuery($sql);
		$this->view->tensp = $data[0]['tensp'];
		
		$sql = "Select noidung from ishali_thongtinsp where idsp = '". $idsp ."' and keytab = '". $keytab ."'";
		$data = $store->SelectQuery($sql);
		if(count($data) > 0)
			$noidung = $data[0]['noidung'];
		else
			$noidung = "";
		
		$this->view->noidung = $noidung;
		
		
	}
	
	public function thongtinsanphamxulyAction(){
        $store = App_Models_StoreModel::getInstance();
		
		$idsp = $_POST['idsp'];
		$keytab = $_POST['keytab'];
		$noidung = $_POST['noidung'];
		
		$sql = "Select 1 from ishali_thongtinsp where idsp = '". $idsp ."' and keytab = '". $keytab ."'";
		$data = $store->SelectQuery($sql);
		if(count($data) ==0)
		{
			$sql = "Insert into ishali_thongtinsp(idsp, keytab, noidung) value(";
			$sql.= "'".$idsp."', '".$keytab."', '".$noidung."') ";
		}
		else
		{
			$sql = "Update ishali_thongtinsp set ";
			$sql.= "noidung = N'".$noidung."' ";
			$sql.= "where idsp = '". $idsp ."' and keytab = '". $keytab ."'";
		}
		$data = $store->InsertDeleteUpdateQuery($sql);
		
		if($data == 1)
		{
			echo "<script>ThongBaoDongY('Lưu Thành Công.', '".ROOT_DOMAIN."/admin/product/thongtinsanpham?idsp=".$idsp."&keytab=".$keytab."');</script>";	
		}
		else
		{
			echo "<script>ThongBaoDongY('Lưu không thành công<br/>Vui Lòng thực hiện lại thao tác.', '".ROOT_DOMAIN."/admin/product/thongtinsanpham?idsp=".$idsp."&keytab=".$keytab."');</script>";
		}
		
	}
    
    public function testAction(){
        //$this->_helper->viewRenderer->setNoRender(true);
        //$this->_helper->layout->disableLayout();
        $store = App_Models_StoreModel::getInstance();
        $facebook = new Ishali_Facebook();
        //$albums = $facebook->getAlbums();
        $albumsPage = $facebook->getAlbumsPage('356730004423499');
        print_r($albumsPage);
        //$this->view->albums = $albums;
        //$accessToken = $facebook->getAccessToken();exit;
        //$this->view->accessToken = $accessToken;

        //$photo = $facebook->getPhotoInAlbums('568424473254050');
        //print_r($photo);exit;
	}
    
    public function checkhavechildcatAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $store = App_Models_StoreModel::getInstance();
        $idcat = $_POST['idcat'];
        $sql = "select count(*) as count_child_cat from ishali_loaisp where parent_id = '$idcat'";
        $data = $store->SelectQuery($sql);
        echo $data[0]['count_child_cat'];
        
    }
    
    




}








































