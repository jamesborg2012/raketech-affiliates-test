jQuery(document).ready(function ($) {
	$('.filter-operators').click(function (e) {
		e.preventDefault()
		$filterPromo = $(document).find('#promo-code-filter').is(':checked')
			? 'yes'
			: 'no'
		$bonusType = $(document).find('#bonus-type-filter').val()

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxObj.ajaxUrl,
			data: {
				action: 'filter_operators',
				filter_promo: $filterPromo,
				bonus_type: $bonusType
			},
			success: function (result) {
				if (result.success) {
					$opContainer = $(document).find('.operators-container')
					$opContainer.empty().html(result.data.result)
				}
			}
		})
	})

	$(document).on('click touchend', '.promo-code-text', function (e) {
		e.preventDefault()

		$promoCode = $(this).find('.promo-code').attr('data-promo')

		if (navigator.clipboard) {
			navigator.clipboard.writeText($promoCode).then(() => {
				alert('Promo Code ' + $promoCode + ' copied to clipboard')
			})
		} else {
			// Use the 'out of viewport hidden text area' trick
			const textArea = document.createElement('textarea')
			textArea.value = $promoCode

			// Move textarea out of the viewport so it's not visible
			textArea.style.position = 'absolute'
			textArea.style.left = '-999999px'

			document.body.prepend(textArea)
			textArea.select()

			try {
				//Using this method as an alternative when no https is available
				document.execCommand('copy')
			} catch (error) {
				console.error(error)
			} finally {
				textArea.remove()
			}
		}
	})
})
