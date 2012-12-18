<?php

// https://commons.wikimedia.org/w/index.php?title=Special:Search&limit=100&offset=0&redirs=0&profile=images&search=red+hot+chili+peppers&uselang=de

if (!empty($_GET['q'])) {
	$query = $_GET['q'];
}

if (empty($query)) {
	$query = 'test';
}


$url = 'http://commons.wikimedia.org/w/index.php';
$command = '?title=Special:Search&limit=100&offset=0&redirs=0&profile=images&uselang=de&search=';

$command .= urlencode($query);

$connect_url = $url . $command;



// @todo check for cache file...

//$data_html = file_get_contents($connect_url);

exec("curl '".$connect_url."'", $data_array, $data_html);

/*
echo '<hr />';

//print_r($data_array);
//print_r($data_html);

echo '<hr />';
echo '<code><pre>';
echo $data_html;
echo '</pre></code>';
echo '<hr />';
echo '<hr />';
*/

$data_html = implode("\n", $data_array);

$doc = new DOMDocument();
//$doc->resolveExternals = true;
//$doc->registerNodeClass('DOMElement', 'JSLikeHTMLElement');

$doc->preserveWhiteSpace = false;

$images = array();

if (!@$doc->loadHTML($data_html)) {
	$error = 'Could not load HTML: ';
	$error .= $data_html;
} else {
	
	// author of page article-author
	//$elem = $doc->getElementById('article-author');
	//$elem->innerHTML = '';
	//$domAttribute = $doc->createAttribute('content');
	//$domAttribute->value = $_SESSION['user']->id;
	//$elem->appendChild($domAttribute);
	
		$elem_t = $doc->getElementsByTagName('table');
		$i=0;
		foreach($elem_t as $srImgData) {

			$elem_i = $srImgData->getElementsByTagName('img');
			foreach($elem_i as $imgData) {
				
				if ($i<2) {
					print_r($imgData);
					echo '******************'."\n\n";
					$i++;
				}
				
				$imgSrc = $imgData->getAttribute('src');
				
				// fix strange url issue
				$imgSrc = 'http:'.$imgSrc;
				
				//echo $imgSrc;
				//echo '<br />';
				
				// thumb upgrade
				$imgSrc = str_replace('120px', '350px', $imgSrc);
				
				// don't show very small pictures by default like:
				// https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/Vintage_aloha_shirt.JPG/90px-Vintage_aloha_shirt.JPG
				// for search "aloha"
				
				$img = array('url' => $imgSrc, 'title' => basename($imgSrc));
				array_push($images, $img);
			}
		}
}


echo json_encode($images);

?>