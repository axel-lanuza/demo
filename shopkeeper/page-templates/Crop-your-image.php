<?php

/*

Template Name: CropYourImage

*/

?>
<?php get_header(); ?>
 
 

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

   
$facebook_image = $_POST['my_file_upload_check'];
$instagram_image = $_POST['my_file_upload_insta'];


     if(empty($facebook_image) && empty($instagram_image))
     {
   

    $files = $_FILES["my_file_upload"];

    foreach ($files['name'] as $key => $value) {
        if ($files['name'][$key]) {
            $file = array(
                'name' => $files['name'][$key],
                'type' => $files['type'][$key],
                'tmp_name' => $files['tmp_name'][$key],
                'error' => $files['error'][$key],
                'size' => $files['size'][$key]
            );
            $_FILES = array("upload_file" => $file);

            $attachment_id = media_handle_upload("upload_file", 0);
           if (is_wp_error($attachment_id)) {
                // There was an error uploading the image.
                echo "Error adding file";
            } else {
                
            }
        }
    }
   
   }
   else {

      if(empty($facebook_image))
      {

         $instagram_image = $_POST['my_file_upload_insta'];
        $desc = "The WordPress Logo";
         $results = media_sideload_image($instagram_image,$desc);

      }
      else
      {

          $facebook_image = $_POST['my_file_upload_check'];
        $desc = "The WordPress Logo";
         $results = media_sideload_image($facebook_image,$desc);
      }
   }
} 
?>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="<?php echo get_site_url(); ?>/wp-content/themes/shopkeeper/js/crop-select-js.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo get_site_url(); ?>/wp-content/themes/shopkeeper/css/crop-select-js.min.css" />  

<div class="container" style="margin-top: 100px;">
  <div class="row">
<div id="wrapper">
<h3 style="padding-bottom: 10px;">Crop your digital photo.</h3>
<span id="errormsg"></span>
<div class="container" style="margin-top: 80px">
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <div id="crop-select"></div>
 <form method="post" action='<?php echo get_site_url(); ?>/select-size/' id='cropimage_form'>
    <input type="hidden" name="orignal_image" value="<?php echo wp_get_attachment_url($attachment_id); ?>" />
            <input type="hidden" name="width" id="scaled-width">
            <input type="hidden" name="height" id="scaled-height">
            <input type="hidden" name="x1" id="scaled-x">
            <input type="hidden" name="y1" id="scaled-y">
            <input type="submit" value="Crop" name="cropbtn" id="cropbtn" />
      </div>
     
    </div>
  </div>
   </form>
      </div>     
    </div>
  </div>
</div>
</div></div>
<script>

var img = new Image();
img.src = '<?php if(empty($facebook_image) && empty($instagram_image)){echo wp_get_attachment_url( $attachment_id );}
   else{ if(empty($facebook_image)){echo $instagram_image;}else { echo $facebook_image;}} ?>';

img.onload = function() {

  if(this.width == 600 && this.height == 600)
  {
      jQuery("#errormsg").html("Photo cannot be cropped, because it already is the minimum size.").fadeIn().delay(2000).fadeOut(3000).css("color", "red");

  }
  else if(this.width == 600 && this.height == 800)
  {
      jQuery("#errormsg").html("Photo can be cropped to 600x600 but not more, because then it will be less then 600x600px").fadeIn().delay(2000).fadeOut(3000).css("color", "red");

  }
    else if(this.width == 1000 && this.height == 1000)
  {
      jQuery("#errormsg").html("Photo can also be cropped to size but is restricted to 600x600 because this is the smallest size").fadeIn().delay(2000).fadeOut(3000).css("color", "red");
  }  
}
jQuery(function () {
      jQuery('#crop-select').CropSelectJs({

        // Image
        imageSrc: '<?php if(empty($facebook_image) && empty($instagram_image)){echo wp_get_attachment_url( $attachment_id );}
   else{ if(empty($facebook_image)){echo $instagram_image;}else { echo $facebook_image;}} ?>',

        // // What to do when the selected area is resized
        selectionResize: function(data) {
          jQuery('#scaled-width').val(data.widthScaledToImage);
          jQuery('#scaled-height').val(data.heightScaledToImage);
        },

        // What to do when the selected area is moved
        selectionMove: function(data) {
          jQuery('#scaled-x').val(data.xScaledToImage);
          jQuery('#scaled-y').val(data.yScaledToImage);
        }
      });

        jQuery('#unlock-ratio-btn').click(function() {
        jQuery('#crop-select').CropSelectJs('clearSelectionAspectRatio');
      });
      jQuery('#match-ratio-btn').click(function() {
        var ratio = jQuery('#crop-select').CropSelectJs('getImageAspectRatio');
        jQuery('#crop-select').CropSelectJs('setSelectionAspectRatio');
      });
      jQuery('#lock-ratio-btn').click(function() {
        var width = parseInt(jQuery('#lock-ratio-width').val());
        var height = parseInt(jQuery('#lock-ratio-height').val());
        jQuery('#crop-select').CropSelectJs('setSelectionAspectRatio', width / height);
      });
 });
</script>