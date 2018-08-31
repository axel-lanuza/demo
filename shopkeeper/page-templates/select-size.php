<?php

/*

Template Name: select-size

*/

?>
<?php get_header(); ?>
 
<?php
// $phpinfonew = phpinfo();
// echo $phpinfonew;
// die;
//ini_set('gd.jpeg_ignore_warning', true);
// $info = phpinfo();
// print_r($info);
// die;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// $crop_size_width = $_POST['width'];
// $crop_size_height = $_POST['height'];




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // print_r($_POST);
   // die;


    $targ_w = $targ_h = 200;
    $jpeg_quality = 90;

    $upl_dir = wp_upload_dir();
	//an array : $upload_directory[basedir] => C:\path\to\wordpress\wp-content\uploads 
	$upload_folder = $upl_dir['basedir'];
	$upload_url = $upl_dir['baseurl'];
	$new_name = "img_" .uniqid(). uniqid() . ".jpg";
	$filename = $upload_folder . "/" . $new_name;
	$new_image = $upload_url . "/" . $new_name;
    
        // $filename = md5(time().rand());
        // $new_image='C:\xampp\htdocs\wordpress\wp-content\uploads/'.$filename.'.jpg';
        
    $src =  $_POST['orignal_image'];
   
    // $SASSS = $_POST['y1'];
    // echo "123";
    // echo $SASSS;
    // die;
    //echo $src;
    //die;
     
    $img_r = imagecreatefromjpeg($src);
  

    $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
 imagecopyresampled($dst_r,$img_r,0,0,20,20,$targ_w,$targ_h,200,200);
    
    imagejpeg($dst_r,$filename,$jpeg_quality);

}
$mxsizephoto = 0;
$amtofpix = 0; 


 echo $width = $_POST['width'];
 echo "***";
 echo $height = $_POST['height'];


 $amtofpix = $width;
//  $crop_size_height = 0;

// $crop_size_width = 0;





// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

 
// $original_image = $_POST['orignal_image'];
// $width = $_POST['y1'];
// echo $width;
// die;echo "123";


//$upl_dir = wp_upload_dir();
	//an array : $upload_directory[basedir] => C:\path\to\wordpress\wp-content\uploads 
	// $upload_folder = $upl_dir['basedir'];
	// $upload_url = $upl_dir['baseurl'];
	// $new_name = "img_" .uniqid(). uniqid() . ".jpg";
	// $filename = $upload_folder . "/" . $new_name;
	// $fileurl = $upload_url . "/" . $new_name;

// $b64image = base64_encode(file_get_contents($original_image));
// echo $b64image;
// die;
// $image = imagecreatefromstring(file_get_contents($original_image));
// $thumb_width = 600;
// $thumb_height = 600;

// $mxsizephoto = 0;
// $amtofpix = 0; 


// 	$width = $_POST['width'];
// 	$height = $_POST['height'];
// 	$amtofpix = $width;

// $mxsizephoto = ($amtofpix*2.54)/150;
	

// imagealphablending($original_image, false);
// imagesavealpha($original_image,true);
// $transparent = imagecolorallocatealpha($original_image, 255, 255, 255, 127);
// imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);

	    

// $thumb = imagecreatefromjpeg($width,$height);

// imagecopyresampled($thumb,$image,0,0,20,20,
//     $thumb_width,$thumb_height,400,400);


// imagecopyresampled($thumb,
// 						   $image,
// 						   0 - ($width - $thumb_width) / 2, // Center the image horizontally
// 						   0 - ($height - $thumb_height) / 2, // Center the image vertically
// 						   10,10,
// 						   $width, $height,
// 						   $width, $height);
// 		imagejpeg($thumb, $filename, 80);
		// $msg['message'] = 'success';
		// $msg['url'] = $fileurl;
		// $msg['path'] = $filename;









//$original_image = $_POST['orignal_image'];



//$image_quality = '95';

// Get dimensions of the original image
//list( $current_width, $current_height ) = getimagesize( $original_image );

// Get coordinates x and y on the original image from where we
// will start cropping the image, the data is taken from the hidden fields of form.
// $x1 = $_POST['x1'];
// $y1 = $_POST['y1'];
// $x2 = $_POST['x2'];
// $y2 = $_POST['y2'];
// $width = $_POST['width'];
// $height = $_POST['height'];     
// print_r( $_POST ); die;

// Define the final size of the image here ( cropped image )
// $crop_width = 600;
// $crop_height = 600;
// Create our small image
//$new = imagecreatetruecolor( $crop_width, $crop_height );
// Create original image
//$current_image = imagecreatefromjpeg( $original_image );
// resampling ( actual cropping )
//imagecopyresampled( $new, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height );
// this method is used to create our new image
//imagejpeg( $new, $new_image, $image_quality );


    // $img_r = imagecreatefromjpeg($original_image);
    // $dst_r = ImageCreateTrueColor( $crop_width, $crop_height );
    // imagecopyresampled($dst_r,$img_r,0,0,$x1,$y1,$crop_width,$crop_height,$width,$height);
    //header('Content-type: ee/jpg');
    
  //    imagejpeg($dst_r,$new_image,$image_quality);
  //   imagedestroy($dst_r);
  // imagedestroy($img_r);
     // $desc = "The WordPress Logo";
     //     $results = media_sideload_image($newimgnew,$desc);

?>

<div class="container" >
    <h3> Select a size. </h3>
    <p>How large should we print your digital photo? Available sizes are based on your photo's resolution.</p>

<?php



for($i=600;$i<=$width;$i+=100)
{
    if($i<=$width)
    {
        $mxsizephoto = ($i)/150;
        echo $cropmaxsizenew = intval($mxsizephoto);
        echo "*";
        $maincalculation = ($height/$width)*$cropmaxsizenew;
        echo $maincalculation;
        echo '</br>';
 
    }

}




 ?>

    <div class="row"> 
<div class="col-md-6"> 
<select id="name" name="name"> 
<option value=""><?php echo $mxsizephoto; ?></option> 
<option value="Elvis">Elvis</option> 
<option value="Frank">Frank</option> 
<option value="Jim">Jim</option> 
</select>
</div>

<div class="col-md-6"> 
<input type="text" id="firstname" name="firstname" value="Elvis" readonly="readonly">
</div></div>
<p>
        <img id="photo" src="https://justframeit.cloudoffice.be/staging\wp-content\uploads/<?php echo $new_name;?>" alt="Cropped Image" title="Cropped Image" />
   
</p>
</div>

<script type="text/javascript">
// 	jQuery(document).ready(function() {

// 		 var filename = jQuery('#photo').val();

// 		 newwidth = filename.width();
// 		 alert(newwidth);
// });
jQuery(document).ready(function() {

    jQuery("#name option").filter(function() {
        return jQuery(this).val() == jQuery("#firstname").val();
    }).attr('selected', true);

    jQuery("#name").live("change", function() {

        jQuery("#firstname").val(jQuery(this).find("option:selected").attr("value"));
    });
});

</script>


