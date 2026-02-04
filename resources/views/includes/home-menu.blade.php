 <!-- Top Header Start -->
  <header class="text-white">
        <div class="container text-center">
            <div class=" img-fluid header_img"> 
                <img class="img-fluid" src="/images/logo_geekx_c.png" alt="AeraNerd Header">
            </div>
        </div>
    </header>
    <!-- 
        <div class="top-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4">
                        <div class="logo">
                            <a href="">
                                <img src="img/logo.png" alt="Logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-4">
                        <div class="search">
                            <input type="text" placeholder="Search">
                            <button><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
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
        </div>
        Top Header End -->


        <!-- Header Start -->
        <div class="header">
            
            <div class="container">
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <a href="#" class="navbar-brand"><img src="/images/mini_h.png" alt="AeraNerd Header"></a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav m-auto">
                            <a href="home" class="aMenu nav-item nav-link active ">Home</a>
                            
                            @foreach($categorias as $cat)
                                <a href="/{{ $cat['nome'] }}" class="aMenu nav-item nav-link">{{ $cat['nome'] }}</a>
                            @endforeach
                            <!-- <a href="index.html" class="aMenu nav-item nav-link active ">Home</a>
                            <a href="#" class="aMenu nav-item nav-link">Sports</a>
                            <a href="#" class="aMenu nav-item nav-link">Tech</a>
                            <a href="#" class="aMenu nav-item nav-link">Fashion</a>
                            <div class="aMenu nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                                <div class="dropdown-menu">
                                    <a href="#" class="dropdown-item">Sub Item 1</a>
                                    <a href="#" class="dropdown-item">Sub Item 2</a>
                                </div>
                            </div>
                            <a href="#" class="aMenu nav-item nav-link">Single Page</a>
                            <a href="contact.html" class="aMenu nav-item nav-link">Contact Us</a> -->
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Header End -->