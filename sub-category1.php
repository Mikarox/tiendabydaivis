<?php
session_start();
error_reporting(0);
include('includes/config.php');
$cid=intval($_GET['scid']);
if(isset($_GET['action']) && $_GET['action']=="add"){
	$id=intval($_GET['id']);
	if(isset($_SESSION['cart'][$id])){
		$_SESSION['cart'][$id]['quantity']++;
	}else{
		$sql_p="SELECT * FROM products WHERE id={$id}";
		$query_p=mysql_query($sql_p);
		if(mysql_num_rows($query_p)!=0){
			$row_p=mysql_fetch_array($query_p);
			$_SESSION['cart'][$row_p['id']]=array("quantity" => 1, "price" => $row_p['productPrice']);
			header('location:my-cart.php');
		}else{
			$message="Product ID is invalid";
		}
	}
}
/* COde for Wishlist
if(isset($_GET['pid']) && $_GET['action']=="wishlist" ){
	if(strlen($_SESSION['login'])==0)
    {   
header('location:login.php');
}
else
{
mysql_query("insert into wishlist(userId,productId) values('".$_SESSION['id']."','".$_GET['pid']."')");
echo "<script>alert('Product aaded in wishlist');</script>";
header('location:my-wishlist.php');

}
} */
?>
<!DOCTYPE html>
<html lang="es">
	<head>

		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="Proyecto tienda online web">
		<meta name="author" content="David Salas y Pedro Ivan">

	    <title>Subcategoria del producto</title>
	    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	    <link rel="stylesheet" href="assets/css/main.css">
	    <link rel="stylesheet" href="assets/css/green.css">
	    <link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
		<link href="assets/css/lightbox.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/animate.min.css">
		<link rel="stylesheet" href="assets/css/rateit.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
		<link rel="stylesheet" href="assets/css/config.css">

		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	</head>
    <body class="cnt-home">
	
<header class="header-style-1">
<!-- ============================================== seccion de cabeza de pagina ============================================== -->
<?php include('includes/top-header.php');?>
<?php include('includes/main-header.php');?>
</header>
<!-- ============================================== seccion cabeza de pagina ============================================== -->
</div><!-- /.breadcrumb -->
<div class="body-content outer-top-xs">
	<div class='container'>
		<div class='row outer-bottom-sm'>
			<div class='col-md-3 sidebar'>
	            	<h3 class="section-title">comprar por</h3>
	            	<div class="sidebar-filter">
		            	<!-- ================= seccion de categorias =============================== -->
<div class="sidebar-widget wow fadeInUp outer-bottom-xs ">
	<div class="widget-header m-t-20">
		<h4 class="widget-title">Categoria</h4>
	</div>
	<div class="sidebar-widget-body m-t-10">
	         <?php $sql=mysql_query("select id,categoryName from category");
while($row=mysql_fetch_array($sql))
{
    ?>
		<div class="accordion">
	    	<div class="accordion-group">
	            <div class="accordion-heading">
	                <a href="category.php?cid=<?php echo htmlentities($row['id']);?>"  class="accordion-toggle collapsed">
	                   <?php echo htmlentities($row['categoryName']);?>
	                </a>
	            </div>  
	        </div>
	    </div>
	    <?php } ?>
	</div>
</div>
	            	</div>
	            </div>
            </div>
			<div class='col-md-9'>
					<!-- ====================== seccion de subcategorias y productos de estas =================== -->
	<div id="category" class="category-carousel hidden-xs">
		<div class="item">	
			<div class="image">
				<img src="assets/images/banners/cat-banner-2.jpg" alt="" class="img-responsive">
			</div>
			<div class="container-fluid">
				<div class="caption vertical-top text-left">
					<div class="big-text">
						<br />
					</div>
					       <?php $sql=mysql_query("select  subcategory  from  subcategory where id='$cid'");
while($row=mysql_fetch_array($sql))
{
    ?>
					<div class="excerpt hidden-sm hidden-md">
						<?php echo htmlentities($row['subcategory']);?>
					</div>
			<?php } ?>
			
				</div>
			</div>
		</div>
</div>
				<div class="search-result-container">
					<div id="myTabContent" class="tab-content">
						<div class="tab-pane active " id="grid-container">
							<div class="category-product  inner-top-vs">
							<div class="row">
			<?php
$ret=mysql_query("select * from products where subCategory='$cid'");
    $cnt=0;
    $num=mysql_num_rows($ret);
if($num>0)
{
while ($row=mysql_fetch_array($ret)) 
{?>																
		<!-- extraemos la imagen del producto -->
		<div class="col-sm-4 col-md-4 wow fadeInUp">
			<div class="products">				
	<div class="product">		
		<div class="product-image">
			<div class="image">
				<a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>"><img  src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['productName']);?>/<?php echo htmlentities($row['productImage1']);?>" alt="" width="210" height="300"></a>
			</div>			                      		   
		</div>	
		<!-- extraemos la informacion del producto -->
		<div class="product-info text-left">
			<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['productName']);?></a></h3>
			<div class="rating rateit-small"></div>
			<div class="description"></div>
			<!-- extraemos el precio del producto -->
			<div class="product-price">	
				<span class="price">
					$. <?php echo htmlentities($row['productPrice']);?>			</span>					
			</div>
		</div>		<!-- boton de agregar al carrito -->
					<div class="cart clearfix animate-effect">
				<div class="action">
					<ul class="list-unstyled">
						<li class="add-cart-button btn-group">
							<button class="btn btn-primary icon" data-toggle="dropdown" type="button">
								<i class="fa fa-shopping-cart"></i>													
							</button>
							<a href="category.php?page=product&action=add&id=<?php echo $row['id']; ?>">
							<button class="btn btn-primary" type="button">Agregar a carrito</button></a>						
						</li>
						<!-- icono de favorito -->
		                <li class="lnk wishlist">
							<a class="add-to-cart" href="category.php?pid=<?php echo htmlentities($row['id'])?>&&action=wishlist" title="Wishlist">
								 <i class="icon fa fa-heart"></i>
							</a>
						</li>

						
					</ul>
				</div>
			</div>
			</div>
			</div>
		</div>
	  <?php 
	} } else{
?>
	<div class="col-sm-4 col-md-4 wow fadeInUp">
	<h3>No Products Found</h3>
	</div>
	<?php } ?>
										</div>
							</div>
						</div>
				</div>
			</div>
		</div>
</div>
</div>
<?php include('includes/footer.php');?>
	<script src="assets/js/jquery-1.11.1.min.js"></script>
	
	<script src="assets/js/bootstrap.min.js"></script>
	
	<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	
	<script src="assets/js/echo.min.js"></script>
	<script src="assets/js/jquery.easing-1.3.min.js"></script>
	<script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/jquery.rateit.min.js"></script>
    <script type="text/javascript" src="assets/js/lightbox.min.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
	<script src="assets/js/scripts.js"></script>

</body>
</html>