"use strict";(self.webpackChunkdocs=self.webpackChunkdocs||[]).push([[1497],{9105:(e,n,a)=>{a.r(n),a.d(n,{assets:()=>o,contentTitle:()=>c,default:()=>h,frontMatter:()=>i,metadata:()=>t,toc:()=>d});var r=a(4848),s=a(8453);const i={sidebar_label:"From v1 to v2",sidebar_position:1,title:"Upgrading from v1 to v2"},c=void 0,t={id:"Upgrading/to-v2",title:"Upgrading from v1 to v2",description:"LmcRbac v2 is a major version upgrade with many breaking changes that prevent",source:"@site/docs/Upgrading/to-v2.md",sourceDirName:"Upgrading",slug:"/Upgrading/to-v2",permalink:"/LmcRbac/docs/next/Upgrading/to-v2",draft:!1,unlisted:!1,editUrl:"https://github.com/lm-commons/lmcrbac/tree/master/docs/docs/Upgrading/to-v2.md",tags:[],version:"current",sidebarPosition:1,frontMatter:{sidebar_label:"From v1 to v2",sidebar_position:1,title:"Upgrading from v1 to v2"},sidebar:"documentationSidebar",previous:{title:"Integrating into applications",permalink:"/LmcRbac/docs/next/Guides/integrating"},next:{title:"From ZF-Commons Rbac v3",permalink:"/LmcRbac/docs/next/Upgrading/migration"}},o={},d=[{value:"Namespace change",id:"namespace-change",level:3},{value:"LmcRbac is based on laminas-permissions-rbac",id:"lmcrbac-is-based-on-laminas-permissions-rbac",level:3},{value:"Refactoring the factories",id:"refactoring-the-factories",level:3},{value:"Refactoring the Assertion Plugin Manager",id:"refactoring-the-assertion-plugin-manager",level:3}];function l(e){const n={code:"code",h3:"h3",p:"p",...(0,s.R)(),...e.components};return(0,r.jsxs)(r.Fragment,{children:[(0,r.jsx)(n.p,{children:"LmcRbac v2 is a major version upgrade with many breaking changes that prevent\nstraightforward upgrading."}),"\n",(0,r.jsx)(n.h3,{id:"namespace-change",children:"Namespace change"}),"\n",(0,r.jsx)(n.p,{children:"The namespace has been changed from LmcRbac to Lmc\\Rbac."}),"\n",(0,r.jsxs)(n.p,{children:["Please review your code to replace references to the ",(0,r.jsx)(n.code,{children:"LmcRbac"})," namespace\nby the ",(0,r.jsx)(n.code,{children:"Lmc\\Rbac"})," namespace."]}),"\n",(0,r.jsx)(n.h3,{id:"lmcrbac-is-based-on-laminas-permissions-rbac",children:"LmcRbac is based on laminas-permissions-rbac"}),"\n",(0,r.jsx)(n.p,{children:"LmcRbac is now based on the role class and interface provided by laminas-permissions-rbac which\nprovides a hierarchical role model only."}),"\n",(0,r.jsxs)(n.p,{children:["Therefore the ",(0,r.jsx)(n.code,{children:"Role"}),", ",(0,r.jsx)(n.code,{children:"HierarchicalRole"})," classes and the ",(0,r.jsx)(n.code,{children:"RoleInterface"})," and ",(0,r.jsx)(n.code,{children:"HierarchicalRoleInterface"})," have been removed\nin version 2."]}),"\n",(0,r.jsxs)(n.p,{children:["The ",(0,r.jsx)(n.code,{children:"PermissionInterface"})," interface has been removed as permissions in ",(0,r.jsx)(n.code,{children:"laminas-permissions-rbac"})," as just strings or any\nobjects that can be casted to a string. If you use objects to hold permissions, just make sure that the object can be\ncasted to a string by, for example, implementing a ",(0,r.jsx)(n.code,{children:"__toString()"})," method."]}),"\n",(0,r.jsx)(n.h3,{id:"refactoring-the-factories",children:"Refactoring the factories"}),"\n",(0,r.jsxs)(n.p,{children:["The factories for services have been refactored from the ",(0,r.jsx)(n.code,{children:"LmcRbac\\Container"})," namespace\nto be colocated with the service that a factory is creating. All factories in the ",(0,r.jsx)(n.code,{children:"LmcRbac\\Container"})," namespace have\nbeen removed."]}),"\n",(0,r.jsx)(n.h3,{id:"refactoring-the-assertion-plugin-manager",children:"Refactoring the Assertion Plugin Manager"}),"\n",(0,r.jsxs)(n.p,{children:["The ",(0,r.jsx)(n.code,{children:"AssertionContainer"})," class, interface and factory have been replaced by ",(0,r.jsx)(n.code,{children:"AssertionPluginManager"})," class, interface and factory."]})]})}function h(e={}){const{wrapper:n}={...(0,s.R)(),...e.components};return n?(0,r.jsx)(n,{...e,children:(0,r.jsx)(l,{...e})}):l(e)}},8453:(e,n,a)=>{a.d(n,{R:()=>c,x:()=>t});var r=a(6540);const s={},i=r.createContext(s);function c(e){const n=r.useContext(i);return r.useMemo((function(){return"function"==typeof e?e(n):{...n,...e}}),[n,e])}function t(e){let n;return n=e.disableParentContext?"function"==typeof e.components?e.components(s):e.components||s:c(e.components),r.createElement(i.Provider,{value:n},e.children)}}}]);