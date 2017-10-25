<?php

function sqw_balise( $balise, $match ) {
	if ( preg_match( '/<(\w+)(?(?!.+\/>).*>|$)/', $match, $tmp ) ) {
		if ( ! isset( $balise ) ) {
			$balise = array();
		}
		$balise[] = $tmp[1];
	}
	foreach ( $balise as $key => $value ) {
		if ( preg_match( '/<\/(.+)>/', $value, $tmp ) ) {
			unset( $balise[ $key ] );
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
	if ( empty( $text ) ) {
		return $text;
	}
	$array_text = preg_split( '/(<.+?><\/.+?>)|(<.+?>)|( )/', $text, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
	foreach ( array_keys( $array_text, ' ', true ) as $key ) {
		unset( $array_text[ $key ] );
	}
	$array_text = array_values( $array_text );
	$words      = count( $array_text );
	$nbr        = ceil( $words / 100 * $percent );
	$lambda     = ( 1 / $nbr );
	$alpha      = 1;
	$begin      = 0;
	$balise     = array();
	while ( $begin < $nbr ) {
		if ( isset( $array_text[ $begin + 1 ] ) ) {
			if ( preg_match( '/<.+?>/', $array_text[ $begin ], $match ) ) {
				$balise  = sqw_balise( $balise, $match[0] );
				$final[] = $array_text[ $begin ];
				$nbr++;
			} else {
				$final[] = '<span style="opacity: ' . number_format( $alpha, 5, '.', '' ) . '">' . $array_text[ $begin ] . '</span>';
				$alpha  -= $lambda;
			}
		}
		$begin++;
	}
	foreach ( $balise as $value ) {
		$final[] = '</' . $value . '>';
	}
	$final = implode( ' ', $final );
	return $final;
}
