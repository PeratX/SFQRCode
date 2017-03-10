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

use iTXTech\SimpleFramework\Module\Module;

class SFQRCode extends Module{
	const QR_FIND_BEST_MASK = true;
	const QR_FIND_FROM_RANDOM = false;
	const QR_DEFAULT_MASK = 2;
	const QR_PNG_MAXIMUM_SIZE = 1024;

	const QR_FORMAT_TEXT = 0;
	const QR_FORMAT_PNG = 1;

	// Encoding modes
	const QR_MODE_NUL = -1;
	const QR_MODE_NUM = 0;
	const QR_MODE_AN = 1;
	const QR_MODE_8 = 2;
	const QR_MODE_KANJI = 3;
	const QR_MODE_STRUCTURE = 4;

	// Levels of error correction.
	const QR_ECLEVEL_L = 0;
	const QR_ECLEVEL_M = 1;
	const QR_ECLEVEL_Q = 2;
	const QR_ECLEVEL_H = 3;

	const QR_IMAGE = true;

	const STRUCTURE_HEADER_BITS = 20;
	const MAX_STRUCTURED_SYMBOLS = 16;

	// Maks
	const N1 = 3;
	const N2 = 3;
	const N3 = 40;
	const N4 = 10;

	const QRSPEC_VERSION_MAX = 40;
	const QRSPEC_WIDTH_MAX = 177;

	const QRCAP_WIDTH = 0;
	const QRCAP_WORDS = 1;
	const QRCAP_REMINDER = 2;
	const QRCAP_EC = 3;

	private static $cacheable = false;

	private static $obj;

	public function load(){
		self::$obj = $this;
		@mkdir($this->getDataFolder());
	}

	public static function isCacheable(): bool{
		return self::$cacheable;
	}

	public static function setCacheable(bool $cacheable){
		self::$cacheable = $cacheable;
	}

	public static function getInstance(): SFQRCode{
		return self::$obj;
	}

	public function unload(){
	}
}