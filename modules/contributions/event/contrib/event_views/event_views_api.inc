<?php
// $Id: event_views_api.inc,v 1.1.2.1 2006/06/23 18:02:59 karens Exp $
/**
 * Returns a calendar in the requested format, populated with the provided nodes.
 * This is not used internally, rather it is an API funciton for external modules
 * to use for rendering calendars when constructing thier own event objects.
 *
 * @ingroup event_view
 *
 * @param $view - The format of calendar to return. Possible values:
 *                "table": A tabular calendar.
 *                "month": A month calendar.
 *                "week": A week calendar.
 *                "day": A day calendar.
 *  @param $nodes – An associative array of nodes with nids for key values.
 *           Node objects must have GMT timestamp values for start ($node->event_start).
 *           Optionally, an end value ($node->event_end) and a time zone offset value
 *           in the same format as drupal core ($node->tz). If a node has no end
 *           value, it is rendered on only one day. If no time zone value is displayed
 *           the time is rendered with no time zone offset (GMT).
 *  @param $module - String containing the name of the module calling the function
 *  @param $title - A string value that will be printed into the header of the calendar
 *  @param $params - an optional array of additional values that may be needed
 *           $params[force_week]  - a week number to limit the displayed calendar to only that week
 *           $params[hide_header] - true to omit td header row(s)
 *           $params[as_array]    - true to return the rows array instead of the themed table
 *  @return Themed calendar view of nodes or array of calendar rows
 */
function event_views_get_calendar($view, $nodes, $module, $title = NULL, $params = array()) {
  
  $today = _event_user_date();
  $data  = array();
  foreach ($nodes as $node) {

    $event = new stdClass();
    $node->event_links = module_invoke_all('link', 'event_node_'. $view, $node, FALSE);
    $nodes[$node->nid] = $node;
    $event->nid = $node->nid;

    // $node_start and $node_end are local timestamp values
    $node_start = gmmktime(0, 0, 0, _event_date('m', $node->event_start, $node->start_offset), _event_date('d', $node->event_start, $node->start_offset), _event_date('Y', $node->event_start, $node->start_offset));
    if ($node->event_end) {
      $node_end = gmmktime(0, 0, 0, _event_date('m', $node->event_end, $node->end_offset), _event_date('d', $node->event_end, $node->end_offset), _event_date('Y', $node->event_end, $node->end_offset));
    }
    else {
      $node_end = $node_start;
    }
    
    if ($node_start == $node_end) {
      $event->event_state = 'singleday';
      $event->stamp = $node_start;
      $data[gmdate('Y', $node_start)][gmdate('m', $node_start)][gmdate('j', $node_start)][] = $event;
    }
    else {
      // roll through each day the event occurs and set an entry for each
      for ($x = $node_start; $x <= $node_end; $x += 86400) {
        if ($x == $node_end) {
          $event->event_state = 'end';
          $event->stamp = $x;
          $data[gmdate('Y', $x)][gmdate('m', $x)][gmdate('j', $x)][] = $event;
        }
        elseif ($x == $node_start) {
          $event->event_state = 'start';
          $event->stamp = $x;
          $data[gmdate('Y', $x)][gmdate('m', $x)][gmdate('j', $x)][] = $event;
        }
        else {
          $event->event_state = 'ongoing';
          $event->stamp = $x;
          $data[gmdate('Y', $x)][gmdate('m', $x)][gmdate('j', $x)][] = $event;
        }
      }
    }
  }
  
  // order the years, months and days
  ksort($data, SORT_NUMERIC);
  foreach($data as $year => $months) {
    ksort($data[$year], SORT_NUMERIC);
    foreach($data[$year] as $month => $days) {
      ksort($data[$year][$month], SORT_NUMERIC);
    }
  }
  
  $weekdays = event_week_days();
  switch ($view) {
    case 'day':
    case 'table':
      foreach ($data as $year => $months) {
        if(count($data) > 1 && !$params['hide_header']) {
          // add year heading
          $rows[][] = array(
            'class' => 'heading year',
            'id' => 'year'.$year,
            'data' => $year);
        }
        foreach($months as $month => $days) {
          foreach($days as $day => $events) {
            $content = theme('event_calendar_date_box', $year, $month, $day, 'table');
            foreach($events as $event) {
              if(!$month_name) {
                $month_name = gmdate('M', $event->stamp);
                $dow = _event_day_of_week($event->stamp);
              }
              $node = $nodes[$event->nid];
              
              $node->event_state = $event->event_state;
              if($output = module_invoke($module, 'event_node_'. $view, $node)) {
                $content .= $output;
              }
              else {
                $content .= theme('event_node_'. $view, $node);
              }
            }
            $rows[][] = array(
              'class' => strtolower("$month_name ". $weekdays[$dow]['day'] . ($event->stamp == $today ? ' today' : '')),
              'id' => strtolower($month_name . $day),
              'data' => $content);
            $month_name = NULL;
          }
        }
      }
    break;

    case 'week':
    case 'month':
      $colspan = '7';
        foreach ($data as $year => $months) {
          if(count($data) > 1 && !$params['hide_header']) {
            // add year heading
            $rows[][] = array(
              'class' => 'heading year',
              'id' => 'year'. $year,
              'data' => $year,
              'colspan' => $colspan);
          }
          foreach ($months as $month => $days) {
            // timestamp of first day in month
            $curstamp = gmmktime(0, 0, 0, $month, 1, $year);
            // timestamp of last day in month
            $lastday = gmmktime(0, 0, 0, $month, gmdate('t', $curstamp), $year);
            // pad the first week row array to fill up days in the previous month we don't build
            $row = array_fill(0, 6, '');
            // get the day of week offset value for the first day of the month
            $start = $offset = _event_day_of_week($curstamp);
            // get name of month
            $month_name = gmdate('M', $curstamp);
            // set week counter
            $week = 0;
            if (($view == 'month' || !$params['force_week'])) {
              // add month header, skip if a single week is being displayed (the week header gets added later)
              if (!$params['hide_header']) {
                $rows[][] = array(
                  'class' => 'heading month',
                  'id' => 'month'. $month,
                  'data' => $month_name,
                  'colspan' => $colspan);
              }
              $rows[] = event_week_header();
            }

            while ($curstamp <= $lastday) {
              for ($x = $start; $x < 7; $x++) {
                $cur_day = (($week * 7) + ($x + 1) - $offset);
                $content = theme('event_calendar_date_box', $year, $month, $cur_day, $view);

                // render nodes for the day
                if(is_array($days[$cur_day])) {
                  foreach($days[$cur_day] as $event) {
                    $node = $nodes[$event->nid];
                    $node->event_state = $event->event_state;
                    if($output = module_invoke($module, 'event_node_'. $view, $node)) {
                      $content .= $output;
                    }
                    else {
                      $content .= theme('event_node_'. $view, $node);
                    }
                  }
                }

                $row[$x] = array(
                  'class' => strtolower("$month_name ". $weekdays[$x]['day'] . ($curstamp == $today ? ' today' : '')),
                  'id' => strtolower($month_name . $day),
                  'data' => $content);

                $curstamp += 86400;
                if ($curstamp > $lastday) {
                  $x = 8;
                }
              }
              if ($view == 'week' && $params['force_week'] && $params['force_week'] == date('W', $curstamp)) {
                // add week header if a single week display is desired and this is the week to display
                $cur_week = date('W', $curstamp);
                if (!$params['hide_header']) {
                  $rows[][] = array(
                    'class' => 'heading week',
                    'id' => 'week'. $cur_week,
                    'data' => t('Week ') . $cur_week,
                    'colspan' => $colspan);
                }
                $rows[] = event_week_header();
              }
              // print week unless this is a week view and force_week is set and this is not the forced week
              if (!($view == 'week' && $params['force_week'] && $params['force_week'] != date('W', $curstamp))) {
                $rows[] = array_pad($row, 7, '&nbsp;');
              }
              $week++;
              $start = 0;
              $row = array();
            }
          }
        }
      break;
  }

  // if only the rows array is requested, return it
  if ($params['as_array']) return $rows;

  $header[] = ($title ? array('class' => 'heading', 'data' => $title, 'colspan' => $colspan) : array());
  return theme('event_calendar_'. $view, 'page', $header, $rows);
}

