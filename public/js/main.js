// burger menu
document.addEventListener("DOMContentLoaded", function () {
    const burgerBtn = document.getElementById("burger-btn")
    const navMenu = document.getElementById("nav-menu")
    burgerBtn.addEventListener("click", function () {
        if (navMenu.classList.contains("active")) {
            navMenu.classList.remove("active")
            navMenu.addEventListener("transitionend", function handler(e) {
                if (e.propertyName === "transform" || e.propertyName === "opacity") {
                    if (!navMenu.classList.contains("active")) {
                        navMenu.classList.add("hidden")
                    }
                    navMenu.removeEventListener("transitionend", handler)
                }
            })
        } else {
            navMenu.classList.remove("hidden")
            void navMenu.offsetWidth
            navMenu.classList.add("active")
        }
    })
})
// slider
document.addEventListener("DOMContentLoaded", function () {
    const track = document.querySelector('.slider-track')
    const slides = document.querySelectorAll('.slide')
    const prevButton = document.querySelector('.slider-arrow-prev')
    const nextButton = document.querySelector('.slider-arrow-next')
    let currentIndex = 0
    const totalSlides = slides.length
    function updateSlider() {
        track.style.transform = `translateX(-${currentIndex * 100}%)`
        const activeOverlay = slides[currentIndex].querySelector('.slide-overlay')
        activeOverlay.style.animation = 'none'
        activeOverlay.offsetHeight
        activeOverlay.style.animation = ''
    }

    prevButton.addEventListener('click', function () {
        if (currentIndex > 0) {
            currentIndex--
        } else {
            currentIndex = totalSlides - 1
        }
        updateSlider()
    })

    nextButton.addEventListener('click', function () {
        if (currentIndex < totalSlides - 1) {
            currentIndex++
        } else {
            currentIndex = 0
        }
        updateSlider()
    })

    window.addEventListener("resize", function () {
        updateSlider()
    })
})
// Load more events
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('load-more')
    const eventsContainer = document.getElementById('events-container')
    let offset = 3

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            console.log('Load more button clicked')
            
            fetch(`/load-more-events?offset=${offset}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok')
                    }
                    return response.json()
                })
                .then(data => {
                    console.log('Received data:', data)
                    eventsContainer.insertAdjacentHTML('beforeend', data.html)
                    offset += 3
                    
                    if (!data.hasMore) {
                        loadMoreBtn.style.display = 'none'
                    }
                })
                .catch(error => {
                    console.error('Error loading more events:', error)
                })
        })
    }
})
// Search
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const autocompleteResults = document.getElementById('autocomplete-results');
    let timeoutId;

    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        const query = this.value.trim();

        if (query.length < 2) {
            autocompleteResults.style.display = 'none';
            return;
        }

        timeoutId = setTimeout(() => {
            fetch(`/search/autocomplete?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(events => {
                    if (events.length > 0) {
                        autocompleteResults.innerHTML = events.map(event => `
                            <div class="autocomplete-item" data-id="${event.id}">
                                ${event.title}
                            </div>
                        `).join('');
                        autocompleteResults.style.display = 'block';
                    } else {
                        autocompleteResults.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    autocompleteResults.style.display = 'none';
                });
        }, 300);
    });

    // Закрытие подсказок при клике вне поиска
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !autocompleteResults.contains(e.target)) {
            autocompleteResults.style.display = 'none';
        }
    });

    // Обработка выбора подсказки
    autocompleteResults.addEventListener('click', function(e) {
        const item = e.target.closest('.autocomplete-item');
        if (item) {
            const eventId = item.dataset.id;
            window.location.href = `/events/${eventId}`;
        }
    });

    // Обработка отправки формы поиска
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const searchInput = document.getElementById('search-input');
            const dateInput = document.getElementById('event-date');
            
            let url = '/search?';
            let params = [];
            if (searchInput.value) {
                params.push(`query=${encodeURIComponent(searchInput.value)}`);
            }
            if (dateInput && dateInput.value) {
                params.push(`date=${encodeURIComponent(dateInput.value)}`);
            }
            if (params.length === 0) {
                // Если ничего не введено, не отправляем
                return;
            }
            url += params.join('&');
            window.location.href = url;
        });
    }
});
// Toggle password visibility
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
// Scroll categories
function scrollCategories(direction) {
    const grid = document.querySelector('.categories-grid');
    const scrollAmount = 300; // Количество пикселей для прокрутки
    
    if (direction === 'next') {
        grid.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    } else {
        grid.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    }
}

// Добавляем обработчики для кнопок навигации
document.addEventListener('DOMContentLoaded', function() {
    const prevBtn = document.querySelector('.category-nav-prev');
    const nextBtn = document.querySelector('.category-nav-next');
    
    if (prevBtn) {
        prevBtn.addEventListener('click', () => scrollCategories('prev'));
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => scrollCategories('next'));
    }
});

// Навигация по категориям
document.addEventListener('DOMContentLoaded', function() {
    const categoriesGrid = document.querySelector('.categories-grid');
    const prevBtn = document.querySelector('.category-nav-prev');
    const nextBtn = document.querySelector('.category-nav-next');

    if (categoriesGrid && prevBtn && nextBtn) {
        const scrollAmount = 300;

        prevBtn.addEventListener('click', () => {
            categoriesGrid.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        });

        nextBtn.addEventListener('click', () => {
            categoriesGrid.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });
    }
});

// Копирование ссылки
document.addEventListener('DOMContentLoaded', function() {
    const copyLinkButton = document.querySelector('.copy-link');
    
    if (copyLinkButton) {
        copyLinkButton.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');
            
            navigator.clipboard.writeText(url).then(function() {
                const originalTitle = copyLinkButton.getAttribute('title');
                copyLinkButton.setAttribute('title', 'Ссылка скопирована!');
                
                setTimeout(function() {
                    copyLinkButton.setAttribute('title', originalTitle);
                }, 2000);
            }).catch(function(err) {
                console.error('Не удалось скопировать ссылку:', err);
            });
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Обработка кнопки "Ответить"
    const replyButtons = document.querySelectorAll('.comment-reply-btn');
    replyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const replyForm = document.getElementById(`reply-form-${commentId}`);
            
            // Скрываем все формы ответов
            document.querySelectorAll('.reply-form-container').forEach(form => {
                form.style.display = 'none';
            });
            
            // Показываем форму ответа для текущего комментария
            replyForm.style.display = 'block';
            
            // Прокручиваем страницу к форме ответа
            replyForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    });
});

// Обработка лайков
document.addEventListener('DOMContentLoaded', function() {
    const likeForms = document.querySelectorAll('.like-form');
    
    likeForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('.like-button');
            const countElement = button.querySelector('.like-count');
            const icon = button.querySelector('i');
            const isLiked = button.classList.contains('active');
            
            // Определяем URL и метод в зависимости от состояния
            const url = isLiked ? 
                this.action.replace('/like', '/unlike') : 
                this.action;
            
            fetch(url, {
                method: isLiked ? 'DELETE' : 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.classList.toggle('active');
                    icon.classList.toggle('fas');
                    icon.classList.toggle('far');
                    countElement.textContent = data.likes_count;
                    button.title = button.classList.contains('active') ? 
                        'Убрать из избранного' : 'Добавить в избранное';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
// Avatar
document.addEventListener('DOMContentLoaded', function() {
    // Обработка загрузки аватара
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatar-preview');
    const avatarPreviewContainer = document.querySelector('.avatar-preview');

    if (avatarInput && avatarPreview) {
        avatarPreviewContainer.addEventListener('click', () => {
            avatarInput.click();
        });

        avatarInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});

// бургер меню 
document.addEventListener('DOMContentLoaded', function() {
    const burgerMenu = document.querySelector('.burger-menu');
    const headerActions = document.querySelector('.header__actions');

    if (burgerMenu && headerActions) {
        burgerMenu.addEventListener('click', function() {
            headerActions.classList.toggle('active');
            burgerMenu.classList.toggle('active');
        });

        // закрытие меню при клике вне него
        document.addEventListener('click', function(event) {
            if (!headerActions.contains(event.target) && !burgerMenu.contains(event.target)) {
                headerActions.classList.remove('active');
                burgerMenu.classList.remove('active');
            }
        });
    }
});
// Участие в событии
document.addEventListener('DOMContentLoaded', function() {
    const participateBtn = document.getElementById('participate-btn');
    const messageDiv = document.getElementById('participate-message');
    if (participateBtn) {
        participateBtn.addEventListener('click', function(e) {
            e.preventDefault();
            participateBtn.disabled = true;
            fetch(`/events/${participateBtn.dataset.eventId}/participate`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                messageDiv.textContent = data.message;
                participateBtn.disabled = false;
            })
            .catch(() => {
                messageDiv.textContent = 'Ошибка при записи!';
                participateBtn.disabled = false;
            });
        });
    }
});

// анимация контента
document.addEventListener('DOMContentLoaded', function () {
    const content = document.querySelector('.content-appear');
    if (content) {
        setTimeout(() => {
            content.classList.add('visible');
        }, 100);
    }
});


