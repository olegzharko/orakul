/* eslint-disable prettier/prettier */
/* eslint-disable react/button-has-type */
import React from 'react';
import './index.scss';

type Props = {
  label: string;
  onClick: (e: any) => void;
  disabled: boolean;
  className?: string;
};

const SecondaryButton = ({
  label, onClick, disabled, className
}: Props) => (
  <button
    className={`secondary-button ${disabled ? 'disabled' : ''} ${
      className || ''
    }`}
    onClick={onClick}
    disabled={disabled}
  >
    {label}
  </button>
);

export default SecondaryButton;
