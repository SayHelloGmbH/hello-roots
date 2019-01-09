<?php

namespace SayHello\Theme\Package;

/**
 * Ajax stuff
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Ajax {

	public function run() {
	}

	public function exit($type, $msg, $add = []) {

		$return = [
			'type' => $type,
			'message' => $msg,
			'add' => $add,
		];

		die(json_encode($return));
	}
}
