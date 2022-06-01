<div>

    <footer class="footer ">
        <div class="footer__box">
            <div class="container">
                <div class="footer__box_wrap">

                    <div class="footer__block">
                        <x-frontend.popular-tags :rows_limit="30" />
                    </div>

                    <div class="footer__block">
                        <x-frontend.cities-with-users :rows_limit="80" />
                    </div>

                </div>
            </div>
        </div>
        <div class="footer__content">
            <div class="container">
                <div class="footer__content_wrap">
                    <div class="footer__left_part">
                        <a href="#" class="footer__logo">
                            <svg width="31" height="32">
                                <use xlink:href="/img/sprite.svg#logo-footer"></use>
                            </svg>
                        </a>
                        <nav class="footer__nav">
                            <div class="footer__nav_list">
                                <a href="nomination.html" class="footer__nav-link">Фотографии</a>
                                <a href="/nominations" class="footer__nav-link">Номинации</a>
                                <a href="about_us.html" class="footer__nav-link">О нас</a>
                            </div>
                            <div class="footer__nav_list">
                                <a href="photographers.html" class="footer__nav-link">Фотографы</a>
                                <a href="#" class="footer__nav-link">Party</a>
                                <a href="#" class="footer__nav-link">Политика конфиденциальности</a>
                            </div>
                        </nav>
                    </div>
                    <div class="footer__right_part">
                        <div class="footer__socials">
                            <a href="#" class="footer__socials-link">
                                <svg width="15" height="15">
                                    <use xlink:href="/img/sprite.svg#socials-instagram"></use>
                                </svg>
                            </a>
                            <a href="#" class="footer__socials-link">
                                <svg width="14" height="8">
                                    <use xlink:href="/img/sprite.svg#socials-vk"></use>
                                </svg>
                            </a>
                            <a href="#" class="footer__socials-link">
                                <svg width="15" height="10">
                                    <use xlink:href="/img/sprite.svg#socials-youtube"></use>
                                </svg>
                            </a>
                            <a href="#" class="footer__socials-link">
                                <svg width="14" height="11">
                                    <use xlink:href="/img/sprite.svg#socials-twitter"></use>
                                </svg>
                            </a>
                        </div>
                        <p class="footer__copyright">© 2021 Платформа для креативных свадебных фотографов</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>


</div>
