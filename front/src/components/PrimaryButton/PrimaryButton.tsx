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

const PrimaryButton = ({
  label, onClick, disabled, className
}: Props) => (
  <button
    className={`primary-button ${disabled ? 'disabled' : ''} ${
      className || ''
    }`}
    onClick={onClick}
    disabled={disabled}
  >
    {label}
  </button>
);

export default PrimaryButton;
