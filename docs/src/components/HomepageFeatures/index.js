import clsx from 'clsx';
import Heading from '@theme/Heading';
import styles from './styles.module.css';
import Link from "@docusaurus/Link";

const FeatureList = [
  {
    title: 'Easy to Use',
    Svg: require('@site/static/img/undraw_docusaurus_mountain.svg').default,
    description: (
      <>
        Docusaurus was designed from the ground up to be easily installed and
        used to get your website up and running quickly.
      </>
    ),
  },
  {
    title: 'Focus on What Matters',
    Svg: require('@site/static/img/undraw_docusaurus_tree.svg').default,
    description: (
      <>
        Docusaurus lets you focus on your docs, and we&apos;ll do the chores. Go
        ahead and move your docs into the <code>docs</code> directory.
      </>
    ),
  },
  {
    title: 'Powered by React',
    Svg: require('@site/static/img/undraw_docusaurus_react.svg').default,
    description: (
      <>
        Extend or customize your website layout by reusing React. Docusaurus can
        be extended while reusing the same header and footer.
      </>
    ),
  },
];

function Feature({Svg, title, description}) {
  return (
    <div className={clsx('col col--4')}>
      <div className="text--center">
        <Svg className={styles.featureSvg} role="img" />
      </div>
      <div className="text--center padding-horiz--md">
        <Heading as="h3">{title}</Heading>
        <p>{description}</p>
      </div>
    </div>
  );
}

export default function HomepageFeatures() {
  return (
    <section className={styles.features}>
      <div className="container">
        <div className={clsx("row")}>
            <div className={clsx("col col--8")}>
                <Heading as="h1">Introduction</Heading>
                <p>Components and services to provide role-based access control (RBAC) to your application.</p>
                <p>LmcRbac can be used in Laminas MVC and in Mezzio applications.</p>
                <p>Based on the original work of <a
                    href="https://github.com/ZF-Commons/zfc-rbac">ZF-Commons/zfc-rbac</a> v3.x.</p>
                <p>If you are looking for the Laminas version of zfc-rbac v2, please use <a
                    href="https://github.com/LM-Commons/LmcRbacMvc">LM-Commons/LmcRbacMvc</a>.</p>
                <div className={styles.buttons}>
                    <Link className="button buttton--primary" to="/docs/installation">Get started</Link>
                </div>
                <Heading as="h2">Support</Heading>
                <ul>
                    <li>File issues at <a
                        href="https://github.com/LM-Commons/LmcRbac/issues">github.com/LM-Commons/LmcRbac/issues</a>.
                    </li>
                    <li>Ask questions in the <a
                        href="https://join.slack.com/t/lm-commons/shared_invite/zt-2gankt2wj-FTS45hp1W~JEj1tWvDsUHQ">LM-Commons
                        Slack</a> chat.
                    </li>
                </ul>


            </div>
            {/*}
          {FeatureList.map((props, idx) => (
            <Feature key={idx} {...props} />
          ))}
          {*/}
        </div>
      </div>
    </section>
  );
}
