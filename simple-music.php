<?php
/*
Plugin Name: Simple Music
Plugin URI: http://zzzprofits.com/forums/21-Wordpress-Plugins-Support
Description: The easy way to play any MP3 in your Blog's sidebar. To install, click activate, then go to Appearance > Widgets to find 'Simple Music'. All settings are contained within the widget.
Version: 1.2
Author: ZZZ Profits
Author URI: http://www.ZZZProfits.com
*/

add_action("widgets_init", array('Simple_Music', 'register'));
register_activation_hook( __FILE__, array('Simple_Music', 'activate'));
register_deactivation_hook( __FILE__, array('Simple_Music', 'deactivate'));
class Simple_Music {
  function activate(){
    $data = array('title' => '', 'url' => 'http://flash-mp3-player.net/medias/another_world.mp3', 'autoplay' => 'No', 'repeat' => 'Yes', 'credit' => 'Yes');
    if ( ! get_option('simple_music')){
      add_option('simple_music' , $data);
    } else {
      update_option('simple_music' , $data);
    }
  }
  
 function control(){
  $data = get_option('simple_music');
  ?>
    <p><label><b>Widget Title:</b><br /> <input name="simple_music_title"
type="text" value="<?php echo $data['title']; ?>" /></label></p>
  <p><label><b>Song URL:</b><br /><input name="simple_music_url"
type="text" value="<?php echo $data['url']; ?>" /></label></p>
<p><em>Enter the url of the mp3 file in the box above (http://site.com/file.mp3). Find a file online, or use the Media > Add New tab on the left to upload an mp3 from your computer.</em></p><br />

<p><label><b>Autoplay?</b></label> 
  <select name="simple_music_autoplay">
  <option <?php if ($data['autoplay'] == "Yes"){echo 'selected="selected"';} ?>>Yes</option>
  <option <?php if ($data['autoplay'] == "No"){echo 'selected="selected"';} ?>>No</option>
</select></p>
<p><em>This option will start playing the audio as soon as the page is loaded.</em></p><br />


<p><label><b>Repeat (Loop)</b></label> 
  <select name="simple_music_repeat">
  <option <?php if ($data['repeat'] == "Yes"){echo 'selected="selected"';} ?>>Yes</option>
  <option <?php if ($data['repeat'] == "No"){echo 'selected="selected"';} ?>>No</option>
</select></p>
<p><em>This option will restart the audio when it reaches the end.</em></p><br />


<p><label>Give Us Credit? </label>
  <select name="simple_music_credit">
  <option <?php if ($data['credit'] == "Yes"){echo 'selected="selected"';} ?>>Yes</option>
  <option <?php if ($data['credit'] == "No"){echo 'selected="selected"';} ?>>No</option>
</select></p>

  <?php
   if (isset($_POST['simple_music_url'])){
   	$data['title'] = attribute_escape($_POST['simple_music_title']);
    $data['url'] = attribute_escape($_POST['simple_music_url']);
    $data['autoplay'] = attribute_escape($_POST['simple_music_autoplay']);
    $data['repeat'] = attribute_escape($_POST['simple_music_repeat']);
    $data['credit'] = attribute_escape($_POST['simple_music_credit']);
    update_option('simple_music', $data);
  }
}


  function deactivate(){
    delete_option('simple_music');
  }
  function widget($args){
  	$data = get_option('simple_music');
    echo $args['before_widget'];
    echo $args['before_title'] . $data['title'] . $args['after_title'];
    
/* Change Options */

	if ($data['repeat'] == "Yes"){
	$repeat = 1; } else { 
	$repeat = 0; }

	if ($data['autoplay'] == "Yes"){
	$autoplay = 1; } else { 
	$autoplay = 0; }

	if ($data['repeat'] == "Yes"){
	$theanchor = "make money online"; } else { 
	$theanchor = "make money online free"; }		
?>
<object type="application/x-shockwave-flash" data="http://flash-mp3-player.net/medias/player_mp3_maxi.swf" width="200" height="20">
    <param name="movie" value="http://flash-mp3-player.net/medias/player_mp3_maxi.swf" />
    <param name="bgcolor" value="#ffffff" />
    <param name="FlashVars" value="mp3=<?php echo $data['url']; ?>&amp;loop=<?php echo $repeat; ?>&amp;autoplay=<?php echo $autoplay; ?>&amp;volume=125&amp;showvolume=1&amp;showloading=always&amp;loadingcolor=949494&amp;sliderovercolor=ffffff&amp;buttonovercolor=cccccc" /></object> 
    <?php

if ($data['credit'] == "Yes"){
echo '<br />Created by <a href="http://www.zzzprofits.com/">'.$theanchor.'</a>';} else {}

echo $args['after_widget'];
  }
function register(){
    register_sidebar_widget('Simple Music', array('Simple_Music', 'widget'));
    register_widget_control('Simple Music', array('Simple_Music', 'control'));
  }
}



?>