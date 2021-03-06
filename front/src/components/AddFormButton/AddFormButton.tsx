/* eslint-disable jsx-a11y/no-static-element-interactions */
import React from 'react';
import './index.scss';

type Props = {
  onClick: () => void;
};

const AddFormButton = ({ onClick }: Props) => (
  <div className="add-form-button" onClick={onClick} onKeyPress={onClick}>
    <img src="/icons/plus.svg" alt="plus" />
  </div>
);

export default AddFormButton;
