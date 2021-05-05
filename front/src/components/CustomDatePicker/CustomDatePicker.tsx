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
  required?: boolean;
}

const CustomDatePicker = ({ selectedDate, onSelect, label, required }: Props) => {
  const [value, setValue] = useState<MaterialUiPickersDate | undefined>(selectedDate);

  useEffect(() => {
    setValue(selectedDate);
  }, [selectedDate]);

  const handleChange = (data: any) => {
    const parseDate = Date.parse(data);
    if (Number.isNaN(parseDate) === true) {
      onSelect(null);
    } else {
      onSelect(data);
    }

    setValue(data);
  };

  return (
    <MuiPickersUtilsProvider utils={DateFnsUtils}>
      <KeyboardDatePicker
        error={required && !value}
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
