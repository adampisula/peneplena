<?php

    get_header();

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

    $id = $_GET["page_id"]; 
    $post = get_post($id); 
    $content = apply_filters('the_content', $post->post_content);

    $paragraphs = explode("\n", $content);


    for($i = 1; $i <= count($paragraphs) / 6 - 1; $i++) {
        array_splice($paragraphs, $i * 6 + ($i - 1), 0, array("<div class='ad ad_content'></div>"));
    }

    $content = implode('<br />', $paragraphs);

?>

<body>
    <div class="loading">
        <div class="lds-dual-ring"></div>
    </div>

    <!--IMPORTS-->
    <link href="<?php bloginfo('template_url'); ?>/css/home.css" rel="stylesheet" />
    <link href="<?php bloginfo('template_url'); ?>/css/fonts.css" rel="stylesheet" />
    <link href="<?php bloginfo('template_url'); ?>/css/page.css" rel="stylesheet" />
    <script src="<?php bloginfo('template_url'); ?>/js/functions.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>
    
    <script>
        $("<img />").attr("src", "<?php background(); ?>").on("load", function() {
            $(this).remove();
            getAverageColor("<?php background(); ?>", function(color) {
                $("body").css("background", "rgb(" + color + ")");
                
                var cArray = color.split(",");
                var cHex = "#";

                for(var i = 0; i < cArray.length; i++)
                    cHex += parseInt(cArray[i]).toString(16);

                $("head").append("<meta name='theme-color' content='" + cHex + "'>");
                
                getImageLightness("<?php background(); ?>", 0, function(brightness) {
                    if(brightness >= 185)
                        $(".menu_narrow").addClass("black");
                });
            });
            
            $(".container").ready(function() {
                setTimeout(function() {
                    if($(".container").height() > $(window).height())
                        $(".scroll_up").css("display", "block");
                    
                    $(".loading").fadeOut(350);
                }, 250);
                
                $(".scroll_up").on("click", function() {
                    $('html,body').animate({ scrollTop: 0 }, 'fast');
                    return false; 
                });
            });
        });
    </script>

    <div class="container">
        <a href="<?php echo esc_url(home_url('/')); ?>"><div class="back">←</div></a>
        <p class="title"><?php echo get_the_title(); ?></p>
        <span class="content"><?php echo $content; ?></span>
    </div>

    <script>
        //ADS
        $(window).on("resize load", function() {
            if($(".container").width() >= 740) {
                $(".ad_content").removeClass("ad_largerectangle");
                $(".ad_content").removeClass("ad_rectangle");
                $(".ad_content").addClass("ad_popunder");
            }

            else if ($(".container").width() >= 380) {
                $(".ad_content").removeClass("ad_popunder");
                $(".ad_content").removeClass("ad_rectangle");
                $(".ad_content").addClass("ad_largerectangle");
            }

            else {
                $(".ad_content").removeClass("ad_popunder");
                $(".ad_content").removeClass("ad_largerectangle");
                $(".ad_content").addClass("ad_rectangle");
            }

            if($(".container").offset().left >= 280) {
                if($(window).height() >= 440) {
                    if(!$(".ad_side").hasClass("ad_verticalrectangle")) {
                        console.log("ad_verticalrectangle");

                        $(".ad_side").remove();
                        $("body").append("<div class='ad ad_side ad_left ad_verticalrectangle'></div>");
                        $("body").append("<div class='ad ad_side ad_right ad_verticalrectangle'></div>");
                    }
                }
            }

            else if($(".container").offset().left >= 200) {
                if($(window).height() >= 640) {
                    if(!$(".ad_side").hasClass("ad_wideskyscraper")) {
                        console.log("ad_wideskyscraper");

                        $(".ad_side").remove();
                        $("body").append("<div class='ad ad_side ad_left ad_wideskyscraper'></div>");
                        $("body").append("<div class='ad ad_side ad_right ad_wideskyscraper'></div>");
                    }
                }
            }

            else if($(".container").offset().left >= 160) {
                if($(window).height() >= 640) {
                    if(!$(".ad_side").hasClass("ad_skyscraper")) {
                        console.log("ad_skyscraper");

                        $(".ad_side").remove();
                        $("body").append("<div class='ad ad_side ad_left ad_skyscraper'></div>");
                        $("body").append("<div class='ad ad_side ad_right ad_skyscraper'></div>");
                    }
                }

                else if($(window).height() >= 280) {
                    if(!$(".ad_side").hasClass("ad_verticalbanner")) {
                        console.log("ad_verticalbanner");

                        $(".ad_side").remove();
                        $("body").append("<div class='ad ad_side ad_left ad_verticalbanner'></div>");
                        $("body").append("<div class='ad ad_side ad_right ad_verticalbanner'></div>");
                    }
                }
            }

            else
                $(".ad_side").remove();

            var d = ($(".container").offset().left - $(".ad_side").width()) / 2;

            $(".ad_left").css("left", d);
            $(".ad_right").css("right", d);
        });
    </script>
    <div class="scroll_up">↑</div>
    <div class="menu_narrow"><?php wp_nav_menu(array("depth" => 1)); ?></div>
</body>

<?php get_footer(); ?>
