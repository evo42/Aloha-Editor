<?php

include 'function.resize.php';

//print_r($_SERVER);

/*
$dirs = array('cache', 'cache/remote');
foreach($dirs as $dir) {
    $end_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . $dir;
    if(!is_dir($end_dir)) {
        echo "<p><em>Hint: If this page looks broken, you probably need to 'mkdir -m 777 -p $end_dir</em></p>";
    }
}
*/

// https://toolserver.org/~magnus/commonsapi.php?image=Altair_Computer_Ad_August_1975.jpg

/*


<?xml version="1.0" encoding="UTF-8"?><response version="0.9"><file><name>Altair Computer Ad August 1975.jpg</name><title>Image:Altair_Computer_Ad_August_1975.jpg</title><urls><file>http://upload.wikimedia.org/wikipedia/commons/b/be/Altair_Computer_Ad_August_1975.jpg</file><description>http://commons.wikimedia.org/wiki/Image:Altair_Computer_Ad_August_1975.jpg</description></urls><size>736862</size><width>1650</width><height>2165</height><uploader>Swtpc6800</uploader><upload_date>2009-07-06T00:15:48Z</upload_date><sha1>e9bf4ff552bf7dd9f7c74c920f4e56311fce22e0</sha1></file><description><language code="en" name="English"> The MITS Altair 8800 computer was the first commercially successful home computer. Paul Allen and Bill Gates wrote Altair BASIC and started Microsoft. This advertisement appeared in &lt;i&gt;Radio-Electronics&lt;/i&gt;, &lt;i&gt;Popular Electronics&lt;/i&gt; and other magazines in August 1975.&lt;/span&gt;</language><language code="fr" name="Français&amp;#160;"> L&apos;Altair 8800 de MITS fut le premier ordinateur personnel a obtenir un succès commercial. Paul Allen and Bill Gates écrivirent Altair BASIC et fondèrent Microsoft. Cette publicité apparut dans les magazines &lt;i&gt;Radio-Electronics&lt;/i&gt; et &lt;i&gt;Popular Electronics&lt;/i&gt;, ainsi que dans plusieurs autres, en août 1975.</language><language code="default"> The MITS Altair 8800 computer was the first commercially successful home computer. Paul Allen and Bill Gates wrote Altair BASIC and started Microsoft. This advertisement appeared in &lt;i&gt;Radio-Electronics&lt;/i&gt;, &lt;i&gt;Popular Electronics&lt;/i&gt; and other magazines in August 1975.&lt;/span&gt;</language></description><categories><category>1975 advertisements</category><category>Advertisements in the United States</category><category>Micro Instrumentation and Telemetry Systems</category><category>Scans by User:Swtpc6800</category></categories><licenses><license><name>PD US no notice</name></license></licenses></response>




<?xml version="1.0" encoding="UTF-8" ?>
<response version="0.9">
    <file>
        <name>Altair Computer Ad August 1975.jpg</name>
        <title>Image:Altair_Computer_Ad_August_1975.jpg</title>
        <urls>
            <file>http://upload.wikimedia.org/wikipedia/commons/b/be/Altair_Computer_Ad_August_1975.jpg</file>
            <description>http://commons.wikimedia.org/wiki/Image:Altair_Computer_Ad_August_1975.jpg</description>
        </urls>
        <size>736862</size>
        <width>1650</width>
        <height>2165</height>
        <uploader>Swtpc6800</uploader>
        <upload_date>2009-07-06T00:15:48Z</upload_date>
        <sha1>e9bf4ff552bf7dd9f7c74c920f4e56311fce22e0</sha1>
    </file>
    <description>
        <language code="en" name="English">The MITS Altair 8800 computer was the first commercially successful home
            computer. Paul Allen and Bill Gates wrote Altair BASIC and started Microsoft.
            This advertisement appeared in &lt;i&gt;Radio-Electronics&lt;/i&gt;, &lt;i&gt;Popular
            Electronics&lt;/i&gt; and other magazines in August 1975.&lt;/span&gt;</language>
        <language
        code="fr" name="Français&amp;#160;">L&apos;Altair 8800 de MITS fut le premier ordinateur personnel a obtenir
            un succès commercial. Paul Allen and Bill Gates écrivirent Altair BASIC
            et fondèrent Microsoft. Cette publicité apparut dans les magazines &lt;i&gt;Radio-Electronics&lt;/i&gt;
            et &lt;i&gt;Popular Electronics&lt;/i&gt;, ainsi que dans plusieurs autres,
            en août 1975.</language>
            <language code="default">The MITS Altair 8800 computer was the first commercially successful home
                computer. Paul Allen and Bill Gates wrote Altair BASIC and started Microsoft.
                This advertisement appeared in &lt;i&gt;Radio-Electronics&lt;/i&gt;, &lt;i&gt;Popular
                Electronics&lt;/i&gt; and other magazines in August 1975.&lt;/span&gt;</language>
    </description>
    <categories>
        <category>1975 advertisements</category>
        <category>Advertisements in the United States</category>
        <category>Micro Instrumentation and Telemetry Systems</category>
        <category>Scans by User:Swtpc6800</category>
    </categories>
    <licenses>
        <license>
            <name>PD US no notice</name>
        </license>
    </licenses>
</response>

*/


if (empty($_GET['image'])) {
	$_GET['image'] = 'Altair_Computer_Ad_August_1975.jpg';
}



$image = trim($_GET['image']);

$url = 'http://toolserver.org/~magnus/commonsapi.php?image='.$image;

$image_xml = file_get_contents($url);
$image_meta = new SimpleXMLElement($image_xml);

$image_description = xml2array($image_meta->description);

//print_r($image_meta);
//print_r($image_description);

echo $image_src_orig = trim((string)$image_meta->file->urls->file);

// variations
$settings_thumbnail = array('w'=>150);
$settings_medium = array('w'=>500);
$settings_large = array('w'=>1024);

$image_src_cache_thumbnail = resize($image_src_orig,$settings_thumbnail);
$image_src_cache_medium = resize($image_src_orig,$settings_medium);
$image_src_cache_large = resize($image_src_orig,$settings_large);

$image_info = getimagesize($image_src_orig);

$image_info_thumbnail = getimagesize($image_src_cache_thumbnail);
$image_info_medium = getimagesize($image_src_cache_medium);
$image_info_large = getimagesize($image_src_cache_large);
//print_r($image_info);

$image_data = array();
$image_data['id'] = trim((string)$image_src_orig);
$image_data['name'] = trim((string)$image_meta->file->name);
$image_data['type'] = 'image';
$image_data['mimeType'] = $image_info_thumbnail['mime'];
//$image_data['width'] = $image_info[0];
//$image_data['height'] = $image_info[1];
$image_data['renditions'] = array(
								array('documentId' => $image_data['id'],
									'url' => $image_src_cache_thumbnail,
									'mimeType' => $image_info_thumbnail['mime'],
									'filename' => $image_data['name'],
									'kind' => 'thumbnail',
									'width' => $image_info_thumbnail[0],
									'height' => $image_info_thumbnail[1]),
								array('documentId' => $image_data['id'],
									'url' => $image_src_cache_medium,
									'mimeType' => $image_info_medium['mime'],
									'filename' => $image_data['name'],
									'kind' => 'medium',
									'width' => $image_info_medium[0],
									'height' => $image_info_medium[1]),
								array('documentId' => $image_data['id'],
									'url' => $image_src_cache_large,
									'mimeType' => $image_info_large['mime'],
									'filename' => $image_data['name'],
									'kind' => 'large',
									'width' => $image_info_large[0],
									'height' => $image_info_large[1]),
								array('documentId' => $image_data['id'],
									'url' => $image_data['id'],
									'mimeType' => $image_info['mime'],
									'filename' => $image_data['name'],
									'kind' => 'original',
									'width' => trim((string)$image_meta->file->width),
									'height' => trim((string)$image_meta->file->height))

							);


echo json_encode($image_data);




function xml2array($xml) { 
    $arXML=array(); 
    $arXML['name']=trim($xml->getName()); 
    $arXML['value']=trim((string)$xml); 
    $t=array(); 
    foreach($xml->attributes() as $name => $value){ 
        $t[$name]=trim($value); 
    } 
    $arXML['attr']=$t; 
    $t=array(); 
    foreach($xml->children() as $name => $xmlchild) { 
        $t[$name][]=xml2array($xmlchild); //FIX : For multivalued node 
    } 
    $arXML['children']=$t; 
    return($arXML); 
}



/*


id REQUIRED
repositoryId REQUIRED
name REQUIRED
baseType REQUIRED (document|folder)
type REQUIRED — This is the type you can freely define.
parentId OPTIONAL
renditions OPTIONAL
localName OPTIONAL
createdBy OPTIONAL
creationDate OPTIONAL
lastModifiedBy OPTIONAL
lastModificationDate OPTIONAL
length OPTIONAL
mimeType OPTIONAL
fileName OPTIONAL
url OPTIONAL



documentId ID REQUIRED identifies the rendition document (The baseType must be document)
url URL REQUIRED identifies the rendition stream.
mimeType String REQUIRED The MIME type of the rendition stream.
filename String REQUIRED The filename of the rendition stream
length Integer OPTIONAL The length of the rendition stream in bytes.
name String OPTIONAL Human readable information about the rendition.
kind String REQUIRED A categorization associated with the rendition. This is freely definable. An example could be:
square – an image square 75×75
thumbnail – a thumbnail version of the object
small – 240 on longest side
medium- 500 on longest side
large – 1024 on longest side (only exists for very large original images)
docx – Microsoft docx Version of the content
lang_de – same content in German language
lang_fr – same content in French language
pdf – pdf version of the content
height Integer OPTIONAL Typically used for image type renditions (expressed as pixels). SHOULD be present if kind equals thumbnail.
width Integer OPTIONAL Typically used for image type renditions (expressed as pixels). SHOULD be present if

Array
(
    [name] => description
    [value] => 
    [attr] => Array
        (
        )

    [children] => Array
        (
            [language] => Array
                (
                    [0] => Array
                        (
                            [name] => language
                            [value] => The MITS Altair 8800 computer was the first commercially successful home computer. Paul Allen and Bill Gates wrote Altair BASIC and started Microsoft. This advertisement appeared in <i>Radio-Electronics</i>, <i>Popular Electronics</i> and other magazines in August 1975.</span>
                            [attr] => Array
                                (
                                    [code] => en
                                    [name] => English
                                )

                            [children] => Array
                                (
                                )

                        )

                    [1] => Array
                        (
                            [name] => language
                            [value] => L'Altair 8800 de MITS fut le premier ordinateur personnel a obtenir un succÃ¨s commercial. Paul Allen and Bill Gates Ã©crivirent Altair BASIC et fondÃ¨rent Microsoft. Cette publicitÃ© apparut dans les magazines <i>Radio-Electronics</i> et <i>Popular Electronics</i>, ainsi que dans plusieurs autres, en aoÃ»t 1975.
                            [attr] => Array
                                (
                                    [code] => fr
                                    [name] => FranÃ§ais&#160;
                                )

                            [children] => Array
                                (
                                )

                        )

                    [2] => Array
                        (
                            [name] => language
                            [value] => The MITS Altair 8800 computer was the first commercially successful home computer. Paul Allen and Bill Gates wrote Altair BASIC and started Microsoft. This advertisement appeared in <i>Radio-Electronics</i>, <i>Popular Electronics</i> and other magazines in August 1975.</span>
                            [attr] => Array
                                (
                                    [code] => default
                                )

                            [children] => Array
                                (
                                )

                        )

                )

        )

)




SimpleXMLElement Object
(
    [@attributes] => Array
        (
            [version] => 0.9
        )

    [file] => SimpleXMLElement Object
        (
            [name] => Altair Computer Ad August 1975.jpg
            [title] => Image:Altair_Computer_Ad_August_1975.jpg
            [urls] => SimpleXMLElement Object
                (
                    [file] => http://upload.wikimedia.org/wikipedia/commons/b/be/Altair_Computer_Ad_August_1975.jpg
                    [description] => http://commons.wikimedia.org/wiki/Image:Altair_Computer_Ad_August_1975.jpg
                )

            [size] => 736862
            [width] => 1650
            [height] => 2165
            [uploader] => Swtpc6800
            [upload_date] => 2009-07-06T00:15:48Z
            [sha1] => e9bf4ff552bf7dd9f7c74c920f4e56311fce22e0
        )

    [description] => SimpleXMLElement Object
        (
            [language] => Array
                (
                    [0] =>  The MITS Altair 8800 computer was the first commercially successful home computer. Paul Allen and Bill Gates wrote Altair BASIC and started Microsoft. This advertisement appeared in <i>Radio-Electronics</i>, <i>Popular Electronics</i> and other magazines in August 1975.</span>
                    [1] =>  L'Altair 8800 de MITS fut le premier ordinateur personnel a obtenir un succÃ¨s commercial. Paul Allen and Bill Gates Ã©crivirent Altair BASIC et fondÃ¨rent Microsoft. Cette publicitÃ© apparut dans les magazines <i>Radio-Electronics</i> et <i>Popular Electronics</i>, ainsi que dans plusieurs autres, en aoÃ»t 1975.
                    [2] =>  The MITS Altair 8800 computer was the first commercially successful home computer. Paul Allen and Bill Gates wrote Altair BASIC and started Microsoft. This advertisement appeared in <i>Radio-Electronics</i>, <i>Popular Electronics</i> and other magazines in August 1975.</span>
                )

        )

    [categories] => SimpleXMLElement Object
        (
            [category] => Array
                (
                    [0] => 1975 advertisements
                    [1] => Advertisements in the United States
                    [2] => Micro Instrumentation and Telemetry Systems
                    [3] => Scans by User:Swtpc6800
                )

        )

    [licenses] => SimpleXMLElement Object
        (
            [license] => SimpleXMLElement Object
                (
                    [name] => PD US no notice
                )

        )

)

*/
?>