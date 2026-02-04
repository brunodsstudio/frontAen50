<script setup>
import { onMounted, ref } from 'vue'; // Correct import for onMounted
import { Head, Link} from '@inertiajs/vue3';
import GeneralLayout from '@/Layouts/GeneralLayout.vue';
import axios from 'axios';
//import Carousel from '@/Components/Carousel.vue';

const colors = [
    'indigo',
    'warning',
    'pink darken-2',
    'red lighten-1',
    'deep-purple accent-4',
  ]

const defaultSlides = [
    {
        image: 'images/eSporsSp.jpg',
        title: 'First slide label',
        description: 'Some representative placeholder content for the first slide.',
        date: '05-Feb-2020',
        link: ''
    },
    {
        image: 'images/eSporsSp.jpg',
        title: 'Second slide label',
        description: 'Some representative placeholder content for the second slide.',
        date: '05-Feb-2020',
        link: ''
    },
    {
        image: 'images/eSporsSp.jpg',
        title: 'Third slide label',
        description: 'Some representative placeholder content for the third slide.',
        date: '05-Feb-2020',
        link: ''
    }
]

const slides = ref(defaultSlides)
const headerBanners = ref([]);
const categorias = ref([]);
const cosplay = ref([]);
const windowWidth = ref(window.innerWidth)

const apiUrl = import.meta.env.VITE_API_URL || 'http://127.0.0.1:3001/api';

const fetchMateriasHome = async () => {
    try {
        
        const response = await axios.get(`${apiUrl}/MateriasHome`);
        const materias = response.data;
        
        if (materias && materias.length > 0) {
            const carouselData = materias.slice(0, 3).map(materia => {
                // Encontrar a imagem com vchr_Tipo = "Materia_home_thumb"
                const thumbImage =  materia.images[0]

            
                return {
                    image: thumbImage?.vchr_HRef || 'images/eSporsSp.jpg',
                    title: materia.vchr_titulo || 'Sem título',
                    description: materia.vchr_Resumo || materia.txt_Conteudo || null,
                    date: materia.dt_post || materia.created_at || '',
                    link: `${materia.vchr_LinkTitulo || materia.id}`,
                    id: materia.int_MateriaId || materia.id
                };
            });

            const headerBannersData = materias.slice(3, 7).map(materia => {
                const thumbImage =  materia.images[0]
                
            
                return {
                    image: thumbImage?.vchr_HRef || 'images/eSporsSp.jpg',
                    title: materia.vchr_titulo || 'Sem título',
                    description: materia.vchr_Resumo || materia.txt_Conteudo || null,
                    date: materia.dt_post || materia.created_at || '',
                    link: `${materia.vchr_LinkTitulo || materia.id}`,
                    id: materia.int_MateriaId || materia.id
                };
            });
           
            headerBanners.value = headerBannersData;
            slides.value = carouselData.length > 0 ? carouselData : defaultSlides;
            

        }
    } catch (error) {
        console.error('Erro ao carregar matérias:', error);
        // Mantém os slides padrão em caso de erro
        slides.value = defaultSlides;
    }
};

const fetchCategorias = async () => {
    try {

        const response = await axios.get(`${apiUrl}/areas?page=1&perPage=20`);
        const areas = response.data;
        
        if (areas && areas.length > 0) {
            // Filtrar: excluir type="pasta" e menu=0
            const filtradas = areas.filter(area => {
                
                return area.type !== 'pasta' && area.menu !== 0;
            });
            
            categorias.value = filtradas;
        }
    } catch (error) {
        console.error('Erro ao carregar categorias:', error);
        categorias.value = [];
    }
};

const fetchCosplay = async () => {
    try {

        const response = await axios.get(`${apiUrl}/MateriasCategoria?id_area=11&page=1&perPage=3&orderBy=created_at&orderDirection=desc`);
        const cosplays = response.data;
        
        if (cosplays && cosplays.length > 0) {
            cosplay.value = cosplays;
        }
    } catch (error) {
        console.error('Erro ao carregar categorias de cosplay:', error);
        cosplay.value = [];
    }
};

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
    
    // Buscar matérias ao montar o componente
    fetchMateriasHome();
    
    // Buscar categorias ao montar o componente
    fetchCategorias();
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
                                        :key="slide.id || i"
                                        >
                                        <v-sheet
                                            :color="colors[i % colors.length]"
                                            height="100%"
                                        >
                                            <div class="d-flex fill-height justify-center align-center">
                                            <div class="text-h2">
                                               <Link :href="slide.link">
                                                   <img :src="slide.image" class="d-block w-100" :alt="slide.title">
                                               </Link>
                                                <div class="carousel-caption d-none d-md-block">
                                                    <Link :href="slide.link"> <h5 class="tn-title">{{ slide.title }}</h5></Link>
                                                    <p v-if="slide.description">{{ slide.description }}</p>
                                                   
                                                </div>
                                            </div>
                                            </div>
                                        </v-sheet>
                                        </v-carousel-item>
                                    </v-carousel>
                                    </div>
                                   
                                    <div class="col-md-6 tn-right">
                                        <div class="row gx-1">
                                            <div class="col-md-6 col-sm-2" v-for="(headerBanner, i) in headerBanners" :key="headerBanner.id || i" >
                                                <div class="tn-img">
                                                      <Link :href="headerBanner.link">
                                                        <img :src="headerBanner.image" class="d-block w-100" :alt="headerBanner.title">
                                                     </Link>
                                                    <div class="tn-content">
                                                        <div class="tn-content-inner">
                                                        <!--     <i class="far fa-clock"></i>{{ headerBanner.date }} -->
                                                            <a class="tn-title" :href="headerBanner.link">{{ headerBanner.title }}</a>
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
                                        <h2><i class="fas fa-align-justify"></i>Destaques</h2>
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
                                        <h2><i class="fas fa-align-justify"></i>Cosplay</h2>
                                        <div class="row cn-slider">
                                            <div class="col-md-6">
                                                <div class="cn-img" v-for="cosplays in cosplay" :key="cosplays.id">
                                                    <img src="img/cat-news-4.jpg" />
                                                    <div class="cn-content">
                                                        <div class="cn-content-inner">
                                                            <a class="cn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            <a class="cn-title" href="">Vivamus vel felis nec magna</a>
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


                        <!-- Main News Start-->
                        <div class="main-news">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h2><i class="fas fa-align-justify"></i>Ultimas Notícias</h2>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mn-img">
                                                            <img src="img/latest-news.jpg" />
                                                        </div>
                                                        <div class="mn-content">
                                                            <a class="mn-title" href="">Cras commodo sem ut porta laoreet</a>
                                                            <a class="mn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            <p>
                                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed porta dui. Class aptent taciti sociosqu ad litora torquent per conubia nostra inceptos...
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mn-list">
                                                            <div class="mn-img">
                                                                <img src="img/latest-news.jpg" />
                                                            </div>
                                                            <div class="mn-content">
                                                                <a class="mn-title" href="">Pellentesque sit amet rutrum lacus</a>
                                                                <a class="mn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            </div>
                                                        </div>
                                                        <div class="mn-list">
                                                            <div class="mn-img">
                                                                <img src="img/latest-news.jpg" />
                                                            </div>
                                                            <div class="mn-content">
                                                                <a class="mn-title" href="">Proin id pretium orci, quis rhoncus eros</a>
                                                                <a class="mn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            </div>
                                                        </div>
                                                        <div class="mn-list">
                                                            <div class="mn-img">
                                                                <img src="img/latest-news.jpg" />
                                                            </div>
                                                            <div class="mn-content">
                                                                <a class="mn-title" href="">Curabitur viverra scelerisque tempor</a>
                                                                <a class="mn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            </div>
                                                        </div>
                                                        <div class="mn-list">
                                                            <div class="mn-img">
                                                                <img src="img/latest-news.jpg" />
                                                            </div>
                                                            <div class="mn-content">
                                                                <a class="mn-title" href="">Integer nec lorem facilisis interdum lorem non</a>
                                                                <a class="mn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            </div>
                                                        </div>
                                                        <div class="mn-list">
                                                            <div class="mn-img">
                                                                <img src="img/latest-news.jpg" />
                                                            </div>
                                                            <div class="mn-content">
                                                                <a class="mn-title" href="">Interdum et malesuada fames</a>
                                                                <a class="mn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <h2><i class="fas fa-align-justify"></i>Popular</h2>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mn-img">
                                                            <img src="img/popular-news.jpg" />
                                                        </div>
                                                        <div class="mn-content">
                                                            <a class="mn-title" href="">Phasellus gravida metus vitae laoreet aliquam</a>
                                                            <a class="mn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            <p>
                                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed porta dui. Class aptent taciti sociosqu ad litora torquent per conubia nostra inceptos...
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mn-list">
                                                            <div class="mn-img">
                                                                <img src="img/popular-news.jpg" />
                                                            </div>
                                                            <div class="mn-content">
                                                                <a class="mn-title" href="">Nullam risus ante sempe</a>
                                                                <a class="mn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            </div>
                                                        </div>
                                                        <div class="mn-list">
                                                            <div class="mn-img">
                                                                <img src="img/popular-news.jpg" />
                                                            </div>
                                                            <div class="mn-content">
                                                                <a class="mn-title" href="">Pellentesque ultrices quam id ipsum tempor</a>
                                                                <a class="mn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            </div>
                                                        </div>
                                                        <div class="mn-list">
                                                            <div class="mn-img">
                                                                <img src="img/popular-news.jpg" />
                                                            </div>
                                                            <div class="mn-content">
                                                                <a class="mn-title" href="">Nam ex magna, commodo sed turpis rutrum</a>
                                                                <a class="mn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            </div>
                                                        </div>
                                                        <div class="mn-list">
                                                            <div class="mn-img">
                                                                <img src="img/popular-news.jpg" />
                                                            </div>
                                                            <div class="mn-content">
                                                                <a class="mn-title" href="">Aliquam condimentum metus</a>
                                                                <a class="mn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            </div>
                                                        </div>
                                                        <div class="mn-list">
                                                            <div class="mn-img">
                                                                <img src="img/popular-news.jpg" />
                                                            </div>
                                                            <div class="mn-content">
                                                                <a class="mn-title" href="">Ut ornare rutrum ligula erat volutpat</a>
                                                                <a class="mn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="sidebar">
                                            <div class="sidebar-widget">
                                                <h2><i class="fas fa-align-justify"></i>Categorias</h2>
                                                <div class="category">
                                                    <ul class="fa-ul">
                                                        <li v-for="categoria in categorias" :key="categoria.id">
                                                            <span class="fa-li"><i class="far fa-arrow-alt-circle-right"></i></span>
                                                            <Link :href="`/categoria/${categoria.id}`">{{ categoria.nome }}</Link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="sidebar-widget">
                                                <h2><i class="fas fa-align-justify"></i>Tags</h2>
                                                <div class="tags">
                                                    <a href="">National</a>
                                                    <a href="">International</a>
                                                    <a href="">Economics</a>
                                                    <a href="">Politics</a>
                                                    <a href="">Lifestyle</a>
                                                    <a href="">Technology</a>
                                                    <a href="">Trades</a>
                                                    <a href="">National</a>
                                                    <a href="">International</a>
                                                    <a href="">Economics</a>
                                                    <a href="">Politics</a>
                                                    <a href="">Lifestyle</a>
                                                    <a href="">Technology</a>
                                                    <a href="">Trades</a>
                                                </div>
                                            </div>

                                            <div class="sidebar-widget">
                                                <h2><i class="fas fa-align-justify"></i>Ads 1 column</h2>
                                                <div class="image">
                                                    <a href=""><img src="img/adds-1.jpg" alt="Image"></a>
                                                </div>
                                            </div>

                                            <div class="sidebar-widget">
                                                <h2><i class="fas fa-align-justify"></i>Ads 2 column</h2>
                                                <div class="image">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <a href=""><img src="img/adds-2.jpg" alt="Image"></a>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <a href=""><img src="img/adds-2.jpg" alt="Image"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Main News End-->


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