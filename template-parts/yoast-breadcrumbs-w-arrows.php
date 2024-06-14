<nav class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <?php if (function_exists("yoast_breadcrumb")) {
        yoast_breadcrumb('<p id="breadcrumbs">', "</p>");
      } ?>
            </div>
            <div class="col-6 end">
                <div class="prev-next">
                    <?php $prev_post = get_previous_post(true, '', 'look-gender');
                    $next_post = get_next_post(true, '', 'look-gender');
                  if($next_post) { ?>
                    <div class="prev-post">
                        <a href="<?= get_permalink($next_post->ID) ?>" class="button">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.4 3.825L15.825 2.25L6 12L15.675 21.75L17.325 20.175L9.15 12L17.4 3.825Z"
                                    fill="white" />
                            </svg>

                        </a>
                    </div>
                    <?php } if($prev_post) { ?>
                    <div class="next-post">
                        <a href="<?= get_permalink($prev_post->ID) ?>" class="button">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.925 12L6.75 3.825L8.325 2.25L18.15 12L8.4 21.75L6.825 20.175L14.925 12Z"
                                    fill="white" />
                            </svg>

                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</nav>