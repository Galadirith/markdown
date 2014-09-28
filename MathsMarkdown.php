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
	 */
	protected function consumeMaths( $lines, $current ) {

		$block = [
			'type' => 'maths',
			'content' => [],
		];
		
		// Consume until empty newline (indents are NOT treated as quotes)
		for( $i = $current, $count = count($lines); $i < $count; $i++ ) {
			if(	ltrim($lines[$i]) !== '' )
				$block['content'][] = $lines[$i];
			else
				break;
		}

		return [$block, --$i];
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