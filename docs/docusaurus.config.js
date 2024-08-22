// @ts-check
// `@type` JSDoc annotations allow editor autocompletion and type checking
// (when paired with `@ts-check`).
// There are various equivalent ways to declare your Docusaurus config.
// See: https://docusaurus.io/docs/api/docusaurus-config

import {themes as prismThemes} from 'prism-react-renderer';

/** @type {import('@docusaurus/types').Config} */
const config = {
    title: 'LmcRbac',
    tagline: 'Role-based access control components for your Laminas or Mezzio application',
    favicon: 'img/favicon.ico',

  // Set the production url of your site here
    url: 'https://lm-commons.github.io',
  // Set the /<baseUrl>/ pathname under which your site is served
  // For GitHub pages deployment, it is often '/<projectName>/'
    baseUrl: '/LmcRbac/',

  // GitHub pages deployment config.
  // If you aren't using GitHub pages, you don't need these.
    organizationName: 'lm-commons',
    projectName: 'LmcRbac',
    trailingSlash: false,

    onBrokenLinks: 'throw',
    onBrokenMarkdownLinks: 'warn',

  // Even if you don't use internationalization, you can use this field to set
  // useful metadata like html lang. For example, if your site is Chinese, you
  // may want to replace "en" with "zh-Hans".
    i18n: {
        defaultLocale: 'en',
        locales: ['en'],
    },

    presets: [
    [
      'classic',
      /** @type {import('@docusaurus/preset-classic').Options} */
      ({
            docs: {
                sidebarPath: './sidebars.js',
              // Please change this to your repo.
              // Remove this to remove the "edit this page" links.
                editUrl:
                'https://github.com/lm-commons/lmcrbac/tree/master/docs/',
            },
            blog: {
                showReadingTime: true,
              // Please change this to your repo.
              // Remove this to remove the "edit this page" links.
                editUrl:
                'https://github.com/lm-commons/lmcrbac/tree/master/docs/',
            },
            theme: {
                customCss: './src/css/custom.css',
            },
        }),
    ],
  ],

themeConfig:
    /** @type {import('@docusaurus/preset-classic').ThemeConfig} */
    ({
      // Replace with your project's social card
        image: 'img/LMC-social-card.png',
        navbar: {
            title: 'LmcRbac',
            logo: {
                alt: 'LM-Commons Logo',
                src: 'img/LMC-logo.png',
//                href: 'https://lm-commons.github.io'
            },
            items: [
            {
                type: 'docSidebar',
                sidebarId: 'documentationSidebar',
                position: 'left',
                label: 'Documentation',
            },
                {
                    type: "docsVersionDropdown",
                    position: "right",
                },

//            {to: '/blog', label: 'Blog', position: 'right'},
                {
                    href: 'https://lm-commons.github.io',
                    label: 'LM-Commons',
                    position: 'right',
            },
            {
                href: 'https://github.com/lm-commons/lmcrbac',
//                label: 'GitHub',
                position: 'right',
                className: 'header-github-link',
            },
            ],
        },
        footer: {
            style: 'dark',
            links: [
            {
                title: 'Docs',
                items: [
                {
                    label: 'Documentation',
                    to: '/docs/gettingstarted',
                },
                ],
            },
            {
                title: 'Community',
                items: [
                {
                    label: 'Slack',
                    href: 'https://join.slack.com/t/lm-commons/shared_invite/zt-2gankt2wj-FTS45hp1W~JEj1tWvDsUHQ',
                },
                ],
            },
            {
                title: 'More',
                items: [
                {
                    label: 'Blog',
                    to: '/blog',
                },
                {
                    label: 'GitHub',
                    href: 'https://github.com/lm-commons/lmcrbac',
                },
                ],
            },
            ],
            copyright: `Copyright © ${new Date().getFullYear()} LM-Commons Organization. Built with Docusaurus.`,
        },
        prism: {
            theme: prismThemes.github,
            darkTheme: prismThemes.dracula,
            additionalLanguages: ['bash', 'json', 'php']
        },
    }),
    headTags: [
        {
            tagName: 'meta',
            attributes: {
                name: 'keywords',
                content: 'php, LmcRbac, Laminas MVC, authorization'
            }
        }
    ],
};

export default config;
