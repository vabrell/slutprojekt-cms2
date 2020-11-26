<?php
use PHPUnit\Framework\TestCase;

final class LuhnTest extends TestCase {

	public function testLuhn() {
		$luhn = new Luhn;

		$this->assertEquals($luhn->checkSSN("8012307362"), true);
		$this->assertEquals($luhn->checkSSN("0101010000"), false);
	}
}