(this.webpackJsonpfront=this.webpackJsonpfront||[]).push([[8],{117:function(e,t,n){"use strict";n.d(t,"a",(function(){return i}));var c=n(111),a=n(0),l=(n(141),n(8)),i=function(e){var t=e.label,n=e.onClick,i=e.disabled,o=e.className,r=Object(a.useState)(!1),s=Object(c.a)(r,2),d=s[0],u=s[1],b=Object(a.useCallback)((function(e){u(!0),n(e)}),[n]);return Object(a.useEffect)((function(){u(!1)}),[n]),Object(l.jsx)("button",{className:"primary-button\n        ".concat(i?"disabled":"","\n        ").concat(o||"","\n        ").concat(d?"clicked":"","\n        "),onClick:b,disabled:i,children:t})}},120:function(e,t,n){"use strict";var c=n(125);n.d(t,"a",(function(){return c.a}))},121:function(e,t,n){"use strict";n.d(t,"a",(function(){return u}));var c=n(111),a=n(0),l=(n(201),n(513)),i=n(515),o=n(482),r=n(504),s=n(8),d=function(e){var t=e.onChange,n=e.data,d=e.label,u=e.selectedValue,b=e.disabled,j=e.size,m=void 0===j?"medium":j,O=e.className,f=e.required,v=e.disableDefaultValue,h=Object(a.useState)(u||""),p=Object(c.a)(h,2),g=p[0],C=p[1];Object(a.useEffect)((function(){C(u||"")}),[u]);return Object(s.jsxs)(o.a,{variant:"outlined",className:"customSelect ".concat(O||""),size:m,children:[Object(s.jsx)(l.a,{children:d}),Object(s.jsxs)(r.a,{error:f&&!g,value:g,onChange:function(e){var n=e.target.value;C(n),t(n)},disabled:b||0===n.length,defaultValue:"",children:[!v&&Object(s.jsx)(i.a,{value:"",children:Object(s.jsx)("em",{children:"\u0412\u044b\u0431\u0440\u0430\u0442\u044c"})}),n.map((function(e){var t=e.id,n=e.title;return Object(s.jsx)(i.a,{value:t,children:n},t)}))]})]})},u=Object(a.memo)(d)},125:function(e,t,n){"use strict";var c=n(111),a=n(0),l=(n(142),n(510)),i=n(8);t.a=function(e){var t=e.label,n=e.onChange,o=e.value,r=void 0===o?"":o,s=e.type,d=void 0===s?"string":s,u=e.disabled,b=e.required,j=Object(a.useState)(r||""),m=Object(c.a)(j,2),O=m[0],f=m[1];Object(a.useEffect)((function(){f(r||"")}),[r]);return Object(i.jsx)(l.a,{error:b&&!O,label:t,variant:"outlined",value:O,onChange:function(e){f(e.target.value),n&&n(e.target.value)},type:d,className:"custom-input",disabled:u||!1})}},129:function(e,t,n){"use strict";n.d(t,"a",(function(){return r}));var c=n(0),a=n(492),l=n(493),i=(n(159),n(8)),o=function(e){var t=e.label,n=e.onChange,c=e.selected,o=e.disabled;return Object(i.jsx)(a.a,{control:Object(i.jsx)(l.a,{checked:c||!1,onChange:function(e){n(e.target.checked)},name:"checkedB",color:"primary"}),label:t,labelPlacement:"start",className:"custom-switch",disabled:o||!1})},r=Object(c.memo)(o)},136:function(e,t,n){"use strict";n.d(t,"a",(function(){return o}));var c=n(3),a=n(0),l=n(23),i=n(11),o=function(){var e=Object(l.b)(),t=Object(l.c)((function(e){return e.main})).modalInfo;return Object(a.useMemo)((function(){return Object(c.a)(Object(c.a)({},t),{},{handleClose:function(){return e(Object(i.d)(Object(c.a)(Object(c.a)({},t),{},{open:!1})))}})}),[t])}},138:function(e,t,n){"use strict";n.d(t,"a",(function(){return o}));n(0),n(143);var c=n(505),a=n(475),l=n(476),i=n(8),o=function(e){var t=e.open,n=e.handleClose,o=e.success,r=e.message;return Object(i.jsx)(c.a,{className:"modal-container",open:t,onClose:n,closeAfterTransition:!0,BackdropComponent:a.a,BackdropProps:{timeout:500},children:Object(i.jsx)(l.a,{in:t,children:Object(i.jsx)("div",{className:"modal ".concat(o?"modal-success":"modal-failed"),children:Object(i.jsx)("p",{className:"message",children:r})})})})}},141:function(e,t,n){},142:function(e,t,n){},143:function(e,t,n){},148:function(e,t,n){"use strict";n.d(t,"a",(function(){return o}));var c=n(111),a=n(0),l=(n(202),n(506)),i=n(8),o=function(e){var t=e.buttons,n=e.onChange,o=e.selected,r=e.unicId,s=Object(a.useState)(o||t[0].id),d=Object(c.a)(s,2),u=d[0],b=d[1];Object(a.useEffect)((function(){b(o||t[0].id),n(o||t[0].id)}),[o]);var j=function(e){b(e),n(e)};return Object(i.jsx)("div",{className:"radio-buttons-group",children:t.map((function(e){var n=e.id,c=e.title;return Object(i.jsxs)("div",{className:"radio-buttons-group__element ".concat(1===t.length?"edit":""),children:[Object(i.jsx)("input",{type:"radio",id:r+c,value:n,checked:u==n,onChange:function(){return j(n)},className:"input"}),Object(i.jsx)("label",{htmlFor:r+c,className:"label",children:c})]},Object(l.a)())}))})};t.b=Object(a.memo)(o)},152:function(e,t,n){},154:function(e,t,n){},159:function(e,t,n){},161:function(e,t,n){"use strict";n.d(t,"a",(function(){return v}));var c=n(0),a=(n(152),n(111)),l=n(9),i=n(23),o=n(11),r=n(15),s=function(e,t){var n=Object(c.useState)(e),l=Object(a.a)(n,2),i=l[0],o=l[1];return Object(c.useEffect)((function(){var n=setTimeout((function(){o(e)}),t);return function(){clearTimeout(n)}}),[e]),i},d=n(505),u=n(475),b=n(476),j=n(8),m=function(e){var t=e.open,n=e.handleClose,c=e.children;return Object(j.jsx)(d.a,{className:"modal-container",open:t,onClose:n,closeAfterTransition:!0,BackdropComponent:u.a,BackdropProps:{timeout:500},children:Object(j.jsx)(b.a,{in:t,children:c})})},O=n(117),f=(n(154),function(){var e=function(){var e=Object(i.b)(),t=Object(l.f)(),n=Object(c.useState)(!1),r=Object(a.a)(n,2),s=r[0],d=r[1],u=Object(i.c)((function(e){return e.main.user.extra_type})),b=Object(i.c)((function(e){return e.main.user.type})),j=Object(c.useCallback)((function(){d(!0)}),[]),m=Object(c.useCallback)((function(){d(!1)}),[]),O=Object(c.useCallback)((function(n){d(!1),t.push("/"),e(Object(o.f)(n))}),[]);return{isOpen:s,userTypeButtons:Object(c.useMemo)((function(){return u.filter((function(e){return e.type!==b})).map((function(e){var t=e.title,n=e.type;return{label:t,onClick:function(){return O(n)}}}))}),[u,b]),handleOpen:j,handleClose:m}}(),t=e.isOpen,n=e.userTypeButtons,r=e.handleOpen,s=e.handleClose;return n.length?Object(j.jsxs)("div",{className:"user-select",children:[Object(j.jsx)("img",{src:"/images/user.svg",alt:"user",onClick:r}),Object(j.jsx)(m,{open:t,handleClose:s,children:Object(j.jsx)("div",{className:"user-select__modal",children:n.map((function(e){var t=e.label,n=e.onClick;return Object(j.jsx)(O.a,{label:t,onClick:n,className:"user-select__button"},t)}))})})]}):null}),v=function(){var e=function(){var e=Object(i.b)(),t=Object(l.f)(),n=Object(c.useState)(""),d=Object(a.a)(n,2),u=d[0],b=d[1],j=Object(c.useState)(0),m=Object(a.a)(j,2),O=m[0],f=m[1],v=s(u,1e3);return Object(c.useEffect)((function(){O?e(Object(r.h)(v)):f((function(e){return e+1}))}),[v]),{onSearch:Object(c.useCallback)((function(e){b(e.target.value)}),[u]),onLogout:Object(c.useCallback)((function(){localStorage.clear(),e(Object(o.e)({type:null,token:null})),t.push("/")}),[]),onLogoClick:Object(c.useCallback)((function(){window.location.reload()}),[]),searchText:u}}(),t=e.onSearch,n=e.onLogout,d=e.onLogoClick,u=e.searchText;return Object(j.jsxs)("div",{className:"header container",children:[Object(j.jsx)("img",{className:"header__logo",src:"/images/logo.svg",alt:"logo",onClick:d}),Object(j.jsxs)("div",{className:"header__search",children:[Object(j.jsx)("input",{type:"text",placeholder:"\u041f\u043e\u0448\u0443\u043a...",onChange:t,value:u}),Object(j.jsx)("img",{src:"/images/search.svg",alt:"search"})]}),Object(j.jsxs)("div",{className:"header__control",children:[Object(j.jsx)(f,{}),Object(j.jsx)("img",{src:"/images/log-out.svg",alt:"logout",onClick:n})]})]})}},164:function(e,t,n){"use strict";n.d(t,"a",(function(){return s}));var c=n(111),a=n(0),l=(n(203),n(269)),i=n.n(l),o=n(510),r=n(8),s=function(e){var t=e.label,n=e.onChange,l=e.value,s=void 0===l?"":l,d=e.disabled,u=Object(a.useState)(s||""),b=Object(c.a)(u,2),j=b[0],m=b[1];Object(a.useEffect)((function(){m(s||"")}),[s]);return Object(r.jsx)(i.a,{className:"custom-input",mask:"+38(999)999-99-99",value:j,disabled:d||!1,onChange:function(e){m(e.target.value),n&&n(e.target.value)},children:function(){return Object(r.jsx)(o.a,{variant:"outlined",label:t,disabled:d||!1})}})}},165:function(e,t,n){"use strict";n.d(t,"a",(function(){return a}));n(0),n(204);var c=n(8),a=function(e){var t=e.onClick,n=e.disabled,a=function(){n||t()};return Object(c.jsx)("div",{className:"add-form-button ".concat(n?"disabled":""),onClick:a,onKeyPress:a,children:Object(c.jsx)("img",{src:"/images/plus.svg",alt:"plus"})})}},173:function(e,t,n){"use strict";var c=n(148);n.d(t,"a",(function(){return c.b}))},179:function(e,t,n){"use strict";n.d(t,"a",(function(){return d}));var c=n(486),a=n(494),l=n(487),i=n(495),o=n(488),r=n(489),s=(n(0),n(8)),d=function(e){var t=e.open,n=e.handleClose,d=e.handleConfirm,u=e.title,b=e.message;return Object(s.jsxs)(c.a,{open:t,onClose:n,"aria-labelledby":"alert-dialog-title","aria-describedby":"alert-dialog-description",children:[Object(s.jsx)(a.a,{children:u}),Object(s.jsx)(l.a,{children:Object(s.jsx)(i.a,{children:b})}),Object(s.jsxs)(o.a,{children:[Object(s.jsx)(r.a,{onClick:n,color:"primary",children:"\u0417\u0430\u043a\u0440\u0438\u0442\u0438"}),Object(s.jsx)(r.a,{onClick:d,color:"primary",autoFocus:!0,children:"\u041f\u0456\u0434\u0442\u0432\u0435\u0440\u0434\u0438\u0442\u0438"})]})]})}},180:function(e,t,n){"use strict";n.d(t,"a",(function(){return a}));n(0),n(205);var c=n(8),a=function(e){var t=e.onClick,n=e.index,a=e.disabled;return Object(c.jsx)("div",{className:"remove-form-button ".concat(a?"disabled":""),onClick:function(){a||t(n)},onKeyPress:function(){return t(n)},children:Object(c.jsx)("img",{src:"/images/minus.svg",alt:"minus"})})}},195:function(e,t){},200:function(e,t,n){},201:function(e,t,n){},202:function(e,t,n){},203:function(e,t,n){},204:function(e,t,n){},205:function(e,t,n){},211:function(e,t,n){"use strict";n.d(t,"a",(function(){return d}));var c=n(0),a=(n(200),n(121)),l=n(111),i=n(23),o=n(46),r=n(43),s=n(8),d=function(e){var t=function(e){var t=e.onFilterDataChange,n=e.horizontal,a=Object(i.b)(),s=Object(i.c)((function(e){return e.main.user})).token,d=Object(i.c)((function(e){return e.filter})).filterInitialData,u=Object(i.c)((function(e){return e.scheduler})).schedulerLock;Object(c.useEffect)((function(){a(Object(o.b)())}),[s]);var b=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.reader}),[d]),j=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.notary}),[d]),m=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.accompanying}),[d]),O=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.contract_type}),[d]),f=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.developer}),[d]),v=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.sort_type}),[d]),h=Object(c.useState)([]),p=Object(l.a)(h,2),g=p[0],C=p[1],x=Object(c.useMemo)((function(){return Boolean(d)}),[d]),_=Object(c.useState)(null),y=Object(l.a)(_,2),k=y[0],N=y[1],S=Object(c.useState)(null),A=Object(l.a)(S,2),w=A[0],D=A[1],M=Object(c.useState)(null),T=Object(l.a)(M,2),E=T[0],z=T[1],I=Object(c.useState)(null),L=Object(l.a)(I,2),B=L[0],R=L[1],F=Object(c.useState)(null),V=Object(l.a)(F,2),P=V[0],q=V[1],W=Object(c.useState)(null),G=Object(l.a)(W,2),J=G[0],K=G[1],Q=Object(c.useState)(null),H=Object(l.a)(Q,2),U=H[0],X=H[1],Y=Object(c.useCallback)((function(){N(null),D(null),z(null),R(null),q(null),K(null),X(null)}),[]);return Object(c.useEffect)((function(){K(null),s&&P&&Object(r.a)(s,+P).then((function(e){return C(e.representative||[])}))}),[P]),Object(c.useEffect)((function(){var e={notary_id:k||null,reader_id:w||null,accompanying_id:E||null,contract_type_id:B||null,developer_id:P||null,dev_representative_id:J||null};n||(e.sort_type=U),t(e)}),[k,w,E,B,P,J,U]),Object(c.useEffect)((function(){u||Y()}),[u]),{shouldRenderFilter:x,notaries:j,readers:b,accompanyings:m,contractTypes:O,developers:f,representative:g,sortType:v,selectedNotary:k,selectedReader:w,selectedRepresentative:J,selectedDeveloper:P,selectedContractType:B,selectedAccompanying:E,selectedSortType:U,setSelectedNotary:N,setSelectedReader:D,setSelectedAccompanying:z,setSelectedContractType:R,setSelectedDeveloper:q,setSelectedRepresentative:K,setSelectedSortType:X,clearAll:Y}}(e);return t.shouldRenderFilter?Object(s.jsxs)("div",{className:"filter ".concat(e.horizontal?"horizontal":""),children:[!e.horizontal&&Object(s.jsxs)("div",{className:"filter__header",children:[Object(s.jsx)("span",{className:"title",children:"\u0424\u0456\u043b\u044c\u0442\u0440"}),Object(s.jsx)("img",{src:"/images/clear-form.svg",alt:"clear form",onClick:t.clearAll,className:"filter__clear"})]}),Object(s.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"115px":"100%"},children:Object(s.jsx)(a.a,{data:t.notaries,selectedValue:t.selectedNotary,onChange:t.setSelectedNotary,label:"\u041d\u043e\u0442\u0430\u0440\u0456\u0443\u0441",size:e.horizontal?"small":"medium"})}),Object(s.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"90px":"100%"},children:Object(s.jsx)(a.a,{data:t.readers,selectedValue:t.selectedReader,onChange:t.setSelectedReader,label:"\u0427\u0438\u0442\u0430\u0447",size:e.horizontal?"small":"medium"})}),Object(s.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"110px":"100%"},children:Object(s.jsx)(a.a,{data:t.accompanyings,selectedValue:t.selectedAccompanying,onChange:t.setSelectedAccompanying,label:"\u0412\u0438\u0434\u0430\u0432\u0430\u0447",size:e.horizontal?"small":"medium"})}),Object(s.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"150px":"100%"},children:Object(s.jsx)(a.a,{data:t.contractTypes,selectedValue:t.selectedContractType,onChange:t.setSelectedContractType,label:"\u0422\u0438\u043f \u0434\u043e\u0433\u043e\u0432\u043e\u0440\u0443",size:e.horizontal?"small":"medium"})}),Object(s.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"140px":"100%"},children:Object(s.jsx)(a.a,{data:t.developers,selectedValue:t.selectedDeveloper,onChange:t.setSelectedDeveloper,label:"\u0417\u0430\u0431\u0443\u0434\u043e\u0432\u043d\u0438\u043a",size:e.horizontal?"small":"medium"})}),Object(s.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"125px":"100%"},children:Object(s.jsx)(a.a,{data:t.representative,selectedValue:t.selectedRepresentative,onChange:t.setSelectedRepresentative,label:"\u041f\u0456\u0434\u043f\u0438\u0441\u0430\u043d\u0442",size:e.horizontal?"small":"medium"})}),!e.horizontal&&Object(s.jsx)("div",{className:"filter__select",children:Object(s.jsx)(a.a,{data:t.sortType,selectedValue:t.selectedSortType,onChange:t.setSelectedSortType,label:"\u0421\u043e\u0440\u0442\u0443\u0432\u0430\u0442\u0438",size:"medium"})}),e.horizontal&&Object(s.jsx)("div",{className:" df",children:Object(s.jsx)("img",{src:"/images/clear-form.svg",alt:"clear form",onClick:t.clearAll,className:"filter__clear"})})]}):null}},409:function(e,t,n){},410:function(e,t,n){},411:function(e,t,n){},412:function(e,t,n){},426:function(e,t,n){},427:function(e,t,n){},428:function(e,t,n){},429:function(e,t,n){},430:function(e,t,n){},431:function(e,t,n){},499:function(e,t,n){"use strict";n.r(t),n.d(t,"default",(function(){return ie}));var c=n(0),a=n(161),l=n(3),i=(n(409),n(410),n(506)),o=n(1),r=n.n(o),s=n(2),d=n(23),u=n(18),b=n(15),j=function(e,t,n,c,a){var l=n[Math.floor(c/e.length)],i=l.day,o=l.date,r=l.year,s=e[c%e.length].time,d=t[a].id;return{day:i,date:o.split(".").reverse().join("."),year:r,time:s,room:d}},m=n(24),O=(n(411),n(8)),f=function(e){var t=e.day,n=e.hours;return Object(O.jsxs)("div",{className:"scheduler__weekDay",children:[Object(O.jsx)("div",{className:"scheduler__day",children:Object(O.jsxs)("p",{children:[t.day,Object(O.jsx)("br",{}),t.date]})}),Object(O.jsx)("div",{className:"scheduler__timeLine",children:n.map((function(e){var t=e.time;return Object(O.jsx)("p",{children:t},t)}))})]})},v=n(111),h=(n(412),n(413)),p=n.n(h),g=n(424),C=n.n(g),x=n(193),_=n.n(x),y=Object(h.WidthProvider)(p.a);function k(e){var t=e.appointments,n=e.cols,a=e.handleDrag,l=e.handleClick,o=Object(c.useState)(1200),r=Object(v.a)(o,2),s=r[0],u=r[1],b=Object(d.c)((function(e){return e.scheduler})).schedulerLock,j=Object(d.c)((function(e){return e.scheduler.oldSelectedAppointment}));Object(c.useEffect)((function(){u(C()(".scheduler__appointments").width())}),[]);var m=Object(c.useCallback)((function(e,t){return(null===j||void 0===j?void 0:j.raw)===e&&(null===j||void 0===j?void 0:j.cell)===t}),[j]);return t?Object(O.jsx)(y,{className:"scheduler__dragAndDrop",cols:n,rowHeight:80,width:s,margin:[0,0],containerPadding:[0,0],verticalCompact:!1,preventCollision:!0,layout:t,onDragStop:function(e,t){var n=e.find((function(e){return e.i===t.i}));a(n),l(n)},isDraggable:!b,children:t.map((function(e){return Object(O.jsxs)("div",{className:"appointment",style:{borderLeft:"4px solid ".concat(e.color),backgroundColor:m(e.y,e.x)?e.color:""},onClickCapture:function(){return l(e)},children:[Object(O.jsx)("div",{className:"appointment__title",children:_()(e.title)}),Object(O.jsx)("table",{className:"appointment__table",children:Object(O.jsx)("tbody",{children:Object(O.jsx)("tr",{children:e.short_info&&Object.values(e.short_info).map((function(e){return Object(O.jsx)("td",{children:e},Object(i.a)())}))})})})]},e.i)}))}):Object(O.jsx)("span",{children:"Loading..."})}var N=n(425),S=n.n(N),A=function(e){var t=function(e){var t=e.raw,n=e.cell,a=e.roomsWithBackground,i=Object(d.c)((function(e){return e.scheduler})).options,o=Object(d.b)(),r=Object(c.useMemo)((function(){var e=a.find((function(e){return e.index===n}));return e?null===e||void 0===e?void 0:e.colour:""}),[]),s=Object(c.useMemo)((function(){return null===i||void 0===i?void 0:i.rooms}),[i]),b=Object(c.useMemo)((function(){return null===i||void 0===i?void 0:i.work_time}),[i]),m=Object(c.useMemo)((function(){return null===i||void 0===i?void 0:i.day_and_date}),[i]);return{backGroundColor:r,onClick:Object(c.useCallback)((function(){var e=j(b,s,m,t,n);S()("".concat(e.year,".").concat(e.date,". ").concat(e.time)).isBefore(S()())||o(Object(u.l)(Object(l.a)(Object(l.a)({},e),{},{raw:t,cell:n,date:e.date})))}),[b,s,m,t,n])}}(e),n=t.backGroundColor,a=t.onClick;return Object(O.jsx)("td",{onClick:a,style:{width:"calc(100% / ".concat(e.rowsQuantity,")"),backgroundColor:e.selected?"#E5E5E5":n}})},w=function(e,t,n){return(null===e||void 0===e?void 0:e.raw)===t&&(null===e||void 0===e?void 0:e.cell)===n};function D(e){var t=function(e){return{newSelectedAppointment:Object(d.c)((function(e){return e.scheduler.newSelectedAppointment})),roomsWithBackground:Object(c.useMemo)((function(){var t=[];return e.rooms.forEach((function(e,n){e.color&&t.push({index:n,colour:e.color})})),t}),[])}}(e),n=t.newSelectedAppointment,a=t.roomsWithBackground;return Object(O.jsx)("div",{className:"scheduler__bodyTable",children:Object(O.jsx)("table",{children:Object(O.jsx)("tbody",{children:e.rows.map((function(t,c){return Object(O.jsx)("tr",{children:e.columns.map((function(t,l){return Object(O.jsx)(A,{selected:w(n,c,l),roomsWithBackground:a,rowsQuantity:e.rows.length,raw:c,cell:l},Object(i.a)())}))},Object(i.a)())}))})})})}var M=function(){var e=function(){var e=Object(d.b)(),t=Object(d.c)((function(e){return e.main.user})).token,n=Object(d.c)((function(e){return e.scheduler})),a=n.options,i=n.isLoading,o=Object(d.c)((function(e){return e.appointments})).appointments;Object(c.useEffect)((function(){return i||(e(Object(u.f)()),e(Object(b.e)())),function(){e(Object(b.c)())}}),[t]);var m=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.rooms}),[a]),O=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.work_time}),[a]),f=Object(c.useMemo)((function(){return i||!a}),[i,m,O]),v=Object(c.useMemo)((function(){return new Array((null===m||void 0===m?void 0:m.length)||0).fill(1)}),[m]),h=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.day_and_date}),[a]),p=Object(c.useMemo)((function(){return new Array((null===O||void 0===O?void 0:O.length)*(null===h||void 0===h?void 0:h.length)||0).fill(1)}),[O]),g=Object(c.useCallback)((function(t){var n=j(O,m,h,t.y,t.x),c={date_time:"".concat(n.year,".").concat(n.date,". ").concat(n.time),room_id:n.room};e(Object(u.g)(c,t.i))}),[O,h,m,h]),C=Object(c.useCallback)(function(){var t=Object(s.a)(r.a.mark((function t(n){var c,a,i,o;return r.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:c=n.x,a=n.y,i=n.i,o=j(O,m,h,a,c),e(Object(u.d)(i)),e(Object(u.m)(Object(l.a)(Object(l.a)({},o),{},{raw:a,cell:c,i:i,date:o.date})));case 4:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}(),[O,m,h]);return{shouldLoad:f,rooms:m,hours:O,tableRows:p,tableColumns:v,days:h,appointments:o,handleAppointmentDrag:g,onAppointmentClick:C}}(),t=e.shouldLoad,n=e.rooms,a=e.hours,o=e.tableRows,v=e.tableColumns,h=e.days,p=e.appointments,g=e.handleAppointmentDrag,C=e.onAppointmentClick;return t?Object(O.jsx)("div",{className:"scheduler",children:Object(O.jsx)(m.a,{})}):Object(O.jsxs)("div",{className:"scheduler",children:[Object(O.jsxs)("div",{className:"scheduler__header",children:[Object(O.jsx)("div",{}),Object(O.jsx)("div",{children:Object(O.jsx)("table",{children:Object(O.jsx)("tbody",{children:Object(O.jsx)("tr",{children:n.map((function(e){var t=e.title;return Object(O.jsx)("td",{style:{width:"calc(100% / ".concat(n.length,")")},children:t},t)}))})})})})]}),Object(O.jsxs)("div",{className:"scheduler__body",children:[Object(O.jsx)("div",{className:"scheduler__dayBar",children:h.map((function(e){return Object(O.jsx)(f,{day:e,hours:a},Object(i.a)())}))}),Object(O.jsxs)("div",{className:"scheduler__appointments",children:[Object(O.jsx)(D,{rows:o,columns:v,rooms:n}),Object(O.jsx)(k,{appointments:p,cols:v.length,handleDrag:g,handleClick:C})]})]})]})},T=function(){var e=Object(d.c)((function(e){return e.appointments})).appointments;return Object(O.jsx)("span",{style:{whiteSpace:"nowrap"},children:"\u0412 \u0440\u043e\u0431\u043e\u0442\u0456: ".concat(null===e||void 0===e?void 0:e.length)})},E=n(211),z=function(){var e=function(){var e=Object(c.useState)(!1),t=Object(v.a)(e,2),n=t[0],a=t[1],l=Object(d.b)();return{onFilterDataChange:Object(c.useCallback)((function(e){n?l(Object(b.g)(e)):a(!0)}),[n])}}().onFilterDataChange;return Object(O.jsx)(E.a,{onFilterDataChange:e,horizontal:!0})},I=(n(426),function(){var e=function(){var e=Object(d.b)(),t=Object(d.c)((function(e){return e.scheduler})).schedulerLock;return{onClick:Object(c.useCallback)((function(){e(Object(u.k)(!t))}),[t]),schedulerLock:t}}(),t=e.onClick,n=e.schedulerLock;return Object(O.jsx)("div",{className:"scheduler__lock-button ".concat(n?"":"unLock"),children:Object(O.jsx)("img",{src:"/images/lock.svg",alt:"lock",onClick:t})})}),L=(n(427),function(){return Object(O.jsxs)("div",{className:"scheduler__filter",children:[Object(O.jsx)(T,{}),Object(O.jsx)(z,{}),Object(O.jsx)(I,{})]})}),B=(n(428),n(173)),R=n(121),F=(n(429),n(430),n(165)),V=n(125),P=n(180),q=n(164),W=function(e){var t=function(e){var t=e.onChange,n=e.clients;return{onPhoneChange:Object(c.useCallback)((function(e,c){t(e,Object(l.a)(Object(l.a)({},n[e]),{},{phone:c}))}),[n]),onNameChange:Object(c.useCallback)((function(e,c){t(e,Object(l.a)(Object(l.a)({},n[e]),{},{full_name:c}))}),[n])}}(e);return Object(O.jsx)("div",{className:"mv12",children:e.clients.map((function(n,c){return Object(O.jsxs)("div",{className:"clients__item mv12",children:[Object(O.jsx)(V.a,{label:"\u041f\u0406\u0411",value:n.full_name,onChange:function(e){return t.onNameChange(c,e)},disabled:e.disabled||!1}),Object(O.jsxs)("div",{className:"mv12 df-jc-sb",children:[Object(O.jsx)(q.a,{label:"\u041d\u043e\u043c\u0435\u0440 \u0442\u0435\u043b\u0435\u0444\u043e\u043d\u0443",value:n.phone,onChange:function(e){return t.onPhoneChange(c,e)},disabled:e.disabled||!1}),e.clients.length>1&&Object(O.jsx)("div",{style:{marginLeft:"12px"},children:Object(O.jsx)(P.a,{onClick:e.onRemove,index:c,disabled:e.disabled||!1})}),c===e.clients.length-1&&Object(O.jsx)("div",{style:{marginLeft:"12px"},children:Object(O.jsx)(F.a,{onClick:e.onAdd,disabled:e.disabled||!1})})]})]})}))})},G=Object(c.memo)(W),J=n(117),K=(n(431),n(120)),Q=n(129),H=function(e){var t=function(e){var t=e.immovables,n=e.onChange,a=Object(d.c)((function(e){return e.scheduler})),i=a.options,o=a.developersInfo;return{building:Object(c.useMemo)((function(){return(null===o||void 0===o?void 0:o.building)||[]}),[o]),contracts:Object(c.useMemo)((function(){return null===i||void 0===i?void 0:i.form_data.contract_type}),[i]),immovableTypes:Object(c.useMemo)((function(){return null===i||void 0===i?void 0:i.form_data.immovable_type}),[i]),onContractChange:Object(c.useCallback)((function(e,c){n(e,Object(l.a)(Object(l.a)({},t[e]),{},{contract_type_id:c}))}),[t]),onBuildingChange:Object(c.useCallback)((function(e,c){n(e,Object(l.a)(Object(l.a)({},t[e]),{},{building_id:+c}))}),[t]),onImmovableTypeChange:Object(c.useCallback)((function(e,c){n(e,Object(l.a)(Object(l.a)({},t[e]),{},{imm_type_id:c}))}),[t]),onBankChange:Object(c.useCallback)((function(e,c){n(e,Object(l.a)(Object(l.a)({},t[e]),{},{bank:c}))}),[t]),onProxyChange:Object(c.useCallback)((function(e,c){n(e,Object(l.a)(Object(l.a)({},t[e]),{},{proxy:c}))}),[t]),onImmNumChange:Object(c.useCallback)((function(e,c){n(e,Object(l.a)(Object(l.a)({},t[e]),{},{imm_number:c}))}),[t])}}(e);return Object(O.jsx)("div",{className:"mv12 immovables__group",children:e.immovables.map((function(n,c){return Object(O.jsxs)("div",{className:"immovables__item mv12",children:[Object(O.jsx)(B.a,{buttons:e.disabled?t.contracts.filter((function(e){return e.id===(n.contract_type_id||t.contracts[0].id)})):t.contracts,onChange:function(e){return t.onContractChange(c,+e)},selected:n.contract_type_id,unicId:"contract-".concat(c)}),Object(O.jsx)("div",{className:"mv12",children:Object(O.jsx)(R.a,{required:!0,onChange:function(e){return t.onBuildingChange(c,e)},data:t.building,label:"\u0411\u0443\u0434\u0438\u043d\u043e\u043a",selectedValue:n.building_id,disabled:e.disabled||!1})}),Object(O.jsx)(B.a,{buttons:e.disabled?t.immovableTypes.filter((function(e){return e.id===(n.imm_type_id||t.immovableTypes[0].id)})):t.immovableTypes,onChange:function(e){return t.onImmovableTypeChange(c,+e)},selected:n.imm_type_id,unicId:"types-".concat(c)}),Object(O.jsx)("div",{className:"mv12",children:Object(O.jsx)(Q.a,{label:"\u0411\u0430\u043d\u043a",onChange:function(e){return t.onBankChange(c,e)},selected:n.bank,disabled:e.disabled})}),Object(O.jsx)("div",{className:"mv12",children:Object(O.jsx)(Q.a,{label:"\u0414\u043e\u0432\u0456\u0440\u0435\u043d\u0456\u0441\u0442\u044c",onChange:function(e){return t.onProxyChange(c,e)},selected:n.proxy,disabled:e.disabled})}),Object(O.jsxs)("div",{className:"mv12 df-jc-sb",children:[Object(O.jsx)(K.a,{required:!0,label:"\u041d\u043e\u043c\u0435\u0440 \u043d\u0435\u0440\u0443\u0445\u043e\u043c\u043e\u0441\u0442\u0456",onChange:function(e){return t.onImmNumChange(c,e)},value:n.imm_number,disabled:e.disabled}),e.immovables.length>1&&Object(O.jsx)("div",{style:{marginLeft:"12px"},children:Object(O.jsx)(P.a,{onClick:e.onRemove,index:c,disabled:e.disabled})}),c===e.immovables.length-1&&Object(O.jsx)("div",{style:{marginLeft:"12px"},children:Object(O.jsx)(F.a,{onClick:e.onAdd,disabled:e.disabled})})]})]})}))})},U=Object(c.memo)(H),X=n(28),Y={contract_type_id:null,building_id:null,imm_type_id:null,imm_number:null,bank:!1,proxy:!1},Z={phone:null,full_name:null},$=n(179),ee=function(e){var t=function(e){var t=e.selectedCard,n=e.initialValues,a=e.edit,i=Object(d.b)(),o=Object(d.c)((function(e){return e.main.user})).token,r=Object(d.c)((function(e){return e.scheduler})),s=r.options,b=r.developersInfo,j=r.isLoading,m=Object(c.useState)(a||!1),O=Object(v.a)(m,2),f=O[0],h=O[1],p=Object(c.useState)((null===n||void 0===n?void 0:n.card.notary_id)||null),g=Object(v.a)(p,2),C=g[0],x=g[1],_=Object(c.useState)(null),y=Object(v.a)(_,2),k=y[0],N=y[1],S=Object(c.useState)(null),A=Object(v.a)(S,2),w=A[0],D=A[1],M=Object(c.useState)(null),T=Object(v.a)(M,2),E=T[0],z=T[1],I=Object(c.useState)([Y]),L=Object(v.a)(I,2),B=L[0],R=L[1],F=Object(c.useState)([Z]),V=Object(v.a)(F,2),P=V[0],q=V[1],W=Object(c.useMemo)((function(){return j||!s}),[s,j]),G=Object(c.useMemo)((function(){return null===s||void 0===s?void 0:s.form_data.notary}),[s]),J=Object(c.useMemo)((function(){return null===s||void 0===s?void 0:s.form_data.developer}),[s]),K=Object(c.useMemo)((function(){return(null===b||void 0===b?void 0:b.manager)||[]}),[b]),Q=Object(c.useMemo)((function(){return(null===b||void 0===b?void 0:b.representative)||[]}),[b]),H=Object(c.useMemo)((function(){return Boolean(k)&&B.length&&B.every((function(e){return e.building_id&&e.imm_number}))&&t}),[k,B,t]),U=Object(c.useMemo)((function(){var e=null===n||void 0===n?void 0:n.card.generator_step,t=null===n||void 0===n?void 0:n.card.ready;return e||t}),[n]),$=Object(c.useMemo)((function(){var e=null===n||void 0===n?void 0:n.card.generator_step,t=null===n||void 0===n?void 0:n.card.ready;return e?"\u041f\u0435\u0440\u0435\u0434\u0430\u043d\u043e \u0434\u043e \u0433\u0435\u043d\u0435\u0440\u0430\u0446\u0456\u0457":t?"\u041f\u043e\u0447\u0430\u0442\u0438 \u0432\u0438\u0434\u0430\u0447\u0443":"\u0420\u0435\u0434\u0430\u0433\u0443\u0432\u0430\u0442\u0438"}),[n]),ee=Object(c.useCallback)((function(e){x(e)}),[]),te=Object(c.useCallback)((function(e){N(e),z(null),D(null),R((function(e){return e.map((function(e){return Object(l.a)(Object(l.a)({},e),{},{building_id:null})}))})),e||i(Object(u.i)({})),i(Object(u.e)(e))}),[]),ne=Object(c.useCallback)((function(e){D(e)}),[w]),ce=Object(c.useCallback)((function(e){z(e)}),[E]),ae=Object(c.useCallback)((function(e,t){B[e]=t,R(Object(X.a)(B))}),[B]),le=Object(c.useCallback)((function(e,t){P[e]=t,q(Object(X.a)(P))}),[P]),ie=Object(c.useCallback)((function(){x(null),N(null),D(null),z(null),R([Y]),q([Z])}),[]),oe=Object(c.useCallback)((function(){R([].concat(Object(X.a)(B),[Y]))}),[B]),re=Object(c.useCallback)((function(e){R((function(t){return t.filter((function(t,n){return n!==e}))}))}),[B]),se=Object(c.useCallback)((function(){q([].concat(Object(X.a)(P),[Z]))}),[P]),de=Object(c.useCallback)((function(e){q((function(t){return t.filter((function(t,n){return n!==e}))}))}),[P]),ue=Object(c.useCallback)((function(){var e="".concat(t.year,".").concat(t.date,". ").concat(t.time),n={immovables:B.map((function(e){return Object(l.a)(Object(l.a)({},e),{},{contract_type_id:e.contract_type_id||s.form_data.immovable_type[0].id,imm_type_id:e.imm_type_id||s.form_data.immovable_type[0].id})})),clients:P,date_time:e,dev_company_id:k,dev_representative_id:w,dev_manager_id:E,room_id:t.room,notary_id:C||G[0].id};o&&(a?(i(Object(u.c)(n,t.i)),h(!0)):(i(Object(u.b)(n)),i(Object(u.l)(null)),ie()))}),[k,w,E,C,B,P,a,t]),be=Object(c.useState)(!1),je=Object(v.a)(be,2),me=je[0],Oe=je[1],fe=Object(c.useMemo)((function(){return{title:"\u0412\u0438\u0434\u0430\u043b\u0438\u0442\u0438 \u043a\u0430\u0440\u0442\u043a\u0443 ".concat(null===t||void 0===t?void 0:t.i),message:"\u0412\u0438 \u0432\u043f\u0435\u0432\u043d\u0435\u043d\u0456, \u0449\u043e \u0431\u0430\u0436\u0430\u0454\u0442\u0435 \u0432\u0438\u0434\u0430\u043b\u0438\u0442\u0438 \u043a\u0430\u0440\u0442\u043a\u0443?"}}),[t]),ve=Object(c.useCallback)((function(){U||Oe(!0)}),[U]),he=Object(c.useCallback)((function(){Oe(!1)}),[]),pe=Object(c.useCallback)((function(){i(Object(u.h)(null===t||void 0===t?void 0:t.i))}),[t,u.h]);return Object(c.useEffect)((function(){n&&(h(!0),x(n.card.notary_id),N(n.card.dev_company_id),D(n.card.dev_representative_id),z(n.card.dev_manager_id),R(0===n.immovables.length?[Y]:n.immovables),q(0===n.clients.length?[Z]:n.clients)),(null===n||void 0===n?void 0:n.card.dev_company_id)&&i(Object(u.e)(n.card.dev_company_id))}),[n]),{shouldLoad:W,notaries:G,representative:Q,developers:J,manager:K,immovables:B,clients:P,activeAddButton:H,insideEdit:f,isConfirmDialogOpen:me,confirmDialogContent:fe,isDeleteDisabled:U,editButtonLabel:$,onDeleteCardClick:ve,onConfirmDialogClose:he,onConfirmDialogAgreed:pe,onNotaryChange:ee,onDeveloperChange:te,onRepresentativeChange:ne,onManagerChange:ce,onImmovablesChange:ae,onAddImmovables:oe,onRemoveImmovable:re,onRemoveClient:de,onClientsChange:le,onAddClients:se,onClearAll:ie,onFormCreate:ue,setEdit:h,selectedNotaryId:C,selectedDeveloperId:k,selectedDevRepresentativeId:w,selectedDevManagerId:E}}(e);return t.shouldLoad?Object(O.jsx)("div",{className:"schedulerForm",children:Object(O.jsx)(m.a,{})}):Object(O.jsxs)("div",{className:"schedulerForm",children:[Object(O.jsxs)("div",{className:"schedulerForm__forms",children:[Object(O.jsxs)("div",{className:"schedulerForm__header",children:[Object(O.jsx)("p",{className:"title",children:t.insideEdit||e.edit?"\u0417\u0430\u043f\u0438\u0441 \u2116 ".concat(e.selectedCard.i):"\u041d\u043e\u0432\u0438\u0439 \u0437\u0430\u043f\u0438\u0441"}),t.insideEdit?Object(O.jsx)("img",{src:"/images/delete.svg",alt:"delete",className:"clear-icon ".concat(t.isDeleteDisabled?"disabled":""),onClick:t.onDeleteCardClick}):Object(O.jsx)("img",{src:"/images/clear.svg",alt:"clear",className:"clear-icon",onClick:t.onClearAll})]}),Object(O.jsx)("div",{className:"mv12",children:Object(O.jsx)(B.a,{buttons:t.insideEdit?t.notaries.filter((function(e){return e.id===t.selectedNotaryId})):t.notaries,onChange:t.onNotaryChange,selected:t.selectedNotaryId,unicId:"notaries"})}),Object(O.jsx)("div",{className:"mv12",children:Object(O.jsx)(R.a,{required:!0,label:"\u0417\u0430\u0431\u0443\u0434\u043e\u0432\u043d\u0438\u043a",data:t.developers,onChange:t.onDeveloperChange,selectedValue:t.selectedDeveloperId,disabled:t.insideEdit||!1})}),Object(O.jsx)("div",{className:"mv12",children:Object(O.jsx)(R.a,{onChange:t.onRepresentativeChange,data:t.representative,label:"\u041f\u0456\u0434\u043f\u0438\u0441\u0430\u043d\u0442",selectedValue:t.selectedDevRepresentativeId,disabled:t.insideEdit||!1})}),Object(O.jsx)("div",{className:"mv12",children:Object(O.jsx)(R.a,{onChange:t.onManagerChange,data:t.manager,label:"\u041c\u0435\u043d\u0435\u0434\u0436\u0435\u0440",selectedValue:t.selectedDevManagerId,disabled:t.insideEdit||!1})}),Object(O.jsx)(U,{immovables:t.immovables,onChange:t.onImmovablesChange,onAdd:t.onAddImmovables,onRemove:t.onRemoveImmovable,disabled:t.insideEdit||!1}),Object(O.jsx)(G,{clients:t.clients,onChange:t.onClientsChange,onAdd:t.onAddClients,onRemove:t.onRemoveClient,disabled:t.insideEdit||!1}),Object(O.jsxs)("div",{className:"mv12",children:[t.insideEdit&&Object(O.jsx)(J.a,{label:t.editButtonLabel,onClick:function(){return t.setEdit(!1)},disabled:t.isDeleteDisabled,className:"schedulerForm__editButton"}),!t.insideEdit&&Object(O.jsx)(J.a,{label:"".concat(e.edit?"\u0417\u0431\u0435\u0440\u0435\u0433\u0442\u0438":"\u0421\u0442\u0432\u043e\u0440\u0438\u0442\u0438"),onClick:t.onFormCreate,disabled:!t.activeAddButton})]})]}),Object(O.jsx)($.a,{open:t.isConfirmDialogOpen,title:t.confirmDialogContent.title,message:t.confirmDialogContent.message,handleClose:t.onConfirmDialogClose,handleConfirm:t.onConfirmDialogAgreed})]})},te=Object(c.memo)(ee),ne=function(){var e=function(){var e=Object(d.b)(),t=Object(c.useState)(0),n=Object(v.a)(t,2),a=n[0],l=n[1],i=Object(d.c)((function(e){return e.scheduler.newSelectedAppointment})),o=Object(d.c)((function(e){return e.scheduler.oldSelectedAppointment})),r=Object(d.c)((function(e){return e.scheduler.editAppointmentData})),s=Object(c.useCallback)((function(){e(Object(u.m)(null)),e(Object(u.j)(null))}),[]);return Object(c.useEffect)((function(){l(r?1:0)}),[r]),Object(c.useEffect)((function(){l(0)}),[i]),{newSelectedAppointment:i,oldSelectedAppointment:o,editAppointmentData:r,selectedTab:a,setSelectedTab:l,onCloseTab:s}}();return Object(O.jsxs)("div",{className:"schedulerForm scheduler__form",children:[Object(O.jsxs)("div",{className:"schedulerForm__tabs",children:[Object(O.jsx)("div",{className:"item ".concat(0===e.selectedTab?"selected":""),style:{backgroundColor:e.editAppointmentData?"":"white"},onClick:function(){return e.setSelectedTab(0)},children:e.newSelectedAppointment?"".concat(e.newSelectedAppointment.day," ").concat(e.newSelectedAppointment.time," ").concat(e.newSelectedAppointment.date.split(".").reverse().join(".")):"\u0412\u0438\u0431\u0435\u0440\u0456\u0442\u044c \u0434\u0430\u0442\u0443"}),e.oldSelectedAppointment&&e.editAppointmentData&&Object(O.jsxs)("div",{className:"item ".concat(1===e.selectedTab?"selected":""),onClick:function(){return e.setSelectedTab(1)},children:["".concat(e.oldSelectedAppointment.day," ").concat(e.oldSelectedAppointment.time," ").concat(e.oldSelectedAppointment.date.split(".").reverse().join(".")),Object(O.jsx)("img",{src:"/images/x.svg",alt:"close",className:"clear-icon",onClick:e.onCloseTab})]})]}),0===e.selectedTab&&Object(O.jsx)(te,{selectedCard:e.newSelectedAppointment}),1===e.selectedTab&&e.editAppointmentData&&e.oldSelectedAppointment&&Object(O.jsx)(te,{selectedCard:e.oldSelectedAppointment,initialValues:e.editAppointmentData,edit:!0})]})},ce=n(136),ae=n(138),le=function(){var e=Object(ce.a)();return Object(O.jsxs)("div",{className:"scheduler__container",children:[Object(O.jsxs)("div",{className:"scheduler__dataView",children:[Object(O.jsx)(L,{}),Object(O.jsx)(M,{})]}),Object(O.jsx)(ne,{}),Object(O.jsx)(ae.a,Object(l.a)({},e))]})},ie=function(){return Object(O.jsxs)(O.Fragment,{children:[Object(O.jsx)(a.a,{}),Object(O.jsx)(le,{})]})}}}]);
//# sourceMappingURL=8.a692effb.chunk.js.map