<?php
/**
 * Audio Player module config.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

class Kata_Plus_Pro_AudioPlayer extends Widget_Base {
	public function get_name() {
		return 'kata-plus-audio-player';
	}

	public function get_title() {
		return esc_html__( 'Audio Player', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-audio-player';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return ['wp-mediaelement', 'kata-plus-audio-player'];
	}

	public function get_style_depends() {
		return ['wp-mediaelement', 'kata-plus-audio-player'];
	}
	protected function register_controls() {
		// Content Tab
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Setting', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$repeater = new Repeater();

		$repeater->add_control(
		    'audio_file',
		    [
		        'label'			=> esc_html__( 'Choose Audio', 'kata-plus' ),
		        'type'			=> 'kata_plus_icons_audio_chooser',
		        'placeholder'	=> esc_html__( 'URL to audio file', 'kata-plus' ),
		        'description'	=> esc_html__( 'Choose audio file from media library.', 'kata-plus' ),
		    ]
		);
		$repeater->add_control(
			'audio_title',
			[
				'label'			=> __( 'Title', 'kata-plus' ),
				'type'			=> Controls_Manager::TEXT,
				'default'		=> __( 'Audio Title', 'kata-plus' ),
				'label_block'	=> true,
				'dynamic'		=> [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'audio_artist',
			[
				'label'			=> __( 'Artist', 'kata-plus' ),
				'type'			=> Controls_Manager::TEXT,
				'default'		=> __( 'David Rodrigers', 'kata-plus' ),
				'label_block'	=> true,
				'dynamic'		=> [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'audio_date',
			[
				'label'			=> __( 'Date', 'kata-plus' ),
				'type'			=> Controls_Manager::TEXT,
				'default'		=> __( 'March 12, 2021', 'kata-plus' ),
				'label_block'	=> true,
				'dynamic'		=> [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'loop',
			[
				'label'        => __( 'Loop', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'kata-plus' ),
				'label_off'    => __( 'Off', 'kata-plus' ),
				'return_value' => 'yes',
			]
		);
		$repeater->add_control(
			'autoplay',
			[
				'label'        => __( 'Autoplay', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'kata-plus' ),
				'label_off'    => __( 'Off', 'kata-plus' ),
				'return_value' => 'yes',
			]
		);
		$repeater->add_control(
			'preload',
			[
				'label'   => __( 'Preload', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'auto',
				'options' => [
					'none'		=> __( 'None', 'kata-plus' ),
					'auto'		=> __( 'Auto', 'kata-plus' ),
					'metadata'	=> __( 'Metadata', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'audios',
			[
				'label'			=> __( 'Audios', 'kata-plus' ),
				'type'			=> Controls_Manager::REPEATER,
				'fields'		=> $repeater->get_controls(),
				'prevent_empty' => false,
				'default'		=> [
				],
				'title_field' => '{{{ audio_title }}}',
			]
		);
		$this->end_controls_section();

		// Content Tab
		$this->start_controls_section(
			'audio_wrapper_section',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'audio_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-audio-player' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'audio_items',
			[
				'label' => esc_html__( 'Items', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'audio_item',
			[
				'label'     => esc_html__( 'Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-track-wrapper' ),
			]
		);
		$this->add_control(
			'audio_item_content_wrapper',
			[
				'label'     => esc_html__( 'Content Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-track-content' ),
			]
		);
		$this->add_control(
			'audio_item_title',
			[
				'label'     => esc_html__( 'Title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-track-title' ),
			]
		);
		$this->add_control(
			'audio_item_meta_wrapper',
			[
				'label'     => esc_html__( 'Meta Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-track-meta-wrapper' ),
			]
		);
		$this->add_control(
			'audio_item_artist',
			[
				'label'     => esc_html__( 'Artist', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-track-artist' ),
			]
		);
		$this->add_control(
			'audio_item_date',
			[
				'label'     => esc_html__( 'Date', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-track-date' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'play_mode_audio_items',
			[
				'label' => esc_html__( 'Play Mode Items', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'play_mode_audio_item',
			[
				'label'     => esc_html__( 'Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-track-wrapper.playing-audio'),
			]
		);
		$this->add_control(
			'play_mode_audio_item_content_wrapper',
			[
				'label'     => esc_html__( 'Content Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-track-content', '', '.playing-audio'),
			]
		);
		$this->add_control(
			'play_mode_audio_item_title',
			[
				'label'     => esc_html__( 'Title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-track-title', '', '.playing-audio'),
			]
		);
		$this->add_control(
			'play_mode_audio_item_artist',
			[
				'label'     => esc_html__( 'Artist', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-track-artist', '', '.playing-audio'),
			]
		);
		$this->add_control(
			'play_mode_audio_item_date',
			[
				'label'     => esc_html__( 'Date', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-track-date', '', '.playing-audio'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'audio_player',
			[
				'label' => esc_html__( 'Player', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'audio_player_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.mejs-container' ),
			]
		);
		$this->add_control(
			'audio_player_controls_wrapper',
			[
				'label'     => esc_html__( 'Controls Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.mejs-controls' ),
			]
		);
		$this->add_control(
			'audio_player_controls_play_pause_wrapper',
			[
				'label'     => esc_html__( 'Play/Pause Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.mejs-playpause-button' ),
			]
		);
		$this->add_control(
			'audio_player_controls_play_button',
			[
				'label'     => esc_html__( 'Play Button', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '[aria-label="Play"]', '', '.mejs-playpause-button' ),
			]
		);
		$this->add_control(
			'audio_player_controls_pause_button',
			[
				'label'     => esc_html__( 'Pause Button', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '[aria-label="Pause"]', '', '.mejs-playpause-button' ),
			]
		);
		$this->add_control(
			'audio_player_controls_current_time_wrapper',
			[
				'label'     => esc_html__( 'Current Time Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.mejs-currenttime-container' ),
			]
		);
		$this->add_control(
			'audio_player_controls_current_time',
			[
				'label'     => esc_html__( 'Current Time', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.mejs-currenttime' ),
			]
		);
		$this->add_control(
			'audio_player_controls_rail_wrapper',
			[
				'label'     => esc_html__( 'Rail Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.mejs-time-rail' ),
			]
		);
		$this->add_control(
			'audio_player_controls_rail',
			[
				'label'     => esc_html__( 'Rail', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.mejs-time-slider' ),
			]
		);
		$this->add_control(
			'audio_player_controls_rail_loaded_time',
			[
				'label'     => esc_html__( 'Rail Time Loaded', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.mejs-time-loaded' ),
			]
		);
		$this->add_control(
			'audio_player_controls_rail_current_time',
			[
				'label'     => esc_html__( 'Rail Time Current', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.mejs-time-current' ),
			]
		);
		$this->add_control(
			'audio_player_controls_duration_wrapper',
			[
				'label'     => esc_html__( 'Duration Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.mejs-duration-container' ),
			]
		);
		$this->add_control(
			'audio_player_controls_duration',
			[
				'label'     => esc_html__( 'Duration', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.mejs-duration' ),
			]
		);
		$this->add_control(
			'audio_player_controls_volume',
			[
				'label'     => esc_html__( 'Volume Button Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.mejs-volume-button' ),
			]
		);
		$this->add_control(
			'audio_player_controls_volume_mute',
			[
				'label'     => esc_html__( 'Volume Mute', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '[title="Mute"]', '', '.mejs-volume-button' ),
			]
		);
		$this->add_control(
			'audio_player_controls_volume_unmute',
			[
				'label'     => esc_html__( 'Volume Unmute', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '[title="Unmute"]', '', '.mejs-volume-button' ),
			]
		);
		$this->add_control(
			'audio_player_controls_slider_volume_slider_wrapper',
			[
				'label'     => esc_html__( 'Volume Slider Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.mejs-horizontal-volume-slider' ),
			]
		);
		$this->add_control(
			'audio_player_controls_slider_volume_slider',
			[
				'label'     => esc_html__( 'Volume Slider', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.mejs-horizontal-volume-total' ),
			]
		);
		$this->add_control(
			'audio_player_controls_slider_volume_slider_current',
			[
				'label'     => esc_html__( 'Current Volume', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.mejs-horizontal-volume-current' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'play_mode_audio_player',
			[
				'label' => esc_html__( 'Player Play Mode', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'play_mode_audio_player_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio .mejs-container' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_wrapper',
			[
				'label'     => esc_html__( 'Controls Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio .mejs-controls' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_play_pause_wrapper',
			[
				'label'     => esc_html__( 'Play/Pause Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio .mejs-playpause-button' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_play_button',
			[
				'label'     => esc_html__( 'Play Button', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio [aria-label="Play"]', '', '.mejs-playpause-button' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_pause_button',
			[
				'label'     => esc_html__( 'Pause Button', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio [aria-label="Pause"]', '', '.mejs-playpause-button' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_current_time_wrapper',
			[
				'label'     => esc_html__( 'Current Time Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio .mejs-currenttime-container' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_current_time',
			[
				'label'     => esc_html__( 'Current Time', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio .mejs-currenttime' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_rail_wrapper',
			[
				'label'     => esc_html__( 'Rail Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio .mejs-time-rail' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_rail',
			[
				'label'     => esc_html__( 'Rail', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio .mejs-time-slider' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_rail_loaded_time',
			[
				'label'     => esc_html__( 'Rail Time Loaded', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio .mejs-time-loaded' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_rail_current_time',
			[
				'label'     => esc_html__( 'Rail Time Current', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio .mejs-time-current' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_duration_wrapper',
			[
				'label'     => esc_html__( 'Duration Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio .mejs-duration-container' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_duration',
			[
				'label'     => esc_html__( 'Duration', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio .mejs-duration' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_volume',
			[
				'label'     => esc_html__( 'Volume Button Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio .mejs-volume-button' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_volume_mute',
			[
				'label'     => esc_html__( 'Volume Mute', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio [title="Mute"]', '', '.mejs-volume-button' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_volume_unmute',
			[
				'label'     => esc_html__( 'Volume Unmute', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio [title="Unmute"]', '', '.mejs-volume-button' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_slider_volume_slider_wrapper',
			[
				'label'     => esc_html__( 'Volume Slider Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio .mejs-horizontal-volume-slider' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_slider_volume_slider',
			[
				'label'     => esc_html__( 'Volume Slider', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio .mejs-horizontal-volume-total' ),
			]
		);
		$this->add_control(
			'play_mode_audio_player_controls_slider_volume_slider_current',
			[
				'label'     => esc_html__( 'Current Volume', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.playing-audio .mejs-horizontal-volume-current' ),
			]
		);
		$this->end_controls_section();


		// Common controls
		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}
}
