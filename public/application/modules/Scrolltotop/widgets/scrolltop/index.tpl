<script type='text/javascript'>
if (!(Browser.name == 'ie' && Browser.version == 6)) {
	window.addEvent((Browser.name == 'ie' ? 'load' : 'domready'), function(){
		var scrollUp = new Fx.Scroll(window);
		var target_opacity = 0.5;
		new Element('span', {
			'id': 'gototop', 
			'class': 'gototop_style',
			'styles': {
				opacity: target_opacity,
				display: 'none',
				position: 'fixed',
				bottom: '45px',
				right: '40px',
				cursor: 'pointer',
				width: '60px',
				height: '60px',
				background: 'url(\'<?php echo $this->baseUrl();?>/application/modules/Scrolltotop/externals/images/scroll_top_buttons/<?php echo $this->scroll_icon;?>\')'
			},
			'text': '<?php echo $this->translate(""); ?>',
			'title': '<?php echo $this->translate("Go To Top"); ?>',
			'tween': {
				duration: 600,
				onComplete: function(el) { if (el.get('opacity') == 0) el.setStyle('display', 'none')}
			},
			'events': {'click': function() {
				scrollUp.toTop();
			}}
		}).inject(document.body);
		window.addEvent('scroll', function() {
			var visible = window.getScroll().y > (window.getSize().y * 0.3);
			if (visible == arguments.callee.prototype.last_state) return;
			if (Fx && Fx.Tween) {
				if (visible) $('gototop').fade('hide').setStyle('display', 'inline').fade(target_opacity);
				else $('gototop').fade('out');
			} else {
				$('gototop').setStyle('display', (visible ? 'inline' : 'none'));
			}
			arguments.callee.prototype.last_state = visible
		});
	});
}
</script>