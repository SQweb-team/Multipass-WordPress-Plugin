<?php

function sqw_balise( $balise, $match ) {
	if ( preg_match('/<(\w+)(?(?!.+\/>).*>|$)/', $match, $tmp ) ) {
		if ( ! isset( $balise ) ) {
			$balise = [];
		}
		$balise[] = $tmp[1];
	}
	foreach ( $balise as $key => $value ) {
		if ( preg_match('/<\/(.+)>/', $value, $tmp ) ) {
			unset($balise[$key]);
		}
	}
	return $balise;
}

function transparent( $text, $percent ) {
	if ( 0 == $percent ) {
		return '';
	} elseif ( 100 == $percent ) {
		return $text;
	}
	$array_text = preg_split( '/(<.+?><\/.+?>)|(<.+?>)|( )/', $text, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
	foreach ( array_keys( $array_text, ' ', true ) as $key ) {
	    unset( $array_text[ $key ] );
	}
	$array_text = array_values( $array_text );
	$words = count( explode( ' ', $text ) );
	$nbr = ceil( $words / 100 * $percent );
	$lambda = (1 / $nbr);
	$alpha = 1;
	$begin = 0;
	$balise = [];
	while ( $begin < $nbr ) {
		if ( preg_match( '/<.+?>/', $array_text[ $begin ], $match ) ) {
			$balise = sqw_balise( $balise, $match[0] );
			$final[] = $array_text[ $begin ];
			$nbr++;
		} else {
			$final[] = '<span style="opacity: ' . $alpha . '">' . $array_text[ $begin ] . '</span>';
			$alpha -= $lambda;
		}
		$begin++;
	}
	$final[] = $array_text[ count($array_text) - 1 ];
	foreach ($balise as $value) {
		$final[] = '</' . $value . '>';
	}
	$final = implode( ' ', $final );
	return $final;
}
