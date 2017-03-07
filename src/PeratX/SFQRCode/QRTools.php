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

class QRTools{


	public static function binarize($frame){
		$len = count($frame);
		foreach($frame as &$frameLine){

			for($i = 0; $i < $len; $i++){
				$frameLine[$i] = (ord($frameLine[$i]) & 1) ? '1' : '0';
			}
		}

		return $frame;
	}


	public static function tcPdfBarcodeArray($code, $mode = 'QR,L'){
		$barcode_array = array();

		if(!is_array($mode))
			$mode = explode(',', $mode);

		$eccLevel = 'L';

		if(count($mode) > 1){
			$eccLevel = $mode[1];
		}

		$qrTab = QRCode::text($code, false, $eccLevel);
		$size = count($qrTab);

		$barcode_array['num_rows'] = $size;
		$barcode_array['num_cols'] = $size;
		$barcode_array['bcode'] = array();

		foreach($qrTab as $line){
			$arrAdd = array();
			foreach(str_split($line) as $char)
				$arrAdd[] = ($char == '1') ? 1 : 0;
			$barcode_array['bcode'][] = $arrAdd;
		}

		return $barcode_array;
	}
}
