(this.webpackJsonpfront=this.webpackJsonpfront||[]).push([[0],{112:function(e,t,n){},117:function(e,t,n){},119:function(e,t,n){},120:function(e,t,n){},158:function(e,t,n){},159:function(e,t,n){},170:function(e,t,n){},171:function(e,t,n){},172:function(e,t,n){},173:function(e,t,n){},174:function(e,t,n){},175:function(e,t,n){},176:function(e,t,n){},177:function(e,t,n){},178:function(e,t,n){},179:function(e,t,n){},180:function(e,t,n){},181:function(e,t,n){},182:function(e,t,n){},183:function(e,t,n){"use strict";n.r(t);var c=n(0),a=n.n(c),r=n(13),o=n.n(r),i=(n(112),n(16)),s=(n(117),n(7)),l=n.n(s),u=n(9),d="http://app.synction.space",b=n(5),j=function(){var e=Object(u.a)(l.a.mark((function e(t){var n,c,a,r,o,i,s,u,d;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return n=t.url,c=t.method,a=void 0===c?"GET":c,r=t.headers,o=void 0===r?{}:r,i=t.bodyData,s={body:void 0,method:a||"GET",headers:Object(b.a)({Accept:"application/json","Content-Type":"applicatioin/json"},o)},i&&(s.body=JSON.stringify(i)),e.next=5,fetch(n,s);case 5:return u=e.sent,e.next=8,u.json();case 8:return d=e.sent,e.abrupt("return",d);case 10:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}();function p(){return m.apply(this,arguments)}function m(){return(m=Object(u.a)(l.a.mark((function e(){var t;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,j({url:"".concat(d,"/api/login?email=oleg99@gmail.com&password=admin123"),method:"POST"});case 3:return t=e.sent,e.abrupt("return",t.data.token);case 7:return e.prev=7,e.t0=e.catch(0),console.log(e.t0),e.abrupt("return",null);case 11:case"end":return e.stop()}}),e,null,[[0,7]])})))).apply(this,arguments)}var f="SET_TOKEN",O=function(){var e=Object(u.a)(l.a.mark((function e(t){var n;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,p();case 2:n=e.sent,t({type:f,payload:n});case 4:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),v=(n(119),n(120),n(223));function h(e){return x.apply(this,arguments)}function x(){return(x=Object(u.a)(l.a.mark((function e(t){var n;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,j({url:"".concat(d,"/api/cards"),headers:{Authorization:"Bearer ".concat(t)}});case 3:return n=e.sent,e.abrupt("return",n.data);case 7:return e.prev=7,e.t0=e.catch(0),console.log(e.t0),e.abrupt("return",null);case 11:case"end":return e.stop()}}),e,null,[[0,7]])})))).apply(this,arguments)}var y="SET_OPTIONS",g="SET_APPOINTMENTS",_="SET_DEVELOPERS_INFO",C="SET_SELECTED_NEW_APPOINTMENT",k="SET_SELECTED_OLD_APPOINTMENT",N="SET_EDIT_APPOINTMENT_DATA",w="SET_IS_LOADING",A="ADD_NEW_APPOINTMENT",S="SET_MODAL_INFO",E="EDIT_APPOINTMENTS",T=function(e){return{type:_,payload:e}},I=function(e){return{type:C,payload:e}},D=function(e){return{type:k,payload:e}},M=function(e){return{type:N,payload:e}},P=function(e){return{type:E,payload:e}},L=function(e){return{type:S,payload:e}},B=function(e){return{type:w,payload:e}},F=function(){var e=Object(u.a)(l.a.mark((function e(t,n){var c;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t(B(!0)),e.next=3,h(n);case 3:c=e.sent,t((a=Object.values(c),{type:g,payload:a})),t(B(!1));case 6:case"end":return e.stop()}var a}),e)})));return function(t,n){return e.apply(this,arguments)}}();function R(e,t){return V.apply(this,arguments)}function V(){return(V=Object(u.a)(l.a.mark((function e(t,n){var c;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,j({url:"".concat(d,"/api/cards/").concat(n),headers:{Authorization:"Bearer ".concat(t)}});case 3:return c=e.sent,e.abrupt("return",c.data);case 7:return e.prev=7,e.t0=e.catch(0),console.log(e.t0),e.abrupt("return",null);case 11:case"end":return e.stop()}}),e,null,[[0,7]])})))).apply(this,arguments)}var z=function(){var e=Object(u.a)(l.a.mark((function e(t,n,c){var a;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,R(n,c);case 2:a=e.sent,t(M(a));case 4:case"end":return e.stop()}}),e)})));return function(t,n,c){return e.apply(this,arguments)}}();function G(e){return J.apply(this,arguments)}function J(){return(J=Object(u.a)(l.a.mark((function e(t){var n;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,j({url:"".concat(d,"/api/calendar"),headers:{Authorization:"Bearer ".concat(t)}});case 3:return n=e.sent,e.abrupt("return",n.data);case 7:return e.prev=7,e.t0=e.catch(0),console.log(e.t0),e.abrupt("return",null);case 11:case"end":return e.stop()}}),e,null,[[0,7]])})))).apply(this,arguments)}var K=function(){var e=Object(u.a)(l.a.mark((function e(t,n){var c;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t(B(!0)),e.next=3,G(n);case 3:c=e.sent,t({type:y,payload:c}),t(B(!1));case 6:case"end":return e.stop()}}),e)})));return function(t,n){return e.apply(this,arguments)}}(),W=function(e,t,n,c,a){var r=n[Math.floor(c/e.length)],o=r.day,i=r.date,s=r.year,l=e[c%e.length].time,u=t[a].id;return{day:o,date:i.split(".").reverse().join("."),year:s,time:l,room:u}};function Q(e,t,n){return U.apply(this,arguments)}function U(){return(U=Object(u.a)(l.a.mark((function e(t,n,c){var a;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,j({url:"".concat(d,"/api/cards/move/").concat(c),headers:{Authorization:"Bearer ".concat(t)},method:"PUT",bodyData:n});case 3:return a=e.sent,e.abrupt("return",a);case 7:return e.prev=7,e.t0=e.catch(0),console.log(e.t0),e.abrupt("return",null);case 11:case"end":return e.stop()}}),e,null,[[0,7]])})))).apply(this,arguments)}var H=function(){var e=Object(u.a)(l.a.mark((function e(t,n,c,a){var r,o,i;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,Q(n,c,a);case 2:r=e.sent,o=r.success,i=r.data,o&&t(P(i));case 6:case"end":return e.stop()}}),e)})));return function(t,n,c,a){return e.apply(this,arguments)}}(),q=n(87),X=n(2),Y=function(){return Object(X.jsx)(q.LoopCircleLoading,{color:"#165153"})},Z=(n(158),function(e){var t=e.day,n=e.hours;return Object(X.jsxs)("div",{className:"scheduler__weekDay",children:[Object(X.jsx)("div",{className:"scheduler__day",children:Object(X.jsxs)("p",{children:[t.day,Object(X.jsx)("br",{}),t.date]})}),Object(X.jsx)("div",{className:"scheduler__timeLine",children:n.map((function(e){var t=e.time;return Object(X.jsx)("p",{children:t},t)}))})]})}),$=n(17),ee=(n(159),n(67)),te=n.n(ee),ne=n(90),ce=n.n(ne),ae=Object(ee.WidthProvider)(te.a);function re(e){var t=e.appointments,n=e.cols,a=e.handleDrag,r=e.handleClick,o=Object(c.useState)(1200),i=Object($.a)(o,2),s=i[0],l=i[1];Object(c.useEffect)((function(){l(ce()(".scheduler__appointments").width())}),[]);return t?Object(X.jsx)(ae,{className:"scheduler__dragAndDrop",cols:n,rowHeight:75,width:s,margin:[0,0],containerPadding:[0,0],verticalCompact:!1,preventCollision:!0,layout:t,onDragStop:function(e,t){var n=e.find((function(e){return e.i===t.i}));a(n)},children:t.map((function(e){return Object(X.jsxs)("div",{className:"appointment",style:{borderLeft:"4px solid ".concat(e.color)},onClick:function(){return r(e)},children:[Object(X.jsx)("div",{className:"appointment__title",children:e.title}),Object(X.jsx)("table",{className:"appointment__table",children:Object(X.jsx)("tbody",{children:Object(X.jsx)("tr",{children:Object.values(e.short_info).map((function(e){return Object(X.jsx)("td",{children:e},Object(v.a)())}))})})})]},e.i)}))}):Object(X.jsx)("span",{children:"Loading..."})}var oe=n(68),ie=n.n(oe),se=function(e){var t=function(e){var t=e.raw,n=e.cell,a=Object(i.c)((function(e){return e.scheduler})).options,r=Object(i.b)(),o=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.rooms}),[a]),s=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.work_time}),[a]),l=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.day_and_date}),[a]);return{onClick:Object(c.useCallback)((function(){var e=W(s,o,l,t,n);ie()("".concat(e.year,".").concat(e.date,". ").concat(e.time)).isBefore(ie()())||r(I(Object(b.a)(Object(b.a)({},e),{},{raw:t,cell:n})))}),[s,o,l,t,n])}}(e).onClick;return Object(X.jsx)("td",{onClick:t,style:{width:"calc(100% / ".concat(e.rowsQuantity,")"),backgroundColor:e.selected?"#E5E5E5":""}})};function le(e){var t=e.rows,n=e.columns,c={newSelectedAppointment:Object(i.c)((function(e){return e.scheduler.newSelectedAppointment}))}.newSelectedAppointment;return Object(X.jsx)("div",{className:"scheduler__bodyTable",children:Object(X.jsx)("table",{children:Object(X.jsx)("tbody",{children:t.map((function(e,a){return Object(X.jsx)("tr",{children:n.map((function(e,n){return Object(X.jsx)(se,{selected:(null===c||void 0===c?void 0:c.raw)===a&&(null===c||void 0===c?void 0:c.cell)===n,rowsQuantity:t.length,raw:a,cell:n},Object(v.a)())}))},Object(v.a)())}))})})})}var ue=function(){var e=function(){var e=Object(i.b)(),t=Object(i.c)((function(e){return e.token})).token,n=Object(i.c)((function(e){return e.scheduler})),a=n.options,r=n.isLoading,o=n.appointments;Object(c.useEffect)((function(){t&&!r&&(K(e,t),F(e,t))}),[t]);var s=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.rooms}),[a]),d=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.work_time}),[a]),j=Object(c.useMemo)((function(){return r||!a}),[r,s,d]),p=Object(c.useMemo)((function(){return new Array((null===s||void 0===s?void 0:s.length)||0).fill(1)}),[s]),m=Object(c.useMemo)((function(){return null===a||void 0===a?void 0:a.day_and_date}),[a]),f=Object(c.useMemo)((function(){return new Array((null===d||void 0===d?void 0:d.length)*(null===m||void 0===m?void 0:m.length)||0).fill(1)}),[d]),O=Object(c.useCallback)((function(n){var c=W(d,s,m,n.y,n.x),a=c.year,r=c.date,o=c.time,i=c.room,l="".concat(a,".").concat(r,". ").concat(o);t&&H(e,t,{date_time:l,room_id:i},n.i)}),[d,m,s,m]),v=Object(c.useCallback)(function(){var n=Object(u.a)(l.a.mark((function n(c){var a,r,o,i;return l.a.wrap((function(n){for(;;)switch(n.prev=n.next){case 0:if(a=c.x,r=c.y,o=c.i,i=W(d,s,m,r,a),!t){n.next=5;break}return n.next=5,z(e,t,o);case 5:e(D(Object(b.a)(Object(b.a)({},i),{},{i:o})));case 6:case"end":return n.stop()}}),n)})));return function(e){return n.apply(this,arguments)}}(),[d,s,m]);return{shouldLoad:j,rooms:s,hours:d,tableRows:f,tableColumns:p,days:m,appointments:o,handleAppointmentDrag:O,onAppointmentClick:v}}(),t=e.shouldLoad,n=e.rooms,a=e.hours,r=e.tableRows,o=e.tableColumns,s=e.days,d=e.appointments,j=e.handleAppointmentDrag,p=e.onAppointmentClick;return t?Object(X.jsx)("div",{className:"scheduler",children:Object(X.jsx)(Y,{})}):Object(X.jsxs)("div",{className:"scheduler",children:[Object(X.jsxs)("div",{className:"scheduler__header",children:[Object(X.jsx)("div",{}),Object(X.jsx)("div",{children:Object(X.jsx)("table",{children:Object(X.jsx)("tbody",{children:Object(X.jsx)("tr",{children:n.map((function(e){var t=e.title;return Object(X.jsx)("td",{style:{width:"calc(100% / ".concat(n.length,")")},children:t},t)}))})})})})]}),Object(X.jsxs)("div",{className:"scheduler__body",children:[Object(X.jsx)("div",{className:"scheduler__dayBar",children:s.map((function(e){return Object(X.jsx)(Z,{day:e,hours:a},Object(v.a)())}))}),Object(X.jsxs)("div",{className:"scheduler__appointments",children:[Object(X.jsx)(le,{rows:r,columns:o}),Object(X.jsx)(re,{appointments:d,cols:o.length,handleDrag:j,handleClick:p})]})]})]})},de=(n(170),function(){return Object(X.jsx)("div",{className:"scheduler__filter",children:"Filter block"})}),be=(n(171),n(172),n(221)),je=n(214),pe=n(184),me=function(e){var t=e.open,n=e.handleClose,c=e.success,a=e.message;return Object(X.jsx)(be.a,{className:"modal-container",open:t,onClose:n,closeAfterTransition:!0,BackdropComponent:je.a,BackdropProps:{timeout:500},children:Object(X.jsx)(pe.a,{in:t,children:Object(X.jsx)("div",{className:"modal ".concat(c?"modal-success":"modal-failed"),children:Object(X.jsx)("p",{className:"message",children:a})})})})},fe=(n(173),function(e){var t=e.buttons,n=e.onChange,a=e.selected,r=e.unicId,o=Object(c.useState)(a||t[0].id),i=Object($.a)(o,2),s=i[0],l=i[1];Object(c.useEffect)((function(){l(a||t[0].id)}),[a]);var u=function(e){n(e)};return Object(X.jsx)("div",{className:"radio-buttons-group",children:t.map((function(e){var n=e.id,c=e.title;return Object(X.jsxs)("div",{className:"radio-buttons-group__element ".concat(1===t.length?"edit":""),children:[Object(X.jsx)("input",{type:"radio",id:r+c,value:n,checked:s===n,onChange:function(){return u(n)},className:"input"}),Object(X.jsx)("label",{htmlFor:r+c,className:"label",children:c})]})}))})}),Oe=Object(c.memo)(fe),ve=(n(174),n(225)),he=n(226),xe=n(217),ye=n(220),ge=function(e){var t=e.onChange,n=e.data,a=e.label,r=e.selectedValue,o=e.disabled,i=Object(c.useState)(r||""),s=Object($.a)(i,2),l=s[0],u=s[1];Object(c.useEffect)((function(){u(r||"")}),[r]);return Object(X.jsxs)(xe.a,{variant:"outlined",className:"customSelect",children:[Object(X.jsx)(ve.a,{children:a}),Object(X.jsxs)(ye.a,{value:l,onChange:function(e){var n=e.target.value;u(n),t(n)},disabled:o||0===n.length,children:[Object(X.jsx)(he.a,{value:"",children:Object(X.jsx)("em",{children:"\u0412\u044b\u0431\u0440\u0430\u0442\u044c"})}),n.map((function(e){var t=e.id,n=e.title;return Object(X.jsx)(he.a,{value:t,children:n},t)}))]})]})},_e=Object(c.memo)(ge),Ce=(n(175),n(176),n(177),function(e){var t=e.onClick,n=e.disabled,c=function(){n||t()};return Object(X.jsx)("div",{className:"add-form-button ".concat(n?"disabled":""),onClick:c,onKeyPress:c,children:Object(X.jsx)("img",{src:"/icons/plus.svg",alt:"plus"})})}),ke=(n(178),n(228)),Ne=function(e){var t=e.label,n=e.onChange,a=e.value,r=void 0===a?"":a,o=e.type,i=void 0===o?"string":o,s=e.disabled,l=Object(c.useState)(r||""),u=Object($.a)(l,2),d=u[0],b=u[1];Object(c.useEffect)((function(){b(r||"")}),[r]);return Object(X.jsx)(ke.a,{label:t,variant:"outlined",value:d,onChange:function(e){b(e.target.value),n(e.target.value)},type:i,className:"custom-input",disabled:s||!1})},we=(n(179),function(e){var t=e.onClick,n=e.index,c=e.disabled;return Object(X.jsx)("div",{className:"remove-form-button ".concat(c?"disabled":""),onClick:function(){c||t(n)},onKeyPress:function(){return t(n)},children:Object(X.jsx)("img",{src:"/icons/minus.svg",alt:"minus"})})}),Ae=function(e){var t=function(e){var t=e.onChange,n=e.clients;return{onPhoneChange:Object(c.useCallback)((function(e,c){t(e,Object(b.a)(Object(b.a)({},n[e]),{},{phone:c}))}),[n]),onNameChange:Object(c.useCallback)((function(e,c){t(e,Object(b.a)(Object(b.a)({},n[e]),{},{full_name:c}))}),[n])}}(e);return Object(X.jsx)("div",{className:"mv12",children:e.clients.map((function(n,c){return Object(X.jsxs)("div",{className:"clients__item mv12",children:[Object(X.jsx)(Ne,{label:"\u041f\u0406\u0411",value:n.full_name,onChange:function(e){return t.onNameChange(c,e)},disabled:e.disabled||!1}),Object(X.jsxs)("div",{className:"mv12 df-jc-sb",children:[Object(X.jsx)(Ne,{label:"\u041d\u043e\u043c\u0435\u0440 \u0442\u0435\u043b\u0435\u0444\u043e\u043d\u0443",value:n.phone,onChange:function(e){return t.onPhoneChange(c,e)},disabled:e.disabled||!1}),e.clients.length>1&&Object(X.jsx)("div",{style:{marginLeft:"12px"},children:Object(X.jsx)(we,{onClick:e.onRemove,index:c,disabled:e.disabled||!1})}),c===e.clients.length-1&&Object(X.jsx)("div",{style:{marginLeft:"12px"},children:Object(X.jsx)(Ce,{onClick:e.onAdd,disabled:e.disabled||!1})})]})]})}))})},Se=Object(c.memo)(Ae),Ee=(n(180),function(e){var t=e.label,n=e.onClick,c=e.disabled,a=e.className;return Object(X.jsx)("button",{className:"primary-button ".concat(c?"disabled":""," ").concat(a||""),onClick:n,disabled:c,children:t})}),Te=(n(181),n(229)),Ie=n(224),De=(n(182),function(e){var t=e.label,n=e.onChange,a=e.selected,r=e.disabled,o=Object(c.useState)(a),i=Object($.a)(o,2),s=i[0],l=i[1];return Object(c.useEffect)((function(){l(a)}),[a]),Object(X.jsx)(Te.a,{control:Object(X.jsx)(Ie.a,{checked:s,onChange:function(e){l(e.target.checked),n(e.target.checked)},name:"checkedB",color:"primary"}),label:t,labelPlacement:"start",className:"custom-switch",disabled:r||!1})}),Me=Object(c.memo)(De),Pe=function(e){var t=function(e){var t=e.immovables,n=e.onChange,a=Object(i.c)((function(e){return e.scheduler})),r=a.options,o=a.developersInfo;return{building:Object(c.useMemo)((function(){return(null===o||void 0===o?void 0:o.building)||[]}),[o]),contracts:Object(c.useMemo)((function(){return null===r||void 0===r?void 0:r.form_data.contract_type}),[r]),immovableTypes:Object(c.useMemo)((function(){return null===r||void 0===r?void 0:r.form_data.immovable_type}),[r]),onContractChange:Object(c.useCallback)((function(e,c){n(e,Object(b.a)(Object(b.a)({},t[e]),{},{contract_type_id:c}))}),[t]),onBuildingChange:Object(c.useCallback)((function(e,c){n(e,Object(b.a)(Object(b.a)({},t[e]),{},{building_id:+c}))}),[t]),onImmovableTypeChange:Object(c.useCallback)((function(e,c){n(e,Object(b.a)(Object(b.a)({},t[e]),{},{imm_type_id:c}))}),[t]),onBankChange:Object(c.useCallback)((function(e,c){n(e,Object(b.a)(Object(b.a)({},t[e]),{},{bank:c}))}),[t]),onProxyChange:Object(c.useCallback)((function(e,c){n(e,Object(b.a)(Object(b.a)({},t[e]),{},{proxy:c}))}),[t]),onImmNumChange:Object(c.useCallback)((function(e,c){n(e,Object(b.a)(Object(b.a)({},t[e]),{},{imm_number:+c}))}),[t])}}(e);return Object(X.jsx)("div",{className:"mv12 immovables__group",children:e.immovables.map((function(n,c){return Object(X.jsxs)("div",{className:"immovables__item mv12",children:[Object(X.jsx)(Oe,{buttons:e.disabled?t.contracts.filter((function(e){return e.id===(n.contract_type_id||t.contracts[0].id)})):t.contracts,onChange:function(e){return t.onContractChange(c,e)},selected:n.contract_type_id,unicId:"contract-".concat(c)}),Object(X.jsx)("div",{className:"mv12",children:Object(X.jsx)(_e,{onChange:function(e){return t.onBuildingChange(c,e)},data:t.building,label:"\u0411\u0443\u0434\u0438\u043d\u043e\u043a",selectedValue:n.building_id,disabled:e.disabled||!1})}),Object(X.jsx)(Oe,{buttons:e.disabled?t.immovableTypes.filter((function(e){return e.id===(n.imm_type_id||t.immovableTypes[0].id)})):t.immovableTypes,onChange:function(e){return t.onImmovableTypeChange(c,e)},selected:n.imm_type_id,unicId:"types-".concat(c)}),Object(X.jsx)("div",{className:"mv12",children:Object(X.jsx)(Me,{label:"\u0411\u0430\u043d\u043a",onChange:function(e){return t.onBankChange(c,e)},selected:n.bank,disabled:e.disabled})}),Object(X.jsx)("div",{className:"mv12",children:Object(X.jsx)(Me,{label:"\u0414\u043e\u0432\u0456\u0440\u0435\u043d\u0456\u0441\u0442\u044c",onChange:function(e){return t.onProxyChange(c,e)},selected:n.proxy,disabled:e.disabled})}),Object(X.jsxs)("div",{className:"mv12 df-jc-sb",children:[Object(X.jsx)(Ne,{label:"\u041d\u043e\u043c\u0435\u0440 \u043f\u0440\u0438\u043c\u0456\u0449\u0435\u043d\u043d\u044f",onChange:function(e){return t.onImmNumChange(c,e)},value:n.imm_number,disabled:e.disabled},"test"),e.immovables.length>1&&Object(X.jsx)("div",{style:{marginLeft:"12px"},children:Object(X.jsx)(we,{onClick:e.onRemove,index:c,disabled:e.disabled})}),c===e.immovables.length-1&&Object(X.jsx)("div",{style:{marginLeft:"12px"},children:Object(X.jsx)(Ce,{onClick:e.onAdd,disabled:e.disabled})})]})]})}))})},Le=Object(c.memo)(Pe),Be=n(31);function Fe(e,t){return Re.apply(this,arguments)}function Re(){return(Re=Object(u.a)(l.a.mark((function e(t,n){var c;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,j({url:"".concat(d,"/api/filter/developer/info/").concat(n),headers:{Authorization:"Bearer ".concat(t)}});case 3:return c=e.sent,e.abrupt("return",c.data);case 7:return e.prev=7,e.t0=e.catch(0),console.log(e.t0),e.abrupt("return",null);case 11:case"end":return e.stop()}}),e,null,[[0,7]])})))).apply(this,arguments)}var Ve=function(){var e=Object(u.a)(l.a.mark((function e(t,n,c){var a;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,Fe(n,c);case 2:a=e.sent,t(T(a));case 4:case"end":return e.stop()}}),e)})));return function(t,n,c){return e.apply(this,arguments)}}(),ze={contract_type_id:null,building_id:null,imm_type_id:null,imm_number:null,bank:!1,proxy:!1},Ge={phone:null,full_name:null};function Je(e,t){return Ke.apply(this,arguments)}function Ke(){return(Ke=Object(u.a)(l.a.mark((function e(t,n){var c;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,j({url:"".concat(d,"/api/cards"),headers:{Authorization:"Bearer ".concat(t)},method:"POST",bodyData:n});case 3:return c=e.sent,e.abrupt("return",c);case 7:return e.prev=7,e.t0=e.catch(0),console.log(e.t0),e.abrupt("return",null);case 11:case"end":return e.stop()}}),e,null,[[0,7]])})))).apply(this,arguments)}var We=function(){var e=Object(u.a)(l.a.mark((function e(t,n,c){var a;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,Je(n,c);case 2:return a=e.sent,t(L({open:!0,success:a.success,message:a.message})),a.success&&t((r=a.data,{type:A,payload:r})),e.abrupt("return",{success:a.success});case 6:case"end":return e.stop()}var r}),e)})));return function(t,n,c){return e.apply(this,arguments)}}();function Qe(e,t,n){return Ue.apply(this,arguments)}function Ue(){return(Ue=Object(u.a)(l.a.mark((function e(t,n,c){var a;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,j({url:"".concat(d,"/api/cards/").concat(c),headers:{Authorization:"Bearer ".concat(t)},method:"PUT",bodyData:n});case 3:return a=e.sent,e.abrupt("return",a);case 7:return e.prev=7,e.t0=e.catch(0),console.log(e.t0),e.abrupt("return",null);case 11:case"end":return e.stop()}}),e,null,[[0,7]])})))).apply(this,arguments)}var He=function(){var e=Object(u.a)(l.a.mark((function e(t,n,c,a){var r,o,i,s;return l.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,Qe(n,c,a);case 2:r=e.sent,o=r.success,i=r.message,s=r.data,t(L({open:!0,success:o,message:i})),o&&t(P(s));case 8:case"end":return e.stop()}}),e)})));return function(t,n,c,a){return e.apply(this,arguments)}}(),qe=function(e){var t=function(e){var t=e.selectedCard,n=e.initialValues,a=e.edit,r=Object(i.b)(),o=Object(i.c)((function(e){return e.token})).token,s=Object(i.c)((function(e){return e.scheduler})),l=s.options,u=s.developersInfo,d=s.isLoading,j=Object(c.useState)(a||!1),p=Object($.a)(j,2),m=p[0],f=p[1],O=Object(c.useState)((null===n||void 0===n?void 0:n.card.notary_id)||null),v=Object($.a)(O,2),h=v[0],x=v[1],y=Object(c.useState)(null),g=Object($.a)(y,2),_=g[0],C=g[1],k=Object(c.useState)(null),N=Object($.a)(k,2),w=N[0],A=N[1],S=Object(c.useState)(null),E=Object($.a)(S,2),P=E[0],L=E[1],B=Object(c.useState)([ze]),F=Object($.a)(B,2),R=F[0],V=F[1],z=Object(c.useState)([Ge]),G=Object($.a)(z,2),J=G[0],K=G[1],W=Object(c.useMemo)((function(){return d||!l}),[l,d]),Q=Object(c.useMemo)((function(){return null===l||void 0===l?void 0:l.form_data.notary}),[l]),U=Object(c.useMemo)((function(){return null===l||void 0===l?void 0:l.form_data.developer}),[l]),H=Object(c.useMemo)((function(){return(null===u||void 0===u?void 0:u.manager)||[]}),[u]),q=Object(c.useMemo)((function(){return(null===u||void 0===u?void 0:u.representative)||[]}),[u]),X=Object(c.useCallback)((function(e){x(e)}),[]);Object(c.useEffect)((function(){n&&(f(!0),x(n.card.notary_id),C(n.card.dev_company_id),A(n.card.dev_representative_id),L(n.card.dev_manager_id),V(0===n.immovables.length?[ze]:n.immovables),K(0===n.clients.length?[Ge]:n.clients)),(null===n||void 0===n?void 0:n.card.dev_company_id)&&o&&Ve(r,o,n.card.dev_company_id)}),[n]);var Y=Object(c.useCallback)((function(e){C(e),e||r(T({})),o&&Ve(r,o,e)}),[o,_]),Z=Object(c.useCallback)((function(e){A(e)}),[w]),ee=Object(c.useCallback)((function(e){L(e)}),[P]),te=Object(c.useCallback)((function(e,t){R[e]=t,V(Object(Be.a)(R))}),[R]),ne=Object(c.useCallback)((function(e,t){J[e]=t,K(Object(Be.a)(J))}),[J]),ce=Object(c.useCallback)((function(){x(null),C(null),A(null),L(null),V([ze]),K([Ge])}),[]),ae=Object(c.useCallback)((function(){V([].concat(Object(Be.a)(R),[ze]))}),[R]),re=Object(c.useCallback)((function(e){V((function(t){return t.filter((function(t,n){return n!==e}))}))}),[R]),oe=Object(c.useCallback)((function(){K([].concat(Object(Be.a)(J),[Ge]))}),[J]),ie=Object(c.useCallback)((function(e){K((function(t){return t.filter((function(t,n){return n!==e}))}))}),[J]),se=Object(c.useMemo)((function(){return Boolean(_)&&R.length&&R.every((function(e){return e.building_id&&e.imm_number}))&&t}),[_,R,t]),le=Object(c.useCallback)((function(){var e="".concat(t.year,".").concat(t.date,". ").concat(t.time),n={immovables:R.map((function(e){return Object(b.a)(Object(b.a)({},e),{},{contract_type_id:e.contract_type_id||l.form_data.immovable_type[0].id,imm_type_id:e.imm_type_id||l.form_data.immovable_type[0].id,imm_num:e.imm_number})})),clients:J,date_time:e,dev_company_id:_,dev_representative_id:w,dev_manager_id:P,room_id:t.room,notary_id:h||Q[0].id};o&&(a?(He(r,o,n,t.i),f(!0)):(We(r,o,n).then((function(e){e.success&&ce()})),r(I(null))))}),[_,w,P,h,R,J,a,t]),ue=Object(c.useCallback)((function(){r(D(null)),r(M(null))}),[]);return{shouldLoad:W,notaries:Q,representative:q,developers:U,manager:H,selectedNotaryId:h,selectedDeveloperId:_,selectedDevRepresentativeId:w,selecedDevManagerId:P,immovables:R,clients:J,activeAddButton:se,insideEdit:m,onNotaryChange:X,onDeveloperChange:Y,onRepresentativeChange:Z,onManagerChange:ee,onImmovablesChange:te,onAddImmovables:ae,onRemoveImmovable:re,onRemoveClient:ie,onClientsChange:ne,onAddClients:oe,onClearAll:ce,onFormCreate:le,onCloseForm:ue,setEdit:f}}(e);return t.shouldLoad?Object(X.jsx)("div",{className:"scheduler__form schedulerForm",children:Object(X.jsx)(Y,{})}):Object(X.jsx)("div",{className:"schedulerForm",children:Object(X.jsxs)("div",{className:"schedulerForm__forms",children:[Object(X.jsxs)("div",{className:"schedulerForm__header",children:[Object(X.jsx)("p",{className:"title",children:t.insideEdit||e.edit?"\u0417\u0430\u043f\u0438\u0441 \u2116 ".concat(e.selectedCard.i):"\u041d\u043e\u0432\u0438\u0439 \u0437\u0430\u043f\u0438\u0441"}),t.insideEdit?Object(X.jsx)("img",{src:"/icons/x.svg",alt:"clear icon",className:"clear-icon",onClick:t.onCloseForm}):Object(X.jsx)("img",{src:"/icons/clear.svg",alt:"clear icon",className:"clear-icon",onClick:t.onClearAll})]}),Object(X.jsx)("div",{className:"mv12",children:Object(X.jsx)(Oe,{buttons:t.insideEdit?t.notaries.filter((function(e){return e.id===t.selectedNotaryId})):t.notaries,onChange:t.onNotaryChange,selected:t.selectedNotaryId,unicId:"notaries"})}),Object(X.jsx)("div",{className:"mv12",children:Object(X.jsx)(_e,{label:"\u0417\u0430\u0431\u0443\u0434\u043e\u0432\u043d\u0438\u043a",data:t.developers,onChange:t.onDeveloperChange,selectedValue:t.selectedDeveloperId,disabled:t.insideEdit||!1})}),Object(X.jsx)("div",{className:"mv12",children:Object(X.jsx)(_e,{onChange:t.onRepresentativeChange,data:t.representative,label:"\u041f\u0456\u0434\u043f\u0438\u0441\u0430\u043d\u0442",selectedValue:t.selectedDevRepresentativeId,disabled:t.insideEdit||!1})}),Object(X.jsx)("div",{className:"mv12",children:Object(X.jsx)(_e,{onChange:t.onManagerChange,data:t.manager,label:"\u041c\u0435\u043d\u0435\u0434\u0436\u0435\u0440",selectedValue:t.selecedDevManagerId,disabled:t.insideEdit||!1})}),Object(X.jsx)(Le,{immovables:t.immovables,onChange:t.onImmovablesChange,onAdd:t.onAddImmovables,onRemove:t.onRemoveImmovable,disabled:t.insideEdit||!1}),Object(X.jsx)(Se,{clients:t.clients,onChange:t.onClientsChange,onAdd:t.onAddClients,onRemove:t.onRemoveClient,disabled:t.insideEdit||!1}),Object(X.jsxs)("div",{className:"mv12",children:[t.insideEdit&&Object(X.jsx)(Ee,{label:"\u0420\u0435\u0434\u0430\u0433\u0443\u0432\u0430\u0442\u0438",onClick:function(){return t.setEdit(!1)},disabled:!e.edit&&!t.activeAddButton,className:"schedulerForm__editButton"}),!t.insideEdit&&Object(X.jsx)(Ee,{label:"".concat(e.edit?"\u0417\u0431\u0435\u0440\u0435\u0433\u0442\u0438":"\u0421\u0442\u0432\u043e\u0440\u0438\u0442\u0438"),onClick:t.onFormCreate,disabled:!t.activeAddButton})]})]})})},Xe=Object(c.memo)(qe),Ye=function(){var e=function(){var e=Object(c.useState)(0),t=Object($.a)(e,2),n=t[0],a=t[1],r=Object(i.b)(),o=Object(i.c)((function(e){return e.scheduler.newSelectedAppointment})),s=Object(i.c)((function(e){return e.scheduler.oldSelectedAppointment})),l=Object(i.c)((function(e){return e.scheduler.editAppointmentData}));Object(c.useEffect)((function(){a(l?1:0)}),[l]),Object(c.useEffect)((function(){a(0)}),[o]);var u=Object(i.c)((function(e){return e.scheduler.modalInfo})),d=Object(c.useMemo)((function(){return Object(b.a)(Object(b.a)({},u),{},{handleClose:function(){return r(L(Object(b.a)(Object(b.a)({},u),{},{open:!1})))}})}),[u]);return{newSelectedAppointment:o,oldSelectedAppointment:s,editAppointmentData:l,modalProps:d,selectedTab:n,setSelectedTab:a}}();return Object(X.jsxs)("div",{className:"schedulerForm scheduler__form",children:[Object(X.jsxs)("div",{className:"schedulerForm__tabs",children:[Object(X.jsx)("div",{className:"item ".concat(0===e.selectedTab?"selected":""),onClick:function(){return e.setSelectedTab(0)},children:e.newSelectedAppointment?"".concat(e.newSelectedAppointment.day," ").concat(e.newSelectedAppointment.time," ").concat(e.newSelectedAppointment.date):"\u0412\u0438\u0431\u0435\u0440\u0456\u0442\u044c \u0434\u0430\u0442\u0443"}),e.oldSelectedAppointment&&e.editAppointmentData&&Object(X.jsx)("div",{className:"item ".concat(1===e.selectedTab?"selected":""),onClick:function(){return e.setSelectedTab(1)},children:"".concat(e.oldSelectedAppointment.day," ").concat(e.oldSelectedAppointment.time," ").concat(e.oldSelectedAppointment.date)})]}),0===e.selectedTab&&Object(X.jsx)(Xe,{selectedCard:e.newSelectedAppointment}),1===e.selectedTab&&e.editAppointmentData&&Object(X.jsx)(Xe,{selectedCard:e.oldSelectedAppointment,initialValues:e.editAppointmentData,edit:!0}),Object(X.jsx)(me,Object(b.a)({},e.modalProps))]})},Ze=function(){return Object(X.jsxs)("div",{className:"scheduler__container",children:[Object(X.jsxs)("div",{className:"scheduler__dataView",children:[Object(X.jsx)(de,{}),Object(X.jsx)(ue,{})]}),Object(X.jsx)(Ye,{})]})},$e=function(){return Object(X.jsx)(Ze,{})},et=function(){return function(){var e=Object(i.b)();Object(c.useEffect)((function(){O(e)}),[])}(),Object(X.jsx)($e,{})},tt=n(42),nt={token:null},ct=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:nt,t=arguments.length>1?arguments[1]:void 0;switch(t.type){case f:return Object(b.a)(Object(b.a)({},e),{},{token:t.payload});default:return e}},at={options:null,appointments:[],developersInfo:{},newSelectedAppointment:null,oldSelectedAppointment:null,editAppointmentData:null,modalInfo:{open:!1,success:!1,message:""},isLoading:!1},rt=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:at,t=arguments.length>1?arguments[1]:void 0;switch(t.type){case y:return Object(b.a)(Object(b.a)({},e),{},{options:t.payload});case g:return Object(b.a)(Object(b.a)({},e),{},{appointments:t.payload});case A:return Object(b.a)(Object(b.a)({},e),{},{appointments:[].concat(Object(Be.a)(e.appointments),[t.payload])});case E:return Object(b.a)(Object(b.a)({},e),{},{appointments:[].concat(Object(Be.a)(e.appointments.filter((function(e){return e.i!==t.payload.i}))),[t.payload])});case _:return Object(b.a)(Object(b.a)({},e),{},{developersInfo:t.payload});case w:return Object(b.a)(Object(b.a)({},e),{},{isLoading:t.payload});case C:return Object(b.a)(Object(b.a)({},e),{},{newSelectedAppointment:t.payload});case k:return Object(b.a)(Object(b.a)({},e),{},{oldSelectedAppointment:t.payload});case N:return Object(b.a)(Object(b.a)({},e),{},{editAppointmentData:t.payload});case S:return Object(b.a)(Object(b.a)({},e),{},{modalInfo:Object(b.a)({},t.payload)});default:return e}},ot=Object(tt.b)({token:ct,scheduler:rt}),it=Object(tt.c)(ot);o.a.render(Object(X.jsx)(a.a.StrictMode,{children:Object(X.jsx)(i.a,{store:it,children:Object(X.jsx)(et,{})})}),document.getElementById("root"))}},[[183,1,2]]]);
//# sourceMappingURL=main.d1c619a5.chunk.js.map