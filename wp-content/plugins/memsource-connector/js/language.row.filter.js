jQuery(document).ready(function() {
    if (!memsourceGlobal.wpmlActive) {
        memsourceAddLanguageRowFilter();
    }
});

function memsourceAddLanguageRowFilter() {
    var container = jQuery('<div></div>');
    container.addClass('memsource-language-row-filter');
    if (memsourceGlobal.languages.source && memsourceGlobal.languages.source.code &&
        memsourceGlobal.languages.target && memsourceGlobal.languages.target.length > 0) {
        var subContainer = jQuery('<ul></ul>');
        memsourceAddLogo(subContainer);
        memsourceAddLanguageLink(subContainer, memsourceGlobal.languages.source);
        jQuery.each(memsourceGlobal.languages.target, function(index, language) {
            memsourceAddLanguageLink(subContainer, language);
        });
        memsourceAddLanguageLink(subContainer, {code: 'all', translated_name: memsourceGlobal.allLanguagesLabel});
        container.append(subContainer);
    } else {
        container.html('<div class="dashicons dashicons-warning red-icon"></div>' + memsourceGlobal.languageSetupLink);
    }
    jQuery(".subsubsub").append(container);
}

function memsourceAddLogo(container) {
    var element = jQuery('<li></li>');
    element.addClass('logo');
    container.append(element);
}

function memsourceAddLanguageLink(container, language) {
    var element = jQuery('<li></li>');
    element.addClass('language-item');
    var params = {lang: language.code, post_type: memsourceGlobal.postType};
    if (memsourceGlobal.postStatus) {
        params.post_status = memsourceGlobal.postStatus;
    }
    if (memsourceGlobal.postAuthor) {
        params.author = memsourceGlobal.postAuthor;
    }
    var html = '<a href="?' + jQuery.param(params) + '">' + language.translated_name + ' <span class="count">(' + memsourceGetLanguagePostCount(language.code) + ')</span>' + '</a>&nbsp;';
    if (language.code != 'all') {
        html += '|&nbsp;';
    }
    element.html(html);
    if (language.code == memsourceGlobal.selectedLanguageCode) {
        element.find('a').addClass('current');
    }
    container.append(element);
}

function memsourceGetLanguagePostCount(code) {
    var postCount = 0;
    jQuery.each(memsourceGlobal.languagePostCount, function(index, item) {
        var count = parseInt(item.postCount);
        if (item.langCode == code) {
            postCount = count;
        } else if (code == 'all') {
            postCount += count;
        }
    });
    return postCount;
}