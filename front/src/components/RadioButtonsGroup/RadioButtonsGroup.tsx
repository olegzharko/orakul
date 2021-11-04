import React, { memo } from 'react';
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
  const handleChange = (id: number | string) => {
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
            checked={selected === id}
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
