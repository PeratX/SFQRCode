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

class QRRsBlock{
	public $dataLength;
	public $data = array();
	public $eccLength;
	public $ecc = array();

	public function __construct($dl, $data, $el, &$ecc, QRRsItem $rs){
		$rs->encodeRsChar($data, $ecc);

		$this->dataLength = $dl;
		$this->data = $data;
		$this->eccLength = $el;
		$this->ecc = $ecc;
	}
}

;