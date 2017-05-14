<?php

namespace Pure;

/*
	implements the view's extension capability
	Example:
		@extends('filename')
		- filename represents a view to extend

		[NOTE] extends must be the first statement

	In parent View can be defined sections to be override
	with expression: @section('name')

	To override a section, do like follow:
	@begin('name')
	...code...
	@end
*/

class ViewExtendEngine extends ViewEngine {

	private $extended = false;
	private $content = null;

	function __construct(){

	}

	// if view contains extends rule, do extension
	private function extendView( $text, $params = array() ){
		if( strpos($text, '@extends(') !== false ){

			$pieces = explode( '@extends(', $text );
			$pieces = explode( ')', $pieces[1] );
			if( count( $pieces ) <= 0 )
				return $text;

			ob_start();
			View::make($pieces[0], $params, true, true); // don't compute
			$result = ob_get_contents();
			ob_end_clean();

			// remove all the extends
			foreach ($this->findRules( $result, '@extends', ')' ) as $extend) {
				$result = str_replace( $extend, '', $result );
			}

			$this->extended = true;
			return $result;
		}
		return $text;
	}

	// clear the view from the unprocessed rules
	private function clear( $text ){
		$result = $text;
		foreach ($this->findRules($text, '@begin', '@end') as $rule) {
			$result = str_replace($rule, '', $result);
		}
		foreach ($this->findRules($text, '@section', ')') as $rule) {
			$result = str_replace($rule, '', $result);
		}
		return $result;
	}

	function map( $text, $params = array() ){

		// inherit template
		$this->content = $this->extendView( $text, $params );

		if( $this->extended == false )
			return $this->clear( $text );

		// Map sections
		foreach ($this->findRules($text, '@begin', '@end') as $rule) {
			$section_name = null;
			foreach ($this->findRules($rule, '(', ')') as $s) {
				$section_name = trim($s);
				$section_name = trim($section_name, "'");
				$section_name = trim($section_name, '"');
			}

			if( $section_name == null )
				continue;

			$pieces = explode( $rule, ')' );
			$pieces = explode( $pieces[1], '@end' );

			// Override the section in parent template
			$this->content = str_replace("@section($section_name)", $pieces[0], $this->content);
			$this->content = str_replace("@section('$section_name')", $pieces[0], $this->content);
			$this->content = str_replace("@section(\"$section_name\")", $pieces[0], $this->content);
		}

		return $this->content;
	}

	function __destruct(){}
}

?>