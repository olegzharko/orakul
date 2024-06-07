(this.webpackJsonpfront=this.webpackJsonpfront||[]).push([[14],{111:function(e,t,n){"use strict";n.d(t,"a",(function(){return r}));var c=n(106),a=n(0),s=(n(132),n(8)),r=function(e){var t=e.label,n=e.onClick,r=e.disabled,o=e.className,i=Object(a.useState)(!1),l=Object(c.a)(i,2),u=l[0],j=l[1],b=Object(a.useCallback)((function(e){j(!0),n(e)}),[n]);return Object(a.useEffect)((function(){j(!1)}),[n]),Object(s.jsx)("button",{className:"primary-button\n        ".concat(r?"disabled":"","\n        ").concat(o||"","\n        ").concat(u?"clicked":"","\n        "),onClick:b,disabled:r,children:t})}},132:function(e,t,n){},138:function(e,t,n){},139:function(e,t,n){},143:function(e,t,n){"use strict";n.d(t,"a",(function(){return g}));var c=n(0),a=(n(138),n(106)),s=n(10),r=n(22),o=n(190),i=n.n(o),l=n(11),u=n(17),j=n(14),b=n(482),d=n(456),O=n(457),f=n(8),m=function(e){var t=e.open,n=e.handleClose,c=e.children;return Object(f.jsx)(b.a,{className:"modal-container",open:t,onClose:n,closeAfterTransition:!0,BackdropComponent:d.a,BackdropProps:{timeout:500},children:Object(f.jsx)(O.a,{in:t,children:c})})},h=n(111),p=(n(139),function(){var e=function(){var e=Object(r.b)(),t=Object(s.f)(),n=Object(c.useState)(!1),o=Object(a.a)(n,2),i=o[0],u=o[1],j=Object(r.c)((function(e){return e.main.user.extra_type})),b=Object(r.c)((function(e){return e.main.user.type})),d=Object(c.useCallback)((function(){u(!0)}),[]),O=Object(c.useCallback)((function(){u(!1)}),[]),f=Object(c.useCallback)((function(n){u(!1),e(Object(l.f)(n)),setTimeout((function(){t.push("/")}),100)}),[e,t]);return{isOpen:i,userTypeButtons:Object(c.useMemo)((function(){return j.filter((function(e){return e.type!==b})).map((function(e){var t=e.title,n=e.type;return{label:t,onClick:function(){return f(n)}}}))}),[j,f,b]),handleOpen:d,handleClose:O}}(),t=e.isOpen,n=e.userTypeButtons,o=e.handleOpen,i=e.handleClose;return n.length?Object(f.jsxs)("div",{className:"user-select",children:[Object(f.jsx)("img",{src:"/images/user.svg",alt:"user",onClick:o}),Object(f.jsx)(m,{open:t,handleClose:i,children:Object(f.jsx)("div",{className:"user-select__modal",children:n.map((function(e){var t=e.label,n=e.onClick;return Object(f.jsx)(h.a,{label:t,onClick:n,className:"user-select__button"},t)}))})})]}):null}),v=function(){var e=function(){var e=Object(s.f)(),t=Object(c.useCallback)((function(){e.push("/")}),[e]),n=Object(c.useCallback)((function(){window.location.reload()}),[]);return{onLogoClick:t,onBackButtonClick:Object(c.useCallback)((function(){"/"!==e.location.pathname&&e.goBack()}),[e]),onReloadButtonClick:n,onForwardButtonClick:Object(c.useCallback)((function(){e.goForward()}),[e])}}(),t=e.onLogoClick,n=e.onBackButtonClick,a=e.onReloadButtonClick,r=e.onForwardButtonClick;return Object(f.jsxs)("div",{className:"header__navigation",children:[Object(f.jsx)("img",{className:"header__logo",src:"/images/logo.svg",alt:"logo",onClick:t}),Object(f.jsx)("img",{className:"header__navButton",src:"/images/arrow-left-nav.svg",alt:"logo",onClick:n}),Object(f.jsx)("img",{className:"header__navButton",src:"/images/arrow-right-nav.svg",alt:"logo",onClick:r}),Object(f.jsx)("img",{className:"header__navButton",src:"/images/reload.svg",alt:"logo",onClick:a})]})},g=function(){var e=function(){var e=Object(r.b)(),t=Object(s.f)(),n=Object(r.c)((function(e){return e.main.user})).type,o=Object(c.useState)(""),b=Object(a.a)(o,2),d=b[0],O=b[1],f=Object(c.useMemo)((function(){return n===j.a.BANK||n===j.a.DEVELOPER}),[n]),m=Object(c.useCallback)(i.a.debounce((function(t){return e(Object(u.g)(t))}),500),[]);return{searchText:d,isNotCompanyUser:f,onSearch:Object(c.useCallback)((function(e){m(e.target.value),O(e.target.value)}),[m]),onLogout:Object(c.useCallback)((function(){localStorage.clear(),e(Object(l.e)({type:null,token:null})),t.push("/")}),[e,t])}}(),t=e.searchText,n=e.isNotCompanyUser,o=e.onSearch,b=e.onLogout;return Object(f.jsxs)("div",{className:"header container",children:[Object(f.jsx)(v,{}),!n&&Object(f.jsxs)("div",{className:"header__search",children:[Object(f.jsx)("input",{type:"text",placeholder:"\u041f\u043e\u0448\u0443\u043a...",onChange:o,value:t}),Object(f.jsx)("img",{src:"/images/search.svg",alt:"search"})]}),Object(f.jsxs)("div",{className:"header__control",children:[!n&&Object(f.jsx)(p,{}),Object(f.jsx)("img",{src:"/images/log-out.svg",alt:"logout",onClick:b})]})]})}},414:function(e,t,n){},484:function(e,t,n){"use strict";n.r(t),n.d(t,"default",(function(){return m}));var c=n(0),a=n(143),s=n(18),r=(n(414),n(1)),o=n.n(r),i=n(2),l=n(106),u=n(22),j=n(4),b=n(5);function d(e){return O.apply(this,arguments)}function O(){return(O=Object(i.a)(o.a.mark((function e(t){var n;return o.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,Object(b.a)({url:"".concat(j.a,"/api/developer/representative"),headers:{Authorization:"Bearer ".concat(t)}});case 3:return n=e.sent,e.abrupt("return",n);case 7:return e.prev=7,e.t0=e.catch(0),console.error(e.t0),e.abrupt("return",null);case 11:case"end":return e.stop()}}),e,null,[[0,7]])})))).apply(this,arguments)}var f=n(8),m=function(){var e=function(){var e=Object(u.c)((function(e){return e.main.user})).token,t=Object(c.useState)(!0),n=Object(l.a)(t,2),a=n[0],s=n[1],r=Object(c.useState)([]),j=Object(l.a)(r,2),b=j[0],O=j[1];return Object(c.useEffect)((function(){Object(i.a)(o.a.mark((function t(){var n;return o.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(e){t.next=2;break}return t.abrupt("return");case 2:return t.next=4,d(e);case 4:(n=t.sent).success&&O(Object.values(n.data)),s(!1);case 7:case"end":return t.stop()}}),t)})))()}),[e]),{isLoading:a,sectionsCards:b}}(),t=e.isLoading,n=e.sectionsCards;return t?Object(f.jsx)(s.a,{}):Object(f.jsxs)("div",{className:"developer",children:[Object(f.jsx)(a.a,{}),0===n.length?Object(f.jsx)("div",{className:"developer__nodata",children:Object(f.jsx)("img",{src:"/images/nodata.png",alt:"no-data"})}):Object(f.jsx)("div",{className:"developer__body",children:Object(f.jsx)("div",{className:"developer__dashboard",children:n.map((function(e){var t=e.day,n=e.date,c=e.cards;return Object(f.jsxs)("div",{className:"section",children:[Object(f.jsx)("div",{className:"section__header",children:Object(f.jsxs)("span",{className:"title",children:[t," ",n]})}),Object(f.jsx)("div",{className:"section__body grid",children:c.map((function(e){var t=e.id,n=e.immovables,c=e.clients,a=e.time;return Object(f.jsxs)("div",{className:"card",children:[Object(f.jsxs)("div",{className:"card__title",children:[Object(f.jsx)("img",{src:"/images/clock.svg",alt:"clock"}),Object(f.jsx)("span",{children:a})]}),Object(f.jsx)("div",{className:"info-block",children:n.map((function(e){return Object(f.jsx)("span",{children:e},e)}))}),Object(f.jsx)("div",{className:"info-block",children:c.map((function(e){return Object(f.jsx)("span",{children:e},e)}))})]},t)}))})]},n)}))})})]})}}}]);
//# sourceMappingURL=14.a37cc3a7.chunk.js.map