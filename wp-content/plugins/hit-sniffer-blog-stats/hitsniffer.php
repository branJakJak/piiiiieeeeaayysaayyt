<?php
/*
Plugin Name: Hit Sniffer Live Blog Analytics
Plugin URI: http://www.hitsniffer.com/
Description: Hit Sniffer is a powerful real time website visitor activity tracker. It will  website visitors actions live and in real time.
Author: hitsniffer.com
Version: 2.10
Author URI: http://www.hitsniffer.com/
*/ 


add_action('admin_menu', 'hs_admin_menu');
add_action('wp_footer', 'hitsniffer');
add_action('wp_head', 'hitsniffer');
hitsniffer_admin_warnings();

function hitsniffer_load_plugin_textdomain() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'hit-sniffer-blog-stats' );
	if ( $loaded = load_textdomain( 'hit-sniffer-blog-stats', trailingslashit( WP_LANG_DIR ) .'hit-sniffer-blog-stats' . '/' .'hit-sniffer-blog-stats' . '-' . $locale . '.mo' ) ) {
		return $loaded;
	} else {
		load_plugin_textdomain( 'hit-sniffer-blog-stats', FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );
	}
}
add_action( 'plugins_loaded', 'hitsniffer_load_plugin_textdomain' );




function hitsniffer() {
global $current_user;
global $_SERVER,$_COOKIE,$hitsniffer_tracker;

$option=get_hs_conf();
$option['code']=str_replace("\r",'',str_replace("\n",'',str_replace(" ","",trim(html_entity_decode($option['code'])))));

	if( round($option['iga'])==1 && current_user_can("manage_options") ) {

		echo "\n<!-- ".__("Hit Sniffer tracking code not shown because you're an administrator and you've configured Hitsniffer plugin to ignore administrators.", 'hit-sniffer-blog-stats')." -->\n";

		return;

	}

$htmlpar='';
$purl='http://www.';
$htssl='';
  if (isset($_SERVER["HTTPS"])){
      if ($_SERVER["HTTPS"]=='on'){
        $purl='https://';
        $htssl=" - SSL";
      }
  }
  if (isset($_SERVER["HTTP_X_FORWARDED_PROTO"])){
  if ($_SERVER["HTTP_X_FORWARDED_PROTO"]=='https'){
        $purl='https://';
        $htssl=" - SSL";
  }
  }

?><!-- HITSNIFFER TRACKING CODE<?php echo $htssl; ?> v2.10 - DO NOT CHANGE --><?php



if (is_search()){



if (round($hitsniffer_tracker)==0){

?><script>MySearch='<?php echo addslashes(get_search_query()); ?>';</script><?php

}



$htmlpar.='&MySearch='.urlencode(addslashes(get_search_query()));



} ?><?php





	if( $option['tkn']!=2 ) {

?><?php if (round($hitsniffer_tracker)==0){ ?>

	<script type='text/javascript'>


function hitsniffer_gc( name ) {

		if (document.cookie){
		var hs_cookie_split = document.cookie.split(';');
		if (hs_cookie_split){
		for( var i in hs_cookie_split ) {
		if (typeof hs_cookie_split[i] == "undefined"){}else{
			if( hs_cookie_split[i].indexOf( name+'=' ) != -1 )
				return decodeURIComponent( hs_cookie_split[i].split('=')[1] );
		}
		}
		}
		}
		return '';
	}






ipname='<?php





      get_currentuserinfo();



      echo $current_user->user_login

?>';





		ipnames=hitsniffer_gc( 'comment_author_<?php echo md5( get_option("siteurl") ); ?>' );

		if (ipnames!='') ipname=ipnames;

  	</script><?php } ?>

<?php

if (!isset($_COOKIE['comment_author_'.md5( get_option("siteurl"))])) $_COOKIE['comment_author_'.md5( get_option("siteurl"))]='';

$ipname=$_COOKIE['comment_author_'.md5( get_option("siteurl"))]; 



if ($ipname=='') $ipname=$current_user->user_login;



if ($ipname!=''){

$htmlpar.='&amp;ipname='.urlencode(addslashes($ipname));

}

	

	}

if (!isset($_SERVER["HTTP_REFERER"])) $_SERVER["HTTP_REFERER"]="";
	

$htmlpar.='&amp;ref='.urlencode(addslashes($_SERVER["HTTP_REFERER"]));

$htmlpar.='&amp;title='.urlencode(addslashes(wp_title('',false)));

$keyword[0]='web stats';
$keyword[1]='website statistics';
$keyword[2]='Website analytics';
$keyword[3]='Website analytics tool';
$keyword[4]='Website analytics software';
$keyword[5]='live website statistics';

$kwid=mt_rand(0,5);
//$kwid=mt_rand(0,35);


if ($option['stats']!=2){
//$stats_widget="publish=1&";
}




?><?php if (round($hitsniffer_tracker==0)){ ?>

<script>

(function(){

var hstc=document.createElement('script');

var hstcs='www.';

hstc.src='<?php echo $purl; ?>hitsniffer.com/track.php?code=<?php echo substr($option['code'],0,32); ?>';

hstc.async=true;

var htssc = document.getElementsByTagName('script')[0];

htssc.parentNode.insertBefore(hstc, htssc);

})();



<?php if (round($option['allowchat'])==2){ ?>var nochat=1;

<?php }else{ ?>var nochat=0;<?php } ?>

</script>
<?php if (round($option['allowfloat'])!=2){ ?>
<script src="<?php echo $purl; ?>hitsniffer.com/onlinefloat.php?code=<?php echo substr($option['code'],0,32); ?>" type="text/javascript" ></script>
<?php } ?>
<?php }else{ ?>

<noscript><a href="http://www.hitsniffer.com/"><img src="<?php echo $purl; ?>hitsniffer.com/track.php?mode=img&amp;code=<?php echo substr($option['code'],0,32); ?><?php echo $htmlpar; ?>" alt="<?php echo $keyword[$kwid]; ?>" border='0' width='1' height='1' /><?php echo $keyword[$kwid]; ?></a></noscript>

<?php } ?>

<!-- HITSNIFFER TRACKING CODE<?php echo $htssl; ?><?php if (round($hitsniffer_tracker==0)){ ?> - Header Code<?php }else{ ?> - Footer Code<?php } ?> - DO NOT CHANGE --><?php 



$hitsniffer_tracker=1;



}







function hitsniffer_admin_warnings() {

$option=get_hs_conf();


if (!isset($option['code'])) $option['code']='';
if (!isset($_REQUEST['hitmagic'])) $_REQUEST['hitmagic']='';

if (isset($_POST['action'])){
$postaction=$_POST['action'];
}else{
$postaction='';
}




	if ( $option['code']=='' && $postaction!='do' && $_REQUEST['hitmagic']!='do' ) {

		function hitsniffer_warning() {

			echo "

			<div id='hitsniffer-warning' class='updated fade'><p><strong>".__('Hitsniffer is almost ready.','hit-sniffer-blog-stats')."</strong> ".sprintf(__('You must <a href="%1$s">enter your Hitsniffer API key</a> to start tracking your stats.','hit-sniffer-blog-stats'), "options-general.php?page=hit-sniffer-blog-stats/hitsniffer.php")."</p></div>

			";

		}

		add_action('admin_notices', 'hitsniffer_warning');

		return;

	}

}



function get_hs_conf(){

$option=get_option('hs_setting');


//remove PHP Notices
if (!isset($option['code'])) $option['code']='';
if (!isset($option['wgd'])) $option['wgd']=1;
if (!isset($option['wgl'])) $option['wgl']=2;
if (!isset($option['tkn'])) $option['tkn']=1;
if (!isset($option['iga'])) $option['iga']=0;
if (!isset($option['igac'])) $option['igac']=0;
if (!isset($option['allowchat'])) $option['allowchat']=1;
if (!isset($option['allowfloat'])) $option['allowfloat']=2;
if (!isset($option['xtheme'])) $option['xtheme']=2;
if (!isset($option['stats'])) $option['stats']=2;
if (!isset($option['wpmap'])) $option['wpmap']=2;
if (!isset($option['wpdash'])) $option['wpdash']=2;

if (round($option['wgd'])==0) $option['wgd']=1;
if (round($option['wgl'])==0) $option['wgl']=2;

if (round($option['tkn'])==0) $option['tkn']=1;

if (round($option['iga'])==0) $option['iga']=0;
if (round($option['igac'])==0) $option['igac']=0;

if (round($option['allowchat'])==0) $option['allowchat']=1;
if (round($option['allowfloat'])==0) $option['allowfloat']=2;

if (round($option['xtheme'])==0) $option['xtheme']=2;

if (round($option['stats'])==0) $option['stats']=2;

if (round($option['wpmap'])==0) $option['wpmap']=2;
if (round($option['wpdash'])==0) $option['wpdash']=2;



return $option;

}

function set_hs_conf($conf){update_option('hs_setting',$conf);}





function hs_admin_menu(){

$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

	add_options_page(__("Hit Sniffer Options",'hit-sniffer-blog-stats'), __("Hit Sniffer",'hit-sniffer-blog-stats'),  'manage_options', __FILE__, 'hs_optionpage');

}



function hs_optionpage(){

$option=get_hs_conf();

$option['code']=html_entity_decode($option['code']);

$option['wgd']=html_entity_decode($option['wgd']);

$option['wgl']=html_entity_decode($option['wgl']);

$option['allowchat']=html_entity_decode($option['allowchat']);
$option['allowfloat']=html_entity_decode($option['allowfloat']);

$option['xtheme']=html_entity_decode($option['xtheme']);

$option['stats']=html_entity_decode($option['stats']);

$option['wpmap']=html_entity_decode($option['wpmap']);
$option['wpdash']=html_entity_decode($option['wpdash']);


$magicable=0; //temporary disable magic feature


if (!isset($_POST['action'])) $_POST['action']='';
if (!isset($saved)) $saved='';
if (!isset($hcresult )) $hcresult ='';
if (!isset($magiced )) $magiced ='';


		if ($_POST['action']=='do'){
		
if (!current_user_can('manage_options')){
$_POST['wgl']=$option['wgl'];
}
			$option=$_POST;

			$option['code']=htmlentities(str_replace(" ","",stripslashes($option['code'])));

            set_hs_conf($option);

			$saved=1;
		}


?>

<div class="wrap">

<style>

input{ width: 99%; }

textarea{ width: 99%; }

select{ width: 100%; }

</style>

<?php

if ($saved==1){

?>



<br>

<div id='hitsniffer-saved' class='updated fade' ><p><strong><?php echo __("Hit Sniffer plugin setting have been saved.",'hit-sniffer-blog-stats');?></strong> <?php if ($option['code']!=''){ ?><?php if (round($magiced)==0){ ?><?php echo __("We have started tracking your visitors.",'hit-sniffer-blog-stats');?> <?php } ?><?php if (round($magiced)==0){ ?><a href="http://www.hitsniffer.com/login-code.php?code=<?php echo $option['code']; ?>">

	<?php echo __("You can monitor your visitor activity in real time here, but hey! Please wait until we track some visitors first!",'hit-sniffer-blog-stats');?></a><?php }else{ ?><?php echo __("We have started tracking your visitors.",'hit-sniffer-blog-stats');?><?php }}else{ ?><?php echo __("Please get your Hitsniffer API code to enable us to start tracking your site visitors, for you.",'hit-sniffer-blog-stats');?><?php } ?></p></div>

		<br>	



<?php





if(function_exists('wp_cache_clean_cache')){

global $file_prefix;

wp_cache_clean_cache($file_prefix);

}





}
$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
?>



<h2>


<img src="<?php echo $x; ?>favicon.png" style="vertical-align: middle; padding-right: 3px; " />

<a target="_blank" href="http://www.hitsniffer.com/?tag=wordpress-to-homepage"><?php echo __("Hit Sniffer - an eye on your site",'hit-sniffer-blog-stats');?></a></h2>

<form method="POST" action="<?php echo str_replace('&hitmagic=do','',$_SERVER['REQUEST_URI']); ?>">




<div>


<?php if ($option['code']!=''){

$magicable=0;

 ?>
 
 
 
<center>
<a class='btn' style="margin-bottom: 15px;padding: 10px;" href="http://www.hitsniffer.com/login-code.php?code=<?php echo $option['code']; ?>" target="_blank"><?php echo __("Monitor your visitor activity, Click to open your real time dashboard.",'hit-sniffer-blog-stats');?></a>
</center>
<?php } 
$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
?>

<div class="tdhdr">
<div class="tdhdrw">



<style>
.lcd{

background-color: #496b9a;
background-image: 	-webkit-gradient(linear, left top, left bottom, 
					from(#889ab4), 
					color-stop(0.5, #6380a9), 
					color-stop(0.5, #486a98), 
					to(#496b9a));
					
background-image:  -moz-linear-gradient(top,
					#889ab4, 
					#6380a9 50%, 
					#486a98 50%, 
					#496b9a); 

background-image: -o-linear-gradient(
    center bottom,
    rgb(48, 69, 96) 60%,
    rgb(96, 122, 149) 65%
);

background-image: linear-gradient(
    center bottom,
    rgb(48, 69, 96) 60%,
    rgb(96, 122, 149) 65%
);


box-shadow: 0px 0px 1px #2E445C, 0px 2px 3px #2E445C;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;

width: 106px;
height: 95px;
color: #fff;
text-align: center;
float: left;
margin-right: 12px;
font-family: Trebuchet MS;
text-shadow: 0px -1px 1px #fff, 0px 1px 1px #000;
cursor: default;


/* For Internet Explorer 5.5 - 7 */
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#FF889ab4, endColorstr=#FF496b9a);
/* For Internet Explorer 8 */
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#FF889ab4, endColorstr=#FF496b9a)";

}

.lcdcolor{
margin-top: 1px;
padding: 5px;
background-color: #2E445C;
background-image: 	-webkit-gradient(linear, left top, left bottom, 
					from(#889ab4), 
					color-stop(0.5, #6380a9), 
					color-stop(0.5, #486a98), 
					to(#496b9a));
					
background-image:  -moz-linear-gradient(top,
					#889ab4, 
					#6380a9 50%, 
					#486a98 50%, 
					#496b9a); 

background-image: -o-linear-gradient(
    center bottom,
    rgb(48, 69, 96) 60%,
    rgb(96, 122, 149) 65%
);
/* For Internet Explorer 5.5 - 7 */
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#FF889ab4, endColorstr=#FF496b9a);
/* For Internet Explorer 8 */
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#FF889ab4, endColorstr=#FF496b9a)";


box-shadow: 0px 0px 1px #2E445C, 0px 2px 3px #2E445C;
border-radius: 2px;
height: 15px;
overflow: hidden;
color: #fff;
text-align: left;
font-family: Trebuchet MS;
text-shadow: 0px -1px 1px #fff, 0px 1px 1px #000;

}
.lcdcolor a{
color: #fff;
text-decoration: none;
}
.lcdcolor a:hover{
text-decoration: underline;
}

.lcdd{
margin: 5px;
font-size: 10pt;
}
.lcdx{
margin: 5px;
font-size: 36pt;
font-weight: 700;
}


.tipmsg{
border-radius: 4px;
-moz-border-radius: 4px;
-webkit-border-radius: 4px;
outline:none;


border: 5px solid #A4C1DF;
box-shadow:0 0 8px #A4C1DF;
-moz-box-shadow:0 0 8px #A4C1DF;
-webkit-box-shadow:0 0 8px #A4C1DF;
padding: 10px;

background-color: rgb(245,245,245); 
background-image: -webkit-gradient(
    linear,
    left bottom,
    left top,
    color-stop(0, rgb(241,241,241)),
    color-stop(1, rgb(250,250,250))
);
background-image: -moz-linear-gradient(
    center bottom,
    rgb(241,241,241) 0%,
    rgb(250,250,250) 100%
);

background-image: -o-linear-gradient(
       top,
       rgb(250,250,250) 48%,
       rgb(241,241,241) 52%
);

text-shadow: rgba(255,255, 255, 1) 0px 1px;
/* For Internet Explorer 5.5 - 7 */
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFFFFFFF, endColorstr=#FFF1F1F1);
/* For Internet Explorer 8 */
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFFFFFFF, endColorstr=#FFF1F1F1)";

}

.tdhdr{
	-moz-border-radius: 5px;-webkit-border-radius: 5px;border-radius: 5px; border: 1px solid #bbb;background-color: #ffffff;padding: 10px;
	background-image: -webkit-gradient(
    linear,
    left bottom,
    left top,
    color-stop(0, rgb(241,241,241)),
    color-stop(1, rgb(250,250,250))
);
background-image: -moz-linear-gradient(
    center bottom,
    rgb(241,241,241) 0%,
    rgb(250,250,250) 100%
);

background-image: -o-linear-gradient(
       top,
       rgb(250,250,250) 48%,
       rgb(241,241,241) 52%
);


/* For Internet Explorer 5.5 - 7 */
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFFDFDFD, endColorstr=#FFF1F1F1);
/* For Internet Explorer 8 */
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFFDFDFD, endColorstr=#FFF1F1F1)";



}
.tdhdrw{
	-moz-border-radius: 5px;-webkit-border-radius: 5px;border-radius: 5px; border: 1px solid #bbb;background-color: #ffffff;padding: 10px;
	background-image: -webkit-gradient(
    linear,
    left bottom,
    left top,
    color-stop(0, rgb(248,248,248)),
    color-stop(1, rgb(255,255,255))
);
background-image: -moz-linear-gradient(
    center bottom,
    rgb(248,248,248) 0%,
    rgb(255,255,255) 100%
);
background-image: -o-linear-gradient(
       top,
       rgb(255,255,255) 48%,
       rgb(248,248,248) 52%
);



/* For Internet Explorer 5.5 - 7 */
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFFFFFFF, endColorstr=#FFF8F8F8);
/* For Internet Explorer 8 */
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFFFFFFF, endColorstr=#FFF8F8F8)";
}
.btn,button,.button{
transition:border linear .3s,box-shadow linear .3s;-moz-transition:border linear .3s,-moz-box-shadow linear .3s;-webkit-transition:border linear .3s,-webkit-box-shadow linear .3s;

display: inline-block;
width: auto;
background-color: #f5f5f5; 
background-image: -webkit-gradient(
    linear,
    left bottom,
    left top,
    color-stop(0.48, rgb(241,241,241)),
    color-stop(0.52, rgb(250,250,250))
);
background-image: -moz-linear-gradient(
    center bottom,
    rgb(241,241,241) 48%,
    rgb(250,250,250) 52%
);
background-image: -o-linear-gradient(
       top,
       rgb(250,250,250) 48%,
       rgb(241,241,241) 52%
);


/* For Internet Explorer 5.5 - 7 */
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFFDFDFD, endColorstr=#FFF1F1F1);
/* For Internet Explorer 8 */
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFFDFDFD, endColorstr=#FFF1F1F1)";


color: #777777;
font-weight: bold;
text-decoration: none;
padding: 6px;
padding-left: 10px;
padding-right: 10px;
border: 1px solid #dddddd;
-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;
text-shadow: rgba(255, 255, 255, 1) 0px 1px;
font-size: 9pt;
white-space: nowrap;
cursor: pointer;
}

.btn:hover,button:hover,.button:hover{
color: #000;
text-decoration: none;
border: 1px solid #939393;
background-image: -webkit-gradient(
    linear,
    left bottom,
    left top,
    color-stop(0.48, rgb(241,241,241)),
    color-stop(0.52, rgb(255,255,255))
);
background-image: -moz-linear-gradient(
    center bottom,
    rgb(241,241,241) 48%,
    rgb(255,255,255) 52%
);
background-image: -o-linear-gradient(
       top,
       rgb(255,255,255) 48%,
       rgb(241,241,241) 52%
);



outline: 0;
/* For Internet Explorer 5.5 - 7 */
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFFFFFFF, endColorstr=#FFF1F1F1);
/* For Internet Explorer 8 */
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFFFFFFF, endColorstr=#FFF1F1F1)";
}
.btn:active,button:active,.button:active{


box-shadow: inset 1px 1px 1px rgba(0,0,0,0.2);
outline: 0;
background-image: -webkit-gradient(
    linear,
    left bottom,
    left top,
    color-stop(0.48, rgb(255,255,255)),
    color-stop(0.52, rgb(241,241,241))
);
background-image: -moz-linear-gradient(
    center bottom,
    rgb(255,255,255) 48%,
    rgb(241,241,241) 52%
);
background-image: -moz-linear-gradient(
    center bottom,
    rgb(255,255,255) 48%,
    rgb(241,241,241) 52%
);
/* For Internet Explorer 5.5 - 7 */
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFF1F1F1, endColorstr=#FFFFFFFF);
/* For Internet Explorer 8 */
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFF1F1F1, endColorstr=#FFFFFFFF)";

}

.clear{
clear: both;
}
</style>






<?php if ($option['code']!=''){ ?><a target="_blank" href="http://www.hitsniffer.com/login-code.php?code=<?php echo $option['code']; ?>"><?php }else{ ?><a target="_blank" href="http://www.hitsniffer.com/features.php"><?php } ?>
<img border="0" src="<?php echo $x; ?>hitsniffer.jpg" style="margin:5px;margin-left: 30px;" width="169" height="100" align="right"></a>


<p style="margin: 0; padding: 0px;"><?php echo __("Hit Sniffer real time visitor activity tracker and analytics, allows you to be aware what is going in your wordpress blog and sites right now and has detailed archive for tracked visitor data. If you don't have an API code yet, you can get your free trial one at our website",'hit-sniffer-blog-stats');?> <a href="http://www.hitsniffer.com/register.php?tag=wordpress-to-ht">hitsniffer.com</a>.

<div class="clear"></div>
</div>





<div class="tdhdr" style="margin-top: 10px;">


<strong><?php echo __("Hit Sniffer API Code",'hit-sniffer-blog-stats');?>:</strong> ( <a href="http://www.hitsniffer.com/register.php?tag=wp-getyourcode" target="_blank"><?php echo __("Get your code",'hit-sniffer-blog-stats');?><?php if ($magicable){ ?><?php } ?></a> ) <br>

	<input type="text" name="code" size="20" value="<?php echo $option['code']; ?>"><br><?php echo __("Each site has its own API Code. It looks something like this 3defb4a2e4426642ea... and can be found in your settings page on hitsniffer.com",'hit-sniffer-blog-stats');?></p>



<div class="tdhdrw">
<b><?php echo __("Advanced Settings",'hit-sniffer-blog-stats');?>:</b><br>


<p><input type="radio" value="1" name="wgd" style="width: 22px; height: 20px;" <?php if ($option['wgd']!=2) echo "checked"; ?>><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;

<input type="radio" value="2" name="wgd" style="width: 22px; height: 20px;" <?php if ($option['wgd']==2) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;&nbsp;<?php echo __("Show hit sniffer quick summary in Wordpress dashboard?",'hit-sniffer-blog-stats');?>

</p>
<?php 
if (current_user_can('manage_options')){
?>
<p><input type="radio" value="2" name="wgl"  style="width: 22px; height: 20px;" <?php if ($option['wgl']==2) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;

<input type="radio" value="1" name="wgl"  style="width: 22px; height: 20px;" <?php if ($option['wgl']!=2) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;&nbsp;<?php echo __("Enable Dashboard widget for administrators only ( recommended for security )",'hit-sniffer-blog-stats');?>

</p>
<?php } ?>
<p><input type="radio" value="1" name="tkn" style="width: 22px; height: 20px;" <?php if ($option['tkn']!=2) echo "checked"; ?>><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;

<input type="radio" value="2" name="tkn" style="width: 22px; height: 20px;" <?php if ($option['tkn']==2) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;&nbsp;<?php echo __("Track visitors name ( using name they enter when commenting )?",'hit-sniffer-blog-stats');?>

</p>

<p><input type="radio" value="1" name="iga" style="width: 22px; height: 20px;" <?php if (round($option['iga'])==1) echo "checked"; ?>><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;

<input type="radio" value="2" name="iga" style="width: 22px; height: 20px;" <?php if (round($option['iga'])!=1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;&nbsp;<?php echo __("Ignore admin visits (remove tracking code for admins)?",'hit-sniffer-blog-stats');?>

</p>


<p><input type="radio" value="1" name="igac" style="width: 22px; height: 20px;" <?php if (round($option['igac'])==1) echo "checked"; ?>><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;

<input type="radio" value="2" name="igac" style="width: 22px; height: 20px;" <?php if (round($option['igac'])!=1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;&nbsp;<?php echo __("Ignore admin visits by encorcing cookie block method on admin dashboard widgets?",'hit-sniffer-blog-stats');?>

</p>

<p><input type="radio" value="1" name="allowchat"  style="width: 22px; height: 20px;" <?php if ($option['allowchat']!=2) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;

<input type="radio" value="2" name="allowchat"  style="width: 22px; height: 20px;" <?php if ($option['allowchat']==2) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;&nbsp;<?php echo __("Enable \"chat with your visitors feature\"",'hit-sniffer-blog-stats');?>

</p>

<p><input type="radio" value="1" name="allowfloat"  style="width: 22px; height: 20px;" <?php if ($option['allowfloat']!=2) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;

<input type="radio" value="2" name="allowfloat"  style="width: 22px; height: 20px;" <?php if ($option['allowfloat']==2) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;&nbsp;<?php echo __("Enable floating chat widget on bottom right of site",'hit-sniffer-blog-stats');?>

</p>

<p><input type="radio" value="2" name="xtheme"  style="width: 22px; height: 20px;" <?php if ($option['xtheme']==2) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;

<input type="radio" value="1" name="xtheme"  style="width: 22px; height: 20px;" <?php if ($option['xtheme']!=2) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;&nbsp;<?php echo __("Use the compact Theme for wordpress dashboard widget?",'hit-sniffer-blog-stats');?>

</p>

<p>



<input type="radio" value="2" name="wpdash"  style="width: 22px; height: 20px;" <?php if ($option['wpdash']==2) echo "checked"; ?>><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;
<input type="radio" value="1" name="wpdash"  style="width: 22px; height: 20px;" <?php if ($option['wpdash']==1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;&nbsp;<?php echo __("Show mini Hitsniffer dashboard (Recent visitors) in wordpress admin dashboard?",'hit-sniffer-blog-stats');?>
</p>

<p>
<?php echo __("Show Visitor Map in wordpress admin dashboard?",'hit-sniffer-blog-stats');?>
<br>
<input type="radio" value="1" name="wpmap"  style="width: 22px; height: 20px;" <?php if ($option['wpmap']==1) echo "checked"; ?>><?php echo __("Online Visitors",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;
<input type="radio" value="2" name="wpmap"  style="width: 22px; height: 20px;" <?php if ($option['wpmap']==2) echo "checked"; ?>><?php echo __("Today",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;
<input type="radio" value="3" name="wpmap"  style="width: 22px; height: 20px;" <?php if ($option['wpmap']==3) echo "checked"; ?>><?php echo __("Disable Map Widget in admin dashboard",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;
</p>


	

</div>
	<input type="submit" value="Save Changes" style="width: 170px; padding: 10px; margin-top: 10px;" class="btn">
</div>
</div>



<?php if ($option['code']==''){ ?>

<div style="margin-top: 15px;" class="tipmsg">
<p style="margin: 0px; padding:0px;"><h2 style="margin: 0px; padding:0px;"><?php echo __("How to setup Hit Sniffer on Wordpress?",'hit-sniffer-blog-stats');?></h2><br><a href="http://www.hitsniffer.com/register.php?tag=wordpress-to-ht-reg"><?php echo __("Just sign up for a hit sniffer account</a> and follow our extremely simple instructions.",'hit-sniffer-blog-stats');?><br><br>

<?php echo __("Login to your hit sniffer account, add your website address to your hit sniffer account.",'hit-sniffer-blog-stats');?><br><?php echo __("Then in the Hitsniffer.com settings page, you will find your Hit Sniffer API code.",'hit-sniffer-blog-stats');?><br>

<?php echo __("Copy and paste the API code into the specified field above and click save changes. That is all!<br>All your visitor information will be tracked and logged in real-time and you can monitor the data live in your Hitsniffer.com dashboard.",'hit-sniffer-blog-stats');?></p>

</div>

<?php } ?>

	<br><p  style="margin: 0px; padding:0px;"><a href="http://www.hitsniffer.com/features.php" target="_blank"><?php echo __("View the features of Hitsniffer",'hit-sniffer-blog-stats');?></a></p>
<br>
<p  style="margin: 0px; padding:0px;"><?php echo __("Hitsniffer also supports normal websites ( non wordpress pages ).",'hit-sniffer-blog-stats');?><?php if ($option['code']!=''){ ?><br>

<?php echo __("If you have a normal website then all you have to do is input the tracking code on each page of your website, a header of footer page is ideal for this.",'hit-sniffer-blog-stats');?></p>

<p class="submit"><?php echo __("Website Code",'hit-sniffer-blog-stats');?>:<br>

<textarea rows="6" name="wcode" cols="100" readonly><!-- HITSNIFFER TRACKING CODE - DO NOT CHANGE -->
<script src="http://www.hitsniffer.com/track.php?code=<?php echo substr($option['code'],0,32); ?>" type="text/javascript" ></script>
<noscript><a href="http://www.hitsniffer.com/">
<img src="http://www.hitsniffer.com/track.php?mode=img&code=<?php echo substr($option['code'],0,32); ?>" alt="Realtime website statistics" border='0' width='1' height='1' />realtime web visitor analytics chat support</a></noscript>
<!-- HITSNIFFER TRACKING CODE - DO NOT CHANGE --></textarea></p><?php } ?>

<input type="hidden" name="action" value="do">

</div>

</form>



</div>

<br>

<?php

}




function hitsniffer_dashboard_map_widget_function() {

$option=get_hs_conf();
$purl='http://www.';

if ($_SERVER["HTTPS"]=='on'){
$purl='https://';
$htssl=" - SSL";
}
  if (isset($_SERVER["HTTP_X_FORWARDED_PROTO"])){
  if ($_SERVER["HTTP_X_FORWARDED_PROTO"]=='https'){
        $purl='https://';
        $htssl=" - SSL";
  }
  }

$mapmode=$option['wpmap'];
if ($mapmode==2) $mapmode="&archive=1";
if ($mapmode==1) $mapmode="";

 if ($option['code']!=''){ ?><table border="0" cellpadding="0" style="border-collapse: collapse" width="100%">

	<tr>

		<td>


	<iframe scrollable='no' scrolling="no"  name="hit-sniffer-stat-map" frameborder="0" style="background-color: #fff; border: 1px solid #A4A2A3;" margin="0" padding="0" marginheight="0" marginwidth="0" width="100%" height="320" src="<?php echo $purl; ?>hitsniffer.com/stats/wp-map.php?code=<?php echo $option['code']; echo $mapmode; ?><?php if( round($option['igac'])==1) { ?>&cookieblock=1<?php } ?>">	

		<p align="center">
		<a href="http://www.hitsniffer.com/login-code.php?code=<?php echo $option['code']; ?>">
		<span><font face="Verdana" style="font-size: 12pt"><?php echo __("Your Browser don't show our widget's iframe. Please Open Hit Sniffer Dashboard manually.",'hit-sniffer-blog-stats');?></font></span></a></iframe></td>

	</tr>

</table>



<?php



}else{ ?><table border="0" cellpadding="0" style="border-collapse: collapse" width="100%" height="54">

	<tr>

		<td>

		<p align="left"><?php echo __("Hitsniffer API Code is not installed. Please open Wordpress settings -> Hitsniffer for instructions.",'hit-sniffer-blog-stats');?><br>
<?php echo __("You need get your free hit sniffer account to get an API key.",'hit-sniffer-blog-stats');?></td>

	</tr>

</table>



<?php



}

}



function hitsniffer_dashboard_widget_function() {
	$option=get_hs_conf();

$purl='http://www.';
if ($_SERVER["HTTPS"]=='on'){
$purl='https://';
$htssl=" - SSL";
}	
  if (isset($_SERVER["HTTP_X_FORWARDED_PROTO"])){
  if ($_SERVER["HTTP_X_FORWARDED_PROTO"]=='https'){
        $purl='https://';
        $htssl=" - SSL";
  }
  }

 if ($option['code']!=''){ ?><table border="0" cellpadding="0" style="border-collapse: collapse" width="100%">
	<tr>
		<td>
<?php
if (round($option['xtheme'])==2){
?>
	<iframe scrollable='no' scrolling="no"  name="hit-sniffer-stat" frameborder="0" style="background-color: #fff; border: 1px solid #A4A2A3;" margin="0" padding="0" marginheight="0" marginwidth="0" width="100%" height="400" src="<?php echo $purl; ?>hitsniffer.com/stats/wp3.2.php?code=<?php echo $option['code']; ?><?php if( round($option['igac'])==1) { ?>&cookieblock=1<?php } ?>">	
<?php 
}else{
?>
	<iframe scrollable='no' scrolling="no"  name="hit-sniffer-stat-compact" frameborder="0" style="background-color: #fff; border: 1px solid #A4A2A3;" margin="0" padding="0" marginheight="0" marginwidth="0" width="100%" height="420" src="<?php echo $purl; ?>hitsniffer.com/stats/wp-2.php?code=<?php echo $option['code']; ?><?php if( round($option['igac'])==1) { ?>&cookieblock=1<?php } ?>">	
<?php } ?>

		<p align="center">
		<a href="http://www.hitsniffer.com/login-code.php?code=<?php echo $option['code']; ?>">
		<span>
		<font face="Verdana" style="font-size: 12pt"><?php echo __("Your Browser don't show our widget's iframe. Please Open Hit Sniffer Dashboard manually.",'hit-sniffer-blog-stats');?></font></span></a></iframe></td>

	</tr>

</table>
<?php



}else{ ?><table border="0" cellpadding="0" style="border-collapse: collapse" width="100%" height="54">

	<tr>

		<td>

		<p align="left"><?php echo __("Hitsniffer API Code is not installed. Please open Wordpress settings -> Hitsniffer for instructions.",'hit-sniffer-blog-stats');?><br>
<?php echo __("You need get your free hit sniffer account to get an API key.",'hit-sniffer-blog-stats');?></td>

	</tr>

</table>



<?php



}

}





function hitsniffer_minidashboard_widget_function() {
	$option=get_hs_conf();

$purl='http://www.';
if ($_SERVER["HTTPS"]=='on'){
$purl='https://';
$htssl=" - SSL";
}	
  if (isset($_SERVER["HTTP_X_FORWARDED_PROTO"])){
  if ($_SERVER["HTTP_X_FORWARDED_PROTO"]=='https'){
        $purl='https://';
        $htssl=" - SSL";
  }
  }

 if ($option['code']!=''){
?>
	<iframe name="hit-sniffer-stat-mini" frameborder="0" style="background-color: #fff; border: 1px solid #A4A2A3;" margin="0" padding="0" marginheight="0" marginwidth="0" width="100%" height="420" src="<?php echo $purl; ?>hitsniffer.com/stats/wp-dashboard.php?code=<?php echo $option['code']; ?><?php if( round($option['igac'])==1) { ?>&cookieblock=1<?php } ?>">

		<p align="center">
		<a href="http://www.hitsniffer.com/login-code.php?code=<?php echo $option['code']; ?>">
		<span>
		<font face="Verdana" style="font-size: 12pt"><?php echo __("Your Browser don't show our widget's iframe. Please Open Hit Sniffer Dashboard manually by clicking here.",'hit-sniffer-blog-stats');?></font></span></a></iframe></td>

	</tr>

</table>
<?php



}else{ ?><table border="0" cellpadding="0" style="border-collapse: collapse" width="100%" height="54">

	<tr>

		<td>

		<p align="left"><?php echo __("Hitsniffer API Code is not installed. Please open Wordpress settings -> Hitsniffer for instructions.",'hit-sniffer-blog-stats');?><br>
<?php echo __("You need get your free hit sniffer account to get an API key.",'hit-sniffer-blog-stats');?></td>

	</tr>

</table>



<?php



}

}




function hitsniffer_add_dashboard_widgets() {

$option=get_hs_conf();


if ($option['wgd']!=2){
    if (function_exists('wp_add_dashboard_widget')){
    if (current_user_can('manage_options')||$option['wgl']!=2) {
      wp_add_dashboard_widget('hitsniffer_dashboard_widget', 'Hit Sniffer - '. __("Your Analytics Summary",'hit-sniffer-blog-stats'), 'hitsniffer_dashboard_widget_function');	
    }
    }
}

if ($option['wpmap']!=3){
    if (function_exists('wp_add_dashboard_widget')){
    if (current_user_can('manage_options')||$option['wgl']!=2) {
    $mapmode=__("Online",'hit-sniffer-blog-stats');
    if ($option['wpmap']=='2') $mapmode=__("Today",'hit-sniffer-blog-stats');
      wp_add_dashboard_widget('hitsniffer_dashboard_map_widget', 'Hit Sniffer - '.$mapmode.' '. __("Visitors Map",'hit-sniffer-blog-stats'), 'hitsniffer_dashboard_map_widget_function');	
    }
    }
}
if ($option['wpdash']!=1){
    if (function_exists('wp_add_dashboard_widget')){
    if (current_user_can('manage_options')||$option['wgl']!=2) {
      wp_add_dashboard_widget('hitsniffer_minidashboard_widget', 'Hit Sniffer - '. __("Recent visitors",'hit-sniffer-blog-stats'), 'hitsniffer_minidashboard_widget_function');	
    }
    }
}

}


add_action('wp_dashboard_setup', 'hitsniffer_add_dashboard_widgets' );

if (function_exists('class_exists')){
if (class_exists('WP_Widget')){

/**

 * HS_SUPPORT Class

 */

class HS_SUPPORT extends WP_Widget {

    /** constructor */

    function __construct() {

        parent::__construct(false, $name = __("Hit Sniffer Live Chat Support",'hit-sniffer-blog-stats'));	

    }



    /** @see WP_Widget::widget */

    function widget($args, $instance) {

    

    

$option=get_hs_conf();

$option['code']=substr(str_replace("\r",'',str_replace("\n",'',str_replace(" ","",trim(html_entity_decode($option['code']))))),0,32);





$purl='http://www.';

if ($_SERVER["HTTPS"]=='on'){

$purl='https://';

$htssl=" - SSL";

}

      if (isset($_SERVER["HTTP_X_FORWARDED_PROTO"])){
  if ($_SERVER["HTTP_X_FORWARDED_PROTO"]=='https'){
        $purl='https://';
        $htssl=" - SSL";
  }
  }

    

    

 if ($option['code']!=''){

        extract( $args );

        $title = apply_filters('widget_title', $instance['widget_title']);
        $widget_comments_title = apply_filters('widget_comments_title', $instance['widget_comments_title']);


        ?>

              <?php echo $before_widget; ?>

                  <?php if ( $title )

                        echo $before_title . $title . $after_title; ?>

<div style="text-align: center;" class="hs-wordpress-chat-placeholder">
<!-- HITSNIFFER ONLINE SUPPORT CODE v2.10 - DO NOT CHANGE --><script type="text/javascript">
document.write('<div id="hs-live-chat-pos"></div>');(function(){var hschatc=document.createElement('script');var hschatcs='www.';if (document.location.protocol=='https:') hschatcs='';hschatc.src=document.location.protocol+'//'+hschatcs+'hitsniffer.com/online2.php?code=<?php echo $option['code']; ?>&img=<?php echo urlencode($instance['wd_img']); ?>&off=<?php echo urlencode($instance['wd_off']); ?>';hschatc.async=true;var htsscc = document.getElementById('hs-live-chat-pos');htsscc.appendChild(hschatc);})();
</script><!-- HITSNIFFER ONLINE SUPPORT CODE - DO NOT CHANGE -->
</div>

                  <?php echo $widget_comments_title; ?>

              <?php echo $after_widget; ?>

        <?php

    }

    }



    /** @see WP_Widget::update */

    function update($new_instance, $old_instance) {		

	$instance = $old_instance;

	$instance['widget_title'] = strip_tags($new_instance['title']);
	$instance['widget_comments_title'] = strip_tags($new_instance['comment']);
	$instance['wd_img'] = strip_tags($new_instance['img']);
	$instance['wd_off'] = strip_tags($new_instance['off']);

        return $instance;

    }



    /** @see WP_Widget::form */

    function form($instance) {

    $option=get_hs_conf();		

     if ($option['code']!=''){

        $title = esc_attr($instance['widget_title']);
        $widget_comments_title = esc_attr($instance['widget_comments_title']);
        $img = esc_attr($instance['wd_img']);
        $off = esc_attr($instance['wd_off']);

        ?>

            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>

            <p><label for="<?php echo $this->get_field_id('comment'); ?>"><?php _e('Your Comment:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('comment'); ?>" name="<?php echo $this->get_field_name('comment'); ?>" type="text" value="<?php echo $widget_comments_title; ?>" /></label></p>

            <p><label for="<?php echo $this->get_field_id('img'); ?>"><?php _e('Custom Online Icon: (optional)'); ?> <input class="widefat" id="<?php echo $this->get_field_id('img'); ?>" name="<?php echo $this->get_field_name('img'); ?>" type="text" value="<?php echo $img; ?>" /></label></p>

            <p><label for="<?php echo $this->get_field_id('off'); ?>"><?php _e('Custom Offline Icon: (optional)'); ?> <input class="widefat" id="<?php echo $this->get_field_id('off'); ?>" name="<?php echo $this->get_field_name('off'); ?>" type="text" value="<?php echo $off; ?>" /></label></p>

		<p><?php echo __("What is this widget?",'hit-sniffer-blog-stats');?></p><span><?php echo __("Hit Sniffer offers a built-in live chat feature. The widget shows an online support icon whenever you are online and shows a leave a message contact form icon when you are not online.",'hit-sniffer-blog-stats');?></span>

      <br><a target="_parent" href="http://www.hitsniffer.com/widget/" target="_blank"><?php echo __("Click here to open Hit Sniffer Widgets page.",'hit-sniffer-blog-stats');?></a>
      <p><?php echo __("With our Firefox addon, you can chat to your visitors direct from a firefox pop up window.",'hit-sniffer-blog-stats');?>

</p><?php 

    }else{

            ?>

            <p><?php echo __("Please configure hit sniffer API Code in your wordpress settings -> Hit Sniffer before using the chat widget.",'hit-sniffer-blog-stats');?></p>

        <?php 

    }

    

    }





function get_hs_conf(){

$option=get_option('hs_setting');

if (round($option['wgd'])==0) $option['wgd']=1;

if (round($option['wgl'])==0) $option['wgl']=2;

if (round($option['tkn'])==0) $option['tkn']=1;

if (round($option['iga'])==0) $option['iga']=2;
if (round($option['igac'])==0) $option['igac']=2;

if (round($option['allowchat'])==0) $option['allowchat']=1;
if (round($option['allowfloat'])==0) $option['allowfloat']=2;

if (round($option['xtheme'])==0) $option['xtheme']=2;

if (round($option['stats'])==0) $option['stats']=2;

if (round($option['wpmap'])==0)  $option['wpmap'] =2;

if (round($option['wpdash'])==0) $option['wpdash']=2;


return $option;

}



} // class HS_SUPPORT
add_action('widgets_init', create_function('', 'return register_widget("HS_SUPPORT");'));


/**

 * HS_SUPPORT Class

 */

class HS_STATS extends WP_Widget {

    /** constructor */

    function __construct() {

        parent::__construct(false, $name = __("Hit Sniffer Statistics",'hit-sniffer-blog-stats'));	

    }



    /** @see WP_Widget::widget */

    function widget($args, $instance) {

    

    

$option=get_hs_conf();

if (!isset($_SERVER["HTTPS"])) $_SERVER["HTTPS"]="";
if (!isset($instance['widget_title']))$instance['widget_title']="";
if (!isset($instance['widget_comments_title']))$instance['widget_comments_title']="";
if (!isset($instance['use_theme']))$instance['use_theme']="";
	if (!isset($instance['hitsniffer_online'])) $instance['hitsniffer_online']='';
	if (!isset($instance['hitsniffer_visit'])) $instance['hitsniffer_visit']='';
	if (!isset($instance['hitsniffer_pageview'])) $instance['hitsniffer_pageview']='';
	if (!isset($instance['hitsniffer_unique'])) $instance['hitsniffer_unique']='';
	if (!isset($instance['hitsniffer_returning'])) $instance['hitsniffer_returning']='';
	if (!isset($instance['hitsniffer_new_visit'])) $instance['hitsniffer_new_visit']='';
	if (!isset($instance['hitsniffer_total_pageview'])) $instance['hitsniffer_total_pageview']='';
	if (!isset($instance['hitsniffer_total_visit'])) $instance['hitsniffer_total_visit']='';
	if (!isset($instance['hitsniffer_yesterday_visit'])) $instance['hitsniffer_yesterday_visit']='';
	if (!isset($instance['hitsniffer_yesterday_pageview'])) $instance['hitsniffer_yesterday_pageview']='';
	if (!isset($instance['hitsniffer_yesterday_unique'])) $instance['hitsniffer_yesterday_unique']='';
	if (!isset($instance['hitsniffer_yesterday_return'])) $instance['hitsniffer_yesterday_return']='';
	if (!isset($instance['hitsniffer_yesterday_new_visit'])) $instance['hitsniffer_yesterday_new_visit']='';
	if (!isset($instance['credits'])) $instance['credits']='';
	if (!isset($instance['affid'])) $instance['affid']='';


$option['code']=substr(str_replace("\r",'',str_replace("\n",'',str_replace(" ","",trim(html_entity_decode($option['code']))))),0,32);
$purl='http://www.';
if ($_SERVER["HTTPS"]=='on'){
$purl='https://';
$htssl=" - SSL";
}
  if (isset($_SERVER["HTTP_X_FORWARDED_PROTO"])){
  if ($_SERVER["HTTP_X_FORWARDED_PROTO"]=='https'){
        $purl='https://';
        $htssl=" - SSL";
  }
  }
if ($option['code']!=''){
{
        extract( $args );
        $title = apply_filters('widget_title', $instance['widget_title']);
        $widget_comments_title = apply_filters('widget_comments_title', $instance['widget_comments_title']);

        ?>

              <?php echo $before_widget; ?>

                  <?php if ( $title )

                        echo $before_title . $title . $after_title; ?>


<script src="//www.hitsniffer.com/api/widget_stats.php?code=<?php echo $option['code']; ?><?php if (!$instance['hitsniffer_online']) { ?>&online=yes<?php } ?><?php if (!$instance['hitsniffer_visit']) { ?>&visit=yes<?php } ?><?php if (!$instance['hitsniffer_pageview']) { ?>&pageview=yes<?php } ?><?php if (!$instance['hitsniffer_unique']) { ?>&unique=yes<?php } ?><?php if (!$instance['hitsniffer_returning']) { ?>&returning=yes<?php } ?><?php if (!$instance['hitsniffer_new_visit']) { ?>&new_visit=yes<?php } ?><?php if (!$instance['hitsniffer_yesterday_visit']) { ?>&yesterday_visit=yes<?php } ?><?php if (!$instance['hitsniffer_yesterday_pageview']) { ?>&yesterday_pageview=yes<?php } ?><?php if (!$instance['hitsniffer_yesterday_unique']) { ?>&yesterday_unique=yes<?php } ?><?php if (!$instance['hitsniffer_yesterday_return']) { ?>&yesterday_return=yes<?php } ?><?php if (!$instance['hitsniffer_yesterday_new_visit']) { ?>&yesterday_new_visit=yes<?php } ?><?php if (!$instance['hitsniffer_total_visit']) { ?>&total_visit=yes<?php } ?><?php if (!$instance['hitsniffer_total_pageview']) { ?>&total_pageview=yes<?php } ?>"></script>




<?php if (!$instance['use_theme']){ ?><style>
.hitsniffer_statistic_widget{

background-color: #627AAD;
border: 2px solid #ffffff;
color: #ffffff;
border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px;
box-shadow:0 0 8px rgba(82,168,236,.5);-moz-box-shadow:0 0 8px rgba(82,168,236,.6);-webkit-box-shadow:0 0 8px rgba(82,168,236,.5); padding: 10px;
font-size: 8pt;
}
.hitsniffer_online{
padding-bottom: 10px;
text-align: center;
}
#hitsniffer_online{
font-size: 15pt;
}
.hitsniffer_statistics_values{
font-weight: bold;
}
.hitsniffer_credits{
text-align: right;
font-size: 8pt;
padding-top: 5px;
}
.hitsniffer_credits a{
text-decoration: none;
color: #ffffff;
}
.hitsniffer_credits a:hover{
text-decoration: underline;
}
</style><?php } ?>
                  <?php echo $widget_comments_title; ?>

              <?php echo $after_widget; ?>

        <?php

    }}

    }



    /** @see WP_Widget::update */

    function update($new_instance, $old_instance) {				

	$instance = $old_instance;

//	$instance['widget_title'] = strip_tags($new_instance['title']);

//	$instance['widget_comments_title'] = strip_tags($new_instance['comment']);
	



        return $new_instance;

    }



    /** @see WP_Widget::form */

    function form($instance) {	



if (!isset($_SERVER["HTTPS"])) $_SERVER["HTTPS"]="";
if (!isset($instance['widget_title']))$instance['widget_title']="";
if (!isset($instance['widget_comments_title']))$instance['widget_comments_title']="";
if (!isset($instance['use_theme']))$instance['use_theme']="";
	if (!isset($instance['hitsniffer_online'])) $instance['hitsniffer_online']='';
	if (!isset($instance['hitsniffer_visit'])) $instance['hitsniffer_visit']='';
	if (!isset($instance['hitsniffer_pageview'])) $instance['hitsniffer_pageview']='';
	if (!isset($instance['hitsniffer_unique'])) $instance['hitsniffer_unique']='';
	if (!isset($instance['hitsniffer_returning'])) $instance['hitsniffer_returning']='';
	if (!isset($instance['hitsniffer_new_visit'])) $instance['hitsniffer_new_visit']='';
	if (!isset($instance['hitsniffer_total_pageview'])) $instance['hitsniffer_total_pageview']='';
	if (!isset($instance['hitsniffer_total_visit'])) $instance['hitsniffer_total_visit']='';
	if (!isset($instance['hitsniffer_yesterday_visit'])) $instance['hitsniffer_yesterday_visit']='';
	if (!isset($instance['hitsniffer_yesterday_pageview'])) $instance['hitsniffer_yesterday_pageview']='';
	if (!isset($instance['hitsniffer_yesterday_unique'])) $instance['hitsniffer_yesterday_unique']='';
	if (!isset($instance['hitsniffer_yesterday_return'])) $instance['hitsniffer_yesterday_return']='';
	if (!isset($instance['hitsniffer_yesterday_new_visit'])) $instance['hitsniffer_yesterday_new_visit']='';
	if (!isset($instance['credits'])) $instance['credits']='';
	if (!isset($instance['affid'])) $instance['affid']='';



    $option=get_hs_conf();		

     if ($option['code']!=''){  	

        $title = esc_attr($instance['widget_title']);
        $widget_comments_title = esc_attr($instance['widget_comments_title']);
        $hitsniffer_online = round(esc_attr($instance['hitsniffer_online']));
        $hitsniffer_visit = round(esc_attr($instance['hitsniffer_visit']));
        $hitsniffer_pageview = round(esc_attr($instance['hitsniffer_pageview']));
        $hitsniffer_unique = round(esc_attr($instance['hitsniffer_unique']));
        $hitsniffer_returning = round(esc_attr($instance['hitsniffer_returning']));
        $hitsniffer_new_visit = round(esc_attr($instance['hitsniffer_new_visit']));
        $hitsniffer_total_pageview = round(esc_attr($instance['hitsniffer_total_pageview']));
        $hitsniffer_total_visit = round(esc_attr($instance['hitsniffer_total_visit']));
        $hitsniffer_yesterday_visit = round(esc_attr($instance['hitsniffer_yesterday_visit']));
        $hitsniffer_yesterday_pageview = round(esc_attr($instance['hitsniffer_yesterday_pageview']));
        $hitsniffer_yesterday_unique = round(esc_attr($instance['hitsniffer_yesterday_unique']));
        $hitsniffer_yesterday_return = round(esc_attr($instance['hitsniffer_yesterday_return']));
        $hitsniffer_yesterday_new_visit = round(esc_attr($instance['hitsniffer_yesterday_new_visit']));
        $use_theme = round(esc_attr($instance['use_theme']));
        $credits = round(esc_attr($instance['credits']));
        $affid = round(esc_attr($instance['affid']));


{


        ?>




            <p><label for="<?php echo $this->get_field_id('widget_title'); ?>"><?php _e('Title:','hit-sniffer-blog-stats'); ?> <input class="widefat" id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('widget_comments_title'); ?>"><?php _e('Your Comment:','hit-sniffer-blog-stats'); ?> <input class="widefat" id="<?php echo $this->get_field_id('widget_comments_title'); ?>" name="<?php echo $this->get_field_name('widget_comments_title'); ?>" type="text" value="<?php echo $widget_comments_title; ?>" /></label></p>
            
            <p>This widget allow you to show your visitors statistics in your sidebar for public.</p>
            
            <p><input type="radio" value="0" name="<?php echo $this->get_field_name('hitsniffer_online'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_online==0) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;
               <input type="radio" value="1" name="<?php echo $this->get_field_name('hitsniffer_online'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_online==1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;<br><?php echo __("Show Online Counts",'hit-sniffer-blog-stats');?></p>
            <p><input type="radio" value="0" name="<?php echo $this->get_field_name('hitsniffer_visit'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_visit==0) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;
               <input type="radio" value="1" name="<?php echo $this->get_field_name('hitsniffer_visit'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_visit==1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;<br><?php echo __("Show Visits Today",'hit-sniffer-blog-stats');?></p>
            <p><input type="radio" value="0" name="<?php echo $this->get_field_name('hitsniffer_pageview'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_pageview==0) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;
               <input type="radio" value="1" name="<?php echo $this->get_field_name('hitsniffer_pageview'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_pageview==1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;<br><?php echo __("Show Pageviews Today",'hit-sniffer-blog-stats');?></p>
            <p><input type="radio" value="0" name="<?php echo $this->get_field_name('hitsniffer_unique'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_unique==0) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;
               <input type="radio" value="1" name="<?php echo $this->get_field_name('hitsniffer_unique'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_unique==1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;<br><?php echo __("Show New Visitors Count for Today",'hit-sniffer-blog-stats');?></p>
            <p><input type="radio" value="0" name="<?php echo $this->get_field_name('hitsniffer_returning'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_returning==0) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;
               <input type="radio" value="1" name="<?php echo $this->get_field_name('hitsniffer_returning'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_returning==1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;<br><?php echo __("Show Returning Visitors Today",'hit-sniffer-blog-stats');?></p>
            <p><input type="radio" value="0" name="<?php echo $this->get_field_name('hitsniffer_new_visit'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_new_visit==0) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;
               <input type="radio" value="1" name="<?php echo $this->get_field_name('hitsniffer_new_visit'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_new_visit==1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;<br><?php echo __("Show New Visits % Today",'hit-sniffer-blog-stats');?></p>
---
            <p><input type="radio" value="0" name="<?php echo $this->get_field_name('hitsniffer_yesterday_visit'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_yesterday_visit==0) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;
               <input type="radio" value="1" name="<?php echo $this->get_field_name('hitsniffer_yesterday_visit'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_yesterday_visit==1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;<br><?php echo __("Show Vists Yesterday",'hit-sniffer-blog-stats');?></p>
            <p><input type="radio" value="0" name="<?php echo $this->get_field_name('hitsniffer_yesterday_pageview'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_yesterday_pageview==0) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;
               <input type="radio" value="1" name="<?php echo $this->get_field_name('hitsniffer_yesterday_pageview'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_yesterday_pageview==1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;<br><?php echo __("Show Pageviews Yesterday",'hit-sniffer-blog-stats');?></p>
            <p><input type="radio" value="0" name="<?php echo $this->get_field_name('hitsniffer_yesterday_unique'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_yesterday_unique==0) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;
               <input type="radio" value="1" name="<?php echo $this->get_field_name('hitsniffer_yesterday_unique'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_yesterday_unique==1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;<br><?php echo __("Show New Visitors Count for Yesterday",'hit-sniffer-blog-stats');?></p>
            <p><input type="radio" value="0" name="<?php echo $this->get_field_name('hitsniffer_yesterday_return'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_yesterday_return==0) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;
               <input type="radio" value="1" name="<?php echo $this->get_field_name('hitsniffer_yesterday_return'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_yesterday_return==1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;<br><?php echo __("Show Returning Visitors Yesterday",'hit-sniffer-blog-stats');?></p>
            <p><input type="radio" value="0" name="<?php echo $this->get_field_name('hitsniffer_yesterday_new_visit'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_yesterday_new_visit==0) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;
               <input type="radio" value="1" name="<?php echo $this->get_field_name('hitsniffer_yesterday_new_visit'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_yesterday_new_visit==1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;<br><?php echo __("Show New Visits % Yesterday",'hit-sniffer-blog-stats');?></p>
---
            <p><input type="radio" value="0" name="<?php echo $this->get_field_name('hitsniffer_total_pageview'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_total_pageview==0) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;
               <input type="radio" value="1" name="<?php echo $this->get_field_name('hitsniffer_total_pageview'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_total_pageview==1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;<br><?php echo __("Show Total Pageviews",'hit-sniffer-blog-stats');?></p>
            <p><input type="radio" value="0" name="<?php echo $this->get_field_name('hitsniffer_total_visit'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_total_visit==0) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;
               <input type="radio" value="1" name="<?php echo $this->get_field_name('hitsniffer_total_visit'); ?>"  style="width: 22px; height: 20px;" <?php if ($hitsniffer_total_visit==1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;<br><?php echo __("Show Total Visits",'hit-sniffer-blog-stats');?></p>
---              
            <p><input type="radio" value="0" name="<?php echo $this->get_field_name('use_theme'); ?>"  style="width: 22px; height: 20px;" <?php if ($use_theme==0) echo "checked"; ?> checked><?php echo __("Yes",'hit-sniffer-blog-stats');?>&nbsp;
               <input type="radio" value="1" name="<?php echo $this->get_field_name('use_theme'); ?>"  style="width: 22px; height: 20px;" <?php if ($use_theme==1) echo "checked"; ?>><?php echo __("No",'hit-sniffer-blog-stats');?>&nbsp;&nbsp;<br><?php echo __("Use Custom Theme?",'hit-sniffer-blog-stats');?></p>
            
 
      <?php 

}
    }else{

            ?>

            <p><?php echo __("Please configure your  Hitsniffer API Code in your \"wordpress Settings -> Hit Sniffer\" before using the statistics widget.",'hit-sniffer-blog-stats');?></p>

        <?php 

    }

    

    }





function get_hs_conf(){

$option=get_option('hs_setting');

if (round($option['wgd'])==0) $option['wgd']=1;
if (round($option['wgl'])==0) $option['wgl']=2;

if (round($option['tkn'])==0) $option['tkn']=1;

if (round($option['iga'])==0) $option['iga']=2;
if (round($option['igac'])==0) $option['igac']=2;

if (round($option['allowchat'])==0) $option['allowchat']=1;
if (round($option['allowfloat'])==0) $option['allowfloat']=2;

if (round($option['xtheme'])==0) $option['xtheme']=2;

if (round($option['stats'])==0) $option['stats']=2;

if (round($option['wpmap'])==0) $option['wpmap']=2;
if (round($option['wpdash'])==0) $option['wpdash']=2;

return $option;

}



} // class HS_STATS



// register HS_STATS widget

add_action('widgets_init', create_function('', 'return register_widget("HS_STATS");'));


}}

	# add "Settings" link to plugin on plugins page
	add_filter('plugin_action_links', 'hitsniffer_settingsLink', 0, 2);
	function hitsniffer_settingsLink($actionLinks, $file) {
 		if (($file == 'hit-sniffer-blog-stats/hitsniffer.php') && function_exists('admin_url')) {
			$settingsLink = '<a href="' . admin_url('options-general.php?page=hit-sniffer-blog-stats/hitsniffer.php') . '">' . __('Settings','hit-sniffer-blog-stats') . '</a>';

			# Add 'Settings' link to plugin's action links
			array_unshift($actionLinks, $settingsLink);
		}

		return $actionLinks;
	}



?>