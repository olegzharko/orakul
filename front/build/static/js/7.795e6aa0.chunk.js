(this.webpackJsonpfront=this.webpackJsonpfront||[]).push([[7],{116:function(e,t,n){"use strict";n.d(t,"a",(function(){return a}));n(0),n(135);var c=n(8),a=function(e){var t=e.label,n=e.onClick,a=e.disabled,o=e.className;return Object(c.jsx)("button",{className:"primary-button ".concat(a?"disabled":""," ").concat(o||""),onClick:n,disabled:a,children:t})}},117:function(e,t,n){"use strict";var c=n(122);n.d(t,"a",(function(){return c.a}))},119:function(e,t,n){"use strict";n.d(t,"a",(function(){return a}));n(0),n(187);var c=n(8),a=function(e){var t=e.title,n=e.children,a=e.onClear;return Object(c.jsxs)("div",{className:"section-with-title",children:[Object(c.jsxs)("div",{className:"section-with-title__header",children:[Object(c.jsx)("h2",{className:"section-title",children:t}),a&&Object(c.jsx)("button",{type:"button",className:"clear-button",children:Object(c.jsx)("img",{src:"/icons/clear-form.svg",alt:"close",className:"clear-icon",onClick:a})})]}),Object(c.jsx)("div",{className:"section-with-title__body",children:n})]})}},122:function(e,t,n){"use strict";var c=n(110),a=n(0),o=(n(133),n(422)),s=n(8);t.a=function(e){var t=e.label,n=e.onChange,i=e.value,l=void 0===i?"":i,r=e.type,u=void 0===r?"string":r,d=e.disabled,b=Object(a.useState)(l||""),j=Object(c.a)(b,2),v=j[0],O=j[1];Object(a.useEffect)((function(){O(l||"")}),[l]);return Object(s.jsx)(o.a,{label:t,variant:"outlined",value:v,onChange:function(e){O(e.target.value),n&&n(e.target.value)},type:u,className:"custom-input",disabled:d||!1})}},127:function(e,t,n){"use strict";n.d(t,"a",(function(){return r}));var c=n(110),a=n(0),o=n(219),s=n(150),i=n(413),l=n(8),r=function(e){var t=e.selectedDate,n=e.onSelect,r=e.label,u=Object(a.useState)(t),d=Object(c.a)(u,2),b=d[0],j=d[1];Object(a.useEffect)((function(){j(t)}),[t]);return Object(l.jsx)(s.a,{utils:o.a,children:Object(l.jsx)(i.a,{margin:"normal",label:r,format:"dd/MM/yyyy",value:b,onChange:function(e){j(e),n(e)},KeyboardButtonProps:{"aria-label":"change date"}})})}},128:function(e,t,n){"use strict";n.d(t,"a",(function(){return i}));var c=n(3),a=n(0),o=n(23),s=n(13),i=function(){var e=Object(o.b)(),t=Object(o.c)((function(e){return e.main})).modalInfo;return Object(a.useMemo)((function(){return Object(c.a)(Object(c.a)({},t),{},{handleClose:function(){return e(Object(s.d)(Object(c.a)(Object(c.a)({},t),{},{open:!1})))}})}),[t])}},130:function(e,t,n){"use strict";n.d(t,"a",(function(){return i}));n(0),n(136);var c=n(418),a=n(402),o=n(401),s=n(8),i=function(e){var t=e.open,n=e.handleClose,i=e.success,l=e.message;return Object(s.jsx)(c.a,{className:"modal-container",open:t,onClose:n,closeAfterTransition:!0,BackdropComponent:a.a,BackdropProps:{timeout:500},children:Object(s.jsx)(o.a,{in:t,children:Object(s.jsx)("div",{className:"modal ".concat(i?"modal-success":"modal-failed"),children:Object(s.jsx)("p",{className:"message",children:l})})})})}},133:function(e,t,n){},135:function(e,t,n){},136:function(e,t,n){},144:function(e,t,n){"use strict";n.d(t,"a",(function(){return r}));var c=n(110),a=n(0),o=n(408),s=n(315),i=(n(151),n(8)),l=function(e){var t=e.label,n=e.onChange,l=e.selected,r=e.disabled,u=Object(a.useState)(l),d=Object(c.a)(u,2),b=d[0],j=d[1];return Object(a.useEffect)((function(){j(l)}),[l]),Object(i.jsx)(o.a,{control:Object(i.jsx)(s.a,{checked:b,onChange:function(e){j(e.target.checked),n(e.target.checked)},name:"checkedB",color:"primary"}),label:t,labelPlacement:"start",className:"custom-switch",disabled:r||!1})},r=Object(a.memo)(l)},148:function(e,t,n){},151:function(e,t,n){},152:function(e,t,n){"use strict";n.d(t,"a",(function(){return c})),n.d(t,"b",(function(){return a}));var c=function(e){return e&&e.replace(/(\d{2}).(\d{2}).(\d{4})/,"$2.$1.$3")},a=function(e){var t=e.getDate()<9?"0".concat(e.getDate()):e.getDate(),n=e.getMonth()<9?"0".concat(e.getMonth()+1):e.getMonth()+1,c=e.getFullYear(),a=e.getHours()<9?"0".concat(e.getHours()):e.getHours(),o=e.getMinutes()<9?"0".concat(e.getMinutes()):e.getMinutes();return"".concat(t,".").concat(n,".").concat(c," ").concat(a,":").concat(o)}},154:function(e,t,n){"use strict";n.d(t,"a",(function(){return d}));var c=n(0),a=(n(148),n(40)),o=n(110),s=n(23),i=n(13),l=n(15),r=function(e,t){var n=Object(c.useState)(e),a=Object(o.a)(n,2),s=a[0],i=a[1];return Object(c.useEffect)((function(){var n=setTimeout((function(){i(e)}),t);return function(){clearTimeout(n)}}),[e]),s},u=n(8),d=function(){var e=function(){var e=Object(s.b)(),t=Object(c.useState)(""),n=Object(o.a)(t,2),a=n[0],u=n[1],d=Object(c.useState)(0),b=Object(o.a)(d,2),j=b[0],v=b[1],O=r(a,1e3);return Object(c.useEffect)((function(){j?e(Object(l.f)(O)):v((function(e){return e+1}))}),[O]),{onSearch:Object(c.useCallback)((function(e){u(e.target.value)}),[a]),onLogout:Object(c.useCallback)((function(){localStorage.clear(),e(Object(i.e)({type:null,token:null}))}),[]),searchText:a}}(),t=e.onSearch,n=e.onLogout,d=e.searchText;return Object(u.jsxs)("div",{className:"header container",children:[Object(u.jsx)(a.b,{to:"/",className:"header__logo",children:Object(u.jsx)("img",{src:"/icons/logo.svg",alt:"logo"})}),Object(u.jsxs)("div",{className:"header__search",children:[Object(u.jsx)("input",{type:"text",placeholder:"\u041f\u043e\u0448\u0443\u043a...",onChange:t,value:d}),Object(u.jsx)("img",{src:"/icons/search.svg",alt:"search"})]}),Object(u.jsx)("div",{className:"header__control",children:Object(u.jsx)("img",{src:"/icons/log-out.svg",alt:"logout",onClick:n})})]})}},162:function(e,t,n){"use strict";var c=n(3),a=(n(0),n(127)),o=n(117),s=n(144),i=n(119),l=n(8);t.a=function(e){var t=e.data,n=e.setData,r=e.title;return Object(l.jsx)(i.a,{title:r,children:Object(l.jsxs)("div",{className:"grid",children:[Object(l.jsx)(a.a,{label:"\u0414\u0430\u0442\u0430 \u043f\u0435\u0440\u0435\u0432\u0456\u0440\u043a\u0438",onSelect:function(e){return n(Object(c.a)(Object(c.a)({},t),{},{date:e}))},selectedDate:t.date}),Object(l.jsx)(o.a,{label:"\u041d\u043e\u043c\u0435\u0440 \u043f\u0435\u0440\u0435\u0432\u0456\u0440\u043a\u0438",onChange:function(e){return n(Object(c.a)(Object(c.a)({},t),{},{number:e}))},value:t.number}),Object(l.jsx)(s.a,{label:"\u041f\u0440\u043e\u0439\u0448\u043e\u0432 \u043f\u0435\u0440\u0435\u0432\u0456\u0440\u043a\u0443",onChange:function(e){return n(Object(c.a)(Object(c.a)({},t),{},{pass:e}))},selected:t.pass})]})})}},168:function(e,t,n){"use strict";n.d(t,"a",(function(){return a}));n(0),n(175);var c=n(8),a=function(e){var t=e.children;return Object(c.jsx)("div",{className:"contentPanel",children:t})}},169:function(e,t,n){"use strict";n.d(t,"a",(function(){return a}));n(0),n(174);var c=n(8),a=function(e){var t=e.children;return Object(c.jsx)("div",{className:"controlPanel",children:t})}},174:function(e,t,n){},175:function(e,t,n){},176:function(e,t,n){},177:function(e,t,n){},178:function(e,t,n){},187:function(e,t,n){},199:function(e,t,n){"use strict";n.d(t,"a",(function(){return b}));var c,a=n(0),o=(n(176),n(370)),s=(n(177),n(40)),i=n(8),l=function(e){var t=e.title,n=e.headerColor,c=e.children,a=e.link,o=e.haveStatus;return Object(i.jsxs)(s.b,{to:a,className:"card",children:[Object(i.jsxs)("div",{className:"card__header",style:{backgroundColor:o?"":n||""},children:[Object(i.jsx)("span",{style:{color:o?"black":n?"white":""},children:t}),o&&Object(i.jsx)("div",{className:"status",style:{backgroundColor:n||""}})]}),Object(i.jsx)("div",{className:"card__main",children:c})]})},r=n(110);!function(e){e[e.CARDS=0]="CARDS",e[e.TABLE=1]="TABLE"}(c||(c={}));var u=function(e){var t=e.link,n=e.title,a=e.cards,o=e.style,s=e.haveStatus;return Object(i.jsxs)("div",{className:"dashboard__main-section",children:[Object(i.jsx)("h2",{children:n}),Object(i.jsx)("div",{className:"cards ".concat(o===c.TABLE?"table":""),children:a.map((function(e){return Object(i.jsx)(l,{haveStatus:s,title:e.title,headerColor:e.color,link:"/".concat(t,"/").concat(e.id),children:e.content.map((function(e){return Object(i.jsx)("span",{className:"card__content-item",children:e},e)}))},e.id)}))})]})},d=(n(178),function(e){var t=e.selected,n=e.onClick;return Object(i.jsxs)("div",{className:"dashboard__space-control",children:[Object(i.jsx)("svg",{className:"".concat(c.CARDS===t?"selected":""),onClick:function(){return n(c.CARDS)},width:"18",height:"18",viewBox:"0 0 18 18",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:Object(i.jsx)("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M1.50008 0.666748H7.33341C7.83341 0.666748 8.16675 1.00008 8.16675 1.50008V7.33341C8.16675 7.83341 7.83341 8.16675 7.33341 8.16675H1.50008C1.00008 8.16675 0.666748 7.83341 0.666748 7.33341V1.50008C0.666748 1.00008 1.00008 0.666748 1.50008 0.666748ZM2.33341 6.50008H6.50008V2.33341H2.33341V6.50008ZM16.5001 0.666748H10.6667C10.1667 0.666748 9.83342 1.00008 9.83342 1.50008V7.33341C9.83342 7.83341 10.1667 8.16675 10.6667 8.16675H16.5001C17.0001 8.16675 17.3334 7.83341 17.3334 7.33341V1.50008C17.3334 1.00008 17.0001 0.666748 16.5001 0.666748ZM11.5001 6.50008H15.6667V2.33341H11.5001V6.50008ZM16.5001 9.83342H10.6667C10.1667 9.83342 9.83342 10.1667 9.83342 10.6667V16.5001C9.83342 17.0001 10.1667 17.3334 10.6667 17.3334H16.5001C17.0001 17.3334 17.3334 17.0001 17.3334 16.5001V10.6667C17.3334 10.1667 17.0001 9.83342 16.5001 9.83342ZM11.5001 15.6667H15.6667V11.5001H11.5001V15.6667ZM7.33341 9.83342H1.50008C1.00008 9.83342 0.666748 10.1667 0.666748 10.6667V16.5001C0.666748 17.0001 1.00008 17.3334 1.50008 17.3334H7.33341C7.83341 17.3334 8.16675 17.0001 8.16675 16.5001V10.6667C8.16675 10.1667 7.83341 9.83342 7.33341 9.83342ZM2.33341 15.6667H6.50008V11.5001H2.33341V15.6667Z",fill:"#165153"})}),Object(i.jsx)("svg",{className:"".concat(c.TABLE===t?"selected":""),onClick:function(){return n(c.TABLE)},width:"20",height:"20",viewBox:"0 0 20 20",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:Object(i.jsx)("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M3.33325 0.833252H16.6666C18.0833 0.833252 19.1666 1.91659 19.1666 3.33325V6.66659C19.1666 8.08325 18.0833 9.16658 16.6666 9.16658H3.33325C1.91659 9.16658 0.833252 8.08325 0.833252 6.66659V3.33325C0.833252 1.91659 1.91659 0.833252 3.33325 0.833252ZM16.6666 7.49992C17.1666 7.49992 17.4999 7.16658 17.4999 6.66658V3.33325C17.4999 2.83325 17.1666 2.49992 16.6666 2.49992H3.33325C2.83325 2.49992 2.49992 2.83325 2.49992 3.33325V6.66658C2.49992 7.16658 2.83325 7.49992 3.33325 7.49992H16.6666ZM16.6666 10.8333H3.33325C1.91659 10.8333 0.833252 11.9166 0.833252 13.3333V16.6666C0.833252 18.0833 1.91659 19.1666 3.33325 19.1666H16.6666C18.0833 19.1666 19.1666 18.0833 19.1666 16.6666V13.3333C19.1666 11.9166 18.0833 10.8333 16.6666 10.8333ZM16.6666 17.4999C17.1666 17.4999 17.4999 17.1666 17.4999 16.6666V13.3333C17.4999 12.8333 17.1666 12.4999 16.6666 12.4999H3.33325C2.83325 12.4999 2.49992 12.8333 2.49992 13.3333V16.6666C2.49992 17.1666 2.83325 17.4999 3.33325 17.4999H16.6666ZM5.58325 4.41659C5.74992 4.58325 5.83325 4.74992 5.83325 4.99992C5.83325 5.24992 5.74992 5.41659 5.58325 5.58325C5.41658 5.74992 5.24992 5.83325 4.99992 5.83325C4.74992 5.83325 4.58325 5.74992 4.41659 5.58325C4.33325 5.49992 4.24992 5.41659 4.24992 5.33325C4.16659 5.24992 4.16659 5.08325 4.16659 4.99992C4.16659 4.91659 4.16659 4.74992 4.24992 4.66659C4.29159 4.62492 4.31242 4.58325 4.33325 4.54159C4.35409 4.49992 4.37492 4.45825 4.41659 4.41659C4.49992 4.33325 4.58325 4.24992 4.66659 4.24992C4.91658 4.16659 5.08325 4.16659 5.33325 4.24992C5.41658 4.24992 5.49992 4.33325 5.58325 4.41659ZM5.83325 14.9999C5.83325 14.7499 5.74992 14.5833 5.58325 14.4166C5.24992 14.0833 4.74992 14.0833 4.41659 14.4166C4.37492 14.4583 4.35409 14.4999 4.33325 14.5416C4.31242 14.5833 4.29159 14.6249 4.24992 14.6666C4.16659 14.7499 4.16659 14.9166 4.16659 14.9999C4.16659 15.2499 4.24992 15.4166 4.41659 15.5833C4.58325 15.7499 4.74992 15.8333 4.99992 15.8333C5.24992 15.8333 5.41658 15.7499 5.58325 15.5833C5.74992 15.4166 5.83325 15.2499 5.83325 14.9999Z",fill:"#C0C1C1"})})]})}),b=function(e){var t=function(e){var t=e.style,n=Object(a.useState)(t||c.CARDS),o=Object(r.a)(n,2);return{selectedType:o[0],setSelectedType:o[1]}}(e),n=t.selectedType,s=t.setSelectedType;return Object(i.jsxs)("div",{className:"dashboard",children:[e.isChangeTypeButton&&Object(i.jsx)(d,{selected:n,onClick:s}),e.sections&&Object(i.jsx)("div",{className:"dashboard__main",children:e.sections.map((function(t){return Object(i.jsx)(u,{link:e.link,title:t.title,style:n,cards:t.cards,haveStatus:e.haveStatus},Object(o.a)())}))})]})}},258:function(e,t,n){},259:function(e,t,n){},416:function(e,t,n){"use strict";n.r(t),n.d(t,"default",(function(){return V}));var c,a=n(3),o=n(0),s=n(9),i=(n(258),n(154)),l=n(169),r=n(110),u=n(23),d=n(28);!function(e){e.DEVELOPER="developer",e.IMMOVABLE="immovable"}(c||(c={}));var b=n(8),j=function(e){var t=e.onSelect,n=e.selected,a=Object(s.f)(),o=function(e){t(e),a.push("/".concat(e))};return Object(b.jsxs)(l.a,{children:[Object(b.jsxs)("button",{className:"navigation-button ".concat(n===c.DEVELOPER?"selected":""),type:"button",onClick:function(){return o(c.DEVELOPER)},children:[Object(b.jsx)("img",{src:"/icons/navigation/developer.svg",alt:"developer"}),"\u0417\u0430\u0431\u043e\u0440\u043e\u043d\u0438 \u043d\u0430 \u043f\u0440\u043e\u0434\u0430\u0432\u0446\u044f"]}),Object(b.jsxs)("button",{className:"navigation-button ".concat(n===c.IMMOVABLE?"selected":""),type:"button",onClick:function(){return o(c.IMMOVABLE)},children:[Object(b.jsx)("img",{src:"/icons/navigation/immovable.svg",alt:"immovable"}),"\u0417\u0430\u0431\u043e\u0440\u043e\u043d\u0438 \u043f\u043e \u043d\u0435\u0440\u0443\u0445\u043e\u043c\u043e\u0441\u0442\u0456"]})]})},v=n(24),O=n(168),f=n(199),m=(n(259),n(117)),h=function(e){var t=e.label,n=e.value,c=e.disabled,a=e.onChange,s=Object(o.useState)(!1),i=Object(r.a)(s,2),l=i[0],u=i[1],d=o.useCallback((function(){n&&(navigator.clipboard.writeText(n),u(!0),setTimeout((function(){return u(!1)}),3e3))}),[n]);return Object(b.jsxs)("div",{className:"clipboard-input",children:[Object(b.jsx)(m.a,{label:t,onChange:a,value:n,disabled:c}),Object(b.jsx)("button",{type:"button",onClick:d,children:l?Object(b.jsx)("img",{src:"/icons/check.svg",alt:"copy"}):Object(b.jsx)("img",{src:"/icons/copy.svg",alt:"copy"})})]})},C=n(119),x=n(162),g=n(116),p=function(e){var t=e.data,n=e.setData,c=e.onPrevButtonClick,a=e.onSave,o=e.onNextButtonClick,s=e.disableSaveButton,i=e.next,l=e.prev;return Object(b.jsxs)(b.Fragment,{children:[Object(b.jsx)(x.a,{data:t,setData:n,title:"\u041f\u0435\u0440\u0435\u0432\u0456\u0440\u043a\u0430"}),Object(b.jsxs)("div",{className:"buttons-group",children:[Object(b.jsxs)("button",{type:"button",onClick:c,disabled:!l,className:"custom-button",children:[Object(b.jsx)("img",{src:"/icons/arrow-left.svg",alt:"previous",className:"left"}),"\u041f\u043e\u043f\u0435\u0440\u0435\u0434\u043d\u0456\u0439"]}),Object(b.jsx)("div",{className:"button-container",children:Object(b.jsx)(g.a,{label:"\u0417\u0431\u0435\u0440\u0435\u0433\u0442\u0438",onClick:a,disabled:s})}),Object(b.jsxs)("button",{type:"button",onClick:o,disabled:!i,className:"custom-button",children:["\u041d\u0430\u0441\u0442\u0443\u043f\u043d\u0438\u0439",Object(b.jsx)("img",{src:"/icons/arrow-right.svg",alt:"next",className:"right"})]})]})]})},N=n(152),k=function(e){var t=function(e){var t=e.onPathChange,n=e.immovable,i=Object(s.f)(),l=Object(s.g)().id,b=Object(u.b)(),j=Object(o.useState)({date:new Date,number:"",pass:!1}),v=Object(r.a)(j,2),O=v[0],f=v[1],m=Object(o.useMemo)((function(){return!O.date||!O.number}),[O]),h=Object(o.useCallback)((function(){b(Object(d.c)(l,Object(a.a)(Object(a.a)({},O),{},{date:Object(N.b)(O.date)})))}),[O,l]),C=Object(o.useCallback)((function(){n.prev&&i.push("/immovable/".concat(n.prev))}),[n]),x=Object(o.useCallback)((function(){n.next&&i.push("/immovable/".concat(n.next))}),[n]);return Object(o.useEffect)((function(){f({date:(null===n||void 0===n?void 0:n.date)?new Date(Object(N.a)(null===n||void 0===n?void 0:n.date)):new Date,number:(null===n||void 0===n?void 0:n.number)||"",pass:(null===n||void 0===n?void 0:n.pass)||!1})}),[n]),Object(o.useEffect)((function(){return t(l,c.IMMOVABLE)}),[l]),{data:O,disableSaveButton:m,setData:f,onPrevButtonClick:C,onNextButtonClick:x,onSave:h}}(e);return e.immovable?Object(b.jsxs)("div",{className:"registrator__immovable",children:[Object(b.jsx)(C.a,{title:e.immovable.title,children:Object(b.jsx)("div",{className:"grid",children:Object(b.jsx)(h,{label:"\u0420\u0435\u0454\u0441\u0442\u0440\u0430\u0446\u0456\u0439\u043d\u0438 \u043d\u043e\u043c\u0435\u0440",value:e.immovable.immovable_code,disabled:!0})})}),Object(b.jsx)(p,{data:t.data,setData:t.setData,onPrevButtonClick:t.onPrevButtonClick,onSave:t.onSave,onNextButtonClick:t.onNextButtonClick,disableSaveButton:t.disableSaveButton,next:e.immovable.next,prev:e.immovable.prev})]}):null},S=Object(o.memo)(k),E=function(e){var t=function(e){var t=e.onPathChange,n=e.developer,i=Object(s.f)(),l=Object(s.g)().id,b=Object(u.b)(),j=Object(o.useState)({date:new Date,number:"",pass:!1}),v=Object(r.a)(j,2),O=v[0],f=v[1],m=Object(o.useMemo)((function(){return!O.date||!O.number}),[O]),h=Object(o.useCallback)((function(){b(Object(d.b)(l,Object(a.a)(Object(a.a)({},O),{},{date:Object(N.b)(O.date)})))}),[O,l]),C=Object(o.useCallback)((function(){n.prev&&i.push("/developer/".concat(n.prev))}),[n]),x=Object(o.useCallback)((function(){n.next&&i.push("/developer/".concat(n.next))}),[n]);return Object(o.useEffect)((function(){f({date:(null===n||void 0===n?void 0:n.date)?new Date(Object(N.a)(null===n||void 0===n?void 0:n.date)):new Date,number:(null===n||void 0===n?void 0:n.number)||"",pass:(null===n||void 0===n?void 0:n.pass)||!1})}),[n]),Object(o.useEffect)((function(){return t(l,c.DEVELOPER)}),[l]),{data:O,disableSaveButton:m,setData:f,onPrevButtonClick:C,onNextButtonClick:x,onSave:h}}(e);return e.developer?Object(b.jsxs)("div",{className:"registrator__developer",children:[Object(b.jsx)(C.a,{title:e.developer.title,children:Object(b.jsxs)("div",{className:"grid",children:[Object(b.jsx)(h,{label:"\u041f\u0406\u0411",value:e.developer.full_name,disabled:!0}),Object(b.jsx)(h,{label:"\u041a\u043e\u0434",value:e.developer.tax_code,disabled:!0})]})}),Object(b.jsx)(p,{data:t.data,setData:t.setData,onPrevButtonClick:t.onPrevButtonClick,onSave:t.onSave,onNextButtonClick:t.onNextButtonClick,disableSaveButton:t.disableSaveButton,next:e.developer.next,prev:e.developer.prev})]}):null},B=n(130),M=n(128),V=function(){var e=function(){var e=Object(u.b)(),t=Object(u.c)((function(e){return e.registrator})),n=t.isLoading,a=t.developers,s=t.immovables,i=Object(o.useState)(c.DEVELOPER),l=Object(r.a)(i,2),b=l[0],j=l[1],v=Object(o.useState)(),O=Object(r.a)(v,2),f=O[0],m=O[1],h=Object(o.useState)(!0),C=Object(r.a)(h,2),x=C[0],g=C[1],p=Object(o.useCallback)((function(e,t){m(e),j(t)}),[]),N=Object(o.useCallback)((function(e){j(e),g((function(e){return!e}))}),[]),k=Object(o.useMemo)((function(){return b===c.IMMOVABLE?s?s.immovables.find((function(e){return e.id===Number(f)})):null:a?a.developers.find((function(e){return e.id===Number(f)})):null}),[f,a,s]),S=Object(o.useMemo)((function(){var e="",t=[];return b===c.DEVELOPER?(e=(null===a||void 0===a?void 0:a.date_info)||"",t=((null===a||void 0===a?void 0:a.developers)||[]).map((function(e){return{id:e.id,title:e.title,content:["\u0414\u0430\u0442\u0430: ".concat(e.date),"\u041d\u043e\u043c\u0435\u0440: ".concat(e.number)],color:e.color}}))):b===c.IMMOVABLE&&(e=(null===s||void 0===s?void 0:s.date_info)||"",t=((null===s||void 0===s?void 0:s.immovables)||[]).map((function(e){return{id:e.id,title:e.title,content:["\u0414\u0430\u0442\u0430: ".concat(e.date),"\u041d\u043e\u043c\u0435\u0440: ".concat(e.number)],color:e.color}}))),[{title:e,cards:t}]}),[b,s,a]);return Object(o.useEffect)((function(){b===c.DEVELOPER?e(Object(d.d)()):e(Object(d.e)())}),[x,f]),{selectedNav:b,triggerNav:N,isLoading:n,sections:S,onChangeNav:p,selectedCardData:k}}(),t=Object(M.a)();return Object(b.jsxs)(b.Fragment,{children:[Object(b.jsx)(i.a,{}),Object(b.jsxs)("main",{className:"registrator",children:[Object(b.jsx)(j,{onSelect:e.triggerNav,selected:e.selectedNav}),Object(b.jsx)(O.a,{children:Object(b.jsxs)(s.c,{children:[Object(b.jsx)(s.a,{path:"/developer/:id",exact:!0,children:Object(b.jsx)(E,{onPathChange:e.onChangeNav,developer:e.selectedCardData})}),Object(b.jsx)(s.a,{path:"/immovable/:id",exact:!0,children:Object(b.jsx)(S,{onPathChange:e.onChangeNav,immovable:e.selectedCardData})}),e.isLoading&&Object(b.jsx)(v.a,{}),!e.isLoading&&Object(b.jsx)(f.a,{link:e.selectedNav,sections:e.sections,haveStatus:!0})]})})]}),Object(b.jsx)(B.a,Object(a.a)({},t))]})}}}]);
//# sourceMappingURL=7.795e6aa0.chunk.js.map