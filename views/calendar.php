<?php defined('SYSPATH') OR die('No direct access allowed.');

// Get the day names
$days = Calendar::days(2);

$today = date('d');
$current_month = date('m');

// Previous and next month timestamps
$next = mktime(0, 0, 0, $month + 1, 1, $year);
$prev = mktime(0, 0, 0, $month - 1, 1, $year);

// Import the GET query array locally and remove the day
$qs = $_GET;
unset($qs['day']);

// Previous and next month query URIs
$path_info = Arr::get($_SERVER, 'PATH_INFO');
$prev = $path_info.URL::query(array_merge($qs, array('month' => date('n', $prev), 'year' => date('Y', $prev))));
$next = $path_info.URL::query(array_merge($qs, array('month' => date('n', $next), 'year' => date('Y', $next))));

// Maintain a Month Offset to find out the actual month in cas e of padding days
// Initially assume prev month so -1
// increment by 1 everytime day = 1
// Actual month = $month + $month_offset
$month_offset = -1;

?>
<table class="calendar">
	<caption>
		<span class="prev"><?php echo html::anchor($prev, '&laquo;') ?></span>
		<span class="title"><?php echo strftime('%Y %B', mktime(0, 0, 0, $month, 1, $year)) ?></span>
		<span class="next"><?php echo html::anchor($next, '&raquo;') ?></span>
	</caption>
	<thead>
		<tr>
			<?php foreach ($days as $weekday_name): ?>
			<th><?php echo $weekday_name ?></th>
			<?php endforeach ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($weeks as $week): ?>
		<tr>
			<?php foreach ($week as $key => $day):
				list($number, $current, $data) = $day;
                                if ($number === 1)
                                {
                                    $month_offset++;
                                }
				$output = NULL;
				$classes = array();
				if (is_array($data))
				{
					$classes = $data['classes'];
					if ( ! empty($data['output']))
					{
						$output = '<div class="output"><ul><li class="calendar_event">'.implode('</li><li>', $data['output']).'</li></ul></div>';
						$classes[] = 'event';
					}
				}

				if($current_month == $month AND $today == $day[0] AND $current)
					$classes[] = 'today';
			?>
			<td id="<?php echo implode('-', array('date',$year,($month+$month_offset),$day[0])); ?>" class="<?php echo implode(' ', $classes) ?>">
				<span class="day"><?php echo $day[0] ?></span>
				<?php echo $output ?>
			</td>
			<?php endforeach ?>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>