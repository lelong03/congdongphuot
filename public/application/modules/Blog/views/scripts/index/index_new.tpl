<style>
ul.blog-items li.blog-item
{
    float: left;
    width: 50%;
    padding: 12px;
    box-sizing: border-box;
    max-height: 444px;
}
ul.blog-items li.blog-item div.blog-thumb
{
    width: 100%;
    height: 200px;
    max-height: 200px;
    background-repeat: no-repeat;
    background-size: cover !important;
    margin-bottom: 10px;
    position: relative;
}
ul.blog-items li.blog-item div.container
{
    border: solid 1px #CCC;
}
ul.blog-items li.blog-item div.blog-thumb > div
{
    position: absolute;
    bottom: 18px;
    background: yellowgreen;
    left: 5px;
    display: none;
}
ul.blog-items li.blog-item:hover div.blog-thumb > div
{
    display: block;
}
ul.blog-items li.blog-item div.container .author
{
    float: left;
    width: 50px;
    height: 50px;
}
ul.blog-items li.blog-item div.container .info
{
    float: left;
    overflow: hidden;
    padding-left: 10px;
    padding-right: 10px;
}
ul.blog-items li.blog-item h3, ul.blog-items li.blog-item p
{
margin-left: 10px;
margin-right: 10px;
margin-bottom: 10px;
overflow: hidden;
}
</style>

<?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
<ul class="blog-items">
    <?php foreach( $this->paginator as $item ): ?>
    <li class="blog-item">
        <div class="container">
            <div class="blog-thumb" style="background: url(<?php echo $item->getPhotoUrl('thumb.main');?>)">
                <div>
                    <div class='author'>
                        <?php echo $this->htmlLink($item->getOwner()->getHref(), $this->itemPhoto($item->getOwner(), 'thumb.icon')) ?>
                    </div>
                    <div class="info">
                        <div class='blogs_browse_info_date'>
                            <?php echo $this->translate('Posted');?>
                            <?php echo $this->timestamp(strtotime($item->creation_date)) ?>
                        </div>
                        <div class='blogs_browse_info_date'>
                            <?php echo $this->translate('By');?>
                            <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?>
                        </div>
                        <div class='blogs_browse_info_date'>
                            <?php echo $this->translate(array('%s view', '%s views', $item->view_count), $item->view_count);?> -
                            <?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $item->comment_count);?>
                        </div>
                    </div>
                </div>
            </div>
            <h3><strong><?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?></strong></h3>
            <p class='blogs_browse_info_blurb cdp_blog_item_description'>
                <?php echo $this->string()->truncate($this->string()->stripTags($item->body), 160) ?>
            </p>

        </div>
    </li>
    <?php endforeach; ?>
</ul>


<?php elseif( $this->category || $this->show == 2 || $this->search ): ?>


<div class="tip">
    <span>
      <?php echo $this->translate('Nobody has written a blog entry with that criteria.');?>
        <?php if (TRUE): // @todo check if user is allowed to create a poll ?>
        <?php echo $this->translate('Be the first to %1$swrite%2$s one!', '<a href="'.$this->url(array('action' => 'create'), 'blog_general').'">', '</a>'); ?>
        <?php endif; ?>
    </span>
</div>


<?php else:?>


<div class="tip">
    <span>
      <?php echo $this->translate('Nobody has written a blog entry yet.'); ?>
        <?php if( $this->canCreate ): ?>
        <?php echo $this->translate('Be the first to %1$swrite%2$s one!', '<a href="'.$this->url(array('action' => 'create'), 'blog_general').'">', '</a>'); ?>
        <?php endif; ?>
    </span>
</div>


<?php endif; ?>



<?php echo $this->paginationControl($this->paginator, null, null, array(
    'pageAsQuery' => true,
    'query' => $this->formValues,
)); ?>