document.addEventListener('DOMContentLoaded', () => {
    function shouldShowElement(el, value) {
        if (!value) {
            return true;
        }

        return el.dataset.elementsFilter.split(',').includes(value);
    }

    function filterDefault(wrapper, value) {
        [...wrapper.children].forEach(el => shouldShowElement(el, value) ? el.classList.remove('invisible') : el.classList.add('invisible'));
    }

    function filterIsotope(value, isotope) {
        isotope.arrange({ filter: (index, el) => shouldShowElement(el, value) });
    }

    function init(filterContainer) {
        const elementsWrapper = document.getElementById(filterContainer.dataset.elementsFilterWrapper);
        const handler = filterContainer.dataset.elementsFilterHandler;

        if (!elementsWrapper || !handler) {
            return;
        }

        const elementsWrapperInner = document.createElement('div');
        elementsWrapperInner.className = 'elements-filter-wrapper-inner';
        elementsWrapper.append(elementsWrapperInner);
        [...elementsWrapper.querySelectorAll('[data-elements-filter]')].forEach(el => elementsWrapperInner.append(el));

        let isotope;

        if (handler === 'isotope') {
            isotope = new window.Isotope(elementsWrapperInner, { itemSelector: '[data-elements-filter]' });
        }

        const filters = [...filterContainer.querySelectorAll('a')];

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
                    filterDefault(elementsWrapperInner, filter.dataset.elementsFilterValue);
                }
            });
        });
    }

    [...document.querySelectorAll('[data-elements-filter-wrapper]')].forEach(init);
});
