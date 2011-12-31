<?php
/**
 * class thesis_page_options
 *
 * @package Thesis
 * @since 1.7
 * @deprecated 1.8
 */
class thesis_page_options {
	function get_options() {
		$saved_options = maybe_unserialize(get_option('thesis_pages'));
		if (!empty($saved_options) && is_object($saved_options)) {
			foreach ($saved_options as $option_name => $value)
				$this->$option_name = $value;
		}
	}
}