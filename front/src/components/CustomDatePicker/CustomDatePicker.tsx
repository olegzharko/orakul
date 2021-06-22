/* eslint-disable quotes */
/* eslint-disable react/jsx-curly-brace-presence */
import React, { useEffect, useState } from 'react';
import DateFnsUtils from '@date-io/date-fns';
import {
  MuiPickersUtilsProvider,
  KeyboardDatePicker,
} from '@material-ui/pickers';
import { MaterialUiPickersDate } from '@material-ui/pickers/typings/date';
import { createMuiTheme, MuiThemeProvider } from '@material-ui/core';
import deLocale from "date-fns/locale/uk";

type Props = {
  label: string;
  onSelect: (value: any) => void;
  selectedDate?: Date | null;
  required?: boolean;
  disabled?: boolean;
}

const customTheme = createMuiTheme({
  palette: {
    primary: {
      main: '#165153',
    }
  },
});

const CustomDatePicker = ({ selectedDate, onSelect, label, required, disabled }: Props) => {
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
    <MuiThemeProvider theme={customTheme}>
      <MuiPickersUtilsProvider utils={DateFnsUtils} locale={deLocale}>
        <KeyboardDatePicker
          error={required && !value}
          margin="normal"
          label={label}
          format="dd/MM/yyyy"
          value={value}
          onChange={handleChange}
          cancelLabel="Закрити"
          okLabel="Зберегти"
          KeyboardButtonProps={{
            'aria-label': 'change date',
          }}
          disabled={disabled || false}
        />
      </MuiPickersUtilsProvider>
    </MuiThemeProvider>

  );
};

export default CustomDatePicker;
