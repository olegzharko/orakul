import * as React from 'react';
import CustomDatePicker from '../CustomDatePicker';
import CustomInput from '../CustomInput';
import CustomSwitch from '../CustomSwitch';
import SectionWithTitle from '../SectionWithTitle';

export type PowerOfAttorneyData = {
  date: any,
  number: string,
  pass: boolean,
}

type Props = {
  data: PowerOfAttorneyData,
  setData: (data: PowerOfAttorneyData) => void,
  title: string;
}

const PowerOfAttorneyFields = ({ data, setData, title }: Props) => (
  <SectionWithTitle title={title}>
    <div className="grid">
      <CustomDatePicker
        required
        label="Дата перевірки"
        onSelect={(val) => setData({ ...data, date: val })}
        selectedDate={data.date}
      />
      <CustomInput
        required
        label="Номер перевірки"
        onChange={(val) => setData({ ...data, number: val })}
        value={data.number}
      />
      <CustomSwitch
        label="Пройшов перевірку"
        onChange={(val) => setData({ ...data, pass: val })}
        selected={data.pass}
      />
    </div>
  </SectionWithTitle>
);

export default PowerOfAttorneyFields;
