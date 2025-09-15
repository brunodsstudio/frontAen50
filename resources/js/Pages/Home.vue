<script setup>
import { onMounted, ref } from 'vue'; // Correct import for onMounted
import { Head, Link} from '@inertiajs/vue3';
import GeneralLayout from '@/Layouts/GeneralLayout.vue';
//import Carousel from '@/Components/Carousel.vue';

const colors = [
    'indigo',
    'warning',
    'pink darken-2',
    'red lighten-1',
    'deep-purple accent-4',
  ]
  const slides = [
    'First',
    'Second',
    'Third',
    'Fourth',
    'Fifth',
  ]

  const windowWidth = ref(window.innerWidth)

  

onMounted(() => {
    let slider = 300;
    if (windowWidth.value > 1200) {
        slider = 700;
    } else if (windowWidth.value > 960){
         slider = 400;
    } else if (windowWidth.value > 780){
        slider = 300;
    } else {
        slider = 200;
    }
    const sliderHeight = slider;
});

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
                                   

                                    <v-carousel
                                        height={{sliderHeight}}
                                        show-arrows="hover"
                                        cycle
                                        hide-delimiter-background
                                    >
                                        <v-carousel-item
                                        v-for="(slide, i) in slides"
                                        :key="i"
                                        >
                                        <v-sheet
                                            :color="colors[i]"
                                            height="100%"
                                        >
                                            <div class="d-flex fill-height justify-center align-center">
                                            <div class="text-h2">
                                               <img src="images/eSporsSp.jpg" class="d-block w-100" alt="...">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <h5>First slide label</h5>
                                                    <p>Some representative placeholder content for the first slide.</p>
                                                </div>
                                            </div>
                                            </div>
                                        </v-sheet>
                                        </v-carousel-item>
                                    </v-carousel>
                                    </div>
                                   
                                    <div class="col-md-6 tn-right">
                                        <div class="row gx-1">
                                            <div class="col-md-6 col-sm-2" >
                                                <div class="tn-img">
                                                    <img src="images/eSporsSp.jpg" class="d-block w-100" alt="...">
                                                    <div class="tn-content">
                                                        <div class="tn-content-inner">
                                                            <a class="tn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            <a class="tn-title" href="">Integer faucibus pharetra odio</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-2">
                                                <div class="tn-img">
                                                     <img src="images/eSporsSp.jpg" class="d-block w-100" alt="...">
                                                    <div class="tn-content">
                                                        <div class="tn-content-inner">
                                                            <a class="tn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            <a class="tn-title" href="">Nulla vitae pharetra ligula</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
           
                                            <div class="col-md-6 col-sm-2">
                                                <div class="tn-img">
                                                     <img src="images/eSporsSp.jpg" class="d-block w-100" alt="...">
                                                    <div class="tn-content">
                                                        <div class="tn-content-inner">
                                                            <a class="tn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            <a class="tn-title" href="">Ut ac euismod tellus a blandit</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-2">
                                                <div class="tn-img">
                                                     <img src="images/eSporsSp.jpg" class="d-block w-100" alt="...">
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