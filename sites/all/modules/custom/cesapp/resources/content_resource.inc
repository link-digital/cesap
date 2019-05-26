<?php

function _cesapp_services_content_installations()
{
  // Terms
  $tids = array();
  $tree = taxonomy_get_tree(6);
  foreach($tree as $item)
  {
    $tids[] = $item->tid;
    // $tree[$item->parents[0]] = 
  }
  $terms = taxonomy_term_load_multiple($tids);
  $terms_view = taxonomy_term_view_multiple($terms, 'app_teaser');

  $output = array();
  $categories = array();
  foreach($tree as $item)
  {
    $tv = $terms_view['taxonomy_terms'][$item->tid];
    $categories[$item->parents[0]][] = array(
      'tid' => $item->tid,
      'title' => $item->name,
      'image' => render($tv['field_image_1']),
    );
  }

  $output['terms'] = $categories;

  //Nodes
  $nids = taxonomy_select_nodes($tids);
  $nodes = node_load_multiple($nids);
  $nodes_view = node_view_multiple($nodes, 'app_teaser');

  $nodes = array();
  foreach(element_children($nodes_view['nodes']) as $nid)
  {
    $node_view = $nodes_view['nodes'][$nid];
    $node = &$node_view['#node'];
    $tid = $node->field_instalacion['und'][0]['tid'];
    $nodes[$tid] = array(
      'title' => $node->title,
    );

    foreach(element_children($node_view['field_items_2']) as $delta)
    {
      $item = $node_view['field_items_2'][$delta];
      $nodes[$tid]['items'][] = array(
        'body' => render($item['field_longtext_1']),
        'image' => render($item['field_images_1']),
      );
    }
  }

  $output['nodes'] = $nodes;

  // var_export($nids);

  return $output;
}
