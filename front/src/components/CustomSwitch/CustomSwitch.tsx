/* eslint-disable no-unused-vars */
/* eslint-disable prettier/prettier */
import React, { useState, memo } from 'react';
import { FormControlLabel, Switch } from '@material-ui/core';
import './index.scss';

type Props = {
  label: string
  onChange: (val: boolean) => void;
  selected: boolean;
};

const CustomSwitch = ({ label, onChange, selected }: Props) => {
  const [value, setValue] = useState(selected || false);

  const handleChange = (event: any) => {
    setValue(event.target.checked);
    onChange(event.target.checked);
  };

  return (
    <FormControlLabel
      control={(
        <Switch
          checked={value}
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

export default memo(CustomSwitch);
