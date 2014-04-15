<?php include('header.php');
$searchContent = $_GET['txtSearch'];
if($searchContent){
	$words = split(",", $searchContent);
}
?>
<div id="searchName">
	<form action="index.php" name="myForm">
		<input onClick="blankDefault('Type the names seperated by comma...', this)"  type="text" name="txtSearch" value="<?php if($searchContent!='') echo $searchContent; else echo "Type the names seperated by comma...";?>" style="width:100%"/>
		<input type="submit" value="Search" />
		<p>Here I could add the Google custom search mechaism and then we can get their correct social network ids and then we could get the likes and followers</p>
	</form>
	<script>
  (function() {
    var cx = '003027148717437402488:kbflmhliij8';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//www.google.com/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:search></gcse:search>
</div>

<table border="0" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" id="tablecontent">
<tr class="header">
	<td>Avatar</td>
	<td>Name</td>
	<td>Twitter Followers Count</td>
	<td>Facebook Page Like Count</td>
	<td>Google Plus Count</td>
	<td> Youtube Like Count</td>
	<td>Total</td>
</tr>
<?php 
	$db = new dbOperation("");
	$query = "delete from  tb_info";
	$db->executeQuery($query);
	for($ic =0;$ic<sizeof($words);$ic++) {
	
		$objTwitter = new twitterclass($words[$ic]);
		$objFb = new facebookclass($words[$ic]);
		$total = $objTwitter->followers_count+$objFb->likes;
		$query = "INSERT INTO tb_info (imgUrl, name, followCount,fblikescount,total) VALUES ('$objTwitter->profileImage', '$objTwitter->name',$objTwitter->followers_count,$objFb->likes,$total)";
		$db->executeQuery($query);
	}
		
	$query = "select * from tb_info order by total desc";
	$result = $db->getResult($query);
	$iCount=0;
	while($row = mysql_fetch_array($result))
	{
		if($iCount%2){
			$class='lightrose';
		}
		else
		{
			$class='lightgreen';
		}
	?>
<tr class="<?php  echo $class;?>">
<!-- Twitter-->
<?php ?>
	<td><img src="<?php print $row['imgUrl'];?>" /></td>
	<td><?php print $row['name'];?></td>
	<td class="align_right"><?php print $row['followCount'];?></td>
<!-- Facebook-->	
	<?php ?>
	<td class="align_right"><?php print $row['fblikescount'];?></td>
<!-- Google+-->
	<td class="align_right"><?php print $row['gpluscount'];?></td>
<!-- Youtube-->
	<td class="align_right"> <?php print $row['youtubecount'];?></td>
<!-- Total-->
	<td class="align_right"><?php print $row['total'];?></td>
</tr>
<?php 
	$iCount++;	
}?>

</table>

<?php include('footer.php');?>
