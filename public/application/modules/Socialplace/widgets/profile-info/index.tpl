<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<style>
#map_canvas{
	width: 100%;
	height: 400px;
	margin-top: 20px;
}
</style>
<h3><?php echo $this->place->title;?></h3>

<?php if ($this->place->address):?>
    <h4><?php echo $this->translate("Address");?></h4>
    <div><?php echo $this->place->address;?></div>
    <?php if ($this->place -> latitude && $this->place -> longitude):?>
    <?php echo $this->htmlLink(
        array('route' => 'socialplace_specific', 'action' => 'direction', 'place_id' => $this->place->getIdentity()),
        $this->translate('Get Direction'),
        array('class' => 'buttonlink socialplace-place-item-direction')) ?>
    <?php endif;?>
    <br />
<?php endif;?>

<?php if(!empty($this->place->phone)) :?>
    <h4><?php echo $this->translate("Phone");?></h4>
    <div><?php echo implode(', ', $this->place->phone) ;?></div>
    <br />
<?php endif; ?>

<?php
$currency = Engine_Api::_()->getApi('settings', 'core')->getSetting('socialplace.currency', 'USD');
$currency = ($currency == 'USD') ? '$' : 'đ';
?>

<h4><?php echo $this->translate("Min Price");?></h4>
<div><?php echo number_format($this->place->price) . $currency; ?></div>
<br />

<h4><?php echo $this->translate("Description");?></h4>
<div><?php echo $this->place->body;?></div>
<br />


<?php if ($this->place->location || $this->place->address):?>
<h4><?php echo $this -> translate('Place Location'); ?> </h4>
	<div><?php echo $this->place->address;?></div>
    <?php echo $this->htmlLink(
    array('route' => 'socialplace_specific', 'action' => 'direction', 'place_id' => $this->place->getIdentity()),
    $this->translate('Get Direction'),
    array('class' => 'buttonlink socialplace-place-item-direction'))
    ?>

	<?php if ($this->place->latitude && $this->place->longitude):?>
		<div id="map_canvas"></div>
		<script>
			function initialize() {
				var map_canvas = document.getElementById('map_canvas');
				var placeLatlng = new google.maps.LatLng(<?php echo $this->place->latitude;?>, <?php echo $this->place->longitude;?>);
				var map_options = {
					center: placeLatlng,
					zoom:16,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				}
				var map = new google.maps.Map(map_canvas, map_options)
				var marker = new google.maps.Marker({
				      position: placeLatlng,
				      map: map,
				      title: '<?php echo $this->place->location;?>'
				});
			}
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>
	<?php endif;?>
<?php endif;?>

