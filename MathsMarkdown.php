<?php

namespace cebe\markdown;

/**
 * Markdown parser for maths flavoured markdown
 * 
 * Markdown parser that follows the orignal markdown spec with the addition
 * of block elements that contain maths
 */
class MathsMarkdown extends Markdown {
	
	/**
	 * @inheritDoc
	 */
	protected function identifyLine( $lines, $current ) {
		
		if(	isset( $lines[$current] ) && !strncmp( $lines[$current], '$$', 2 ) )
			return 'maths';
		
		return parent::identifyLine( $lines, $current );
	}
	
	/**
	 * Consume lines for a maths block
	 * 
	 * A maths block should be preceded and followed by a blank line (with
	 * standard exceptions such as being preceded by a header). The maths
	 * block is delimited by $$ at its beginning and end.
	 * 
	 * The opening and closing delimiters $$ should be placed on their own
	 * lines. Anything placed after the opening $$ on the same line will be
	 * ignored, leaving only the $$ in the output render. Similarly, anything
	 * placed before the closing $$ will be ignored.
	 * 
	 * The maths block may contain blank lines between the delimiters, and
	 * they will NOT be interpreted as a new paragraph.
	 */
	protected function consumeMaths( $lines, $current ) {

		$block = [
			'type' => 'maths',
			'content' => [],
		];
		
		// Consume until closing $$ delimiter is found
		$block['content'][] = '$$';
		for( $i = $current+1, $count = count($lines); $i < $count; $i++ ) {
			if( !preg_match( '/\$\$$/', $lines[$i] ) )
				$block['content'][] = $lines[$i];
			else
				break;
		}
		$block['content'][] = '$$';
		
		return [$block, $i];
	}
	
	/**
	 * Renders a maths block
	 * 
	 * @return string The maths block as orignially written in the markdown
	 *     document, surrounded by \n to separate is from the surrounding
	 *     html elements
	 */
	protected function renderMaths($block) {
		return "\n".implode("\n", $block['content'])."\n";
	}
}

?>