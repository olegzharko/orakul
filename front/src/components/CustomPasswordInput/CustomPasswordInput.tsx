/* eslint-disable react/jsx-wrap-multilines */
/* eslint-disable no-unused-vars */
/* eslint-disable react/react-in-jsx-scope */
import React, { useState, useEffect } from 'react';
import './index.scss';
import {
  FormControl,
  InputLabel,
  OutlinedInput,
  InputAdornment,
  IconButton,
} from '@material-ui/core';
import { Visibility, VisibilityOff } from '@material-ui/icons';

type Props = {
  label: string;
  onChange: (value: string) => void;
  value?: string | number | null;
  type?: string;
  disabled?: boolean;
};

const CustomPasswordInput = ({ label, onChange, value = '' }: Props) => {
  const [password, setPassword] = useState(value || '');
  const [showPassword, setShowPassword] = useState<boolean>(false);

  useEffect(() => {
    setPassword(value || '');
  }, [value]);

  const handleClickShowPassword = () => {
    setShowPassword((prev) => !prev);
  };

  const handleMouseDownPassword = (event: any) => {
    event.preventDefault();
  };

  const handleChange = (event: any) => {
    setPassword(event.target.value);
    onChange(event.target.value);
  };

  return (
    <FormControl variant="outlined" className="custom-input">
      <InputLabel htmlFor="outlined-adornment-password">Password</InputLabel>
      <OutlinedInput
        id="outlined-adornment-password"
        type={showPassword ? 'text' : 'password'}
        value={password}
        onChange={handleChange}
        endAdornment={
          <InputAdornment position="end">
            <IconButton
              aria-label="toggle password visibility"
              onClick={handleClickShowPassword}
              onMouseDown={handleMouseDownPassword}
              edge="end"
            >
              {showPassword ? <Visibility /> : <VisibilityOff />}
            </IconButton>
          </InputAdornment>
        }
        labelWidth={70}
      />
    </FormControl>
  );
};

export default CustomPasswordInput;
