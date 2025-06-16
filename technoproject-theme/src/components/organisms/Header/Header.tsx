import React from 'react';
import { Link } from 'react-router-dom';
import styles from './Header.module.scss';

const Header: React.FC = () => {
  return (
    <header className={styles.header}>
      <div className={styles.logo}>
        <Link to="/">Technoproject</Link> {/* Placeholder Logo */}
      </div>
      <nav className={styles.nav}>
        <Link to="/" className={styles.navLink}>Inicio</Link>
        <Link to="/cursos" className={styles.navLink}>Cursos</Link>
        {/* Add more links as needed */}
      </nav>
      {/* Hamburger menu button for mobile will be added later */}
    </header>
  );
};

export default Header;
