<div class="pagination">
<?php if($this->prev_pagination): ?>
    <?php foreach($this->prev_pagination as $page): ?>
    <a href="<?=$page['link']?>"><?=$page['page']?></a>
    <?php endforeach; ?>
    <?=$this->delimiter; ?>
<?php endif; ?>

<?php if($this->pagination): ?>
    <?php foreach($this->pagination as $page): ?>
        <?php if($page['cur_page']): ?>
            <span class="cur-page"><?=$page['page']?></span>
        <?php else: ?>
            <a href="<?=$page['link']?>"><?=$page['page']?></a>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php if($this->next_pagination): ?>
    <?=$this->delimiter; ?>
    <?php foreach($this->next_pagination as $page): ?>
    <a href="<?=$page['link']?>"><?=$page['page']?></a>
    <?php endforeach; ?>
<?php endif; ?>
</div>