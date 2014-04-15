
<?php include('db.php');
	include('commonclass.php');	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Social Network Influence Calculator</title>
<link rel='stylesheet'  href='includes/style.css' type='text/css' />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript">
	function blankDefault(_text, _this) {
    if(_text == _this.value)
        _this.value = '';
}
function contentDefault(_text, _this) {
    if(_text != '')
        _this.value = _text;
}
	
</script>
</head>

<body>
