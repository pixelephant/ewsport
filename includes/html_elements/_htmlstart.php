<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="hu" />
<meta name="author" content="" />
<meta name="description" content="<?php echo $metadescription; ?>" />
<meta name="keywords" content="<?php echo $metakeyword; ?>" /> 
<meta name="reply-to" content="info@.hu" />
<meta name="copyright" content="Copyright &copy; 2010  Kft. - " />
<meta name="robots" content="index, follow, all" />
<meta name="distribution" content="Global" />
<meta name="revisit-after" content="1 Week" />
<meta name="rating" content="General" />
<meta name="doc-type" content="Web Page" />
<meta http-equiv="imagetoolbar" content="no" />
<title><?php echo $metatitle; ?></title>
<base href="http://<?php echo getenv("HTTP_HOST"); ?>/ewsport/" />
<link rel="stylesheet" type="text/css" href="css/site.css" />
<link rel="stylesheet" type="text/css" href="css/slimbox.css" />
<?php 
if (count($sitecss) > 0) {
	foreach ($sitecss as $key => $value) {
		echo '<link rel="stylesheet" type="text/css" href="css/' . $value . '.css" />';		
	}
}	
?>
<link rel="stylesheet" type="text/css" href="css/gvForms.css" />
<script type="text/javascript" src="js/mootools-core-1.3-full-compat.js"></script>
<script type="text/javascript" src="js/mootools-1.2-more.js"></script>
<script type="text/javascript" src="js/gvForms.js"></script>
<script type="text/javascript" src="js/index.js"></script>
<script type="text/javascript" src="js/slimbox.js"></script>
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="css/ie.css" />
<![endif]-->
</head>

