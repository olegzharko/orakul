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
  const [value, setValue] = useState(selected);

  const handleChange = (event: any) => {
    setValue(event.target.checked);
    onChange(event.target.checked);
  };

  useEffect(() => {
    setValue(selected);
  }, [selected]);

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
      disabled={disabled || false}
    />
  );
};

export default memo(CustomSwitch);
