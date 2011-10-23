<?
  date_default_timezone_set("America/New_York");

  function day_index($day_of_week, $hours) {
    return array_search($day_of_week, array_keys($hours));
  }

  function day_name($day_index, $hours) {
    $day_names = array_keys($hours);
    return $day_names[$day_index];
  }

  function hours_list_class($day_of_week, $hours) {
    return (day_index($day_of_week, $hours) % 2 == 0) ? "shade" : "";
  }

  function currently_open($time, $hours) {
    return ($time >= $hours[0]) && ($time <= $hours[1]);
  }

  function next_open($time, $current_hours, $day_of_week, $hours) {
    if ($time > $current_hours[1]) {
      $tomorrow_index = ($day_of_week + 1) % 7;
      $tomorrow_name = day_name($tomorrow_index, $hours);
      return "" . $hours[$tomorrow_name][0] . "am tomorrow";
    } else {
      return "" . $current_hours[0] . "am";
    }
  }

  $hours = array(
    "Sunday"    => array(11, 22),
    "Monday"    => array(11, 22),
    "Tuesday"   => array(11, 22),
    "Wednesday" => array(11, 22),
    "Thursday"  => array(11, 22),
    "Friday"    => array(11, 23),
    "Saturday"  => array(11, 23)
  );

  $date = getdate();
  $timestamp = $date[0];
  $time = $date["hours"] + ($date["minutes"] / 60.0);
  $day_of_week = $date["wday"];
  $day_name = day_name($day_of_week, $hours);
  $current_hours = $hours[$day_name];
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Is Francesca's Open?</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div id="container">
    <header>
      <strong>Francesca&rsquo;s Dessert Caffe</strong> in Durham, NC
      <div id="current-time"><?= date("M d, g:ia", $timestamp) ?></id>
    </header>

    <div id="primary">
      <h1>Is Francesca&rsquo;s open?</h1>
      <? if (currently_open($time, $current_hours)): ?>
        <h2>Yes,</h2>
        <h3>until <?= $current_hours[1] - 12 ?>pm.</h3>
      <? else: ?>
        <h2>No,</h2>
        <h3>not until <?= next_open($time, $current_hours, $day_of_week, $hours) ?>.</h3>
      <? endif; ?>
    </div>

    <div id="secondary">
      <div id="hours">
        <h4>Francesca&rsquo;s Fall Hours</h4>

        <ul>
          <? foreach ($hours as $day_of_week => $open_close): ?>
            <li class="<?= hours_list_class($day_of_week, $hours) ?>">
              <span class="day"><?= $day_of_week ?></span>
              <span class="time"><?= $open_close[0] ?>am &ndash; <?= $open_close[1] - 12 ?>pm</span>
            </li>
          <? endforeach; ?>
        </ul>
      </div>

      <div id="map">
        <iframe width="360" height="270" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?q=Francesca's+Durham+NC&amp;hl=en&amp;sll=37.0625,-95.677068&amp;sspn=37.462243,75.498047&amp;vpsrc=6&amp;hq=Francesca's&amp;hnear=Durham,+North+Carolina&amp;t=m&amp;ie=UTF8&amp;ll=36.008006,-78.921962&amp;spn=0.009373,0.015407&amp;z=15&amp;output=embed"></iframe>

        <p>
          <h4>Francesca&rsquo;s Dessert Caffe</h4>
          <a href="http://maps.google.com/maps?q=Francesca's+Durham+NC&hl=en&ll=36.007729,-78.921543&spn=0.004678,0.009216&sll=37.0625,-95.677068&sspn=37.462243,75.498047&vpsrc=6&hq=Francesca's&hnear=Durham,+North+Carolina&t=m&z=17">
            706B 9th St<br />
            Durham, NC 27705
          </a><br />
          <a href="tel:+1-919-286-4177">(919) 286-4177</a>
        </p>
      </div>
    </div>

    <footer>
      <p>This website was created by <a href="mailto:david.eisinger@gmail.com">David Eisinger</a>, who likes Francesca&rsquo;s but is otherwise in no way affiliated with it.</p>
    </footer>
  </div>
</body>
</html>
