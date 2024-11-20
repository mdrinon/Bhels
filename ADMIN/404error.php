<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>

<style>
    .page_404 {
        padding:40px 0; 
        background:#fff; 
        font-family: 'arial', serif;
        width: 100%;
    }.page_404 img { 
        width:90%;
    }.four_zero_four_bg{
        background-image: url(https://cdn.dribbble.com/users/722246/screenshots/3066818/404-page.gif);
        height: 650px;
        background-position: center;
    }.four_zero_four_bg h1{
        font-size:80px;
    }.four_zero_four_bg h3{
        font-size:80px;
    }.link_404{      
        color: #fff!important;
        padding: 10px 20px;
        background: var(--quinary-color);
        margin: 20px 0;
        display: inline-block;
        border-radius: 7px;
    }.link_404:hover{
        color: #fff!important;
        background: var(--senary-color);
        text-decoration: none;
        text-underline-offset: 0px;
    }.contant_box_404{
        margin-top: 50px;
        text-align: center;
    }
</style>

<section class="main-content">
    <div class="page_404">
        <div class="container">
            <div class="row"> 
                <div class="col-sm-12 ">
                    <div class="col-sm-10 col-sm-offset-1  text-center">
                        <div class="four_zero_four_bg"></div>
                        <div class="contant_box_404">
                            <h3 class="h2">Look like you're lost</h3>
                            <p>the page you are looking for is not avaible!</p>
                            <a href="index.php" class="link_404">Go to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include('partials/footer.php'); ?>
