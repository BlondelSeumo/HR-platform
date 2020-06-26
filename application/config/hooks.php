<?php
defined('BASEPATH') OR exit('No direct script access allowed');



$hook['post_controller_constructor'][] = array(
'function' => 'redirect_ssl',
'filename' => 'ssl.php',
'filepath' => 'hooks'
);

//
// CSRF Protection hooks, don't touch these unless you know what you're
// doing.
//
// THE ORDER OF THESE HOOKS IS EXTREMELY IMPORTANT!!
//
 
// THIS HAS TO GO FIRST IN THE post_controller_constructor HOOK LIST.
$hook['post_controller_constructor'][] = array( // Mind the "[]", this is not the only post_controller_constructor hook
  'class'    => 'CSRF_Protection',
  'function' => 'validate_tokens',
  'filename' => 'csrf.php',
  'filepath' => 'hooks'
);
 
// Generates the token (MUST HAPPEN AFTER THE VALIDATION HAS BEEN MADE, BUT BEFORE THE CONTROLLER
// IS EXECUTED, OTHERWISE USER HAS NO ACCESS TO A VALID TOKEN FOR CUSTOM FORMS).
$hook['post_controller_constructor'][] = array( // Mind the "[]", this is not the only post_controller_constructor hook
  'class'    => 'CSRF_Protection',
  'function' => 'generate_token',
  'filename' => 'csrf.php',
  'filepath' => 'hooks'
);
 
// This injects tokens on all forms
$hook['display_override'] = array(
  'class'    => 'CSRF_Protection',
  'function' => 'inject_tokens',
  'filename' => 'csrf.php',
  'filepath' => 'hooks'
);
