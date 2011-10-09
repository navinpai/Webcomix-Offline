<html>
<head>
<title>XKCD Viewer | Designed By &nbsp; :)</title>
<link rel="stylesheet" href="dhinchak/style.css" media="all">
<script src="dhinchak/shortcuts.js" type="text/javascript"></script>
</head>
<body>
<?php
$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("xkcd", $con);

$count=mysql_query("SELECT count(id) FROM comix");
$comiccount = mysql_fetch_array($count) or die(mysql_error());
$q=$_GET['q'];
if($q==NULL)
$q=$comiccount;
echo '<div id="main_container" align="center">';
if($q < 1 || $q >$comiccount['count(id)'])
echo '<br/><br/><br/><h1>NOT AVAILABLE</h1>';
else
{
$result=  mysql_query("SELECT * FROM comix where id=$q");
$row = mysql_fetch_array($result) or die(mysql_error());
echo '<div class="main_title" align="center"><h1>'.$row['title'].'</h1></div><br/>';
$n=$q+1;
$p=$q-1;
$nextpath='<a href="?q='.$n.'">NEXT</a>';
$prevpath='<a href="?q='.$p.'">PREVIOUS</a>';
$picshow='<br/><br/><img src="comics/'.$row['picid'].'" title="'.$row['alttext'].'"/><br/>';
echo '<br/><h4>'.$row['alttext'].'</h4><br/>';
echo '<div class="left_content" align="left"><p>';
echo $prevpath;
echo '</p></div>';
echo '<div class="right_content" align="right"><p>';
echo $nextpath;
echo '</p></div>';
if($q==404)
echo '<p align="center">XKCD HAS NO COMIC #404 ... DID U KNOW THAT?</p>';
else
echo $picshow;
}
echo '<br/><br/><div class="footer" align="center">XKCD Archive | An Archive of '.$comiccount['count(id)'].' XKCD Comics<br/>'."&copy;".' R[o]b[o] Zombie Productions</div></div>'; 
echo '<script type="text/javascript">

function init() {
	shortcut.add("p", function() {
		window.location="?q='.$p.'";
	});
shortcut.add("n", function() {
		window.location="?q='.$n.'";
	});
shortcut.add("Space", function() {
		window.scrollBy(0,100);
	});	
}
window.onload=init;
</script>'
?>
</body>
</html>














