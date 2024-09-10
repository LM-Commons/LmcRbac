"use strict";(self.webpackChunkdocs=self.webpackChunkdocs||[]).push([[4567],{826:(e,r,n)=>{n.r(r),n.d(r,{assets:()=>c,contentTitle:()=>l,default:()=>h,frontMatter:()=>s,metadata:()=>t,toc:()=>a});var i=n(4848),o=n(8453);const s={sidebar_label:"Roles, permissions and Role providers",title:"Roles, Permissions and Role providers",sidebar_position:4},l=void 0,t={id:"role-providers",title:"Roles, Permissions and Role providers",description:"Roles",source:"@site/versioned_docs/version-2.0/role-providers.md",sourceDirName:".",slug:"/role-providers",permalink:"/LmcRbac/docs/role-providers",draft:!1,unlisted:!1,editUrl:"https://github.com/lm-commons/lmcrbac/tree/master/docs/versioned_docs/version-2.0/role-providers.md",tags:[],version:"2.0",sidebarPosition:4,frontMatter:{sidebar_label:"Roles, permissions and Role providers",title:"Roles, Permissions and Role providers",sidebar_position:4},sidebar:"documentationSidebar",previous:{title:"Quick Start",permalink:"/LmcRbac/docs/quick-start"},next:{title:"Authorization service",permalink:"/LmcRbac/docs/authorization-service"}},c={},a=[{value:"Roles",id:"roles",level:2},{value:"Permissions",id:"permissions",level:2},{value:"Role Providers",id:"role-providers",level:2},{value:"Built-in role providers",id:"built-in-role-providers",level:3},{value:"<code>Lmc\\Rbac\\Role\\InMemoryRoleProvider</code>",id:"lmcrbacroleinmemoryroleprovider",level:3},{value:"<code>Lmc\\Rbac\\Role\\ObjectRepositoryRoleProvider</code>",id:"lmcrbacroleobjectrepositoryroleprovider",level:3},{value:"Creating custom role providers",id:"creating-custom-role-providers",level:2},{value:"Role Service",id:"role-service",level:2}];function d(e){const r={a:"a",admonition:"admonition",code:"code",h2:"h2",h3:"h3",li:"li",p:"p",pre:"pre",table:"table",tbody:"tbody",td:"td",th:"th",thead:"thead",tr:"tr",ul:"ul",...(0,o.R)(),...e.components};return(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)(r.h2,{id:"roles",children:"Roles"}),"\n",(0,i.jsx)(r.p,{children:"A role is an object that returns a list of permissions that the role has."}),"\n",(0,i.jsxs)(r.p,{children:["LmcRbac uses the Role class defined by ",(0,i.jsx)(r.a,{href:"https://github.com/laminas/laminas-permissions-rbac",children:"laminas-permissions-rbac"}),"."]}),"\n",(0,i.jsxs)(r.p,{children:["Roles are defined using by the ",(0,i.jsx)(r.code,{children:"\\Laminas\\Permissions\\Rbac\\Role"})," class or by a class\nimplementing ",(0,i.jsx)(r.code,{children:"\\Laminas\\Permissions\\Rbac\\RoleInterface"}),"."]}),"\n",(0,i.jsx)(r.p,{children:"Roles can have child roles and therefore provides a hierarchy of roles where a role inherit the permissions of all its\nchild roles."}),"\n",(0,i.jsx)(r.p,{children:"For example, a 'user' role may have the 'read' and 'write' permissions, and a 'admin' role\nmay inherit the permissions of the 'user' role plus an additional 'delete' role. In this structure,\nthe 'admin' role will have 'user' as its child role."}),"\n",(0,i.jsxs)(r.admonition,{title:"Flat roles",type:"tip",children:[(0,i.jsx)(r.p,{children:"Previous version of LmcRbac used to make a distinction between flat roles and hierarchical roles.\nA flat role is just a simplification of a hierarchical role, i.e. a hierarchical role without children."}),(0,i.jsxs)(r.p,{children:["In ",(0,i.jsx)(r.code,{children:"laminas-permissions-rbac"}),", roles are hierarchical."]})]}),"\n",(0,i.jsx)(r.h2,{id:"permissions",children:"Permissions"}),"\n",(0,i.jsxs)(r.p,{children:["A permission in ",(0,i.jsx)(r.code,{children:"laminas-permissions-rbac"})," is simply a string that represents the permission such as 'read', 'write' or 'delete'.\nBut it can also be more precise like 'article.read' or 'article.write'."]}),"\n",(0,i.jsx)(r.p,{children:"A permission can also be an object as long as it can be casted to a string. This could be the\ncase, for example, when permissions are stored in a database where they could also have a identified and a description."}),"\n",(0,i.jsx)(r.admonition,{type:"tip",children:(0,i.jsxs)(r.p,{children:["An object can be casted to a string by implementing the ",(0,i.jsx)(r.code,{children:"__toString()"})," method."]})}),"\n",(0,i.jsx)(r.h2,{id:"role-providers",children:"Role Providers"}),"\n",(0,i.jsxs)(r.p,{children:["A role provider is an object that returns a list of roles. A role provider must implement the\n",(0,i.jsx)(r.code,{children:"Lmc\\Rbac\\Role\\RoleProviderInterface"})," interface. The only required method is ",(0,i.jsx)(r.code,{children:"getRoles"}),", and must return an array\nof ",(0,i.jsx)(r.code,{children:"Laminas\\Permissions\\Rbac\\RoleInterface"})," objects."]}),"\n",(0,i.jsx)(r.p,{children:"Roles can come from one of many sources: in memory, from a file, from a database, etc. However, you can specify only one role provider per application."}),"\n",(0,i.jsx)(r.h3,{id:"built-in-role-providers",children:"Built-in role providers"}),"\n",(0,i.jsxs)(r.p,{children:["LmcRbac comes with two built-in role providers: ",(0,i.jsx)(r.code,{children:"Lmc\\Rbac\\Role\\InMemoryRoleProvider"})," and\n",(0,i.jsx)(r.code,{children:"Lmc\\Rbac\\Role\\ObjectRepositoryRoleProvider"}),". A role provider must be added to the ",(0,i.jsx)(r.code,{children:"role_provider"})," subkey in the\nconfiguration file. For example:"]}),"\n",(0,i.jsx)(r.pre,{children:(0,i.jsx)(r.code,{className:"language-php",children:"return [\n    'lmc_rbac' => [\n        'role_provider' => [\n            Lmc\\Rbac\\Role\\InMemoryRoleProvider::class => [\n                // configuration\n            ],\n        ]\n    ]\n];\n"})}),"\n",(0,i.jsx)(r.h3,{id:"lmcrbacroleinmemoryroleprovider",children:(0,i.jsx)(r.code,{children:"Lmc\\Rbac\\Role\\InMemoryRoleProvider"})}),"\n",(0,i.jsx)(r.p,{children:"This provider is ideal for small/medium sites with few roles/permissions. All the data is specified in a simple associative array in a\nPHP file."}),"\n",(0,i.jsx)(r.p,{children:"Here is an example of the format you need to use:"}),"\n",(0,i.jsx)(r.pre,{children:(0,i.jsx)(r.code,{className:"language-php",children:"return [\n    'lmc_rbac' => [\n        'role_provider' => [\n            Lmc\\Rbac\\Role\\InMemoryRoleProvider::class => [\n                'admin' => [\n                    'children'    => ['member'],\n                    'permissions' => ['article.delete']\n                ],\n                'member' => [\n                    'children'    => ['guest'],\n                    'permissions' => ['article.edit', 'article.archive']\n                ],\n                'guest' => [\n                    'permissions' => ['article.read']\n                ],\n            ],\n        ],\n    ],\n];\n"})}),"\n",(0,i.jsxs)(r.p,{children:["The ",(0,i.jsx)(r.code,{children:"children"})," and ",(0,i.jsx)(r.code,{children:"permissions"})," subkeys are entirely optional. Internally, the ",(0,i.jsx)(r.code,{children:"Lmc\\Rbac\\Role\\InMemoryRoleProvider"})," creates\n",(0,i.jsx)(r.code,{children:"Lmc\\Rbac\\Role\\Role"})," objects with children, if any."]}),"\n",(0,i.jsx)(r.p,{children:"If you are more confident with flat RBAC, the previous config can be re-written to remove any inheritence between roles:"}),"\n",(0,i.jsx)(r.pre,{children:(0,i.jsx)(r.code,{className:"language-php",children:"return [\n    'lmc_rbac' => [\n        'role_provider' => [\n            Lmc\\Rbac\\Role\\InMemoryRoleProvider::class => [\n                'admin' => [\n                    'permissions' => [\n                        'article.delete',\n                        'article.edit',\n                        'article.archive',\n                        'article.read'\n                    ]\n                ],\n                'member' => [\n                    'permissions' => [\n                        'article.edit',\n                        'article.archive',\n                        'article.read'\n                    ]\n                ],\n                'guest' => [\n                    'permissions' => ['article.read']\n                ]\n            ]\n        ]\n    ]\n];\n"})}),"\n",(0,i.jsx)(r.h3,{id:"lmcrbacroleobjectrepositoryroleprovider",children:(0,i.jsx)(r.code,{children:"Lmc\\Rbac\\Role\\ObjectRepositoryRoleProvider"})}),"\n",(0,i.jsxs)(r.p,{children:["This provider fetches roles from a database using ",(0,i.jsx)(r.code,{children:"Doctrine\\Common\\Persistence\\ObjectRepository"})," interface."]}),"\n",(0,i.jsxs)(r.p,{children:["You can configure this provider by giving an object repository service name that is fetched from the service manager\nusing the ",(0,i.jsx)(r.code,{children:"object_repository"})," key:"]}),"\n",(0,i.jsx)(r.pre,{children:(0,i.jsx)(r.code,{className:"language-php",children:"return [\n    'lmc_rbac' => [\n        'role_provider' => [\n            Lmc\\Rbac\\Role\\ObjectRepositoryRoleProvider::class => [\n                'object_repository'  => 'App\\Repository\\RoleRepository',\n                'role_name_property' => 'name'\n            ],\n        ],\n    ],\n];\n"})}),"\n",(0,i.jsxs)(r.p,{children:["Or you can specify the ",(0,i.jsx)(r.code,{children:"object_manager"})," and ",(0,i.jsx)(r.code,{children:"class_name"})," options:"]}),"\n",(0,i.jsx)(r.pre,{children:(0,i.jsx)(r.code,{className:"language-php",children:"return [\n    'lmc_rbac' => [\n        'role_provider' => [\n            Lmc\\Rbac\\Role\\ObjectRepositoryRoleProvider::class => [\n                'object_manager'     => 'doctrine.entitymanager.orm_default',\n                'class_name'         => 'App\\Entity\\Role',\n                'role_name_property' => 'name'\n            ],\n        ],\n    ],\n];\n"})}),"\n",(0,i.jsxs)(r.p,{children:["In both cases, you need to specify the ",(0,i.jsx)(r.code,{children:"role_name_property"})," value, which is the name of the entity's property\nthat holds the actual role name. This is used internally to only load the identity roles, instead of loading\nthe whole table every time."]}),"\n",(0,i.jsxs)(r.p,{children:["Please note that your entity fetched from the table MUST implement the ",(0,i.jsx)(r.code,{children:"Lmc\\Rbac\\Role\\RoleInterface"})," interface."]}),"\n",(0,i.jsxs)(r.p,{children:["Sample ORM entity models are provided in the ",(0,i.jsx)(r.code,{children:"/data"})," folder for flat role, hierarchical role and permission."]}),"\n",(0,i.jsx)(r.h2,{id:"creating-custom-role-providers",children:"Creating custom role providers"}),"\n",(0,i.jsxs)(r.p,{children:["To create a custom role provider, you first need to create a class that implements the\n",(0,i.jsx)(r.code,{children:"Lmc\\Rbac\\Role\\RoleProviderInterface"})," interface."]}),"\n",(0,i.jsx)(r.p,{children:"Then, you need to add it to the role provider manager:"}),"\n",(0,i.jsx)(r.pre,{children:(0,i.jsx)(r.code,{className:"language-php",children:"return [\n    'lmc_rbac' => [\n        'role_provider' => [\n            MyCustomRoleProvider::class => [\n                // Options\n            ],\n        ],\n    ],\n];\n"})}),"\n",(0,i.jsx)(r.p,{children:"And the role provider is created using the service manager:"}),"\n",(0,i.jsx)(r.pre,{children:(0,i.jsx)(r.code,{className:"language-php",children:"return [\n    'service_manager' => [\n        'factories' => [\n            MyCustomRoleProvider::class => MyCustomRoleProviderFactory::class,\n        ],\n    ],\n];\n"})}),"\n",(0,i.jsx)(r.h2,{id:"role-service",children:"Role Service"}),"\n",(0,i.jsx)(r.p,{children:"LmcRbac provides a role service that will use the Role Providers to provide the roles\nassociated with a given identity."}),"\n",(0,i.jsxs)(r.p,{children:["It can be retrieved from the container be requesting the ",(0,i.jsx)(r.code,{children:"Lmc\\Rbac\\Service\\RoleServiceIntgeface"}),"."]}),"\n",(0,i.jsxs)(r.p,{children:[(0,i.jsx)(r.code,{children:"Lmc\\Rbac\\Service\\RoleServiceInterface"})," defines the following method:"]}),"\n",(0,i.jsxs)(r.ul,{children:["\n",(0,i.jsxs)(r.li,{children:["\n",(0,i.jsx)(r.p,{children:(0,i.jsx)(r.code,{children:"getIdentityRoles(?IdentityInterface $identity = null): iterable"})}),"\n",(0,i.jsxs)(r.table,{children:[(0,i.jsx)(r.thead,{children:(0,i.jsxs)(r.tr,{children:[(0,i.jsx)(r.th,{children:"Parameter"}),(0,i.jsx)(r.th,{children:"Description"})]})}),(0,i.jsx)(r.tbody,{children:(0,i.jsxs)(r.tr,{children:[(0,i.jsx)(r.td,{children:(0,i.jsx)(r.code,{children:"$identity"})}),(0,i.jsxs)(r.td,{children:["The identity whose roles to retrieve. ",(0,i.jsx)("br",{}),"If ",(0,i.jsx)(r.code,{children:"$identity"})," is null, then the ",(0,i.jsx)(r.code,{children:"guest"})," is used. ",(0,i.jsx)("br",{}),"The ",(0,i.jsx)(r.code,{children:"guest"})," role is definable via configuration and defaults to ",(0,i.jsx)(r.code,{children:"'guest'"}),"."]})]})})]}),"\n"]}),"\n"]})]})}function h(e={}){const{wrapper:r}={...(0,o.R)(),...e.components};return r?(0,i.jsx)(r,{...e,children:(0,i.jsx)(d,{...e})}):d(e)}},8453:(e,r,n)=>{n.d(r,{R:()=>l,x:()=>t});var i=n(6540);const o={},s=i.createContext(o);function l(e){const r=i.useContext(s);return i.useMemo((function(){return"function"==typeof e?e(r):{...r,...e}}),[r,e])}function t(e){let r;return r=e.disableParentContext?"function"==typeof e.components?e.components(o):e.components||o:l(e.components),i.createElement(s.Provider,{value:r},e.children)}}}]);