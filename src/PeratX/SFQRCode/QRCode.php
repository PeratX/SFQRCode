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

class QRCode{

	public $version;
	public $width;
	public $data;


	public function encodeMask(QRInput $input, $mask){
		if($input->getVersion() < 0 || $input->getVersion() > SFQRCode::QRSPEC_VERSION_MAX){
			throw new \Exception('wrong version');
		}
		if($input->getErrorCorrectionLevel() > SFQRCode::QR_ECLEVEL_H){
			throw new \Exception('wrong level');
		}

		$raw = new QRRawCode($input);

		$version = $raw->version;
		$width = QRSpec::getWidth($version);
		$frame = QRSpec::newFrame($version);

		$filler = new FrameFiller($width, $frame);

		// inteleaved data and ecc codes
		for($i = 0; $i < $raw->dataLength + $raw->eccLength; $i++){
			$code = $raw->getCode();
			$bit = 0x80;
			for($j = 0; $j < 8; $j++){
				$addr = $filler->next();
				$filler->setFrameAt($addr, 0x02 | (($bit & $code) != 0));
				$bit = $bit >> 1;
			}
		}

		unset($raw);

		// remainder bits
		$j = QRSpec::getRemainder($version);
		for($i = 0; $i < $j; $i++){
			$addr = $filler->next();
			$filler->setFrameAt($addr, 0x02);
		}

		$frame = $filler->frame;
		unset($filler);


		// masking
		$maskObj = new QRMask();
		if($mask < 0){

			if(SFQRCode::QR_FIND_BEST_MASK){
				$masked = $maskObj->mask($width, $frame, $input->getErrorCorrectionLevel());
			}else{
				$masked = $maskObj->makeMask($width, $frame, (intval(SFQRCode::QR_DEFAULT_MASK) % 8), $input->getErrorCorrectionLevel());
			}
		}else{
			$masked = $maskObj->makeMask($width, $frame, $mask, $input->getErrorCorrectionLevel());
		}

		$this->version = $version;
		$this->width = $width;
		$this->data = $masked;

		return $this;
	}


	public function encodeInput(QRInput $input){
		return $this->encodeMask($input, -1);
	}


	public function encodeString8bit($string, $version, $level){
		if($string == null){
			throw new \Exception('empty string!');
		}

		$input = new QRInput($version, $level);
		if($input == NULL) return NULL;

		$ret = $input->append(SFQRCode::QR_MODE_8, strlen($string), str_split($string));
		if($ret < 0){
			unset($input);
			return NULL;
		}
		return $this->encodeInput($input);
	}

	public function encodeString($string, $version, $level, $hint, $casesensitive){

		if($hint != SFQRCode::QR_MODE_8 && $hint != SFQRCode::QR_MODE_KANJI){
			throw new \Exception('bad hint');
		}

		$input = new QRInput($version, $level);

		$ret = QRSplit::splitStringToQRInput($string, $input, $hint, $casesensitive);
		if($ret < 0){
			return NULL;
		}

		return $this->encodeInput($input);
	}

	public static function image($text, $level = SFQRCode::QR_ECLEVEL_L, $size = 3, $margin = 4){
		$enc = QREncode::factory($level, $size, $margin);
		return $enc->encodeImage($text);
	}

	public static function text($text, $level = SFQRCode::QR_ECLEVEL_L, $size = 3, $margin = 4){
		$enc = QREncode::factory($level, $size, $margin);
		return $enc->encode($text);
	}

	public static function raw($text, $level = SFQRCode::QR_ECLEVEL_L, $size = 3, $margin = 4){
		$enc = QREncode::factory($level, $size, $margin);
		return $enc->encodeRAW($text);
	}
}
