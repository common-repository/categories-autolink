<?php
function categories_autolink($text) 
{

/*
Plugin Name: Categories Autolink 
Version: 2.0
Version description: Automatically turns categories names in links to the respective archives. Keeps the original words case in text.
Plugin URI: http://www.centrostudilaruna.it/huginnemuninn/plugin-wordpress
Description: Wraps categories names in links
Author: Alberto Lombardo
Author URI: http://www.centrostudilaruna.it/huginnemuninn
Based on : Autolink by Chris Lynch http://www.planetofthepenguins.com
Copyright (c) 2007
Released under the GPL license
http://www.gnu.org/licenses/gpl.txt

    This file is part of WordPress.
    WordPress is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/* Define the $wpdb to perform queries on the WP database */
global $wpdb;
/* Wrap spaces around the text - helps with regexp? */
$text = " $text ";
/* Set exceptions; will be developed in following releases */
$exceptions = 'WHERE cat_name <> "Names"';
/* Load categories */
$categories = $wpdb->get_results("SELECT name, term_id identificativo FROM $wpdb->terms LEFT JOIN $wpdb->term_taxonomy USING (term_id) WHERE taxonomy = 'category'");
/* Loop through links */
foreach ($categories as $categoria) 
{
/* create cat_urls */
$cat_urls = get_category_link($categoria->identificativo);
/* Replace any instance of the cat_name with the cat_name wrapped in a HREF to link_url */
$text = preg_replace("|(?!<[^<>]*?)(?<![?./&])\b($categoria->name)\b(?!:)(?![^<>]*?>)|imsU","<a href=\"$cat_urls\">$1</a>" , $text);
}
/* Trim extraneous spaces off and return */
return trim( $text );
}
add_filter('the_content', 'categories_autolink', 18);
?>