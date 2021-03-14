/* eslint-disable object-curly-newline */
/* eslint-disable no-unused-vars */
import React, { useState, memo, useEffect } from 'react';
import './index.scss';
import InputLabel from '@material-ui/core/InputLabel';
import MenuItem from '@material-ui/core/MenuItem';
import FormControl from '@material-ui/core/FormControl';
import Select from '@material-ui/core/Select';

type Data = {
  id: number;
  title: string;
};

type Props = {
  onChange: (value: string) => void;
  data: Data[];
  label: string;
  selectedValue?: string | null | number;
  disabled?: boolean;
  size?: 'medium' | 'small';
};

const CustomSelect = ({
  onChange,
  data,
  label,
  selectedValue,
  disabled,
  size = 'medium',
}: Props) => {
  const [selected, setSelected] = useState(selectedValue || '');

  useEffect(() => {
    setSelected(selectedValue || '');
  }, [selectedValue]);

  const handleChange = (event: any) => {
    const val = event.target.value;
    setSelected(val);
    onChange(val);
  };

  return (
    <FormControl variant="outlined" className="customSelect" size={size}>
      <InputLabel>{label}</InputLabel>
      <Select
        value={selected}
        onChange={handleChange}
        disabled={disabled || data.length === 0}
      >
        <MenuItem value="">
          <em>Выбрать</em>
        </MenuItem>
        {data.map(({ id, title }: Data) => (
          <MenuItem value={id} key={id}>
            {title}
          </MenuItem>
        ))}
      </Select>
    </FormControl>
  );
};

export default memo(CustomSelect);
