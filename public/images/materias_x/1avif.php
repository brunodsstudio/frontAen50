<?php

//Open Source Image directory, loop through each Image and resize it.
		if($dir = opendir('.')){
      @mkdir("webps");

	while(($file = readdir($dir))!== false){

		if($file !== "." && $file !== ".."){
            $valid1366 = count(explode("-1366", $file));
            $valid372 = count(explode("-372", $file));
	    			$validfb = count(explode("-fb", $file));

              if($valid1366 > 1  || $valid372 > 1 || $validfb > 1){
								$name= str_replace(array(".jpg", ".JPEG", ".JPG", ".jpeg"), "",$file);
								$im = @imagecreatefrompng($file);
                if(!$im) {
                    $im = @imagecreatefromjpeg($file);
                }

								imagewebp($im, "webps/". $name.".webp", "50");
							} else {
								if(!is_dir($file))
									copy($file, "webps/".$file);
							}

		}
}
			closedir($dir);
		}
 ?>
