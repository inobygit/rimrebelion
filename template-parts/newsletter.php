<?php
/**
 * Funkcnost zaobstarava js v app.js
 * Do formu sa nastavuju classy podla toho co sa prave deje:
 *  - loading - ked prebieha request
 *  - success - ked uspesne prebehol
 *  - fail - ked to padlo tak sa prida class fail. po 5s sa automaticky odstrani
 */

// prettier-ignore
$gdpr_label = __("Súhlasim so", "rimrebelion") . " <a class='link gdpr-link privacy-policy-link' target='__blank' href='" . get_privacy_policy_url() . "'>" . __("spracovaním osobných údajov", "rimrebelion") . "</a> ";
$subscribe_label = __("Prihlásiť sa", "rimrebelion");
$form_id = uniqid("newsletter_form");
?>
<form id="<?= $form_id ?>" class="newsletter-form">
    <div class="overlay"></div>
    <div class="newsletter-inner-wrap">
        <div class="input-wrap">
            <label for="email" class="inplace-label"><?= __("Vaša e-mailová adresa", "rimrebelion") ?></label>
            <input type="email" class="input-text email" name="email"
                placeholder="<?= __("Vaša e-mailová adresa", "rimrebelion") ?>" autocomplete="email" required />
        </div>
    </div>
    <div class="gdpr-inner-wrap">
        <input id="gdpr" type="checkbox" class="input-checkbox gdpr" name="gdpr" required />
        <label for="gdpr"><span><?= $gdpr_label ?></span></label>
    </div>
    <div class="button-wrap">
        <button type="submit" class="button submit triangleright" name="subscribe_newsletter"
            value="<?= $subscribe_label ?>"><?= $subscribe_label ?></button>
    </div>
    <p class="message error-message">
        <?= __("Pri pokuse odoslať požiadavku nastala chyba. Prosím skúste to znovu.", "rimrebelion") ?></p>
    <p class="message success-message"><?= __("Ďakujeme za váš odber.", "rimrebelion") ?></p>
</form>