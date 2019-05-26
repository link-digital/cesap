<?php

/***
* Implementes hook_preprocess_page
*/
function chipcha_base_theme_preprocess_page(&$vars)
{
  //Remove title and main content from home.
  if(drupal_is_front_page())
  {
    unset($vars['page']['content']['system_main']);
    $vars['title'] = '';
  }

  _chipcha_base_theme_set_logos($vars);

}

// Override theme_links__system_main_menu to allow dropdown menus
function chipcha_base_theme_links__system_main_menu($vars) {
  $menu_name = variable_get('menu_main_links_source', 'main-menu');
  $menu_tree = menu_tree($menu_name);

  foreach($menu_tree as $id => &$item)
  {
    if(strpos($id, '#') === 0) continue;
    $title = strtolower(check_plain($item['#title']));
    $title = preg_replace('/[^a-zA-Z0-9\-]+/', '-', $title);
    $item['#attributes']['class'][] = 'menu-' . $title;
  }

  unset($menu_tree['#theme_wrappers']);
  $output = '<ul' . drupal_attributes($vars['attributes']) . '>';
  $output .= drupal_render($menu_tree);
  $output .= '</ul>';

  return $output;
}



/***
* Implements hook_html_head_alter
*
* Adding favicons in multiple sizes
*/
function chipcha_base_theme_html_head_alter(&$vars)
{
  $icons = array(
    '16',
    '32',
    '64',
    '128',
  );

  _chipcha_base_theme_set_favicons('icon', $vars, $icons, 10);

  $icons = array(
    '57',
    '114',
    '72',
    '144',
    '60',
    '120',
    '76',
    '152',
    '160',
  );

  _chipcha_base_theme_set_favicons('apple-touch-icon', $vars, $icons, 20);
}

/***
* Helper functions
*/
function _chipcha_base_theme_set_favicons($rel, &$vars, $icons, $weight=10)
{
  global $base_path;

  $default_theme_path = drupal_get_path('theme', variable_get('theme_default')) . '/';
  $chipcha_theme_path = drupal_get_path('theme', 'chipcha_base_theme') . '/';


  foreach($icons as $size)
  {
    $icon = "icons/{$rel}-{$size}x{$size}.png";

    if(file_exists(DRUPAL_ROOT . '/' . $default_theme_path . $icon))
    {
      $icon_path = file_create_url($default_theme_path . $icon);
    }
    else if(file_exists(DRUPAL_ROOT . '/' . $chipcha_theme_path . $icon))
    {
      $icon_path = file_create_url($chipcha_theme_path . $icon);
    }
    else
    {
      continue;
    }

    $attributes = array(
      'rel' => $rel,
      'type' => 'image/png',
      'href' => $icon_path,
      'sizes' => "{$size}x{$size}",
    );


    $tag = array(
      '#type' => 'html_tag',
      '#tag' => 'link',
      '#attributes' => $attributes,
      '#weight' => $weight++
    );

    $vars[$icon] = $tag;
//    drupal_add_html_head($tag, $icon);
  }
}

function _chipcha_base_theme_set_logos(&$vars)
{
  global $base_path;

  $default_theme_path = drupal_get_path('theme', variable_get('theme_default')) . '/';
  $chipcha_theme_path = drupal_get_path('theme', 'chipcha_base_theme') . '/';

//  $default_theme_path = base_path() . drupal_get_path('theme', variable_get('theme_default')) . '/';

  $default_logo = $default_theme_path . 'img/logo.png';
	$logos = array(
		'logo_header_lg' => 'logo-header-lg.png',
		'logo_header_sm' => 'logo-header-sm.png',
		'logo_footer_lg' => 'logo-footer-lg.png',
		'logo_footer_sm' => 'logo-footer-sm.png',
	);

  $vars['logo'] = $base_path . $default_theme_path . 'img/logo.png';

  foreach($logos as $k => $v)
  {
	  if(file_exists(DRUPAL_ROOT . '/' . $default_theme_path . 'img/' . $v))
	  {
	    $vars[$k] = $base_path . $default_theme_path . 'img/' . $v;
	  }
  }

}
