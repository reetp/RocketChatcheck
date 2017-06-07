<?php

$version = array("0.57.0", "0.57.0-rc0", "0.56.0", "0.56.0-rc5", "0.56.0-rc4", "0.56.0-rc3", "0.56.0-rc2");

foreach ($version as $ver){
  
list($key, $val) = explode('-', $ver);

$arr= array($key => $val);
}

//foreach ($version as $ver){
//  
//  $verMajor[] = explode("-",$ver);
//  
//}

    $version    = array_unique($version);
    $version    = max($version);
    
    $latestVer = "0.57.0";
    
    if ($latestVer > $version){
      echo "Newer";
    }
    else{
        echo"not Newer";
    }
    
?>