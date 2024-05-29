<?php
/**
 * Funkcnost zaobstarava js v app.ts
 * Do formu sa nastavuju classy podla toho co sa prave deje:
 *  - loading - ked prebieha request
 *  - success - ked uspesne prebehol
 *  - fail - ked to padlo tak sa prida class fail. po 5s sa automaticky odstrani
 */

// prettier-ignore
$heading = __("JOIN OUR COMMUNITY AND DON'T MISS A GREAT CHANCE", "rimrebelion");
$text = __("Explore uncharted paths and places with our latest collections and exclusive deals.", "rimrebelion");
$btn_text = mb_get_block_field("newsletter_btn_text");

$popup_check = mb_get_block_field("newsletter_popup_check");

$gdpr_label =
    __("Súhlasim so", "rimrebelion") .
    " <a class='link gdpr-link privacy-policy-link' href='" .
    get_privacy_policy_url() .
    "'>" .
    __("spracovaním osobných údajov", "rimrebelion") .
    "</a> " .
    __("na marketingové účely.", "rimrebelion");
$subscribe_label = __("Odoslať", "rimrebelion");
$form_id = uniqid("newsletter_form");
?>
<div
    <?= inoby_block_attrs($attributes, ["class" => "component-newsletter" . ($popup_check ? " newsletter-on-popup" : "")]) ?>>
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-12 newsletter-col">
                <div class="newsletter-box">
                    <div class="content-wrap">
                        <div class="content-text">
                            <?= isset($heading) ? '<h2 class="newsletter-heading">' . $heading . "</h2>" : ". __('test','rimrebelion') ." ?>
                            <?= isset($text) ? '<p class="newsletter-text">' . $text . "</p>" : "" ?>
                        </div>
                    </div>
                    <?php if ($popup_check == 1) { ?>
                    <div class="button-wrap">
                        <?php echo isset($btn_text) ? '<a href="#0" class="button triangleleft triangleright form-button">' . $btn_text . "</a>" : ""; ?>
                    </div>
                    <div class="newsletter-popup">
                        <div class="newsletter-wrap">
                            <div class="close-btn">✕</div>
                            <?php get_template_part("template-parts/newsletter"); ?>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="newsletter-wrap">
                        <?php get_template_part("template-parts/newsletter"); ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>