App = {
	start: function() {
		$collections = $('.collection a');

		$collections.bind('click', function() {
			$('.collection').removeClass('selected');
			$self = $(this);

			$('#main').load(this.href, null, function() {
				$self.parent().addClass('selected');
				$('#main > ul').tree();
			});
			return false;
		});
	},
	status: function() {
		$collections = $('.collection a');
		text = " collection" + ($collections.length == 1 ? "" : "s") + " in database";
		$('#footer .status').text($collections.length + text);
	},
	collections: {
		refresh: function() {
			$('#groups').load(location.toString(), {}, function() {
				App.start();
				App.status();
			});
		},
		add: function() {
			'<li class="collection"><input type="text" id="ColName" /></li>';
			$('#groups > ul').append();
		}
	}
};

$(document).ready(function() {

	$('.button-bar button').bind('mousedown', function() {
		$(this).toggleClass('pressed');
	}).bind('mouseup', function() {
		$(this).toggleClass('pressed');
	});

	$('#RefreshCollections').bind('click', function() {
		App.collections.refresh();
	});

	App.start();
	App.status();
});

jQuery.fn.tree = function(config) {
	$keys = jQuery(this).addClass('tree').find(".value ul").hide().parent().prev(".key");

	$keys.addClass("closed").bind('click', function() {
		$self = jQuery(this);
		$self.next('.value').find('> ul')[$self.hasClass('closed') ? 'show' : 'hide']();
		$self.toggleClass('closed').toggleClass('open');
	});

	jQuery(this).find('.value:not(:has(ul))').bind('click', function() {
		if ($(this).find('input').length > 0) {
			return true;
		}
		old = jQuery(this).text();
		$in = jQuery(this).html('<input type="text" class="edit" value="" />').find('input');

		$in.val(old).focus().bind('blur', function(e) {
			val = $(this).val();
			$node = $(this).parent();
			$(this).parent().text();

			mapper = function() { return encodeURIComponent($(this).text()); };
			path = $node.parents('ul').parent().prev('.key').map(mapper).toArray();
			path.push(encodeURIComponent($node.prev('.key').text()));
			path.shift();
			path = '/' + path.join('/');

			_id = $node.parents('.document').find('.key.id:first').next('.value').text();
			url = urls.edit.replace(':col', jQuery("#groups .selected a").text());
			url = url.replace(':args', encodeURIComponent(_id) + path);
			data = { data: val, old: old };

			$.post(url, data, function(text) {
				$node.html(text);
			});
		}).bind('keyDown', function(e) {
			if (e.keyCode == 32) {
				$(this).blur();
			}
			return true;
		})
	});
};
