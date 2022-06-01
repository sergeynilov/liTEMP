
function makeSlug(text) { // https://overcoder.net/q/4004526/javascript-slug-%D1%80%D0%B0%D0%B1%D0%BE%D1%82%D0%B0%D0%B5%D1%82-%D0%B8-%D0%B4%D0%BB%D1%8F-%D0%BD%D0%B5%D0%BB%D0%B0%D1%82%D0%B8%D0%BD%D1%81%D0%BA%D0%B8%D1%85-%D1%81%D0%B8%D0%BC%D0%B2%D0%BE%D0%BB%D0%BE%D0%B2

    text = text.toString().toLowerCase().trim();

    const sets = [
        {to: 'a', from: '[ÀÁÂÃÄÅÆĀĂĄẠẢẤẦẨẪẬẮẰẲẴẶἀ]'},
        {to: 'c', from: '[ÇĆĈČ]'},
        {to: 'd', from: '[ÐĎĐÞ]'},
        {to: 'e', from: '[ÈÉÊËĒĔĖĘĚẸẺẼẾỀỂỄỆ]'},
        {to: 'g', from: '[ĜĞĢǴ]'},
        {to: 'h', from: '[ĤḦ]'},
        {to: 'i', from: '[ÌÍÎÏĨĪĮİỈỊ]'},
        {to: 'j', from: '[Ĵ]'},
        {to: 'ij', from: '[Ĳ]'},
        {to: 'k', from: '[Ķ]'},
        {to: 'l', from: '[ĹĻĽŁ]'},
        {to: 'm', from: '[Ḿ]'},
        {to: 'n', from: '[ÑŃŅŇ]'},
        {to: 'o', from: '[ÒÓÔÕÖØŌŎŐỌỎỐỒỔỖỘỚỜỞỠỢǪǬƠ]'},
        {to: 'oe', from: '[Œ]'},
        {to: 'p', from: '[ṕ]'},
        {to: 'r', from: '[ŔŖŘ]'},
        {to: 's', from: '[ßŚŜŞŠȘ]'},
        {to: 't', from: '[ŢŤ]'},
        {to: 'u', from: '[ÙÚÛÜŨŪŬŮŰŲỤỦỨỪỬỮỰƯ]'},
        {to: 'w', from: '[ẂŴẀẄ]'},
        {to: 'x', from: '[ẍ]'},
        {to: 'y', from: '[ÝŶŸỲỴỶỸ]'},
        {to: 'z', from: '[ŹŻŽ]'},
        {to: '-', from: '[·/_,:;\']'}
    ];

    sets.forEach(set => {
        text = text.replace(new RegExp(set.from,'gi'), set.to)
    });

    return text
        .replace(/\s+/g, '-')    // Replace spaces with -
        .replace(/[^-a-zа-я\u0370-\u03ff\u1f00-\u1fff]+/g, '') // Remove all non-word chars
        .replace(/--+/g, '-')    // Replace multiple - with single -
        .replace(/^-+/, '')      // Trim - from start of text
        .replace(/-+$/, '')      // Trim - from end of text
}

/*
function makeSlug(string) {
    return string.toString().toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '');
}
*/

function makeConvertToSlug(srcField, dstField) {

    var srcValue = $('#' + srcField).val()
    if (typeof srcValue == undefined) return
    srcValue= convertToSlug(srcValue)
    // console.log('+++srcValue::')
    // console.log(srcValue)
    $("#"+dstField).val(srcValue);
}

function convertToSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/[^\w ]+/g,'')
        .replace(/ +/g,'-')
        ;
}

function show_toastr(type, title_msg, title_sub_msg) {
    toastr.options.closeButton = true;
    toastr.options.progressBar = true;
    toastr.options.timeOut = '4000';
    if (type == 'success') {
        toastr.success(title_sub_msg, title_msg);
    } else if (type == 'info') {
        toastr.info(title_sub_msg, title_msg);
    } else if (type == 'warning') {
        toastr.warning(title_sub_msg, title_msg);
    } else if (type == 'error') {
        toastr.error(title_sub_msg, title_msg);
    }
}

function getErrorMessage(error) {
    // console.log('getErrorMessage error::')
    // console.log(typeof error)
    // console.log(error)
    // debugger
    // console.log('getErrorMessage error.status::')
    // console.log(error.status)
    // console.log(typeof error.status)
    //
    // console.log('getErrorMessage error.responseJSON::')
    // console.log(error.responseJSON)
    // console.log('getErrorMessage error.responseJSON.message::')
    // console.log(error.responseJSON.message)
    if (typeof error.status != 'undefined' && typeof error.responseJSON != 'undefined' && error.status === 400) {
        if (typeof error.responseJSON.message != 'undefined') {
            return "Validation error : " + error.responseJSON.message
        }
    }

    if (typeof error.status != 'undefined' && typeof error.responseJSON != 'undefined') {
        if (typeof error.responseJSON.message != 'undefined') {
            return error.responseJSON.message
        }
    }

    // console.log('+++getErrorMessage error.response.data.errors::')
    // console.log(error.response.data.errors)

    /*
        if (typeof error.response.status != 'undefined' && typeof error.response != 'undefined' && error.response.status === 400) {
            if (typeof error.response.data.message != 'undefined') {
                return "Validation error : " + error.response.data.message
            }
        }
        if (typeof error.response.status != 'undefined' && typeof error.response != 'undefined' && error.response.status === 500) {
            if (typeof error.response.data.message != 'undefined') {
                return "Validation error : " + error.response.data.message
            }
        }
        if (typeof error.response.status != 'undefined' && /!*typeof error.response != 'undefined' && *!/ error.response.status === 422) {
            if (typeof error.response.data.message != 'undefined') {
                console.log(typeof error.response.data.errors)

                if (typeof error.response.data.errors === 'object') {
                    let errorMessage = ''
                    for (var fieldName in error.response.data.errors) {
                        var value = error.response.data.errors[fieldName]
                        errorMessage += fieldName + " : " + value + '   '
                    }
                    return "Validation error : " + errorMessage

                }
                return "Validation error : " + error.response.data.message
            }
        }
        if (typeof error.response.data.exception != 'undefined') return error.response.data.exception
        if (typeof error.response.data.message != 'undefined') return error.response.data.exception
    */
}


// init Masonry
var $grid = $('.grid-masonry').masonry({
    itemSelector: '.grid-item',
    percentPosition: true,
    columnWidth: '.grid-item'
});
