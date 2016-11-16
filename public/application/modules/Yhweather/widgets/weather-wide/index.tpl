<style>
    .weather_forecast_body .condition {
        float: left;
        width: 180px;
    }
    .float_right_rtl > div
    {
        margin-top: 7px;
    }
</style>

<?php
  $widget_uniq_key = uniqid('weather_');
?>

<script type="text/javascript">
  var edit_weather_location_url = '<?php echo $this->url(array('module' => 'yhweather', 'controller' => 'index', 'action' => 'edit-location'), 'default'); ?>';

  function show_edit_location_box(node)
  {
    node.blur();

    var $container = $(node).getParent('.weather_cont');
    Smoothbox.open($container.getElement('.weather_edit_location_box'), {mode: 'Inline', width: 350, height: 40});
  }

  function edit_weather_location(node, widget_key)
  {
    var $form = $(node).getParent('.weather_edit_location_box');
    var $weather_box = $('weather_' + widget_key).getElement('.weather_box');
    var $loading_box = $('weather_' + widget_key).getElement('.weather_loading');
    var $location_input = $('weather_' + widget_key).getElement('.weather_location_input');

    var location = $form.getElement('.weather_location_input').value;
    var object_type = $form.getElement('input[name="object_type"]').value;
    var object_id = $form.getElement('input[name="object_id"]').value;

    $weather_box.addClass('display_none');
    $loading_box.removeClass('display_none');

    en4.core.request.send(new Request.JSON({
      url: edit_weather_location_url,
      data: {format: 'json', location: location, object_type: object_type, object_id:object_id},
      onSuccess: function(response){
        Smoothbox.close();

        if (response && response.error) {
          he_show_message(response.message, 'error');
        } else {
          $weather_box.set('html', response.html);
          $location_input.value = response.weather.location;
        }

        $weather_box.removeClass('display_none');
        $loading_box.addClass('display_none');
      }
    }));
  };
</script>

<div class="weather_cont" id="weather_<?php echo $widget_uniq_key; ?>">

  <div class="weather_box">
      <?php  if (empty($this->weather['information'])) : ?>
          <div class="weather_city">
              <?php if ($this->can_edit_location) : ?>
              <a href="javascript://" onclick="show_edit_location_box(this);" class="edit_location_data_btn" title="<?php echo $this->translate('yhweather_edit location'); ?>"></a>
              <?php endif; ?>
              <?php echo ($this->weather['location']) ?  $this->weather['location'] : $this->translate('yhweather_No location'); ?>
          </div>
          <div class="weather_forecast_body"><?php echo $this->translate('yhweather_No data found'); ?></div>
      <?php else : ?>

      <div class="weather_city">
          <?php if ($this->can_edit_location) : ?>
          <a href="javascript://" onclick="show_edit_location_box(this);" class="edit_location_data_btn" title="<?php echo $this->translate('yhweather_edit location'); ?>"></a>
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
                  <div><strong>
                      <?php echo $forecast_condition;?>
                      </strong>
                  </div>
                  <div class="clr"></div>
              </div>
              <div class="clr"></div>
          </div>
          <?php endforeach ?>
      </div>

      <?php endif; ?>



  </div>

  <div class="weather_loading display_none"></div>

  <div class="display_none">
    <div class="weather_edit_location_box">
      <div class="weather_edit_location_desc"><?php echo $this->translate("YHWEATHER_EDIT_LOCATION_DESC"); ?></div>
      <div class="weather_edit_location_desc">
        <input name="weather_location" class="text weather_location_input" value="<?php echo $this->weather['location'] ?>"/>
        <input type="hidden" name="object_type" value="<?php echo $this->object_type; ?>"/>
        <input type="hidden" name="object_id" value="<?php echo $this->object_id; ?>"/>
      </div>

      <button type="submit" name="submit" onclick="edit_weather_location(this, '<?php echo $widget_uniq_key; ?>');"><?php echo $this->translate('Save'); ?></button>&nbsp;
      <button type="submit" name="submit" onclick="Smoothbox.close();"><?php echo $this->translate('Cancel'); ?></button>
    </div>
  </div>

</div>