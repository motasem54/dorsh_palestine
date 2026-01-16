<style>
    .footer-logo {
    width: 150px;
    margin-bottom: 20px;
    filter: brightness(0) invert(1);
}

</style>
    <!-- Footer -->
    <footer id="contact" class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-widget">
                        <img src="images/logo.png" alt="Dorsch Palestine" class="footer-logo">
                        <p style="margin-bottom: 20px;">Leading supplier of premium kitchen appliances with a focus on sustainability, the environment, and healthy cooking.</p>
                        <p style="font-weight: 600; color: var(--primary-gold); margin-bottom: 10px;">Follow Us:</p>
                        <div class="social-links">
                            <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h4>Quick Links</h4>
                        <ul>
                            <li><a href="#home">Home</a></li>
                            <li><a href="#products">Products</a></li>
                            <li><a href="#collections">Collections</a></li>
                            <li><a href="#about">About Us</a></li>
                            <li><a href="#contact">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h4>Collections</h4>
                        <ul>
                            <li><a href="#">Premium Cookware</a></li>
                            <li><a href="#">Lifetime Series</a></li>
                            <li><a href="#">SteelPro</a></li>
                            <li><a href="#">GoPress Pressure Cookers</a></li>
                            <li><a href="#">Bakeware</a></li>
                            <li><a href="#">Coffee & Tea</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h4>Contact Info</h4>
                        <ul style="font-size: 13px;">
                            <li><a href="#"><i class="fas fa-map-marker-alt"></i> Palestine, Hebron</a></li>
                            <li><a href="tel:+972599000000"><i class="fas fa-phone"></i> +972 59 900 0000</a></li>
                            <li><a href="mailto:info@dorsch-palestine.com"><i class="fas fa-envelope"></i> info@dorsch-palestine.com</a></li>
                        </ul>
                        <p style="margin-top: 20px; font-size: 12px; color: #999;">
                            Products manufactured in compliance with LFGB German Standards
                        </p>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 <a href="#">Dorsch Palestine</a>. All Rights Reserved. | Made with German Standards | <a href="#">Privacy Policy</a></p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Preloader
        $(window).on('load', function() {
            $('.preloader-wrap').fadeOut(600);
        });

        // AOS Animation
        AOS.init({
            duration: 1000,
            once: true,
            offset: 80
        });

        // Header Scroll Effect
        $(window).scroll(function() {
            if ($(window).scrollTop() > 50) {
                $('.header-area').addClass('scrolled');
            } else {
                $('.header-area').removeClass('scrolled');
            }
        });

        // Smooth Scroll
        $('a[href^="#"]').on('click', function(e) {
            e.preventDefault();
            var target = $(this.hash);
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 75
                }, 800, 'swing');
            }
        });

        // Mobile Menu Toggle
        $('.btn-menu').on('click', function() {
            $(this).toggleClass('active');
            $('.main-menu').toggleClass('active');

            if ($(this).hasClass('active')) {
                $(this).find('span:nth-child(1)').css('transform', 'rotate(45deg) translateY(10px)');
                $(this).find('span:nth-child(2)').css('opacity', '0');
                $(this).find('span:nth-child(3)').css('transform', 'rotate(-45deg) translateY(-10px)');
            } else {
                $(this).find('span').css({'transform': 'none', 'opacity': '1'});
            }
        });

        // Active Menu Item on Scroll
        $(window).scroll(function() {
            var scrollPos = $(window).scrollTop() + 100;

            $('.main-menu a').each(function() {
                var currLink = $(this);
                var refElement = $(currLink.attr('href'));

                if (refElement.length && refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                    $('.main-menu a').removeClass('active');
                    currLink.addClass('active');
                }
            });
        });

        // Products Swiper
        var swiper = new Swiper('.productsSwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 25,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            }
        });

        // Counter Animation for Stats
        var counted = false;
        $(window).scroll(function() {
            var statsSection = $('.stats-section');
            if (statsSection.length) {
                var oTop = statsSection.offset().top - window.innerHeight;
                if (!counted && $(window).scrollTop() > oTop) {
                    $('.stat-number').each(function() {
                        var $this = $(this);
                        var countTo = $this.text();
                        var numValue = parseInt(countTo.replace(/[^0-9]/g, ''));

                        $({ countNum: 0 }).animate({
                            countNum: numValue
                        }, {
                            duration: 2000,
                            easing: 'swing',
                            step: function() {
                                var suffix = countTo.indexOf('+') > -1 ? '+' : '';
                                suffix = countTo.indexOf('%') > -1 ? '%' : suffix;
                                $this.text(Math.floor(this.countNum) + suffix);
                            },
                            complete: function() {
                                $this.text(countTo);
                            }
                        });
                    });
                    counted = true;
                }
            }
        });
    </script>
</body>
</html>