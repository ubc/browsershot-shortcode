<?php 
/*
* Plugin Name: Browsershots Shortcode
* Plugin URI:
* Description: Adds the ability to display the screenshorts of website using the [browsershot url="http://wordpress.org" width=300] shortcode
* Version: 1.0
* Author: UBC CMS, Enej
* Author URI:http://cms.ubc.ca
*
*
* This program is free software; you can redistribute it and/or modify it under the terms of the GNU
* General Public License as published by the Free Software Foundation; either version 2 of the License,
* or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
* even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*
* You should have received a copy of the GNU General Public License along with this program; if not, write
* to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*



* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

/**
 * CTLT_Browsershot class.
 */
class CTLT_Browsershot{
	static $instance;

	function __construct() {
		self::$instance = $this;
		add_action( 'init', array( $this, 'init' ) );
	}
	
	function init(){
		
		$this->add_shortcode( 'browsershot', 'browsershot' );
	}
	
	/**
	* has_shortcode function.
	*
	* @access public
	* @param mixed $shortcode
	* @return void
	*/
	function has_shortcode( $shortcode ) {
		global $shortcode_tags;
		
		return ( in_array( $shortcode, $shortcode_tags ) ? true : false);
	}
	
	/**
	* add_shortcode function.
	*
	* @access public
	* @param mixed $shortcode
	* @param mixed $shortcode_function
	* @return void
	*/
	function add_shortcode( $shortcode, $shortcode_function ) {
		
		if( !$this->has_shortcode( $shortcode ) )
		add_shortcode( $shortcode, array( &$this, $shortcode_function ) );
		
	}
	
	/**
	 * browsershot function.
	 * 
	 * @access public
	 * @param mixed $attributes
	 * @param string $content (default: '')
	 * @param string $code (default: '')
	 * @return void
	 */
	public function browsershot($attributes, $content = '', $code = '') {

		extract( shortcode_atts( array(
			'url' => '',
			'width' => 250,
		), $attributes) );
	
		$imageUrl = $this->create_url($url, $width);
	
		if ($imageUrl == '') {
			return '';
		} else {
			$image = '<img src="' . $imageUrl . '" alt="' . $url . '" width="' . $width . '"/>';
			return '<div class="browsershot mshot"><a href="' . $url . '">' . $image . '</a></div>';
		}
	
	}
	
	
	/**
	 * create_url function.
	 * 
	 * @access public
	 * @param string $url (default: '')
	 * @param int $width (default: 250)
	 * @return void
	 */
	function create_url($url = '', $width = 250) {

		if ($url != '')
			return 'http://s.wordpress.com/mshots/v1/' . urlencode(clean_url($url)) . '?w=' . $width;
		else
			return '';
	}
}

$browsershot = New CTLT_Browsershot();