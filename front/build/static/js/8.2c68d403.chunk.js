(this.webpackJsonpfront=this.webpackJsonpfront||[]).push([[8],{119:function(e,t,n){"use strict";n.d(t,"a",(function(){return a}));n(0),n(139);var c=n(8),a=function(e){var t=e.label,n=e.onClick,a=e.disabled,l=e.className;return Object(c.jsx)("button",{className:"primary-button ".concat(a?"disabled":""," ").concat(l||""),onClick:n,disabled:a,children:t})}},120:function(e,t,n){"use strict";var c=n(125);n.d(t,"a",(function(){return c.a}))},121:function(e,t,n){"use strict";n.d(t,"a",(function(){return u}));var c=n(111),a=n(0),l=(n(199),n(510)),i=n(512),o=n(479),s=n(501),r=n(8),d=function(e){var t=e.onChange,n=e.data,d=e.label,u=e.selectedValue,b=e.disabled,j=e.size,m=void 0===j?"medium":j,O=e.className,v=e.required,f=e.disableDefaultValue,h=Object(a.useState)(u||""),p=Object(c.a)(h,2),g=p[0],x=p[1];Object(a.useEffect)((function(){x(u||"")}),[u]);return Object(r.jsxs)(o.a,{variant:"outlined",className:"customSelect ".concat(O||""),size:m,children:[Object(r.jsx)(l.a,{children:d}),Object(r.jsxs)(s.a,{error:v&&!g,value:g,onChange:function(e){var n=e.target.value;x(n),t(n)},disabled:b||0===n.length,defaultValue:"",children:[!f&&Object(r.jsx)(i.a,{value:"",children:Object(r.jsx)("em",{children:"\u0412\u044b\u0431\u0440\u0430\u0442\u044c"})}),n.map((function(e){var t=e.id,n=e.title;return Object(r.jsx)(i.a,{value:t,children:n},t)}))]})]})},u=Object(a.memo)(d)},125:function(e,t,n){"use strict";var c=n(111),a=n(0),l=(n(137),n(507)),i=n(8);t.a=function(e){var t=e.label,n=e.onChange,o=e.value,s=void 0===o?"":o,r=e.type,d=void 0===r?"string":r,u=e.disabled,b=e.required,j=Object(a.useState)(s||""),m=Object(c.a)(j,2),O=m[0],v=m[1];Object(a.useEffect)((function(){v(s||"")}),[s]);return Object(i.jsx)(l.a,{error:b&&!O,label:t,variant:"outlined",value:O,onChange:function(e){v(e.target.value),n&&n(e.target.value)},type:d,className:"custom-input",disabled:u||!1})}},129:function(e,t,n){"use strict";n.d(t,"a",(function(){return s}));var c=n(0),a=n(491),l=n(492),i=(n(158),n(8)),o=function(e){var t=e.label,n=e.onChange,c=e.selected,o=e.disabled;return Object(i.jsx)(a.a,{control:Object(i.jsx)(l.a,{checked:c||!1,onChange:function(e){n(e.target.checked)},name:"checkedB",color:"primary"}),label:t,labelPlacement:"start",className:"custom-switch",disabled:o||!1})},s=Object(c.memo)(o)},133:function(e,t,n){"use strict";n.d(t,"a",(function(){return o}));var c=n(3),a=n(0),l=n(23),i=n(13),o=function(){var e=Object(l.b)(),t=Object(l.c)((function(e){return e.main})).modalInfo;return Object(a.useMemo)((function(){return Object(c.a)(Object(c.a)({},t),{},{handleClose:function(){return e(Object(i.d)(Object(c.a)(Object(c.a)({},t),{},{open:!1})))}})}),[t])}},135:function(e,t,n){"use strict";n.d(t,"a",(function(){return o}));n(0),n(140);var c=n(503),a=n(485),l=n(484),i=n(8),o=function(e){var t=e.open,n=e.handleClose,o=e.success,s=e.message;return Object(i.jsx)(c.a,{className:"modal-container",open:t,onClose:n,closeAfterTransition:!0,BackdropComponent:a.a,BackdropProps:{timeout:500},children:Object(i.jsx)(l.a,{in:t,children:Object(i.jsx)("div",{className:"modal ".concat(o?"modal-success":"modal-failed"),children:Object(i.jsx)("p",{className:"message",children:s})})})})}},137:function(e,t,n){},139:function(e,t,n){},140:function(e,t,n){},147:function(e,t,n){"use strict";n.d(t,"a",(function(){return o}));var c=n(111),a=n(0),l=(n(200),n(502)),i=n(8),o=function(e){var t=e.buttons,n=e.onChange,o=e.selected,s=e.unicId,r=Object(a.useState)(o||t[0].id),d=Object(c.a)(r,2),u=d[0],b=d[1];Object(a.useEffect)((function(){b(o||t[0].id),n(o||t[0].id)}),[o]);var j=function(e){b(e),n(e)};return Object(i.jsx)("div",{className:"radio-buttons-group",children:t.map((function(e){var n=e.id,c=e.title;return Object(i.jsxs)("div",{className:"radio-buttons-group__element ".concat(1===t.length?"edit":""),children:[Object(i.jsx)("input",{type:"radio",id:s+c,value:n,checked:u==n,onChange:function(){return j(n)},className:"input"}),Object(i.jsx)("label",{htmlFor:s+c,className:"label",children:c})]},Object(l.a)())}))})};t.b=Object(a.memo)(o)},152:function(e,t,n){},158:function(e,t,n){},160:function(e,t,n){"use strict";n.d(t,"a",(function(){return b}));var c=n(0),a=(n(152),n(41)),l=n(111),i=n(9),o=n(23),s=n(13),r=n(15),d=function(e,t){var n=Object(c.useState)(e),a=Object(l.a)(n,2),i=a[0],o=a[1];return Object(c.useEffect)((function(){var n=setTimeout((function(){o(e)}),t);return function(){clearTimeout(n)}}),[e]),i},u=n(8),b=function(){var e=function(){var e=Object(o.b)(),t=Object(i.f)(),n=Object(c.useState)(""),a=Object(l.a)(n,2),u=a[0],b=a[1],j=Object(c.useState)(0),m=Object(l.a)(j,2),O=m[0],v=m[1],f=d(u,1e3);return Object(c.useEffect)((function(){O?e(Object(r.g)(f)):v((function(e){return e+1}))}),[f]),{onSearch:Object(c.useCallback)((function(e){b(e.target.value)}),[u]),onLogout:Object(c.useCallback)((function(){localStorage.clear(),e(Object(s.e)({type:null,token:null})),t.push("/")}),[]),searchText:u}}(),t=e.onSearch,n=e.onLogout,b=e.searchText;return Object(u.jsxs)("div",{className:"header container",children:[Object(u.jsx)(a.b,{to:"/",className:"header__logo",children:Object(u.jsx)("img",{src:"/images/logo.svg",alt:"logo"})}),Object(u.jsxs)("div",{className:"header__search",children:[Object(u.jsx)("input",{type:"text",placeholder:"\u041f\u043e\u0448\u0443\u043a...",onChange:t,value:b}),Object(u.jsx)("img",{src:"/images/search.svg",alt:"search"})]}),Object(u.jsx)("div",{className:"header__control",children:Object(u.jsx)("img",{src:"/images/log-out.svg",alt:"logout",onClick:n})})]})}},163:function(e,t,n){"use strict";n.d(t,"a",(function(){return r}));var c=n(111),a=n(0),l=(n(201),n(267)),i=n.n(l),o=n(507),s=n(8),r=function(e){var t=e.label,n=e.onChange,l=e.value,r=void 0===l?"":l,d=e.disabled,u=Object(a.useState)(r||""),b=Object(c.a)(u,2),j=b[0],m=b[1];Object(a.useEffect)((function(){m(r||"")}),[r]);return Object(s.jsx)(i.a,{className:"custom-input",mask:"+38(999)999-99-99",value:j,disabled:d||!1,onChange:function(e){m(e.target.value),n&&n(e.target.value)},children:function(){return Object(s.jsx)(o.a,{variant:"outlined",label:t,disabled:d||!1})}})}},164:function(e,t,n){"use strict";n.d(t,"a",(function(){return a}));n(0),n(202);var c=n(8),a=function(e){var t=e.onClick,n=e.disabled,a=function(){n||t()};return Object(c.jsx)("div",{className:"add-form-button ".concat(n?"disabled":""),onClick:a,onKeyPress:a,children:Object(c.jsx)("img",{src:"/images/plus.svg",alt:"plus"})})}},172:function(e,t,n){"use strict";var c=n(147);n.d(t,"a",(function(){return c.b}))},178:function(e,t,n){"use strict";n.d(t,"a",(function(){return a}));n(0),n(203);var c=n(8),a=function(e){var t=e.onClick,n=e.index,a=e.disabled;return Object(c.jsx)("div",{className:"remove-form-button ".concat(a?"disabled":""),onClick:function(){a||t(n)},onKeyPress:function(){return t(n)},children:Object(c.jsx)("img",{src:"/images/minus.svg",alt:"minus"})})}},187:function(e,t){},198:function(e,t,n){},199:function(e,t,n){},200:function(e,t,n){},201:function(e,t,n){},202:function(e,t,n){},203:function(e,t,n){},209:function(e,t,n){"use strict";n.d(t,"a",(function(){return d}));var c=n(0),a=(n(198),n(121)),l=n(111),i=n(23),o=n(46),s=n(43),r=n(8),d=function(e){var t=function(e){var t=e.onFilterDataChange,n=e.horizontal,a=Object(i.b)(),r=Object(i.c)((function(e){return e.main.user})).token,d=Object(i.c)((function(e){return e.filter})).filterInitialData;Object(c.useEffect)((function(){a(Object(o.b)())}),[r]);var u=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.reader}),[d]),b=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.notary}),[d]),j=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.accompanying}),[d]),m=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.contract_type}),[d]),O=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.developer}),[d]),v=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.sort_type}),[d]),f=Object(c.useState)([]),h=Object(l.a)(f,2),p=h[0],g=h[1],x=Object(c.useMemo)((function(){return Boolean(d)}),[d]),C=Object(c.useState)(null),_=Object(l.a)(C,2),y=_[0],k=_[1],N=Object(c.useState)(null),S=Object(l.a)(N,2),A=S[0],w=S[1],D=Object(c.useState)(null),T=Object(l.a)(D,2),M=T[0],E=T[1],z=Object(c.useState)(null),I=Object(l.a)(z,2),R=I[0],L=I[1],F=Object(c.useState)(null),V=Object(l.a)(F,2),B=V[0],P=V[1],q=Object(c.useState)(null),J=Object(l.a)(q,2),K=J[0],Q=J[1],H=Object(c.useState)(null),W=Object(l.a)(H,2),G=W[0],U=W[1],X=Object(c.useCallback)((function(){k(null),w(null),E(null),L(null),P(null),Q(null),U(null)}),[]);return Object(c.useEffect)((function(){Q(null),r&&B&&Object(s.a)(r,+B).then((function(e){return g(e.representative||[])}))}),[B]),Object(c.useEffect)((function(){var e={notary_id:y||null,reader_id:A||null,accompanying_id:M||null,contract_type_id:R||null,developer_id:B||null,dev_representative_id:K||null};n||(e.sort_type=G),t(e)}),[y,A,M,R,B,K,G]),{shouldRenderFilter:x,notaries:b,readers:u,accompanyings:j,contractTypes:m,developers:O,representative:p,sortType:v,selectedNotary:y,selectedReader:A,selectedRepresentative:K,selectedDeveloper:B,selectedContractType:R,selectedAccompanying:M,selectedSortType:G,setSelectedNotary:k,setSelectedReader:w,setSelectedAccompanying:E,setSelectedContractType:L,setSelectedDeveloper:P,setSelectedRepresentative:Q,setSelectedSortType:U,clearAll:X}}(e);return t.shouldRenderFilter?Object(r.jsxs)("div",{className:"filter ".concat(e.horizontal?"horizontal":""),children:[!e.horizontal&&Object(r.jsxs)("div",{className:"filter__header",children:[Object(r.jsx)("span",{className:"title",children:"\u0424\u0456\u043b\u044c\u0442\u0440"}),Object(r.jsx)("img",{src:"/images/clear-form.svg",alt:"clear form",onClick:t.clearAll,className:"filter__clear"})]}),Object(r.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"115px":"100%"},children:Object(r.jsx)(a.a,{data:t.notaries,selectedValue:t.selectedNotary,onChange:t.setSelectedNotary,label:"\u041d\u043e\u0442\u0430\u0440\u0456\u0443\u0441",size:e.horizontal?"small":"medium"})}),Object(r.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"90px":"100%"},children:Object(r.jsx)(a.a,{data:t.readers,selectedValue:t.selectedReader,onChange:t.setSelectedReader,label:"\u0427\u0438\u0442\u0430\u0447",size:e.horizontal?"small":"medium"})}),Object(r.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"110px":"100%"},children:Object(r.jsx)(a.a,{data:t.accompanyings,selectedValue:t.selectedAccompanying,onChange:t.setSelectedAccompanying,label:"\u0412\u0438\u0434\u0430\u0432\u0430\u0447",size:e.horizontal?"small":"medium"})}),Object(r.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"150px":"100%"},children:Object(r.jsx)(a.a,{data:t.contractTypes,selectedValue:t.selectedContractType,onChange:t.setSelectedContractType,label:"\u0422\u0438\u043f \u0434\u043e\u0433\u043e\u0432\u043e\u0440\u0443",size:e.horizontal?"small":"medium"})}),Object(r.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"140px":"100%"},children:Object(r.jsx)(a.a,{data:t.developers,selectedValue:t.selectedDeveloper,onChange:t.setSelectedDeveloper,label:"\u0417\u0430\u0431\u0443\u0434\u043e\u0432\u043d\u0438\u043a",size:e.horizontal?"small":"medium"})}),Object(r.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"125px":"100%"},children:Object(r.jsx)(a.a,{data:t.representative,selectedValue:t.selectedRepresentative,onChange:t.setSelectedRepresentative,label:"\u041f\u0456\u0434\u043f\u0438\u0441\u0430\u043d\u0442",size:e.horizontal?"small":"medium"})}),!e.horizontal&&Object(r.jsx)("div",{className:"filter__select",children:Object(r.jsx)(a.a,{data:t.sortType,selectedValue:t.selectedSortType,onChange:t.setSelectedSortType,label:"\u0421\u043e\u0440\u0442\u0443\u0432\u0430\u0442\u0438",size:"medium"})}),e.horizontal&&Object(r.jsx)("div",{className:" df",children:Object(r.jsx)("img",{src:"/images/clear-form.svg",alt:"clear form",onClick:t.clearAll,className:"filter__clear"})})]}):null}},407:function(e,t,n){},408:function(e,t,n){},409:function(e,t,n){},410:function(e,t,n){},423:function(e,t){},425:function(e,t,n){},426:function(e,t,n){},427:function(e,t,n){},428:function(e,t,n){},429:function(e,t,n){},430:function(e,t,n){},496:function(e,t,n){"use strict";n.r(t),n.d(t,"default",(function(){return ae}));var c=n(0),a=n(160),l=n(3),i=(n(407),n(408),n(502)),o=n(1),s=n.n(o),r=n(2),d=n(23),u=n(18),b=n(15),j=function(e,t,n,c,a){var l=n[Math.floor(c/e.length)],i=l.day,o=l.date,s=l.year,r=e[c%e.length].time,d=t[a].id;return{day:i,date:o.split(".").reverse().join("."),year:s,time:r,room:d}},m=n(24),O=(n(409),n(8)),v=function(e){var t=e.day,n=e.hours;return Object(O.jsxs)("div",{className:"scheduler__weekDay",children:[Object(O.jsx)("div",{className:"scheduler__day",children:Object(O.jsxs)("p",{children:[t.day,Object(O.jsx)("br",{}),t.date]})}),Object(O.jsx)("div",{className:"scheduler__timeLine",children:n.map((function(e){var t=e.time;return Object(O.jsx)("p",{children:t},t)}))})]})},f=n(111),h=(n(410),n(411)),p=n.n(h),g=n(422),x=n.n(g),C=n(185),_=n.n(C),y=(n(423),Object(h.WidthProvider)(p.a));function k(e){var t=e.appointments,n=e.cols,a=e.handleDrag,l=e.handleClick,o=Object(c.useState)(1200),s=Object(f.a)(o,2),r=s[0],u=s[1],b=Object(d.c)((function(e){return e.scheduler})).schedulerLock,j=Object(d.c)((function(e){return e.scheduler.oldSelectedAppointment}));Object(c.useEffect)((function(){u(x()(".scheduler__appointments").width())}),[]);var m=Object(c.useCallback)((function(e,t){return(null===j||void 0===j?void 0:j.raw)===e&&(null===j||void 0===j?void 0:j.cell)===t}),[j]);return t?Object(O.jsx)(y,{className:"scheduler__dragAndDrop",cols:n,rowHeight:80,width:r,margin:[0,0],containerPadding:[0,0],verticalCompact:!1,preventCollision:!0,layout:t,onDragStop:function(e,t){var n=e.find((function(e){return e.i===t.i}));a(n),l(n)},isDraggable:!b,children:t.map((function(e){return Object(O.jsxs)("div",{className:"appointment",style:{borderLeft:"4px solid ".concat(e.color),backgroundColor:m(e.y,e.x)?e.color:""},onClickCapture:function(){return l(e)},children:[Object(O.jsx)("div",{className:"appointment__title",children:_()(e.title)}),Object(O.jsx)("table",{className:"appointment__table",children:Object(O.jsx)("tbody",{children:Object(O.jsx)("tr",{children:Object.values(e.short_info).map((function(e){return Object(O.jsx)("td",{children:e},Object(i.a)())}))})})})]},e.i)}))}):Object(O.jsx)("span",{children:"Loading..."})}var N=n(424),S=n.n(N),A=function(e){var t=function(e){var t=e.raw,n=e.cell,a=Object(d.c)((function(e){return e.scheduler})).options,i=Object(d.b)(),o=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.rooms}),[a]),s=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.work_time}),[a]),r=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.day_and_date}),[a]);return{onClick:Object(c.useCallback)((function(){var e=j(s,o,r,t,n);S()("".concat(e.year,".").concat(e.date,". ").concat(e.time)).isBefore(S()())||i(Object(u.l)(Object(l.a)(Object(l.a)({},e),{},{raw:t,cell:n,date:e.date})))}),[s,o,r,t,n])}}(e).onClick;return Object(O.jsx)("td",{onClick:t,style:{width:"calc(100% / ".concat(e.rowsQuantity,")"),backgroundColor:e.selected?"#E5E5E5":""}})};function w(e){var t=e.rows,n=e.columns,c={newSelectedAppointment:Object(d.c)((function(e){return e.scheduler.newSelectedAppointment}))}.newSelectedAppointment;return Object(O.jsx)("div",{className:"scheduler__bodyTable",children:Object(O.jsx)("table",{children:Object(O.jsx)("tbody",{children:t.map((function(e,a){return Object(O.jsx)("tr",{children:n.map((function(e,n){return Object(O.jsx)(A,{selected:(null===c||void 0===c?void 0:c.raw)===a&&(null===c||void 0===c?void 0:c.cell)===n,rowsQuantity:t.length,raw:a,cell:n},Object(i.a)())}))},Object(i.a)())}))})})})}var D=function(){var e=function(){var e=Object(d.b)(),t=Object(d.c)((function(e){return e.main.user})).token,n=Object(d.c)((function(e){return e.scheduler})),a=n.options,i=n.isLoading,o=Object(d.c)((function(e){return e.appointments})).appointments;Object(c.useEffect)((function(){return i||(e(Object(u.f)()),e(Object(b.d)())),function(){e(Object(b.h)([]))}}),[t]);var m=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.rooms}),[a]),O=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.work_time}),[a]),v=Object(c.useMemo)((function(){return i||!a}),[i,m,O]),f=Object(c.useMemo)((function(){return new Array((null===m||void 0===m?void 0:m.length)||0).fill(1)}),[m]),h=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.day_and_date}),[a]),p=Object(c.useMemo)((function(){return new Array((null===O||void 0===O?void 0:O.length)*(null===h||void 0===h?void 0:h.length)||0).fill(1)}),[O]),g=Object(c.useCallback)((function(t){var n=j(O,m,h,t.y,t.x),c={date_time:"".concat(n.year,".").concat(n.date,". ").concat(n.time),room_id:n.room};e(Object(u.g)(c,t.i))}),[O,h,m,h]),x=Object(c.useCallback)(function(){var t=Object(r.a)(s.a.mark((function t(n){var c,a,i,o;return s.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:c=n.x,a=n.y,i=n.i,o=j(O,m,h,a,c),e(Object(u.d)(i)),e(Object(u.m)(Object(l.a)(Object(l.a)({},o),{},{raw:a,cell:c,i:i,date:o.date})));case 4:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}(),[O,m,h]);return{shouldLoad:v,rooms:m,hours:O,tableRows:p,tableColumns:f,days:h,appointments:o,handleAppointmentDrag:g,onAppointmentClick:x}}(),t=e.shouldLoad,n=e.rooms,a=e.hours,o=e.tableRows,f=e.tableColumns,h=e.days,p=e.appointments,g=e.handleAppointmentDrag,x=e.onAppointmentClick;return t?Object(O.jsx)("div",{className:"scheduler",children:Object(O.jsx)(m.a,{})}):Object(O.jsxs)("div",{className:"scheduler",children:[Object(O.jsxs)("div",{className:"scheduler__header",children:[Object(O.jsx)("div",{}),Object(O.jsx)("div",{children:Object(O.jsx)("table",{children:Object(O.jsx)("tbody",{children:Object(O.jsx)("tr",{children:n.map((function(e){var t=e.title;return Object(O.jsx)("td",{style:{width:"calc(100% / ".concat(n.length,")")},children:t},t)}))})})})})]}),Object(O.jsxs)("div",{className:"scheduler__body",children:[Object(O.jsx)("div",{className:"scheduler__dayBar",children:h.map((function(e){return Object(O.jsx)(v,{day:e,hours:a},Object(i.a)())}))}),Object(O.jsxs)("div",{className:"scheduler__appointments",children:[Object(O.jsx)(w,{rows:o,columns:f}),Object(O.jsx)(k,{appointments:p,cols:f.length,handleDrag:g,handleClick:x})]})]})]})},T=function(){var e=Object(d.c)((function(e){return e.appointments})).appointments;return Object(O.jsx)("span",{style:{whiteSpace:"nowrap"},children:"\u0412 \u0440\u043e\u0431\u043e\u0442\u0456: ".concat(null===e||void 0===e?void 0:e.length)})},M=n(209),E=function(){var e=function(){var e=Object(c.useState)(!1),t=Object(f.a)(e,2),n=t[0],a=t[1],l=Object(d.b)();return{onFilterDataChange:Object(c.useCallback)((function(e){n?l(Object(b.f)(e)):a(!0)}),[n])}}().onFilterDataChange;return Object(O.jsx)(M.a,{onFilterDataChange:e,horizontal:!0})},z=(n(425),function(){var e=function(){var e=Object(d.b)(),t=Object(d.c)((function(e){return e.scheduler})).schedulerLock;return{onClick:Object(c.useCallback)((function(){e(Object(u.k)(!t))}),[t]),schedulerLock:t}}(),t=e.onClick,n=e.schedulerLock;return Object(O.jsx)("div",{className:"scheduler__lock-button ".concat(n?"":"unLock"),children:Object(O.jsx)("img",{src:"/images/lock.svg",alt:"lock",onClick:t})})}),I=(n(426),function(){return Object(O.jsxs)("div",{className:"scheduler__filter",children:[Object(O.jsx)(T,{}),Object(O.jsx)(E,{}),Object(O.jsx)(z,{})]})}),R=(n(427),n(172)),L=n(121),F=(n(428),n(429),n(164)),V=n(125),B=n(178),P=n(163),q=function(e){var t=function(e){var t=e.onChange,n=e.clients;return{onPhoneChange:Object(c.useCallback)((function(e,c){t(e,Object(l.a)(Object(l.a)({},n[e]),{},{phone:c}))}),[n]),onNameChange:Object(c.useCallback)((function(e,c){t(e,Object(l.a)(Object(l.a)({},n[e]),{},{full_name:c}))}),[n])}}(e);return Object(O.jsx)("div",{className:"mv12",children:e.clients.map((function(n,c){return Object(O.jsxs)("div",{className:"clients__item mv12",children:[Object(O.jsx)(V.a,{label:"\u041f\u0406\u0411",value:n.full_name,onChange:function(e){return t.onNameChange(c,e)},disabled:e.disabled||!1}),Object(O.jsxs)("div",{className:"mv12 df-jc-sb",children:[Object(O.jsx)(P.a,{label:"\u041d\u043e\u043c\u0435\u0440 \u0442\u0435\u043b\u0435\u0444\u043e\u043d\u0443",value:n.phone,onChange:function(e){return t.onPhoneChange(c,e)},disabled:e.disabled||!1}),e.clients.length>1&&Object(O.jsx)("div",{style:{marginLeft:"12px"},children:Object(O.jsx)(B.a,{onClick:e.onRemove,index:c,disabled:e.disabled||!1})}),c===e.clients.length-1&&Object(O.jsx)("div",{style:{marginLeft:"12px"},children:Object(O.jsx)(F.a,{onClick:e.onAdd,disabled:e.disabled||!1})})]})]})}))})},J=Object(c.memo)(q),K=n(119),Q=(n(430),n(120)),H=n(129),W=function(e){var t=function(e){var t=e.immovables,n=e.onChange,a=Object(d.c)((function(e){return e.scheduler})),i=a.options,o=a.developersInfo;return{building:Object(c.useMemo)((function(){return(null===o||void 0===o?void 0:o.building)||[]}),[o]),contracts:Object(c.useMemo)((function(){return null===i||void 0===i?void 0:i.form_data.contract_type}),[i]),immovableTypes:Object(c.useMemo)((function(){return null===i||void 0===i?void 0:i.form_data.immovable_type}),[i]),onContractChange:Object(c.useCallback)((function(e,c){n(e,Object(l.a)(Object(l.a)({},t[e]),{},{contract_type_id:c}))}),[t]),onBuildingChange:Object(c.useCallback)((function(e,c){n(e,Object(l.a)(Object(l.a)({},t[e]),{},{building_id:+c}))}),[t]),onImmovableTypeChange:Object(c.useCallback)((function(e,c){n(e,Object(l.a)(Object(l.a)({},t[e]),{},{imm_type_id:c}))}),[t]),onBankChange:Object(c.useCallback)((function(e,c){n(e,Object(l.a)(Object(l.a)({},t[e]),{},{bank:c}))}),[t]),onProxyChange:Object(c.useCallback)((function(e,c){n(e,Object(l.a)(Object(l.a)({},t[e]),{},{proxy:c}))}),[t]),onImmNumChange:Object(c.useCallback)((function(e,c){n(e,Object(l.a)(Object(l.a)({},t[e]),{},{imm_number:c}))}),[t])}}(e);return Object(O.jsx)("div",{className:"mv12 immovables__group",children:e.immovables.map((function(n,c){return Object(O.jsxs)("div",{className:"immovables__item mv12",children:[Object(O.jsx)(R.a,{buttons:e.disabled?t.contracts.filter((function(e){return e.id===(n.contract_type_id||t.contracts[0].id)})):t.contracts,onChange:function(e){return t.onContractChange(c,+e)},selected:n.contract_type_id,unicId:"contract-".concat(c)}),Object(O.jsx)("div",{className:"mv12",children:Object(O.jsx)(L.a,{required:!0,onChange:function(e){return t.onBuildingChange(c,e)},data:t.building,label:"\u0411\u0443\u0434\u0438\u043d\u043e\u043a",selectedValue:n.building_id,disabled:e.disabled||!1})}),Object(O.jsx)(R.a,{buttons:e.disabled?t.immovableTypes.filter((function(e){return e.id===(n.imm_type_id||t.immovableTypes[0].id)})):t.immovableTypes,onChange:function(e){return t.onImmovableTypeChange(c,+e)},selected:n.imm_type_id,unicId:"types-".concat(c)}),Object(O.jsx)("div",{className:"mv12",children:Object(O.jsx)(H.a,{label:"\u0411\u0430\u043d\u043a",onChange:function(e){return t.onBankChange(c,e)},selected:n.bank,disabled:e.disabled})}),Object(O.jsx)("div",{className:"mv12",children:Object(O.jsx)(H.a,{label:"\u0414\u043e\u0432\u0456\u0440\u0435\u043d\u0456\u0441\u0442\u044c",onChange:function(e){return t.onProxyChange(c,e)},selected:n.proxy,disabled:e.disabled})}),Object(O.jsxs)("div",{className:"mv12 df-jc-sb",children:[Object(O.jsx)(Q.a,{required:!0,label:"\u041d\u043e\u043c\u0435\u0440 \u043d\u0435\u0440\u0443\u0445\u043e\u043c\u043e\u0441\u0442\u0456",onChange:function(e){return t.onImmNumChange(c,e)},value:n.imm_number,disabled:e.disabled}),e.immovables.length>1&&Object(O.jsx)("div",{style:{marginLeft:"12px"},children:Object(O.jsx)(B.a,{onClick:e.onRemove,index:c,disabled:e.disabled})}),c===e.immovables.length-1&&Object(O.jsx)("div",{style:{marginLeft:"12px"},children:Object(O.jsx)(F.a,{onClick:e.onAdd,disabled:e.disabled})})]})]})}))})},G=Object(c.memo)(W),U=n(28),X={contract_type_id:null,building_id:null,imm_type_id:null,imm_number:null,bank:!1,proxy:!1},Y={phone:null,full_name:null},Z=function(e){var t=function(e){var t=e.selectedCard,n=e.initialValues,a=e.edit,i=Object(d.b)(),o=Object(d.c)((function(e){return e.main.user})).token,s=Object(d.c)((function(e){return e.scheduler})),r=s.options,b=s.developersInfo,j=s.isLoading,m=Object(c.useState)(a||!1),O=Object(f.a)(m,2),v=O[0],h=O[1],p=Object(c.useState)((null===n||void 0===n?void 0:n.card.notary_id)||null),g=Object(f.a)(p,2),x=g[0],C=g[1],_=Object(c.useState)(null),y=Object(f.a)(_,2),k=y[0],N=y[1],S=Object(c.useState)(null),A=Object(f.a)(S,2),w=A[0],D=A[1],T=Object(c.useState)(null),M=Object(f.a)(T,2),E=M[0],z=M[1],I=Object(c.useState)([X]),R=Object(f.a)(I,2),L=R[0],F=R[1],V=Object(c.useState)([Y]),B=Object(f.a)(V,2),P=B[0],q=B[1],J=Object(c.useMemo)((function(){return j||!r}),[r,j]),K=Object(c.useMemo)((function(){return null===r||void 0===r?void 0:r.form_data.notary}),[r]),Q=Object(c.useMemo)((function(){return null===r||void 0===r?void 0:r.form_data.developer}),[r]),H=Object(c.useMemo)((function(){return(null===b||void 0===b?void 0:b.manager)||[]}),[b]),W=Object(c.useMemo)((function(){return(null===b||void 0===b?void 0:b.representative)||[]}),[b]),G=Object(c.useCallback)((function(e){C(e)}),[]);Object(c.useEffect)((function(){n&&(h(!0),C(n.card.notary_id),N(n.card.dev_company_id),D(n.card.dev_representative_id),z(n.card.dev_manager_id),F(0===n.immovables.length?[X]:n.immovables),q(0===n.clients.length?[Y]:n.clients)),(null===n||void 0===n?void 0:n.card.dev_company_id)&&i(Object(u.e)(n.card.dev_company_id))}),[n]);var Z=Object(c.useCallback)((function(e){N(e),z(null),D(null),F((function(e){return e.map((function(e){return Object(l.a)(Object(l.a)({},e),{},{building_id:null})}))})),e||i(Object(u.i)({})),i(Object(u.e)(e))}),[]),$=Object(c.useCallback)((function(e){D(e)}),[w]),ee=Object(c.useCallback)((function(e){z(e)}),[E]),te=Object(c.useCallback)((function(e,t){L[e]=t,F(Object(U.a)(L))}),[L]),ne=Object(c.useCallback)((function(e,t){P[e]=t,q(Object(U.a)(P))}),[P]),ce=Object(c.useCallback)((function(){C(null),N(null),D(null),z(null),F([X]),q([Y])}),[]),ae=Object(c.useCallback)((function(){F([].concat(Object(U.a)(L),[X]))}),[L]),le=Object(c.useCallback)((function(e){F((function(t){return t.filter((function(t,n){return n!==e}))}))}),[L]),ie=Object(c.useCallback)((function(){q([].concat(Object(U.a)(P),[Y]))}),[P]),oe=Object(c.useCallback)((function(e){q((function(t){return t.filter((function(t,n){return n!==e}))}))}),[P]),se=Object(c.useCallback)((function(){i(Object(u.h)(t.i))}),[t]),re=Object(c.useMemo)((function(){return Boolean(k)&&L.length&&L.every((function(e){return e.building_id&&e.imm_number}))&&t}),[k,L,t]),de=Object(c.useCallback)((function(){var e="".concat(t.year,".").concat(t.date,". ").concat(t.time),n={immovables:L.map((function(e){return Object(l.a)(Object(l.a)({},e),{},{contract_type_id:e.contract_type_id||r.form_data.immovable_type[0].id,imm_type_id:e.imm_type_id||r.form_data.immovable_type[0].id})})),clients:P,date_time:e,dev_company_id:k,dev_representative_id:w,dev_manager_id:E,room_id:t.room,notary_id:x||K[0].id};o&&(a?(i(Object(u.c)(n,t.i)),h(!0)):(i(Object(u.b)(n)),i(Object(u.l)(null)),ce()))}),[k,w,E,x,L,P,a,t]);return{shouldLoad:J,notaries:K,representative:W,developers:Q,manager:H,immovables:L,clients:P,activeAddButton:re,insideEdit:v,onNotaryChange:G,onDeveloperChange:Z,onRepresentativeChange:$,onManagerChange:ee,onImmovablesChange:te,onAddImmovables:ae,onRemoveImmovable:le,onRemoveClient:oe,onClientsChange:ne,onAddClients:ie,onClearAll:ce,onFormCreate:de,setEdit:h,onDeleteCard:se,selectedNotaryId:x,selectedDeveloperId:k,selectedDevRepresentativeId:w,selecedDevManagerId:E}}(e);return t.shouldLoad?Object(O.jsx)("div",{className:"schedulerForm",children:Object(O.jsx)(m.a,{})}):Object(O.jsx)("div",{className:"schedulerForm",children:Object(O.jsxs)("div",{className:"schedulerForm__forms",children:[Object(O.jsxs)("div",{className:"schedulerForm__header",children:[Object(O.jsx)("p",{className:"title",children:t.insideEdit||e.edit?"\u0417\u0430\u043f\u0438\u0441 \u2116 ".concat(e.selectedCard.i):"\u041d\u043e\u0432\u0438\u0439 \u0437\u0430\u043f\u0438\u0441"}),t.insideEdit?Object(O.jsx)("img",{src:"/images/delete.svg",alt:"delete",className:"clear-icon",onClick:t.onDeleteCard}):Object(O.jsx)("img",{src:"/images/clear.svg",alt:"clear",className:"clear-icon",onClick:t.onClearAll})]}),Object(O.jsx)("div",{className:"mv12",children:Object(O.jsx)(R.a,{buttons:t.insideEdit?t.notaries.filter((function(e){return e.id===t.selectedNotaryId})):t.notaries,onChange:t.onNotaryChange,selected:t.selectedNotaryId,unicId:"notaries"})}),Object(O.jsx)("div",{className:"mv12",children:Object(O.jsx)(L.a,{required:!0,label:"\u0417\u0430\u0431\u0443\u0434\u043e\u0432\u043d\u0438\u043a",data:t.developers,onChange:t.onDeveloperChange,selectedValue:t.selectedDeveloperId,disabled:t.insideEdit||!1})}),Object(O.jsx)("div",{className:"mv12",children:Object(O.jsx)(L.a,{onChange:t.onRepresentativeChange,data:t.representative,label:"\u041f\u0456\u0434\u043f\u0438\u0441\u0430\u043d\u0442",selectedValue:t.selectedDevRepresentativeId,disabled:t.insideEdit||!1})}),Object(O.jsx)("div",{className:"mv12",children:Object(O.jsx)(L.a,{onChange:t.onManagerChange,data:t.manager,label:"\u041c\u0435\u043d\u0435\u0434\u0436\u0435\u0440",selectedValue:t.selecedDevManagerId,disabled:t.insideEdit||!1})}),Object(O.jsx)(G,{immovables:t.immovables,onChange:t.onImmovablesChange,onAdd:t.onAddImmovables,onRemove:t.onRemoveImmovable,disabled:t.insideEdit||!1}),Object(O.jsx)(J,{clients:t.clients,onChange:t.onClientsChange,onAdd:t.onAddClients,onRemove:t.onRemoveClient,disabled:t.insideEdit||!1}),Object(O.jsxs)("div",{className:"mv12",children:[t.insideEdit&&Object(O.jsx)(K.a,{label:"\u0420\u0435\u0434\u0430\u0433\u0443\u0432\u0430\u0442\u0438",onClick:function(){return t.setEdit(!1)},disabled:!e.edit&&!t.activeAddButton,className:"schedulerForm__editButton"}),!t.insideEdit&&Object(O.jsx)(K.a,{label:"".concat(e.edit?"\u0417\u0431\u0435\u0440\u0435\u0433\u0442\u0438":"\u0421\u0442\u0432\u043e\u0440\u0438\u0442\u0438"),onClick:t.onFormCreate,disabled:!t.activeAddButton})]})]})})},$=Object(c.memo)(Z),ee=function(){var e=function(){var e=Object(d.b)(),t=Object(c.useState)(0),n=Object(f.a)(t,2),a=n[0],l=n[1],i=Object(d.c)((function(e){return e.scheduler.newSelectedAppointment})),o=Object(d.c)((function(e){return e.scheduler.oldSelectedAppointment})),s=Object(d.c)((function(e){return e.scheduler.editAppointmentData})),r=Object(c.useCallback)((function(){e(Object(u.m)(null)),e(Object(u.j)(null))}),[]);return Object(c.useEffect)((function(){l(s?1:0)}),[s]),Object(c.useEffect)((function(){l(0)}),[i]),{newSelectedAppointment:i,oldSelectedAppointment:o,editAppointmentData:s,selectedTab:a,setSelectedTab:l,onCloseTab:r}}();return Object(O.jsxs)("div",{className:"schedulerForm scheduler__form",children:[Object(O.jsxs)("div",{className:"schedulerForm__tabs",children:[Object(O.jsx)("div",{className:"item ".concat(0===e.selectedTab?"selected":""),style:{backgroundColor:e.editAppointmentData?"":"white"},onClick:function(){return e.setSelectedTab(0)},children:e.newSelectedAppointment?"".concat(e.newSelectedAppointment.day," ").concat(e.newSelectedAppointment.time," ").concat(e.newSelectedAppointment.date.split(".").reverse().join(".")):"\u0412\u0438\u0431\u0435\u0440\u0456\u0442\u044c \u0434\u0430\u0442\u0443"}),e.oldSelectedAppointment&&e.editAppointmentData&&Object(O.jsxs)("div",{className:"item ".concat(1===e.selectedTab?"selected":""),onClick:function(){return e.setSelectedTab(1)},children:["".concat(e.oldSelectedAppointment.day," ").concat(e.oldSelectedAppointment.time," ").concat(e.oldSelectedAppointment.date.split(".").reverse().join(".")),Object(O.jsx)("img",{src:"/images/x.svg",alt:"close",className:"clear-icon",onClick:e.onCloseTab})]})]}),0===e.selectedTab&&Object(O.jsx)($,{selectedCard:e.newSelectedAppointment}),1===e.selectedTab&&e.editAppointmentData&&e.oldSelectedAppointment&&Object(O.jsx)($,{selectedCard:e.oldSelectedAppointment,initialValues:e.editAppointmentData,edit:!0})]})},te=n(133),ne=n(135),ce=function(){var e=Object(te.a)();return Object(O.jsxs)("div",{className:"scheduler__container",children:[Object(O.jsxs)("div",{className:"scheduler__dataView",children:[Object(O.jsx)(I,{}),Object(O.jsx)(D,{})]}),Object(O.jsx)(ee,{}),Object(O.jsx)(ne.a,Object(l.a)({},e))]})},ae=function(){return Object(O.jsxs)(O.Fragment,{children:[Object(O.jsx)(a.a,{}),Object(O.jsx)(ce,{})]})}}}]);
//# sourceMappingURL=8.2c68d403.chunk.js.map