!function(e){var t={};function r(n){if(t[n])return t[n].exports;var o=t[n]={i:n,l:!1,exports:{}};return e[n].call(o.exports,o,o.exports,r),o.l=!0,o.exports}r.m=e,r.c=t,r.d=function(e,t,n){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(r.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)r.d(n,o,function(t){return e[t]}.bind(null,o));return n},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="",r(r.s=58)}({0:function(e,t){e.exports=jQuery},1:function(e,t){e.exports=function(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e},e.exports.__esModule=!0,e.exports.default=e.exports},10:function(e,t){e.exports=function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")},e.exports.__esModule=!0,e.exports.default=e.exports},11:function(e,t){function r(e,t){for(var r=0;r<t.length;r++){var n=t[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}e.exports=function(e,t,n){return t&&r(e.prototype,t),n&&r(e,n),Object.defineProperty(e,"prototype",{writable:!1}),e},e.exports.__esModule=!0,e.exports.default=e.exports},21:function(e,t,r){"use strict";e.exports=function(e,t,r,n){e=(e+"").replace(/[^0-9+\-Ee.]/g,"");var o=isFinite(+e)?+e:0,a=isFinite(+t)?Math.abs(t):0,c=void 0===n?",":n,i=void 0===r?".":r,s="";return(s=(a?function(e,t){if(-1===(""+e).indexOf("e"))return+(Math.round(e+"e+"+t)+"e-"+t);var r=(""+e).split("e"),n="";return+r[1]+t>0&&(n="+"),(+(Math.round(+r[0]+"e"+n+(+r[1]+t))+"e-"+t)).toFixed(t)}(o,a).toString():""+Math.round(o)).split("."))[0].length>3&&(s[0]=s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g,c)),(s[1]||"").length<a&&(s[1]=s[1]||"",s[1]+=new Array(a-s[1].length+1).join("0")),s.join(i)}},5:function(e,t,r){"use strict";r.d(t,"b",(function(){return d})),r.d(t,"a",(function(){return y}));var n=r(1),o=r.n(n),a=r(10),c=r.n(a),i=r(11),s=r.n(i);function u(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function l(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?u(Object(r),!0).forEach((function(t){o()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):u(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}var p=r(21),d=function(){function e(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};c()(this,e);var r=edd_vars,n=r.currency_decimals,o=r.decimal_separator,a=r.thousands_separator;this.config=l({precision:n,decimalSeparator:o,thousandSeparator:a},t)}return s()(e,[{key:"format",value:function(e){var t=e;"number"!=typeof e&&(t=parseFloat(e)),isNaN(t)&&(t=0);var r=this.config,n=r.precision,o=r.decimalSeparator,a=r.thousandSeparator;return p(t,n,o,a)}},{key:"unformat",value:function(e){var t=this.config,r=t.decimalSeparator,n=t.thousandSeparator;"string"!=typeof e&&(e=String(e));var o=e.replace(n,"").replace(r,"."),a=parseFloat(o);return isNaN(a)?0:a}},{key:"absint",value:function(e){var t=this.unformat(e);return t>=0?t:-1*t}}]),e}();function f(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function b(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?f(Object(r),!0).forEach((function(t){o()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):f(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}var y=function(){function e(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};c()(this,e);var r=edd_vars,n=r.currency,o=r.currency_sign,a=r.currency_pos,i=r.currency_decimals,s=r.decimal_separator,u=r.thousands_separator;this.config=b({currency:n,currencySymbol:o,currencySymbolPosition:a,precision:i,decimalSeparator:s,thousandSeparator:u},t),this.number=new d(this.config)}return s()(e,[{key:"format",value:function(e){var t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1],r=this.config,n=r.currencySymbol,o=r.currencySymbolPosition,a=this.number.format(e),c=e<0,i="";switch(!0===c&&!0===t&&(a=this.number.format(-1*e)),o){case"before":i=n+a;break;case"after":i=a+n}return!0===c&&!1===t&&(i="-".concat(i)),i}},{key:"unformat",value:function(e){var t=this.config.currencySymbol,r=e.replace(t,"");return this.number.unformat(r)}}]),e}()},58:function(e,t,r){"use strict";r.r(t),function(e,t){r(59),r(92),"undefined"!=typeof postboxes&&/edd-reports/.test(pagenow)&&postboxes.add_postbox_toggles(pagenow);var n={init:function(){this.meta_boxes(),this.date_options(),this.customers_export()},meta_boxes:function(){e(".edd-reports-wrapper .postbox .handlediv").remove(),e(".edd-reports-wrapper .postbox").removeClass("closed"),setTimeout((function(){e(".edd-reports-wrapper .postbox .hndle").unbind("click.postboxes")}),1)},date_options:function(){e("select.edd-graphs-date-options").on("change",(function(t){var r=e(this),n=r.parent().siblings(".edd-date-range-options");"other"===r.val()?n.removeClass("screen-reader-text"):n.addClass("screen-reader-text")}))},customers_export:function(){e("#edd_customer_export_download").change((function(){var t=e(this),r=e("option:selected",t).val(),n=e("#edd_customer_export_option");if("0"===t.val()?n.show():n.hide(),0!==parseInt(r)){var o={action:"edd_check_for_download_price_variations",download_id:r,all_prices:!0},a=e(".edd_price_options_select");e.post(ajaxurl,o,(function(t){a.remove(),e("#edd_customer_export_download_chosen").after(t)}))}else a.remove()}))}};t(document).ready((function(e){n.init()}))}.call(this,r(0),r(0))},59:function(e,t,r){"use strict";(function(e){}).call(this,r(0))},92:function(e,t,r){"use strict";var n=r(1),o=r.n(n),a=r(5),c=function(e){var t=e.type;return"pie"===t||"doughnut"===t},i=function(e,t){var r=e;return"currency"===t.type&&(r=(new a.a).format(e)),r},s={enabled:!1,mode:"index",position:"nearest",custom:function(e){var t=document.getElementById("edd-chartjs-tooltip");if(t||((t=document.createElement("div")).id="edd-chartjs-tooltip",t.innerHTML="<table></table>",this._chart.canvas.parentNode.appendChild(t)),0!==e.opacity){if(t.classList.remove("above","below","no-transform"),e.yAlign?t.classList.add(e.yAlign):t.classList.add("no-transform"),e.body){var r=e.title||[],n=e.body.map((function(e){return e.lines})),o="<thead>";r.forEach((function(e){o+="<tr><th>"+e+"</th></tr>"})),o+="</thead><tbody>",n.forEach((function(t,r){var n=e.labelColors[r],a=n.borderColor,c=n.backgroundColor,i=a;"rgb(230, 230, 230)"!==i&&"#fff"!==i||(i=c);var s='<span class="edd-chartjs-tooltip-key" style="'+["background: ".concat(i),"border-color: ".concat(i),"border-width: 2px"].join(";")+'"></span>';o+="<tr><td>"+s+t+"</td></tr>"})),o+="</tbody>",t.querySelector("table").innerHTML=o}var a=this._chart.canvas.offsetTop,c=this._chart.canvas.offsetLeft;t.style.opacity=1,t.style.left=c+e.caretX+"px",t.style.top=a+e.caretY+"px",t.style.fontFamily=e._bodyFontFamily,t.style.fontSize=e.bodyFontSize+"px",t.style.fontStyle=e._bodyFontStyle,t.style.padding=e.yPadding+"px "+e.xPadding+"px"}else t.style.opacity=0}};function u(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function l(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?u(Object(r),!0).forEach((function(t){o()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):u(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}var p=function(e){return l(l({},s),{},{callbacks:{label:function(t,r){var n=e.options.datasets,o=n[Object.keys(n)[t.datasetIndex]],a=i(t.yLabel,o);return"".concat(r.datasets[t.datasetIndex].label,": ").concat(a)}}})};function d(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function f(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?d(Object(r),!0).forEach((function(t){o()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):d(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}window.edd=window.edd||{},window.edd.renderChart=function(e){c(e),Chart.defaults.global.pointHitDetectionRadius=5,c(e)?function(e){var t=e.target;e.options.tooltips=function(e){return f(f({},s),{},{callbacks:{label:function(t,r){var n=e.options.datasets,o=n[Object.keys(n)[t.datasetIndex]],a=r.datasets[t.datasetIndex],c=a.data.reduce((function(e,t,r,n){return e+t})),s=a.data[t.index],u=i(s,o),l=Math.floor(s/c*100+.5);return"".concat(r.labels[t.index],": ").concat(u," (").concat(l,"%)")}}})}(e),new Chart(document.getElementById(t),e)}(e):function(e){var t=e.target,r=e.dates,n=(r.utc_offset,r.hour_by_hour,r.day_by_day,new a.b),o=l(l({},e),{},{options:l(l({},e.options),{},{tooltips:p(e),scales:l(l({},e.options.scales),{},{yAxes:[l(l({},e.options.scales.yAxes[0]),{},{ticks:{callback:function(e,t,r){return n.format(e)}}})],xAxes:[l(l({},e.options.scales.xAxes[0]),{},{time:l(l({},e.options.scales.xAxes[0].time),{},{parser:function(e){return moment.utc(e)}})})]})})});new Chart(document.getElementById(t),o)}(e)}}});