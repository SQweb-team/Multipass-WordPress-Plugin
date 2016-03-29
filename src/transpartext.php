<?php

function transparent( $text, $percent ) {

	if ( 0 == $percent ) {
		return '';
	}
	$array_text = explode( ' ', $text );
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
