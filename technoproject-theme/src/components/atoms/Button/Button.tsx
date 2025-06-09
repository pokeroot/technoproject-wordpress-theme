// technoproject-theme/src/components/atoms/Button/Button.tsx
import React from 'react';
import styles from './Button.module.scss'; // Using SCSS Modules

export interface ButtonProps extends React.ButtonHTMLAttributes<HTMLButtonElement> {
  variant?: 'primary' | 'secondary' | 'tertiary' | 'danger' | 'link';
  size?: 'small' | 'medium' | 'large';
  href?: string; // If the button should act as a link
  leftIcon?: React.ReactNode;
  rightIcon?: React.ReactNode;
  isLoading?: boolean;
  fullWidth?: boolean;
}

const Button: React.FC<ButtonProps> = ({
  children,
  variant = 'primary',
  size = 'medium',
  href,
  leftIcon,
  rightIcon,
  isLoading = false,
  fullWidth = false,
  className,
  disabled,
  type = 'button',
  ...props
}) => {
  const buttonClasses = [
    styles.button,
    styles[variant],
    styles[size],
    isLoading ? styles.loading : '',
    fullWidth ? styles.fullWidth : '',
    className || '',
  ].join(' ').trim();

  const content = (
    <>
      {isLoading && <span className={styles.spinner}></span>}
      {!isLoading && leftIcon && <span className={styles.iconLeft}>{leftIcon}</span>}
      <span className={styles.text}>{children}</span>
      {!isLoading && rightIcon && <span className={styles.iconRight}>{rightIcon}</span>}
    </>
  );

  if (href) {
    return (
      <a
        href={href}
        className={buttonClasses}
        // For accessibility with anchor tags styled as buttons
        role="button"
        aria-disabled={disabled || isLoading}
        {...(props as React.AnchorHTMLAttributes<HTMLAnchorElement>)}
        // Ensure only valid anchor props are spread
      >
        {content}
      </a>
    );
  }

  return (
    <button
      type={type}
      className={buttonClasses}
      disabled={disabled || isLoading}
      {...props}
    >
      {content}
    </button>
  );
};

export default Button;
