"use strict";(self.webpackChunkdocs=self.webpackChunkdocs||[]).push([[873],{2163:(e,n,t)=>{t.r(n),t.d(n,{assets:()=>d,contentTitle:()=>c,default:()=>h,frontMatter:()=>r,metadata:()=>o,toc:()=>a});var i=t(4848),s=t(8453);const r={sidebar_label:"Configuration",sidebar_position:7,title:"Configuring LmcRbac"},c=void 0,o={id:"configuration",title:"Configuring LmcRbac",description:"LmcRbac is configured via the lmc_rbac key in the application config.",source:"@site/docs/configuration.md",sourceDirName:".",slug:"/configuration",permalink:"/LmcRbac/docs/configuration",draft:!1,unlisted:!1,editUrl:"https://github.com/lm-commons/lmcrbac/tree/master/docs/docs/configuration.md",tags:[],version:"current",sidebarPosition:7,frontMatter:{sidebar_label:"Configuration",sidebar_position:7,title:"Configuring LmcRbac"},sidebar:"documentationSidebar",previous:{title:"Dynamic Assertions",permalink:"/LmcRbac/docs/assertions"},next:{title:"Migration Guide",permalink:"/LmcRbac/docs/migration"}},d={},a=[{value:"Reference",id:"reference",level:2}];function l(e){const n={a:"a",code:"code",h2:"h2",p:"p",table:"table",tbody:"tbody",td:"td",th:"th",thead:"thead",tr:"tr",...(0,s.R)(),...e.components};return(0,i.jsxs)(i.Fragment,{children:[(0,i.jsxs)(n.p,{children:["LmcRbac is configured via the ",(0,i.jsx)(n.code,{children:"lmc_rbac"})," key in the application config."]}),"\n",(0,i.jsxs)(n.p,{children:["This is typically achieved by creating\na ",(0,i.jsx)(n.code,{children:"config/autoload/lmcrbac.global.php"})," file. A sample configuration file is provided in the ",(0,i.jsx)(n.code,{children:"config/"})," folder."]}),"\n",(0,i.jsx)(n.h2,{id:"reference",children:"Reference"}),"\n",(0,i.jsxs)(n.table,{children:[(0,i.jsx)(n.thead,{children:(0,i.jsxs)(n.tr,{children:[(0,i.jsx)(n.th,{children:"Key"}),(0,i.jsx)(n.th,{children:"Description"})]})}),(0,i.jsxs)(n.tbody,{children:[(0,i.jsxs)(n.tr,{children:[(0,i.jsx)(n.td,{children:(0,i.jsx)(n.code,{children:"guest_role"})}),(0,i.jsxs)(n.td,{children:["Defines the name of the ",(0,i.jsx)(n.code,{children:"guest"})," role when no identity exists. ",(0,i.jsx)("br",{}),"Defaults to ",(0,i.jsx)(n.code,{children:"'guest'"}),"."]})]}),(0,i.jsxs)(n.tr,{children:[(0,i.jsx)(n.td,{children:(0,i.jsx)(n.code,{children:"assertion_map"})}),(0,i.jsxs)(n.td,{children:["Defines the dynamic assertions that are associated to permissions.",(0,i.jsx)("br",{}),"Defaults to ",(0,i.jsx)(n.code,{children:"[]"}),".",(0,i.jsx)("br",{}),"See the ",(0,i.jsx)(n.a,{href:"assertions",children:"Dynamic Assertions"})," section."]})]}),(0,i.jsxs)(n.tr,{children:[(0,i.jsx)(n.td,{children:(0,i.jsx)(n.code,{children:"role_provider"})}),(0,i.jsxs)(n.td,{children:["Defines the role provider.",(0,i.jsx)("br",{}),"Defaults to ",(0,i.jsx)(n.code,{children:"[]"}),(0,i.jsx)("br",{}),"See the ",(0,i.jsx)(n.a,{href:"role-providers",children:"Role Providers"})," section."]})]})]})]})]})}function h(e={}){const{wrapper:n}={...(0,s.R)(),...e.components};return n?(0,i.jsx)(n,{...e,children:(0,i.jsx)(l,{...e})}):l(e)}},8453:(e,n,t)=>{t.d(n,{R:()=>c,x:()=>o});var i=t(6540);const s={},r=i.createContext(s);function c(e){const n=i.useContext(r);return i.useMemo((function(){return"function"==typeof e?e(n):{...n,...e}}),[n,e])}function o(e){let n;return n=e.disableParentContext?"function"==typeof e.components?e.components(s):e.components||s:c(e.components),i.createElement(r.Provider,{value:n},e.children)}}}]);