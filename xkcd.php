<?php

$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("xkcd", $con);

//INITIAL cURL
$myurl= 'http://xkcd.com/';
$ch = curl_init($myurl);
curl_setopt($ch, CURLOPT_URL, $myurl);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
list($discard,$actdat)=explode('Permanent link to this comic: http://xkcd.com/',$data);
list($latest,$discard)=explode('/',$actdat);
echo $latest;

for ($i=1;$i<=$latest;$i++){

$myurl= 'http://xkcd.com/'.$i.'/';

//GOD BLESS CURL! :)
$ch = curl_init($myurl);
curl_setopt($ch, CURLOPT_URL, $myurl);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);

//Just stripping away the unwanted info.. Yes, this is inefficient! :(

$first=strpos($data,'<li><a href="/">&gt;|</a></li>');
$actdata=substr($data,$first+56,1000);
list($actdat,$discard)=explode('<br/>',$actdata);

//IMAGE
list($discard,$leftover)=explode('src="',$actdat);
list($imgurl,$discard)=explode('"',$leftover);
list($discard,$imgname)=explode('comics/',$imgurl);
$imgfile = file_get_contents($imgurl);
file_put_contents('comics/'.$imgname,$imgfile);

//MOUSEOVER
list($discard,$leftover)=explode('title="',$actdat);
list($alt,$discard)=explode('"',$leftover);

//TITLE
list($discard,$leftover)=explode('alt="',$actdat);
list($title,$discard)=explode('"',$leftover);

echo $i,'<br/>';

$query="INSERT INTO comix VALUES ($i,'$imgname','$title','$alt')";
mysql_query($query);

if ($data = NULL)
echo 'FAILURE';
}

//Tying up loose ends
curl_close($ch);
mysql_close();
 ?>

