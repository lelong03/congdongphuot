<div class='generic_layout_container layout_place_browse_search'>
        <?php echo $this->formFilter->setAttrib('class', 'filters')->render($this) ?>
</div>

<div class="generic_layout_container quicklinks">
      <ul class="navigation">
        <li>
          <?php echo $this->htmlLink(array('route' => 'socialplace_general', 'action' => 'create'), $this->translate('Create New Place'), array(
            'class' => 'buttonlink icon_place_create'
          )) ?>
        </li>
      </ul>
</div>