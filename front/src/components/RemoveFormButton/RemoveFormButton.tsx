/* eslint-disable jsx-a11y/no-static-element-interactions */
import React from 'react';
import './index.scss';

type Props = {
  onClick: (index: number) => void;
  index: number;
  disabled?: boolean;
};

const RemoveFormButton = ({ onClick, index, disabled }: Props) => {
  const handleClick = () => {
    if (disabled) return;
    onClick(index);
  };

  return (
    <div
      className={`remove-form-button ${disabled ? 'disabled' : ''}`}
      onClick={handleClick}
      onKeyPress={() => onClick(index)}
    >
      <img src="/icons/minus.svg" alt="minus" />
    </div>
  );
};

export default RemoveFormButton;
