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

?>

<body>
    <div class="loading">
        <div class="lds-dual-ring"></div>
    </div>

    <!--IMPORTS-->
    <link href="<?php bloginfo('template_url'); ?>/css/home.css" rel="stylesheet" />
    <link href="<?php bloginfo('template_url'); ?>/css/fonts.css" rel="stylesheet" />
    <link href="<?php bloginfo('template_url'); ?>/css/posts.css" rel="stylesheet" />
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

            setTimeout(function() {
                $(".loading").fadeOut(350);
                
                if($(".container").height() > $(window).height())
                    $(".scroll_up").css("display", "block");

                $(".scroll_up").on("click", function() {
                    $('html,body').animate({ scrollTop: 0 }, 'fast');
                    return false; 
                });
            }, 250);
        });
    </script>

    <div class="container">
        <a href='<?php echo esc_url(home_url('/')); ?>'><div class='back'>←</div></a>
        <?php
            
            if(have_posts()):
                while(have_posts()): the_post();
        ?>
                    <div class="post">
                        <a href="<?php echo get_permalink(get_the_ID()); ?>" class='guid'><p class="post_title"><?php the_title(); ?></p></a>
                        <span class='post_meta'>
                            <p class='post_date'><b>D</b><?php echo get_the_date("Y-m-d"); ?></p>
                                |
                            <p class='post_author'><b>A</b><?php the_author(); ?></p>
                        </span>
                        <span class="post_content"><?php the_content("... <i>czytaj dalej...</i>"); ?></span>
                    </div>
        <?php    
                endwhile;
        
                echo "<div class='navigate'>".paginate_links(array("prev_next" => false))."</div>";
        
            else:
                echo "<p>Niestety nic tu nie ma :c</p>";
            endif;
        
        ?>
    </div>
    <div class="menu_narrow"><?php wp_nav_menu(array("depth" => 1)); ?></div>
    <div class="scroll_up">↑</div>
    
    <div id="temp-posts" style="display: none;"></div>
</body>

<?php get_footer(); ?>