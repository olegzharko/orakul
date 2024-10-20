import { Checkbox, FormControlLabel } from '@material-ui/core';
import React, { useCallback, useEffect, useState } from 'react';
import './index.scss';

type Props = {
  onChange: (value: boolean) => void;
  label: string;
  checked?: boolean;
  disabled?: boolean;
};

const CustomCheckBox = ({
  onChange,
  label,
  checked = false,
  disabled = false
}: Props) => {
  const [value, setValue] = useState<boolean>(checked);

  useEffect(() => {
    setValue(checked);
  }, [checked]);

  const handleChange = useCallback(
    (e: any) => {
      setValue(e.target.checked);
      onChange(e.target.checked);
    },
    [onChange]
  );

  return (
    <FormControlLabel
      disabled={disabled}
      control={
        <Checkbox checked={value} onChange={handleChange} color="default" />
      }
      label={label}
      className="custom-checkBox"
    />
  );
};

export default CustomCheckBox;
