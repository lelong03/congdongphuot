<script type="text/javascript" ">
var snowOptions =  <?php echo Zend_Json::encode($this->snowOptions); ?>
</script>
<script type="text/javascript" src="<?php echo $this->layout()->staticBaseUrl ?>application/modules/ChristmasSnow/externals/scripts/snowfall.js"></script>
<?php
if($this->snowOptions['song'] && $this->snowOptions['play']):
?>
<embed type="application/x-shockwave-flash" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" flashvars="audioUrl=<?php echo $this->snowOptions['song'];?>&autoPlay=true" width="1" height="1" quality="best"></embed>
<?php endif;?>