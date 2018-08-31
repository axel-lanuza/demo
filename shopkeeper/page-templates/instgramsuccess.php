<?php

/*

Template Name: instagramsuccess

*/

?>
<?php get_header(); 


// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


require(dirname(__FILE__).'/Instagram.php');
use MetzWeb\Instagram\Instagram;
// initialize class
$instagram = new Instagram(array(
   'apiKey' => '6e1976347cd34f34a4ec09916ce1c82e',
    'apiSecret' => '6894bc3a0c3c42faa5ad7f1ef9604bc7',
    'apiCallback' => 'https://justframeit.cloudoffice.be/staging/success/' // must point to success.php
));
// receive OAuth code parameter
$code = $_GET['code'];

// check whether the user has granted access
if (isset($code)) {
    // receive OAuth token object
    $data = $instagram->getOAuthToken($code);
  
    $username = $data->user->username;
    // store user access token
    $instagram->setAccessToken($data);
    // now you have access to all authenticated user methods
    $result = $instagram->getUserMedia();
} else {
    // check whether an error occurred
    if (isset($_GET['error'])) {
        echo 'An error occurred: ' . $_GET['error_description'];
    }
}
?>
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

	<div class="full-width-page">
<div id="primary" class="content-area">
       
        <div id="content" class="site-content" role="main">
<div class="entry-content">

<h3 class="text-center">Upload your Instagram photo.</h3>  
<div class="container">
   
    <form id="file_upload" name="file_upload" method="post" action="<?php echo get_site_url(); ?>/cropyourimage/" enctype="multipart/form-data" style="margin: 0 auto; text-align: center;">
   
       
            <?php
            // display all user likes
            foreach ($result->data as $media) {
           // echo "<div class='gallery'> <div class='fb-album'>";  
    	
                    $image = $media->images->low_resolution->url;
                    // echo "<input type='image' name='my_file_upload_insta' src='{$image}'>";
                    // echo "<img  src=\"{$image}\"/>";
                    // echo " </div>  </div>";
                    echo "<input type='hidden' name='my_file_upload_btn' id='my_file_upload_insta'>";
                 
                echo "<input name='my_file_upload_insta' type='image' src='{$image}' value ='{$image}' onclick='validaFrmSeguimiento(this.value);'/>";
              
            }
            ?>
       
   
        <!-- GitHub project -->
       <!--  <footer>
            <p>created by <a href="https://github.com/cosenary/Instagram-PHP-API">cosenary's Instagram class</a>,
                available on GitHub</p>
            <iframe width="95px" scrolling="0" height="20px" frameborder="0" allowtransparency="true"
                    src="http://ghbtns.com/github-btn.html?user=cosenary&repo=Instagram-PHP-API&type=fork&count=true"></iframe>
        </footer> -->
    
    <!-- <input name="my_file_upload_btn" type="submit" value="Upload" id="btn" style="margin-top: 90px;" /> -->
</form>
</div>
</div></div></div></div><script type="text/javascript">
function validaFrmSeguimiento(my_file_upload_instas)
{
    document.file_upload.my_file_upload_insta.value=my_file_upload_insta;

}
</script>
<?php get_footer(); ?>
