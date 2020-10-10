<ul class="pagination">
    <li class="<?= ($bag->first()->isVisitable() ? '' : 'disabled' ); ?>"><a href="<?= $this->getPaginatedUri($bag->first()->page()); ?>" class="btn" >First</a></li>
    <li class="<?= ($bag->previous()->isVisitable() ? '' : 'disabled' ); ?>"><a href="<?= $this->getPaginatedUri($bag->previous()->page()); ?>" class="btn" >Previous</a></li>
    <?php foreach ($bag->pages() as $page) : ?>
        <li class="<?= $page->isCurrent() ? 'active' : ''; ?>"><a href="<?= $this->getPaginatedUri($page->page()); ?>" class="btn" ><?= $page->title(); ?></a></li>
    <?php endforeach; ?>

    <li class="<?= ($bag->next()->isVisitable() ? '' : 'disabled' ); ?>"><a href="<?= $this->getPaginatedUri($bag->next()->page()); ?>" class="btn">Next</a></li>
    <li class="<?= ($bag->last()->isVisitable() ? '' : 'disabled' ); ?>"><a href="<?= $this->getPaginatedUri($bag->last()->page()); ?>" class="btn">Last</a></li>
</ul>

