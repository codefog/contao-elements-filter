document.addEventListener('DOMContentLoaded', () => {
    function shouldShowElement(el, value) {
        // Multiple values
        if (Array.isArray(value)) {
            if (value.length === 0) {
                return true;
            }

            const elementValues = el.dataset.elementsFilter.split(',');

            return !value.some(v => !elementValues.includes(v));
        }

        // Single value
        if (!value) {
            return true;
        }

        return el.dataset.elementsFilter.split(',').includes(value);
    }

    function filterDefault(value, wrapper) {
        [...wrapper.children].forEach(el => shouldShowElement(el, value) ? el.classList.remove('invisible') : el.classList.add('invisible'));
    }

    function filterIsotope(value, isotope) {
        isotope.arrange({ filter: (index, el) => shouldShowElement(el, value) });
    }

    function initFilters(filters, handler, elementsWrapperInner, isotope) {
        filters.forEach(filter => {
            if (filter.dataset.elementsFilterValue === '') {
                filter.classList.add('active');
            }

            filter.addEventListener('click', e => {
                e.preventDefault();

                filters.forEach(el => (el === filter) ? el.classList.add('active') : el.classList.remove('active'));

                if (handler === 'isotope') {
                    filterIsotope(filter.dataset.elementsFilterValue, isotope);
                } else {
                    filterDefault(filter.dataset.elementsFilterValue, elementsWrapperInner);
                }
            });
        });
    }

    function initFiltersGrouped(filters, handler, elementsWrapperInner, isotope) {
        const filterItems = () => {
            const values = filters.filter(filter => !!filter.checked).map(filter => filter.value);

            if (handler === 'isotope') {
                filterIsotope(values, isotope);
            } else {
                filterDefault(values, elementsWrapperInner);
            }
        };

        filters.forEach(filter => {
            filter.addEventListener('change', () => {
                filters.forEach(el => (el === filter) ? el.parentElement.classList.add('active') : el.parentElement.classList.remove('active'));
                filterItems();
            });
        });
    }

    function init(filterContainer) {
        const elementsWrapper = document.getElementById(filterContainer.dataset.elementsFilterWrapper);
        const handler = filterContainer.dataset.elementsFilterHandler;

        if (!elementsWrapper || !handler) {
            return;
        }

        // Wrap content elements with another div
        const elementsWrapperInner = document.createElement('div');
        elementsWrapperInner.className = 'elements-filter-wrapper-inner';
        elementsWrapper.append(elementsWrapperInner);
        [...elementsWrapper.querySelectorAll('[data-elements-filter]')].forEach(el => elementsWrapperInner.append(el));

        let isotope;

        if (handler === 'isotope') {
            isotope = new window.Isotope(elementsWrapperInner, { itemSelector: '[data-elements-filter]' });
        }

        const filters = [...filterContainer.querySelectorAll('[data-elements-filter-value]')];

        if (filterContainer.hasAttribute('data-elements-filters-grouped')) {
            initFiltersGrouped(filters, handler, elementsWrapperInner, isotope);
        } else {
            initFilters(filters, handler, elementsWrapperInner, isotope);
        }
    }

    [...document.querySelectorAll('[data-elements-filter-wrapper]')].forEach(init);
});
