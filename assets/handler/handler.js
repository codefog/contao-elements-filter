(function ($) {
    function filterDefault(elementsContainer, value) {
        elementsContainer.fadeOut(function () {
            elementsContainer.children().each(function () {
                var el = $(this);

                if (!value || el.hasClass(value)) {
                    el.show();
                } else {
                    el.hide();
                }
            });

            elementsContainer.fadeIn();
        });
    }

    function filterIsotope(elementsContainer, value) {
        elementsContainer.isotope({
            filter: function () {
                return value ? $(this).hasClass(value) : true;
            }
        });
    }

    function init() {
        var filterContainer = $(this);
        var handler = filterContainer.data('handler');
        var elementsContainer = $(filterContainer.data('elements'));

        if (elementsContainer.length < 1) {
            console.error('The element containing elements does not exist: ' + filterContainer.data('elements'));
            return;
        }

        if (handler === 'isotope') {
            elementsContainer.isotope();
        }

        var filters = filterContainer.find('a');

        filters.on('click', function (e) {
            e.preventDefault();

            var filter = $(this);
            var value = filter.data('filter');

            if (value) {
                value = 'elements-filter-' + value;
            }

            filters.removeClass('active');
            filter.addClass('active');

            if (handler === 'isotope') {
                filterIsotope(elementsContainer, value);
            } else {
                filterDefault(elementsContainer, value);
            }
        });
    }

    $(document).ready(function () {
        $('[data-elements-filter]').each(init);
    });
})(jQuery);
