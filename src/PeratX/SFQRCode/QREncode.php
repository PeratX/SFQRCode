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

use PeratX\SimpleFramework\Console\Logger;

class QREncode{

	public $caseSensitive = true;
	public $eightBit = false;

	public $version = 0;
	public $size = 3;
	public $margin = 4;

	public $structured = 0; // not supported yet

	public $level = SFQRCode::QR_ECLEVEL_L;
	public $hint = SFQRCode::QR_MODE_8;


	public static function factory($level = SFQRCode::QR_ECLEVEL_L, $size = 3, $margin = 4){
		$enc = new QREncode();
		$enc->size = $size;
		$enc->margin = $margin;

		switch($level . ''){
			case '0':
			case '1':
			case '2':
			case '3':
				$enc->level = $level;
				break;
			case 'l':
			case 'L':
				$enc->level = SFQRCode::QR_ECLEVEL_L;
				break;
			case 'm':
			case 'M':
				$enc->level = SFQRCode::QR_ECLEVEL_M;
				break;
			case 'q':
			case 'Q':
				$enc->level = SFQRCode::QR_ECLEVEL_Q;
				break;
			case 'h':
			case 'H':
				$enc->level = SFQRCode::QR_ECLEVEL_H;
				break;
		}

		return $enc;
	}


	public function encodeRAW($intext){
		$code = new QRCode();

		if($this->eightBit){
			$code->encodeString8bit($intext, $this->version, $this->level);
		}else{
			$code->encodeString($intext, $this->version, $this->level, $this->hint, $this->caseSensitive);
		}

		return $code->data;
	}


	public function encode($intext){
		$code = new QRCode();

		if($this->eightBit){
			$code->encodeString8bit($intext, $this->version, $this->level);
		}else{
			$code->encodeString($intext, $this->version, $this->level, $this->hint, $this->caseSensitive);
		}

		var_dump($code->data);
		return QRTools::binarize($code->data);
	}


	public function encodeImage($inText){
		try{
			$tab = $this->encode($inText);

			$maxSize = (int) (SFQRCode::QR_PNG_MAXIMUM_SIZE / (count($tab) + 2 * $this->margin));

			return QRImage::image($tab, min(max(1, $this->size), $maxSize), $this->margin);
		}catch(\Throwable $e){
			Logger::logException($e);
			return null;
		}
	}
}
