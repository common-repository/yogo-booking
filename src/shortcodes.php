<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_shortcode( 'yogo-calendar', function ( $args ) {
	$branch = isset( $args['branch'] ) ? $args['branch'] : '';
    $classType = isset( $args['class-type']) ? $args['class-type'] : '';
    $teacher = isset( $args['teacher']) ? $args['teacher'] : '';
    $startDate = isset( $args['start-date']) ? $args['start-date'] : '';

	return '<div class="yogo-calendar" ' .
	       'data-branch="' . $branch . '"' .
           'data-class-type="' . $classType . '"' .
           'data-teacher="' . $teacher . '"' .
           'data-start-date="' . $startDate . '"' .
	       '></div>';
} );

add_shortcode( 'yogo-teachers', function ( $args ) {
    $startDate = isset( $args['start-date']) ? $args['start-date'] : '';

    return '<div class="yogo-teachers" ' .
        'data-start-date="' . $startDate . '"' .
        'data-teachers="' . $args['teachers'] . '"' .
        'data-teacher="' . $args['teacher'] . '"' .
        '></div>';
} );

add_shortcode( 'yogo-events', function ( $args ) {
	return '<div class="yogo-events" data-event-group="' .
  ( isset( $args['event-group'] ) ? $args['event-group'] : '' ) .
  '"></div>';
} );

add_shortcode( 'yogo-prices', function ( $args ) {
	return '<div class="yogo-prices" data-price-group="' .
  ( isset( $args['price-group'] ) ? $args['price-group'] : '' ) .
  '"></div>';
} );

add_shortcode( 'yogo-products', function ( $args ) {
	return '<div class="yogo-products"></div>';
} );


add_shortcode( 'yogo-event-button', function ( $args ) {

	$eventId = isset( $args['event'] ) ? $args['event'] : null;
	if ( ! $eventId ) {
		return '[event-button MISSING EVENT ID]';
	}

	$cssClasses = isset( $args['css-classes'] ) ? $args['css-classes'] : '';
	$cta        = isset( $args['cta'] ) ? $args['cta'] : '';

	return '<div ' .
	       'class="yogo-event-button" ' .
	       'data-event="' . $eventId . '" ' .
	       'data-cta="' . $cta . '" ' .
	       'data-css-classes="' . $cssClasses . '"></div>';
} );

add_shortcode( 'yogo-class-pass-button', function ( $args ) {

	$classPassId = isset( $args['class-pass'] ) ? $args['class-pass'] : '';
	if ( ! $classPassId ) {
		return '[class-pass-button MISSING CLASS PASS ID]';
	}

	$cssClasses = isset( $args['css-classes'] ) ? $args['css-classes'] : '';
	$cta        = isset( $args['cta'] ) ? $args['cta'] : '';

	return '<div ' .
	       'class="yogo-class-pass-button" ' .
	       'data-class-pass="' . $classPassId . '" ' .
	       'data-cta="' . $cta . '" ' .
	       'data-css-classes="' . $cssClasses . '"></div>';
} );

add_shortcode( 'yogo-membership-button', function ( $args ) {

	$membershipId = isset( $args['membership'] ) ? $args['membership'] : '';
	if ( ! $membershipId ) {
		return '[membership-button MISSING MEMBERSHIP ID]';
	}

	$membershipPaymentOptionId = isset( $args['payment-option'] ) ? $args['payment-option'] : '';

	$cssClasses = isset( $args['css-classes'] ) ? $args['css-classes'] : '';
	$cta        = isset( $args['cta'] ) ? $args['cta'] : '';

	return '<div ' .
	       'class="yogo-membership-button" ' .
	       'data-membership="' . $membershipId . '" ' .
	       'data-payment-option="' . $membershipPaymentOptionId . '" ' .
	       'data-cta="' . $cta . '" ' .
	       'data-css-classes="' . $cssClasses . '"></div>';
} );

add_shortcode( 'yogo-membership-button', function ( $args ) {

    $membershipId = isset( $args['membership'] ) ? $args['membership'] : '';
    if ( ! $membershipId ) {
        return '[membership-button MISSING MEMBERSHIP ID]';
    }

    $membershipPaymentOptionId = isset( $args['payment-option'] ) ? $args['payment-option'] : '';

    $cssClasses = isset( $args['css-classes'] ) ? $args['css-classes'] : '';
    $cta        = isset( $args['cta'] ) ? $args['cta'] : '';

    return '<div ' .
        'class="yogo-membership-button" ' .
        'data-membership="' . $membershipId . '" ' .
        'data-payment-option="' . $membershipPaymentOptionId . '" ' .
        'data-cta="' . $cta . '" ' .
        'data-css-classes="' . $cssClasses . '"></div>';
} );

add_shortcode( 'yogo-video-group', function ( $args ) {

	$videoGroupId = isset( $args['video-group'] ) ? $args['video-group'] : null;
	if ( ! $videoGroupId ) {
		return '[video group MISSING VIDEO GROUP ID]';
	}

	$cssClasses = isset( $args['css-classes'] ) ? $args['css-classes'] : '';

	return '<div ' .
	       'class="yogo-video-group" ' .
	       'data-video-group="' . $videoGroupId . '" ' .
	       'data-css-classes="' . $cssClasses . '"></div>';
} );
