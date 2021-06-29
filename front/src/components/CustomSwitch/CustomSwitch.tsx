/* eslint-disable no-unused-vars */
/* eslint-disable prettier/prettier */
import React, { useEffect, useState, memo } from 'react';
import { FormControlLabel, Switch } from '@material-ui/core';
import './index.scss';

type Props = {
  label: string
  onChange: (val: boolean) => void;
  selected: boolean;
  disabled?: boolean;
};

const CustomSwitch = ({
  label,
  onChange,
  selected,
  disabled
}: Props) => {
  const handleChange = (event: any) => {
    onChange(event.target.checked);
  };

  return (
    <FormControlLabel
      control={(
        <Switch
          checked={selected || false}
          onChange={handleChange}
          name="checkedB"
          color="primary"
        />
      )}
      label={label}
      labelPlacement="start"
      className="custom-switch"
      disabled={disabled || false}
    />
  );
};

export default memo(CustomSwitch);
