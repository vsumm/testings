<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2021 ThemePunch
 */

if (!defined('ABSPATH')) exit();

class Essential_Grid_Item_Element
{

	/**
	 * Return all Item Elements
	 */
	public static function get_essential_item_elements()
	{
		global $wpdb;

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_ELEMENTS;
		$item_elements = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

		return apply_filters('essgrid_get_essential_item_elements', $item_elements);
	}

	/**
	 * Get Item Element by ID from Database
	 */
	public static function get_essential_item_element_by_id($id = 0)
	{
		global $wpdb;

		$id = intval($id);
		if ($id == 0) return false;

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_ELEMENTS;
		$element = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id), ARRAY_A);
		if (!empty($element)) {
			$element['settings'] = @json_decode($element['params'], true);
		}

		return apply_filters('essgrid_get_essential_item_element_by_id', $element, $id);
	}

	/**
	 * Get Item Element by handle from Database
	 */
	public static function check_existence_by_handle($handle)
	{
		global $wpdb;

		if (trim($handle) == '') return esc_attr__('Chosen name is too short', ESG_TEXTDOMAIN);

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_ELEMENTS;
		$element = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE handle = %s", $handle), ARRAY_A);

		$return = false;
		if (!empty($element)) {
			$return = true;
		}

		return apply_filters('essgrid_check_existence_by_handle', $return, $handle);
	}

	/**
	 * Update Item Element by ID from Database
	 */
	public static function update_create_essential_item_element($data)
	{
		global $wpdb;

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_ELEMENTS;
		if (!isset($data['name']) || empty($data['name'])) return esc_attr__('Name not received', ESG_TEXTDOMAIN);

		$element = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE name = %s", $data['name']), ARRAY_A);
		if (!empty($element)) {
			$success = self::update_essential_item_element(apply_filters('essgrid_update_create_essential_item_element', $data, 'update'));
		} else {
			$success = self::insert_essential_item_element(apply_filters('essgrid_update_create_essential_item_element', $data, 'insert'));
		}

		return $success;
	}

	/**
	 * Update Item Element by ID from Database
	 */
	public static function update_essential_item_element($data)
	{
		global $wpdb;

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_ELEMENTS;
		if (empty($data['settings'])) return esc_attr__('Element Item has no attributes', ESG_TEXTDOMAIN);

		//check if element is default element (these are not deletable)
		$default = self::getDefaultElementsArray();
		$is_default = false;
		foreach ($default as $handle => $settings) {
			if ($handle == sanitize_title($data['name'])) {
				$is_default = true;
				break;
			}
		}

		$data['settings'] = self::clean_settings_from_elements($data['settings']);

		if ($is_default) return esc_attr__('Choosen name is reserved for default Item Elements. Please choose a different name', ESG_TEXTDOMAIN);

		$data = apply_filters('essgrid_update_essential_item_element', $data);

		$response = $wpdb->update($table_name, array('settings' => json_encode($data['settings'])), array('handle' => sanitize_title($data['name'])));
		if ($response === false) return esc_attr__('Element Item could not be changed', ESG_TEXTDOMAIN);

		return true;
	}

	/**
	 * Insert Item Element by ID from Database
	 */
	public static function insert_essential_item_element($data)
	{
		global $wpdb;

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_ELEMENTS;

		if (empty($data['settings'])) return esc_attr__('Element Item has no attributes', ESG_TEXTDOMAIN);

		//check if element is default element (these are not deletable)
		$default = self::getDefaultElementsArray();
		$is_default = false;
		foreach ($default as $handle => $settings) {
			if ($handle == sanitize_title($data['name'])) {
				$is_default = true;
				break;
			}
		}

		if ($is_default) return esc_attr__('Choosen name is reserved for default Item Elements. Please choose a different name', ESG_TEXTDOMAIN);

		$data['settings'] = self::clean_settings_from_elements($data['settings']);
		$data = apply_filters('essgrid_insert_essential_item_element', $data);

		$response = $wpdb->insert($table_name, array('name' => $data['name'], 'handle' => sanitize_title($data['name']), 'settings' => json_encode($data['settings'])));
		if ($response === false) return false;

		return true;
	}

	/**
	 * Delete Item Element by handle from Database
	 */
	public static function delete_element_by_handle($data)
	{
		global $wpdb;

		$data = apply_filters('essgrid_delete_element_by_handle', $data);
		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_ELEMENTS;
		if (empty($data['handle'])) return esc_attr__('Element Item does not exist', ESG_TEXTDOMAIN);

		//check if element is default element (these are not deletable)
		$default = self::getDefaultElementsArray();
		$is_default = false;
		foreach ($default as $handle => $settings) {
			if ($handle == $data['handle']) {
				$is_default = true;
				break;
			}
		}

		if ($is_default) return esc_attr__('Default Item Elements can\'t be deleted', ESG_TEXTDOMAIN);

		$response = $wpdb->delete($table_name, array('handle' => $data['handle']));
		if ($response === false) return esc_attr__('Element Item could not be deleted', ESG_TEXTDOMAIN);

		return true;
	}

	/**
	 * Clean the element- from the settings
	 */
	public static function clean_settings_from_elements($settings)
	{
		if (empty($settings)) return $settings;
		if (!is_array($settings)) return str_replace('element-', '', $settings);

		$clean_setting = array();
		foreach ($settings as $key => $value) {
			$clean_setting[str_replace('element-', '', $key)] = $value;
		}

		return apply_filters('essgrid_clean_settings_from_elements', $clean_setting, $settings);
	}

	/**
	 * Get Array of Text Elements
	 */
	public static function getTextElementsArray()
	{
		global $wpdb;

		$custom = array();
		$elements = self::get_essential_item_elements();
		if (!empty($elements)) {
			foreach ($elements as $element) {
				$custom[$element['handle']] = array('id' => $element['id'], 'name' => $element['name'], 'settings' => json_decode($element['settings'], true));
			}
		}
		Essential_Grid_Base::stripslashes_deep($custom);

		return apply_filters('essgrid_getTextElementsArray', $custom, $elements);
	}

	/**
	 * Get Array of Special Elements
	 */
	public static function getSpecialElementsArray()
	{
		$default = array(
			'eg-line-break' => array(
				'id' => '-1',
				'name' => 'eg-line-break',
				'display' => '<i class="eg-icon-level-down"></i><span>' . esc_html__('LINEBREAK ELEMENT', ESG_TEXTDOMAIN) . '</span>',
				'settings' => array(
					'background-color' => '#FFFFFF',
					'bg-alpha' => '20',
					'clear' => 'both',
					'border-width' => '0',
					'color' => 'transparent',
					'display' => 'block',
					'font-size' => '10',
					'font-style' => 'italic',
					'font-weight' => '700',
					'line-height' => '5',
					'margin' => array('0', '0', '0', '0'),
					'padding' => array('0', '0', '0', '0'),
					'text-align' => 'center',
					'transition' => 'none',
					'text-transform' => 'uppercase',
					'letter-spacing' => 'normal',
					'source' => 'text',
					'source-text' => esc_attr__('LINE-BREAK', ESG_TEXTDOMAIN),
					'special' => 'true',
					'special-type' => 'line-break'
				)
			)
		);

		return apply_filters('essgrid_getSpecialElementsArray', $default);
	}

	/**
	 * Get Array of Additional Elements
	 * @since: 2.0
	 */
	public static function getAdditionalElementsArray()
	{
		$default = array(
			'eg-blank-element' => array(
				'id' => '-2',
				'name' => 'eg-blank-element',
				'display' => '<i class="eg-icon-doc"></i><span>' . esc_html__('Blank HTML', ESG_TEXTDOMAIN) . '</span>',
				'settings' => array(
					'background-color' => 'transparent',
					'source-text-style-disable' => 'true',
					'bg-alpha' => '20',
					'clear' => 'both',
					'border-width' => '0',
					'color' => '#000000',
					'display' => 'block',
					'font-size' => '13',
					'font-weight' => '400',
					'line-height' => '15',
					'margin' => array('0', '0', '0', '0'),
					'padding' => array('0', '0', '0', '0'),
					'text-align' => 'center',
					'transition' => 'none',
					'source' => 'text',
					'source-text' => esc_attr__('Blank HTML', ESG_TEXTDOMAIN),
					'special' => 'true',
					'special-type' => 'blank-element'
				)
			)
		);

		return apply_filters('essgrid_getAdditionalElementsArray', $default);
	}

	/**
	 * Get Array of Post Elements
	 */
	public static function getPostElementsArray()
	{
		$post = array(
			'title' => array('name' => esc_attr__('Title', ESG_TEXTDOMAIN), 'type' => 'text'),
			'cat_list' => array('name' => esc_attr__('Cat. List', ESG_TEXTDOMAIN), 'type' => 'text'),
			'tag_list' => array('name' => esc_attr__('Tag List', ESG_TEXTDOMAIN), 'type' => 'text'),
			'excerpt' => array('name' => esc_attr__('Excerpt', ESG_TEXTDOMAIN), 'type' => 'text'),
			'meta' => array('name' => esc_attr__('Meta', ESG_TEXTDOMAIN), 'type' => 'text'),
			'num_comments' => array('name' => esc_attr__('Num. Comments', ESG_TEXTDOMAIN), 'type' => 'text'),
			'date' => array('name' => esc_attr__('Date', ESG_TEXTDOMAIN), 'type' => 'text'),
			'date_day' => array('name' => esc_attr__('Date Day', ESG_TEXTDOMAIN), 'type' => 'text'),
			'date_month' => array('name' => esc_attr__('Date Month', ESG_TEXTDOMAIN), 'type' => 'text'),
			'date_month_abbr' => array('name' => esc_attr__('Date Month Abbr.', ESG_TEXTDOMAIN), 'type' => 'text'),
			'date_month_name' => array('name' => esc_attr__('Date Month Name', ESG_TEXTDOMAIN), 'type' => 'text'),
			'date_year' => array('name' => esc_attr__('Date Year', ESG_TEXTDOMAIN), 'type' => 'text'),
			'date_year_abbr' => array('name' => esc_attr__('Date Year Abbr.', ESG_TEXTDOMAIN), 'type' => 'text'),
			'date_modified' => array('name' => esc_attr__('Date Modified', ESG_TEXTDOMAIN), 'type' => 'text'),
			'author_name' => array('name' => esc_attr__('Author Name', ESG_TEXTDOMAIN), 'type' => 'text'),
			'author_profile' => array('name' => esc_attr__('Author Website', ESG_TEXTDOMAIN), 'type' => 'text'),
			'author_posts' => array('name' => esc_attr__('Author Posts Page', ESG_TEXTDOMAIN), 'type' => 'text'),
			'author_avatar_32' => array('name' => esc_attr__('Author Avatar 32px', ESG_TEXTDOMAIN), 'type' => 'text'),
			'author_avatar_64' => array('name' => esc_attr__('Author Avatar 64px', ESG_TEXTDOMAIN), 'type' => 'text'),
			'author_avatar_96' => array('name' => esc_attr__('Author Avatar 96px', ESG_TEXTDOMAIN), 'type' => 'text'),
			'author_avatar_512' => array('name' => esc_attr__('Author Avatar 512px', ESG_TEXTDOMAIN), 'type' => 'text'),
			'post_id' => array('name' => esc_attr__('Post ID', ESG_TEXTDOMAIN), 'type' => 'text'),
			'post_url' => array('name' => esc_attr__('Post URL', ESG_TEXTDOMAIN), 'type' => 'text'),
			'content' => array('name' => esc_attr__('Post Content', ESG_TEXTDOMAIN), 'type' => 'text'),
			'alternate-image' => array('name' => esc_attr__('Alt. Image', ESG_TEXTDOMAIN), 'type' => 'image'),
			'alias' => array('name' => esc_attr__('Alias', ESG_TEXTDOMAIN), 'type' => 'text'),
			'taxonomy' => array('name' => esc_attr__('Taxonomy List', ESG_TEXTDOMAIN), 'type' => 'text'),
			'caption' => array('name' => esc_attr__('Caption', ESG_TEXTDOMAIN), 'type' => 'text'),
			'description' => array('name' => esc_attr__('Description', ESG_TEXTDOMAIN), 'type' => 'text'),
			'likespost' => array('name' => esc_attr__('Likes (Posts)', ESG_TEXTDOMAIN), 'type' => 'text'),
			'likes' => array('name' => esc_attr__('Likes (Facebook,Twitter,YouTube,Vimeo,Instagram)', ESG_TEXTDOMAIN), 'type' => 'text'),
			'likes_short' => array('name' => esc_attr__('Likes Short (Facebook,Twitter,YouTube,Vimeo,Instagram)', ESG_TEXTDOMAIN), 'type' => 'text'),
			'dislikes' => array('name' => esc_attr__('Dislikes (YouTube)', ESG_TEXTDOMAIN), 'type' => 'text'),
			'dislikes_short' => array('name' => esc_attr__('Dislikes Short (YouTube)', ESG_TEXTDOMAIN), 'type' => 'text'),
			'favorites' => array('name' => esc_attr__('Favorites (YouTube, flickr)', ESG_TEXTDOMAIN), 'type' => 'text'),
			'favorites_short' => array('name' => esc_attr__('Favorites Short (YouTube, flickr)', ESG_TEXTDOMAIN), 'type' => 'text'),
			'retweets' => array('name' => esc_attr__('Retweets (Twitter)', ESG_TEXTDOMAIN), 'type' => 'text'),
			'retweets_short' => array('name' => esc_attr__('Retweets Short (Twitter)', ESG_TEXTDOMAIN), 'type' => 'text'),
			'views' => array('name' => esc_attr__('Views (flickr,YouTube, Vimeo)', ESG_TEXTDOMAIN), 'type' => 'text'),
			'views_short' => array('name' => esc_attr__('Views Short (flickr,YouTube, Vimeo)', ESG_TEXTDOMAIN), 'type' => 'text'),
			'itemCount' => array('name' => esc_attr__('Playlist Item Count (YouTube)', ESG_TEXTDOMAIN), 'type' => 'text'),
			'channel_title' => array('name' => esc_attr__('Channel Title (YouTube)', ESG_TEXTDOMAIN), 'type' => 'text'),
			'duration' => array('name' => esc_attr__('Duration (Vimeo)', ESG_TEXTDOMAIN), 'type' => 'text'),
			'iframe' => array('name' => esc_attr__('iFrame (url)', ESG_TEXTDOMAIN), 'type' => 'text'),
			'revslider' => array('name' => esc_attr__('Slider Revolution', ESG_TEXTDOMAIN), 'type' => 'revslider'),
			'essgrid' => array('name' => esc_attr__('Essential Grid', ESG_TEXTDOMAIN), 'type' => 'essgrid'),
			'wistia' => array('name' => esc_attr__('Wistia Video (ID)', ESG_TEXTDOMAIN), 'type' => 'wistia')
		);

		$post = apply_filters('essgrid_post_meta_handle', $post); //stays for backwards compatibility
		$post = apply_filters('essgrid_getPostElementsArray', $post);

		return $post;
	}

	/**
	 * Get Array of Event Elements
	 */
	public static function getEventElementsArray()
	{
		$event = array(
			'event_start_date' => array('name' => esc_attr__('Event Start Date', ESG_TEXTDOMAIN)),
			'event_end_date' => array('name' => esc_attr__('Event End Date', ESG_TEXTDOMAIN)),
			'event_start_time' => array('name' => esc_attr__('Event Start Time', ESG_TEXTDOMAIN)),
			'event_end_time' => array('name' => esc_attr__('Event End Time', ESG_TEXTDOMAIN)),
			'event_event_id' => array('name' => esc_attr__('Event Event ID', ESG_TEXTDOMAIN)),
			'event_location_name' => array('name' => esc_attr__('Event Location Name', ESG_TEXTDOMAIN)),
			'event_location_slug' => array('name' => esc_attr__('Event Location Slug', ESG_TEXTDOMAIN)),
			'event_location_address' => array('name' => esc_attr__('Event Location Address', ESG_TEXTDOMAIN)),
			'event_location_town' => array('name' => esc_attr__('Event Location Town', ESG_TEXTDOMAIN)),
			'event_location_state' => array('name' => esc_attr__('Event Location State', ESG_TEXTDOMAIN)),
			'event_location_postcode' => array('name' => esc_attr__('Event Location Postcode', ESG_TEXTDOMAIN)),
			'event_location_region' => array('name' => esc_attr__('Event Location Region', ESG_TEXTDOMAIN)),
			'event_location_country' => array('name' => esc_attr__('Event Location Country', ESG_TEXTDOMAIN))
		);

		return apply_filters('essgrid_getEventElementsArray', $event);
	}

	/**
	 * Get Array of Default Elements
	 */
	public static function getDefaultElementsArray()
	{
		$default = array();
		include('assets/default-item-elements.php');
		$default = apply_filters('essgrid_add_default_item_elements', $default); //stays for backwards compatibility
		$default = apply_filters('essgrid_getDefaultElementsArray', $default);

		return $default;
	}

	/**
	 * Get Array of Elements
	 */
	public static function prepareElementsForEditor($elements, $set_loaded = false)
	{
		$html = '';
		$load_class = '';

		if ($set_loaded == true)
			$load_class = ' eg-newli';

		foreach ($elements as $handle => $element) {
			$styles = '';
			$filter_type = 'text';
			$data_id = 1;
			if (isset($element['settings']) && !empty($element['settings'])) {
				if ($element['settings']['source'] == 'icon') {
					$text = '<i class="' . $element['settings']['source-icon'] . '"></i>';
				} elseif ($element['settings']['source'] == 'text') {
					$text = $element['settings']['source-text'];
				} else {
					$text = $element['name'];
				}
				if ($element['settings']['source'] == 'icon') $filter_type = 'icon';
				$data_id = $element['id'];
			} else {
				$text = $element['name'];
			}

			$sort_title = strip_tags($text);
			if (trim($sort_title) == '') {
				$sort_title = 'unsorted';
			} else {
				$sort_title = strtolower(substr($sort_title, 0, 1));
			}

			if (isset($element['default']) && $element['default'] == 'true') $filter_type .= ' filter-default';

			$html .= '<li class="filterall filter-' . $filter_type . $load_class . '" data-title="' . $sort_title . '" data-date="' . $data_id . '">' . "\n";
			$html .= '   <div class="esg-entry-content">';
			$html .= '       <div class="eg-elements-format-wrapper"><div class="skin-dz-elements" data-handle="' . $handle . '"' . $styles . '>';
			$html .= $text;
			$html .= '       </div></div>' . "\n";
			$html .= '   </div>' . "\n";
			$html .= '</li>' . "\n";
		}

		return apply_filters('essgrid_prepareElementsForEditor', $html, $elements, $set_loaded);
	}

	/**
	 * Get Array of Special Elements
	 */
	public static function prepareSpecialElementsForEditor()
	{
		$html = '';
		$elements = self::getSpecialElementsArray();
		foreach ($elements as $handle => $element) {
			$styles = '';
			if (isset($element['settings']) && !empty($element['settings'])) {
				$text = $element['display'];
			} else {
				$text = $element['name'];
			}
			$html .= '<div class="skin-dz-elements eg-special-element" data-handle="' . $handle . '"' . $styles . '>';
			$html .= $text;
			$html .= '</div>' . "\n";
		}

		return apply_filters('essgrid_prepareSpecialElementsForEditor', $html, $elements);
	}

	/**
	 * Get Array of Additional Elements
	 */
	public static function prepareAdditionalElementsForEditor()
	{
		$html = '';
		$elements = self::getAdditionalElementsArray();
		foreach ($elements as $handle => $element) {
			$styles = '';
			if (isset($element['settings']) && !empty($element['settings'])) {
				$text = $element['display'];
			} else {
				$text = $element['name'];
			}
			$html .= '<div class="skin-dz-elements eg-special-blank-element eg-additional-element eg-special-element-margin" data-handle="' . $handle . '"' . $styles . '>';
			$html .= $text;
			$html .= '</div>' . "\n";
		}

		return apply_filters('essgrid_prepareAdditionalElementsForEditor', $html, $elements);
	}

	/**
	 * Get Array of Default Elements
	 */
	public static function prepareDefaultElementsForEditor()
	{
		$elements = self::getDefaultElementsArray();
		$elements = apply_filters('essgrid_prepareDefaultElementsForEditor', $elements);

		return self::prepareElementsForEditor($elements, true);
	}

	/**
	 * Get Array of Post Elements
	 */
	public static function prepareTextElementsForEditor()
	{
		$elements = self::getTextElementsArray();
		$elements = apply_filters('essgrid_prepareTextElementsForEditor', $elements);

		return self::prepareElementsForEditor($elements, true);
	}

	/**
	 * Get Array of Elements
	 */
	public static function getElementsForJavascript()
	{
		$default = self::getDefaultElementsArray();
		$text = self::getTextElementsArray();
		$special = self::getSpecialElementsArray();
		$additional = self::getAdditionalElementsArray();

		$all = array_merge($default, $text, $special, $additional);

		return apply_filters('essgrid_getElementsForJavascript', $all);
	}

	/**
	 * Get Array of Elements
	 */
	public static function getElementsForDropdown()
	{
		$post = self::getPostElementsArray();
		$all['post'] = $post;

		if (Essential_Grid_Woocommerce::is_woo_exists()) {
			$woocommerce = array();
			$tmp_wc = Essential_Grid_Woocommerce::get_meta_array();
			foreach ($tmp_wc as $handle => $name) {
				$woocommerce[$handle]['name'] = $name;
			}
			$all['woocommerce'] = $woocommerce;
		}

		return apply_filters('essgrid_getElementsForDropdown', $all);
	}

	/**
	 * create css from settings
	 */
	public static function get_existing_elements($only_styles = false)
	{
		$styles = array(
			'font-size' => array(
				'value' => 'int',
				'type' => 'text-slider',
				'values' => array('min' => '6', 'max' => '120', 'step' => '1', 'default' => '12'),
				'style' => 'idle',
				'unit' => 'px'),

			'line-height' => array(
				'value' => 'int',
				'type' => 'text-slider',
				'values' => array('min' => '7', 'max' => '150', 'step' => '1', 'default' => '14'),
				'style' => 'idle',
				'unit' => 'px'),

			'color' => array(
				'value' => 'string',
				'type' => 'colorpicker',
				'values' => array('default' => '#000'),
				'style' => 'idle',
				'unit' => ''),

			'font-family' => array(
				'value' => 'string',
				'values' => array('default' => ''),
				'style' => 'idle',
				'type' => 'text',
				'unit' => ''),

			'font-weight' => array(
				'value' => 'string',
				'values' => array('default' => '400'),
				'style' => 'idle',
				'type' => 'select',
				'unit' => ''),

			'text-decoration' => array(
				'value' => 'string',
				'values' => array('default' => 'none'),
				'style' => 'idle',
				'type' => 'select',
				'unit' => ''),

			'font-style' => array(
				'value' => 'string',
				'values' => array('default' => false),
				'style' => 'idle',
				'type' => 'checkbox',
				'unit' => ''),

			'text-transform' => array(
				'value' => 'string',
				'values' => array('default' => 'none'),
				'style' => 'idle',
				'type' => 'select',
				'unit' => ''),

			'letter-spacing' => array(
				'value' => 'string',
				'values' => array('default' => 'normal'),
				'style' => 'idle',
				'type' => 'text',
				'unit' => ''),

			'display' => array(
				'value' => 'string',
				'values' => array('default' => 'inline-block'),
				'style' => 'idle',
				'type' => 'select',
				'unit' => ''),

			'float' => array(
				'value' => 'string',
				'values' => array('default' => 'none'),
				'style' => 'idle',
				'type' => 'select',
				'unit' => ''),

			'text-align' => array(
				'value' => 'string',
				'values' => array('default' => 'center'),
				'style' => 'idle',
				'type' => 'select',
				'unit' => ''),

			'clear' => array(
				'value' => 'string',
				'values' => array('default' => 'none'),
				'style' => 'idle',
				'type' => 'select',
				'unit' => ''),

			'margin' => array(
				'value' => 'int',
				'type' => 'multi-text',
				'values' => array('default' => '0'),
				'style' => 'idle',
				'unit' => 'px'),

			'padding' => array(
				'value' => 'int',
				'type' => 'multi-text',
				'values' => array('default' => '0'),
				'style' => 'idle',
				'unit' => 'px'),

			'border' => array(
				'value' => 'int',
				'type' => 'multi-text',
				'values' => array('default' => '0'),
				'style' => 'idle',
				'unit' => 'px'),

			'border-radius' => array(
				'value' => 'int',
				'type' => 'multi-text',
				'values' => array('default' => '0'),
				'style' => 'idle',
				'unit' => array('px', 'percentage')),

			'border-color' => array(
				'value' => 'string',
				'values' => array('default' => 'transparent'),
				'style' => 'idle',
				'type' => 'colorpicker',
				'unit' => ''),

			'border-style' => array(
				'value' => 'string',
				'values' => array('default' => 'solid'),
				'style' => 'idle',
				'type' => 'select',
				'unit' => ''),

			'background-color' => array(
				'value' => 'string',
				'type' => 'colorpicker',
				'values' => array('default' => '#FFF'),
				'style' => 'idle',
				'unit' => ''),

			'bg-alpha' => array(
				'value' => 'string',
				'values' => array('min' => '0', 'max' => '100', 'step' => '1', 'default' => '100'),
				'style' => 'false',
				'type' => 'text-slider',
				'unit' => ''),

			'shadow-color' => array(
				'value' => 'string',
				'type' => 'colorpicker',
				'values' => array('default' => '#000'),
				'style' => 'false',
				'unit' => ''),

			'shadow-alpha' => array(
				'value' => 'string',
				'values' => array('min' => '0', 'max' => '100', 'step' => '1', 'default' => '100'),
				'style' => 'false',
				'type' => 'text-slider',
				'unit' => ''),

			'box-shadow' => array(
				'value' => 'int',
				'type' => 'multi-text',
				'values' => array('default' => '0'),
				'style' => 'idle',
				'unit' => 'px'),

			'position' => array(
				'value' => 'string',
				'type' => 'select',
				'values' => array('default' => 'relative'),
				'style' => 'idle',
				'unit' => ''),

			'top-bottom' => array(
				'value' => 'int',
				'type' => 'text',
				'values' => array('default' => '0'),
				'style' => 'false',
				'unit' => 'px'),

			'left-right' => array(
				'value' => 'int',
				'type' => 'text',
				'values' => array('default' => '0'),
				'style' => 'false',
				'unit' => 'px')

		);

		$styles = apply_filters('essgrid_get_existing_elements_styles', $styles, $only_styles);

		$hover_styles = array(
			'font-size-hover' => array(
				'value' => 'int',
				'type' => 'text-slider',
				'values' => array('min' => '6', 'max' => '120', 'step' => '1', 'default' => '12'),
				'style' => 'hover',
				'unit' => 'px'),

			'line-height-hover' => array(
				'value' => 'int',
				'type' => 'text-slider',
				'values' => array('min' => '7', 'max' => '150', 'step' => '1', 'default' => '14'),
				'style' => 'hover',
				'unit' => 'px'),

			'color-hover' => array(
				'value' => 'string',
				'type' => 'colorpicker',
				'values' => array('default' => '#000'),
				'style' => 'hover',
				'unit' => ''),

			'font-family-hover' => array(
				'value' => 'string',
				'values' => array('default' => ''),
				'style' => 'hover',
				'type' => 'text',
				'unit' => ''),

			'font-weight-hover' => array(
				'value' => 'string',
				'values' => array('default' => '400'),
				'style' => 'hover',
				'type' => 'select',
				'unit' => ''),

			'text-decoration-hover' => array(
				'value' => 'string',
				'values' => array('default' => 'none'),
				'style' => 'hover',
				'type' => 'select',
				'unit' => ''),

			'font-style-hover' => array(
				'value' => 'string',
				'values' => array('default' => false),
				'style' => 'hover',
				'type' => 'checkbox',
				'unit' => ''),

			'text-transform-hover' => array(
				'value' => 'string',
				'values' => array('default' => 'none'),
				'style' => 'hover',
				'type' => 'select',
				'unit' => ''),

			'letter-spacing-hover' => array(
				'value' => 'string',
				'values' => array('default' => 'normal'),
				'style' => 'hover',
				'type' => 'text',
				'unit' => ''),

			'border-hover' => array(
				'value' => 'int',
				'type' => 'multi-text',
				'values' => array('default' => '0'),
				'style' => 'hover',
				'unit' => 'px'),

			'border-radius-hover' => array(
				'value' => 'int',
				'type' => 'multi-text',
				'values' => array('default' => '0'),
				'style' => 'hover',
				'unit' => array('px', 'percentage')),

			'border-color-hover' => array(
				'value' => 'string',
				'values' => array('default' => 'transparent'),
				'style' => 'hover',
				'type' => 'colorpicker',
				'unit' => ''),

			'border-style-hover' => array(
				'value' => 'string',
				'values' => array('default' => 'solid'),
				'style' => 'hover',
				'type' => 'select',
				'unit' => ''),

			'background-color-hover' => array(
				'value' => 'string',
				'type' => 'colorpicker',
				'values' => array('default' => '#FFF'),
				'style' => 'hover',
				'unit' => ''),

			'bg-alpha-hover' => array(
				'value' => 'string',
				'values' => array('min' => '0', 'max' => '100', 'step' => '1', 'default' => '100'),
				'style' => 'false',
				'type' => 'text-slider',
				'unit' => ''),

			'shadow-color-hover' => array(
				'value' => 'string',
				'type' => 'colorpicker',
				'values' => array('default' => '#000'),
				'style' => 'false',
				'unit' => ''),

			'shadow-alpha-hover' => array(
				'value' => 'string',
				'values' => array('min' => '0', 'max' => '100', 'step' => '1', 'default' => '100'),
				'style' => 'false',
				'type' => 'text-slider',
				'unit' => ''),

			'box-shadow-hover' => array(
				'value' => 'int',
				'type' => 'multi-text',
				'values' => array('default' => '0'),
				'style' => 'hover',
				'unit' => 'px'),
		);

		$hover_styles = apply_filters('essgrid_get_existing_elements_hover_styles', $hover_styles, $only_styles);

		$other = array();
		if (!$only_styles) {
			$other = array(
				'source' => array(
					'value' => 'string',
					'type' => 'select',
					'values' => array('default' => 'post'),
					'style' => 'false',
					'unit' => ''),

				'transition' => array(
					'value' => 'string',
					'type' => 'select',
					'values' => array('default' => 'fade'),
					'style' => 'attribute',
					'unit' => ''),

				'source-separate' => array(
					'value' => 'string',
					'type' => 'text',
					'values' => array('default' => ','),
					'style' => 'attribute',
					'unit' => ''),

				'source-catmax' => array(
					'value' => 'string',
					'type' => 'text',
					'values' => array('default' => '-1'),
					'style' => 'attribute',
					'unit' => ''),

				'always-visible-desktop' => array(
					'value' => 'string',
					'type' => 'checkbox',
					'values' => array('default' => ''),
					'style' => 'false',
					'unit' => ''),

				'always-visible-mobile' => array(
					'value' => 'string',
					'type' => 'checkbox',
					'values' => array('default' => ''),
					'style' => 'false',
					'unit' => ''),

				'source-function' => array(
					'value' => 'string',
					'type' => 'select',
					'values' => array('default' => 'link'),
					'style' => 'attribute',
					'unit' => ''),

				'limit-type' => array(
					'value' => 'string',
					'type' => 'select',
					'values' => array('default' => 'none'),
					'style' => 'attribute',
					'unit' => ''),

				'limit-num' => array(
					'value' => 'string',
					'type' => 'text',
					'values' => array('default' => '10'),
					'style' => 'attribute',
					'unit' => ''),

				'min-height' => array(
					'value' => 'string',
					'type' => 'text',
					'values' => array('default' => '0'),
					'style' => 'attribute',
					'unit' => ''),

				'max-height' => array(
					'value' => 'string',
					'type' => 'text',
					'values' => array('default' => 'none'),
					'style' => 'attribute',
					'unit' => ''),

				'transition-type' => array(
					'value' => 'string',
					'type' => 'select',
					'values' => array('default' => ''),
					'style' => 'false',
					'unit' => ''),

				'delay' => array(
					'value' => 'string',
					'type' => 'text-slider',
					'values' => array('min' => '0', 'max' => '60', 'step' => '1', 'default' => '10'),
					'style' => 'attribute',
					'unit' => ''),

				'duration' => array(
					'value' => 'string',
					'type' => 'select',
					'values' => array('default' => 'default'),
					'style' => 'false',
					'unit' => ''),

				'link-type' => array(
					'value' => 'string',
					'type' => 'select',
					'values' => array('default' => 'none'),
					'style' => 'false',
					'unit' => ''),

				'hideunder' => array(
					'value' => 'string',
					'type' => 'text',
					'values' => array('default' => '0'),
					'style' => 'false',
					'unit' => ''),

				'hideunderheight' => array(
					'value' => 'string',
					'type' => 'text',
					'values' => array('default' => '0'),
					'style' => 'false',
					'unit' => ''),

				'hidetype' => array(
					'value' => 'string',
					'type' => 'select',
					'values' => array('default' => 'visibility'),
					'style' => 'false',
					'unit' => ''),

				'hide-on-video' => array(
					'value' => 'string',
					'type' => 'select', //was checkbock before with values 'false', 'true'
					'values' => array('default' => false),
					'style' => 'false',
					'unit' => ''),

				'show-on-lightbox-video' => array(
					'value' => 'string',
					'type' => 'select',
					'values' => array('default' => false),
					'style' => 'false',
					'unit' => ''),

				'enable-hover' => array(
					'value' => 'string',
					'type' => 'checkbox',
					'values' => array('default' => false),
					'style' => 'false',
					'unit' => ''),

				'attribute' => array(
					'value' => 'string',
					'type' => 'text',
					'values' => array('default' => ''),
					'style' => 'false',
					'unit' => ''),

				'class' => array(
					'value' => 'string',
					'type' => 'text',
					'values' => array('default' => ''),
					'style' => 'false',
					'unit' => ''),

				'rel' => array(
					'value' => 'string',
					'type' => 'text',
					'values' => array('default' => ''),
					'style' => 'false',
					'unit' => ''),

				'tag-type' => array(
					'value' => 'string',
					'type' => 'select',
					'values' => array('default' => 'div'),
					'style' => 'false',
					'unit' => ''),

				'force-important' => array(
					'value' => 'string',
					'type' => 'checkbox',
					'values' => array('default' => true),
					'style' => 'false',
					'unit' => ''),

				'align' => array(
					'value' => 'string',
					'type' => 'select',
					'values' => array('default' => 't_l'),
					'style' => 'false',
					'unit' => ''),

				'link-target' => array(
					'value' => 'string',
					'type' => 'select',
					'values' => array('default' => '_self'),
					'style' => 'false',
					'unit' => ''),

				'source-text-style-disable' => array(
					'value' => 'string',
					'type' => 'checkbox',
					'values' => array('default' => false),
					'style' => 'false',
					'unit' => '')
			);

			if (Essential_Grid_Woocommerce::is_woo_exists()) {
				$other['show-on-sale'] = array(
					'value' => 'string',
					'type' => 'checkbox',
					'values' => array('default' => false),
					'style' => 'false',
					'unit' => '');
				$other['show-if-featured'] = array(
					'value' => 'string',
					'type' => 'checkbox',
					'values' => array('default' => false),
					'style' => 'false',
					'unit' => '');
			}

			$other = apply_filters('essgrid_get_existing_elements_other', $other, $only_styles);
		}

		$styles = array_merge($styles, $other, $hover_styles);

		return apply_filters('essgrid_get_existing_elements', $styles, $only_styles);
	}

	/**
	 * get list of allowed styles on tags
	 */
	public static function get_allowed_styles_for_tags()
	{
		return apply_filters('essgrid_get_allowed_styles_for_tags',
			array(
				'font-size',
				'line-height',
				'color',
				'font-family',
				'font-weight',
				'text-decoration',
				'font-style',
				'text-transform',
				'letter-spacing',
				'background-color'
			)
		);
	}

	/**
	 * get list of allowed styles on tags
	 */
	public static function get_allowed_styles_for_cat_tag()
	{
		return apply_filters('essgrid_get_allowed_styles_for_cat_tag',
			array(
				'font-size',
				'line-height',
				'color',
				'font-family',
				'font-weight',
				'text-decoration',
				'font-style',
				'text-transform',
				'letter-spacing',
			)
		);
	}

	/**
	 * get list of allowed styles on wrap
	 */
	public static function get_allowed_styles_for_wrap()
	{
		return apply_filters('essgrid_get_allowed_styles_for_wrap',
			array(
				'display',
				'clear',
				'position',
				'text-align',
				'margin',
				'float',
				'left',
				'top',
				'right',
				'bottom'
			)
		);
	}

	/**
	 * get list of allowed styles on wrap
	 */
	public static function get_wait_until_output_styles()
	{
		return apply_filters('essgrid_get_wait_until_output_styles',
			array(
				'border-style' => array(
					'wait' => array('border', 'border-color', 'border-style', 'border-top-width', 'border-right-width', 'border-bottom-width', 'border-left-width'),
					'not-if' => 'none'
				),
				'border-style-hover' => array(
					'wait' => array('border-hover', 'border-color-hover', 'border-style-hover', 'border-top-width-hover', 'border-right-width-hover', 'border-bottom-width-hover', 'border-left-width-hover'),
					'not-if' => 'none'
				),
				'box-shadow' => array(
					'wait' => array('box-shadow'),
					'not-if' => array('0px 0px 0px 0px', '0)')
				),
				'-moz-box-shadow' => array(
					'wait' => array('-moz-box-shadow'),
					'not-if' => array('0px 0px 0px 0px', '0)')
				),
				'-webkit-box-shadow' => array(
					'wait' => array('-webkit-box-shadow'),
					'not-if' => array('0px 0px 0px 0px', '0)')
				),
				'text-decoration' => array(
					'wait' => array('text-decoration'),
					'not-if' => 'none'
				),
				'text-transform' => array(
					'wait' => array('text-transform'),
					'not-if' => 'none'
				),
				'letter-spacing' => array(
					'wait' => array('letter-spacing'),
					'not-if' => 'normal'
				),
				'font-family' => array(
					'wait' => array('font-family'),
					'not-if' => ''
				)
			)
		);
	}

	/**
	 * get list of allowed things on meta
	 */
	public function get_allowed_meta()
	{
		$base = new Essential_Grid_Base();
		$transitions_media = $base->get_hover_animations(true); //true will get with in/out
		return apply_filters('essgrid_get_allowed_meta',
			array(
				array(
					'name' => array('handle' => 'color', 'text' => esc_attr__('Font Color', ESG_TEXTDOMAIN)),
					'type' => 'color',
					'default' => '#FFFFFF',
					'container' => 'style',
					'hover' => 'true',
					'cpmode' => 'single'
				),
				array(
					'name' => array('handle' => 'font-style', 'text' => esc_attr__('Font Style', ESG_TEXTDOMAIN)),
					'type' => 'select',
					'default' => 'normal',
					'values' => array('normal' => esc_attr__('Normal', ESG_TEXTDOMAIN), 'italic' => esc_attr__('Italic', ESG_TEXTDOMAIN)),
					'container' => 'style',
					'hover' => 'true'
				),
				array(
					'name' => array('handle' => 'text-decoration', 'text' => esc_attr__('Text Decoration', ESG_TEXTDOMAIN)),
					'type' => 'select',
					'default' => 'none',
					'values' => array('none' => esc_attr__('None', ESG_TEXTDOMAIN), 'underline' => esc_attr__('Underline', ESG_TEXTDOMAIN), 'overline' => esc_attr__('Overline', ESG_TEXTDOMAIN), 'line-through' => esc_attr__('Line Through', ESG_TEXTDOMAIN)),
					'container' => 'style',
					'hover' => 'true'
				),
				array(
					'name' => array('handle' => 'text-transform', 'text' => esc_attr__('Text Transform', ESG_TEXTDOMAIN)),
					'type' => 'select',
					'default' => 'none',
					'values' => array('none' => esc_attr__('None', ESG_TEXTDOMAIN), 'capitalize' => esc_attr__('Capitalize', ESG_TEXTDOMAIN), 'uppercase' => esc_attr__('Uppercase', ESG_TEXTDOMAIN), 'lowercase' => esc_attr__('Lowercase', ESG_TEXTDOMAIN)),
					'container' => 'style',
					'hover' => 'true'
				),
				array(
					'name' => array('handle' => 'letter-spacing', 'text' => esc_attr__('Letter Spacing', ESG_TEXTDOMAIN)),
					'type' => 'text',
					'default' => 'normal',
					'container' => 'style',
					'hover' => 'true'
				),
				array(
					'name' => array('handle' => 'border-color', 'text' => esc_attr__('Border Color', ESG_TEXTDOMAIN)),
					'type' => 'color',
					'default' => '#FFFFFF',
					'container' => 'style',
					'hover' => 'true',
					'cpmode' => 'single'
				),
				array(
					'name' => array('handle' => 'border-style', 'text' => esc_attr__('Border Style', ESG_TEXTDOMAIN)),
					'type' => 'select',
					'default' => 'none',
					'values' => array('none' => esc_attr__('None', ESG_TEXTDOMAIN), 'solid' => esc_attr__('solid', ESG_TEXTDOMAIN), 'dotted' => esc_attr__('dotted', ESG_TEXTDOMAIN), 'dashed' => esc_attr__('dashed', ESG_TEXTDOMAIN), 'double' => esc_attr__('double', ESG_TEXTDOMAIN)),
					'container' => 'style',
					'hover' => 'true'
				),
				array(
					'name' => array('handle' => 'background', 'text' => esc_attr__('Background Color', ESG_TEXTDOMAIN)),
					'type' => 'color',
					'default' => '#FFFFFF',
					'container' => 'style',
					'hover' => 'true',
					'cpmode' => 'full'
				),
				array(
					'name' => array('handle' => 'box-shadow', 'text' => esc_attr__('Box Shadow', ESG_TEXTDOMAIN)),
					'type' => 'text',
					'default' => '0px 0px 0px 0px #000000',
					'container' => 'style',
					'hover' => 'true'
				),
				array(
					'name' => array('handle' => 'transition', 'text' => esc_attr__('Transition', ESG_TEXTDOMAIN)),
					'type' => 'select',
					'default' => 'fade',
					'values' => $transitions_media,
					'container' => 'anim'
				),
				array(
					'name' => array('handle' => 'transition-delay', 'text' => esc_attr__('Transition Delay', ESG_TEXTDOMAIN)),
					'type' => 'number',
					'default' => '0',
					'values' => array('0', '60', '1'),
					'container' => 'anim'
				),
				array(
					'name' => array('handle' => 'cover-bg-color', 'text' => esc_attr__('Cover BG Color', ESG_TEXTDOMAIN)),
					'type' => 'color',
					'default' => '#FFFFFF',
					'container' => 'layout',
					'cpmode' => 'full'
				),
				array(
					'name' => array('handle' => 'item-bg-color', 'text' => esc_attr__('Item BG Color', ESG_TEXTDOMAIN)),
					'type' => 'color',
					'default' => '#FFFFFF',
					'container' => 'layout',
					'cpmode' => 'full'
				),
				array(
					'name' => array('handle' => 'content-bg-color', 'text' => esc_attr__('Content BG Color', ESG_TEXTDOMAIN)),
					'type' => 'color',
					'default' => '#FFFFFF',
					'container' => 'layout',
					'cpmode' => 'full'
				),
			)
		);
	}
}
