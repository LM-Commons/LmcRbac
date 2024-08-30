"use strict";(self.webpackChunkdocs=self.webpackChunkdocs||[]).push([[9320],{6147:(e,n,i)=>{i.r(n),i.d(n,{assets:()=>d,contentTitle:()=>o,default:()=>h,frontMatter:()=>s,metadata:()=>c,toc:()=>a});var t=i(4848),r=i(8453);const s={sidebar_label:"Authorization service",sidebar_position:5,title:"Authorization Service"},o=void 0,c={id:"authorization-service",title:"Authorization Service",description:"Usage",source:"@site/versioned_docs/version-1.4/authorization-service.md",sourceDirName:".",slug:"/authorization-service",permalink:"/LmcRbac/docs/authorization-service",draft:!1,unlisted:!1,editUrl:"https://github.com/lm-commons/lmcrbac/tree/master/docs/versioned_docs/version-1.4/authorization-service.md",tags:[],version:"1.4",sidebarPosition:5,frontMatter:{sidebar_label:"Authorization service",sidebar_position:5,title:"Authorization Service"},sidebar:"documentationSidebar",previous:{title:"Roles and Role providers",permalink:"/LmcRbac/docs/role-providers"},next:{title:"Dynamic Assertions",permalink:"/LmcRbac/docs/assertions"}},d={},a=[{value:"Usage",id:"usage",level:3},{value:"Reference",id:"reference",level:3}];function l(e){const n={a:"a",code:"code",h3:"h3",li:"li",p:"p",pre:"pre",table:"table",tbody:"tbody",td:"td",th:"th",thead:"thead",tr:"tr",ul:"ul",...(0,r.R)(),...e.components};return(0,t.jsxs)(t.Fragment,{children:[(0,t.jsx)(n.h3,{id:"usage",children:"Usage"}),"\n",(0,t.jsxs)(n.p,{children:["The Authorization service can be retrieved from the service manager using the name\n",(0,t.jsx)(n.code,{children:"LmcRbac\\Service\\AuthorizationServiceInterface"})," and injected into your code:"]}),"\n",(0,t.jsx)(n.pre,{children:(0,t.jsx)(n.code,{className:"language-php",children:"<?php\n    /** @var \\Psr\\Container\\ContainerInterface $container */\n    $authorizationService = $container->get(LmcRbac\\Service\\AuthorizationServiceInterface::class);\n\n"})}),"\n",(0,t.jsx)(n.h3,{id:"reference",children:"Reference"}),"\n",(0,t.jsxs)(n.p,{children:[(0,t.jsx)(n.code,{children:"LmcRbac\\Service\\AuthorizationServiceInterface"})," defines the following method:"]}),"\n",(0,t.jsxs)(n.ul,{children:["\n",(0,t.jsx)(n.li,{children:(0,t.jsx)(n.code,{children:"isGranted(?IdentityInterface $identity, string $permission, $context = null): bool"})}),"\n"]}),"\n",(0,t.jsxs)(n.table,{children:[(0,t.jsx)(n.thead,{children:(0,t.jsxs)(n.tr,{children:[(0,t.jsx)(n.th,{children:"Parameter"}),(0,t.jsx)(n.th,{children:"Description"})]})}),(0,t.jsxs)(n.tbody,{children:[(0,t.jsxs)(n.tr,{children:[(0,t.jsx)(n.td,{children:(0,t.jsx)(n.code,{children:"$identity"})}),(0,t.jsxs)(n.td,{children:["The identity whose roles to checks. ",(0,t.jsx)("br",{}),"If ",(0,t.jsx)(n.code,{children:"$identity"})," is null, then the ",(0,t.jsx)(n.code,{children:"guest"})," is used. ",(0,t.jsx)("br",{}),"The ",(0,t.jsx)(n.code,{children:"guest"})," role is definable via configuration and defaults to ",(0,t.jsx)(n.code,{children:"'guest'"}),"."]})]}),(0,t.jsxs)(n.tr,{children:[(0,t.jsx)(n.td,{children:(0,t.jsx)(n.code,{children:"$permission"})}),(0,t.jsx)(n.td,{children:"The permission to check against"})]}),(0,t.jsxs)(n.tr,{children:[(0,t.jsx)(n.td,{children:(0,t.jsx)(n.code,{children:"$context"})}),(0,t.jsx)(n.td,{children:"A context that will be passed to dynamic assertions that are defined for the permission"})]})]})]}),"\n",(0,t.jsxs)(n.p,{children:["More on dynamic assertions can be found in the ",(0,t.jsx)(n.a,{href:"/LmcRbac/docs/assertions",children:"Assertions"})," section."]}),"\n",(0,t.jsxs)(n.p,{children:["More on the ",(0,t.jsx)(n.code,{children:"guest"})," role can be found in the ",(0,t.jsx)(n.a,{href:"/LmcRbac/docs/configuration",children:"Configuration"})," section."]})]})}function h(e={}){const{wrapper:n}={...(0,r.R)(),...e.components};return n?(0,t.jsx)(n,{...e,children:(0,t.jsx)(l,{...e})}):l(e)}},8453:(e,n,i)=>{i.d(n,{R:()=>o,x:()=>c});var t=i(6540);const r={},s=t.createContext(r);function o(e){const n=t.useContext(s);return t.useMemo((function(){return"function"==typeof e?e(n):{...n,...e}}),[n,e])}function c(e){let n;return n=e.disableParentContext?"function"==typeof e.components?e.components(r):e.components||r:o(e.components),t.createElement(s.Provider,{value:n},e.children)}}}]);