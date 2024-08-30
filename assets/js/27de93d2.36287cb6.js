"use strict";(self.webpackChunkdocs=self.webpackChunkdocs||[]).push([[653],{4971:(e,n,i)=>{i.r(n),i.d(n,{assets:()=>d,contentTitle:()=>o,default:()=>h,frontMatter:()=>r,metadata:()=>c,toc:()=>a});var s=i(4848),t=i(8453);const r={sidebar_label:"Quick start",sidebar_position:3,title:"Quick Start"},o=void 0,c={id:"quickstart",title:"Quick Start",description:"Once the library has been installed by Composer, you will need to copy the",source:"@site/versioned_docs/version-1.4/quickstart.md",sourceDirName:".",slug:"/quickstart",permalink:"/LmcRbac/docs/quickstart",draft:!1,unlisted:!1,editUrl:"https://github.com/lm-commons/lmcrbac/tree/master/docs/versioned_docs/version-1.4/quickstart.md",tags:[],version:"1.4",sidebarPosition:3,frontMatter:{sidebar_label:"Quick start",sidebar_position:3,title:"Quick Start"},sidebar:"documentationSidebar",previous:{title:"Concepts",permalink:"/LmcRbac/docs/concepts"},next:{title:"Roles and Role providers",permalink:"/LmcRbac/docs/role-providers"}},d={},a=[{value:"Defining roles",id:"defining-roles",level:2},{value:"Basic authorization",id:"basic-authorization",level:2},{value:"Using assertions",id:"using-assertions",level:2}];function l(e){const n={a:"a",admonition:"admonition",code:"code",h2:"h2",li:"li",p:"p",pre:"pre",ul:"ul",...(0,t.R)(),...e.components};return(0,s.jsxs)(s.Fragment,{children:[(0,s.jsxs)(n.p,{children:["Once the library has been installed by Composer, you will need to copy the\n",(0,s.jsx)(n.code,{children:"config/lmcrbac.global.php"})," file from ",(0,s.jsx)(n.code,{children:"LmcRbac"})," to the ",(0,s.jsx)(n.code,{children:"config/autoload"})," folder."]}),"\n",(0,s.jsx)(n.admonition,{type:"note",children:(0,s.jsxs)(n.p,{children:["On older versions of ",(0,s.jsx)(n.code,{children:"LmcRbac"}),", the configuration file is named ",(0,s.jsx)(n.code,{children:"config/config.global.php"}),"."]})}),"\n",(0,s.jsx)(n.h2,{id:"defining-roles",children:"Defining roles"}),"\n",(0,s.jsx)(n.p,{children:"By default, no roles and no permissions are defined."}),"\n",(0,s.jsxs)(n.p,{children:["Roles and permissions are defined by a Role Provider. ",(0,s.jsx)(n.code,{children:"LmcRbac"})," ships with two roles providers:"]}),"\n",(0,s.jsxs)(n.ul,{children:["\n",(0,s.jsxs)(n.li,{children:["a simple ",(0,s.jsx)(n.code,{children:"InMemoryRoleProvider"})," that uses an associative array to define roles and their permission. This is the default."]}),"\n",(0,s.jsxs)(n.li,{children:["a ",(0,s.jsx)(n.code,{children:"ObjectRepositoyRoleProvider"})," that is based on Doctrine ORM."]}),"\n"]}),"\n",(0,s.jsxs)(n.p,{children:["To quickly get started, let's use the ",(0,s.jsx)(n.code,{children:"InMemoryRoleProvider"})," role provider."]}),"\n",(0,s.jsxs)(n.p,{children:["In the ",(0,s.jsx)(n.code,{children:"config/autoload/lmcrbac.global.php"}),", add the following:"]}),"\n",(0,s.jsx)(n.pre,{children:(0,s.jsx)(n.code,{className:"language-php",children:"<?php\n\nreturn [\n    'lmc_rbac' => [\n        'role_provider' => [\n            'LmcRbac\\Role\\InMemoryRoleProvider' => [\n                'guest',\n                'user' => [\n                    'permissions' => ['create', 'edit'],\n                ],\n                'admin' => [\n                    'children' => ['user'],\n                    'permissions' => ['delete'],\n                ],\n            ],\n        ],\n    ],\n];\n"})}),"\n",(0,s.jsxs)(n.p,{children:["This defines 3 roles: a ",(0,s.jsx)(n.code,{children:"guest"})," role, a ",(0,s.jsx)(n.code,{children:"user"})," role having 2 permissions, and a ",(0,s.jsx)(n.code,{children:"admin"})," role which has the ",(0,s.jsx)(n.code,{children:"user"})," role as\na child and with its own permission. If the hierarchy is flattened:"]}),"\n",(0,s.jsxs)(n.ul,{children:["\n",(0,s.jsxs)(n.li,{children:[(0,s.jsx)(n.code,{children:"guest"})," has no permission"]}),"\n",(0,s.jsxs)(n.li,{children:[(0,s.jsx)(n.code,{children:"user"})," has permissions ",(0,s.jsx)(n.code,{children:"create"})," and ",(0,s.jsx)(n.code,{children:"edit"})]}),"\n",(0,s.jsxs)(n.li,{children:[(0,s.jsx)(n.code,{children:"admin"})," has permissions ",(0,s.jsx)(n.code,{children:"create"}),", ",(0,s.jsx)(n.code,{children:"edit"})," and ",(0,s.jsx)(n.code,{children:"delete"})]}),"\n"]}),"\n",(0,s.jsx)(n.h2,{id:"basic-authorization",children:"Basic authorization"}),"\n",(0,s.jsx)(n.p,{children:"The authorization service can get retrieved from service manager container and used to check if a permission\nis granted to an identity:"}),"\n",(0,s.jsx)(n.pre,{children:(0,s.jsx)(n.code,{className:"language-php",children:"<?php\n\n    /** @var \\Psr\\Container\\ContainerInterface $container */\n    $authorizationService = $container->get('\\LmcRbac\\Service\\AuthorizationServiceInterface');\n    \n    /** @var \\LmcRbac\\Identity\\IdentityInterface $identity */\n    if ($authorizationService->isGranted($identity, 'create')) {\n        /** do something */\n    }\n"})}),"\n",(0,s.jsxs)(n.p,{children:["If ",(0,s.jsx)(n.code,{children:"$identity"})," has the role ",(0,s.jsx)(n.code,{children:"user"})," and/or ",(0,s.jsx)(n.code,{children:"admin"})," then the authorization is granted. If the identity has the role ",(0,s.jsx)(n.code,{children:"guest"}),", then authorization\nis denied."]}),"\n",(0,s.jsx)(n.admonition,{type:"info",children:(0,s.jsxs)(n.p,{children:["If ",(0,s.jsx)(n.code,{children:"$identity"})," is null (no identity), then the guest role is assumed which is set to ",(0,s.jsx)(n.code,{children:"'guest'"})," by default. The guest role\ncan be configured in the ",(0,s.jsx)(n.code,{children:"lmcrbac.config.php"})," file.  More on this in the ",(0,s.jsx)(n.a,{href:"/LmcRbac/docs/configuration",children:"Configuration"})," section."]})}),"\n",(0,s.jsx)(n.admonition,{type:"warning",children:(0,s.jsxs)(n.p,{children:[(0,s.jsx)(n.code,{children:"LmcRbac"})," does not provide any logic to instantiate an identity entity. It is assumed that\nthe application will instantiate an entity that implements ",(0,s.jsx)(n.code,{children:"\\LmcRbac\\Identity\\IdentityInterface"})," which defines the ",(0,s.jsx)(n.code,{children:"getRoles()"}),"\nmethod."]})}),"\n",(0,s.jsx)(n.h2,{id:"using-assertions",children:"Using assertions"}),"\n",(0,s.jsxs)(n.p,{children:["Even if an identity has the ",(0,s.jsx)(n.code,{children:"user"})," role granting it the ",(0,s.jsx)(n.code,{children:"edit"})," permission, it should not have the authorization to edit another identity's resource."]}),"\n",(0,s.jsx)(n.p,{children:"This can be achieved using dynamic assertion."}),"\n",(0,s.jsxs)(n.p,{children:["An assertion is a function that implements the ",(0,s.jsx)(n.code,{children:"\\LmcRbac\\Assertion\\AssertionInterface"})," and is configured in the configuration\nfile."]}),"\n",(0,s.jsxs)(n.p,{children:["Let's modify the ",(0,s.jsx)(n.code,{children:"lmcrbac.config.php"})," file as follows:"]}),"\n",(0,s.jsx)(n.pre,{children:(0,s.jsx)(n.code,{className:"language-php",children:"<?php\nreturn [\n    'lmc_rbac' => [\n        'role_provider' => [\n            /* roles and permissions\n        ],\n        'assertion_map' => [\n            'edit' => function ($permission, IdentityInterface $identity = null, $resource = null) {\n                        if ($resource->getOwnerId() === $identity->getId() {\n                            return true;\n                        } else {\n                            return false;\n                      }\n        ],\n    ],\n];\n"})}),"\n",(0,s.jsx)(n.p,{children:"Then use the authorization service passing the resource (called a 'context') in addition to the permission:"}),"\n",(0,s.jsx)(n.pre,{children:(0,s.jsx)(n.code,{className:"language-php",children:"<?php\n\n    /** @var \\Psr\\Container\\ContainerInterface $container */\n    $authorizationService = $container->get('\\LmcRbac\\Service\\AuthorizationServiceInterface');\n    \n    /** @var \\LmcRbac\\Identity\\IdentityInterface $identity */\n    if ($authorizationService->isGranted($identity, 'edit', $resource)) {\n        /** do something */\n    }\n"})}),"\n",(0,s.jsxs)(n.p,{children:["Dynanmic assertions are further discussed in the ",(0,s.jsx)(n.a,{href:"assertions",children:"Dynamic Assertions"})," section."]})]})}function h(e={}){const{wrapper:n}={...(0,t.R)(),...e.components};return n?(0,s.jsx)(n,{...e,children:(0,s.jsx)(l,{...e})}):l(e)}},8453:(e,n,i)=>{i.d(n,{R:()=>o,x:()=>c});var s=i(6540);const t={},r=s.createContext(t);function o(e){const n=s.useContext(r);return s.useMemo((function(){return"function"==typeof e?e(n):{...n,...e}}),[n,e])}function c(e){let n;return n=e.disableParentContext?"function"==typeof e.components?e.components(t):e.components||t:o(e.components),s.createElement(r.Provider,{value:n},e.children)}}}]);