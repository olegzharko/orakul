/* eslint-disable no-unused-vars */
/* eslint-disable react/no-unused-prop-types */
import React, { useState, memo } from 'react';
import './index.scss';

type Button = {
  id: number;
  title: string;
};

type Props = {
  buttons: Button[];
  onChange: (id: number) => void;
};

export const RadioButtonsGroup = ({ buttons, onChange }: Props) => {
  const [selected, setSelected] = useState(buttons[0].id);

  const handleChange = (id: number) => {
    setSelected(id);
    onChange(id);
  };

  return (
    <div className="radio-buttons-group">
      {buttons.map(({ id, title }: Button) => (
        <div className="radio-buttons-group__element">
          <input
            type="radio"
            id={title}
            name={title}
            value={id}
            checked={selected === id}
            onChange={() => handleChange(id)}
            className="input"
          />
          <label htmlFor={title} className="label">
            {title}
          </label>
        </div>
      ))}
    </div>
  );
};

export default memo(RadioButtonsGroup);
