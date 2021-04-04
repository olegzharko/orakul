import * as React from 'react';
import CustomDatePicker from '../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';

const Rating = () => (
  <div className="rating">
    <SectionWithTitle title="Оцінка" onClear={() => console.log('clear')}>
      <div className="grid">
        <CustomSelect label="Оцінка від компанії" data={[]} onChange={(e) => console.log(e)} />
        <CustomDatePicker label="Дата оцінки" onSelect={(e) => console.log(e)} />
        <CustomInput label="Ціна в грн" onChange={(e) => console.log(e)} />
      </div>
    </SectionWithTitle>

    <div className="middle-button">
      <PrimaryButton label="Зберегти" onClick={() => console.log('click')} disabled={false} />
    </div>
  </div>
);

export default Rating;
