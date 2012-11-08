<?php
//ini_set('display_errors', '0');
session_start();
header("Content-Type: text/html; charset=utf-8");
include 'config.php';
include('../functions/functions.php');
checkLogin(1);//2, 3, 4 ...visszautitva
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/admin.css" />
<link rel="stylesheet" type="text/css" href="css/ajax.css" />
<link href="validate.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/dashboard.css" media="screen" />
<script type="text/javascript" src="../3rdparty/mootools/mootools-1.2.1-core-yc.js"></script>
<script type="text/javascript" src="../3rdparty/mootools/mootools-1.2-more.js"></script>


<script type="text/javascript" src="3rdparty/calendar/calendar.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="3rdparty/tigra/tigra_tables.js"></script>
<link href="validate.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="utils/date-en-GB.js"></script>
<script type="text/javascript" src="validate.js"></script>

<script type="text/javascript" src="js/csv_datum.js"></script> 
<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	// General options
	mode : "textareas",
    //language : "hu",
	theme : "advanced",
	entities: "",
	plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

	// Theme options
	theme_advanced_styles : "Pillangó=pillango_bg",
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	// Example content CSS (should be your site CSS)
	content_css : "css/style.css",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js",
	
	editor_selector : "mcefull_editor",

	// Replace values for the template plugin
	template_replace_values : {
		username : "Some User",
		staffid : "991234"
	}
});

tinyMCE.init({
    theme : "advanced",
    mode : "textareas",
    //language : "hu",
    entities: "",
	theme_advanced_styles : "Pillangó=pillango_bg",
    theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,styleselect,bullist,numlist,undo,redo,link,unlink,copy,paste,pastetext,pasteword,removeformat,code",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",

    editor_selector : "mcelead_editor"
});
</script>
<!-- /tinyMCE -->

<link href="treeview.css" type="text/css" rel="stylesheet">
<script language="javascript" src="ua.js" type="text/javascript"></script>
<script language="javascript" src="ftiens4.js" type="text/javascript"></script>
<script language="javascript" src="menu.php?<? echo session_name(); ?>=<? echo session_id(); ?>" type="text/javascript"></script>
<link rel="stylesheet" href="css/slimbox.css" type="text/css" media="screen" />
<title>Futurefund Adminisztráció - </title>
</head>

<body>
<div id="container">
<div id="header"><div class="border">
	<div class="logo"></div>
	<div class="close"><a href="logout.php"></a></div>

	<div class="text">Üdvözöllek kedves <strong><?= $_SESSION['user_name'];?></strong>!</div>
</div></div>

	<div class="elv"></div>
	<!--<div class="menu_4"><a href="">Admin klasszikus</a></div>
	<div class="elv"></div>
	<div class="menu_5"><a href="">Admin varázsló</a></div>
	<div class="elv"></div>-->
	<div class="menu_6"><a href="logout.php">Kilépés</a></div>
</div></div>

<div id="left_side">
<span class="TreeviewSpanArea">
      <script>initializeDocument()</script>
      <noscript>A tree for site navigation will open here if you enable 
      JavaScript in your browser. </noscript></span>
</div>
