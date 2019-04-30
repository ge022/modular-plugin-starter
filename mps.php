<?php
/*
 * Plugin Name: Modular Plugin Starter
 * Plugin URI: localhost
 * Description: This is a custom plugin.
 * Version: 1.0.0
 * Author: localhost
 * Author URI: localhost
 * Text Domain: mps
 * License: GPLv2 or later
 */

/*
   Copyright (C) 2018 localhost

   This program is free software; you can redistribute it and/or
   modify it under the terms of the GNU General Public License
   as published by the Free Software Foundation; either version 2
   of the License, or (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
   Also add information on how to contact you by electronic and paper mail.
 */

define( 'MPS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MPS__PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'MPS__PLUGIN_IDENTIFIER', plugin_basename( __FILE__ ) );

require_once( MPS__PLUGIN_DIR . 'class.mps.php' );
require_once( MPS__PLUGIN_DIR . 'class.mps-options.php' );

register_activation_hook( __FILE__, [ 'MPS', 'plugin_activate' ] );
register_deactivation_hook( __FILE__, [ 'MPS', 'plugin_deactivate' ] );

add_action( 'plugins_loaded', [ 'MPS', 'load_modules' ], 100 );

MPS::init();