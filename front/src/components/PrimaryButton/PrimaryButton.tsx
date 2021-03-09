/* eslint-disable react/button-has-type */
import React from 'react';
import './index.scss';

type Props = {
  label: string;
  onClick: () => void;
  disabled: boolean;
};

const PrimaryButton = ({ label, onClick, disabled }: Props) => (
  <button
    className={`primary-button ${disabled ? 'disabled' : ''}`}
    onClick={onClick}
    disabled={disabled}
  >
    {label}
  </button>
);

export default PrimaryButton;
