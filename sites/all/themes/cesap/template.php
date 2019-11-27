<?php

function cesap_preprocess_html(&$vars)
{
  // drupal_add_css('https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css', array('type' => 'external'));
  drupal_add_css('https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700|Roboto:400,500,700', array('type' => 'external'));
}

function cesap_preprocess_page(&$vars)
{

  drupal_add_js (path_to_theme() . '/js/lib/lfmodal.js');
  drupal_add_js (path_to_theme() . '/js/lib/tiny-slider.min.js');
  drupal_add_css(path_to_theme() . '/js/lib/tiny-slider.css');

  if(isset($vars['node']))
  {
    $node = &$vars['node'];
    if(in_array($node->type, array('evento', 'actualidad')))
    {
      // $vars['title'] = node_type_get_name($node);
      $vars['title'] = 'Eventos y actualidad';
      $vars['theme_hook_suggestions'][] = 'page__side_right';
    }

    if(in_array($node->type, array('pagina_basica')))
    {
      // $vars['title'] = 'CESAP';
      // $vars['theme_hook_suggestions'][] = 'page__side_right';
    }

    if(in_array($node->type, array('reserva')))
    {
      drupal_add_js (path_to_theme() . '/js/ezapp_request.js');
      if($node->nid == 166)
      {
        $vars['title'] = 'Salones & eventos';
      }
      else if($node->nid == 172)
      {
        $vars['title'] = 'Deportes';
      }
      else
      {
        $vars['title'] = 'Reserva de hotel';
      }
      // $vars['theme_hook_suggestions'][] = 'page__node__reservation';
    }
  }

  // Vue paths
  $vue_paths = 
    'hotel' . PHP_EOL .
    'salones-eventos' . PHP_EOL .
    'deportes' . PHP_EOL .
    'user/mis-reservas' . PHP_EOL
    ;

  if(drupal_match_path(request_path(), $vue_paths))
  {
    // drupal_add_js('https://cdn.jsdelivr.net/npm/vue/dist/vue.js', 'external');
    // drupal_add_js (path_to_theme() . '/js/lib/vue.js');
    drupal_add_js('https://unpkg.com/vue', 'external');
    // drupal_add_js (path_to_theme() . '/js/lib/vue-hotel-datepicker.umd.min.js');
    drupal_add_js (path_to_theme() . '/js/lib/vue-datepicker.min.js');
    drupal_add_css(path_to_theme() . '/js/lib/vue-datepicker.min.css');
  }
}

function cesap_preprocess_node(&$vars)
{
  if($vars['type'] == 'reserva' && $vars['view_mode'] == 'full')
  {
    if(!empty($vars['field_reserve_type']))
    {
      $vars['theme_hook_suggestions'][] = 'node__reserva__' . $vars['field_reserve_type'][0]['value'];
    }
  }
  // else if($vars['type'] == 'galeria' && $vars['view_mode'] == 'teaser')
  // {
  //   $vars['theme_hook_suggestions'][] = 'node__galeria__teaser';
  // }
}

function cesap_breadcrumb($vars)
{
  $breadcrumb = $vars['breadcrumb'];
  if (!empty($breadcrumb)) {
    // $breadcrumb[] = '<span class="color-blue-3">' . drupal_get_title() . '</span>';
    return '<div class="breadcrumb">'. implode(' / ', $breadcrumb) .'</div>';
  }
}

function _cesap_spaces_json()
{
  $spaces = array();
  $terms = taxonomy_get_tree(4);
  $tids = array();

  foreach($terms as $t)
  {
    $tids[] = $t->tid;
  }

  $terms = taxonomy_term_load_multiple($tids);
  foreach($terms as $t)
  {
    $term = taxonomy_term_view($t);
    // kpr($term);
    $spaces[] = array(
      'name' => $term['#term']->name,
      'ico' => render($term['field_image_1']),
      'cid' => render($term['field_ea_id_category']),
    );
  }

  return json_encode($spaces);
}

function cesap_preprocess_views_view(&$vars)
{
  if($vars['view']->name == 'sedes' && $vars['view']->current_display === 'page')
  {
    drupal_add_css(path_to_theme() . '/js/lib/ol.css');
    drupal_add_js(path_to_theme() . '/js/lib/ol.js');
    drupal_add_js(path_to_theme() . '/js/sedes.js');

    $coords = array();
    $branches = array();
    $points = array();

    foreach($vars['view']->result as $item)
    {
      $node = node_load($item->nid);

      $item_coords = field_get_items('node', $node, 'field_coords');
      $content = field_get_items('node', $node, 'field_longtext_1');
      $coord = explode(',', $item_coords[0]['safe_value']);
      $coords = array((double) $coord[1], (double) $coord[0]);
      $points[] = $coords;

      $branches[] = array(
        'content' => '<div class="color-blue-1">' . $node->title . '</div><div>' . nl2br($content[0]['safe_value']) . '</div>',
        'coords' => $coords,
      );
    }

    $settings = array(
      'marker' =>   base_path() . path_to_theme() . '/img/map-marker-violet.png',
      'branches' => $branches,
      'center' => _cesap_coordinates_center($points),
    );

    drupal_add_js(array('carbon' => $settings), 'setting');

  }
}

function _cesap_coordinates_center($data)
{
    if (!is_array($data)) return FALSE;

    $num_coords = count($data);

    $X = 0.0;
    $Y = 0.0;
    $Z = 0.0;

    foreach ($data as $coord)
    {
        $lat = $coord[0] * pi() / 180;
        $lon = $coord[1] * pi() / 180;

        $a = cos($lat) * cos($lon);
        $b = cos($lat) * sin($lon);
        $c = sin($lat);

        $X += $a;
        $Y += $b;
        $Z += $c;
    }

    $X /= $num_coords;
    $Y /= $num_coords;
    $Z /= $num_coords;

    $lon = atan2($Y, $X);
    $hyp = sqrt($X * $X + $Y * $Y);
    $lat = atan2($Z, $hyp);

    return array($lat * 180 / pi(), $lon * 180 / pi());
}

// User pages
function cesap_theme()
{
  $items = array();
	
  $items['user_login'] = array(
    'render element' => 'form',
    'path' => drupal_get_path('theme', 'cesap') . '/templates/blocks/',
    'template' => 'user-login',
  );

  $items['user_pass'] = array(
    'render element' => 'form',
    'path' => drupal_get_path('theme', 'cesap') . '/templates/blocks/',
    'template' => 'user-pass',
  );

  $items['user_register_form'] = array (
    'render element' => 'form',
    'path' => drupal_get_path('theme', 'cesap') . '/templates/blocks/',
    'template' => 'user-register',
    // 'preprocess functions' => array('YOURTHEME_preprocess_user_register_form'),
  );

  return $items;
}

function cesap_select($variables) {
  $element = $variables['element'];
  element_set_attributes($element, array('id', 'name', 'size'));
  _form_set_class($element, array('form-select'));

  return '<div class="custom-select"><select' . drupal_attributes($element['#attributes']) . '>' . form_select_options($element) . '</select></div>';
}

function cesap_file_link($variables) {
  $file = $variables['file'];
  $icon_directory = $variables['icon_directory'];

  $url = file_create_url($file->uri);

  // Human-readable names, for use as text-alternatives to icons.
  $mime_name = array(
    'application/msword' => t('Microsoft Office document icon'),
    'application/vnd.ms-excel' => t('Office spreadsheet icon'),
    'application/vnd.ms-powerpoint' => t('Office presentation icon'),
    'application/pdf' => t('PDF icon'),
    'video/quicktime' => t('Movie icon'),
    'audio/mpeg' => t('Audio icon'),
    'audio/wav' => t('Audio icon'),
    'image/jpeg' => t('Image icon'),
    'image/png' => t('Image icon'),
    'image/gif' => t('Image icon'),
    'application/zip' => t('Package icon'),
    'text/html' => t('HTML icon'),
    'text/plain' => t('Plain text icon'),
    'application/octet-stream' => t('Binary Data'),
  );

  $mimetype = file_get_mimetype($file->uri);

  $icon = theme('file_icon', array(
    'file' => $file,
    'icon_directory' => $icon_directory,
    'alt' => !empty($mime_name[$mimetype]) ? $mime_name[$mimetype] : t('File'),
  ));

  // Set options as per anchor format described at
  // http://microformats.org/wiki/file-format-examples
  $options = array(
    'attributes' => array(
      'type' => $file->filemime . '; length=' . $file->filesize,
    ),
  );

  // Use the description as the link text if available.
  if (empty($file->description)) {
    $link_text = $file->filename;
  }
  else {
    $link_text = $file->description;
    $options['attributes']['title'] = check_plain($file->filename);
  }
  $options['attributes']['target'] = '_blank';

  return '<span class="file">' . $icon . ' ' . l($link_text, $url, $options) . '</span>';
}