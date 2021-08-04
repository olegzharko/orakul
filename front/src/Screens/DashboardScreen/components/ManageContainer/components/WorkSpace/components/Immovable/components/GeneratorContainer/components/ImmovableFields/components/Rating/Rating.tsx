import * as React from 'react';
import CustomDatePicker from '../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';
import { useRating, Props } from './useRating';

const Rating = (props: Props) => {
  const { data, valuation, setData, onClear, onSave } = useRating(props);

  return (
    <div className="rating">
      <SectionWithTitle title="Оцінка" onClear={onClear}>
        <div className="grid mb20">
          <CustomSelect
            label="Оцінка від компанії"
            data={valuation}
            onChange={(e) => setData({ ...data, property_valuation_id: +e })}
            selectedValue={data.property_valuation_id}
          />
          <CustomDatePicker
            label="Дата оцінки"
            onSelect={(e) => setData({ ...data, date: e })}
            selectedDate={data.date}
          />
          <CustomInput
            label="Ціна в грн"
            onChange={(e) => setData({ ...data, price: e })}
            value={data.price}
          />
        </div>
        <CustomInput
          label="Назва документа у родовому відмінку"
          onChange={(e) => setData({ ...data, title: e })}
          value={data.title}
        />
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={onSave} disabled={false} />
      </div>
    </div>
  );
};

export default Rating;
