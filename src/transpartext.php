<?php

function transparent( $text, $percent ) {
	if ( 0 == $percent ) {
		return '';
	} elseif ( 100 == $percent ) {
		return $text;
	}
	$array_text = preg_split( '/(<.+?>)|( )/', $text, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
	foreach ( array_keys( $array_text, ' ', true ) as $key ) {
	    unset( $array_text[ $key ] );
	}
	$array_text = array_values( $array_text );
	$words = count( explode( ' ', $text ) );
	$nbr = ceil( $words / 100 * $percent );
	$lambda = (1 / $nbr);
	$alpha = 1;
	$begin = 0;
	while ( $begin < $nbr ) {
		$final[ $begin ] = '<span style="opacity: ' . $alpha . '">' . $array_text[ $begin ] . '</span>';
		$begin++;
		$alpha -= $lambda;
	}
	$final = implode( ' ', $final );
	return $final;
}
