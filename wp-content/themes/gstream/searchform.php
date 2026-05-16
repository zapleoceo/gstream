<?php

?>

<div class="header__body__search">
    <form role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
        <div class="header__body__search__box">		
			<input type="text" class="header__body__search__box__input" placeholder="Что ищете?" value="<?php echo get_search_query(); ?>" name="s"> 
			<button class="header__body__search__box__button">
				<div class="header__body__search__box__button__icon"></div>
				<span class="header__body__search__box__button__text">поиск</span>
		    </button>
						
		</div>
	</form>
</div>
