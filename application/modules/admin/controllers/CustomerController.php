<?php
	class Admin_CustomerController extends App_Controller_AdminController {
		
		public function init() {
			parent::init();
			$this->_SESSION=new Zend_Session_Namespace();
			
			$facebook = new Ishali_Facebook();
			$idpage = $facebook->getpageid();
			
			if(isset($idpage))
				$_SESSION['idpage'] = $idpage;
		}

		public function indexAction() {
        
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
				$this->view->checkSessionIdpage = $checkSessionIdpage;
				$this->view->idpage = $idpage;
				//Your code here
				
				$list_customer = $store->getCustomer($idpage);
				$this->view->list_customer = $list_customer;
			}
		}
		
		public function viewcustomerdetailsAction()
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
			
			$name = $_POST['name'];
			$phone = $_POST['phone'];
			$city = $_POST['city'];
			$district = $_POST['district'];
			$address = $_POST['address'];
			$latest_order = $_POST['latest_order'];
			$rating = $_POST['rating'];
			$fb_address = $_POST['fb_address'];
			$idpage = $_POST['idpage'];
			$email = $_POST['email'];
			
			$total_revenue = 0;
			$real_revenue = 0;
			$virtual_revenue = 0;
			
			$total_orders = 0;
			$delivered_orders = 0;
			$pending_orders = 0;
			$cancelled_orders = 0;
			
			$config = $this->view->config = $store->getConfig($idpage);
			
			/*Get cart and cart details of a customer*/
			$infoCarts = $store->getCustomerOrders($idpage, $email);
			foreach($infoCarts as $key=>$cart) {
				$idcart = $cart['id_cart'];
				$sql = "Select SUM(gia) From detail_cart Where id_cart = '$idcart' and idpage = '$idpage'";
				$result = $store->SelectQuery($sql);
				$price = $result[0]['SUM(gia)'];
				
				if ($cart['status'] == 1 || $cart['status'] == 0) {
				
					$pending_orders++;
					$virtual_revenue = $virtual_revenue + $price;
					
				} else if ($cart['status'] == 2) {
				
					$real_revenue = $real_revenue + $price;
					$delivered_orders++;
					
				} else if ($cart['status'] == -1) {
					$cancelled_orders++;
				}
				
				if ($cart['status'] != -1) {
					$total_revenue = $total_revenue + $price;
				}
				
				$total_orders++;
			}
?>

			<div class="header_popup_content">
				Thông Tin Khách Hàng <?php echo $name ?>
				<p class="close_popup" onclick="close_popup()"><img src="<?php echo APP_DOMAIN ?>/application/templates/giaodien_admin/images/delete.png"/></p>
			</div>
			<div class="popup_content">
				<table class="table_detail_cart">
					<tr>
						<td align='left'><strong>Thông tin khách hàng</strong></td>
						<td></td>
					</tr>
					<tr>
						<td align='right'>Họ và tên:</td>
						<td><?php echo $name?></td>
					</tr>
					<tr>
						<td align='right'>Số điện thoại:</td>
						<td><?php echo $phone?></td>
					</tr>
					<tr>
						<td align='right'>Địa chỉ:</td>
						<td><?php echo $address." ".$district." ".$city ?></td>
					</tr>
					<tr><td colspan="2"></td></tr>
					<tr>
						<td align='left'><strong>Thông tin liên lạc</strong></td>
						<td></td>
					</tr>
					<tr>
						<td align='right'>Email:</td>
						<td><?php echo $email ?></td>
					</tr>
					<tr>
						<td align='right'>Facebook:</td>
						<td><?php echo $fb_address?></td>
					</tr>
					<tr>
						<td align='left'><strong>Thông tin mua hàng</strong></td>
						<td></td>
					</tr>
					<tr>
						<td align='right'>Doanh thu đã nhận:</td>
						<td><b><?php echo number_format($real_revenue,0,',','.') .' '. $config['donvitien'] ?></b></td>
					</tr>
					<tr>
						<td align='right'>Doanh thu chưa nhận:</td>
						<td><b><?php echo number_format($virtual_revenue,0,',','.') .' '. $config['donvitien'] ?></b></td>
					</tr>
					<tr>
						<td align='right'>Tổng doanh thu:</td>
						<td><b><?php echo number_format($total_revenue,0,',','.') .' '. $config['donvitien'] ?></b></td>
					</tr>
					<tr>
						<td align='left'><strong>Thông tin hoạt động</strong></td>
						<td></td>
					</tr>
					<tr>
						<td align='right'>Lần mua hàng gần nhất:</td>
						<td><?php echo $latest_order ?></td>
					</tr>
					<tr>
						<td align='right'>Mức độ uy tín:</td>
						<td><?php echo $rating ?></td>
					</tr>
					<tr>
						<td align='right'>Đơn hàng đã giao:</td>
						<td><b><?php echo $delivered_orders." / ".$total_orders ?></b></td>
					</tr>
					<tr>
						<td align='right'>Đơn hàng chưa giao:</td>
						<td><b><?php echo $pending_orders." / ".$total_orders ?></b></td>
					</tr>
					<tr>
						<td align='right'>Đơn hàng đã huỷ:</td>
						<td><b><?php echo $cancelled_orders." / ".$total_orders ?></b></td>
					</tr>

					<tr>
						<td align='left'><strong>Danh sách đơn hàng</strong></td>
						<td></td>
					</tr>
					
					<tr>
						<table class="tbl-home" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<th width="12%">Mã ĐH</th>
								<th width="10%">Ngày đặt</th>
								<th width="10%">Tình trạng</th>
								<th width="10%">Tổng giá</th>
								<th width="20%">Công cụ</th>
							</tr>
							<?php
								foreach($infoCarts as $key=>$value)
								{
									$datecreate = strtotime(substr($value['date_create'], 0, 10));
									$datecreate =  date('d-m-Y', $datecreate);
									
									$idcart = $value['id_cart'];
									$sql = "Select SUM(gia) From detail_cart Where id_cart = '$idcart' and idpage = '$idpage'";
									$result = $store->SelectQuery($sql);
									$total_price = $result[0]['SUM(gia)'];
							?>
							<tr>
								<td><?php echo $value['id_cart'] ?></td>
								<td><?php echo $datecreate; ?></td>
								<td>
									<div style="position: relative;">
										<?php
											$st = "";
											$status = "";
											if($value['status'] == -1) {$st = "cancel"; $status = "Hủy ĐH";}
											if($value['status'] == 0) {$st = "orange"; $status = "Chưa đọc";}
											if($value['status'] == 1) {$st = "green"; $status = "Chưa giao";}
											if($value['status'] == 2) {$st = "grey"; $status = "Đã giao";}
										?>
										<p class="status_cart status_cart_<?php echo $value['id_cart']?> <?php echo $st ?>"><?php echo $status ?></p>
									</div>
								</td>
								<td><?php echo $total_price ?></td>
								<td align="center">
									<a onclick="viewCart('<?php echo $value['id_cart'] ?>')" href="javascript:void(0)"><img title="Chi tiết đơn hàng" alt="detail" src="<?php echo APP_DOMAIN . '/application/templates/giaodien_admin/images/setting.png' ?>"/></a>
								</td>
							</tr>
							<?php
								}
							?>
						</table>
					</tr>
				</table>
			</div>
			
			<?php
			
		}
	}
?>