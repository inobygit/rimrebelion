<?php
$quote_text = mb_get_block_field("component_quotes_quote_text");

$autor_name = mb_get_block_field("component_quotes_name");
$autor_desc = mb_get_block_field("component_quotes_autor_desc");
$autor_img = mb_get_block_field("component_quotes_autor_img");

if ($quote_text) { ?>
<section <?= inoby_block_attrs($attributes, ["class" => "component-quote"]) ?>>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="quote-wrap">
                    <?php
          echo isset($quote_text) ? '<blockquote class="quote-text">' . $quote_text . "</blockquote>" : "";
          echo '<div class="autor-wrap">';
          if ($autor_img) {
          echo '<div class="autor-avatar">';
            echo isset($autor_img) ? mb_inoby_picture($autor_img, "s-2") : "";
            echo "</div>";
          }
          echo '<div class="autor-info">';
          echo isset($autor_name) ? '<p class="autor-name">' . $autor_name . "</p>" : "";
          echo isset($autor_desc) ? '<p class="autor-desc">' . $autor_desc . "</p>" : "";
          echo "</div>";
          echo "</div>";
          ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php }