/**
 * Main JavaScript file for John Long Design Portfolio theme
 */

(function($) {
    'use strict';

    // Initialize when document is ready
    $(document).ready(function() {
        initTheme();
    });

    /**
     * Initialize theme functionality
     */
    function initTheme() {
        initNavigation();
        initSmoothScrolling();
        initAnimations();
        initContactForm();
        initLightbox();
        initParallax();
    }

    /**
     * Navigation functionality
     */
    function initNavigation() {
        const navbar = $('.navbar');
        
        // Add scroll effect to navbar
        $(window).scroll(function() {
            if ($(window).scrollTop() > 50) {
                navbar.addClass('navbar-scrolled');
            } else {
                navbar.removeClass('navbar-scrolled');
            }
        });

        // Mobile menu close on link click
        $('.navbar-nav .nav-link').on('click', function() {
            $('.navbar-collapse').collapse('hide');
        });

        // Active nav highlighting
        $(window).scroll(function() {
            updateActiveNav();
        });
    }

    /**
     * Update active navigation based on scroll position
     */
    function updateActiveNav() {
        const scrollPos = $(window).scrollTop() + 100;
        
        $('section[id]').each(function() {
            const section = $(this);
            const sectionTop = section.offset().top;
            const sectionHeight = section.outerHeight();
            const sectionId = section.attr('id');
            
            if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
                $('.navbar-nav .nav-link').removeClass('active');
                $('.navbar-nav .nav-link[href="#' + sectionId + '"]').addClass('active');
            }
        });
    }

    /**
     * Smooth scrolling for anchor links
     */
    function initSmoothScrolling() {
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                
                $('html, body').animate({
                    scrollTop: target.offset().top - 70
                }, 800, 'easeInOutQuart');
            }
        });
    }

    /**
     * Initialize scroll animations
     */
    function initAnimations() {
        // Fade in animation observer
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);

        // Observe elements for animation
        $('.project-card, .testimonial-card, .result-stat, .process-step').each(function() {
            observer.observe(this);
        });

        // Counter animation for stats
        $('.result-stat .stat-number').each(function() {
            const $this = $(this);
            const target = parseInt($this.text().replace(/[^\d]/g, ''));
            const suffix = $this.text().replace(/[\d]/g, '');
            
            $({ value: 0 }).animate({ value: target }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.ceil(this.value) + suffix);
                }
            });
        });
    }

    /**
     * Contact form functionality
     */
    function initContactForm() {
        $('.contact-form').on('submit', function(e) {
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');
            const originalText = submitBtn.html();
            
            // Add loading state
            submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Sending...')
                     .prop('disabled', true);
            
            // Form validation
            let isValid = true;
            
            form.find('input[required], textarea[required]').each(function() {
                const field = $(this);
                const value = field.val().trim();
                
                if (!value) {
                    field.addClass('is-invalid');
                    isValid = false;
                } else {
                    field.removeClass('is-invalid');
                }
                
                // Email validation
                if (field.attr('type') === 'email' && value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        field.addClass('is-invalid');
                        isValid = false;
                    }
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                submitBtn.html(originalText).prop('disabled', false);
                showNotification('Please fill in all required fields correctly.', 'error');
                return false;
            }
            
            // If we get here, form is valid - let it submit naturally
        });

        // Contact form enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const contactForm = document.querySelector('.contact-form');
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    
                    // Show loading state
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
                    submitBtn.disabled = true;
                    
                    // Reset after 5 seconds if something goes wrong
                    setTimeout(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }, 5000);
                });
            }
        });
        
        // Real-time validation
        $('.contact-form input, .contact-form textarea').on('blur', function() {
            const field = $(this);
            const value = field.val().trim();
            
            if (field.prop('required') && !value) {
                field.addClass('is-invalid');
            } else {
                field.removeClass('is-invalid');
            }
        });
    }

    /**
     * Initialize lightbox for images
     */
    function initLightbox() {
        // Add lightbox to solution images
        $('.solution-image a[data-lightbox]').each(function() {
            $(this).on('click', function(e) {
                e.preventDefault();
                const imgSrc = $(this).find('img').attr('src');
                openLightbox(imgSrc);
            });
        });
    }

    /**
     * Open lightbox modal
     */
    function openLightbox(imageSrc) {
        const lightboxHtml = `
            <div class="lightbox-overlay" id="lightbox-overlay">
                <div class="lightbox-container">
                    <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
                    <img src="${imageSrc}" alt="Project Image" class="lightbox-image">
                </div>
            </div>
        `;
        
        $('body').append(lightboxHtml);
        $('#lightbox-overlay').fadeIn(300);
        
        // Close on overlay click
        $('#lightbox-overlay').on('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });
        
        // Close on escape key
        $(document).on('keyup.lightbox', function(e) {
            if (e.keyCode === 27) {
                closeLightbox();
            }
        });
    }

    /**
     * Close lightbox modal
     */
    window.closeLightbox = function() {
        $('#lightbox-overlay').fadeOut(300, function() {
            $(this).remove();
        });
        $(document).off('keyup.lightbox');
    };

    /**
     * Initialize parallax effects
     */
    function initParallax() {
        $(window).scroll(function() {
            const scrolled = $(window).scrollTop();
            const parallaxElements = $('.hero-image img');
            
            parallaxElements.each(function() {
                const speed = 0.5;
                const yPos = -(scrolled * speed);
                $(this).css('transform', 'translate3d(0, ' + yPos + 'px, 0)');
            });
        });
    }

    /**
     * Show notification message
     */
    function showNotification(message, type = 'info') {
        const alertClass = type === 'error' ? 'alert-danger' : 'alert-success';
        const icon = type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle';
        
        const notification = $(`
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                 style="top: 100px; right: 20px; z-index: 9999; min-width: 300px;">
                <i class="fas ${icon} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        $('body').append(notification);
        
        // Auto remove after 5 seconds
        setTimeout(function() {
            notification.alert('close');
        }, 5000);
    }

    /**
     * Preloader functionality
     */
    function initPreloader() {
        $(window).on('load', function() {
            $('.preloader').fadeOut(500);
        });
    }

    /**
     * Initialize project filtering (if needed)
     */
    function initProjectFiltering() {
        $('.filter-btn').on('click', function() {
            const filter = $(this).data('filter');
            const projects = $('.project-card');
            
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            
            if (filter === 'all') {
                projects.fadeIn(300);
            } else {
                projects.hide();
                $('.project-card[data-category="' + filter + '"]').fadeIn(300);
            }
        });
    }

    /**
     * Back to top button
     */
    function initBackToTop() {
        const backToTop = $('<button class="back-to-top" title="Back to Top"><i class="fas fa-chevron-up"></i></button>');
        $('body').append(backToTop);
        
        $(window).scroll(function() {
            if ($(window).scrollTop() > 500) {
                backToTop.addClass('show');
            } else {
                backToTop.removeClass('show');
            }
        });
        
        backToTop.on('click', function() {
            $('html, body').animate({ scrollTop: 0 }, 800);
        });
    }

    // Initialize additional features
    initPreloader();
    initProjectFiltering();
    initBackToTop();

    // Add custom easing
    $.easing.easeInOutQuart = function(x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t * t + b;
        return -c / 2 * ((t -= 2) * t * t * t - 2) + b;
    };

    // Navigation scroll highlighting
    document.addEventListener('DOMContentLoaded', function() {
        // Navigation scroll highlighting
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link[href^="#"]');
        const sections = Array.from(navLinks).map(link => {
            const targetId = link.getAttribute('href').substring(1);
            return document.getElementById(targetId);
        }).filter(section => section !== null);

        function updateActiveNavigation() {
            let current = '';
            const scrollPos = window.scrollY + 100; // Offset for better UX

            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.offsetHeight;
                
                if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
                    current = section.getAttribute('id');
                }
            });

            // Remove all active classes
            navLinks.forEach(link => {
                link.classList.remove('active');
                link.parentElement.classList.remove('active');
            });

            // Add active class to current section link
            if (current) {
                const activeLink = document.querySelector(`.navbar-nav .nav-link[href="#${current}"]`);
                if (activeLink) {
                    activeLink.classList.add('active');
                    activeLink.parentElement.classList.add('active');
                }
            } else {
                // If no section is active, make "Home" active (first link)
                const homeLink = document.querySelector('.navbar-nav .nav-link[href="#hero"], .navbar-nav .nav-link[href="/"], .navbar-nav .nav-link[href="' + window.location.origin + '"]');
                if (homeLink) {
                    homeLink.classList.add('active');
                    homeLink.parentElement.classList.add('active');
                }
            }
        }

        // Update on scroll
        window.addEventListener('scroll', updateActiveNavigation);
        
        // Update on page load
        updateActiveNavigation();

        // Smooth scrolling for anchor links
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href').substring(1);
                const targetSection = document.getElementById(targetId);
                
                if (targetSection) {
                    e.preventDefault();
                    
                    // Remove active from all
                    navLinks.forEach(l => {
                        l.classList.remove('active');
                        l.parentElement.classList.remove('active');
                    });
                    
                    // Add active to clicked link
                    this.classList.add('active');
                    this.parentElement.classList.add('active');
                    
                    // Smooth scroll to section
                    targetSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    
                    // Close mobile menu if open
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                        const navbarToggler = document.querySelector('.navbar-toggler');
                        if (navbarToggler) {
                            navbarToggler.click();
                        }
                    }
                }
            });
        });
    });

})(jQuery);
