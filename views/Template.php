<html>
    <head>
        <meta charset="utf-8"/>        
        <link rel="stylesheet" href="<?=URL?>/css/style.css">
		<link rel="stylesheet" href="<?=URL?>/css/font-awesome.min.css">
        <title><?= $t;?></title>
    </head>
    <body class="supressPadding supressMargin overflowHidden">
        <div class="main baseView">
            <header class="header">
                <div class="flexColumns space-evenly" style ="width:141px;padding-left:10px">
                    <div class="aligntextCenter">
                        <p class="supressMargin" ><a style="color:white;text-decoration: none;" href="<?=URL;?>"><?=$siteName?></a></p>
                    </div>
                </div> 
                <div class="flexColumns space-evenly alignItemsCenter">
                    <div class="flexRow space-evenly">
                        <?php
                            $_topBar = "";
                            if($isLogged){
                                $_topBar.= '<button onclick="location.href=\''.URL.'management\';">
                                                Gestion
                                            </button>';
                                
                                
                                    
                            }
                            echo $_topBar;
                        ?>
                        
                    </div>   
                </div>   
                <div class="flexColumns space-around alignItemsCenter" style=" font-size:110%;width:141px;">
                    <?=$isLogged?'<p style="margin:0;"><a style="color:white;text-decoration: none;" href="'.URL.'login/logout">deconnecter</a></p>' : '<p style="margin:0;"><a style="color:white;text-decoration: none;" href="'.URL.'login">connexion</a></p>';?>
                </div>
            </header>    
            <nav  class="gridX8 correctMe Max1900 overflowScroll" style="margin: auto;">
                    
                <div  class="gridX8-2-7 fullHauteur" style="background-color:#0000005c; color:white;">

                    <?= $content;?>
                </div>
            </nav>
            <footer class="fullLarger aligntextCenter" style='color:white;background-color: #535151b0;padding: 5px;'>
                <p>Créer par Julien Bruel</p>
            </footer>
        </div>
    </body>     
</html>