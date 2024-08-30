"use strict";(self.webpackChunkdocs=self.webpackChunkdocs||[]).push([[8813],{5448:(e,n,o)=>{o.r(n),o.d(n,{assets:()=>a,contentTitle:()=>t,default:()=>m,frontMatter:()=>r,metadata:()=>s,toc:()=>d});var i=o(4848),c=o(8453);const r={sidebar_label:"Migration Guide",sidebar_position:8,title:"Migration Guide"},t=void 0,s={id:"migration",title:"Migration Guide",description:"Migrating from ZF-Commons RBAC v3",source:"@site/versioned_docs/version-1.4/migration.md",sourceDirName:".",slug:"/migration",permalink:"/LmcRbac/docs/migration",draft:!1,unlisted:!1,editUrl:"https://github.com/lm-commons/lmcrbac/tree/master/docs/versioned_docs/version-1.4/migration.md",tags:[],version:"1.4",sidebarPosition:8,frontMatter:{sidebar_label:"Migration Guide",sidebar_position:8,title:"Migration Guide"},sidebar:"documentationSidebar",previous:{title:"Configuration",permalink:"/LmcRbac/docs/configuration"}},a={},d=[{value:"Migrating from ZF-Commons RBAC v3",id:"migrating-from-zf-commons-rbac-v3",level:2}];function l(e){const n={a:"a",code:"code",h2:"h2",li:"li",p:"p",ul:"ul",...(0,c.R)(),...e.components};return(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)(n.h2,{id:"migrating-from-zf-commons-rbac-v3",children:"Migrating from ZF-Commons RBAC v3"}),"\n",(0,i.jsx)(n.p,{children:"The ZF-Commons Rbac was created for the Zend Framework. When the Zend Framework was migrated to\nthe Laminas project, the LM-Commons organization was created to provide components formerly provided by ZF-Commons."}),"\n",(0,i.jsx)(n.p,{children:"When ZfcRbac was moved to LM-Commons, it was split into two repositories:"}),"\n",(0,i.jsxs)(n.ul,{children:["\n",(0,i.jsxs)(n.li,{children:[(0,i.jsx)(n.a,{href:"https://github.com/LM-Commons/LmcRbacMvc",children:"LmcRbacMvc"})," contains the old version 2 of ZfcRbac."]}),"\n",(0,i.jsx)(n.li,{children:"LmcRbac contains the version 3 of ZfcRbac, which was only released as v3.alpha.1."}),"\n"]}),"\n",(0,i.jsx)(n.p,{children:"To upgrade"}),"\n",(0,i.jsxs)(n.ul,{children:["\n",(0,i.jsxs)(n.li,{children:["Uninstall ",(0,i.jsx)(n.code,{children:"zf-commons/zfc-rbac:3.0.0-alpha.1"}),"."]}),"\n",(0,i.jsxs)(n.li,{children:["Install ",(0,i.jsx)(n.code,{children:"lm-commons/lmc-rbac:~1.0"})]}),"\n",(0,i.jsxs)(n.li,{children:["Change ",(0,i.jsx)(n.code,{children:"zfc-rbac.global.php"})," to ",(0,i.jsx)(n.code,{children:"lmcrbac.global.php"})," and update the key ",(0,i.jsx)(n.code,{children:"zfc_rbac"})," to ",(0,i.jsx)(n.code,{children:"lmc_rbac"}),"."]}),"\n",(0,i.jsxs)(n.li,{children:["Review your code for usages of the ",(0,i.jsx)(n.code,{children:"ZfcRbac/*"})," namespace to ",(0,i.jsx)(n.code,{children:"LmcRbac/*"})," namespace."]}),"\n"]})]})}function m(e={}){const{wrapper:n}={...(0,c.R)(),...e.components};return n?(0,i.jsx)(n,{...e,children:(0,i.jsx)(l,{...e})}):l(e)}},8453:(e,n,o)=>{o.d(n,{R:()=>t,x:()=>s});var i=o(6540);const c={},r=i.createContext(c);function t(e){const n=i.useContext(r);return i.useMemo((function(){return"function"==typeof e?e(n):{...n,...e}}),[n,e])}function s(e){let n;return n=e.disableParentContext?"function"==typeof e.components?e.components(c):e.components||c:t(e.components),i.createElement(r.Provider,{value:n},e.children)}}}]);