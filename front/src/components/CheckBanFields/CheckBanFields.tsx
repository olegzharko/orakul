import * as React from 'react';
import CustomDatePicker from '../CustomDatePicker';
import CustomInput from '../CustomInput';
import CustomSwitch from '../CustomSwitch';
import SectionWithTitle from '../SectionWithTitle';

export type CheckBanFieldsData = {
  date: Date,
  number: string,
  pass: boolean,
}

type Props = {
  data: CheckBanFieldsData,
  setData: (data: CheckBanFieldsData) => void,
  title: string;
}

const CheckBanFields = ({ data, setData, title }: Props) => (
  <SectionWithTitle title={title}>
    <div className="grid">
      <CustomDatePicker
        label="Дата перевірки"
        onSelect={(val) => setData({ ...data, date: val })}
        selectedDate={data.date}
      />
      <CustomInput
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

export default CheckBanFields;
