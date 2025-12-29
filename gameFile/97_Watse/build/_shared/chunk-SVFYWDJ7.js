import{c as F}from"/build/_shared/chunk-HFQ3JK4Y.js";import{b as N,n as A}from"/build/_shared/chunk-NHO5U3KD.js";import{d as x}from"/build/_shared/chunk-G5WX4PPA.js";var I=x(N(),1),C=x(N(),1),E=x(N(),1);var se={data:""},oe=e=>typeof window=="object"?((e?e.querySelector("#_goober"):window._goober)||Object.assign((e||document.head).appendChild(document.createElement("style")),{innerHTML:" ",id:"_goober"})).firstChild:e||se;var ne=/(?:([\u0080-\uFFFF\w-%@]+) *:? *([^{;]+?);|([^;}{]*?) *{)|(}\s*)/g,ie=/\/\*[^]*?\*\/|  +/g,Y=/\n+/g,b=(e,t)=>{let r="",s="",i="";for(let a in e){let n=e[a];a[0]=="@"?a[1]=="i"?r=a+" "+n+";":s+=a[1]=="f"?b(n,a):a+"{"+b(n,a[1]=="k"?"":t)+"}":typeof n=="object"?s+=b(n,t?t.replace(/([^,])+/g,o=>a.replace(/([^,]*:\S+\([^)]*\))|([^,])+/g,u=>/&/.test(u)?u.replace(/&/g,o):o?o+" "+u:u)):a):n!=null&&(a=/^--/.test(a)?a:a.replace(/[A-Z]/g,"-$&").toLowerCase(),i+=b.p?b.p(a,n):a+":"+n+";")}return r+(t&&i?t+"{"+i+"}":i)+s},h={},K=e=>{if(typeof e=="object"){let t="";for(let r in e)t+=r+K(e[r]);return t}return e},ue=(e,t,r,s,i)=>{let a=K(e),n=h[a]||(h[a]=(u=>{let l=0,c=11;for(;l<u.length;)c=101*c+u.charCodeAt(l++)>>>0;return"go"+c})(a));if(!h[n]){let u=a!==e?e:(l=>{let c,v,g=[{}];for(;c=ne.exec(l.replace(ie,""));)c[4]?g.shift():c[3]?(v=c[3].replace(Y," ").trim(),g.unshift(g[0][v]=g[0][v]||{})):g[0][c[1]]=c[2].replace(Y," ").trim();return g[0]})(e);h[n]=b(i?{["@keyframes "+n]:u}:u,r?"":"."+n)}let o=r&&h.g?h.g:null;return r&&(h.g=h[n]),((u,l,c,v)=>{v?l.data=l.data.replace(v,u):l.data.indexOf(u)===-1&&(l.data=c?u+l.data:l.data+u)})(h[n],t,s,o),n},le=(e,t,r)=>e.reduce((s,i,a)=>{let n=t[a];if(n&&n.call){let o=n(r),u=o&&o.props&&o.props.className||/^go/.test(o)&&o;n=u?"."+u:o&&typeof o=="object"?o.props?"":b(o,""):o===!1?"":o}return s+i+(n??"")},"");function S(e){let t=this||{},r=e.call?e(t.p):e;return ue(r.unshift?r.raw?le(r,[].slice.call(arguments,1),t.p):r.reduce((s,i)=>Object.assign(s,i&&i.call?i(t.p):i),{}):r,oe(t.target),t.g,t.o,t.k)}var V,z,M,Qe=S.bind({g:1}),f=S.bind({k:1});function J(e,t,r,s){b.p=t,V=e,z=r,M=s}function y(e,t){let r=this||{};return function(){let s=arguments;function i(a,n){let o=Object.assign({},a),u=o.className||i.className;r.p=Object.assign({theme:z&&z()},o),r.o=/ *go\d+/.test(u),o.className=S.apply(r,s)+(u?" "+u:""),t&&(o.ref=n);let l=e;return e[0]&&(l=o.as||e,delete o.as),M&&l[0]&&M(o),V(l,o)}return t?t(i):i}}var U=x(N(),1);var w=x(N(),1),de=e=>typeof e=="function",G=(e,t)=>de(e)?e(t):e,ce=(()=>{let e=0;return()=>(++e).toString()})(),_=(()=>{let e;return()=>{if(e===void 0&&typeof window<"u"){let t=matchMedia("(prefers-reduced-motion: reduce)");e=!t||t.matches}return e}})(),pe=20,Z=(e,t)=>{switch(t.type){case 0:return{...e,toasts:[t.toast,...e.toasts].slice(0,pe)};case 1:return{...e,toasts:e.toasts.map(a=>a.id===t.toast.id?{...a,...t.toast}:a)};case 2:let{toast:r}=t;return Z(e,{type:e.toasts.find(a=>a.id===r.id)?1:0,toast:r});case 3:let{toastId:s}=t;return{...e,toasts:e.toasts.map(a=>a.id===s||s===void 0?{...a,dismissed:!0,visible:!1}:a)};case 4:return t.toastId===void 0?{...e,toasts:[]}:{...e,toasts:e.toasts.filter(a=>a.id!==t.toastId)};case 5:return{...e,pausedAt:t.time};case 6:let i=t.time-(e.pausedAt||0);return{...e,pausedAt:void 0,toasts:e.toasts.map(a=>({...a,pauseDuration:a.pauseDuration+i}))}}},$=[],B={toasts:[],pausedAt:void 0},k=e=>{B=Z(B,e),$.forEach(t=>{t(B)})},me={blank:4e3,error:4e3,success:2e3,loading:1/0,custom:4e3},fe=(e={})=>{let[t,r]=(0,I.useState)(B),s=(0,I.useRef)(B);(0,I.useEffect)(()=>(s.current!==B&&r(B),$.push(r),()=>{let a=$.indexOf(r);a>-1&&$.splice(a,1)}),[]);let i=t.toasts.map(a=>{var n,o,u;return{...e,...e[a.type],...a,removeDelay:a.removeDelay||((n=e[a.type])==null?void 0:n.removeDelay)||e?.removeDelay,duration:a.duration||((o=e[a.type])==null?void 0:o.duration)||e?.duration||me[a.type],style:{...e.style,...(u=e[a.type])==null?void 0:u.style,...a.style}}});return{...t,toasts:i}},ge=(e,t="blank",r)=>({createdAt:Date.now(),visible:!0,dismissed:!1,type:t,ariaProps:{role:"status","aria-live":"polite"},message:e,pauseDuration:0,...r,id:r?.id||ce()}),T=e=>(t,r)=>{let s=ge(t,e,r);return k({type:2,toast:s}),s.id},m=(e,t)=>T("blank")(e,t);m.error=T("error");m.success=T("success");m.loading=T("loading");m.custom=T("custom");m.dismiss=e=>{k({type:3,toastId:e})};m.remove=e=>k({type:4,toastId:e});m.promise=(e,t,r)=>{let s=m.loading(t.loading,{...r,...r?.loading});return typeof e=="function"&&(e=e()),e.then(i=>{let a=t.success?G(t.success,i):void 0;return a?m.success(a,{id:s,...r,...r?.success}):m.dismiss(s),i}).catch(i=>{let a=t.error?G(t.error,i):void 0;a?m.error(a,{id:s,...r,...r?.error}):m.dismiss(s)}),e};var ye=(e,t)=>{k({type:1,toast:{id:e,height:t}})},ve=()=>{k({type:5,time:Date.now()})},D=new Map,xe=1e3,he=(e,t=xe)=>{if(D.has(e))return;let r=setTimeout(()=>{D.delete(e),k({type:4,toastId:e})},t);D.set(e,r)},Ee=e=>{let{toasts:t,pausedAt:r}=fe(e);(0,C.useEffect)(()=>{if(r)return;let a=Date.now(),n=t.map(o=>{if(o.duration===1/0)return;let u=(o.duration||0)+o.pauseDuration-(a-o.createdAt);if(u<0){o.visible&&m.dismiss(o.id);return}return setTimeout(()=>m.dismiss(o.id),u)});return()=>{n.forEach(o=>o&&clearTimeout(o))}},[t,r]);let s=(0,C.useCallback)(()=>{r&&k({type:6,time:Date.now()})},[r]),i=(0,C.useCallback)((a,n)=>{let{reverseOrder:o=!1,gutter:u=8,defaultPosition:l}=n||{},c=t.filter(p=>(p.position||l)===(a.position||l)&&p.height),v=c.findIndex(p=>p.id===a.id),g=c.filter((p,d)=>d<v&&p.visible).length;return c.filter(p=>p.visible).slice(...o?[g+1]:[0,g]).reduce((p,d)=>p+(d.height||0)+u,0)},[t]);return(0,C.useEffect)(()=>{t.forEach(a=>{if(a.dismissed)he(a.id,a.removeDelay);else{let n=D.get(a.id);n&&(clearTimeout(n),D.delete(a.id))}})},[t]),{toasts:t,handlers:{updateHeight:ye,startPause:ve,endPause:s,calculateOffset:i}}},be=f`
from {
  transform: scale(0) rotate(45deg);
	opacity: 0;
}
to {
 transform: scale(1) rotate(45deg);
  opacity: 1;
}`,we=f`
from {
  transform: scale(0);
  opacity: 0;
}
to {
  transform: scale(1);
  opacity: 1;
}`,Le=f`
from {
  transform: scale(0) rotate(90deg);
	opacity: 0;
}
to {
  transform: scale(1) rotate(90deg);
	opacity: 1;
}`,Ue=y("div")`
  width: 20px;
  opacity: 0;
  height: 20px;
  border-radius: 10px;
  background: ${e=>e.primary||"#ff4b4b"};
  position: relative;
  transform: rotate(45deg);

  animation: ${be} 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275)
    forwards;
  animation-delay: 100ms;

  &:after,
  &:before {
    content: '';
    animation: ${we} 0.15s ease-out forwards;
    animation-delay: 150ms;
    position: absolute;
    border-radius: 3px;
    opacity: 0;
    background: ${e=>e.secondary||"#fff"};
    bottom: 9px;
    left: 4px;
    height: 2px;
    width: 12px;
  }

  &:before {
    animation: ${Le} 0.15s ease-out forwards;
    animation-delay: 180ms;
    transform: rotate(90deg);
  }
`,Be=f`
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
`,ke=y("div")`
  width: 12px;
  height: 12px;
  box-sizing: border-box;
  border: 2px solid;
  border-radius: 100%;
  border-color: ${e=>e.secondary||"#e0e0e0"};
  border-right-color: ${e=>e.primary||"#616161"};
  animation: ${Be} 1s linear infinite;
`,Re=f`
from {
  transform: scale(0) rotate(45deg);
	opacity: 0;
}
to {
  transform: scale(1) rotate(45deg);
	opacity: 1;
}`,Ne=f`
0% {
	height: 0;
	width: 0;
	opacity: 0;
}
40% {
  height: 0;
	width: 6px;
	opacity: 1;
}
100% {
  opacity: 1;
  height: 10px;
}`,Ce=y("div")`
  width: 20px;
  opacity: 0;
  height: 20px;
  border-radius: 10px;
  background: ${e=>e.primary||"#61d345"};
  position: relative;
  transform: rotate(45deg);

  animation: ${Re} 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275)
    forwards;
  animation-delay: 100ms;
  &:after {
    content: '';
    box-sizing: border-box;
    animation: ${Ne} 0.2s ease-out forwards;
    opacity: 0;
    animation-delay: 200ms;
    position: absolute;
    border-right: 2px solid;
    border-bottom: 2px solid;
    border-color: ${e=>e.secondary||"#fff"};
    bottom: 6px;
    left: 6px;
    height: 10px;
    width: 6px;
  }
`,Ie=y("div")`
  position: absolute;
`,Se=y("div")`
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  min-width: 20px;
  min-height: 20px;
`,De=f`
from {
  transform: scale(0.6);
  opacity: 0.4;
}
to {
  transform: scale(1);
  opacity: 1;
}`,Te=y("div")`
  position: relative;
  transform: scale(0.6);
  opacity: 0.4;
  min-width: 20px;
  animation: ${De} 0.3s 0.12s cubic-bezier(0.175, 0.885, 0.32, 1.275)
    forwards;
`,Oe=({toast:e})=>{let{icon:t,type:r,iconTheme:s}=e;return t!==void 0?typeof t=="string"?U.createElement(Te,null,t):t:r==="blank"?null:U.createElement(Se,null,U.createElement(ke,{...s}),r!=="loading"&&U.createElement(Ie,null,r==="error"?U.createElement(Ue,{...s}):U.createElement(Ce,{...s})))},Ae=e=>`
0% {transform: translate3d(0,${e*-200}%,0) scale(.6); opacity:.5;}
100% {transform: translate3d(0,0,0) scale(1); opacity:1;}
`,Pe=e=>`
0% {transform: translate3d(0,0,-1px) scale(1); opacity:1;}
100% {transform: translate3d(0,${e*-150}%,-1px) scale(.6); opacity:0;}
`,$e="0%{opacity:0;} 100%{opacity:1;}",Ge="0%{opacity:1;} 100%{opacity:0;}",je=y("div")`
  display: flex;
  align-items: center;
  background: #fff;
  color: #363636;
  line-height: 1.3;
  will-change: transform;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1), 0 3px 3px rgba(0, 0, 0, 0.05);
  max-width: 350px;
  pointer-events: auto;
  padding: 8px 10px;
  border-radius: 8px;
`,We=y("div")`
  display: flex;
  justify-content: center;
  margin: 4px 10px;
  color: inherit;
  flex: 1 1 auto;
  white-space: pre-line;
`,Fe=(e,t)=>{let r=e.includes("top")?1:-1,[s,i]=_()?[$e,Ge]:[Ae(r),Pe(r)];return{animation:t?`${f(s)} 0.35s cubic-bezier(.21,1.02,.73,1) forwards`:`${f(i)} 0.4s forwards cubic-bezier(.06,.71,.55,1)`}},ze=E.memo(({toast:e,position:t,style:r,children:s})=>{let i=e.height?Fe(e.position||t||"top-center",e.visible):{opacity:0},a=E.createElement(Oe,{toast:e}),n=E.createElement(We,{...e.ariaProps},G(e.message,e));return E.createElement(je,{className:e.className,style:{...i,...r,...e.style}},typeof s=="function"?s({icon:a,message:n}):E.createElement(E.Fragment,null,a,n))});J(w.createElement);var Me=({id:e,className:t,style:r,onHeightUpdate:s,children:i})=>{let a=w.useCallback(n=>{if(n){let o=()=>{let u=n.getBoundingClientRect().height;s(e,u)};o(),new MutationObserver(o).observe(n,{subtree:!0,childList:!0,characterData:!0})}},[e,s]);return w.createElement("div",{ref:a,className:t,style:r},i)},He=(e,t)=>{let r=e.includes("top"),s=r?{top:0}:{bottom:0},i=e.includes("center")?{justifyContent:"center"}:e.includes("right")?{justifyContent:"flex-end"}:{};return{left:0,right:0,display:"flex",position:"absolute",transition:_()?void 0:"all 230ms cubic-bezier(.21,1.02,.73,1)",transform:`translateY(${t*(r?1:-1)}px)`,...s,...i}},Ye=S`
  z-index: 9999;
  > * {
    pointer-events: auto;
  }
`,P=16,ot=({reverseOrder:e,position:t="top-center",toastOptions:r,gutter:s,children:i,containerStyle:a,containerClassName:n})=>{let{toasts:o,handlers:u}=Ee(r);return w.createElement("div",{id:"_rht_toaster",style:{position:"fixed",zIndex:9999,top:P,left:P,right:P,bottom:P,pointerEvents:"none",...a},className:n,onMouseEnter:u.startPause,onMouseLeave:u.endPause},o.map(l=>{let c=l.position||t,v=u.calculateOffset(l,{reverseOrder:e,gutter:s,defaultPosition:t}),g=He(c,v);return w.createElement(Me,{id:l.id,key:l.id,onHeightUpdate:u.updateHeight,className:l.visible?Ye:"",style:g},l.type==="custom"?G(l.message,l):i?i(l):w.createElement(ze,{toast:l,position:c}))}))},Q=m;var W=x(N());var X=[[{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0}],[{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0}],[{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0}],[{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0}],[{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0}],[{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0},{value:"",status:"BLUE",index:0}]];var ut=[["Q","W","E","R","T","Y","U","I","O","P"],["A","S","D","F","G","H","J","K","L"],["Z","X","C","V","B","N","M"],["\xAB","STUUR"]],q={Q:"BLUE",W:"BLUE",E:"BLUE",R:"BLUE",T:"BLUE",Y:"BLUE",U:"BLUE",I:"BLUE",O:"BLUE",P:"BLUE",A:"BLUE",S:"BLUE",D:"BLUE",F:"BLUE",G:"BLUE",H:"BLUE",J:"BLUE",K:"BLUE",L:"BLUE",Z:"BLUE",X:"BLUE",C:"BLUE",V:"BLUE",B:"BLUE",N:"BLUE",M:"BLUE"};var L=x(A()),Ke=({title:e,desc:t})=>Q.custom(r=>(0,L.jsx)("div",{className:`${r.visible?"animate-enter":"animate-leave"} max-w-md w-full bg-white shadow-lg rounded-lg pointer-events-auto flex ring-1 ring-black ring-opacity-5`,children:(0,L.jsx)("div",{className:"flex-1 w-0 p-4",children:(0,L.jsx)("div",{className:"flex items-start",children:(0,L.jsxs)("div",{className:"ml-3 flex-1",children:[(0,L.jsx)("h4",{className:"text-lg font-medium text-gray-900",children:e}),(0,L.jsx)("p",{className:"mt-1 text-md text-gray-500",children:t})]})})})})),O=Ke;function te(e){let t=e.mainWord.toUpperCase(),r=e.gamesRows[e.currentRow],s=r.flatMap(d=>[d.value]),i=t.split(""),a=s.join("");if(a.length<5)return O({title:"Te Kort",desc:"Die woord moet 5 letters lank wees"}),{...e};if(!e.toCheck.find(d=>d.toUpperCase()===a.toUpperCase()))return O({title:"Snaaks...",desc:"Lyk nie of ons daai woord ken nie"}),j(e),{...e};let o=ee(i),l=r.map((d,R)=>i[R]===d.value?(e.keyBoardColors[d.value]="GREEN",{...d,status:"GREEN",index:R}):i.find(H=>H===d.value)?(e.keyBoardColors[d.value]!=="GREEN"&&(e.keyBoardColors[d.value]="ORANGE"),{...d,status:"ORANGE",index:R}):(e.keyBoardColors[d.value]="GREY",{...d,status:"GREY",index:R})).sort(Ve),c=[],g=l.map(d=>{if(c.push(d.value),d.status==="ORANGE"){let R=o[d.value];return ee(c)[d.value]>R?{...d,status:"GREY"}:d}else return d}).sort(Je);e.gamesRows[e.currentRow]=g;let p={...e,currentInput:0,currentRow:e.currentRow+1};return t===a?(p={...p,gameStatus:2,endDate:new Date},j(p),O({title:"Jou yster",desc:"Jy het gewen"}),{...p}):e.currentRow===5?(p={...p,gameStatus:3,endDate:new Date},j(p),O({title:"Verloor",desc:"Ag nee, probeer more weer"}),{...p}):(j(p),p)}var j=e=>{let t={...e};delete t.toCheck;let r=JSON.stringify(t),s=btoa(r);localStorage.setItem(e.todaysDate,s)},ee=e=>{let t={};for(let r of e)t[r]=t[r]?t[r]+1:1;return t},Ve=(e,t)=>{let r={};return r["GREEN"]=1,r["ORANGE"]=2,r["GREY"]=3,r[e.status]<r[t.status]?-1:r[e.status]>r[t.status]?1:0},Je=(e,t)=>e.index<t.index?-1:e.index>t.index?1:0;function re(e,t){switch(t.type){case 4:return{...e,mainWord:t.mainWord,todaysDate:t.todaysDate,mainNumber:t.mainNumber,toCheck:t.toCheck};case 3:return{...e,...t.storage};case 0:return e.currentInput===5?{...e}:(e.gamesRows[e.currentRow][e.currentInput].value=t.key,{...e,gamesRows:e.gamesRows,currentInput:e.currentInput+1,gameStatus:1});case 1:return{...te(e)};case 2:{if(!e.currentInput)return{...e};let r=e.currentInput-1;return e.gamesRows[e.currentRow][r].value="",{...e,currentRow:e.currentRow,currentInput:r}}default:return e}}var ae=x(A()),_e={gamesRows:X,toCheck:[],startDate:new Date,mainNumber:0,mainWord:"",currentRow:0,currentInput:0,gameStatus:0,keyBoardColors:{...q}};function Ze({children:e}){let[t,r]=W.useReducer(re,_e),s={state:t,dispatch:r};return(0,ae.jsx)(F.Provider,{value:s,children:e})}function Lt(){let e=W.useContext(F);if(e===void 0)throw new Error("useLogic must be used within a LogicProvider");return e}export{ut as a,ot as b,Ze as c,Lt as d};
