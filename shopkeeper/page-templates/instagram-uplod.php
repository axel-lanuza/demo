<?php

/*

Template Name: instagramuplod

*/

?>
<?php get_header(); ?>
 <style type="text/css">
 div.gallery img {
    width: 100%;
    height: auto;
}
div.gallery {
    margin: 5px;
    border: 1px solid #ccc;
    float: left;
    width: 180px;
}
 </style>


    <style>
        .login {
            display: block;
            font-size: 20px;
            font-weight: bold;
            margin-top: 50px;
        }
    </style>


<div class="full-width-page">
<div id="primary" class="content-area">
       
        <div id="content" class="site-content" role="main">
<div class="entry-content">

<h3 class="text-center">Upload your Instagram photo.</h3>  

<?php

require(dirname(__FILE__).'/Instagram.php');

use MetzWeb\Instagram\Instagram;
// initialize class
$instagram = new Instagram(array(
    'apiKey' => '6e1976347cd34f34a4ec09916ce1c82e',
    'apiSecret' => '6894bc3a0c3c42faa5ad7f1ef9604bc7',
    'apiCallback' => 'https://justframeit.cloudoffice.be/staging/success/' // must point to success.php
));
// create login URL
$loginUrl = $instagram->getLoginUrl();
?>

<div class="container">
    
    <div class="main">
        <ul class="grid">
            
            <li>
                <a class="login" href="<?php echo $loginUrl ?>">» Login with Instagram</a>
                
            </li>
        </ul>
        <!-- GitHub project -->
       
    </div>
</div>


</div></div></div></div>




<?php get_footer(); ?>
