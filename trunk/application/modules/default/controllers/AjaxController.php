<?php
require('mail/class.phpmailer.php');
require('mail/class.smtp.php');

class AjaxController extends App_Controller_FrontController {

    public function init() {
        parent::init();
		$facebook = new Ishali_Facebook();
        $this->_SESSION=new Zend_Session_Namespace();
    }


    public function muahangAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
		$store = $this->view->info = App_Models_StoreModel::getInstance();
        $idsp = $_POST['idsp'];
        $soluong = $_POST['soluong'];
        //$size = $_POST['size'];
        $cart = array();
        $idpage = $this->view->idpage;
        if(isset($_SESSION["cart_$idpage"]))
        {
            $cart = $_SESSION["cart_$idpage"];
        }
        $cart[$idsp]['soluong'] = $soluong;
        //$cart[$idsp]['size'] = $size;
        $_SESSION["cart_$idpage"] = $cart;
        print_r($cart);
    }
    
    public function changecartAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
		$store = $this->view->info = App_Models_StoreModel::getInstance();
        $idsp = $_POST['idsp'];
        $soluong = $_POST['soluong'];
        $soluong = max(1, $soluong);
        //$size = $_POST['size'];
        $cart = array();
        $idpage = $this->view->idpage;
        if(isset($_SESSION["cart_$idpage"]))
        {
            $cart = $_SESSION["cart_$idpage"];
        }
        $cart[$idsp]['soluong'] = $soluong;
        //$cart[$idsp]['size'] = $size;
        $_SESSION["cart_$idpage"] = $cart;
    }
    
    public function deletecartAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $idsp = $_POST['idsp'];
        $idpage = $this->view->idpage;
        $cart = $_SESSION["cart_$idpage"];
        unset($cart[$idsp]);
        $_SESSION["cart_$idpage"] = $cart;
    }
    
    public function dathangAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        

		$store = $this->view->info = App_Models_StoreModel::getInstance();
        $config = Zend_Registry::get(APPLICATION_CONFIG);
        $path_image = $config->config->path_image;
        $prefix = $config->config->prefix;
        $appid = $config->facebook->appid;
        
        $idpage = $_POST['idpage'];
        $pageConfig = $store->getConfig($idpage);
        $pageInfo = $store->getInfoPage($idpage);

        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $district = $_POST['district'];
        $address = $_POST['address'];
        $comment = $_POST['comment'];
        $idpage = $this->view->idpage;
        
        
        $sql = "select id_cart from cart order by id_cart DESC";
        $rs = mysql_query($sql);
        
        if(mysql_num_rows($rs) >= 1)
        {
            $row = mysql_fetch_row($rs);
            $last_idCart = $row[0];
            $index_cart = explode('_', $last_idCart);
            $index_cart = $index_cart[1];
            $index_cart = $index_cart + 1;
        }
        else
        {
            $index_cart = 1;
        }
        
        $len = strlen($index_cart);
        if($len == 1) $id_cart = $prefix . '_0000' . $index_cart;
        if($len == 2) $id_cart = $prefix . '_000' . $index_cart;
        if($len == 3) $id_cart = $prefix . '_00' . $index_cart;
        if($len == 4) $id_cart = $prefix . '_0' . $index_cart;
        if($len == 5) $id_cart = $prefix . '_' . $index_cart;
        if(!isset($id_cart)) $id_cart = $prefix . '_' . $index_cart;
        
        $sql = "Insert into cart 
                (`id_cart`, `date_create`, `date_modify`, `status`, `name`, `phone`, `email`, `city`, `district`, `address`, `comment`, `idpage`)
                values ('$id_cart', now(), now(), '0', '$name','$phone', '$email', '$city', '$district', '$address', '$comment', '$idpage')";
        mysql_query($sql);
        
        $cart = $_SESSION["cart_$idpage"];
        $arraySanPham = array();
        foreach($cart as $idsp=>$value)
        {
            $detailSanPham = $store->getProductById($idpage, $idsp);
            $arraySanPham[$idsp]['detail'] = $detailSanPham;
            $arraySanPham[$idsp]['soluong'] = $value['soluong'];
            //$arraySanPham[$idsp]['size'] = $value['size'];
        }

        foreach($arraySanPham as $key=>$value)
        {
            $idsp = $value['detail']['idsp'];
            $gia = $value['detail']['gia'];
            $giagiam = $value['detail']['giagiam'];
            $soluong = $value['soluong'];
            
            $sql = "insert into detail_cart (`id_cart`, `idsp`, `gia`, `giagiam`, `soluong`, `idpage`)
                    values('$id_cart', '$idsp', '$gia', '$giagiam', '$soluong', '$idpage')";
            mysql_query($sql);
        }
        
        $contentCart  = "<table width='600' border='1' cellspacing='0' cellpadding='0'>";
        $contentCart .= "<tr><td colspan='6'>Mã Đơn hàng: <span style='color:red; font-weight:bold'>$id_cart</span></td></tr>";
        $contentCart .= "<tr><th width='30' bgcolor='#CCCCCC' scope='col'>STT</th><th width='125' bgcolor='#CCCCCC' scope='col'>HÌNH</th><th width='180' bgcolor='#CCCCCC' scope='col'>TÊN SP</th><th width='50' bgcolor='#CCCCCC' scope='col'>SL</th><th width='101' bgcolor='#CCCCCC' scope='col'>GIÁ</th><th width='100' bgcolor='#CCCCCC' scope='col'>THÀNH TIỀN</th></tr>";
        $i=1;
        $tongthanhtien = 0;
        foreach($arraySanPham as $key=>$value)
        {
            $stt = $i++;
            $image = $value['detail']['hinhchinh'];
            $tensp = $value['detail']['tensp'];
            $sl = $value['soluong'];
            //$size = $value['size'];
            $gia = ($value['detail']['giagiam'] != 0) ? $value['detail']['giagiam'] : $value['detail']['gia'];
            $tonggia = $gia * $sl;
            $tongthanhtien += $tonggia;
            $gia = number_format($gia,0,',','.');
            $tonggia = number_format($tonggia,0,',','.');
            $contentCart .= "<tr><td align='center' valign='middle'>$stt</td><td align='center' valign='middle'><img width='85' height='65' src='$image'/></td><td>$tensp</td><td align='center' valign='middle'>$sl</td><td align='center' valign='middle'>$gia</td><td align='center' valign='middle'>$tonggia</td></tr>";
        }
        $tongthanhtien = number_format($tongthanhtien,0,',','.');
        $contentCart .= "<tr><td colspan='5' align='center' valign='middle'><strong>TỔNG CỘNG</strong></td><td colspan='2' align='center' valign='middle'><strong>$tongthanhtien</strong></td></tr></table>";
        
        //$contentCart_Email = $pageConfig['email_cart'];
        $path_template_email = APP_DOMAIN . '/application/layouts/bookshop/email/template_email.html';
        $contentCart_Email = file_get_contents($path_template_email);
        
        
        $delivery = $pageConfig['delivery'];
        $contact = $pageConfig['contact'];
        $datenow = date("d-m-Y H:i:s");
        
        $link_app = $pageInfo['link_page'] . '/app_'. $appid;
        
        $contentCart_Email = str_replace('[gio_hang]', $contentCart, $contentCart_Email);
        $contentCart_Email = str_replace('[id_cart]', $id_cart, $contentCart_Email);
        $contentCart_Email = str_replace('[name_shop]', $pageConfig['shopname'], $contentCart_Email);
        $contentCart_Email = str_replace('[link_page]', $pageInfo['link_page'], $contentCart_Email);
        $contentCart_Email = str_replace('[link_app]', $link_app, $contentCart_Email);
        $contentCart_Email = str_replace('[date_now]', $datenow, $contentCart_Email);
        $contentCart_Email = str_replace('[name]', $name, $contentCart_Email);
        $contentCart_Email = str_replace('[phone]', $phone, $contentCart_Email);
        $contentCart_Email = str_replace('[email]', $email, $contentCart_Email);
        $contentCart_Email = str_replace('[delivery]', $delivery, $contentCart_Email);
        $contentCart_Email = str_replace('[contact]', $contact, $contentCart_Email);
        $contentCart_Email = str_replace('[cart]', $contentCart, $contentCart_Email);

        unset($_SESSION["cart_$idpage"]);
        
        $titleEmail = $pageConfig['shopname'];
		$subjectEmail = $pageConfig['shopname'] . ' Thong tin don hang.';
        $contentCart1 = $contentCart_Email;
        
        $subjectEmail2 = "ĐƠN HÀNG - $name - $phone";
        $contentCart2 = "<p>Thông tin đơn hàng</p>";
        $contentCart2.= "Tên : $name<br/>";    
        $contentCart2.= "Email : $email<br/>";
        $contentCart2.= "SĐT : $phone<br/>";
        $contentCart2.= "Thành phố : $city<br/>";
        $contentCart2.= "Quận : $district<br/>";
        $contentCart2.= "Địa chỉ : $address<br/>";
        $contentCart2.= "Ghi chú : $comment<br/>";
        $contentCart2.= $contentCart;
        
        $contact_email = $pageConfig['emailfrom'];
        //Email gui KH
		$send1 = $this->sendmail($email, $name, $titleEmail, $subjectEmail, $contentCart1, $titleEmail, $contact_email);
        //Email gui cho Quan ly
        echo $send2 = $this->sendmail($contact_email, $titleEmail, $name, $subjectEmail2, $contentCart2, $name, $email);
        if($send2 == 1)
        {
            unset($_SESSION["cart_$idpage"]);
        }
    }
    
    public function sendmail($mailto, $nameto, $namefrom, $subject, $noidung, $namereplay, $emailreplay)
	{
		$mail = new PHPMailer();
		$mail->IsSMTP(); // set mailer to use SMTP
		$mail->Host = "smtp.gmail.com"; // specify main and backup server
		$mail->Port = 465; // set the port to use
		$mail->SMTPAuth = true; // turn on SMTP authentication
		$mail->SMTPSecure = 'ssl';
		$mail->Username = "hongtien.51090@gmail.com"; // your SMTP username or your gmail username// Email gui thu
		$mail->Password = "phamhongtien510"; // your SMTP password or your gmail password
		//$from = $mailfrom; // Reply to this email// Email khi reply
        $mail->CharSet="utf-8";
		$from = $emailreplay; // Reply to this email// Email khi reply
		$to= $mailto; // Recipients email ID // Email nguoi nhan
		$name= $nameto; // Recipient's name // Ten cua nguoi nhan
		$mail->From = $from;
		$mail->FromName = $namefrom; // Name to indicate where the email came from when the recepient received// Ten nguoi gui
		$mail->AddAddress($to,$name);
		$mail->AddReplyTo($from,$namereplay);// Ten trong tieu de khi tra loi
		$mail->WordWrap = 50; // set word wrap
		$mail->IsHTML(true); // send as HTML
		$mail->Subject = $subject;
		$mail->Body = $noidung; //HTML Body
		$mail->AltBody = ""; //Text Body

		if(!$mail->Send())
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}
    
    
    

   

}
