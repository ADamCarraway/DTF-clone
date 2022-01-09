/**
 * A simple forEach() implementation for Arrays, Objects and NodeLists
 * @private
 * @param {Array|Object|NodeList} collection Collection of items to iterate
 * @param {Function} callback Callback function for each iteration
 * @param {Array|Object|NodeList} scope Object/NodeList/Array that forEach is iterating over (aka `this`)
 */
export var forEach = function (collection, callback, scope) {
    if (Object.prototype.toString.call(collection) === '[object Object]') {
        for (var prop in collection) {
            if (Object.prototype.hasOwnProperty.call(collection, prop)) {
                callback.call(scope, collection[prop], prop, collection);
            }
        }
    } else {
        for (var i = 0, len = collection.length; i < len; i++) {
            callback.call(scope, collection[i], i, collection);
        }
    }
};

export function removeFromArray(array, element) {
    const index = array.indexOf(element);
    array.splice(index, 1);
}

export function editorParseToHtml(blocks, toFeed = false) {
    let html = '';
    let arrBlocks = JSON.parse(blocks);

    for (let i = 0, len = arrBlocks.length; i < len; i++) {
        let block = arrBlocks[i];
        let type = block.type;

        if (type === "image" && showInFeed(block, toFeed)) {
            let classNames = 'post-single-image';

            if (block.data.withBackground) {
                classNames += ' image-background l-island-b'
            }

            if (block.data.withBorder) {
                classNames += ' image-border'
            }

            html += '<figure>'

            html += '<div  class="' + classNames + '"><img src="' + block.data.file.url + '" alt=""/></div>'

            if (block.data.caption) {
                html += '<div class="l-island-a">\n' +
                    '            <figcaption class="content-image-caption">\n' +
                    '                                    <span class="content-image-caption__title">' + block.data.caption + '</span>\n' +
                    '                                            </figcaption>\n' +
                    '        </div>'
            }

            html += '</figure>';
        } else if (type === 'paragraph' && showInFeed(block, toFeed)) {
            html += '<div class="l-island-a">\n' +
                '    \n' +
                '        <p>' + block.data.text + '</p>\n' +
                '    </div>'
        } else if (type === 'header') {
            html += '<h' + block.data.level + '>'

            html += '<div class="l-island-a">' + block.data.text + '</div>'

            html += '</h' + block.data.level + '>'
        } else if (type === 'list' && showInFeed(block, toFeed)) {
            let className = block.data.style === 'ordered' ? 'ordered' : 'unordered';

            html += '<div class="l-island-a"><ul class="' + className + '">'

            for (let t = 0, lent = block.data.items.length; t < lent; t++) {
                html += '<li>' + block.data.items[t] + '</li>'
            }

            html += '</ul></div>'
        } else if (type === 'delimiter' && showInFeed(block, toFeed)) {
            html += '<div class="l-island-a">\n' +
                '        <div class="block-delimiter"></div>\n' +
                '    </div>'
        }
    }

    return html;
}

function showInFeed(block, status) {
    if (!status) return true;

    return block.tunes.ShowInFeed;
}