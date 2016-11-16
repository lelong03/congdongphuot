<?php  if (empty($this->weather['information'])) : ?>
  <div class="weather_city">
    <?php if ($this->can_edit_location) : ?>
      <a href="javascript://" onclick="show_edit_location_box(this);" class="edit_location_data_btn" title="<?php echo $this->translate('weather_edit location'); ?>"></a>
    <?php endif; ?>
    <?php echo ($this->weather['location']) ?  $this->weather['location'] : $this->translate('weather_No location'); ?>
  </div>
  <div class="weather_forecast_body"><?php echo $this->translate('weather_No data found'); ?></div>

<?php else : ?>

  <div class="weather_city">
    <?php if ($this->can_edit_location) : ?>
      <a href="javascript://" onclick="show_edit_location_box(this);" class="edit_location_data_btn" title="<?php echo $this->translate('weather_edit location'); ?>"></a>
    <?php endif; ?>
    <?php echo $this->weather['information']['city']; ?>
  </div>






<div class="yhweather-today-temp">
    <div class="yhweather-today-temp-left">
        <img src="application/modules/Yhweather/externals/images/yahoo_code/<?php echo strtolower(str_replace(array(' ', '/'), '_', $this->weather['current']['code']));?>.gif" alt="weather"/>
    </div>
    <div class="yhweather-today-temp-middle">
        <?php echo $this->translate(strtolower($this->weather['current']['text'])) ?>
    </div>
    <div class="yhweather-today-temp-right">
        <?php
                    $weather=0; $unit_system = ($this->unit_system == 'us') ? $this->translate('yhweather_F') : $this->translate('yhweather_C');
        $weather = $this->weather['current']['temp'];
        ?>
        <b><?php echo $weather; ?>&deg; <?php echo $unit_system; ?></b>
    </div>
</div>

<?php
              $wind_direction = $this->translate($this->weather['current']['wind_direction']);
$wind_speed = $this->weather['current']['wind_speed'];
if( !$wind_speed or $wind_speed < 0 ) {
$wind_speed = 0;
}
$unit_speed = ($this->unit_system == 'us') ? 'mph' : 'm/s';
$wind_condition = $this->translate('Wind: %1$s at %2$s ' . $unit_speed, $wind_direction, $wind_speed);
$humidity = $this->translate('Humidity: ') . $this->weather['current']['humidity'] . '%';

?>

<div class="yhweather-today-wind">
    <?php echo $wind_condition ?>
</div>
<div class="yhweather-today-huminity">
    <?php echo ($wind_condition) ? $humidity : ''; ?>
</div>

<div style="clear: both; width: 100%;"></div>










  <div class="weather_forecast_weather">
    <div class="weather_forecast_title"><?php echo $this->translate("yhweather_Forecast"); ?></div>

    <?php foreach ($this->weather['forecast_list'] as $forecast) : ?>
<?php
$forecast_condition = str_replace(array('AM ', 'PM '), '', $forecast['text']);

if(strpos($forecast_condition, '/')){
  $i = 0;
  $conditions = explode('/', $forecast_condition);
  foreach($conditions as $condition) {
    $forecast_condition = ($i > 0) ? $forecast_condition . '/' . $this->translate(strtolower($condition)) : '' . $this->translate(strtolower($condition));
    $i++;
  }
} else {
   $forecast_condition = $this->translate( $forecast_condition == 'Clear' ? 'YHWEATHER_' . strtolower($forecast_condition) : strtolower($forecast_condition) );
}
?>
    <div class="weather_forecast_body">
      <div class="weather_icon float_right_rtl"><img src="application/modules/Yhweather/externals/images/yahoo_code/<?php echo $forecast['code'];?>.gif" alt="weather" title="<?php echo $forecast_condition;?>"/></div>
      <div class="condition float_right_rtl">
        <div class="day_of_week"><?php echo $this->translate('YHWEATHER_' . $forecast['day']) ?></div>
        <div style="display:block">
          <?php
            $high = $forecast['high'];
            $low = $forecast['low'];
          ?>
          <?php echo $low; ?>&deg;<?php echo $unit_system; ?> | <?php echo $high; ?>&deg;<?php echo $unit_system; ?>
        </div>
        <div>
    <?php
      echo $forecast_condition;
    ?>
        </div>
        <div class="clr"></div>
      </div>
      <div class="clr"></div>
    </div>
    <?php endforeach ?>
  </div>

<?php endif; ?>