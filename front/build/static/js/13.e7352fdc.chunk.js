(this.webpackJsonpfront=this.webpackJsonpfront||[]).push([[13],{111:function(e,t,n){"use strict";n.d(t,"a",(function(){return s}));var c=n(106),a=n(0),r=(n(132),n(8)),s=function(e){var t=e.label,n=e.onClick,s=e.disabled,o=e.className,i=Object(a.useState)(!1),u=Object(c.a)(i,2),l=u[0],b=u[1],j=Object(a.useCallback)((function(e){b(!0),n(e)}),[n]);return Object(a.useEffect)((function(){b(!1)}),[n]),Object(r.jsx)("button",{className:"primary-button\n        ".concat(s?"disabled":"","\n        ").concat(o||"","\n        ").concat(l?"clicked":"","\n        "),onClick:j,disabled:s,children:t})}},132:function(e,t,n){},138:function(e,t,n){},139:function(e,t,n){},143:function(e,t,n){"use strict";n.d(t,"a",(function(){return v}));var c=n(0),a=(n(138),n(106)),r=n(10),s=n(22),o=n(190),i=n.n(o),u=n(11),l=n(17),b=n(14),j=n(482),d=n(456),f=n(457),O=n(8),h=function(e){var t=e.open,n=e.handleClose,c=e.children;return Object(O.jsx)(j.a,{className:"modal-container",open:t,onClose:n,closeAfterTransition:!0,BackdropComponent:d.a,BackdropProps:{timeout:500},children:Object(O.jsx)(f.a,{in:t,children:c})})},m=n(111),p=(n(139),function(){var e=function(){var e=Object(s.b)(),t=Object(r.f)(),n=Object(c.useState)(!1),o=Object(a.a)(n,2),i=o[0],l=o[1],b=Object(s.c)((function(e){return e.main.user.extra_type})),j=Object(s.c)((function(e){return e.main.user.type})),d=Object(c.useCallback)((function(){l(!0)}),[]),f=Object(c.useCallback)((function(){l(!1)}),[]),O=Object(c.useCallback)((function(n){l(!1),e(Object(u.f)(n)),setTimeout((function(){t.push("/")}),100)}),[e,t]);return{isOpen:i,userTypeButtons:Object(c.useMemo)((function(){return b.filter((function(e){return e.type!==j})).map((function(e){var t=e.title,n=e.type;return{label:t,onClick:function(){return O(n)}}}))}),[b,O,j]),handleOpen:d,handleClose:f}}(),t=e.isOpen,n=e.userTypeButtons,o=e.handleOpen,i=e.handleClose;return n.length?Object(O.jsxs)("div",{className:"user-select",children:[Object(O.jsx)("img",{src:"/images/user.svg",alt:"user",onClick:o}),Object(O.jsx)(h,{open:t,handleClose:i,children:Object(O.jsx)("div",{className:"user-select__modal",children:n.map((function(e){var t=e.label,n=e.onClick;return Object(O.jsx)(m.a,{label:t,onClick:n,className:"user-select__button"},t)}))})})]}):null}),k=function(){var e=function(){var e=Object(r.f)(),t=Object(c.useCallback)((function(){e.push("/")}),[e]),n=Object(c.useCallback)((function(){window.location.reload()}),[]);return{onLogoClick:t,onBackButtonClick:Object(c.useCallback)((function(){"/"!==e.location.pathname&&e.goBack()}),[e]),onReloadButtonClick:n,onForwardButtonClick:Object(c.useCallback)((function(){e.goForward()}),[e])}}(),t=e.onLogoClick,n=e.onBackButtonClick,a=e.onReloadButtonClick,s=e.onForwardButtonClick;return Object(O.jsxs)("div",{className:"header__navigation",children:[Object(O.jsx)("img",{className:"header__logo",src:"/images/logo.svg",alt:"logo",onClick:t}),Object(O.jsx)("img",{className:"header__navButton",src:"/images/arrow-left-nav.svg",alt:"logo",onClick:n}),Object(O.jsx)("img",{className:"header__navButton",src:"/images/arrow-right-nav.svg",alt:"logo",onClick:s}),Object(O.jsx)("img",{className:"header__navButton",src:"/images/reload.svg",alt:"logo",onClick:a})]})},v=function(){var e=function(){var e=Object(s.b)(),t=Object(r.f)(),n=Object(s.c)((function(e){return e.main.user})).type,o=Object(c.useState)(""),j=Object(a.a)(o,2),d=j[0],f=j[1],O=Object(c.useMemo)((function(){return n===b.a.BANK||n===b.a.DEVELOPER}),[n]),h=Object(c.useCallback)(i.a.debounce((function(t){return e(Object(l.g)(t))}),500),[]);return{searchText:d,isNotCompanyUser:O,onSearch:Object(c.useCallback)((function(e){h(e.target.value),f(e.target.value)}),[h]),onLogout:Object(c.useCallback)((function(){localStorage.clear(),e(Object(u.e)({type:null,token:null})),t.push("/")}),[e,t])}}(),t=e.searchText,n=e.isNotCompanyUser,o=e.onSearch,j=e.onLogout;return Object(O.jsxs)("div",{className:"header container",children:[Object(O.jsx)(k,{}),!n&&Object(O.jsxs)("div",{className:"header__search",children:[Object(O.jsx)("input",{type:"text",placeholder:"\u041f\u043e\u0448\u0443\u043a...",onChange:o,value:t}),Object(O.jsx)("img",{src:"/images/search.svg",alt:"search"})]}),Object(O.jsxs)("div",{className:"header__control",children:[!n&&Object(O.jsx)(p,{}),Object(O.jsx)("img",{src:"/images/log-out.svg",alt:"logout",onClick:j})]})]})}},290:function(e,t,n){},317:function(e,t,n){"use strict";n.d(t,"a",(function(){return O}));var c=n(0),a=n(18),r=(n(290),n(1)),s=n.n(r),o=n(2),i=n(106),u=n(22),l=n(4),b=n(5);function j(e){return d.apply(this,arguments)}function d(){return(d=Object(o.a)(s.a.mark((function e(t){var n;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,Object(b.a)({url:"".concat(l.a,"/api/bank/data"),headers:{Authorization:"Bearer ".concat(t)}});case 2:if((n=e.sent).success){e.next=5;break}throw new Error(n.message);case 5:return e.abrupt("return",n.data);case 6:case"end":return e.stop()}}),e)})))).apply(this,arguments)}var f=n(8),O=function(){var e=function(){var e=Object(u.c)((function(e){return e.main.user})).token,t=Object(c.useState)(!0),n=Object(i.a)(t,2),a=n[0],r=n[1],l=Object(c.useState)(),b=Object(i.a)(l,2),d=b[0],f=b[1];return Object(c.useEffect)((function(){Object(o.a)(s.a.mark((function t(){var n;return s.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(e){t.next=2;break}return t.abrupt("return");case 2:return t.prev=2,t.next=5,j(e);case 5:n=t.sent,f(n),t.next=12;break;case 9:t.prev=9,t.t0=t.catch(2),console.error(t.t0);case 12:return t.prev=12,r(!1),t.finish(12);case 15:case"end":return t.stop()}}),t,null,[[2,9,12,15]])})))()}),[e]),{isLoading:a,cards:d}}(),t=e.isLoading,n=e.cards;return t?Object(f.jsx)(a.a,{}):n?Object(f.jsx)("div",{className:"vision-bank",children:n.map((function(e){var t=e.title,n=e.info;return Object(f.jsxs)("div",{className:"bank-card",children:[Object(f.jsxs)("div",{className:"bank-card__title",children:[Object(f.jsx)("img",{src:"/images/clock.svg",alt:"clock"}),Object(f.jsx)("span",{children:t})]}),Object(f.jsx)("div",{className:"bank-card__info",children:n.map((function(e){return Object(f.jsx)("a",{href:"/".concat(e.link),children:e.title},e.id)}))})]},t)}))}):null}},413:function(e,t,n){},486:function(e,t,n){"use strict";n.r(t),n.d(t,"default",(function(){return s}));n(0);var c=n(143),a=n(317),r=(n(413),n(8)),s=function(){return Object(r.jsxs)(r.Fragment,{children:[Object(r.jsx)(c.a,{}),Object(r.jsx)("div",{className:"bank-container",children:Object(r.jsx)(a.a,{})})]})}}}]);
//# sourceMappingURL=13.e7352fdc.chunk.js.map