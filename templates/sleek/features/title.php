<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Likewise for Metadatas, get the info from db(website CMS) of the menu if db is used,
    else if its not db(Simple Site, get it from bassket)
    Note that if its a webApp, metadata is not need-->



    <title><?CORE::componentTitle();?></title>


    <!--Links-->
    <link rel="stylesheet" href="<?=CDN;?>css/air.design.css">
    <link rel="stylesheet" href="<?=BaseUrl;?>templates/sleek/css/main.css">


    <link rel="stylesheet" href="<?=CDN;?>css/font-awesome.min.css">


    <!-- Component Styles -->
    <?CORE::componentStyle();?>


    <!--Favicon-->
    <link href="<?=CDN;?>images/logo/favicon.png" rel="icon" type="image/png"/>



</head>
<body>
  <base url='<?=BaseUrl;?>' />
