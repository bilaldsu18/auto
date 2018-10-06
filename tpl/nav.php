<div id="header-with-tabs">

    <div class="page-full-width cf">

        <ul id="tabs" class="fl">
            <li><a href="dashboard.php" class="dashboard-tab">Dashboard</a></li>
			<li><a href="view_supplier.php" class="supplier-tab">Supplier</a></li>
            <li><a href="view_product.php" class="active-tab stock-tab">Stocks</a></li>
            
            <li><a href="view_purchase.php" class="purchase-tab">Purchase</a></li>
            <li><a href="view_customers.php" class="customers-tab">Customers</a></li>
            <li><a href="view_sales.php" class="sales-tab">Sales</a></li>
            <li><a href="view_payments.php" class="payment-tab">Transactions</a></li>
            <li><a href="view_reg_excise.php" class="reg.Excise-tab">Reg.Excise</a></li>
            <li><a href="view_files.php" class="files-tab">Files Delivery</a></li>
            <li><a href="view_report.php" class="report-tab">Reports</a></li>
        </ul> <!-- end tabs -->

        <!-- Change this image to your own company's logo -->
        <!-- The logo will automatically be resized to 30px height. -->
        <a href="#" id="company-branding-small" class="fr"><img src="<?php if(isset($_SESSION['logo'])) { echo "upload/".$_SESSION['logo'];}else{ echo "upload/posnic.png"; } ?>" alt="Point of Sale" /></a>

    </div> <!-- end full-width -->

</div>