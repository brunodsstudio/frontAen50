<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GeneralLayout from '@/Layouts/GeneralLayout.vue';
import Carousel from '@/Components/Carousel.vue';

</script>

    <template #header>
            <Head title="Home" />
            <GeneralLayout>

                <div class="container-fluid p-0" style="margin-top: 40px;">

                        <!-- Top News Start-->
                        <div class="top-news">
                            <div class="container-fluid">
                            
                                <div class="row gx-2">
                                    <div class="col-md-6 tn-left">

                                        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators">
                                                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                            </div>
                                            <div class="carousel-inner">
                                                <div class="carousel-item active" data-bs-interval="10000">
                                                <img src="images/eSporsSp.jpg" class="d-block w-100" alt="...">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <h5>First slide label</h5>
                                                    <p>Some representative placeholder content for the first slide.</p>
                                                </div>
                                                </div>
                                                <div class="carousel-item" data-bs-interval="2000">
                                                <img src="images/eSporsSp.jpg" class="d-block w-100" alt="...">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <h5>Second slide label</h5>
                                                    <p>Some representative placeholder content for the second slide.</p>
                                                </div>
                                                </div>
                                                <div class="carousel-item">
                                                <img src="images/eSporsSp.jpg" class="d-block w-100" alt="...">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <h5>Third slide label</h5>
                                                    <p>Some representative placeholder content for the third slide.</p>
                                                </div>
                                                </div>
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>


                                    </div>
                                    <div class="col-md-1 tn-left" style="width: 5px;"></div>
                                    <div class="col-md-5 tn-right">
                                        <div class="row gx-1">
                                            <div class="col-md-6">
                                                <div class="tn-img">
                                                    <img src="img/top-news-2.jpg" />
                                                    <div class="tn-content">
                                                        <div class="tn-content-inner">
                                                            <a class="tn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            <a class="tn-title" href="">Integer faucibus pharetra odio</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="tn-img">
                                                    <img src="img/top-news-3.jpg" />
                                                    <div class="tn-content">
                                                        <div class="tn-content-inner">
                                                            <a class="tn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            <a class="tn-title" href="">Nulla vitae pharetra ligula</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-md-6">
                                                <div class="tn-img">
                                                    <img src="img/top-news-4.jpg" />
                                                    <div class="tn-content">
                                                        <div class="tn-content-inner">
                                                            <a class="tn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            <a class="tn-title" href="">Ut ac euismod tellus a blandit</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="tn-img">
                                                    <img src="img/top-news-5.jpg" />
                                                    <div class="tn-content">
                                                        <div class="tn-content-inner">
                                                            <a class="tn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            <a class="tn-title" href="">Cras ac egestas sem nec euismod</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Top News End-->

                         <br/>

                        <!-- Category News Start-->
                        <div class="cat-news">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h2><i class="fas fa-align-justify"></i>Sports</h2>
                                        <div class="row cn-slider">
                                            <div class="col-md-6">
                                                <div class="cn-img">
                                                    <img src="img/cat-news-1.jpg" />
                                                    <div class="cn-content">
                                                        <div class="cn-content-inner">
                                                            <a class="cn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            <a class="cn-title" href="">Cras sed semper puru vitae lobortis velit</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="cn-img">
                                                    <img src="img/cat-news-2.jpg" />
                                                    <div class="cn-content">
                                                        <div class="cn-content-inner">
                                                            <a class="cn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            <a class="cn-title" href="">Vestibulum ante ipsum primis</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="cn-img">
                                                    <img src="img/cat-news-3.jpg" />
                                                    <div class="cn-content">
                                                        <div class="cn-content-inner">
                                                            <a class="cn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            <a class="cn-title" href="">Sed quis convallis lacus</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h2><i class="fas fa-align-justify"></i>Technology</h2>
                                        <div class="row cn-slider">
                                            <div class="col-md-6">
                                                <div class="cn-img">
                                                    <img src="img/cat-news-4.jpg" />
                                                    <div class="cn-content">
                                                        <div class="cn-content-inner">
                                                            <a class="cn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            <a class="cn-title" href="">Vivamus vel felis nec magna</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="cn-img">
                                                    <img src="img/cat-news-5.jpg" />
                                                    <div class="cn-content">
                                                        <div class="cn-content-inner">
                                                            <a class="cn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            <a class="cn-title" href="">Phasellus vitae fermentum est</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="cn-img">
                                                    <img src="img/cat-news-6.jpg" />
                                                    <div class="cn-content">
                                                        <div class="cn-content-inner">
                                                            <a class="cn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            <a class="cn-title" href="">Aenean ut varius dui</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Category News End-->


                        <!-- Footer Start -->
                        <div class="footer">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="footer-widget">
                                            <h3 class="title">Useful Links</h3>
                                            <ul>
                                                <li><a href="#">Pellentesque</a></li>
                                                <li><a href="#">Aliquam</a></li>
                                                <li><a href="#">Fusce placerat</a></li>
                                                <li><a href="#">Nulla hendrerit</a></li>
                                                <li><a href="#">Maecenas</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="footer-widget">
                                            <h3 class="title">Quick Links</h3>
                                            <ul>
                                                <li><a href="#">Posuere egestas</a></li>
                                                <li><a href="#">Sollicitudin</a></li>
                                                <li><a href="#">Luctus non</a></li>
                                                <li><a href="#">Duis tincidunt</a></li>
                                                <li><a href="#">Elementum</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="footer-widget">
                                            <h3 class="title">Get in Touch</h3>
                                            <div class="contact-info">
                                                <p><i class="fa fa-map-marker"></i>123 Terry Lane, New York, USA</p>
                                                <p><i class="fa fa-envelope"></i>email@example.com</p>
                                                <p><i class="fa fa-phone"></i>+123-456-7890</p>
                                                <div class="social">
                                                    <a href=""><i class="fab fa-twitter"></i></a>
                                                    <a href=""><i class="fab fa-facebook"></i></a>
                                                    <a href=""><i class="fab fa-linkedin"></i></a>
                                                    <a href=""><i class="fab fa-instagram"></i></a>
                                                    <a href=""><i class="fab fa-youtube"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-3 col-md-6">
                                        <div class="footer-widget">
                                            <h3 class="title">Newsletter</h3>
                                            <div class="newsletter">
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed porta dui. Class aptent taciti sociosqu ad litora torquent per conubia nostra inceptos
                                                </p>
                                                <form>
                                                    <input class="form-control" type="email" placeholder="Your email here">
                                                    <button class="btn">Submit</button>
                                                </form>
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
                                        <p>Copyright &copy; <a href="https://htmlcodex.com">HTML Codex</a>. All Rights Reserved</p>
                                    </div>

                                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                                    <div class="col-md-6 template-by">
                                        <p>Template By <a href="https://htmlcodex.com">HTML Codex</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Footer Bottom End -->




                <!-- Back to Top -->
                <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
       
       
    
            </div>
           
            </GeneralLayout>
    
    </template>