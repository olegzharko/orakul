/* eslint-disable object-curly-newline */
/* eslint-disable no-unused-vars */
import React, { useState, memo } from 'react';
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
};

const CustomSelect = ({ onChange, data, label }: Props) => {
  const [selectedValue, setSelectedValue] = useState('');

  const handleChange = (event: any) => {
    const val = event.target.value;
    setSelectedValue(val);
    onChange(val);
  };

  return (
    <FormControl variant="outlined" className="customSelect">
      <InputLabel>{label}</InputLabel>
      <Select
        value={selectedValue}
        onChange={handleChange}
        disabled={data.length === 0}
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
