(this.webpackJsonpfront=this.webpackJsonpfront||[]).push([[0],{110:function(e,t,n){},115:function(e,t,n){},117:function(e,t,n){},118:function(e,t,n){},156:function(e,t,n){},157:function(e,t,n){},169:function(e,t,n){},170:function(e,t,n){},171:function(e,t,n){},172:function(e,t,n){},173:function(e,t,n){},174:function(e,t,n){},175:function(e,t,n){},176:function(e,t,n){},177:function(e,t,n){},178:function(e,t,n){},179:function(e,t,n){"use strict";n.r(t);var c=n(0),a=n.n(c),r=n(12),o=n.n(r),s=(n(110),n(15)),i=(n(115),n(10)),l=n.n(i),u=n(16),d="http://app.synction.space",b=n(7),j=function(){var e=Object(u.a)(l.a.mark((function e(t){var n,c,a,r,o,s,i,u,d,j,m;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return n=t.url,c=t.method,a=void 0===c?"GET":c,r=t.headers,o=void 0===r?{}:r,s=t.bodyData,i={body:void 0,method:a||"GET",headers:Object(b.a)({Accept:"application/json","Content-Type":"applicatioin/json"},o)},s&&(i.body=JSON.stringify(s)),e.next=5,fetch(n,i);case 5:return u=e.sent,e.next=8,u.json();case 8:if((d=e.sent).success){e.next=12;break}throw j=u.status,m=u.message,new Error("[".concat(j,", ").concat(m,"] Could not fetch on URL (").concat(n,") data:\n").concat(JSON.stringify(d,null,2)));case 12:return e.abrupt("return",d);case 13:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}();function m(){return O.apply(this,arguments)}function O(){return(O=Object(u.a)(l.a.mark((function e(){var t;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,j({url:"".concat(d,"/api/login?email=oleg99@gmail.com&password=admin123"),method:"POST"});case 3:return t=e.sent,e.abrupt("return",t.data.token);case 7:return e.prev=7,e.t0=e.catch(0),console.log(e.t0),e.abrupt("return",null);case 11:case"end":return e.stop()}}),e,null,[[0,7]])})))).apply(this,arguments)}var p="SET_TOKEN",v=function(){var e=Object(u.a)(l.a.mark((function e(t){var n;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,m();case 2:n=e.sent,t({type:p,payload:n});case 4:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),h=(n(117),n(118),n(219));function f(e){return x.apply(this,arguments)}function x(){return(x=Object(u.a)(l.a.mark((function e(t){var n;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,j({url:"".concat(d,"/api/cards"),headers:{Authorization:"Bearer ".concat(t)}});case 3:return n=e.sent,e.abrupt("return",n.data);case 7:return e.prev=7,e.t0=e.catch(0),console.log(e.t0),e.abrupt("return",null);case 11:case"end":return e.stop()}}),e,null,[[0,7]])})))).apply(this,arguments)}var g="SET_OPTIONS",y="SET_APPOINTMENTS",_="SET_DEVELOPERS_INFO",C="SET_SELECTED_NEW_APPOINTMENT",k="SET_IS_LOADING",N="ADD_NEW_APPOINTMENT",w="SET_MODAL_INFO",I=function(e){return{type:_,payload:e}},S=function(e){return{type:C,payload:e}},A=function(e){return{type:w,payload:e}},E=function(e){return{type:k,payload:e}},M=function(){var e=Object(u.a)(l.a.mark((function e(t,n){var c;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t(E(!0)),e.next=3,f(n);case 3:c=e.sent,t((a=Object.values(c),{type:y,payload:a})),t(E(!1));case 6:case"end":return e.stop()}var a}),e)})));return function(t,n){return e.apply(this,arguments)}}();function T(e){return D.apply(this,arguments)}function D(){return(D=Object(u.a)(l.a.mark((function e(t){var n;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,j({url:"".concat(d,"/api/calendar"),headers:{Authorization:"Bearer ".concat(t)}});case 3:return n=e.sent,e.abrupt("return",n.data);case 7:return e.prev=7,e.t0=e.catch(0),console.log(e.t0),e.abrupt("return",null);case 11:case"end":return e.stop()}}),e,null,[[0,7]])})))).apply(this,arguments)}var P=function(){var e=Object(u.a)(l.a.mark((function e(t,n){var c;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t(E(!0)),e.next=3,T(n);case 3:c=e.sent,t({type:g,payload:c}),t(E(!1));case 6:case"end":return e.stop()}}),e)})));return function(t,n){return e.apply(this,arguments)}}(),L=function(e,t,n,c,a){var r=n[Math.floor(c/e.length)];return{day:r.day,date:r.date,year:r.year,time:e[c%e.length].time,room:t[a].id}},B=n(85),F=n(2),R=function(){return Object(F.jsx)(B.LoopCircleLoading,{color:"#165153"})},V=(n(156),function(e){var t=e.day,n=e.hours;return Object(F.jsxs)("div",{className:"scheduler__weekDay",children:[Object(F.jsx)("div",{className:"scheduler__day",children:Object(F.jsxs)("p",{children:[t.day,Object(F.jsx)("br",{}),t.date]})}),Object(F.jsx)("div",{className:"scheduler__timeLine",children:n.map((function(e){var t=e.time;return Object(F.jsx)("p",{children:t},t)}))})]})}),z=n(17),J=(n(157),n(67)),G=n.n(J),K=n(88),W=n.n(K),Q=Object(J.WidthProvider)(G.a);function H(e){var t=e.appointments,n=e.cols,a=e.handleDrag,r=Object(c.useState)(1200),o=Object(z.a)(r,2),s=o[0],i=o[1];Object(c.useEffect)((function(){i(W()(".scheduler__appointments").width())}),[]);return t?Object(F.jsx)(Q,{className:"scheduler__dragAndDrop",cols:n,rowHeight:75,width:s,margin:[0,0],containerPadding:[0,0],verticalCompact:!1,preventCollision:!0,layout:t,onDragStop:function(e,t){var n=e.find((function(e){return e.i===t.i}));a(n)},children:t.map((function(e){var t=e.i,n=e.title,c=e.color,a=e.short_info;return Object(F.jsxs)("div",{className:"appointment",style:{borderLeft:"4px solid ".concat(c)},children:[Object(F.jsx)("div",{className:"appointment__title",children:n}),Object(F.jsx)("table",{className:"appointment__table",children:Object(F.jsx)("tbody",{children:Object(F.jsx)("tr",{children:Object.values(a).map((function(e){return Object(F.jsx)("td",{children:e},Object(h.a)())}))})})})]},t)}))}):Object(F.jsx)("span",{children:"Loading..."})}var U=function(e){var t=function(e){var t=e.raw,n=e.cell,a=Object(s.c)((function(e){return e.scheduler})).options,r=Object(s.b)(),o=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.rooms}),[a]),i=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.work_time}),[a]),l=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.day_and_date}),[a]);return{onClick:Object(c.useCallback)((function(){var e=L(i,o,l,t,n);r(S(Object(b.a)(Object(b.a)({},e),{},{raw:t,cell:n})))}),[i,o,l,t,n])}}(e).onClick;return Object(F.jsx)("td",{onClick:t,style:{width:"calc(100% / ".concat(e.rawsQuantity,")"),backgroundColor:e.selected?"#E5E5E5":""}})};function q(e){var t=e.raws,n=e.columns,c={newSelectedAppointment:Object(s.c)((function(e){return e.scheduler.newSelectedAppointment}))}.newSelectedAppointment;return Object(F.jsx)("div",{className:"scheduler__bodyTable",children:Object(F.jsx)("table",{children:Object(F.jsx)("tbody",{children:t.map((function(e,a){return Object(F.jsx)("tr",{children:n.map((function(e,n){return Object(F.jsx)(U,{selected:(null===c||void 0===c?void 0:c.raw)===a&&(null===c||void 0===c?void 0:c.cell)===n,rawsQuantity:t.length,raw:a,cell:n},Object(h.a)())}))},Object(h.a)())}))})})})}var X=function(){var e=function(){var e=Object(s.b)(),t=Object(s.c)((function(e){return e.token})).token,n=Object(s.c)((function(e){return e.scheduler})),a=n.options,r=n.isLoading,o=n.appointments;Object(c.useEffect)((function(){t&&!r&&(P(e,t),M(e,t))}),[t]);var i=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.rooms}),[a]),l=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.work_time}),[a]),u=Object(c.useMemo)((function(){return r||!a}),[r,i,l]),d=Object(c.useMemo)((function(){return new Array((null===i||void 0===i?void 0:i.length)||0).fill(1)}),[i]),b=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.day_and_date}),[a]),j=Object(c.useMemo)((function(){return new Array((null===l||void 0===l?void 0:l.length)*(null===b||void 0===b?void 0:b.length)||0).fill(1)}),[l]),m=Object(c.useCallback)((function(e){L(l,i,b,e.y,e.x)}),[l,b]);return{shouldLoad:u,rooms:i,hours:l,tableRaws:j,tableColumns:d,days:b,appointments:o,handleAppointmentDrag:m}}(),t=e.shouldLoad,n=e.rooms,a=e.hours,r=e.tableRaws,o=e.tableColumns,i=e.days,l=e.appointments,u=e.handleAppointmentDrag;return t?Object(F.jsx)("div",{className:"scheduler",children:Object(F.jsx)(R,{})}):Object(F.jsxs)("div",{className:"scheduler",children:[Object(F.jsxs)("div",{className:"scheduler__header",children:[Object(F.jsx)("div",{}),Object(F.jsx)("div",{children:Object(F.jsx)("table",{children:Object(F.jsx)("tbody",{children:Object(F.jsx)("tr",{children:n.map((function(e){var t=e.title;return Object(F.jsx)("td",{style:{width:"calc(100% / ".concat(n.length,")")},children:t},t)}))})})})})]}),Object(F.jsxs)("div",{className:"scheduler__body",children:[Object(F.jsx)("div",{className:"scheduler__dayBar",children:i.map((function(e){return Object(F.jsx)(V,{day:e,hours:a},Object(h.a)())}))}),Object(F.jsxs)("div",{className:"scheduler__appointments",children:[Object(F.jsx)(q,{raws:r,columns:o}),Object(F.jsx)(H,{appointments:l,cols:o.length,handleDrag:u})]})]})]})},Y=(n(169),function(){return Object(F.jsx)("div",{className:"scheduler__filter",children:"Filter block"})}),Z=(n(170),n(217)),$=n(210),ee=n(180),te=function(e){var t=e.open,n=e.handleClose,c=e.success,a=e.message;return Object(F.jsx)(Z.a,{className:"modal-container",open:t,onClose:n,closeAfterTransition:!0,BackdropComponent:$.a,BackdropProps:{timeout:500},children:Object(F.jsx)(ee.a,{in:t,children:Object(F.jsx)("div",{className:"modal ".concat(c?"modal-success":"modal-failed"),children:Object(F.jsx)("p",{className:"message",children:a})})})})},ne=(n(171),function(e){var t=e.buttons,n=e.onChange,a=e.selected,r=e.unicId,o=Object(c.useState)(a||t[0].id),s=Object(z.a)(o,2),i=s[0],l=s[1];Object(c.useEffect)((function(){l(a||t[0].id)}),[a]);var u=function(e){n(e)};return Object(F.jsx)("div",{className:"radio-buttons-group",children:t.map((function(e){var t=e.id,n=e.title;return Object(F.jsxs)("div",{className:"radio-buttons-group__element",children:[Object(F.jsx)("input",{type:"radio",id:r+n,value:t,checked:i===t,onChange:function(){return u(t)},className:"input"}),Object(F.jsx)("label",{htmlFor:r+n,className:"label",children:n})]})}))})}),ce=Object(c.memo)(ne),ae=(n(172),n(221)),re=n(222),oe=n(213),se=n(216),ie=function(e){var t=e.onChange,n=e.data,a=e.label,r=e.selectedValue,o=Object(c.useState)(r||""),s=Object(z.a)(o,2),i=s[0],l=s[1];Object(c.useEffect)((function(){l(r||"")}),[r]);return Object(F.jsxs)(oe.a,{variant:"outlined",className:"customSelect",children:[Object(F.jsx)(ae.a,{children:a}),Object(F.jsxs)(se.a,{value:i,onChange:function(e){var n=e.target.value;l(n),t(n)},disabled:0===n.length,children:[Object(F.jsx)(re.a,{value:"",children:Object(F.jsx)("em",{children:"\u0412\u044b\u0431\u0440\u0430\u0442\u044c"})}),n.map((function(e){var t=e.id,n=e.title;return Object(F.jsx)(re.a,{value:t,children:n},t)}))]})]})},le=Object(c.memo)(ie),ue=(n(173),n(174),function(e){var t=e.onClick;return Object(F.jsx)("div",{className:"add-form-button",onClick:t,onKeyPress:t,children:Object(F.jsx)("img",{src:"/icons/plus.svg",alt:"plus"})})}),de=(n(175),n(224)),be=function(e){var t=e.label,n=e.onChange,a=e.value,r=void 0===a?"":a,o=e.type,s=void 0===o?"string":o,i=Object(c.useState)(r||""),l=Object(z.a)(i,2),u=l[0],d=l[1];Object(c.useEffect)((function(){d(r||"")}),[r]);return Object(F.jsx)(de.a,{label:t,variant:"outlined",value:u,onChange:function(e){d(e.target.value),n(e.target.value)},type:s,className:"custom-input"})},je=function(e){var t=function(e){var t=e.onChange,n=e.clients;return{onPhoneChange:Object(c.useCallback)((function(e,c){t(e,Object(b.a)(Object(b.a)({},n[e]),{},{phone:c}))}),[n]),onNameChange:Object(c.useCallback)((function(e,c){t(e,Object(b.a)(Object(b.a)({},n[e]),{},{full_name:c}))}),[n])}}(e);return Object(F.jsx)("div",{className:"mv12",children:e.clients.map((function(n,c){return Object(F.jsxs)(F.Fragment,{children:[Object(F.jsx)(be,{label:"\u041f\u0406\u0411",value:n.full_name,onChange:function(e){return t.onNameChange(c,e)}}),Object(F.jsxs)("div",{className:"mv12 df-jc-sb",children:[Object(F.jsx)(be,{label:"\u041d\u043e\u043c\u0435\u0440 \u0442\u0435\u043b\u0435\u0444\u043e\u043d\u0443",value:n.phone,onChange:function(e){return t.onPhoneChange(c,e)}}),Object(F.jsx)("div",{style:{marginLeft:"12px"},children:Object(F.jsx)(ue,{onClick:e.onAdd})})]})]})}))})},me=Object(c.memo)(je),Oe=(n(176),function(e){var t=e.label,n=e.onClick,c=e.disabled;return Object(F.jsx)("button",{className:"primary-button ".concat(c?"disabled":""),onClick:n,disabled:c,children:t})}),pe=n(225),ve=n(220),he=(n(177),function(e){var t=e.label,n=e.onChange,a=e.selected,r=Object(c.useState)(a||!1),o=Object(z.a)(r,2),s=o[0],i=o[1];return Object(F.jsx)(pe.a,{control:Object(F.jsx)(ve.a,{checked:s,onChange:function(e){i(e.target.checked||!1),n(e.target.checked)},name:"checkedB",color:"primary"}),label:t,labelPlacement:"start",className:"custom-switch"})}),fe=Object(c.memo)(he),xe=(n(178),function(e){var t=e.onClick,n=e.index;return Object(F.jsx)("div",{className:"remove-form-button",onClick:function(){return t(n)},onKeyPress:function(){return t(n)},children:Object(F.jsx)("img",{src:"/icons/minus.svg",alt:"minus"})})}),ge=function(e){var t=function(e){var t=e.immovables,n=e.onChange,a=Object(s.c)((function(e){return e.scheduler})),r=a.options,o=a.developersInfo;return{building:Object(c.useMemo)((function(){return(null===o||void 0===o?void 0:o.building)||[]}),[o]),contracts:Object(c.useMemo)((function(){return null===r||void 0===r?void 0:r.form_data.contract_type}),[r]),immovableTypes:Object(c.useMemo)((function(){return null===r||void 0===r?void 0:r.form_data.immovable_type}),[r]),onContractChange:Object(c.useCallback)((function(e,c){n(e,Object(b.a)(Object(b.a)({},t[e]),{},{contract_type_id:c}))}),[t]),onBuildingChange:Object(c.useCallback)((function(e,c){n(e,Object(b.a)(Object(b.a)({},t[e]),{},{building_id:+c}))}),[t]),onImmovableTypeChange:Object(c.useCallback)((function(e,c){n(e,Object(b.a)(Object(b.a)({},t[e]),{},{imm_type_id:c}))}),[t]),onBankChange:Object(c.useCallback)((function(e,c){n(e,Object(b.a)(Object(b.a)({},t[e]),{},{bank:c}))}),[t]),onProxyChange:Object(c.useCallback)((function(e,c){n(e,Object(b.a)(Object(b.a)({},t[e]),{},{proxy:c}))}),[t]),onImmNumChange:Object(c.useCallback)((function(e,c){n(e,Object(b.a)(Object(b.a)({},t[e]),{},{imm_num:+c}))}),[t])}}(e);return Object(F.jsx)("div",{className:"mv12",children:e.immovables.map((function(n,c){return Object(F.jsxs)(F.Fragment,{children:[Object(F.jsx)(ce,{buttons:t.contracts,onChange:function(e){return t.onContractChange(c,e)},selected:n.contract_type_id,unicId:"contract-".concat(c)}),Object(F.jsx)("div",{className:"mv12",children:Object(F.jsx)(le,{onChange:function(e){return t.onBuildingChange(c,e)},data:t.building,label:"\u0411\u0443\u0434\u0438\u043d\u043e\u043a",selectedValue:n.building_id})}),Object(F.jsx)(ce,{buttons:t.immovableTypes,onChange:function(e){return t.onImmovableTypeChange(c,e)},selected:n.imm_type_id,unicId:"types-".concat(c)}),Object(F.jsx)("div",{className:"mv12",children:Object(F.jsx)(fe,{label:"\u0411\u0430\u043d\u043a",onChange:function(e){return t.onBankChange(c,e)},selected:n.bank})}),Object(F.jsx)("div",{className:"mv12",children:Object(F.jsx)(fe,{label:"\u0414\u043e\u0432\u0456\u0440\u0435\u043d\u0456\u0441\u0442\u044c",onChange:function(e){return t.onProxyChange(c,e)},selected:n.proxy})}),Object(F.jsxs)("div",{className:"mv12 df-jc-sb",children:[Object(F.jsx)(be,{label:"\u041d\u043e\u043c\u0435\u0440 \u043f\u0440\u0438\u043c\u0456\u0449\u0435\u043d\u043d\u044f",onChange:function(e){return t.onImmNumChange(c,e)},value:n.imm_num},"test"),e.immovables.length>1&&Object(F.jsx)("div",{style:{marginLeft:"12px"},children:Object(F.jsx)(xe,{onClick:e.onRemove,index:c})}),c===e.immovables.length-1&&Object(F.jsx)("div",{style:{marginLeft:"12px"},children:Object(F.jsx)(ue,{onClick:e.onAdd})})]})]})}))})},ye=Object(c.memo)(ge),_e=n(35);function Ce(e,t){return ke.apply(this,arguments)}function ke(){return(ke=Object(u.a)(l.a.mark((function e(t,n){var c;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,j({url:"".concat(d,"/api/filter/developer/info/").concat(n),headers:{Authorization:"Bearer ".concat(t)}});case 3:return c=e.sent,e.abrupt("return",c.data);case 7:return e.prev=7,e.t0=e.catch(0),console.log(e.t0),e.abrupt("return",null);case 11:case"end":return e.stop()}}),e,null,[[0,7]])})))).apply(this,arguments)}var Ne=function(){var e=Object(u.a)(l.a.mark((function e(t,n,c){var a;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,Ce(n,c);case 2:a=e.sent,t(I(a));case 4:case"end":return e.stop()}}),e)})));return function(t,n,c){return e.apply(this,arguments)}}(),we={contract_type_id:null,building_id:null,imm_type_id:null,imm_num:null,bank:!1,proxy:!1},Ie={phone:null,full_name:null};function Se(e,t){return Ae.apply(this,arguments)}function Ae(){return(Ae=Object(u.a)(l.a.mark((function e(t,n){var c;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,j({url:"".concat(d,"/api/cards"),headers:{Authorization:"Bearer ".concat(t)},method:"POST",bodyData:n});case 3:return c=e.sent,e.abrupt("return",c);case 7:return e.prev=7,e.t0=e.catch(0),console.log(e.t0),e.abrupt("return",null);case 11:case"end":return e.stop()}}),e,null,[[0,7]])})))).apply(this,arguments)}var Ee=function(){var e=Object(u.a)(l.a.mark((function e(t,n,c){var a;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,Se(n,c);case 2:return a=e.sent,t(A({open:!0,success:a.success,message:a.message})),t((r=a.data,{type:N,payload:r})),e.abrupt("return",{success:a.success});case 6:case"end":return e.stop()}var r}),e)})));return function(t,n,c){return e.apply(this,arguments)}}(),Me=function(){var e=function(){var e=Object(s.b)(),t=Object(s.c)((function(e){return e.token})).token,n=Object(s.c)((function(e){return e.scheduler})),a=n.options,r=n.developersInfo,o=n.isLoading,i=Object(s.c)((function(e){return e.scheduler.newSelectedAppointment})),l=Object(c.useState)(null),u=Object(z.a)(l,2),d=u[0],j=u[1],m=Object(c.useState)(null),O=Object(z.a)(m,2),p=O[0],v=O[1],h=Object(c.useState)(null),f=Object(z.a)(h,2),x=f[0],g=f[1],y=Object(c.useState)(null),_=Object(z.a)(y,2),C=_[0],k=_[1],N=Object(c.useState)([we]),w=Object(z.a)(N,2),A=w[0],E=w[1],M=Object(c.useState)([Ie]),T=Object(z.a)(M,2),D=T[0],P=T[1],L=Object(c.useMemo)((function(){return o||!a}),[a,o]),B=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.form_data.notary}),[a]),F=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.form_data.developer}),[a]),R=Object(c.useMemo)((function(){return(null===r||void 0===r?void 0:r.manager)||[]}),[r]),V=Object(c.useMemo)((function(){return(null===r||void 0===r?void 0:r.representative)||[]}),[r]),J=Object(c.useCallback)((function(e){j(e)}),[]),G=Object(c.useCallback)((function(n){v(n),n||e(I({})),t&&Ne(e,t,n)}),[t,p]),K=Object(c.useCallback)((function(e){g(e)}),[x]),W=Object(c.useCallback)((function(e){k(e)}),[C]),Q=Object(c.useCallback)((function(e,t){A[e]=t,E(Object(_e.a)(A))}),[A]),H=Object(c.useCallback)((function(e,t){D[e]=t,P(Object(_e.a)(D))}),[D]),U=Object(c.useCallback)((function(){j(null),v(null),g(null),k(null),E([we]),P([Ie])}),[]),q=Object(c.useCallback)((function(){E([].concat(Object(_e.a)(A),[we]))}),[A]),X=Object(c.useCallback)((function(e){E((function(t){return t.filter((function(t,n){return n!==e}))}))}),[A]),Y=Object(c.useCallback)((function(){P([].concat(Object(_e.a)(D),[Ie]))}),[D]),Z=Object(c.useMemo)((function(){return Boolean(p)&&A.length&&A.every((function(e){return e.building_id&&e.imm_num}))}),[p,A]),$=Object(c.useCallback)((function(){var n=i.date.split(".").reverse().join("."),c="".concat(i.year,".").concat(n," ").concat(i.time),r={immovables:A.map((function(e){return Object(b.a)(Object(b.a)({},e),{},{contract_type_id:e.contract_type_id||a.form_data.immovable_type[0].id,imm_type_id:e.imm_type_id||a.form_data.immovable_type[0].id})})),clients:D,date_time:c,dev_company_id:p,dev_representative_id:x,dev_manager_id:C,room_id:i.room,notary_id:d||B[0].id};t&&(Ee(e,t,r).then((function(e){e.success&&U()})),e(S(null)))}),[p,x,C,i,d,A,D]);return{shouldLoad:L,notaries:B,representative:V,developers:F,manager:R,selectedNotaryId:d,selectedDeveloperId:p,selectedDevRepresentativeId:x,selecedDevManagerId:C,immovables:A,clients:D,activeAddButton:Z,onNotaryChange:J,onDeveloperChange:G,onRepresentativeChange:K,onManagerChange:W,onImmovablesChange:Q,onAddImmovables:q,onRemoveImmovable:X,onClientsChange:H,onAddClients:Y,onClearAll:U,onFormCreate:$}}();return e.shouldLoad?Object(F.jsx)("div",{className:"scheduler__form schedulerForm",children:Object(F.jsx)(R,{})}):Object(F.jsxs)("div",{className:"schedulerForm",children:[Object(F.jsx)("div",{className:"schedulerForm__tabs"}),Object(F.jsxs)("div",{className:"schedulerForm__forms",children:[Object(F.jsxs)("div",{className:"schedulerForm__header",children:[Object(F.jsx)("p",{className:"title",children:"\u041d\u043e\u0432\u0438\u0439 \u0437\u0430\u043f\u0438\u0441"}),Object(F.jsx)("img",{src:"/icons/clear.svg",alt:"clear icon",className:"clear-icon",onClick:e.onClearAll})]}),Object(F.jsx)("div",{className:"mv12",children:Object(F.jsx)(ce,{buttons:e.notaries,onChange:e.onNotaryChange,selected:e.selectedNotaryId,unicId:"notaries"})}),Object(F.jsx)("div",{className:"mv12",children:Object(F.jsx)(le,{label:"\u0417\u0430\u0431\u0443\u0434\u043e\u0432\u043d\u0438\u043a",data:e.developers,onChange:e.onDeveloperChange,selectedValue:e.selectedDeveloperId})}),Object(F.jsx)("div",{className:"mv12",children:Object(F.jsx)(le,{onChange:e.onRepresentativeChange,data:e.representative,label:"\u041f\u0456\u0434\u043f\u0438\u0441\u0430\u043d\u0442",selectedValue:e.selectedDevRepresentativeId})}),Object(F.jsx)("div",{className:"mv12",children:Object(F.jsx)(le,{onChange:e.onManagerChange,data:e.manager,label:"\u041c\u0435\u043d\u0435\u0434\u0436\u0435\u0440",selectedValue:e.selecedDevManagerId})}),Object(F.jsx)(ye,{immovables:e.immovables,onChange:e.onImmovablesChange,onAdd:e.onAddImmovables,onRemove:e.onRemoveImmovable}),Object(F.jsx)(me,{clients:e.clients,onChange:e.onClientsChange,onAdd:e.onAddClients}),Object(F.jsx)("div",{className:"mv12",children:Object(F.jsx)(Oe,{label:"\u0421\u0442\u0432\u043e\u0440\u0438\u0442\u0438",onClick:e.onFormCreate,disabled:!e.activeAddButton})})]})]})},Te=Object(c.memo)(Me),De=function(){var e=function(){var e=Object(s.b)(),t=Object(s.c)((function(e){return e.scheduler.newSelectedAppointment})),n=Object(s.c)((function(e){return e.scheduler.modalInfo}));return{newSelectedAppointment:t,modalProps:Object(c.useMemo)((function(){return Object(b.a)(Object(b.a)({},n),{},{handleClose:function(){return e(A(Object(b.a)(Object(b.a)({},n),{},{open:!1})))}})}),[n])}}();return Object(F.jsxs)("div",{className:"scheduler__form",children:[Object(F.jsx)(Te,{}),Object(F.jsx)(te,Object(b.a)({},e.modalProps))]})},Pe=function(){return Object(F.jsxs)("div",{className:"scheduler__container",children:[Object(F.jsxs)("div",{className:"scheduler__dataView",children:[Object(F.jsx)(Y,{}),Object(F.jsx)(X,{})]}),Object(F.jsx)(De,{})]})},Le=function(){return Object(F.jsx)(Pe,{})},Be=function(){return function(){var e=Object(s.b)();Object(c.useEffect)((function(){v(e)}),[])}(),Object(F.jsx)(Le,{})},Fe=n(42),Re={token:null},Ve=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:Re,t=arguments.length>1?arguments[1]:void 0;switch(t.type){case p:return Object(b.a)(Object(b.a)({},e),{},{token:t.payload});default:return e}},ze={options:null,appointments:[],developersInfo:{},newSelectedAppointment:null,modalInfo:{open:!1,success:!1,message:""},isLoading:!1},Je=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:ze,t=arguments.length>1?arguments[1]:void 0;switch(t.type){case g:return Object(b.a)(Object(b.a)({},e),{},{options:t.payload});case y:return Object(b.a)(Object(b.a)({},e),{},{appointments:t.payload});case N:return Object(b.a)(Object(b.a)({},e),{},{appointments:[].concat(Object(_e.a)(e.appointments),[t.payload])});case _:return Object(b.a)(Object(b.a)({},e),{},{developersInfo:t.payload});case k:return Object(b.a)(Object(b.a)({},e),{},{isLoading:t.payload});case C:return Object(b.a)(Object(b.a)({},e),{},{newSelectedAppointment:t.payload});case w:return Object(b.a)(Object(b.a)({},e),{},{modalInfo:Object(b.a)({},t.payload)});default:return e}},Ge=Object(Fe.b)({token:Ve,scheduler:Je}),Ke=Object(Fe.c)(Ge);o.a.render(Object(F.jsx)(a.a.StrictMode,{children:Object(F.jsx)(s.a,{store:Ke,children:Object(F.jsx)(Be,{})})}),document.getElementById("root"))}},[[179,1,2]]]);
//# sourceMappingURL=main.b2976cfc.chunk.js.map