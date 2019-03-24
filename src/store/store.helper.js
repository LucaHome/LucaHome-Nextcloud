'use strict'

/**
 * Sorts array in specified order type
 *
 * @param {Array<T>} array The array to sort
 * @param {String} sortOrder The sorting order type
 * @param {Boolean} sortDirection The sorting direction
 * @returns {Array}
 */
function sort(array, sortOrder, sortDirection) {
    var comparator;

    switch (sortOrder) {
        default:
        case 'id':
            comparator = (x, y) => x.id - y.id;
            break;
        case 'name':
            comparator = (x, y) => x.name.toLowerCase().localeCompare(y.name.toLowerCase());
            break;
        case 'filter':
            comparator = (x, y) => x.filter.toLowerCase().localeCompare(y.filter.toLowerCase());
            break;
        case 'area':
            comparator = (x, y) => x.area.toLowerCase().localeCompare(y.area.toLowerCase());
            break;
        case 'code':
            comparator = (x, y) => x.code.toLowerCase().localeCompare(y.code.toLowerCase());
            break;
    }

    var sortedArray = array.sort((x, y) => comparator(x, y));
    return sortDirection ? sortedArray.reverse() : sortedArray;
}

export {
    sort
}