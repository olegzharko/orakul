/* eslint-disable no-unused-vars */
/* eslint-disable react/react-in-jsx-scope */
import React, { useState, useEffect } from 'react';
import './index.scss';
import InputMask from 'react-input-mask';
import { TextField } from '@material-ui/core';

type Props = {
  label: string;
  value?: string | number | null;
  onChange?: (value: string) => void;
  disabled?: boolean;
  required?: boolean;
};

const PhoneMaskInput = ({
  label,
  onChange,
  value = '',
  disabled,
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
    <InputMask
      className="custom-input"
      mask="+38(999)999-99-99"
      value={text}
      disabled={false}
      onChange={handleChange}
    >
      {() => <TextField variant="outlined" label={label} disabled={disabled || false} />}
    </InputMask>
  );
};

export default PhoneMaskInput;
