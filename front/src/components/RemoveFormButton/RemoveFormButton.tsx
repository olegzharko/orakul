/* eslint-disable jsx-a11y/no-static-element-interactions */
import React from 'react';
import './index.scss';

type Props = {
  onClick: (index: number) => void;
  index: number;
};

const RemoveFormButton = ({ onClick, index }: Props) => (
  <div
    className="remove-form-button"
    onClick={() => onClick(index)}
    onKeyPress={() => onClick(index)}
  >
    <img src="/icons/minus.svg" alt="minus" />
  </div>
);

export default RemoveFormButton;
