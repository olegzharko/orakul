(this.webpackJsonpfront=this.webpackJsonpfront||[]).push([[8],{119:function(e,t,n){"use strict";n.d(t,"a",(function(){return a}));n(0),n(125);var c=n(8),a=function(e){var t=e.label,n=e.onClick,a=e.disabled,s=e.className;return Object(c.jsx)("button",{className:"primary-button ".concat(a?"disabled":""," ").concat(s||""),onClick:n,disabled:a,children:t})}},125:function(e,t,n){},126:function(e,t,n){},127:function(e,t,n){"use strict";n.d(t,"a",(function(){return i}));var c=n(3),a=n(0),s=n(22),l=n(13),i=function(){var e=Object(s.b)(),t=Object(s.c)((function(e){return e.main})).modalInfo;return Object(a.useMemo)((function(){return Object(c.a)(Object(c.a)({},t),{},{handleClose:function(){return e(Object(l.d)(Object(c.a)(Object(c.a)({},t),{},{open:!1})))}})}),[t])}},128:function(e,t,n){"use strict";n.d(t,"a",(function(){return i}));n(0),n(126);var c=n(397),a=n(384),s=n(383),l=n(8),i=function(e){var t=e.open,n=e.handleClose,i=e.success,r=e.message;return Object(l.jsx)(c.a,{className:"modal-container",open:t,onClose:n,closeAfterTransition:!0,BackdropComponent:a.a,BackdropProps:{timeout:500},children:Object(l.jsx)(s.a,{in:t,children:Object(l.jsx)("div",{className:"modal ".concat(i?"modal-success":"modal-failed"),children:Object(l.jsx)("p",{className:"message",children:r})})})})}},138:function(e,t,n){},143:function(e,t,n){"use strict";n.d(t,"a",(function(){return d}));var c=n(0),a=(n(138),n(113)),s=n(22),l=n(13),i=n(15),r=function(e,t){var n=Object(c.useState)(e),s=Object(a.a)(n,2),l=s[0],i=s[1];return Object(c.useEffect)((function(){var n=setTimeout((function(){i(e)}),t);return function(){clearTimeout(n)}}),[e]),l},o=n(8),d=function(){var e=function(){var e=Object(s.b)(),t=Object(c.useState)(""),n=Object(a.a)(t,2),o=n[0],d=n[1],u=Object(c.useState)(0),b=Object(a.a)(u,2),j=b[0],m=b[1],f=r(o,1e3);return Object(c.useEffect)((function(){j?e(Object(i.f)(f)):m((function(e){return e+1}))}),[f]),{onSearch:Object(c.useCallback)((function(e){d(e.target.value)}),[o]),onLogout:Object(c.useCallback)((function(){localStorage.clear(),e(Object(l.e)({type:null,token:null}))}),[]),searchText:o}}(),t=e.onSearch,n=e.onLogout,d=e.searchText;return Object(o.jsxs)("div",{className:"header container",children:[Object(o.jsx)("div",{className:"header__logo",children:Object(o.jsx)("img",{src:"/icons/logo.svg",alt:"logo"})}),Object(o.jsxs)("div",{className:"header__search",children:[Object(o.jsx)("input",{type:"text",placeholder:"\u041f\u043e\u0448\u0443\u043a...",onChange:t,value:d}),Object(o.jsx)("img",{src:"/icons/search.svg",alt:"search"})]}),Object(o.jsx)("div",{className:"header__control",children:Object(o.jsx)("img",{src:"/icons/log-out.svg",alt:"logout",onClick:n})})]})}},146:function(e,t,n){"use strict";n.d(t,"a",(function(){return u}));var c=n(113),a=n(0),s=(n(178),n(406)),l=n(354),i=n(380),r=n(396),o=n(8),d=function(e){var t=e.onChange,n=e.data,d=e.label,u=e.selectedValue,b=e.disabled,j=e.size,m=void 0===j?"medium":j,f=Object(a.useState)(u||""),O=Object(c.a)(f,2),h=O[0],v=O[1];Object(a.useEffect)((function(){v(u||"")}),[u]);return Object(o.jsxs)(i.a,{variant:"outlined",className:"customSelect",size:m,children:[Object(o.jsx)(s.a,{children:d}),Object(o.jsxs)(r.a,{value:h,onChange:function(e){var n=e.target.value;v(n),t(n)},disabled:b||0===n.length,children:[Object(o.jsx)(l.a,{value:"",children:Object(o.jsx)("em",{children:"\u0412\u044b\u0431\u0440\u0430\u0442\u044c"})}),n.map((function(e){var t=e.id,n=e.title;return Object(o.jsx)(l.a,{value:t,children:n},t)}))]})]})},u=Object(a.memo)(d)},161:function(e,t,n){},162:function(e,t,n){},163:function(e,t,n){},164:function(e,t,n){},165:function(e,t,n){},177:function(e,t,n){},178:function(e,t,n){},184:function(e,t,n){"use strict";n.d(t,"a",(function(){return u}));var c,a=n(0),s=(n(163),n(164),n(38)),l=n(8),i=function(e){var t=e.title,n=e.headerColor,c=e.children,a=e.link,i=e.haveStatus;return console.log(i),Object(l.jsxs)(s.b,{to:a,className:"card",children:[Object(l.jsxs)("div",{className:"card__header",style:{backgroundColor:i?"":n||""},children:[Object(l.jsx)("span",{style:{color:i?"black":n?"white":""},children:t}),i&&Object(l.jsx)("div",{className:"status",style:{backgroundColor:n||""}})]}),Object(l.jsx)("div",{className:"card__main",children:c})]})},r=n(113);!function(e){e[e.CARDS=0]="CARDS",e[e.TABLE=1]="TABLE"}(c||(c={}));var o=function(e){var t=e.link,n=e.title,a=e.cards,s=e.style,r=e.haveStatus;return Object(l.jsxs)("div",{className:"dashboard__main-section",children:[Object(l.jsx)("h2",{children:n}),Object(l.jsx)("div",{className:"cards ".concat(s===c.TABLE?"table":""),children:a.map((function(e){return Object(l.jsx)(i,{haveStatus:r,title:e.title,headerColor:e.color,link:"/".concat(t,"/").concat(e.id),children:e.content.map((function(e){return Object(l.jsx)("span",{className:"card__content-item",children:e},e)}))},e.id)}))})]})},d=(n(165),function(e){var t=e.selected,n=e.onClick;return Object(l.jsxs)("div",{className:"dashboard__space-control",children:[Object(l.jsx)("svg",{className:"".concat(c.CARDS===t?"selected":""),onClick:function(){return n(c.CARDS)},width:"18",height:"18",viewBox:"0 0 18 18",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:Object(l.jsx)("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M1.50008 0.666748H7.33341C7.83341 0.666748 8.16675 1.00008 8.16675 1.50008V7.33341C8.16675 7.83341 7.83341 8.16675 7.33341 8.16675H1.50008C1.00008 8.16675 0.666748 7.83341 0.666748 7.33341V1.50008C0.666748 1.00008 1.00008 0.666748 1.50008 0.666748ZM2.33341 6.50008H6.50008V2.33341H2.33341V6.50008ZM16.5001 0.666748H10.6667C10.1667 0.666748 9.83342 1.00008 9.83342 1.50008V7.33341C9.83342 7.83341 10.1667 8.16675 10.6667 8.16675H16.5001C17.0001 8.16675 17.3334 7.83341 17.3334 7.33341V1.50008C17.3334 1.00008 17.0001 0.666748 16.5001 0.666748ZM11.5001 6.50008H15.6667V2.33341H11.5001V6.50008ZM16.5001 9.83342H10.6667C10.1667 9.83342 9.83342 10.1667 9.83342 10.6667V16.5001C9.83342 17.0001 10.1667 17.3334 10.6667 17.3334H16.5001C17.0001 17.3334 17.3334 17.0001 17.3334 16.5001V10.6667C17.3334 10.1667 17.0001 9.83342 16.5001 9.83342ZM11.5001 15.6667H15.6667V11.5001H11.5001V15.6667ZM7.33341 9.83342H1.50008C1.00008 9.83342 0.666748 10.1667 0.666748 10.6667V16.5001C0.666748 17.0001 1.00008 17.3334 1.50008 17.3334H7.33341C7.83341 17.3334 8.16675 17.0001 8.16675 16.5001V10.6667C8.16675 10.1667 7.83341 9.83342 7.33341 9.83342ZM2.33341 15.6667H6.50008V11.5001H2.33341V15.6667Z",fill:"#165153"})}),Object(l.jsx)("svg",{className:"".concat(c.TABLE===t?"selected":""),onClick:function(){return n(c.TABLE)},width:"20",height:"20",viewBox:"0 0 20 20",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:Object(l.jsx)("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M3.33325 0.833252H16.6666C18.0833 0.833252 19.1666 1.91659 19.1666 3.33325V6.66659C19.1666 8.08325 18.0833 9.16658 16.6666 9.16658H3.33325C1.91659 9.16658 0.833252 8.08325 0.833252 6.66659V3.33325C0.833252 1.91659 1.91659 0.833252 3.33325 0.833252ZM16.6666 7.49992C17.1666 7.49992 17.4999 7.16658 17.4999 6.66658V3.33325C17.4999 2.83325 17.1666 2.49992 16.6666 2.49992H3.33325C2.83325 2.49992 2.49992 2.83325 2.49992 3.33325V6.66658C2.49992 7.16658 2.83325 7.49992 3.33325 7.49992H16.6666ZM16.6666 10.8333H3.33325C1.91659 10.8333 0.833252 11.9166 0.833252 13.3333V16.6666C0.833252 18.0833 1.91659 19.1666 3.33325 19.1666H16.6666C18.0833 19.1666 19.1666 18.0833 19.1666 16.6666V13.3333C19.1666 11.9166 18.0833 10.8333 16.6666 10.8333ZM16.6666 17.4999C17.1666 17.4999 17.4999 17.1666 17.4999 16.6666V13.3333C17.4999 12.8333 17.1666 12.4999 16.6666 12.4999H3.33325C2.83325 12.4999 2.49992 12.8333 2.49992 13.3333V16.6666C2.49992 17.1666 2.83325 17.4999 3.33325 17.4999H16.6666ZM5.58325 4.41659C5.74992 4.58325 5.83325 4.74992 5.83325 4.99992C5.83325 5.24992 5.74992 5.41659 5.58325 5.58325C5.41658 5.74992 5.24992 5.83325 4.99992 5.83325C4.74992 5.83325 4.58325 5.74992 4.41659 5.58325C4.33325 5.49992 4.24992 5.41659 4.24992 5.33325C4.16659 5.24992 4.16659 5.08325 4.16659 4.99992C4.16659 4.91659 4.16659 4.74992 4.24992 4.66659C4.29159 4.62492 4.31242 4.58325 4.33325 4.54159C4.35409 4.49992 4.37492 4.45825 4.41659 4.41659C4.49992 4.33325 4.58325 4.24992 4.66659 4.24992C4.91658 4.16659 5.08325 4.16659 5.33325 4.24992C5.41658 4.24992 5.49992 4.33325 5.58325 4.41659ZM5.83325 14.9999C5.83325 14.7499 5.74992 14.5833 5.58325 14.4166C5.24992 14.0833 4.74992 14.0833 4.41659 14.4166C4.37492 14.4583 4.35409 14.4999 4.33325 14.5416C4.31242 14.5833 4.29159 14.6249 4.24992 14.6666C4.16659 14.7499 4.16659 14.9166 4.16659 14.9999C4.16659 15.2499 4.24992 15.4166 4.41659 15.5833C4.58325 15.7499 4.74992 15.8333 4.99992 15.8333C5.24992 15.8333 5.41658 15.7499 5.58325 15.5833C5.74992 15.4166 5.83325 15.2499 5.83325 14.9999Z",fill:"#C0C1C1"})})]})}),u=function(e){var t=function(e){var t=e.style,n=Object(a.useState)(t||c.CARDS),s=Object(r.a)(n,2);return{selectedType:s[0],setSelectedType:s[1]}}(e),n=t.selectedType,s=t.setSelectedType;return Object(l.jsxs)("div",{className:"dashboard",children:[e.isChangeTypeButton&&Object(l.jsx)(d,{selected:n,onClick:s}),e.sections&&Object(l.jsx)("div",{className:"dashboard__main",children:e.sections.map((function(t){return Object(l.jsx)(o,{link:e.link,title:t.title,style:n,cards:t.cards,haveStatus:e.haveStatus})}))})]})}},185:function(e,t,n){"use strict";n.d(t,"a",(function(){return d}));var c=n(0),a=(n(177),n(146)),s=n(113),l=n(22),i=n(42),r=n(41),o=n(8),d=function(e){var t=function(e){var t=e.onFilterDataChange,n=e.horizontal,a=Object(l.b)(),o=Object(l.c)((function(e){return e.main.user})).token,d=Object(l.c)((function(e){return e.filter})).filterInitialData;Object(c.useEffect)((function(){a(Object(i.b)())}),[o]);var u=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.reader}),[d]),b=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.notary}),[d]),j=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.accompanying}),[d]),m=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.contract_type}),[d]),f=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.developer}),[d]),O=Object(c.useMemo)((function(){return null===d||void 0===d?void 0:d.sort_type}),[d]),h=Object(c.useState)([]),v=Object(s.a)(h,2),p=v[0],C=v[1],x=Object(c.useMemo)((function(){return Boolean(d)}),[d]),g=Object(c.useState)(null),y=Object(s.a)(g,2),N=y[0],S=y[1],_=Object(c.useState)(null),k=Object(s.a)(_,2),V=k[0],w=k[1],z=Object(c.useState)(null),T=Object(s.a)(z,2),H=T[0],M=T[1],A=Object(c.useState)(null),R=Object(s.a)(A,2),E=R[0],D=R[1],I=Object(c.useState)(null),B=Object(s.a)(I,2),Z=B[0],F=B[1],L=Object(c.useState)(null),q=Object(s.a)(L,2),P=q[0],G=q[1],$=Object(c.useState)(null),J=Object(s.a)($,2),K=J[0],Q=J[1],U=Object(c.useCallback)((function(){S(null),w(null),M(null),D(null),F(null),G(null),Q(null)}),[]);return Object(c.useEffect)((function(){G(null),o&&Z&&Object(r.a)(o,+Z).then((function(e){return C(e.representative||[])}))}),[Z]),Object(c.useEffect)((function(){var e={notary_id:N||null,reader_id:V||null,accompanying_id:H||null,contract_type_id:E||null,developer_id:Z||null,dev_representative_id:P||null};n||(e.sort_type=K),t(e)}),[N,V,H,E,Z,P,K]),{shouldRenderFilter:x,notaries:b,readers:u,accompanyings:j,contractTypes:m,developers:f,representative:p,sortType:O,selectedNotary:N,selectedReader:V,selectedRepresentative:P,selectedDeveloper:Z,selectedContractType:E,selectedAccompanying:H,selectedSortType:K,setSelectedNotary:S,setSelectedReader:w,setSelectedAccompanying:M,setSelectedContractType:D,setSelectedDeveloper:F,setSelectedRepresentative:G,setSelectedSortType:Q,clearAll:U}}(e);return t.shouldRenderFilter?Object(o.jsxs)("div",{className:"filter ".concat(e.horizontal?"horizontal":""),children:[Object(o.jsxs)("div",{className:"filter__header",children:[Object(o.jsx)("span",{style:{whiteSpace:"nowrap"},className:"".concat(e.horizontal?"":"title"),children:e.horizontal?"\u0421\u043e\u0440\u0442\u0443\u0432\u0430\u0442\u0438 \u043f\u043e:":"\u0424\u0456\u043b\u044c\u0442\u0440"}),!e.horizontal&&Object(o.jsx)("img",{src:"/icons/clear-form.svg",alt:"clear form",onClick:t.clearAll,className:"filter__clear"})]}),Object(o.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"115px":"100%"},children:Object(o.jsx)(a.a,{data:t.notaries,selectedValue:t.selectedNotary,onChange:t.setSelectedNotary,label:"\u041d\u043e\u0442\u0430\u0440\u0456\u0443\u0441",size:e.horizontal?"small":"medium"})}),Object(o.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"90px":"100%"},children:Object(o.jsx)(a.a,{data:t.readers,selectedValue:t.selectedReader,onChange:t.setSelectedReader,label:"\u0427\u0438\u0442\u0430\u0447",size:e.horizontal?"small":"medium"})}),Object(o.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"110px":"100%"},children:Object(o.jsx)(a.a,{data:t.accompanyings,selectedValue:t.selectedAccompanying,onChange:t.setSelectedAccompanying,label:"\u0412\u0438\u0434\u0430\u0432\u0430\u0447",size:e.horizontal?"small":"medium"})}),Object(o.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"150px":"100%"},children:Object(o.jsx)(a.a,{data:t.contractTypes,selectedValue:t.selectedContractType,onChange:t.setSelectedContractType,label:"\u0422\u0438\u043f \u0434\u043e\u0433\u043e\u0432\u043e\u0440\u0443",size:e.horizontal?"small":"medium"})}),Object(o.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"140px":"100%"},children:Object(o.jsx)(a.a,{data:t.developers,selectedValue:t.selectedDeveloper,onChange:t.setSelectedDeveloper,label:"\u0417\u0430\u0431\u0443\u0434\u043e\u0432\u043d\u0438\u043a",size:e.horizontal?"small":"medium"})}),Object(o.jsx)("div",{className:"filter__select",style:{width:e.horizontal?"125px":"100%"},children:Object(o.jsx)(a.a,{data:t.representative,selectedValue:t.selectedRepresentative,onChange:t.setSelectedRepresentative,label:"\u041f\u0456\u0434\u043f\u0438\u0441\u0430\u043d\u0442",size:e.horizontal?"small":"medium"})}),!e.horizontal&&Object(o.jsx)("div",{className:"filter__select",children:Object(o.jsx)(a.a,{data:t.sortType,selectedValue:t.selectedSortType,onChange:t.setSelectedSortType,label:"\u0421\u043e\u0440\u0442\u0443\u0432\u0430\u0442\u0438",size:"medium"})}),e.horizontal&&Object(o.jsx)("div",{className:" df",children:Object(o.jsx)("img",{src:"/icons/clear-form.svg",alt:"clear form",onClick:t.clearAll,className:"filter__clear"})})]}):null}},186:function(e,t,n){"use strict";n.d(t,"a",(function(){return a}));n(0),n(162);var c=n(8),a=function(e){var t=e.children;return Object(c.jsx)("div",{className:"contentPanel",children:t})}},187:function(e,t,n){"use strict";n.d(t,"a",(function(){return a}));n(0),n(161);var c=n(8),a=function(e){var t=e.children;return Object(c.jsx)("div",{className:"controlPanel",children:t})}},305:function(e,t,n){},306:function(e,t,n){},354:function(e,t,n){"use strict";var c=n(107),a=n(117),s=n(16),l=n(0),i=(n(37),n(109)),r=n(111),o=n(399),d=n(171),u=n(116),b=n(173),j=n(26),m="undefined"===typeof window?l.useEffect:l.useLayoutEffect,f=l.forwardRef((function(e,t){var n=e.alignItems,a=void 0===n?"center":n,r=e.autoFocus,f=void 0!==r&&r,O=e.button,h=void 0!==O&&O,v=e.children,p=e.classes,C=e.className,x=e.component,g=e.ContainerComponent,y=void 0===g?"li":g,N=e.ContainerProps,S=(N=void 0===N?{}:N).className,_=Object(c.a)(N,["className"]),k=e.dense,V=void 0!==k&&k,w=e.disabled,z=void 0!==w&&w,T=e.disableGutters,H=void 0!==T&&T,M=e.divider,A=void 0!==M&&M,R=e.focusVisibleClassName,E=e.selected,D=void 0!==E&&E,I=Object(c.a)(e,["alignItems","autoFocus","button","children","classes","className","component","ContainerComponent","ContainerProps","dense","disabled","disableGutters","divider","focusVisibleClassName","selected"]),B=l.useContext(b.a),Z={dense:V||B.dense||!1,alignItems:a},F=l.useRef(null);m((function(){f&&F.current&&F.current.focus()}),[f]);var L=l.Children.toArray(v),q=L.length&&Object(d.a)(L[L.length-1],["ListItemSecondaryAction"]),P=l.useCallback((function(e){F.current=j.findDOMNode(e)}),[]),G=Object(u.a)(P,t),$=Object(s.a)({className:Object(i.a)(p.root,C,Z.dense&&p.dense,!H&&p.gutters,A&&p.divider,z&&p.disabled,h&&p.button,"center"!==a&&p.alignItemsFlexStart,q&&p.secondaryAction,D&&p.selected),disabled:z},I),J=x||"li";return h&&($.component=x||"div",$.focusVisibleClassName=Object(i.a)(p.focusVisible,R),J=o.a),q?(J=$.component||x?J:"div","li"===y&&("li"===J?J="div":"li"===$.component&&($.component="div")),l.createElement(b.a.Provider,{value:Z},l.createElement(y,Object(s.a)({className:Object(i.a)(p.container,S),ref:G},_),l.createElement(J,$,L),L.pop()))):l.createElement(b.a.Provider,{value:Z},l.createElement(J,Object(s.a)({ref:G},$),L))})),O=Object(r.a)((function(e){return{root:{display:"flex",justifyContent:"flex-start",alignItems:"center",position:"relative",textDecoration:"none",width:"100%",boxSizing:"border-box",textAlign:"left",paddingTop:8,paddingBottom:8,"&$focusVisible":{backgroundColor:e.palette.action.selected},"&$selected, &$selected:hover":{backgroundColor:e.palette.action.selected},"&$disabled":{opacity:.5}},container:{position:"relative"},focusVisible:{},dense:{paddingTop:4,paddingBottom:4},alignItemsFlexStart:{alignItems:"flex-start"},disabled:{},divider:{borderBottom:"1px solid ".concat(e.palette.divider),backgroundClip:"padding-box"},gutters:{paddingLeft:16,paddingRight:16},button:{transition:e.transitions.create("background-color",{duration:e.transitions.duration.shortest}),"&:hover":{textDecoration:"none",backgroundColor:e.palette.action.hover,"@media (hover: none)":{backgroundColor:"transparent"}}},secondaryAction:{paddingRight:48},selected:{}}}),{name:"MuiListItem"})(f),h=l.forwardRef((function(e,t){var n,a=e.classes,r=e.className,o=e.component,d=void 0===o?"li":o,u=e.disableGutters,b=void 0!==u&&u,j=e.ListItemClasses,m=e.role,f=void 0===m?"menuitem":m,h=e.selected,v=e.tabIndex,p=Object(c.a)(e,["classes","className","component","disableGutters","ListItemClasses","role","selected","tabIndex"]);return e.disabled||(n=void 0!==v?v:-1),l.createElement(O,Object(s.a)({button:!0,role:f,tabIndex:n,component:d,selected:h,disableGutters:b,classes:Object(s.a)({dense:a.dense},j),className:Object(i.a)(a.root,r,h&&a.selected,!b&&a.gutters),ref:t},p))}));t.a=Object(r.a)((function(e){return{root:Object(s.a)({},e.typography.body1,Object(a.a)({minHeight:48,paddingTop:6,paddingBottom:6,boxSizing:"border-box",width:"auto",overflow:"hidden",whiteSpace:"nowrap"},e.breakpoints.up("sm"),{minHeight:"auto"})),gutters:{},selected:{},dense:Object(s.a)({},e.typography.body2,{minHeight:"auto"})}}),{name:"MuiMenuItem"})(h)},395:function(e,t,n){"use strict";n.r(t),n.d(t,"default",(function(){return g}));var c=n(0),a=(n(305),n(9)),s=n(143),l=n(3),i=n(187),r=n(185),o=n(119),d=(n(306),n(8)),u=[{key:0,title:"\u0423\u0441\u0456",quantity:50},{key:1,title:"\u0413\u043e\u0442\u043e\u0432\u0456",quantity:10},{key:2,title:"\u041e\u0441\u043d\u043e\u0432\u043d\u0438\u0445",quantity:30},{key:3,title:"\u041f\u043e\u043f\u0435\u0440\u0435\u0434\u043d\u0456\u0445",quantity:4},{key:4,title:"\u0421\u043a\u0430\u0441\u043e\u0432\u0430\u043d\u043e",quantity:2}],b=function(){return Object(d.jsxs)("div",{className:"dashboard__filter-contracts",children:[Object(d.jsx)("span",{className:"title",children:"\u0414\u043e\u0433\u043e\u0432\u043e\u0440\u0438"}),Object(d.jsx)("div",{className:"cards",children:u.map((function(e){return Object(d.jsxs)("div",{className:"item",children:[Object(d.jsxs)("div",{className:"item__left",children:[Object(d.jsx)("img",{src:"/icons/contract.svg",alt:"contract"}),Object(d.jsx)("span",{className:"name",children:e.title})]}),Object(d.jsx)("span",{className:"quantity",children:e.quantity})]},e.key)}))})]})},j=n(113),m=n(22),f=n(15),O=function(){var e=function(){var e=Object(m.b)(),t=Object(c.useState)(),n=Object(j.a)(t,2),a=n[0],s=n[1];return{onFilterDataChange:Object(c.useCallback)((function(e){s(e)}),[]),onFilterSubmit:Object(c.useCallback)((function(){a&&e(Object(f.e)(a))}),[a])}}(),t=e.onFilterDataChange,n=e.onFilterSubmit;return Object(d.jsx)(i.a,{children:Object(d.jsxs)("div",{className:"dashboard__filter",children:[Object(d.jsx)(b,{}),Object(d.jsx)(r.a,{onFilterDataChange:t}),Object(d.jsx)("div",{className:"mv12",children:Object(d.jsx)(o.a,{label:"\u0417\u0430\u0441\u0442\u043e\u0441\u0443\u0432\u0430\u0442\u0438",onClick:n,disabled:!1})})]})})},h=n(127),v=n(128),p=n(184),C=n(186),x=function(){var e=Object(h.a)(),t=function(){var e=Object(m.b)(),t=Object(m.c)((function(e){return e.appointments})).appointments;return Object(c.useEffect)((function(){return e(Object(f.d)()),function(){e(Object(f.g)([]))}}),[]),{formatAppointments:Object(c.useMemo)((function(){return t.map((function(e){return{title:"".concat(e.day," ").concat(e.date),cards:e.cards.map((function(e){return{id:e.id,title:e.title,content:e.instructions,color:e.color}}))}}))}),[t])}}().formatAppointments;return Object(d.jsxs)("div",{className:"dashboard-screen",children:[Object(d.jsx)(O,{}),Object(d.jsx)(C.a,{children:Object(d.jsx)(p.a,{link:"contracts",sections:t,isChangeTypeButton:!0})}),Object(d.jsx)(v.a,Object(l.a)({},e))]})},g=function(){return Object(d.jsxs)(d.Fragment,{children:[Object(d.jsx)(s.a,{}),Object(d.jsxs)(a.c,{children:[Object(d.jsx)(a.a,{path:"/contracts/:id",children:Object(d.jsx)("h1",{children:"Here"})}),Object(d.jsx)(a.a,{path:"/",children:Object(d.jsx)(x,{})})]})]})}}}]);
//# sourceMappingURL=8.9652b892.chunk.js.map