<?php
/**
 * Return a time difference of a given time in
 * days, hours or minutes depending on the time
 * difference.
 *
 * @param $time (required)
*/
function get_time_difference( $time ) {
    $current_time = new DateTime( current_time( 'mysql' ) );
    $previous_time = new DateTime( $time );
    $difference = $current_time->diff( $previous_time );
    $timestamp = '';
    
    if ( 0 < $difference->y ) {
        /**
         * If we've passed one year, let's show the full
         * date.
        */
         $timestamp = get_the_date( 'F j, Y' );
    } else if ( 12 >= $difference->m && 1 <= $difference->m ) {
        /**
         * If we've made it here, we know that we have not
         * yet passed one year, but have made it passed one
         * month. As such, let's remove the year from the 
         * output, but keep the date style format.
        */
        $timestamp .= get_the_date( 'F j' );
    } else if ( 0 < $difference->d ) {
        /**
         * If we've made it here, we know that we have not
         * yet passed one month, but have made it passed one
         * day. As such, let's show just the number of days
         * that have passed.
        */
        $timestamp .= sprintf( translate_nooped_plural( _n_noop( '%s Day Ago', '%s Days Ago' ), $difference->days ), $difference->days );
    } else if ( 0 < $difference->h ) {
        /**
         * If we've made it here, we know that we have not
         * yet passed one day, but have made it passed one
         * hour. As such, let's show just the number of hours
         * that have passed.
        */
        $timestamp .= sprintf( translate_nooped_plural( _n_noop( '%s Hour Ago', '%s Hours Ago', 'listed' ), $difference->h, 'listed' ), $difference->h );
    } else if ( 0 < $difference->i ) {
        /**
         * If we've made it here, we know that we have not
         * yet passed one hour, but have made it passed one
         * minute. As such, let's show just the number of
         * minutes that have passed.
        */
        $timestamp .= sprintf( translate_nooped_plural( _n_noop( '%s Minute Ago', '%s Minutes Ago', 'listed' ), $difference->i, 'listed' ), $difference->i );
    } else {
        /**
         * If we've made it here, that this post is fresh
         * off the press. Let's show how fresh it is.
        */
        $timestamp = __( 'Just Now', 'listed' );
    }
 
    return $timestamp;
}