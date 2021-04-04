import * as React from 'react';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import RadioButtonsGroup from '../../../../../../../../../../../../../../components/RadioButtonsGroup';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';

const buttons = [
  {
    id: 1,
    title: 'Жіноча',
  },
  {
    id: 2,
    title: 'Чоловіча'
  }
];

const Passport = () => (
  <div className="clients__passport">
    <SectionWithTitle title="Код та Паспортні данні" onClear={() => console.log('clear')}>
      <div className="grid">
        <div className="sex">
          <p className="sex__title">Стать</p>
          <RadioButtonsGroup buttons={buttons} onChange={(e) => console.log(e)} unicId="clients__passport-sex" />
        </div>

        <CustomInput label="Дата народження" onChange={(e) => console.log(e)} />
        <CustomInput label="ІНН" onChange={(e) => console.log(e)} />
        <CustomInput label="Тип паспорту" onChange={(e) => console.log(e)} />
        <CustomInput label="Серія/Номер паспорту" onChange={(e) => console.log(e)} />
        <CustomInput label="Дата видачі" onChange={(e) => console.log(e)} />
        <CustomInput label="Орган що видав паспорт" onChange={(e) => console.log(e)} />
        <CustomInput label="Запису в ЄДДР (для ID карток)" onChange={(e) => console.log(e)} />
        <CustomInput label="Діє до" onChange={(e) => console.log(e)} />
      </div>
    </SectionWithTitle>

    <div className="middle-button">
      <PrimaryButton label="Зберегти" onClick={() => console.log('click')} disabled={false} />
    </div>
  </div>
);

export default Passport;
