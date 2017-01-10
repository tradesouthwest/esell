<?php
/**
 * TSW Listing Nano Directory
 * Author: Larry Judd Oliver @tradesouthwest | http://tradesouthwest.com
 * Contributors in readme.md file
 * License in LICENSE.md file
 * controls - functions - filters
 */

// Convert special HTML entities back to characters
function esc($s){
    echo htmlspecialchars_decode($s, ENT_HTML5);
}

// returns only letters and numbers
function alpha_only( $string )
    {
        return preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
    }
/**
* Remove all characters except letters, numbers, and spaces.
*
* @param string $string
* @return string
*/
function alpha_spaces( $string ) {
    return preg_replace( "/[^a-z0-9 ]/i", "", $string );
}
/**
* Transform two or more spaces into just one space.
*
* @param string $string
* @return string
*/
function strip_whitespace( $string ) {
    return preg_replace( '/  +/', ' ', $string );
}
// safe redirect
function redirect($url)
{
    if (!headers_sent())
    {
        header('Location: '.$url);
        exit;
        }
    else
        {
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="3;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
}
// display sessions (for debug)
function display_sessions() {
$html=
$html .= '<pre>';
$html = print_r($_SESSION);
$html .= '<pre>';
return $html;
}

function seoUrl($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}

// standardize date inputs
$date_entered = date('m-d-Y H:i:s');

require 'config.settings.php';
?>
