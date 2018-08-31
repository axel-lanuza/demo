<?php

/*

Template Name: BuildYourFrame

*/

?>
<?php get_header(); ?>

<style type="text/css">
  .form-control-file {
     
    text-align: center;
    width: 90px;
    cursor: pointer;
    visibility: hidden;
    }
      .form-control-file:before {
     content: attr(data-title);
    position: absolute;

    /* top: 0px; */
    left: 0;
    width: 13%;
    right: 0px;
    min-height: 186px;
    line-height: 2em;
    padding-top: 1.5em;
    margin: 0 auto;
    clear: both;
    opacity: 1;
    visibility: visible;
    text-align: center;
    border: 0.25em dashed currentColor;
    transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
    overflow: hidden;
  }
    &:hover {
      &:before {
        border-style: solid;
        box-shadow: inset 0px 0px 0px 0.25em currentColor;
      }
    }
  }

  .entry-content form#msgname{
  	color: red !important;
  	font-size: 20px;
}
#cancelbtn
{position: relative;
display: block;
margin: 0 auto;}
#dvPreview
{
  height: 134px;
}
img#setimg
{
  
  width: 16%;
  height: 155px;
}
a.fa-facebook-square{
  position: absolute;
    padding-left: 70px;
    padding-top: 30px;
    font-size: 35px;
}
a.fa-instagram{
  position: absolute;
   
    padding-top: 30px;
    font-size: 35px;
}

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<div class="full-width-page">
<div id="primary" class="content-area">
       
        <div id="content" class="site-content" role="main">
<div class="entry-content">
<form id="file_upload" method="post" action="<?php echo get_site_url(); ?>/cropyourimage/" enctype="multipart/form-data" style="margin: 0 auto; text-align: center;">
	<h3 style="padding-bottom: 10px;">Upload your digital photo.</h3>  
	<span id="msgname"></span>
	<span id="blankmsg"></span>
<div id="dvPreview">
     <input type="file" class="form-control-file text-primary font-weight-bold" name="my_file_upload[]" multiple="multiple" id="fileupload"  onchange="readUrl(this)" data-title="Drag and drop a image">

</div> </br></br> 
<a href="<?php echo get_site_url(); ?>/facebook-upload/" class="fa fa-facebook-square"></a> 
<a href="<?php echo get_site_url(); ?>/instagram-upload/" class="fa fa-instagram"></a>
   
     <input name="my_file_upload" type="button" value="Upload" id="btn" style="margin-top: 90px;" />
</form>
</div>
 <div class="clearfix"></div>
                <footer class="entry-meta">   
                    
                </footer>
</div>
</div>
</div>
<?php get_footer(); ?>
<script type="text/javascript">
//For Form Sbmit and Validation
jQuery('#btn').on('click', function() {  
   var filename = jQuery('#fileupload').val();  
  if(filename == '')
  { 
	  jQuery("#blankmsg").html("Please upload Your Photo").fadeIn().delay(2000).fadeOut('fast').css("color", "red");
	  return false;
	}else
	 {
	 	  jQuery( "#file_upload" ).submit();
	 }
  
});

//For drag and Drop
function readUrl(input) {

  if (input.files && input.files[0]) {
    let reader = new FileReader();
    reader.onload = (e) => {
      let imgData = e.target.result;
      let imgName = input.files[0].name;
      input.setAttribute("data-title", imgName);
      console.log(e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }

}

//For Image Preview
jQuery(function () {
    jQuery("#fileupload").change(function () {
        jQuery("#fileupload").hide();
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        if (regex.test(jQuery(this).val().toLowerCase())) {
            if (jQuery.browser.msie && parseFloat(jQuery.browser.version) <= 9.0) {
                jQuery("#dvPreview").show();
                jQuery("#dvPreview")[0].filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = jQuery(this).val();
            }
            else {
                if (typeof (FileReader) != "undefined") {
                    jQuery("#dvPreview").show();
                    jQuery("#dvPreview").append("<img id='setimg'/>");
                    jQuery("#dvPreview").append("<input type='button' id='cancelbtn' name='cancel' value='Cancel' onclick='btncanc();'>");
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        jQuery("#dvPreview img").attr("src", e.target.result);

                        var img = new Image();      
                    img.src = e.target.result;

                    img.onload = function () {
                        var w = this.width;
                        var h = this.height;


             if (h < 600 && w < 600)
              {
                    jQuery("#msgname").html("Your Photo is too small to Print").fadeIn().delay(4000).fadeOut('fast').css("color", "red");
                    jQuery("#dvPreview img").remove();
               var $el = jQuery('#dvPreview #fileupload');
               $el.wrap('<form>').closest('form').get(0).reset();
               $el.unwrap();

                  jQuery("#dvPreview #cancelbtn").remove();
               jQuery("#fileupload").show();
               jQuery('#dvPreview #fileupload').attr("data-title",'Drag and drop a image');
                        return false;
              }
            }
         }
                    reader.readAsDataURL(jQuery(this)[0].files[0]);
     				       
                } else {
                    alert("This browser does not support FileReader.");
                }
            }
        } else {
            alert("Please upload a valid image file.");
            jQuery("#dvPreview img").remove();
   var $el = jQuery('#dvPreview #fileupload');
   $el.wrap('<form>').closest('form').get(0).reset();
   $el.unwrap();

      jQuery("#dvPreview #cancelbtn").remove();
   jQuery("#fileupload").show();
   jQuery('#dvPreview #fileupload').attr("data-title",'Drag and drop a image');
        }
    });
});

//For Cancel Button
function btncanc() {

   jQuery("#dvPreview img").remove();
	 var $el = jQuery('#dvPreview #fileupload');
   $el.wrap('<form>').closest('form').get(0).reset();
   $el.unwrap();

      jQuery("#dvPreview #cancelbtn").remove();
   jQuery("#fileupload").show();
   jQuery('#dvPreview #fileupload').attr("data-title",'Drag and drop a image');
}	
</script>