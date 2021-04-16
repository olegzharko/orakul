/* eslint-disable no-unused-vars */
/* eslint-disable react/react-in-jsx-scope */
import React, { useState, useEffect } from 'react';
import './index.scss';
import { TextField } from '@material-ui/core';

type Props = {
  label: string;
  value?: string | number | null;
  onChange?: (value: string) => void;
  type?: string;
  disabled?: boolean;
  required?: boolean;
};

const CustomInput = ({
  label,
  onChange,
  value = '',
  type = 'string',
  disabled,
  required,
}: Props) => {
  const [text, setText] = useState(value || '');

  useEffect(() => {
    setText(value || '');
  }, [value]);

  const handleChange = (event: any) => {
    setText(event.target.value);
    onChange && onChange(event.target.value);
  };

  return (
    <TextField
      error={required && !text}
      label={label}
      variant="outlined"
      value={text}
      onChange={handleChange}
      type={type}
      className="custom-input"
      disabled={disabled || false}
    />
  );
};

export default CustomInput;
