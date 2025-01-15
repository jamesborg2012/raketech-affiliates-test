<?php

$logoPath = plugin_dir_url(dirname(__FILE__, 3)) . 'assets/logo.jpg';

?>

<div class='single-operator-container' id=<?= $operator['operator'] ?>>
    <div class='operator-logo-container' style="background-color: <?= $operator['logo_bg_color'] ?>;">
        <img src="<?= $logoPath ?>" alt="Raketech" class="logo-image">
    </div>
    <div class='operator-content-container'>
        <div class='flex-container'>
            <div class='operator-contents operator-flex-column'>
                <p class='operator-name'><?= $operator['operator'] . ' ' . $operator['bonus_type'] ?></p>
                <p class='operator-amount'>
                    <strong><?= $operator['amount'] ?></strong>
                </p>
                <?php if (!empty($operator['promo_code'])): ?>
                    <div class='promo-code-container'>
                        <p class='promo-code-text'>
                            Exclusive with Raketech - use
                            <strong class='promo-code' data-promo=<?= $operator['promo_code'] ?>>
                                <?= $operator['promo_code'] ?>
                            </strong>
                            <i class="fa-solid fa-copy"></i>
                        </p>
                    </div>
                <?php endif; ?>
                <p class="terms-conditions">
                    Advertising link 18+. <a href='<?= $operator['terms_link'] ?>' target="_blank" class='terms-link'>Terms & Conditions</a> apply. Please play responsibly
                </p>
            </div>
            <div class='operator-buttons operator-flex-column desktop-display'>
                <a href='<?= $operator['affiliate_link'] ?>' target="_blank" class='affiliate-link button'>Visit</a>
                <a href='<?= $operator['permalink'] ?>' target="_blank" class='permalink button'>Review</a>
            </div>
            <div class="terms-conditions-mobile">
                Advertising link 18+. <a href='<?= $operator['terms_link'] ?>' target="_blank" class='terms-link'>Terms & Conditions</a> apply. Please play responsibly
            </div>
        </div>
    </div>
</div>