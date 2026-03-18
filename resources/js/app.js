import jQuery from 'jquery';
import select2 from 'select2';

select2(window, jQuery);

globalThis.$ = globalThis.jQuery = jQuery;
