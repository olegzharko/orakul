/* eslint-disable no-unused-vars */
/* eslint-disable react/react-in-jsx-scope */
import React, { useState } from 'react';
import './index.scss';
import { TextField } from '@material-ui/core';

type Props = {
  label: string;
  onChange: (value: string) => void;
};

const CustomInput = ({ label, onChange }: Props) => {
  const [text, setText] = useState<string>('');

  const handleChange = (event: any) => {
    const { value } = event.target;
    setText(value);
    onChange(value);
  };

  return (
    <TextField
      label={label}
      variant="outlined"
      value={text}
      onChange={handleChange}
      className="custom-input"
    />
  );
};

export default CustomInput;
