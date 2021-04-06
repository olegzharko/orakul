/* eslint-disable quotes */
/* eslint-disable react/jsx-curly-brace-presence */
import React, { useEffect, useState } from 'react';
import DateFnsUtils from '@date-io/date-fns';
import {
  MuiPickersUtilsProvider,
  KeyboardDatePicker,
} from '@material-ui/pickers';
import { MaterialUiPickersDate } from '@material-ui/pickers/typings/date';

type Props = {
  label: string;
  onSelect: (value: any) => void;
  selectedDate?: Date | null;
}

const CustomDatePicker = ({ selectedDate, onSelect, label }: Props) => {
  const [value, setValue] = useState<MaterialUiPickersDate | undefined>(selectedDate);

  useEffect(() => {
    setValue(selectedDate);
  }, [selectedDate]);

  const handleChange = (data: any) => {
    setValue(data);
    onSelect(data);
  };

  return (
    <MuiPickersUtilsProvider utils={DateFnsUtils}>
      <KeyboardDatePicker
        margin="normal"
        label={label}
        format="dd/MM/yyyy"
        value={value}
        onChange={handleChange}
        KeyboardButtonProps={{
          'aria-label': 'change date',
        }}
      />
    </MuiPickersUtilsProvider>
  );
};

export default CustomDatePicker;
