@section('footer')
    <footer class="footer">
        <div class="container">
            <div class="footer-top">
                <div>
                    <a class="footer-logo" href="{{ route('home') }}">Event Horizon</a>
                </div>
                <nav class="footer-nav">
                    <a href="{{ route('contacts') }}">Контакты</a>
                    <a href="{{ route('about') }}">О нас</a>
                </nav>
                <div class="footer-social">
                    <a href="https://t.me/keklole" class="social-link" target="_blank"><img src="{{ asset('images/Vector (1).svg') }}" alt="tg"></a>
                    <a href="https://vk.com/keklole0" class="social-link" target="_blank"><img src="{{ asset('images/Vector.svg') }}" alt="vk"></a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Event Horizon. Все права защищены.</p>
            </div>
        </div>
    </footer>
@endsection
