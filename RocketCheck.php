<?php

$rootDir = '/root/scripts/RocketCheck';

include $rootDir . '/simple_html_dom.php';

$verFile    = $rootDir . '/latest.ver';

$inputFile = $rootDir . '/RocketGit.html';

$emailAddress = "admin@somedomain.com";

if (file_exists && is_readable($inputFile)) {

    //$prevVersion =
    // Create a DOM object from a HTML file
    $html       = file_get_html($inputFile);
    /*
     *  <table class="releases-tag-list" data-pjax>
     *    <tr>
     *     <td class="date">
     *       <a href="/RocketChat/Rocket.Chat/releases/tag/0.39.0">
     *         <relative-time datetime="2016-09-05T15:04:32Z">Sep 5, 2016</relative-time>
     *       </a>
     *     </td>
    */

    $version    = array();

    foreach ($html->find('td') as $td) {

        //echo $ret->plaintext;
        $childNodes = count($td->children);

        //echo "ChildNodes = $childNodes<br />";
        if ($childNodes > 0) {

            foreach ($td->find('a') as $href) {
                //echo $href->innertext;
                $link       = $href->href;
                if (preg_match('/[\/]RocketChat[\/]Rocket.Chat[\/]releases[\/]tag[\/]/', $link)) {
                    //        echo "Link $link<br />";
                    $version[]            = preg_replace('/[\/]RocketChat[\/]Rocket.Chat[\/]releases[\/]tag[\/]/', '', $link);
                    //echo "Version $version<br />";
                    
                }
                //echo $link->innertext;
                
            }

        }

    }
    $version    = array_unique($version);
    $version    = max($version);

    $oldVersion = readMyFile($verFile);

    if ($oldVersion == "" || $version > $oldVersion) {
        $write      = writeMyFile($verFile, $version);
        if ($version > $oldVersion) {
            mail("$emailAddress", "RocketChat Update", "New Rocketchat $version available", "From: $emailAddress");
        }
    } else {
        mail("$emailAddress", "RocketChat Update", "Current version $version - no updates available", "From: $emailAddress");
    }

} else {
  exit;
}

// Simple write a line of data to a file
function writeMyFile($outputFilename, $strData)
{
    $handle = fopen($outputFilename, "w+");
    fwrite($handle, $strData);
    fclose($handle);
}

// Simple read a line of data to a file
function readMyFile($outputFilename)
{
    if (file_exists($outputFilename)) {
        //echo "Exists<br />";
        if (is_readable($outputFilename)) {
            //echo "readable<br />";
            $handle  = fopen($outputFilename, "r+");
            $version = fread($handle, filesize("./$outputFileName"));
            fclose($handle);
            return $version;
        } else {
            $version == "";
            return $version;
        }
    }
}
?>