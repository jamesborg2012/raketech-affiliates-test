<?php

$response = wp_remote_get(get_site_url(null, 'wp-json/operator-provider/v1/list?ordered=true'));
$operators = json_decode($response['body'], true);

$display_date = date('F Y');

?>
<div class="operators-list-block-container">
	<div class='title-container'>
		<strong>Best Betting Sites | <?= $display_date ?></strong>
	</div>
	<div class='operators-filter-container'>
		<strong>Filter the operators list!</strong>
		<div class='operators-filter'>
			<div class='operators-promo-code-filter'>
				<label>
					<input type="checkbox" name='promo-code-filter' id='promo-code-filter' value='yes'>
					Show operators with a promo code only
				</label>
			</div>
			<div class='operators-bonus-type-filter'>
				<select name='bonus-type-filter' id='bonus-type-filter'>
					<option value="">Select bonus type</option>
					<?php
					foreach ($operators as $operator):
						if (empty($operator['bonus_type'])):
							continue;
						endif;
					?>
						<option value="<?= $operator['bonus_type'] ?>">
							<?= $operator['bonus_type'] ?>
						</option>
					<?php
					endforeach; ?>
				</select>
			</div>
			<div class="filter-button-container">
				<button class='filter-operators' type="button">Filter your Toplist</button>
			</div>
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