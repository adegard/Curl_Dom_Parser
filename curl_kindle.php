<?php
echo "<h1>MY KINDLE BOOKS</h1></br>";

echo "
<style type='text/css'>
.tg  {border-collapse:collapse;border-spacing:0;border-color:#aabcfe;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#aabcfe;color:#669;background-color:#e8edff;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#aabcfe;color:#039;background-color:#b9c9fe;}
.tg .tg-us36{border-color:inherit;vertical-align:top}
.tg .tg-yw4l{vertical-align:top}
</style>
<table class='tg'>
";

echo "
  <tr>
    <th class='tg-us36'>Name</th>
    <th class='tg-yw4l'>Title</th>
    <th class='tg-yw4l'>Stars</th>
    <th class='tg-yw4l'>Langue</th>
    <th class='tg-yw4l'>Rank</th>
    <th class='tg-yw4l'>Cat</th>
  </tr>
  ";

	include "simple_html_dom.php";
	
	$url = array("https://www.amazon.it/dp/B07HJB9QVF",
				"https://www.amazon.fr/dp/B07HLF6SMR", 
				"https://www.amazon.com/dp/B07HKT13KC",
				"https://www.amazon.com/dp/B07JVJJ99F",
				"https://www.amazon.it/dp/B07HNQ2WFG",
				"https://www.amazon.fr/dp/B07JC95PX1"
				);
	
for ($x = 0; $x <= count($url)-1; $x++) {



	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url[$x]);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$response = curl_exec($ch);
	curl_close($ch);

	$html = new simple_html_dom();
	$html->load($response);

	echo "  <tr>";
		
	
	echo "<td class='tg-us36'>";
	//img 
	foreach($html->find('img[id^=ebooksImg]') as $img)
			//$img=substr($img->plaintext, 0, 2);
			//echo $img; //->plaintext;
			$src = $img->src;
			echo "<a href='$url[$x]' target='_blank'><img src='$src' height='50'></a>";
			//echo "<a href='$url[$x]' target='_blank'>$img</a>";
	echo "</td>";

	//title
	echo "<td class='tg-yw4l'>";
	foreach($html->find('span[id=ebooksProductTitle]') as $title)
			$nameb=substr($title->plaintext, 0, 20);
			echo "<a href='$url[$x]' target='_blank'>". $nameb ."</a>";
	echo "</td>";
		

	//stars 
	echo "<td class='tg-yw4l'>";
	foreach($html->find('span[class=a-icon-alt]') as $precent)
			$precent=substr($precent->plaintext, 0, 10);
			echo $precent; //->plaintext;
	echo "</td>";
	
	
	//langue 
	echo "<td class='tg-yw4l'>";
	foreach($html->find("#productDetailsTable > tbody > tr > td > div > ul > li(5)") as $lang)
			//echo $lang; //->plaintext;
	echo "</td>";

	//Rank 
	echo "<td class='tg-yw4l'>";
	foreach($html->find("#SalesRank") as $rank)
			$rank=$rank->plaintext;
			$start = stripos($rank,"#");
			$end = stripos($rank," ", $start);
			$res = substr($rank,$start+1, $end);
			echo $res;
			//echo $rank; //->plaintext;
	echo "</td>";

	//cat
	echo "<td class='tg-yw4l'>";
	foreach($html->find("#SalesRank") as $cat)
			$cat=substr($cat->plaintext, 24, 324);
			echo $cat; //->plaintext;
	echo "</td>";

	echo "  </tr>";
} 	
	echo "</table>";

?>

