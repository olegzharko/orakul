/* eslint-disable react/require-default-props */
/* eslint-disable no-unused-vars */
/* eslint-disable react/no-unused-prop-types */
import React, { useState, memo, useEffect } from 'react';
import './index.scss';
import { v4 as uuidv4 } from 'uuid';

type Button = {
  id: number | string;
  title: string;
};

type Props = {
  buttons: Button[];
  unicId: string;
  onChange: (id: number | string) => void;
  selected?: number | string | null;
};

export const RadioButtonsGroup = ({
  buttons,
  onChange,
  selected,
  unicId,
}: Props) => {
  const [selectedValue, setSelectedValue] = useState(selected || buttons[0].id);

  useEffect(() => {
    setSelectedValue(selected || buttons[0].id);
  }, [selected]);

  const handleChange = (id: number | string) => {
    setSelectedValue(id);
    onChange(id);
  };

  return (
    <div className="radio-buttons-group">
      {buttons.map(({ id, title }: Button) => (
        <div
          key={uuidv4()}
          className={`radio-buttons-group__element ${
            buttons.length === 1 ? 'edit' : ''
          }`}
        >
          <input
            type="radio"
            id={unicId + title}
            value={id}
            checked={selectedValue === id}
            onChange={() => handleChange(id)}
            className="input"
          />
          <label htmlFor={unicId + title} className="label">
            {title}
          </label>
        </div>
      ))}
    </div>
  );
};

export default memo(RadioButtonsGroup);
