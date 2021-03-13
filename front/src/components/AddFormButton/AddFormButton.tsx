/* eslint-disable jsx-a11y/no-static-element-interactions */
import React from 'react';
import './index.scss';

type Props = {
  onClick: () => void;
  disabled?: boolean;
};

const AddFormButton = ({ onClick, disabled }: Props) => {
  const handleClick = () => {
    if (disabled) return;
    onClick();
  };

  return (
    <div
      className={`add-form-button ${disabled ? 'disabled' : ''}`}
      onClick={handleClick}
      onKeyPress={handleClick}
    >
      <img src="/icons/plus.svg" alt="plus" />
    </div>
  );
};

export default AddFormButton;
