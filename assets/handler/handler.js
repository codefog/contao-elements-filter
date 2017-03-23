(function ($) {
    function filterDefault(container, value) {
        container.fadeOut(function () {
            container.children().each(function () {
                var el = $(this);

                if (!value || el.hasClass(value)) {
                    el.show();
                } else {
                    el.hide();
                }
            });

            container.fadeIn();
        });
    }

    function filterIsotope(wrapper, value) {
        wrapper.isotope({
            filter: function () {
                return value ? $(this).hasClass(value) : true;
            }
        });
    }

    function init() {
        var filterContainer = $(this);
        var handler = filterContainer.data('handler');
        var elementsWrapper = $(filterContainer.data('elements'));

        if (elementsWrapper.length < 1) {
            console.error('The element containing elements does not exist: ' + filterContainer.data('elements'));
            return;
        }

        var elementsParent = elementsWrapper.find('.elements-filter').wrapAll('<div class="elements-filter-wrapper"/>').eq(0).parent();

        if (handler === 'isotope') {
            elementsParent.isotope({ itemSelector: '.elements-filter' });
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
                filterIsotope(elementsParent, value);
            } else {
                filterDefault(elementsParent, value);
            }
        });
    }

    $(document).ready(function () {
        $('[data-elements-filter]').each(init);
    });
})(jQuery);
