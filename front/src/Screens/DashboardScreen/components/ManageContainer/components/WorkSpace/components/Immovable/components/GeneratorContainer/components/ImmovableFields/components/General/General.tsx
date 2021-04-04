import * as React from 'react';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import RadioButtonsGroup from '../../../../../../../../../../../../../../components/RadioButtonsGroup';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';

const buttons = [
  {
    id: 1,
    title: 'КВ',
  },
  {
    id: 2,
    title: 'П-м'
  },
  {
    id: 3,
    title: 'ГНП'
  },
];

const General = () => (
  <>
    <SectionWithTitle title="Загальні дані" onClear={() => console.log('clear')}>
      <div className="general grid-center-duet">
        <div className="general__type">
          <p className="general__type-title">Тип нерухомості</p>
          <RadioButtonsGroup buttons={buttons} onChange={(e) => console.log(e)} unicId="immovable__general-type" />
        </div>

        <CustomSelect label="Адреса" data={[]} onChange={(e) => console.log(e)} />
        <CustomInput label="Номер нерухомості" onChange={(e) => console.log(e)} />
        <CustomInput label="Реєстровий номер" onChange={(e) => console.log(e)} />
        <CustomInput label="Повна вартість в доларах" onChange={(e) => console.log(e)} />
        <CustomInput label="Повна вартість в гривнях" onChange={(e) => console.log(e)} />

        <CustomInput label="Сума внеску зг. попереднього договору в грн" onChange={(e) => console.log(e)} />
        <CustomInput label="Сума внеску зг. попереднього договору в дол" onChange={(e) => console.log(e)} />

        <CustomInput label="Вартість 1 кв. м. гривнях" onChange={(e) => console.log(e)} />
        <CustomInput label="Вартість 1 кв. м. доларах" onChange={(e) => console.log(e)} />

        <div className="duet">
          <CustomInput label="Загальна площа" onChange={(e) => console.log(e)} />
          <CustomInput label="Житлова площа" onChange={(e) => console.log(e)} />
        </div>

        <div className="trio">
          <CustomSelect label="К-ть кімнат" data={[]} onChange={(e) => console.log(e)} />
          <CustomInput label="№ поверху" onChange={(e) => console.log(e)} />
          <CustomInput label="№ секції" onChange={(e) => console.log(e)} />
        </div>
      </div>
    </SectionWithTitle>

    <div className="middle-button">
      <PrimaryButton label="Зберегти" onClick={() => console.log('click')} disabled={false} />
    </div>
  </>
);

export default General;
