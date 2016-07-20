jQuery(function($) {
	$(document).ready(function() {
		$('.sqw-tab-select').click(function() {
			if (!$(this).hasClass('sqw-tab-active')) {
				$('.sqw-tab-select').toggleClass('sqw-tab-active');
				$('.sqw-form').toggle();
			}
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
			$('.' + $(this).attr('name')).toggle(200);
			$(this).toggleClass('sqw-tack-basic-check');
			$(this).toggleClass('sqw-' + $(this).data('color'));
			if (!$(this).hasClass('sqw-tack-basic-check')) {
				clean('.' + $(this).attr('name'));
			}
		});

		$('.sqw-tack-big').click(function() {
			$('.sqw-' + $(this).attr('name') + '-body').toggle(200);
			var valid = 1;
			var value = $('.sqw-' + $(this).attr('name') + '-input').val();
			if (value == 1) {
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
				return (1);
			}
			return (0);
		}

		function checkPassword(pass) {
			if (pass.length >= 8) {
				return (1);
			}
			return (0);
		}

		$('.sqw-form input[type=text], input[type=password]').keyup(function() {
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
					valid = (checkPassword($(this).val()) && $(this).val() === $('.sqw-form input[name=sqw-password]').val());
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
			$('.sqw-btn-link').text($(this).val());
		});
	});
});