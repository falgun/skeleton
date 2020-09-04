<?php
echo '<ul class="pagination">';
echo '<li class="' . ($bag->firstPage->isValid() ? '' : 'disabled' ) . '"><a href="' . $this->getPaginatedUri($bag->firstPage->page) . '" class="btn" >First</a></li>';
echo '<li class="' . ($bag->prePage->isValid() ? '' : 'disabled' ) . '"><a href="' . $this->getPaginatedUri($bag->prePage->page) . '" class="btn" >Previous</a></li>';

foreach ($bag->links as $link) {
    echo '<li class="' . ($link->current ? 'active' : '' ) . '"><a href="' . $this->getPaginatedUri($link->page) . '" class="btn" >' . $link->title . '</a></li>';
}

echo '<li class="' . ($bag->nextPage->isValid() ? '' : 'disabled' ) . '"><a href="' . $this->getPaginatedUri($bag->nextPage->page) . '" class="btn" >Next</a></li>';
echo '<li class="' . ($bag->lastPage->isValid() ? '' : 'disabled' ) . '"><a href="' . $this->getPaginatedUri($bag->lastPage->page) . '" class="btn" >Last</a></li>';

echo '</ul>';

