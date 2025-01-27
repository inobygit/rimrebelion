<?php 
    $club_popup_show = rwmb_meta('club_popup_show', ["object_type" => "setting"], 'options');

if (!is_user_logged_in() && !empty($club_popup_show) && $club_popup_show) { 
    $club_popup_image = rwmb_meta('club_popup_image', ["object_type" => "setting"], 'options');
    $club_popup_logo = rwmb_meta('club_popup_logo', ["object_type" => "setting"], 'options');
    $club_popup_benefits = rwmb_meta('club_popup_benefits', ["object_type" => "setting"], 'options');
    $club_popup_heading_last = rwmb_meta('club_popup_heading_last', ["object_type" => "setting"], 'options');
    $club_popup_desc_last = rwmb_meta('club_popup_desc_last', ["object_type" => "setting"], 'options');
    $club_popup_coupon = rwmb_meta('club_popup_coupon', ["object_type" => "setting"], 'options');
    ?>


<div class="club-popup">
    <div class="club-popup-wrapper">
        <div class="popup-step step-1 active">

            <div class="popup-content">
                <?php if(!empty($club_popup_image)) {
                    mb_inoby_picture($club_popup_image, 'o-6');
                }?>
                <div class="popup-text">
                    <span class="close-popup">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M26 0H0V26H26V0Z" fill="black" />
                            <path d="M7.15002 8.25002L8.25002 7.15002L18.85 17.75L17.75 18.85L7.15002 8.25002Z"
                                fill="white" />
                            <path d="M17.75 7.15002L18.85 8.25002L8.25002 18.85L7.15002 17.75L17.75 7.15002Z"
                                fill="white" />
                        </svg>

                    </span>
                    <?php if(!empty($club_popup_logo)) {
                        mb_inoby_picture($club_popup_logo, 'o-6');
                    }?>
                    <?php if(!empty($club_popup_benefits)) {
                        foreach($club_popup_benefits as $benefit) { ?>
                    <p class="benefit">
                        <?= $benefit ?>
                    </p>
                    <?php } } ?>
                    <button
                        class="next-step button triangleBoth black"><?= __("Join the club", 'rimrebellion') ?></button>
                </div>
            </div>
        </div>
        <div class="popup-step step-2">

            <div class="popup-content">
                <?php if(!empty($club_popup_image)) {
                    mb_inoby_picture($club_popup_image, 'o-6');
                }?>
                <div class="popup-text">
                    <span class="close-popup">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M26 0H0V26H26V0Z" fill="black" />
                            <path d="M7.15002 8.25002L8.25002 7.15002L18.85 17.75L17.75 18.85L7.15002 8.25002Z"
                                fill="white" />
                            <path d="M17.75 7.15002L18.85 8.25002L8.25002 18.85L7.15002 17.75L17.75 7.15002Z"
                                fill="white" />
                        </svg>

                    </span>
                    <?php echo do_shortcode('[xoo_el_inline_form forms="register" active="register" pattern="separate" navstyle="disable" register_redirect="same"]'); ?>
                </div>
            </div>
        </div>
        <div class="popup-step step-3">

            <div class="popup-content">
                <?php if(!empty($club_popup_image)) {
                    mb_inoby_picture($club_popup_image, 'o-6');
                }?>
                <div class="popup-text">
                    <span class="close-popup">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M26 0H0V26H26V0Z" fill="black" />
                            <path d="M7.15002 8.25002L8.25002 7.15002L18.85 17.75L17.75 18.85L7.15002 8.25002Z"
                                fill="white" />
                            <path d="M17.75 7.15002L18.85 8.25002L8.25002 18.85L7.15002 17.75L17.75 7.15002Z"
                                fill="white" />
                        </svg>

                    </span>
                    <?php if(!empty($club_popup_heading_last)) { ?>
                    <h2><?= $club_popup_heading_last ?></h2>
                    <?php } ?>
                    <?php if(!empty($club_popup_desc_last)) { ?>
                    <p><?= $club_popup_desc_last ?></p>
                    <?php } ?>
                    <?php if(!empty($club_popup_coupon)) { ?>
                    <div class="coupon">
                        <div class="message">
                            <?= __("Coupon was successfully copied to your clipboard", 'inoby') ?>
                        </div>
                        <p class="coupon-code">
                            <?= $club_popup_coupon ?>
                        </p>
                        <span class="copy">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M6 11C6 8.17157 6 6.75736 6.87868 5.87868C7.75736 5 9.17157 5 12 5H15C17.8284 5 19.2426 5 20.1213 5.87868C21 6.75736 21 8.17157 21 11V16C21 18.8284 21 20.2426 20.1213 21.1213C19.2426 22 17.8284 22 15 22H12C9.17157 22 7.75736 22 6.87868 21.1213C6 20.2426 6 18.8284 6 16V11Z"
                                        stroke="#000000" stroke-width="1.5"></path>
                                    <path
                                        d="M6 19C4.34315 19 3 17.6569 3 16V10C3 6.22876 3 4.34315 4.17157 3.17157C5.34315 2 7.22876 2 11 2H15C16.6569 2 18 3.34315 18 5"
                                        stroke="#000000" stroke-width="1.5"></path>
                                </g>
                            </svg>
                        </span>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } ?>