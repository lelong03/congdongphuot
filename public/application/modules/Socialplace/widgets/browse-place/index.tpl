<?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
<div class="socialplace-browse-listings-header clearfix">
	<div id="socialplace-mode-view" class="socialplace-mode-view">
		<?php if(in_array('list', $this -> mode_enabled)):?>
			<span class="socialplace-viewmode-list" rel="socialplace-browse-place-viewmode-list"></span>
		<?php endif;?>
		<?php if(in_array('map', $this -> mode_enabled)):?>
			<span class="socialplace-viewmode-maps" rel="socialplace-browse-place-viewmode-maps"></span>
		<?php endif;?>	
	</div>
</div>

<div id="socialplace-browse-listings">
	<ul class="socialplace-browse-place-items">
		<?php foreach($this->paginator as $place) :?>
		<li>
			<div class="socialplace-place-item socialplace-clearfix">
				<div class="socialplace-place-item-image" style="background: url(<?php echo $place->getPhotoUrl();?>);">
				</div>
				<div class="socialplace-place-item-content">
					<div class="socialplace-place-item-name">
						<a href="<?php echo $place->getHref();?>">
							<h3><?php echo $place->title;?></h3>
						</a>
					</div>
                    <div class="socialplace-review-item-rating">
                        <?php echo $this->partial('_review_rating.tpl', 'socialplace', array('rate_number' => $place -> rating));?>
                    </div>
                    <div class="socialplace_icon socialplace-place-item-location">
                        <?php echo $place->address;?>
                    </div>
                    <?php if(!empty($place->phone)) :?>
                        <div class="socialplace_icon socialplace-place-item-phone">
                            <?php echo implode(', ', $place->phone) ;?>
                        </div>
                    <?php endif; ?>
					<div class="socialplace_icon socialplace-place-item-description">
                        <?php echo $this->string()->truncate(strip_tags($place->body), 150) ?>
					</div>
                    <div class="socialplace_icon socialplace-place-item-price">
                        <strong><?php echo number_format($place -> price); ?><?php echo $this -> c; ?></strong>
                         - <?php echo $this->translate(array("%s like", "%s likes", $place->like_count), $place->like_count); ?>
                         - <?php echo $this->translate(array("%s view", "%s views", $place->view_count), $place->view_count); ?>
                         - <?php echo $this->translate(array("%s comment", "%s comments", $place->comment_count), $place->comment_count); ?>
                    </div>
				</div>
			</div>
		</li>
		<?php endforeach;?>
	</ul>
	<div id="socialplace-browse-place-maps" class="socialplace-browse-place-maps">
		<iframe id='map-view-iframe' style="max-height: 500px;"></iframe>
	</div>
</div>
<?php else: ?>
    <div class="tip">
		<span>
			<?php echo $this->translate('There are no places found yet.') ?>
		</span>
    </div>
<?php endif; ?>

<div id='paginator'>
	<?php if( $this->paginator->count() > 1 ): ?>
	     <?php echo $this->paginationControl($this->paginator, null, null, array(
	            'pageAsQuery' => true,
	            'query' => $this->formValues,
	          )); ?>
	<?php endif; ?>
</div>


<script type="text/javascript">
	function setCookie(cname, cvalue, exdays) {
	    var d = new Date();
	    d.setTime(d.getTime() + (exdays*24*60*60*1000));
	    var expires = "expires="+d.toUTCString();
	    document.cookie = cname + "=" + cvalue + "; " + expires;
	}

	function getCookie(cname) {
	    var name = cname + "=";
	    var ca = document.cookie.split(';');
	    for(var i=0; i<ca.length; i++) {
	        var c = ca[i];
	        while (c.charAt(0)==' ') c = c.substring(1);
	        if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
	    }
	    return "";
	}
    
    function setMapMode(){
       	var html =  "<?php echo $this->url(array('action'=>'display-map-view', 'type' => 'place', 'ids' => $this->placeIds), 'socialplace_general') ?>";
       	document.getElementById('map-view-iframe').dispose();
		var iframe = new IFrame({
			id : 'map-view-iframe',
			src: html,
			styles: {			       
				'height': '500px',
				'width' : '100%'
			}
		});
		
       	iframe.inject( $('socialplace-browse-place-maps') );
		document.getElementById('map-view-iframe').style.display = 'block';
		//document.getElementById('paginator').style.display = 'none';
    }

 	// Get cookie
	var myCookieViewMode = getCookie('socialplace-place-viewmode-cookie');
	if ( myCookieViewMode == '') 
	{
		myCookieViewMode = '<?php echo $this -> class_mode;?>';
	}
	if ( myCookieViewMode == '') 
	{
		myCookieViewMode = 'socialplace-browse-place-viewmode-list';
	}
	if ($$('.socialplace-mode-view')[0])
	{
		$$('.socialplace-mode-view')[0].addClass( myCookieViewMode );
	}
	if ($('socialplace-browse-listings'))
	{
		$('socialplace-browse-listings').addClass( myCookieViewMode );
	}

	// render MapView
	if ( myCookieViewMode == 'socialplace-browse-place-viewmode-maps') {
		setMapMode();
	}

	// Set click viewMode
	$$('.socialplace-mode-view > span').addEvent('click', function(){
		var viewmode = this.get('rel'),
			browse_content = $('socialplace-browse-listings'),
			header_mode = $$('.socialplace-mode-view')[0];

		setCookie('socialplace-place-viewmode-cookie', viewmode, 1);

		header_mode
			.removeClass('socialplace-browse-place-viewmode-list')
			.removeClass('socialplace-browse-place-viewmode-maps');

		browse_content
			.removeClass('socialplace-browse-place-viewmode-list')
			.removeClass('socialplace-browse-place-viewmode-maps');

		header_mode.addClass( viewmode );
		browse_content.addClass( viewmode );

		// render MapView
		if ( viewmode == 'socialplace-browse-place-viewmode-maps') {
			setMapMode();
		} else {
			document.getElementById('paginator').style.display = 'block';
		}
	});

	$$('.socialplace-item-more-option > span.socialplace-item-more-btn').addEvent('click', function() {
		this.getParent('.socialplace-item-more-option').toggleClass('socialplace-item-show-option');
	});
 </script>   