<?php
namespace App\Helpers;

//use App\Classes\MenuClass;

class HeaderHelper {

    public $_defaultHeader;
    private $_meta = array();
    private $_title;
    private $_description;
    public $_aCss = array();
    public $_aJs = array();



    public function __construct($url = null) {

        $this->_meta = array(
            "charset" => "utf8",
            "compatible" => array("http-equiv" => "X-UA-Compatible", "content" => "IE=edge"),
            "viewport" => array("name" => "viewport", "content" => "width=device-width, initial-scale=1"),

            "autor" => array("name" => "autor", "content" => "Bruno de Lima")
        );
    }

   

     public function getHeader($header = null) {
        $this->_defaultHeader = '

           <title>' . $this->_title . '</title>

               '.$this->getMetaTag().'
               '. $this->printCss(). '



             <link rel="apple-touch-icon" sizes="57x57" href="images/apple-icon-57x57.png">
            <link rel="apple-touch-icon" sizes="60x60" href="images/apple-icon-60x60.png">
            <link rel="apple-touch-icon" sizes="72x72" href="images/apple-icon-72x72.png">
            <link rel="apple-touch-icon" sizes="76x76" href="images/apple-icon-76x76.png">
            <link rel="apple-touch-icon" sizes="114x114" href="images/apple-icon-114x114.png">
            <link rel="apple-touch-icon" sizes="120x120" href="images/apple-icon-120x120.png">
            <link rel="apple-touch-icon" sizes="144x144" href="images/apple-icon-144x144.png">
            <link rel="apple-touch-icon" sizes="152x152" href="images/apple-icon-152x152.png">
            <link rel="apple-touch-icon" sizes="180x180" href="images/apple-icon-180x180.png">
            <link rel="icon" type="image/png" sizes="192x192"  href="images/android-icon-192x192.png">
            <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
            <link rel="icon" type="image/png" sizes="96x96" href="images/favicon-96x96.png">
            <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">

            <meta name="msapplication-TileColor" content="#ffffff">
            <meta name="msapplication-TileImage" content="images/ms-icon-144x144.png">
            <meta name="theme-color" content="#ffffff">
            <meta name="google-site-verification" content="mi7p4wnU5Us4FgxiwSoPWYuoRKXV-9ch19Kw55ZVd5s" />	    
            <meta name="msvalidate.01" content="C3867D82CA332AA808CB35D0E2AC47A3" />
            <meta name="facebook-domain-verification" content="usyrqubde4smd7p17nfph6hwhca0q0" />
            <meta name="csrf-token" content="'.csrf_token().'" />



            <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,900" rel="stylesheet"> -->
             <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                   <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
        
            <link href="https://fonts.googleapis.com/css2?family=Kdam+Thmor+Pro&display=swap" rel="stylesheet">

            <!-- HTML5 Shim and Respond.
            js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
            <!--[if lt IE 9]> -->
            <script src = "js/html5shiv.js"></script>
            <script src="js/respond.min.js"></script>

           
            <![endif]-->

             <link href="lib/slick/slick.css" rel="stylesheet">
            <link href="lib/slick/slick-theme.css" rel="stylesheet">
            <link href="css/style.css" rel="stylesheet">

           ';
        //<link rel="manifest" href="'.asset('/').'"images/manifest.json">
            return $this->_defaultHeader;
    }

    public function addArrayMeta($val) {
        array_push($this->_meta, $val);
    }

    public function setMetaTag($key, $val) {
        $this->_metas[$key] = $val;
    }

    public function setTitle($val) {
        $this->_title = $val;
    }

    public function setDescription($val) {
        $this->_description = $val;
    }

    public function getMetaTag() {
        $metas = "";
        foreach ($this->_meta as $k => $m) {
            if (is_array($m)) {
                $metas .= "<meta ";
                foreach ($m as $k_ => $m_) {
                    $metas .= $k_ . " = \"" . $m_ . "\" ";
                }
                $metas .= ">";
            } else {
                $metas .= "<meta " . $k . "= \"" . $m . "\">";
            }
        }
        return $metas;
    }

    public function loadJs($aJs) {

        if (is_array($aJs)) {
            foreach ($aJs as $js) {
                array_push($this->_aJs, '<script type="text/javascript" src="js/' . $js . '"></script>');
            }
        }
    }

    public function loadJsFullPath($aJs) {

        if (is_array($aJs)) {
            foreach ($aJs as $js) {
                array_push($this->_aJs, '<script type="text/javascript" src="' . $js . '"></script>');
            }
        }
    }

    public function loadCss($aCss) {

        if (is_array($aCss)) {
            foreach ($aCss as $css) {
                array_push($this->_aCss, '<link rel="stylesheet" href="css/' . $css . '" type="text/css" >');
            }
        }
    }

    public function loadCssFullPath($aCss) {

        if (is_array($aCss)) {
            foreach ($aCss as $css) {
                array_push($this->_aCss, '<link rel="stylesheet" href="' . $css . '" type="text/css" >');
            }
        }
    }

    public function printJs() {
        foreach ($this->_aJs as $j) {
            echo $j . "\n";
        }
    }

    public function GetJs() {
        $strJs= "";
        foreach ($this->_aJs as $j) {
            $strJs .= $j . "\n";
        }
        return $strJs;
    }

    public function printCss() {
        foreach ($this->_aCss as $c) {
            echo $c . "\n";
        }
    }

    public function setFBTags(){

    }

    public function getAdSense(){
       $var = '';
	/* <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- home_h -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:970px;height:90px"
                     data-ad-client="ca-pub-4395511758091442"
                     data-ad-slot="1821368857"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script> */
        return $var;
    }

 /*   public function geraMenuJson(){
        $menu = new MenuClass();

        return response()->json([
            'data' => $menu->buildMenu()
        ]);
    }


    public function geraMenu(){
        $menu = new MenuClass();
        return $menu->buildMenu();
  
    }*/



}
