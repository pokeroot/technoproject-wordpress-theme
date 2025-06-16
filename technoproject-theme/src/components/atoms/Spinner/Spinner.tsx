import React from 'react';
import styles from './Spinner.module.scss';

export interface SpinnerProps {
  size?: 'small' | 'medium' | 'large';
  color?: 'primary' | 'secondary' | 'inherit'; // Allow color customization
  className?: string;
}

const Spinner: React.FC<SpinnerProps> = ({
  size = 'medium',
  color = 'primary',
  className,
}) => {
  const spinnerClasses = [
    styles.spinner,
    styles[size],
    styles[color],
    className || '',
  ].join(' ').trim();

  return (
    <div className={spinnerClasses} role="status" aria-live="polite">
      <span className={styles.visuallyHidden}>Cargando...</span> {/* For accessibility */}
    </div>
  );
};

export default Spinner;
