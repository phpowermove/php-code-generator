<?php
namespace phpowermove\codegen\tests\parts;

trait TestUtils {

	private function getGeneratedContent($file) {
		return file_get_contents(__DIR__ . '/../generator/generated/' . $file);
	}

	private function getFixtureContent($file) {
		return file_get_contents(__DIR__ . '/../fixtures/' . $file);
	}
}
