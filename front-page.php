<?php

    function background($print = true, $pad = true) {
        $path = get_template_directory()."/img/backgrounds/";
        $files = scandir($path);
        $files = array_diff(scandir($path), array(".", ".."));

        //PICTURE A DAY
        if($pad) {
            if(!$print)
                return get_bloginfo('template_url').'/img/backgrounds/'.(string) ((int) date("z") % count($files) + 1).".jpg";
        
            echo get_bloginfo('template_url').'/img/backgrounds/'.(string) (((int) date("z") + 0) % count($files) + 1).".jpg";
            return;
        }

        //RANDOM
        if(!$print)
            return get_bloginfo('template_url').'/img/backgrounds/'.(string) mt_rand(1, count($files)).".jpg";

        echo get_bloginfo('template_url').'/img/backgrounds/'.(string) mt_rand(1, count($files)).".jpg";
    }

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo("charset"); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <title><?php bloginfo("name"); ?></title>
        <link href="<?php bloginfo('template_url'); ?>/css/loading.css" rel="stylesheet" />
        <?php

            wp_head();

        ?>
    </head>
    <body>
        <div class="loading">
            <div class="lds-dual-ring"></div>
        </div>

        <!--IMPORTS-->
        <link href="<?php bloginfo('template_url'); ?>/css/home.css" rel="stylesheet" />
        <link href="<?php bloginfo('template_url'); ?>/css/fonts.css" rel="stylesheet" />
        <script src="<?php bloginfo('template_url'); ?>/js/functions.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script>
            $("<img />").attr("src", "<?php background(); ?>").on("load", function() {
                $(this).remove();
                $("body").css("background", "url(<?php background(); ?>) no-repeat center center fixed");
                $("body").css("background-size", "cover");
                
                getImageLightness("<?php background(); ?>", 0, function(brightness) {
                    if(brightness >= 185)
                        $(".site-title, .home ul li a, .kherut-logo, .kherut-logo div, .kherut-logo div a").addClass("black");
                });
                
                getAverageColor("<?php background(); ?>", function(color) {
                    $(".menu ul li a").css("background", "rgba(" + color + ",0.55)");
                    
                    var cArray = color.split(",");
                    var cHex = "#";
                    
                    for(var i = 0; i < cArray.length; i++)
                        cHex += parseInt(cArray[i]).toString(16);
                    
                    $("head").append("<meta name='theme-color' content='" + cHex + "'>");
                });
                
                setTimeout(function() {
                    $(".loading").fadeOut(350);
                }, 250);
            });
        </script>
        <div class="home">
            <h1 class="site-title"><?php bloginfo("name"); ?></h1>
            <img class="site-logo" src="<?php bloginfo('template_url'); ?>/img/logo.png" />
            <?php wp_nav_menu(array("depth" => 1)); ?>
        </div>
        <!--<div class="kherut-logo">
            <img src="<?php bloginfo('template_url'); ?>/img/kherut_logo.png" alt="Kherut.io" title="Kherut.io" />
            <div>
                <a href="https://kherut.github.io/">kherut.github.io</a>
            </div>
        </div>-->
    </body>
</html>
