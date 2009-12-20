<?php
// $Id: views_audio.inc,v 1.2.2.1 2006/08/08 15:57:07 drewish Exp $

function audio_views_tables() {
  $tables['audio'] = array(
    'name' => 'audio',
    'join' => array(
      'left' => array(
        'table' => 'node',
        'field' => 'vid'
      ),
      'right' => array(
        'field' => 'vid'
      )
    ),
    'fields' => array(
      'play_count' => array(
        'name' => t('Audio: Play count'),
        'sortable' => FALSE,
        'help' => t('This will display the number of times this has been played.'),
      ),
      'download_count' => array(
        'name' => t('Audio: Download count'),
        'sortable' => FALSE,
        'help' => t('This will display the number of times this has been downloaded.'),
      ),
      'playtime' => array(
        'name' => t('Audio: Length'),
        'sortable' => TRUE,
        'help' => t('This will display the play length of the audio.'),
      ),
      'play_link' => array(
        'name' => t('Audio: Player link/flash'),
        'handler' => 'audio_views_handler_field_player',
        'notafield' => TRUE,
        'sortable' => FALSE,
        'help' => t('This will display a flash player/link.'),
      ),
      'download_link' => array(
        'name' => t('Audio: Download link'),
        'handler' => 'audio_views_handler_field_download',
        'notafield' => TRUE,
        'sortable' => FALSE,
        'help' => t('This will display a download link if the node allows it.'),
      ),
    ),
    'filters' => array(
      'downloadable' => array(
        'name' => t('Audio: Downloadable'),
        'operator' => array('=' => 'Equals'),
        'list' => 'views_handler_operator_yesno',
        'list-type' => 'select',
        'help' => t('Filter by whether or not the audio is downloadable. '),
      ),
    ),
  );

  $tables['audio_file'] = array(
    'name' => 'audio_file',
    'join' => array(
      'left' => array(
        'table' => 'audio',
        'field' => 'vid'
      ),
      'right' => array(
        'field' => 'vid'
      )
    ),
    'fields' => array(
      'filesize' => array(
        'name' => t('Audio: File size'),
        'handler' => 'views_handler_field_filesize',
        'sortable' => TRUE,
        'help' => t("This will display the audio file's size."),
      ),
    ),
  );

  foreach (audio_get_tags_allowed() as $tag) {
    $tables['audio_metadata_'. $tag] = array(
      'name' => 'audio_metadata',
      'join' => array(
        'left' => array(
          'table' => 'audio',
          'field' => 'vid'
        ),
        'right' => array(
          'field' => 'vid'
        ),
        'extra' => array(
          'tag' => $tag
        ),
      ),
      'fields' => array(
        'value' => array(
          'name' => t('Audio: Tag %tag', array('%tag' => $tag)),
          'sortable' => TRUE,
          'help' => "This will display tag $tag values.",
        ),
      ),
      'filters' => array(
        'clean' => array(
          'name' => t('Audio: Tag %tag', array('%tag' => $tag)),
          'tag' => $tag,
          'operator' => array('=' => 'Equals'),
          'list' => 'audio_views_handler_filter_tags',
          'list-type' => 'list',
          'operator' => 'views_handler_operator_or',
          'value-type' => 'array',
          'help' => t('Filter by whether or not the audio is downloadable. '),
        ),
      ),
    );
  }

  return $tables;
}

// TODO: profile this code and see if it can be optimized.
function audio_views_handler_field_player($fieldinfo, $fielddata, $value, $data) {
  $node = node_load($data->nid);
  return audio_get_player($node);
}

// TODO: profile this code and see if it can be optimized.
function audio_views_handler_field_download($fieldinfo, $fielddata, $value, $data) {
  $node = node_load($data->nid);
  if ($node->url_download) {
    return l(t('download audio file'), $node->url_download, NULL);
  }
}

/**
 *
 */
function audio_views_handler_filter_tags($op, $field) {
  $tags = array();
  $result = db_query(db_rewrite_sql("SELECT a.value, a.clean FROM {node} n INNER JOIN {audio_metadata} a ON n.vid = a.vid WHERE a.tag = '%s' ORDER BY a.value ASC"), $field['tag']);
  while ($obj = db_fetch_object($result)) {
    $tags[$obj->clean] = $obj->value;
  }
  return $tags;
}
