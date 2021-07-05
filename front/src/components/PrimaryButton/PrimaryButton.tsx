/* eslint-disable prettier/prettier */
/* eslint-disable react/button-has-type */
import React, { useCallback, useState, useEffect } from 'react';
import './index.scss';

type Props = {
  label: string;
  onClick: (e: any) => void;
  disabled?: boolean;
  className?: string;
};

const PrimaryButton = ({
  label, onClick, disabled, className
}: Props) => {
  const [isClicked, setIsClicked] = useState<boolean>(false);

  const handleClick = useCallback((e) => {
    setIsClicked(true);
    onClick(e);
  }, [onClick]);

  useEffect(() => {
    setIsClicked(false);
  }, [onClick]);

  return (
    <button
      className={
        `primary-button
        ${disabled ? 'disabled' : ''}
        ${className || ''}
        ${isClicked ? 'clicked' : ''}
        `
      }
      onClick={handleClick}
      disabled={disabled}
    >
      {label}
    </button>
  );
};

export default PrimaryButton;
