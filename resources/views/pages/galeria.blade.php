@extends('layouts.home')
@section('contentSection1')


<section >

    <style>.loader-ellips {
        font-size: 20px; /* change size here */
        position: relative;
        width: 4em;
        height: 1em;
        margin: 10px auto;
        }

        .loader-ellips__dot {
        display: block;
        width: 1em;
        height: 1em;
        border-radius: 0.5em;
        background: #555; /* change color here */
        position: absolute;
        animation-duration: 0.5s;
        animation-timing-function: ease;
        animation-iteration-count: infinite;
        }

        .loader-ellips__dot:nth-child(1),
        .loader-ellips__dot:nth-child(2) {
        left: 0;
        }
        .loader-ellips__dot:nth-child(3) { left: 1.5em; }
        .loader-ellips__dot:nth-child(4) { left: 3em; }

        @keyframes reveal {
        from { transform: scale(0.001); }
        to { transform: scale(1); }
        }

        @keyframes slide {
        to { transform: translateX(1.5em) }
        }

        .loader-ellips__dot:nth-child(1) {
        animation-name: reveal;
        }

        .loader-ellips__dot:nth-child(2),
        .loader-ellips__dot:nth-child(3) {
        animation-name: slide;
        }

        .loader-ellips__dot:nth-child(4) {
        animation-name: reveal;
        animation-direction: reverse;
        }
        
        .grid__col-sizer,
        .photo-item {
        width: 32%;
        }

        .grid__gutter-sizer {
        width: 2%;
        }

        .photo-item {
        margin-bottom: 10px;
        float: left;
        }

        .photo-item__image {
        display: block;
        max-width: 100%;
        }

        .photo-item__caption {
        position: absolute;
        left: 10px;
        bottom: 10px;
        margin: 0;
        }

        .photo-item__caption a {
        color: white;
        font-size: 0.8em;
        text-decoration: none;
        }

        .page-load-status {
        display: none; /* hidden by default */
        padding-top: 20px;
        border-top: 1px solid #DDD;
        text-align: center;
        color: #777;
        }

        /* loader ellips in separate pen CSS */


    </style>

    <div class="container" style="max-width:98%;">

        <div class="row">
                        <div class="col-md-4 col-sm-12" style="padding:10px; margin:0px; ">
                            @if($featuredImage)
                                <img class='img-fluid' src="{{ $featuredImage['vchr_arquivo_caminho'] ?? '' }}" alt="{{ $materia['vchr_titulo'] }}">
                            @else
                                <img class='img-fluid' src="{{ asset('/images/default-thumbnail.jpg') }}" alt="{{ $materia['vchr_titulo'] }}">
                            @endif
                        </div>

                        <div class="col-md-8 col-sm-12">
                            <div class="line"></div>
                            <h3 class="destaque_titulo" style="height:"><a href="#">{{$materia['vchr_titulo']}}</a></h3>
                            <h6 class="vid-name">{{$materia['vchr_lide']}}</h6>

                            <div class="info">
                                <h5>By <a href="#">{{$materia['vchr_autor']}}</a></h5>
                                <span><i class="fa fa-calendar"></i>{{ $materia['dt_post_formatted'] ?? $materia['dt_post'] }}</span>
                                <!-- <span><i class="fa fa-heart"></i>1,200</span> -->
                            </div>
                          <!--  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#disclaimerModal">
                                Sobre o uso e divulgação das imagens
                            </button> -->


                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2">
                        Sobre o uso e divulgação das imagens
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel2">Disclaimer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div style="margin-top: 20px; max-height:250px; overflow-x: hidden; overflow-y: scroll; ">
                                    
                                <p>
                                    <B>SOBRE O DIREITO DE EXIBIÇÂO E DIVULGAÇÂO DAS IMAGENS:</B><br>
                                    1 - AS FOTOS ABAIXO SÂO DE DIREITO e POSSE da organização do evento, estando o direito de veiculação diretamente ligada ao contrato de aceitação constante compra do ingresso e partipação do evento em questão.&nbsp;<br>
                                    2 - AS FOTOS ABAIXO tem caráter unica e exclusivamente de divulgação da arte COSPLAY e seus criadores bem como do evento em questão. Não sendo veículadas em hipotese nenhuma de forma comercial e/ou com outras finalidades!<br>
                                    3 - Todo material fotográfico coletado e&nbsp; primeiramente de direito das pessoas fotografadas, que em absoluta concordancia posaram para as mesmas , em segundo lugar do site www.aeranerd.com.br, em terceiro lugar dos idealizadores do evento em questão.<br>
                                    4 -&nbsp;AS FOTOS ABAIXO podem ser excluidas à qualquer momento, mediante solicitação das partes envolvidas, se por advento da divulgação causarem incomodo, transtorno social, constrangimento ou quaisquer motivos dos quais a pessoa retratada julgar pertimentes, nós nos disponibilizamos a faze-lo de bom grado e o mais imediatamente possível!<br>
                                    5 - AS FOTOS NÂO PODERÂO ser compartilhadas, copiadas, veiculadas em outros canais, ou redistribuidas em hipotese alguma!<br>
                                    6 - A edição das fotos é TERMINANTEMENTE proibida, bem como a retirada, desfoque ou corte da marca-d'agua e/ou assinatura do fotógrafo.<br>
                                    7 -&nbsp; Sendo o material coletado em evento e espaço publico e aberto, e do fato que todas as pessoas retratadas se dispuseram de forma completamente gratuita , é do entendimento que sua divulgação dentro dos limites acima descritos é realizada unica e exclusivamente para fins JORNALISTICOS, de forma análoga à celebridades em eventos de grande porte.<br>
                                    <br>
                                    Ficamos à disposição para contato e esclarecimentos em nossos canais de comunicação!<br>
                                    E imensamente agradecido por todos que se deixaram fotografar.<br>
                                    Viva à arte cosplay!<br>
                                    <br>
                                    &nbsp;</p>
        
                                    <h2><a href="https://www.jusbrasil.com.br/legislacao/1503907193/Constituicao-Federal-de-1988#art-5_inc-IX" title="Constituição Federal de 1988">Constituição Federal de 1988</a></h2>
        
                                    <p>Nós, representantes do povo brasileiro, reunidos em Assembléia Nacional Constituinte para instituir um Estado Democrático, destinado a assegurar o exercício dos direitos sociais e individuais, a liberdade, a segurança, o bem-estar, o desenvolvimento, a igualdade e a justiça como valores supremos de uma sociedade fraterna, pluralista e sem preconceitos, fundada na harmonia social e comprometida, na ordem interna e internacional, com a solução pacífica das controvérsias, promulgamos, sob a proteção de Deus, a seguinte CONSTITUIÇÃO DA REPÚBLICA FEDERATIVA DO BRASIL.</p>
        
                                    <p><strong>Art. 5º</strong>&nbsp;Todos são iguais perante a lei, sem distinção de qualquer natureza, garantindo-se aos brasileiros e aos estrangeiros residentes no País a inviolabilidade do direito à vida, à liberdade, à igualdade, à segurança e à propriedade, nos termos seguintes:</p>
        
                                    <p><strong>IX</strong>&nbsp;- é livre a expressão da atividade intelectual, artística, científica e de comunicação, independentemente de censura ou licença;<br>
                                    <br>
                                    <strong><a href="https://www.jusbrasil.com.br/topicos/10730738/inciso-ix-do-artigo-5-da-constituicao-federal-de-1988">https://www.jusbrasil.com.br/topicos/10730738/inciso-ix-do-artigo-5-da-constituicao-federal-de-1988</a></strong></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                            </div>
                        </div>
                        </div>

                            
                        </div>
        </div>
        
        <hr/>


        <div class="row">
        <div class="col-md-9 col-sm-12" style="padding:10px; margin:0px; ">
            <h1 class="headline2"> Confira a galeria de fotos abaixo</h1>
                <div class="grid">
                    <div class="grid__col-sizer"></div>
                    <div class="grid__gutter-sizer"></div>
                </div>

                <div class="page-load-status">
                    <div class="loader-ellips infinite-scroll-request">
                        <span class="loader-ellips__dot"></span>
                        <span class="loader-ellips__dot"></span>
                        <span class="loader-ellips__dot"></span>
                        <span class="loader-ellips__dot"></span>
                    </div>
                    <p class="infinite-scroll-last">End of content</p>
                    <p class="infinite-scroll-error">No more pages to load</p>
                </div>

            </div>
            <div class="col-md-3 col-sm-12" style="padding:10px; margin:0px; ">
          
                        <h1 class="headline2">Últimas</h1>

                        @if(isset($relatedArticles) && count($relatedArticles) > 0)
                            @foreach($relatedArticles as $article)
                                <div class="cols-sm-12" >
                                    <div class="row" >
                                        <div class="col-4" >
                                            @php
                                                $articleImage = null;
                                                if (isset($article['images']) && is_array($article['images'])) {
                                                    foreach ($article['images'] as $img) {
                                                        if ($img['vchr_Tipo'] === 'Materia_home_thumb') {
                                                            $articleImage = $img['vchr_arquivo_caminho'];
                                                            break;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <a href="{{ '/' . ($article['vchr_LinkTitulo'] ?? '#') }}" alt="">
                                                <img class="img-fluid" src="{{ $articleImage ?? asset('/images/default-thumb.jpg') }}" />
                                            </a>
                                        </div>
                                        <div class="col-6" >
                                            <a href="{{ '/' . ($article['vchr_LinkTitulo'] ?? '#') }}" alt="">
                                                <h6>{{ $article['vchr_titulo'] ?? '' }}</h6>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            @endforeach
                        @endif
            </div>
         </div>

         <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <img id="imgModal"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>

        
</div>
        
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
    <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>

    <script>
        // Galeria configuration from backend
        const galeriaConfig = {
            pastaS3: '{{ $galeria["pastaS3"] ?? "" }}',
            apiUrl: '{{ $galeria["apiUrl"] ?? "" }}',
            firstPageData: @json($galeria['firstPageData'] ?? null)
        };

        console.log('Galeria Config:', galeriaConfig);
        console.log('First Page Data:', galeriaConfig.firstPageData);

        let $grid = $('.grid').masonry({
            itemSelector: '.photo-item',
            columnWidth: '.grid__col-sizer',
            gutter: '.grid__gutter-sizer',
            percentPosition: true,
            stagger: 30,
            // nicer reveal transition
            visibleStyle: { transform: 'translateY(0)', opacity: 1 },
            hiddenStyle: { transform: 'translateY(100px)', opacity: 0 },
        });

        // Get Masonry instance
        var msnry = $grid.data('masonry');

        // Variable to track current page
        let currentPage = 1;
        let isLoading = false;

        // Load initial page with first page data from backend
        if (galeriaConfig.firstPageData && galeriaConfig.firstPageData.data) {
            console.log('Loading initial data from backend');
            const initialData = galeriaConfig.firstPageData.data;
            let itemsHTML = initialData.map(getItemHTML).join('');
            let $items = $(itemsHTML);
            
            $items.imagesLoaded(function() {
                $grid.append($items).masonry('appended', $items);
                console.log('Initial items loaded (Page 1), total items:', initialData.length);
                
                // Setup manual scroll detection
                setupScrollDetection();
            });
        }

        function setupScrollDetection() {
            console.log('Setting up scroll detection...');
            
            $(window).on('scroll', function() {
                if (isLoading) {
                    console.log('Already loading, skip');
                    return;
                }
                
                let scrollTop = $(window).scrollTop();
                let windowHeight = $(window).height();
                let documentHeight = $(document).height();
                let scrollBottom = documentHeight - (scrollTop + windowHeight);
                
                // Log scroll position every time
                console.log('Scroll position:', {
                    scrollTop: scrollTop,
                    windowHeight: windowHeight,
                    documentHeight: documentHeight,
                    scrollBottom: scrollBottom,
                    threshold: 300
                });
                
                // Load more when 300px from bottom
                if (scrollBottom < 300) {
                    console.log('Near bottom! Loading next page...');
                    loadNextPage();
                }
            });
        }

        function loadNextPage() {
            if (isLoading) {
                console.log('Already loading a page, skipping...');
                return;
            }
            
            isLoading = true;
            currentPage++;
            
            const proxyUrl = `/galeria-proxy/${galeriaConfig.pastaS3}/${currentPage}`;
            console.log(`Loading page ${currentPage} from ${proxyUrl}`);
            
            // Show loading indicator
            $('.page-load-status .infinite-scroll-request').show();
            
            $.ajax({
                url: proxyUrl,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(`Page ${currentPage} loaded successfully:`, response);
                    
                    // Hide loading indicator
                    $('.page-load-status .infinite-scroll-request').hide();
                    
                    // Check if response has data
                    if (!response || (!Array.isArray(response) && !response.data)) {
                        console.error('Invalid response format:', response);
                        $('.page-load-status .infinite-scroll-error').show();
                        isLoading = false;
                        return;
                    }
                    
                    const imagesData = response.data || response;
                    
                    if (!imagesData || imagesData.length === 0) {
                        console.log('No more images to load');
                        $('.page-load-status .infinite-scroll-last').show();
                        isLoading = false;
                        return;
                    }
                    
                    console.log(`Adding ${imagesData.length} new images to grid`);
                    
                    // Compile body data into HTML
                    let itemsHTML = imagesData.map(getItemHTML).join('');
                    let $items = $(itemsHTML);
                    
                    // Append items first
                    $grid.append($items);
                    
                    // Use native imagesLoaded to wait for images to load
                    imagesLoaded($items, function() {
                        // Tell Masonry new items have been added
                        $grid.masonry('appended', $items);
                        // Force layout recalculation
                        $grid.masonry('layout');
                        console.log(`Items from page ${currentPage} appended and laid out`);
                        isLoading = false;
                    });
                },
                error: function(xhr, status, error) {
                    console.error(`Error loading page ${currentPage}:`, error, xhr.responseText);
                    $('.page-load-status .infinite-scroll-request').hide();
                    $('.page-load-status .infinite-scroll-error').show();
                    isLoading = false;
                    currentPage--; // Rollback page counter
                }
            });
        }

        //------------------//

        function getItemHTML({ foto }) {
            return `<div class="photo-item">
                <img class="photo-item__image" src="${foto}" alt="Foto da Galeria" data-toggle="modal" data-target="#exampleModal" data-src="${foto}" onclick="setModalPhoto(this)" loading="lazy"/>
            </div>`;
        }

        function setModalPhoto(image) {
            var imageUrl = $(image).attr("data-src");
            
            $("#exampleModalLabel").html('{{ $materia["vchr_titulo"] ?? "" }}');
            $("#imgModal").attr('src', imageUrl);
            $("#imgModal").addClass('img-fluid');
            $("#imgModal").attr('alt', 'Foto: Bruno Kbelo');
        }
        
        // Prevent right-click on images
        document.addEventListener("contextmenu", function(e){
            if (e.target.nodeName === "IMG") {
                e.preventDefault();
            }
        }, false);
    </script>
</section>
@endsection
