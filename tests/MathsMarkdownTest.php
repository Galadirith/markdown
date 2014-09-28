<?php

namespace cebe\markdown\tests;

use cebe\markdown\MathsMarkdown;

/**
 * Test class for maths flavoured markdown
 */
class MathMarkdownTest extends BaseMarkdownTest{
	
	public function createMarkdown() {
		return new MathsMarkdown();
	}
	
	public function getDataPaths() {
		return [ 
			'markdown-data' => __DIR__.'/markdown-data',
			'math-data' => __DIR__.'/math-data' 
		];
	}
	
	public function testEdgeCases() {
		$this->assertEquals("<p>&amp;</p>\n", $this->createMarkdown()->parse('&'));
		$this->assertEquals("<p>&lt;</p>\n", $this->createMarkdown()->parse('<'));
	}
}

?>