/* eslint-disable no-unused-vars */
/* eslint-disable prettier/prettier */
import React from 'react';
import { FormControlLabel, Switch } from '@material-ui/core';
import './index.scss';

type Props = {
  label: string
  onChange: (val: boolean) => void;
  selected: boolean;
};

const CustomSwitch = ({ label, onChange, selected }: Props) => {
  const handleChange = (event: any) => {
    onChange(event.target.checked);
  };

  return (
    <FormControlLabel
      control={(
        <Switch
          checked={selected}
          onChange={handleChange}
          name="checkedB"
          color="primary"
        />
      )}
      label={label}
      labelPlacement="start"
      className="custom-switch"
    />
  );
};

export default CustomSwitch;
