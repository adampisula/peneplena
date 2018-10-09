<?php

    $parse_uri = explode('wp-content', $_SERVER["SCRIPT_FILENAME"]);
    require_once($parse_uri[0].'wp-load.php');

    if(have_posts()):
        while(have_posts()) : the_post();
?>

        <div class="post">
            <a href="<?php get_permalink($post->ID)?>" class='guid'><p class='post_title'>".$post->post_title."</p></a>
        </div>

<?php

    endwhile;

?>

<?php
    /*function formatPosts($posts) {
        $ret = "";

        foreach($posts as $post) {
            $content_arr = get_extended($post->post_content);

            $ret .= "<div class='post'>";
            $ret .= "<a href='".get_permalink($post->ID)."' class='guid'><p class='post_title'>".$post->post_title."</p></a>";
            $ret .= "<span class='post_meta'><p class='post_date'><b>D</b>".explode(" ", $post->post_date)[0]."</p> | ";
            $ret .= "<p class='post_author'><b>A</b>".get_the_author_meta("display_name", $post->post_author)."</p></span>";
            $ret .= "<p class='post_content'>".$content_arr["main"];

            if(strlen($post->post_content) > $content_arr["main"])
                $ret .= "... <a href='".get_permalink($post->ID)."' class='read_more'><i>czytaj dalej</i></a>";
            
            $ret .= "</p>";

            $ret .= "</div>";
        }

        $ret = str_replace("<div class=\"box full single\">", "", $ret);

        return $ret;
    }

    echo formatPosts(get_posts());*/

?>