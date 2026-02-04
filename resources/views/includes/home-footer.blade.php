<!-- Footer Start -->
        <div class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h3 class="title">Categorias</h3>
                            <ul>
                                @if(isset($categorias) && is_array($categorias))
                                    @foreach(array_slice($categorias, 0, 6) as $cat)
                                        <li><a href="/{{ strtolower($cat['nome']) }}">{{ $cat['nome'] }}</a></li>
                                    @endforeach
                                @else
                                    <li><a href="/Cinema">Cinema</a></li>
                                    <li><a href="/Games">Games</a></li>
                                    <li><a href="/Quadrinhos">Quadrinhos</a></li>
                                    <li><a href="/Animes">Animes</a></li>
                                    <li><a href="/Cosplay">Cosplay</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h3 class="title">Tags Populares</h3>
                            <ul>
                                <li><a href="/tag/MCU">MCU</a></li>
                                <li><a href="/tag/Marvel">Marvel</a></li>
                                <li><a href="/tag/DC">DC Comics</a></li>
                                <li><a href="/tag/Anime">Anime</a></li>
                                <li><a href="/tag/Netflix">Netflix</a></li>
                                <li><a href="/tag/Disney+">Disney+</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h3 class="title">Siga-nos</h3>
                            <div class="contact-info">
                                <p><i class="fa fa-map-marker"></i>São Paulo, Brasil</p>
                                <p><i class="fa fa-envelope"></i>contato@aeranerd.com.br</p>
                                <p><i class="fas fa-globe"></i><a href="https://www.aeranerd.com.br" target="_blank" style="color: inherit; margin-left: 5px;">www.aeranerd.com.br</a></p>
                                <div class="social">
                                    <a href="https://twitter.com/aeranerd" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                                    <a href="https://facebook.com/aeranerd" target="_blank" title="Facebook"><i class="fab fa-facebook"></i></a>
                                    <a href="https://instagram.com/aeranerd" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                                    <a href="https://youtube.com/@aeranerd" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                                    <a href="https://tiktok.com/@aeranerd" target="_blank" title="TikTok"><i class="fab fa-tiktok"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h3 class="title">Sobre o A Era Nerd</h3>
                            <div class="newsletter">
                                <p>
                                    Portal dedicado ao universo geek com notícias sobre cinema, games, quadrinhos, animes, séries e tudo sobre a cultura nerd. Fique por dentro das últimas novidades!
                                </p>
                                <div style="margin-top: 15px;">
                                    <a href="/home" class="btn btn-sm" style="background-color: #ff6b6b; color: white;">Ir para Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Footer Bottom Start -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 copyright">
                        <p>Copyright &copy; {{ date('Y') }} <a href="https://www.aeranerd.com.br">A Era Nerd</a>. Todos os direitos reservados.</p>
                    </div>

                    <div class="col-md-6 template-by">
                        <p>
                            <a href="/sobre">Sobre</a> | 
                            <a href="/contato">Contato</a> | 
                            <a href="/politica-privacidade">Política de Privacidade</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Bottom End -->


        <!-- Back to Top -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>


        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('lib/slick/slick.min.js') }}"></script>


        <!-- Template Javascript -->
        <script src="{{ asset('js/main.js') }}"></script>