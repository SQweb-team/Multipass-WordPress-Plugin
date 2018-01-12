jQuery(function($) {
	$(document).ready(function() {
		$('.sqw-tab-select').click(function() {
			if (!$(this).hasClass('sqw-tab-active')) {
				$('.sqw-tab-select').toggleClass('sqw-tab-active');
				$('.sqw-form').toggle();
			}
		});

		var multipass_button_lang = {
										'fr':'Premium avec Multipass',
										'en':'Premium with Multipass',
										'es':'Premium con Multipass'
									};

		var multipass_punch_line = {
										'fr':'Lecture Illimitée • Zéro Pub',
										'en':'Unrestricted Access • No Ads',
									};

		function change_lang_button(lang) {
			$('.sqw-btn-mp-link-tiny-none').html(multipass_button_lang[lang]);
			$('#sqw-punch-line').html(multipass_punch_line[lang]);
		}

		change_lang_button($('.sqw-input-select').val());

		$('.sqw-input-select').change(function() {
			change_lang_button($(this).val());
		});

		$('#sqw-previ-select').change(function() {
			$('.sqweb-button').removeClass().addClass('sqweb-button multipass-'+$(this).val());
		});

		function clean(elem) {
			$(elem).find('input').each(function() {
				if ($(this).attr('type') === 'checkbox') {
					$(this).prop('checked', false);
				} else {
					$(this).val('');
				}
			});
		}

		$('.sqw-tack-basic').click(function() {
			if ($(this).attr('name') === 'sqw_display_support' && !$(this).hasClass('sqw-green')) {
				$('.sqw-support-button-preview').removeClass('sqw-hide');
			} else if ($(this).attr('name') === 'sqw_display_support' && $(this).hasClass('sqw-green')) {
				$('.sqw-support-button-preview').addClass('sqw-hide');
			}

			$('.' + $(this).attr('name')).toggle(200);
			$(this).toggleClass('sqw-tack-basic-check');
			$(this).toggleClass('sqw-' + $(this).data('color'));
			if ($(this).data('color') === 'red') {
				$('.sqw-textarea').val(adb_default_message);
			} else {
				$('.sqw-textarea').val('');
			}
			if (!$(this).hasClass('sqw-tack-basic-check')) {
				clean('.' + $(this).attr('name'));
			}
		});

		$('.sqw-tack-big').click(function() {
			$('.sqw-' + $(this).attr('name') + '-body').toggle(200);
			var valid = 1;
			var value = $('.sqw-' + $(this).attr('name') + '-input').val();
			if (value === 1) {
				valid = 0;
			}
			$('.sqw-' + $(this).attr('name') + '-input').val(valid);
			$('.sqw-title-' + $(this).attr('name')).toggleClass('sqw-title-'+ $(this).attr('name') +'-color');
			$(this).toggleClass('sqw-tack-big-check');
			$(this).toggleClass('sqw-' + $(this).data('color'));
			if (!$(this).hasClass('sqw-tack-big-check')) {
				clean('.sqw-' + $(this).attr('name') + '-body');
			}
		});

		function checkMail(mail) {
			if (mail.match(/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/)) {
				return 1;
			}
			return 0;
		}

		function checkPassword(pass) {
			if (pass.length >= 8) {
				return 1;
			}
			return 0;
		}

		$('.sqw-form input[type=text], input[type=email], input[type=password]').keyup(function() {
			var valid = 1;
			switch ($(this).attr('name')) {
				case 'sqw-emailc':
					valid = checkMail($(this).val());
					break;

				case 'sqw-passwordc':
					valid = checkPassword($(this).val());
					break;

				case 'sqw-email':
					valid = checkMail($(this).val());
					break;

				case 'sqw-password':
					valid = checkPassword($(this).val());
					break;

				case 'sqw-confirmp':
					valid = checkPassword($(this).val()) && $(this).val() === $('.sqw-form input[name=sqw-password]').val();
					break;
			}
			if (valid) {
				$(this).removeClass('sqw-form-red');
				$(this).addClass('sqw-form-green');
			} else {
				$(this).removeClass('sqw-form-green');
				$(this).addClass('sqw-form-red');
			}
		});

		function resize(elem) {
			$(elem).height('36px');
			$(elem).height($(elem).prop('scrollHeight')+'px');
		}

		resize($('.sqw-textarea'));

		$('.sqw-textarea').keyup(function() {
			resize(this);
		});

		$('.sqw-radio').click(function() {
			$('.sqweb-button').removeClass('sqweb-grey').removeClass('sqweb-blue').addClass('sqweb-'+$(this).val());
		});

		$('#sqw-login-msg, #sqw-logout-msg').keyup(function() {
			$('.sqw-btn-mp-link').text($(this).val());
		});

		$('#sqw_filter_all').click(function() {
			if ($('#sqw_filter_all').attr('checked') !== undefined ) {
				$('.categories_inputs').attr('disabled', true);
				$('div[name="sqw-fading-art"]').addClass('sqw-tack-basic-check sqw-green');
				$('.sqw-fading-art').css('display', 'block');
				$('input[name="perctart"]').val(25);
			} else {
				$('.categories_inputs').attr('disabled', false);
			}
		});

		$('#sqw_display_support_trigger').click(function() {
			if ($('#sqw_display_support').val() == 1) {
				$('#sqw_display_support').val(0);
			} else {
				$('#sqw_display_support').val(1);
			}
		});

		$('#sqw_autologin_trigger').click(function() {
			if ($('#sqw_autologin').val() == 1) {
				$('#sqw_autologin').val(0);
			} else {
				$('#sqw_autologin').val(1);
			}
		});
	});
});