/* eslint-disable no-unused-vars */
/* eslint-disable prettier/prettier */
import { FormControlLabel, Switch } from '@material-ui/core';
import './index.scss';
import React, { useState } from 'react';

type Props = {
  label: string
  onChange: (val: boolean) => void
};

const CustomSwitch = ({ label, onChange }: Props) => {
  const [checked, setChecked] = useState<boolean>(false);

  const handleChange = (event: any) => {
    const val = event.target.checked;
    setChecked(val);
    onChange(val);
  };

  return (
    <FormControlLabel
      control={(
        <Switch
          checked={checked}
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
