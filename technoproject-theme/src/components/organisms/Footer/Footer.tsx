import React from 'react';
import styles from './Footer.module.scss';

const Footer: React.FC = () => {
  return (
    <footer className={styles.footer}>
      <div className={styles.footerContent}>
        <p>&copy; {new Date().getFullYear()} Technoproject. Todos los derechos reservados.</p>
        {/* Add more footer content like links, social media icons later */}
      </div>
    </footer>
  );
};

export default Footer;
