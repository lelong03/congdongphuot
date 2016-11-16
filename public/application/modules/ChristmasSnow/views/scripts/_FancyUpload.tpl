<?php
$this->headScript()
    ->appendFile($this->baseUrl() . '/externals/fancyupload/Swiff.Uploader.js')
    ->appendFile($this->baseUrl() . '/externals/fancyupload/Fx.ProgressBar.js')
    ->appendFile($this->baseUrl() . '/externals/fancyupload/FancyUpload2.js')
    ->appendFile($this->baseUrl() . '/externals/fancyupload/FancyUpload2.js');
$this->headLink()
    ->appendStylesheet($this->baseUrl() . '/externals/fancyupload/fancyupload.css');
?>
<script type="text/javascript">
var uploadCount = 0;
var uploaderSwf = '<?php echo $this->baseUrl() . '/externals/fancyupload/Swiff.Uploader.swf' ?>'
window.addEvent('domready', function() { // wait for the content
    var up = new FancyUpload2($('demo-status'), $('demo-list'), { // options object
        // we console.log infos, remove that in production!!
        verbose: false,
        appendCookieData: true,
        // url is read from the form, so you just have to change one place
        url: $('form-upload-music').action + '?ul=1',
        // path to the SWF file
        path: uploaderSwf,
        // remove that line to select all files, or edit it, add more items
        typeFilter: {
            'Mp3 Music (*.mp3)': '*.mp3'
        },
        // this is our browse button, *target* is overlayed with the Flash movie
        target: 'demo-browse',
        // graceful degradation, onLoad is only called if all went well with Flash
        onLoad: function() {
            $('demo-status').removeClass('hide'); // we show the actual UI
            $('demo-fallback').destroy(); // ... and hide the plain form
            // We relay the interactions with the overlayed flash to the link
            this.target.addEvents({
                click: function() {
                    return false;
                },
                mouseenter: function() {
                    this.addClass('hover');
                },
                mouseleave: function() {
                    this.removeClass('hover');
                    this.blur();
                },
                mousedown: function() {
                    this.focus();
                }
            });
            // Interactions for the 2 other buttons
                        if ($('submit-wrapper'))
                            $('submit-wrapper').hide();
            $('demo-clear').addEvent('click', function() {
                up.remove(); // remove all files
                if ($('fancyuploadfileids'))
                                    $('fancyuploadfileids').value = '';
                return false;
            });
        },

        /**
         * Is called when files were not added, "files" is an array of invalid File classes.
         *
         * This example creates a list of error elements directly in the file list, which
         * hide on click.
         */
        onSelectFail: function(files) {
            files.each(function(file) {
                new Element('li', {
                    'class': 'validation-error',
                    html: file.validationErrorMessage || file.validationError,
                    title: MooTools.lang.get('FancyUpload', 'removeTitle'),
                    events: {
                        click: function() {
                            this.destroy();
                        }
                    }
                }).inject(this.list, 'top');
            }, this);
        },
        onComplete: function hideProgress() {
                        var demostatuscurrent = document.getElementById("demo-status-current");
                        var demostatusoverall = document.getElementById("demo-status-overall");
                        var demosubmit = document.getElementById("submit-wrapper");

                        demostatuscurrent.style.display = "none";
                        demostatusoverall.style.display = "none";
                        if (demosubmit)
                            demosubmit.style.display = "block";
        },
        onFileStart: function() {
                        <?php $user = Engine_Api::_()->user()->getViewer();
                        $max_songs = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('mp3music_album', $user, 'max_songs');
                        if($max_songs == "")
                            $max_songs = 5; ?>
                            var max_song = <?php echo $max_songs; ?>;     
            if(uploadCount >= max_song)
            {
                alert("Number song of album is limited :" + max_song + " songs ");
               
            }
            uploadCount += 1;
        },
                onFileRemove: function(file) {
                        uploadCount -= 1;
                        file_id = file.song_id;
                        request = new Request.JSON({
                          'format' : 'json',
                          'url' : '<?php echo $this->url(array('module'=>'mp3music_album','controller'=>'album','action'=>'remove-song-album'), 'default') ?>',
                          'data': {
                            'format': 'json',
                            'song_id' : file_id                          
                          },
                          'onSuccess' : function(responseJSON) {
                            return false;
                          }
                        });
                        request.send();
                        var fileids = $('fancyuploadfileids');

                        if ($("demo-list").getChildren('li').length == 0)
                        {
                          var democlear  = document.getElementById("demo-clear");
                          var demolist   = document.getElementById("demo-list");
                          var demosubmit = document.getElementById("submit-wrapper");
                          democlear.style.display  = "none";
                          demolist.style.display   = "none";
                          demosubmit.style.display = "none";
                        }
                        if (fileids)
                            fileids.value = fileids.value.replace(file_id, "");
        },
        onSelectSuccess: function(file) {
                        $('demo-list').style.display = 'block';
                        var democlear = document.getElementById("demo-clear");
                        var demostatuscurrent = document.getElementById("demo-status-current");
                        var demostatusoverall = document.getElementById("demo-status-overall");

                        democlear.style.display = "inline";
                        demostatuscurrent.style.display = "block";
                        demostatusoverall.style.display = "block";
                        up.start();
        },
        /**
         * This one was directly in FancyUpload2 before, the event makes it
         * easier for you, to add your own response handling (you probably want
         * to send something else than JSON or different items).
         */
        onFileSuccess: function(file, response) {
            var json = new Hash(JSON.decode(response, true) || {});
             <?php $user = Engine_Api::_()->user()->getViewer();
                        $max_songs = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('mp3music_album', $user, 'max_songs');
                        if($max_songs == "")
                        {
                             $mtable  = Engine_Api::_()->getDbtable('permissions', 'authorization');
                             $maselect = $mtable->select()
                                ->where("type = 'mp3music_album'")
                                ->where("level_id = ?",$user->level_id)
                                ->where("name = 'max_songs'");
                              $mallow_a = $mtable->fetchRow($maselect);          
                              if (!empty($mallow_a))
                                $max_songs = $mallow_a['value'];
                              else
                                 $max_songs = 10;
                        }
                        ?>
                            var max_song = <?php echo $max_songs; ?>;     
            if(uploadCount >= max_song)
            {
                alert("Number song of album is limited :" + max_song + " songs ");
                return false; 
            }
            uploadCount += 1;
            if (json.get('status') == '1') {
                file.element.addClass('file-success');
                file.info.set('html', '<span>Upload complete.</span>');
                file.song_id   = json.get('song_id');
                var fileids = $('fancyuploadfileids');
                                if (fileids) {
                                    if (fileids.value.length)
                                        fileids.value += ' ';
                                    fileids.value += json.get('song_id');
                                }
            } else {
                file.element.addClass('file-failed');
                file.info.set('html', '<span><?php echo $this->string()->escapeJavascript($this->translate('An error occurred:')) ?></span> ' + (json.get('error') ? (json.get('error')) : response));
            }
        },
        /**
         * onFail is called when the Flash movie got bashed by some browser plugin
         * like Adblock or Flashblock.
         */
        onFail: function(error) {
            switch (error) {
                case 'hidden': // works after enabling the movie and clicking refresh
                    alert('<?php echo $this->string()->escapeJavascript($this->translate("To enable the embedded uploader, unblock it in your browser and refresh (see Adblock).")) ?>');
                    break;
                case 'blocked': // This no *full* fail, it works after the user clicks the button
                    alert('<?php echo $this->string()->escapeJavascript($this->translate("To enable the embedded uploader, enable the blocked Flash movie (see Flashblock).")) ?>');
                    break;
                case 'empty': // Oh oh, wrong path
                    alert('<?php echo $this->string()->escapeJavascript($this->translate("A required file was not found, please be patient and we'll fix this.")) ?>');
                    break;
                case 'flash': // no flash 9+
                    alert('<?php echo $this->string()->escapeJavascript($this->translate("To enable the embedded uploader, install the latest Adobe Flash plugin.")) ?>');
            }
        }
    });
});
</script>

<fieldset id="demo-fallback">
  <legend><?php echo $this->translate("File Upload") ?></legend>
  <p>
    <?php echo $this->translate('Click "Browse..." to select the MP3 file you would like to upload.') ?>
  </p>
  <label for="demo-musiclabel">
    <?php echo $this->translate('Upload Music:') ?>
    <input id="<?php echo $this->element->getName() ?>"
           type="file"
           name="<?php echo $this->element->getName() ?>"
           value="<?php echo $this->element->getValue() ?>" />
  </label>
</fieldset>

<div id="demo-status" class="hide">
  <div>
    <?php echo $this->translate('_MUSIC_UPLOAD_DESCRIPTION') ?>
  </div>
  <div>
    <a class="buttonlink icon_music_new" href="javascript:void(0);" id="demo-browse"><?php echo $this->translate('Add Music') ?></a>
    <a class="buttonlink icon_clearlist" href="javascript:void(0);" id="demo-clear"><?php echo $this->translate('Clear List') ?></a>
  </div>
  <div class="demo-status-overall" id="demo-status-overall" style="display:none">
    <div class="overall-title"></div>
    <img src="<?php echo $this->baseUrl() . '/externals/fancyupload/assets/progress-bar/bar.gif';?>" class="progress overall-progress" alt="" />
  </div>
  <div class="demo-status-current" id="demo-status-current" style="display:none">
    <div class="current-title"></div>
    <img src="<?php echo $this->baseUrl() . '/externals/fancyupload/assets/progress-bar/bar.gif';?>" class="progress current-progress" alt="" />
  </div>
  <div class="current-text"></div>
</div>
<ul id="demo-list"></ul>