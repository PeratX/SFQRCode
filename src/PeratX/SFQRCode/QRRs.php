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

class QRRs{

	public static $items = array();

	public static function initRs($symsize, $gfpoly, $fcr, $prim, $nroots, $pad){
		foreach(self::$items as $rs){
			if($rs->pad != $pad) continue;
			if($rs->nroots != $nroots) continue;
			if($rs->mm != $symsize) continue;
			if($rs->gfpoly != $gfpoly) continue;
			if($rs->fcr != $fcr) continue;
			if($rs->prim != $prim) continue;

			return $rs;
		}

		$rs = QRRsItem::initRsChar($symsize, $gfpoly, $fcr, $prim, $nroots, $pad);
		array_unshift(self::$items, $rs);

		return $rs;
	}
}