<?php

/*

Template Name: facbookuplod

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
<?php



 //include('facebook.php'); ?>

  
<?php 

include(dirname(__FILE__).'/facebook.php');

//echo get_stylesheet_directory() . '/js/base_facebook.php';


 $facebook = new Facebook(array(
  'appId'  => '2155136561433157',
  'secret' => '649ced34a4cf04cc650736493aed53bf',
));

// See if there is a user froa cookie
//$user = '2022229944756591';//
//$user = $facebook->getUser();
// echo $user;
// die;
$loginUrl = $facebook->getLoginUrl();
?>



<div class="full-width-page">
<div id="primary" class="content-area">
       
        <div id="content" class="site-content" role="main">
<div class="entry-content">

<h3 class="text-center">Upload your Facebook photo.</h3>  
<a style="font-size: 19px;" href="<?php echo $loginUrl; ?>" class="loginBtn loginBtn--facebook">
  Login with Facebook
</a>


<?php
 // Generate access token
 
  $access_token = 'EAAeoFdUvykUBAEaSCzsWnUaPg4xz6V7MNJONql9NE0t2r8ZBvPPxxvVcT9mK0UcoZBsc5saOXopjMi5RWM8JtJLmZA7cxrZAIacCj8xxh7dtkKTS7yFtZCK9p6YGRDY7E2hfoG5s8ZCF3Cn38zZAA1ULZAtXG8QuIL4ZA0KHaEo3QZAu6eA4DiZBz49FzkZBHc3YZAh1ZBHO9XSDhv0HdatXsyMNa6HpFDOGHAk6H5lfBWl9HAIwZDZD';
 

 //$token = '1f5fedbc81df7af02cf0fa369129f807';
if ($user != 0) {

  try {
        //$fields = "id,name,description,link,cover_photo,count";
     $graph_album_link = "https://graph.facebook.com/v3.1/{$user}/albums?access_token={$access_token}";

$jsonData = file_get_contents($graph_album_link);
$fbAlbumObj = json_decode($jsonData, true, 512, JSON_BIGINT_AS_STRING);
$fbAlbumData = $fbAlbumObj['data'];
?>
<form id="file_upload" method="post" action="<?php echo get_site_url(); ?>/cropyourimage/" enctype="multipart/form-data" style="margin: 0 auto; text-align: center;">
<?php
foreach($fbAlbumData as $data)
{

    $album_id = isset($data['id'])?$data['id']:'';
    $graphPhoLink = "https://graph.facebook.com/v2.9/{$album_id}/photos?fields=source,images,name&access_token={$access_token}";
$jsonData = file_get_contents($graphPhoLink);
$fbPhotoObj = json_decode($jsonData, true, 512, JSON_BIGINT_AS_STRING);
 
// Facebook photos content
$fbPhotoData = $fbPhotoObj['data'];
?>

<?php
foreach($fbPhotoData as $data){
    $imageData = end($data['images']);
    $imgSource = isset($imageData['source'])?$imageData['source']:'';
    $name = isset($data['name'])?$data['name']:'';
    
  
    echo "<div class='gallery'>";
    echo "<div class='fb-album'>";
    echo "<img src='{$imgSource}' alt=''>";
    echo "<input type='radio' name='my_file_upload_check' value='{$imgSource}'>";
    echo "<h3>{$name}</h3>";
    echo "</div>";
    echo "</div>";
   
}

  

}

?>
<!-- <input type="file" name="my_file_upload" id="fbimage" value=""> -->
<input name="my_file_upload_btn" type="submit" value="Upload" id="btn" style="margin-top: 90px;" />
</form>
<?php

    
    $user_profile = $facebook->api('/'.$user);
    // $user_album = $facebook->api('/'.$user.'/albums');
     
 
   
  } catch (FacebookApiException $e) {
   echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
    $user = null;
  }
}

?>
</div></div></div></div>




<?php get_footer(); ?>
