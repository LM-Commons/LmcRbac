"use strict";(self.webpackChunkdocs=self.webpackChunkdocs||[]).push([[616],{3716:(e,n,s)=>{s.r(n),s.d(n,{assets:()=>c,contentTitle:()=>r,default:()=>h,frontMatter:()=>o,metadata:()=>a,toc:()=>d});var i=s(4848),t=s(8453);const o={sidebar_label:"Dynamic Assertions",sidebar_position:6,title:"Dynamic Assertions"},r=void 0,a={id:"assertions",title:"Dynamic Assertions",description:"Dynamic Assertions provide the capability to perform extra validations when",source:"@site/versioned_docs/version-2.0/assertions.md",sourceDirName:".",slug:"/assertions",permalink:"/LmcRbac/docs/2.0/assertions",draft:!1,unlisted:!1,editUrl:"https://github.com/lm-commons/lmcrbac/tree/master/docs/versioned_docs/version-2.0/assertions.md",tags:[],version:"2.0",sidebarPosition:6,frontMatter:{sidebar_label:"Dynamic Assertions",sidebar_position:6,title:"Dynamic Assertions"},sidebar:"documentationSidebar",previous:{title:"Authorization service",permalink:"/LmcRbac/docs/2.0/authorization-service"},next:{title:"Configuration",permalink:"/LmcRbac/docs/2.0/configuration"}},c={},d=[{value:"Defining a dynamic assertion function",id:"defining-a-dynamic-assertion-function",level:2},{value:"Configuring Assertions",id:"configuring-assertions",level:2},{value:"Dynamic Assertion sets",id:"dynamic-assertion-sets",level:2},{value:"Defining dynamic assertions at run-time",id:"defining-dynamic-assertions-at-run-time",level:2}];function l(e){const n={a:"a",code:"code",h2:"h2",p:"p",pre:"pre",...(0,t.R)(),...e.components};return(0,i.jsxs)(i.Fragment,{children:[(0,i.jsxs)(n.p,{children:["Dynamic Assertions provide the capability to perform extra validations when\nthe authorization service's ",(0,i.jsx)(n.code,{children:"isGranted()"})," method is called."]}),"\n",(0,i.jsxs)(n.p,{children:["As described in ",(0,i.jsx)(n.a,{href:"authorization-service#reference",children:"Authorization Service"}),", it is possible to pass a context to the\n",(0,i.jsx)(n.code,{children:"isGranted()"})," method. This context is then passed to dynamic assertion functions. This context can be any object type."]}),"\n",(0,i.jsx)(n.p,{children:"You can define dynamic assertion functions and assigned them to permission via configuration."}),"\n",(0,i.jsx)(n.h2,{id:"defining-a-dynamic-assertion-function",children:"Defining a dynamic assertion function"}),"\n",(0,i.jsxs)(n.p,{children:["A dynamic assertion must implement the ",(0,i.jsx)(n.code,{children:"Lmc\\Rbac\\Assertion\\AssertionInterace"})," which defines only one method:"]}),"\n",(0,i.jsx)(n.pre,{children:(0,i.jsx)(n.code,{className:"language-php",children:"public function assert(\n        string $permission,\n        ?IdentityInterface $identity = null,\n        mixed $context = null\n    ): bool\n"})}),"\n",(0,i.jsxs)(n.p,{children:["The assertion returns ",(0,i.jsx)(n.code,{children:"true"})," when the access is granted, ",(0,i.jsx)(n.code,{children:"false"})," otherwise."]}),"\n",(0,i.jsxs)(n.p,{children:["A simple assertion could be to check that user represented by ",(0,i.jsx)(n.code,{children:"$identity"}),", for the permission\nrepresented by ",(0,i.jsx)(n.code,{children:"$permission"})," owns the resource represented by ",(0,i.jsx)(n.code,{children:"$context"}),"."]}),"\n",(0,i.jsx)(n.pre,{children:(0,i.jsx)(n.code,{className:"language-php",children:"<?php\n\nclass MyAssertion implements \\Lmc\\Rbac\\Assertion\\AssertionInterface\n{\n    public function assert(string $permission, ?IdentityInterface $identity = null, $context = null): bool\n    {\n        // for 'edit' permission\n        if ('edit' === $permission) {\n            /** @var MyObjectClass $context */\n            return $context->getOwnerId() === $identity->getId();\n        }\n        // This should not happen since this assertion should only be\n        // called when the 'edit' permission is checked \n        return true;\n    }\n}\n"})}),"\n",(0,i.jsx)(n.h2,{id:"configuring-assertions",children:"Configuring Assertions"}),"\n",(0,i.jsx)(n.p,{children:"Dynamic assertions are configured in LmcRbac via an assertion map defined in the LmcRbac configuration where assertions\nare associated with permissions."}),"\n",(0,i.jsxs)(n.p,{children:["The ",(0,i.jsx)(n.code,{children:"assertion_map"})," key in the configuration is used to define the assertion map. If an assertion needs to be created via\na factory, use the ",(0,i.jsx)(n.code,{children:"assertion_manager"})," config key. The Assertion Manager is a standard\nplugin manager and its configuration should be a service manager configuration array."]}),"\n",(0,i.jsx)(n.pre,{children:(0,i.jsx)(n.code,{className:"language-php",children:"<?php\nuse Laminas\\ServiceManager\\Factory\\InvokableFactory\n\nreturn [\n    'lmc_rbac' => [\n        /* the rest of the file */\n        'assertion_map' => [\n            'edit'  => \\My\\Namespace\\MyAssertion::class,\n        ],\n        'assertion_manager' => [\n            'factories' => [\n                \\My\\Namespace\\MyAssertion::class => InvokableFactory::class\n            ],\n        ],\n    ],\n];\n"})}),"\n",(0,i.jsx)(n.p,{children:"It is also possible to configure an assertion using a callable instead of a class:"}),"\n",(0,i.jsx)(n.pre,{children:(0,i.jsx)(n.code,{className:"language-php",children:"<?php\n\nuse Lmc\\Rbac\\Permission\\PermissionInterface;\n\nreturn [\n    'lmc_rbac' => [\n        /* the rest of the file */\n        'assertion_map' => [\n            'edit'  => function assert(string $permission, ?IdentityInterface $identity = null, $context = null): bool\n                        {\n                            // for 'edit' permission\n                            if ('edit' === $permission) {\n                                /** @var MyObjectClass $context */\n                                return $context->getOwnerId() === $identity->getId();\n                            }\n                            // This should not happen since this assertion should only be\n                            // called when the 'edit' permission is checked \n                            return true;\n                        },\n        ],\n    ],\n];\n"})}),"\n",(0,i.jsx)(n.h2,{id:"dynamic-assertion-sets",children:"Dynamic Assertion sets"}),"\n",(0,i.jsx)(n.p,{children:"LmcRbac supports the creation of dynamic assertion sets where multiple assertions can be combined using 'and/or' logic.\nAssertion sets are configured by associating an array of assertions to a permission in the assertion map:"}),"\n",(0,i.jsx)(n.pre,{children:(0,i.jsx)(n.code,{className:"language-php",children:"<?php\n\nreturn [\n    'lmc_rbac' => [\n        /* the rest of the file */\n        'assertion_map' => [\n            'edit'  => [\n                \\My\\Namespace\\AssertionA::class,\n                \\My\\Namespace\\AssertionB::class,\n            ],\n            'read' => [\n                'condition' => \\Lmc\\Rbac\\Assertion\\AssertionSet::CONDITION_OR,\n                \\My\\Namespace\\AssertionC::class,\n                \\My\\Namespace\\AssertionD::class,\n            ],\n            'delete' => [\n                'condition' => \\Lmc\\Rbac\\Assertion\\AssertionSet::CONDITION_OR,\n                \\My\\Namespace\\AssertionE::class,\n                [\n                    'condition' => \\Lmc\\Rbac\\Assertion\\AssertionSet::CONDITION_AND,\n                    \\My\\Namespace\\AssertionF::class,\n                    \\My\\Namespace\\AssertionC::class,                \n                ],\n            ],\n        /** the rest of the file */\n    ],\n];\n"})}),"\n",(0,i.jsxs)(n.p,{children:["By default, an assertion set combines assertions using a 'and' condition. This is demonstrated by the map associated with\nthe ",(0,i.jsx)(n.code,{children:"'edit'"})," permission above."]}),"\n",(0,i.jsxs)(n.p,{children:["It is possible to combine assertions using a 'or' condition by adding a ",(0,i.jsx)(n.code,{children:"condition"})," equal to ",(0,i.jsx)(n.code,{children:"AssertionSet::CONDITION_OR"}),"\nto the assertion set as demonstrated by the map associated with the ",(0,i.jsx)(n.code,{children:"'read'"})," permission above."]}),"\n",(0,i.jsxs)(n.p,{children:["Furthermore, it is possible to nest assertion sets in order to create more complex logic as demonstrated by the map\nassociated with the ",(0,i.jsx)(n.code,{children:"'delete'"})," permission above."]}),"\n",(0,i.jsxs)(n.p,{children:["The default logic is to combine assertions using 'and' logic but this can be explicitly set as shown above for ",(0,i.jsx)(n.code,{children:"'delete'"}),"\npermission."]}),"\n",(0,i.jsx)(n.h2,{id:"defining-dynamic-assertions-at-run-time",children:"Defining dynamic assertions at run-time"}),"\n",(0,i.jsx)(n.p,{children:"Although dynamic assertions are typically defined in the application's configuration, it is possible to set\ndynamic assertions at run-time by using the Authorization Service utility methods for adding/getting assertions."}),"\n",(0,i.jsxs)(n.p,{children:["These methods are described in the Authorization Service ",(0,i.jsx)(n.a,{href:"/LmcRbac/docs/2.0/authorization-service#reference",children:"reference"}),"."]})]})}function h(e={}){const{wrapper:n}={...(0,t.R)(),...e.components};return n?(0,i.jsx)(n,{...e,children:(0,i.jsx)(l,{...e})}):l(e)}},8453:(e,n,s)=>{s.d(n,{R:()=>r,x:()=>a});var i=s(6540);const t={},o=i.createContext(t);function r(e){const n=i.useContext(o);return i.useMemo((function(){return"function"==typeof e?e(n):{...n,...e}}),[n,e])}function a(e){let n;return n=e.disableParentContext?"function"==typeof e.components?e.components(t):e.components||t:r(e.components),i.createElement(o.Provider,{value:n},e.children)}}}]);