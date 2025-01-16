<?php

$response = wp_remote_get(get_site_url(null, 'wp-json/operator-provider/v1/list?ordered=true'));
$operators = json_decode($response['body'], true);

$display_date = date('F Y');

$bonus_types = [];
foreach ($operators as $operator) {
	if (empty($operator['bonus_type'])):
		continue;
	endif;

	if (isset($bonus_types[$operator['bonus_type']])) {
		continue;
	}

	$bonus_types[$operator['bonus_type']] = $operator['bonus_type'];
}

sort($bonus_types);

?>
<div class="operators-list-block-container">
	<div class='title-container'>
		<strong>Best Betting Sites | <?= $display_date ?></strong>
	</div>
	<div class='operators-filter-container'>
		<h4 class="filter-message">Filter your sites to find a particular bonus or promo code of your liking</h4>
		<div class='operators-filter'>
			<div class='operators-promo-code-filter filter'>
				<label>
					<input type="checkbox" name='promo-code-filter' id='promo-code-filter' value='yes'>
					Show Promo Codes
				</label>
			</div>
			<div class='operators-bonus-type-filter filter'>
				<select name='bonus-type-filter' id='bonus-type-filter'>
					<option value="">No Bonus Chosen</option>
					<?php
					foreach ($bonus_types as $bonus_type):
					?>
						<option value="<?= $bonus_type ?>">
							<?= $bonus_type ?>
						</option>
					<?php
					endforeach; ?>
				</select>
			</div>
		</div>
		<div class="filter-button-container">
			<button class='filter-operators' type="button">Filter</button>
		</div>
	</div>
	<div class='operators-container'>
		<?php
		ob_start();
		if (empty($operators)):
			include(__DIR__ . '/views/single-operator-card.php');
		else:
			foreach ($operators as $operator):
				include(__DIR__ . '/views/single-operator-card.php');
			endforeach;
		endif;
		ob_get_contents();
		echo ob_get_clean(); ?>
	</div>
</div>