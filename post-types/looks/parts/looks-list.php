<?php
  echo apply_filters("inoby_looks_list_before", "<div class=\"row\">");

  $posts_args = [
    "post_type" => "looks",
    "posts_per_page" => get_option("posts_per_page"),
    'post_status' => 'publish',
    "orderby" => "date",
    "order" => "desc",
    'offset'  => Inoby_Config::latest_posts(),
  ];
  $posts_query = new WP_Query($posts_args);
  if ($posts_query->have_posts()):
    $posts_query_index = 0;
    while ($posts_query->have_posts()):
      $posts_query->the_post();
      echo apply_filters("inoby_looks_list_card_before", "<div class=\"col-3 col-md-6 col-sm-12\">");
      get_template_part("post-types/looks/parts/card", null, ["post" => $post]);
      echo apply_filters("inoby_looks_list_card_after", "</div>");
      do_action("posts_query_loop", $posts_query_index);
      $posts_query_index++;
    endwhile;
  endif;
  ?>
<div id="load-more-posts"></div>
<?php echo apply_filters("inoby_looks_list_after", "</div>");