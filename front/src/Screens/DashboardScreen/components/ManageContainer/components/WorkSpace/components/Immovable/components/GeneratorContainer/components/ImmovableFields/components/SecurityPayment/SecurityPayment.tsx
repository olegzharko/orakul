import * as React from 'react';
import CustomDatePicker from '../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import RadioButtonsGroup from '../../../../../../../../../../../../../../components/RadioButtonsGroup';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';

const buttons = [
  {
    id: 1,
    title: 'Гривня',
  },
  {
    id: 2,
    title: 'Долар'
  }
];

const SecurityPayment = () => (
  <div className="security-payment">
    <SectionWithTitle title="Забезпечувальний платіж" onClear={() => console.log('clear')}>
      <div className="grid">
        <CustomDatePicker label="Дата підписання" onSelect={(e) => console.log(e)} />
        <CustomDatePicker label="Дата закінчення" onSelect={(e) => console.log(e)} />
        <CustomInput label="Реєстраційний номер" onChange={(e) => console.log(e)} />

        <div className="security-payment__currency">
          <p className="security-payment__currency-title">Валюта</p>
          <RadioButtonsGroup buttons={buttons} onChange={(e) => console.log(e)} unicId="immovable__security-payment-currency" />
        </div>

        <CustomInput label="I частина з. платежу у грн (дол.)" onChange={(e) => console.log(e)} />
        <CustomInput label="II частина з. платежу у грн (дол.)" onChange={(e) => console.log(e)} />
      </div>
    </SectionWithTitle>

    <div className="middle-button">
      <PrimaryButton label="Зберегти" onClick={() => console.log('click')} disabled={false} />
    </div>
  </div>
);

export default SecurityPayment;
