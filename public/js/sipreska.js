
/* ==================================================
   MENU MOBILE
================================================== */
function toggleNav() {
    const nav = document.getElementById('mainNav');
    const button = document.querySelector('.nav-toggle');

    if (!nav || !button) {
        return;
    }

    const isOpen = nav.classList.toggle('show');

    button.setAttribute('aria-expanded', String(isOpen));
    button.setAttribute(
        'aria-label',
        isOpen ? 'Tutup menu' : 'Buka menu'
    );
}

// Tutup menu HP setelah salah satu tautan dipilih.
document.querySelectorAll('#mainNav a').forEach(function (link) {
    link.addEventListener('click', function () {
        const nav = document.getElementById('mainNav');
        const button = document.querySelector('.nav-toggle');

        if (!nav || !button) {
            return;
        }

        nav.classList.remove('show');
        button.setAttribute('aria-expanded', 'false');
        button.setAttribute('aria-label', 'Buka menu');
    });
});


/* ==================================================
   DROPDOWN NAVBAR SIPRESKA
   Tambahan — pertahankan fungsi JS lainnya
================================================== */

function toggleDropdown(button) {
    const dropdown = button.closest('.nav-dropdown');

    if (!dropdown) {
        return;
    }

    const akanDibuka = !dropdown.classList.contains('open');

    // Tutup dropdown lainnya.
    document.querySelectorAll('.nav-dropdown').forEach(function (item) {
        item.classList.remove('open');

        const tombol = item.querySelector('.nav-dropdown-toggle');

        if (tombol) {
            tombol.setAttribute('aria-expanded', 'false');
        }
    });

    // Buka dropdown yang dipilih.
    if (akanDibuka) {
        dropdown.classList.add('open');
        button.setAttribute('aria-expanded', 'true');
    }
}

// Tutup dropdown jika pengguna mengeklik di luar menu.
document.addEventListener('click', function (event) {
    if (event.target.closest('.nav-dropdown')) {
        return;
    }

    document.querySelectorAll('.nav-dropdown').forEach(function (item) {
        item.classList.remove('open');

        const tombol = item.querySelector('.nav-dropdown-toggle');

        if (tombol) {
            tombol.setAttribute('aria-expanded', 'false');
        }
    });
});

// Tutup dropdown menggunakan tombol Escape.
document.addEventListener('keydown', function (event) {
    if (event.key !== 'Escape') {
        return;
    }

    document.querySelectorAll('.nav-dropdown').forEach(function (item) {
        item.classList.remove('open');

        const tombol = item.querySelector('.nav-dropdown-toggle');

        if (tombol) {
            tombol.setAttribute('aria-expanded', 'false');
        }
    });
});

/* ==================================================
   HERO SLIDER SIPRESKA
================================================== */
(function () {
    const slider = document.querySelector('.hero-slider');
    if (!slider) return;

    const slides = Array.from(slider.querySelectorAll('.slide'));
    const dotsContainer = slider.querySelector('#sliderDots');
    if (slides.length < 2 || !dotsContainer) return;

    let activeIndex = Math.max(0, slides.findIndex((slide) => slide.classList.contains('active')));
    let timer;

    const showSlide = (index) => {
        activeIndex = (index + slides.length) % slides.length;
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === activeIndex);
            slide.setAttribute('aria-hidden', String(i !== activeIndex));
        });
        dotsContainer.querySelectorAll('button').forEach((dot, i) => {
            dot.classList.toggle('active', i === activeIndex);
            dot.setAttribute('aria-current', i === activeIndex ? 'true' : 'false');
        });
    };

    dotsContainer.replaceChildren(...slides.map((_, i) => {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.setAttribute('aria-label', `Tampilkan slide ${i + 1}`);
        dot.addEventListener('click', () => {
            showSlide(i);
            restartTimer();
        });
        return dot;
    }));

    window.changeSlide = (step) => {
        showSlide(activeIndex + step);
        restartTimer();
    };

    const startTimer = () => {
        if (!timer) timer = window.setInterval(() => showSlide(activeIndex + 1), 5500);
    };
    const stopTimer = () => {
        window.clearInterval(timer);
        timer = undefined;
    };
    function restartTimer() {
        stopTimer();
        startTimer();
    }

    slider.addEventListener('mouseenter', stopTimer);
    slider.addEventListener('mouseleave', startTimer);
    slider.addEventListener('focusin', stopTimer);
    slider.addEventListener('focusout', (event) => {
        if (!slider.contains(event.relatedTarget)) startTimer();
    });
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) stopTimer();
        else startTimer();
    });

    showSlide(activeIndex);
    startTimer();
})();
