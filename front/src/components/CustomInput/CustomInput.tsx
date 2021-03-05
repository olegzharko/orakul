/* eslint-disable no-unused-vars */
/* eslint-disable react/react-in-jsx-scope */
import React, { memo } from 'react';
import './index.scss';
import { TextField } from '@material-ui/core';

type Props = {
  label: string;
  onChange: (value: string) => void;
  value?: string | number;
  type?: string;
};

const CustomInput = ({
  label,
  onChange,
  value = '',
  type = 'string',
}: Props) => {
  const handleChange = (event: any) => {
    onChange(event.target.value);
  };

  return (
    <TextField
      label={label}
      variant="outlined"
      value={value}
      onChange={handleChange}
      type={type}
      className="custom-input"
    />
  );
};

export default memo(CustomInput);
