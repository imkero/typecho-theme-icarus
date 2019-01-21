document.addEventListener('DOMContentLoaded', function () {
    if (typeof(ClipboardJS) !== 'undefined') {
        $('pre>code').each(function () {
            var id = 'code-' + Date.now() + (Math.random() * 1000 | 0);
            $(this).attr('id', id);
            $(this).prepend($(`<button class="button is-borderless is-radiusless is-small copy" data-clipboard-target="#${id}" title="Copy"><i class="fas fa-copy"></i></button>`));
        });
        new ClipboardJS('pre>code>.copy');
    }
});