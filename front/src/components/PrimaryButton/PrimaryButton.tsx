/* eslint-disable react/button-has-type */
import React from 'react';
import './index.scss';

type Props = {
  label: string;
  onClick: () => void;
};

const PrimaryButton = ({ label, onClick }: Props) => (
  <button className="primary-button" onClick={onClick}>
    {label}
  </button>
);

export default PrimaryButton;
