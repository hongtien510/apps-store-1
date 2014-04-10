<?php

class Admin_CartController extends App_Controller_AdminController {

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
		
		$store = $this->view->info = App_Models_StoreModel::getInstance();

		
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
            $config = $this->view->config = $store->getConfig($idpage);
			if($this->_request->getParam("st") != "")
			{
				$status = $this->_request->getParam("st");
				$list_cart = $store->getCart($idpage, $status);
				$this->view->list_cart = $list_cart;
			}
			else
			{
				$status = $this->_request->getParam("st");
				$list_cart = $store->getCart($idpage);
				$this->view->list_cart = $list_cart;
			}

			$this->view->checkSessionIdpage = $checkSessionIdpage;
			
		}
    }
	
	public function searchAction()
	{
		$_SESSION['list_page'] = "1";
		
		$store = $this->view->info = App_Models_StoreModel::getInstance();

		
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
            $config = $this->view->config = $store->getConfig($idpage);
			
			if($this->_request->getParam("keyword") != "")
			{
				$keyword = $this->_request->getParam("keyword");
				$list_cart = $store->getOrder($idpage, $keyword);
				$this->view->list_cart = $list_cart;
				
			}
			else
			{
				$list_cart = $store->getOrder($idpage);
				$this->view->list_cart = $list_cart;
			}

			$this->view->checkSessionIdpage = $checkSessionIdpage;
			
		}
	}
	
    public function changestatusAction()
    {
        $store = $this->view->info = App_Models_StoreModel::getInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        if($this->_request->getParam("idpage") != "")
        {
			$idpagee = $this->_request->getParam("idpage");
			$_SESSION['idpage'] = $idpagee;
		}
		@$idpage = $_SESSION['idpage'];
        $idCart = $_POST['idCart'];
        $status = $_POST['status'];
        $sql = "update cart set `status` = '$status' where id_cart = '$idCart' and idpage = '$idpage'";
        echo $store->InsertDeleteUpdateQuery($sql);
    }
    
    public function changestatus2Action()
    {
        $store = $this->view->info = App_Models_StoreModel::getInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        if($this->_request->getParam("idpage") != "")
        {
			$idpagee = $this->_request->getParam("idpage");
			$_SESSION['idpage'] = $idpagee;
		}
		@$idpage = $_SESSION['idpage'];
        $idCart = $_POST['idCart'];
        $sql = "select status from cart where id_cart = '$idCart'";
        $data = $store->SelectQuery($sql);
        $status = $data[0]['status'];
        if($status == 0)
        {
            $sql = "update cart set `status` = '1' where id_cart = '$idCart' and idpage = '$idpage'";
            echo $store->InsertDeleteUpdateQuery($sql);
            exit;
        }
        echo '0';
    }
    
    public function deletecartAction()
    {
        $store = $this->view->info = App_Models_StoreModel::getInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        if($this->_request->getParam("idpage") != "")
        {
			$idpagee = $this->_request->getParam("idpage");
			$_SESSION['idpage'] = $idpagee;
		}
		@$idpage = $_SESSION['idpage'];
        $idCart = $_POST['idCart'];
        $sql = "delete from cart where `id_cart` = '$idCart' and `idpage` = '$idpage'";
        $store->InsertDeleteUpdateQuery($sql);
        
        $sql = "delete from detail_cart where `id_cart` = '$idCart'";
        $store->InsertDeleteUpdateQuery($sql);
        
        echo '1';
    }
    
    public function viewcartAction()
    {
        $store = $this->view->info = App_Models_StoreModel::getInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        if($this->_request->getParam("idpage") != "")
        {
			$idpage = $this->_request->getParam("idpage");
			$_SESSION['idpage'] = $idpage;
		}
		@$idpage = $_SESSION['idpage'];
        $idCart = $_POST['idCart'];
        $config = $this->view->config = $store->getConfig($idpage);
        $sql = "select * from cart where id_cart = '$idCart' and idpage = '$idpage'";
        $infoCart = $store->SelectQuery($sql);
        $infoCart = $infoCart[0];
        
        $sql = "select * from detail_cart where id_cart = '$idCart' and idpage = '$idpage'";
        $detailCart = $store->SelectQuery($sql);
        //print_r($detailCart);exit;
        
        $status = "";
        if($infoCart['status'] == 0) $status = "Chưa đọc";
        if($infoCart['status'] == 1) $status = "Chưa giao";
        if($infoCart['status'] == 2) $status = "Đã giao";
        ?>
        <div class="header_popup_content">
            Chi tiết đơn hàng <?php echo $idCart ?>
            <p class="close_popup" onclick="close_popup()"><img src="<?php echo APP_DOMAIN ?>/application/templates/giaodien_admin/images/delete.png"/></p>
        </div>
        <div class="popup_content">
            <table class="table_detail_cart">
                <tr>
                    <td width='30%' align='right'>Tình trạng đơn hàng:</td>
                    <td><?php echo $status?></td>
                </tr>
                <tr>
                    <td align='left'><strong>Thông tin người đặt hàng</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td align='right'>Họ và tên:</td>
                    <td><?php echo $infoCart['name']?></td>
                </tr>
                <tr>
                    <td align='right'>Số điện thoại:</td>
                    <td><?php echo $infoCart['phone']?></td>
                </tr>
                <tr>
                    <td align='right'>Email:</td>
                    <td><?php echo $infoCart['email']?></td>
                </tr>
                <tr><td colspan="2"></td></tr>
                <tr>
                    <td align='left'><strong>Thông tin giao hàng</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td align='right'>Tỉnh/Thành phố:</td>
                    <td><?php echo $infoCart['city']?></td>
                </tr>
                <tr>
                    <td align='right'>Quận/Huyện:</td>
                    <td><?php echo $infoCart['district']?></td>
                </tr>
                <tr>
                    <td align='right'>Địa chỉ:</td>
                    <td><?php echo $infoCart['address']?></td>
                </tr>
                <tr>
                    <td align='right'>Ghi chú:</td>
                    <td><?php echo $infoCart['comment']?></td>
                </tr>
                <tr><td colspan="2"></td></tr>
                <tr>
                    <td align='left'><strong>Thông tin đơn hàng</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="table_detail_cart">
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                            <?php
							$tong_tien = 0;
                                foreach($detailCart as $key=>$value)
                                {
                                    $sql = "select * from ishali_sanpham where idsp = ". $value['idsp'];
                                    $data = mysql_query($sql);
                                    $sp = mysql_fetch_assoc($data);
									
									$gia = ($value['giagiam'] != 0) ? $value['giagiam'] : $value['gia'];
									$thanh_tien = $value['soluong'] * $gia;
									$tong_tien += $thanh_tien;
                            ?>
                                    <tr>
                                        <td><img class="img_detail_cart" src="<?php echo $sp['hinhchinh'] ?>"/></td>
                                        <td>
                                            <div class="name_detail_cart">
                                                <p class="name_pro"><?php echo $sp['tensp']?></p>
                                                <p class="price_pro"><?php echo number_format($value['gia'],0,',','.') .' '. $config['donvitien']?></p>
                                            </div>
                                        </td>
                                        <td align='center'><span class="text3"><?php echo $value['soluong']?></span></td>
                                        <td align='center'><span class="text3"><?php echo number_format($thanh_tien,0,',','.') .' '. $config['donvitien']?></span></td>
                                    </tr>
                            <?php
                                }
                            ?>
                            <tr>    
                                <th colspan="2"></th>
                                <th class="tong_cong" colspan="2">Tổng cộng : <?php echo number_format($tong_tien,0,',','.') .' '. $config['donvitien']?></th>
                            </tr>
                        </table>
                    
                    </td>
                </tr>
            </table>
        </div>
        
        <?php
        
    }
}

