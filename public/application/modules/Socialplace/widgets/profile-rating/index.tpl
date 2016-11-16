<?php
	$this->headTranslate(array(
		'ratings',
		'rating',
	));
?>
<script type="text/javascript">
     en4.core.runonce.add(function() {
          var pre_rate = <?php echo $this->place->rating; ?>;
          var rated = '<?php echo $this->rated; ?>';
          var place_id = <?php echo $this->place->place_id; ?>;
          var total_votes = <?php echo $this->rating_count; ?>;
          var viewer = <?php echo $this->viewer_id; ?>;

          var rating_over = window.rating_over = function(rating) {
               if( rated == 1 ) {
                   document.getElementById('rating_text').innerHTML = "<?php echo $this->translate('you already rated'); ?>";
                    //set_rating();
               } else if( viewer == 0 ) {
                   document.getElementById('rating_text').innerHTML = "<?php echo $this->translate('please login to rate'); ?>";
               } else {
                   document.getElementById('rating_text').innerHTML = "<?php echo $this->translate('click to rate'); ?>";
                    for(var x=1; x<=5; x++) {
                         if(x <= rating) {
                             document.getElementById('rate_'+x).set('class', 'rating_star_big_generic rating_star_big');
                         } else {
                             document.getElementById('rate_'+x).set('class', 'rating_star_big_generic rating_star_big_disabled');
                         }
                    }
               }
          }
    
          var rating_out = window.rating_out = function() {
              document.getElementById('rating_text').innerHTML = en4.core.language.translate(['%s rating', '%s ratings', total_votes], total_votes);
               if (pre_rate != 0){
                    set_rating();
               }
               else {
                    for(var x=1; x<=5; x++) {
                        document.getElementById('rate_'+x).set('class', 'rating_star_big_generic rating_star_big_disabled');
                    }
               }
          }

          var set_rating = window.set_rating = function() {
               var rating = pre_rate;
              document.getElementById('rating_text').innerHTML = en4.core.language.translate(['%s rating', '%s ratings', total_votes], total_votes);
               for(var x=1; x<=parseInt(rating); x++) {
                   document.getElementById('rate_'+x).set('class', 'rating_star_big_generic rating_star_big');
               }

               for(var x=parseInt(rating)+1; x<=5; x++) {
                   document.getElementById('rate_'+x).set('class', 'rating_star_big_generic rating_star_big_disabled');
               }

               var remainder = Math.round(rating)-rating;
               if (remainder <= 0.5 && remainder !=0){
                    var last = parseInt(rating)+1;
                   document.getElementById('rate_'+last).set('class', 'rating_star_big_generic rating_star_big_half');
               }
          }

          var rate = window.rate = function(rating) {
              document.getElementById('rating_text').innerHTML = "<?php echo $this->translate('Thanks for rating!'); ?>";
               for(var x=1; x<=5; x++) {
                   document.getElementById('rate_'+x).set('onclick', '');
               }
               (new Request.JSON({
                    'format': 'json',
                    'url' : '<?php echo $this->url(array('module' => 'socialplace', 'controller' => 'index', 'action' => 'rate'), 'default', true) ?>',
                    'data' : {
                         'format' : 'json',
                         'rating' : rating,
                         'place_id': place_id
                    },
                    'onRequest' : function(){
                         rated = 1;
                         total_votes = total_votes+1;
                         pre_rate = (pre_rate+rating)/total_votes;
                         set_rating();
                    },
                    'onSuccess' : function(responseJSON, responseText)
                    {
                         var total = responseJSON[0].total;
                        document.getElementById('rating_text').innerHTML = en4.core.language.translate(['%s rating', '%s ratings', total], total);
                    }
               })).send();

          }

          var tagAction = window.tagAction = function(tag){
              document.getElementById('tag').value = tag;
              document.getElementById('filter_form').submit();
          }
    
          set_rating();
     });
</script>
<h3>
     <?php echo $this->translate('Add Rates') ?>
</h3>
<div id="socialplace-profile-rates">
     <div id="socialplace_rating" class="rating" onmouseout="rating_out();">
          <span id="rate_1" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id): ?>onclick="rate(1);"<?php endif; ?> onmouseover="rating_over(1);"></span>
          <span id="rate_2" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id): ?>onclick="rate(2);"<?php endif; ?> onmouseover="rating_over(2);"></span>
          <span id="rate_3" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id): ?>onclick="rate(3);"<?php endif; ?> onmouseover="rating_over(3);"></span>
          <span id="rate_4" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id): ?>onclick="rate(4);"<?php endif; ?> onmouseover="rating_over(4);"></span>
          <span id="rate_5" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id): ?>onclick="rate(5);"<?php endif; ?> onmouseover="rating_over(5);"></span>
          <span id="rating_text" class="rating_text"><?php echo $this->translate('click to rate'); ?></span>
     </div>
</div>
