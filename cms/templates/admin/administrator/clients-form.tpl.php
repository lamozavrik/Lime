<div class="box">
    <div class="box-title">
        <p class="title"><?=_('Добавить клиента')?></p>
        <div class="box-buttons">
            <a href="#" class="button"><?=_('Сохранить')?></a>
            <a href="<?=$this->cancel_action ?>" class="button"><?=_('Отмена')?></a>
        </div>
    </div>
    <div class="box-content">
       <div class="box-tabs-nav">
           <ul>
               <li class="box-tab-button" data-tab="#main-info"><span><?=_('Общая информация') ?></span></li>
               <li class="box-tab-button" data-tab="#sites-info"><span><?=_('Сайты') ?></span></li>
               <li class="box-tab-button" data-tab="#phones-info"><span><?=_('Телефоны') ?></span></li>
           </ul>
       </div>
       <div id="main-info" class="box-tab">main-info</div>
       <div id="sites-info" class="box-tab">sites-info</div>
       <div id="phones-info" class="box-tab">phones-info</div>
    </div>
</div>