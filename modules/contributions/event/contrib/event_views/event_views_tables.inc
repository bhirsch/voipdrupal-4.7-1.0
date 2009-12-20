<?php
// $Id: event_views_tables.inc,v 1.1.2.6 2006/08/15 21:00:56 karens Exp $
// this information is seldom used since it is cached when views are created
// might as well keep the size of the actively-used module as small as possible
// by separating these functions out into their own file

/**
 *  Implementation of hook_views_tables()
 *  Expose event fields and filters to the views module
 */
function _event_views_views_tables() {

  // create an option list of event content types
  $event_node_types = array_merge(event_get_types('all'), event_get_types('solo'));
  $type_options = array();
  foreach ($event_node_types as $type) {
    $type_options[$type] = node_get_name($type);
  }

  // use this to default to current time
  $current = array('***CURRENT_TIME***' => t('now'));

  // limit years to years that have events
  $years   = ($current + drupal_map_assoc(range(intval(date("Y", variable_get('event_range_prev', time()))), intval(date("Y", variable_get('event_range_next',time()))))));
  $months  = ($current + drupal_map_assoc(range(1, 12), 'map_month'));
  $days    = ($current + drupal_map_assoc(range(1, 31)));
    
  $tables['event'] = array(
    'name' => 'event', 
    'join' => array(
      'left' => array(
        'table' => 'node',
        'field' => 'nid'
      ), 
      'right' => array(
        'field' => 'nid'
      ), 
    ),
    'fields' => array(
      'event_start' => array(
        'name' => t('Event: Start Time'), 
        'sortable' => true,
        'handler' => views_handler_field_dates(),
        ),
      'event_end' => array(
        'name' => t('Event: End Time'),
        'sortable' => true,
        'handler' => views_handler_field_dates(),
        ),
      'timezone' => array(
        'name' => t('Event: Timezone'),
        'handler' => 'event_timezone_display_handler',
        'query_handler' => 'event_views_query_handler',
        'sortable' => true,
      ),
    ),
    'sorts' => array(
      'event_start' => array('name' => t('Event: Start Time')),
      'event_end' => array('name' => t('Event: End Time')),
    ),
    'filters' => array(
      'event_start' => array(
        'field' => 'event_start',
        'name' => t('Event: Start Date'),
        'operator' => 'views_handler_operator_gtlt',
        'value' => views_handler_filter_date_value_form(),
        'option' => 'string',
        'handler' => 'event_views_handler_filter_timestamp',
        'help' => t('This filter allows events to be filtered by their start date. Enter dates in the format: CCYY-MM-DD HH:MM:SS. Enter \'now\' to use the current time. You may enter a delta (in seconds) to the option that will be added to the time; this is most useful when combined with now. If you have the jscalendar module from jstools installed, you can use a popup date picker here.'),
      ),
      'event_end' => array(
        'field' => 'event_end',
        'name' => t('Event: End Date'),
        'operator' => 'views_handler_operator_gtlt',
        'value' => views_handler_filter_date_value_form(),
        'option' => 'string',
        'handler' => 'event_views_handler_filter_timestamp',
        'help' => t('This filter allows events to be filtered by their end date. Enter dates in the format: CCYY-MM-DD HH:MM:SS. Enter \'now\' to use the current time. You may enter a delta (in seconds) to the option that will be added to the time; this is most useful when combined with now. If you have the jscalendar module from jstools installed, you can use a popup date picker here.'),
      ),
      'year' => array(
        'field' => 'event_start',
        'name' => t('Event: Start Year'),
        'operator' => 'views_handler_operator_gtlt',
        'list' => $years,
        'list-type' => 'select',
        'handler' => 'event_views_handler_filter_ymd',
        'option' => 'event_views_calendar_form',
        'type' => 'YEAR',
        'help' => t('Filter by year. Use the option to select the date field to filter on.'),
      ),
      'month' => array(
        'field' => 'event_start',
        'name' => t('Event: Start Month'),
        'operator' => 'views_handler_operator_gtlt',
        'list' => $months,
        'list-type' => 'select',
        'handler' => 'event_views_handler_filter_ymd',
        'option' => 'event_views_calendar_form',
        'type' => 'MONTH',
        'help' => t('Filter by month. Use the option to select the date field to filter on.'),
      ),
      'day' => array(
        'field' => 'event_start',
        'name' => t('Event: Start Day'),
        'operator' => 'views_handler_operator_gtlt',
        'list' => $days,
        'list-type' => 'select',
        'handler' => 'event_views_handler_filter_ymd',
        'option' => 'event_views_calendar_form',
        'type' => 'DAYOFMONTH',
        'help' => t('Filter by day. Use the option to select the date field to filter on.'),
      ),
    ),
  );
  
  // add a pseudo table to set up additional fields and filters for node table
  $tables['event_views'] = array(
    'name' => 'node', 
    'join' => array(
      'left' => array(
        'table' => 'node',
        'field' => 'nid'
      ), 
      'right' => array(
        'field' => 'nid'
      ), 
    ),
    // add a pseudo fields to set up calendar start and end psuedo dates
    'fields' => array(
      'calendar_start' => array(
        'name' => t('Calendar: Start Time'), 
        'notafield' => true,
        'sortable' => true,
        'option' => 'event_views_calendar_form',
        'handler' => views_handler_field_dates(),
        'query_handler' => 'event_views_calendar_query_handler',
        'help' => t('A field to serve as the start time for this record in a calendar view. Use the option to select the date field use.'),
        ),
      'calendar_end' => array(
        'name' => t('Calendar: End Time'),
        'notafield' => true,
        'sortable' => true,
        'option' => 'event_views_calendar_form',
        'handler' => views_handler_field_dates(),
        'query_handler' => 'event_views_calendar_query_handler',
        'help' => t('A field to serve as the end time for this record in a calendar view. Use the option to select the date field to use.'),
        ),
    ),
   // here's a filter that is limited to event content types to be used for exposed filters that should not contain other values
   'filters' => array(
      'event_type' => array(
        'field' => 'type',
        'name' => t('Event: Type'),
        'list' => $type_options,
        'list-type' => 'list',
        'operator' => 'views_handler_operator_or',
        'value-type' => 'array',
        'help' => t('A node type selector that is limited to event-enabled node types. Use as exposed filter that only contains event node types.'),
        ),
      ),
    );

   return $tables;
}

/**
 *  Implementation of hook_views_arguments()
 */
function _event_views_views_arguments() {
  $arguments = array(
    'event_year' => array(
      'name' => t('Event: Start Year'),
      'handler' => 'event_views_handler_arg_year',
      'option' => 'event_views_calendar_form',
      'help' => t('Filter by the event year (YYYY). Use the option to select the date field to filter on.'),
    ),
    'event_month' => array(
      'name' => t('Event: Start Month'),
      'handler' => 'event_views_handler_arg_month',
      'option' => 'event_views_calendar_form',
      'help' => t("Filter by the event month (1-12). Place this argument after a 'Year' argument. Use the option to select the date field to filter on."),
    ),
    'event_day' => array(
      'name' => t('Event: Start Day'),
      'handler' => 'event_views_handler_arg_day',
      'option' => 'event_views_calendar_form',
      'help' => t("Filter by the event day (1-31). Place this argument after a 'Year' and a 'Month' argument. Use the option to select the date field to filter on."),
    ),
    'event_week' => array(
      'name' => t('Event: Start Week'),
      'handler' => 'event_views_handler_arg_week',
      'option' => 'event_views_calendar_form',
      'help' => t("Filter by the week number (1-52). Place this argument after a 'Year' argument. Use the option to select the date field to filter on."),
    ),
  );
  return $arguments;
}

/**
 *  Implementation of hook_views_default_views()
 *   Create default event views
 */
function _event_views_views_default_views() {
  
  // avoid miscellaneous problems by forcing the cache to clear before creating a default view
  views_invalidate_cache();

  $event_node_types = array_merge(event_get_types('all'), event_get_types('solo'));
  
  $view = new stdClass();
  $view->name = t('event_select');
  $view->description = t('Events list filtered by drop-down date selector.');
  $view->disabled = TRUE;
  $view->access = array (
    );
  $view->view_args_php = '';
  $view->page = TRUE;
  $view->page_title = t('event list');
  $view->page_header = '';
  $view->page_header_format = '1';
  $view->page_footer = '';
  $view->page_footer_format = '1';
  $view->page_empty = '';
  $view->page_empty_format = '1';
  $view->page_type = 'table';
  $view->url = 'event/select';
  $view->use_pager = TRUE;
  $view->nodes_per_page = '10';
  $view->menu = FALSE;
  $view->menu_title = '';
  $view->menu_tab = FALSE;
  $view->menu_tab_default = FALSE;
  $view->menu_weight = '';
  $view->sort = array (
    );
  $view->argument = array (
    );
  $view->field = array (
    array (
      'tablename' => 'node',
      'field' => 'title',
      'label' => t('Title'),
      'handler' => 'views_handler_field_nodelink',
      'sortable' => '1',
    ),
    array (
      'tablename' => 'event',
      'field' => 'event_start',
      'label' => t('Start Time:'),
      'handler' => 'views_handler_field_date_small',
      'sortable' => '1',
      'defaultsort' => 'ASC',
    ),
    array (
      'tablename' => 'event',
      'field' => 'event_end',
      'label' => t('End Time:'),
      'handler' => 'views_handler_field_date_small',
      'sortable' => '1',
      'defaultsort' => 'ASC',
    ),
  );
  $view->filter = array (
    array (
      'tablename' => 'node',
      'field' => 'status',
      'operator' => '=',
      'options' => '',
      'value' => '1',
      ),
    array (
      'tablename' => 'node',
      'field' => 'type',
      'operator' => 'OR',
      'options' => '',
      'value' => $event_node_types,
      ),
   array (
      'tablename' => 'event',
      'field' => 'year',
      'operator' => '=',
      'options' => '',
      'value' => '***CURRENT_TIME***',
    ),
    array (
      'tablename' => 'event',
      'field' => 'month',
      'operator' => '>=',
      'options' => '',
      'value' => '***CURRENT_TIME***',
    ),
    array (
      'tablename' => 'event',
      'field' => 'day',
      'operator' => '>=',
      'options' => '',
      'value' => '1',
    ),
 
   );
  $view->exposed_filter = array (
     array (
      'tablename' => 'event',
      'field' => 'year',
      'label' => t('Start Year:'),
      'optional' => 0,
      'is_default' => 0,
      'operator' => 0,
      'single' => 0,
    ),
    array (
      'tablename' => 'event',
      'field' => 'month',
      'label' => t('Start Month:'),
      'optional' => 0,
      'is_default' => 0,
      'operator' => 0,
      'single' => 0,
    ),
     array (
      'tablename' => 'event',
      'field' => 'day',
      'label' => t('Start Day:'),
      'optional' => 0,
      'is_default' => 0,
      'operator' => 0,
      'single' => 0,
    ),
  );
  $view->requires = array(node, event);
  $views[$view->name] = $view;

  $view = new stdClass();
  $view->name = t('event_js');
  $view->description = t('Events list filtered by js date selector.');
  $view->disabled = TRUE;
  $view->access = array (
    );
  $view->view_args_php = '';
  $view->page = TRUE;
  $view->page_title = t('event list');;
  $view->page_header = '';
  $view->page_header_format = '1';
  $view->page_footer = '';
  $view->page_footer_format = '1';
  $view->page_empty = '';
  $view->page_empty_format = '1';
  $view->page_type = 'table';
  $view->url = 'event/selector';
  $view->use_pager = TRUE;
  $view->nodes_per_page = '10';
  $view->menu = FALSE;
  $view->menu_title = '';
  $view->menu_tab = FALSE;
  $view->menu_tab_default = FALSE;
  $view->menu_weight = '';
  $view->sort = array (
  );
  $view->argument = array (
  );
  $view->field = array (
    array (
    'tablename' => 'node',
    'field' => 'title',
    'label' => t('Title'),
    'handler' => 'views_handler_field_nodelink',
    'sortable' => '1',
    ),
    array (
    'tablename' => 'event',
    'field' => 'event_start',
    'label' => t('Start Time:'),
    'handler' => 'views_handler_field_date_small',
    'sortable' => '1',
    'defaultsort' => 'ASC',
    ),
    array (
    'tablename' => 'event',
    'field' => 'event_end',
    'label' => t('End Time:'),
    'handler' => 'views_handler_field_date_small',
    'sortable' => '1',
    'defaultsort' => 'ASC',
    ),
  );
  $view->filter = array (
    array (
    'tablename' => 'node',
    'field' => 'status',
    'operator' => '=',
    'options' => '',
    'value' => '1',
    ),
    array (
    'tablename' => 'node',
    'field' => 'type',
    'operator' => 'OR',
    'options' => '',
    'value' => $event_node_types,
    ),
    array (
    'tablename' => 'event',
    'field' => 'event_start',
    'operator' => '>',
    'options' => '',
    'value' => 'now',
    ),
    array (
    'tablename' => 'event',
    'field' => 'event_end',
    'operator' => '>',
    'options' => '',
    'value' => 'now',
    ),
  );
  $view->exposed_filter = array (
  array (
    'tablename' => 'event',
    'field' => 'event_start',
    'label' => t('Start Date'),
    'optional' => 0,
    'is_default' => 0,
    'operator' => 0,
    'single' => 0,
  ),
  array (
    'tablename' => 'event',
    'field' => 'event_end',
    'label' => t('End Date'),
    'optional' => 0,
    'is_default' => 0,
    'operator' => 0,
    'single' => 0,
  ),
  );

  $view->requires = array(node, event);
  $views[$view->name] = $view;


  $view = new stdClass();
  $view->name = t('event_date');
  $view->description = t('Events list filtered by url arguments.');
  $view->disabled = TRUE;
  $view->access = array (
    );
  $view->view_args_php = '';
  $view->page = TRUE;
  $view->page_title = t('event list');;
  $view->page_header = '';
  $view->page_header_format = '1';
  $view->page_footer = '';
  $view->page_footer_format = '1';
  $view->page_empty = '';
  $view->page_empty_format = '1';
  $view->page_type = 'table';
  $view->url = 'event/date';
  $view->use_pager = TRUE;
  $view->nodes_per_page = '10';
  $view->menu = FALSE;
  $view->menu_title = '';
  $view->menu_tab = FALSE;
  $view->menu_tab_default = FALSE;
  $view->menu_weight = '';
  $view->sort = array (
    );
  $view->argument = array (
    );
  $view->field = array (
   array (
      'tablename' => 'node',
      'field' => 'title',
      'label' => t('Title'),
      'handler' => 'views_handler_field_nodelink',
      'sortable' => '1',
    ),
     array (
      'tablename' => 'event',
      'field' => 'event_start',
      'label' => t('Start Time:'),
      'handler' => 'views_handler_field_date_small',
      'sortable' => '1',
      'defaultsort' => 'ASC',
    ),
    array (
      'tablename' => 'event',
      'field' => 'event_end',
      'label' => t('End Time:'),
      'handler' => 'views_handler_field_date_small',
      'sortable' => '1',
    ),
  );
  $view->filter = array (
    array (
      'tablename' => 'node',
      'field' => 'status',
      'operator' => '=',
      'options' => '',
      'value' => '1',
      ),
    array (
      'tablename' => 'node',
      'field' => 'type',
      'operator' => 'OR',
      'options' => '',
      'value' => $event_node_types,
      ),
  );
  $view->exposed_filter = array ();
  $view->argument = array (
    array (
      'type' => 'event_year',
      'argdefault' => '6',
      'title' => t('Year'),
      'options' => '',
    ),
    array (
      'type' => 'event_month',
      'argdefault' => '6',
      'title' => t('Month'),
      'options' => '',
    ),
    array (
      'type' => 'event_day',
      'argdefault' => '6',
      'title' => t('Day'),
      'options' => '',
    ),
  );
  $view->requires = array(node, event);
  $views[$view->name] = $view;
  
  $view = new stdClass();
  $view->name = 'event_calendar';
  $view->description = t('Monthly calendar view of events, filtered by url arguments');
  $view->disabled = TRUE;
  $view->access = array ();
  $view->view_args_php = '';
  $view->page = TRUE;
  $view->page_title = t('Calendar');
  $view->page_header = '';
  $view->page_header_format = '1';
  $view->page_footer = '';
  $view->page_footer_format = '1';
  $view->page_empty = '';
  $view->page_empty_format = '1';
  $view->page_type = 'month';
  $view->url = 'event/calendar';
  $view->use_pager = TRUE;
  $view->nodes_per_page = '99';
  $view->sort = array (
  );
  $view->argument = array (
    array (
      'type' => 'event_year',
      'argdefault' => '6',
      'title' => t('Year'),
      'options' => '',
    ),
    array (
      'type' => 'event_month',
      'argdefault' => '6',
      'title' => t('Month'),
      'options' => '',
    ),
  );
  $view->field = array (
    array (
      'tablename' => 'node',
      'field' => 'title',
      'label' => t('Title:'),
      'handler' => 'views_handler_field_nodelink',
    ),
    array (
      'tablename' => 'event',
      'field' => 'event_start',
      'label' => t('Start:'),
      'handler' => 'views_handler_field_date_small',
    ),
    array (
      'tablename' => 'event',
      'field' => 'event_end',
      'label' => t('End:'),
      'handler' => 'views_handler_field_date_small',
    ),
  );
  $view->filter = array (
    array (
      'tablename' => 'node',
      'field' => 'status',
      'operator' => '=',
      'options' => '',
      'value' => '1',
    ),
    array (
      'tablename' => 'event_views',
      'field' => 'event_type',
      'operator' => 'OR',
      'options' => '',
      'value' => $event_node_types,
    ),
    array (
      'tablename' => 'term_node',
      'field' => 'tid',
      'operator' => 'OR',
      'options' => '',
      'value' => array (
),
    ),
  );
  $view->exposed_filter = array (
    array (
      'tablename' => 'event_views',
      'field' => 'event_type',
      'label' => t('Type'),
      'optional' => 1,
      'is_default' => 0,
      'operator' => 1,
      'single' => 1,
    ),
    array (
      'tablename' => 'term_node',
      'field' => 'tid',
      'label' => t('Category'),
      'optional' => 1,
      'is_default' => 0,
      'operator' => 1,
      'single' => 1,
    ),
  );
  $view->requires = array(node, event, event_views, term_node);
  $views[$view->name] = $view;

  return $views;

}


