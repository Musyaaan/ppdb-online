// ppdb.js — Scroll reveal animation for PPDB page

document.addEventListener('DOMContentLoaded', function () {
    // Intersection Observer for fade-in-up effect
    const targets = document.querySelectorAll(
        '.ppdb-step, .ppdb-data-card, .ppdb-notif-card, .ppdb-zonasi-card, .ppdb-info-card'
    );

    targets.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity .45s ease, transform .45s ease';
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, 60 * i);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    targets.forEach(el => observer.observe(el));
});