<?php
    $pageConfig = $this->pageConfig;
    $configApp = Zend_Registry::get(APPLICATION_CONFIG);
    $path_image = $configApp->config->path_image;
    $idpage = $this->idpage;
?>

<div class="m-top">
	<!--breadcrum-->
	<div class="breadcrum" style="display:none;">
		<a href="#">Hàng m?i</a> / <a href="#">Qu?n áo</a> / <a href="#">N?</a>/
		<a href="#" class="active">Áo</a>
	</div>
	<!--End breadcrum-->
	<!--sort-->

    <div class="sort">		<span class="title">S?p x?p</span>
        <select name="sort" class="select">
        	<option <?php if(@$_GET['sort'] == 'new') echo "select='select'" ?> value="new">Theo hàng m?i</option>			
            <option <?php if(@$_GET['sort'] == 'asc') echo "select='select'" ?> value="asc">Theo giá tang d?n</option>
        	<option <?php if(@$_GET['sort'] == 'desc') echo "select='select'" ?> value="desc">Theo giá gi?m d?n</option>
        </select>
    </div>

	<!--End sort-->
</div>
<div class="m-bottom">
	<!--product-->
	<div class="product">
        <?php
            
            $listProduct = $this->listProduct;
            if(count($listProduct) > 0)
            {
                foreach($listProduct as $value)
                {
        ?>
    		<div class="p-item">
    			<a href="<?php echo APP_DOMAIN .'/detail?idpage='. $idpage .'&id='. $value['idsp']?>">
    				<img src="<?php echo APP_DOMAIN .'/'. $path_image . $value['hinhchinh']?>" alt="" title=""/>
    				<?php
                        if($value['giagiam'] == 0 && $value['spmoi'] == 1) echo "<div class='new'></div>";
                    ?>
                    <?php
                        if($value['giagiam'] != 0) echo "<div class='selloff'><span>{$value['sale_off']}% off</span></div>";
                    ?>
                    <a onclick="muahang('<?php echo $value['idsp']?>')" href="javascript:void(0)" class="addcart"></a>
    				<div class="bg-name">
    					<p class="name-p"><?php echo $value['tensp'] ?></p>
    					<p class="price">
                        <?php
                            if($value['giagiam'] != 0)
                            {
                        ?>
                            <span class="price-real"><?php echo number_format($value['gia'],0,',','.') .' '. $pageConfig['donvitien'] ?></span>
                            <span class="price-sale"><?php echo number_format($value['giagiam'],0,',','.') .' '. $pageConfig['donvitien'] ?></span>
                        <?php
                            }
                            else
                            {
                        ?>
                            <span class="price-sale"><?php echo number_format($value['gia'],0,',','.') .' '. $pageConfig['donvitien'] ?></span>
                        <?php
                            }
                        ?>
                        </p>
    				</div>
    			</a>	
    		</div>
        <?php 
                }
            }
            else
            {
                echo '<br/>Không tìm th?y s?n ph?m nào';
            }
        ?>
		<?php echo $this->pagination; ?>
	</div>
	<div class="cart-shop">
		<div class="cart-icon-right">
			<a href="<?php echo APP_DOMAIN .'/giohang?idpage='. $idpage ?>" class="cart-icon">
				<div class="total"><?php echo isset($_SESSION["cart_$idpage"]) ? count($_SESSION["cart_$idpage"]) : "0" ?></div>
			</a>
			<a href="#" class="search-icon"></a>
			<div class="search-content">
				<input onkeyup="searchProduct(event, this.value)" type="text" value="" placeholder="Tìm ki?m" />
			</div>
			
			<a href="javascript:void(0);" class="gotoTop"></a>
		</div>
	</div>
	<!--End product-->
</div>
