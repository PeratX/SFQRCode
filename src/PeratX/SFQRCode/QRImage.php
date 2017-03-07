<?php

/**
 * SFQRCode
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PeratX & arielferrandini
 */


namespace PeratX\SFQRCode;

class QRImage{

	public static function image($frame, $pixelPerPoint = 4, $outerFrame = 4){
		$h = count($frame);
		$w = strlen($frame[0]);

		$imgW = $w + 2 * $outerFrame;
		$imgH = $h + 2 * $outerFrame;

		$base_image = ImageCreate($imgW, $imgH);

		$col[0] = ImageColorAllocate($base_image, 255, 255, 255);
		$col[1] = ImageColorAllocate($base_image, 0, 0, 0);

		imagefill($base_image, 0, 0, $col[0]);

		for($y = 0; $y < $h; $y++){
			for($x = 0; $x < $w; $x++){
				if($frame[$y][$x] == '1'){
					ImageSetPixel($base_image, $x + $outerFrame, $y + $outerFrame, $col[1]);
				}
			}
		}

		$target_image = ImageCreate($imgW * $pixelPerPoint, $imgH * $pixelPerPoint);
		ImageCopyResized($target_image, $base_image, 0, 0, 0, 0, $imgW * $pixelPerPoint, $imgH * $pixelPerPoint, $imgW, $imgH);
		ImageDestroy($base_image);

		return $target_image;
	}
}