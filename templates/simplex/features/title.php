<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Likewise for Metadatas, get the info from db(website CMS) of the menu if db is used,
    else if its not db(Simple Site, get it from bassket)
    Note that if its a webApp, metadata is not need-->

    <!--Write a logic for the title-->
    <!--First check if its db(Website CMS), if yes, then get the title of the page from the DB,
    Else get the title of the Page from the $url-->

    <?php
      $legacy = CORE::getInstance('Legacy');
      if(isset($legacy->routerPath['title'])){
        $title=$legacy->routerPath['title'];
      }else{
        if(isset($_GET['url'])){

          $url = explode('/',(rtrim(strtolower($_GET['url']),'/')));
          $title = ucfirst($url[0]);
          for( $i=1; $i<count($url); $i++){
            $title.='->'.ucfirst($url[$i]);
          }

        }else{
          $title="Home";
        }
      }

    ?>
    <title><?=$title;?></title>


    <!--Links-->
    <link rel="stylesheet" href="<?=BaseUrl;?>libraries/design/css/air.design.css">
    <link rel="stylesheet" href="<?=BaseUrl;?>templates/simplex/css/main.css">


    <link rel="stylesheet" href="<?=BaseUrl;?>libraries/design/css/font-awesome.min.css">


    <!-- Component Styles -->
    <?php
    if(!AirJax){
      
      if(isset($legacy->style)){
        echo '<style>'.$legacy->style.'</style>';
      }elseif(isset($legacy->styleUrls)){
        for($i =0; $i < count($legacy->styleUrls); $i++){
          echo '<link rel="stylesheet" href="'.BaseUrl.'components/'.$legacy->styleUrls[$i].'">';
        }
      }

    }
    ?>


    <!--Favicon-->
    <link href="<?=BaseUrl;?>media/images/logo/favicon.png" rel="icon" type="image/png"/>



</head>
<body>
  <base url='<?=BaseUrl;?>' />
