import React from 'react';
import RadioButtonsGroup from '../../../../../../../../components/RadioButtonsGroup';
import CustomSelect from '../../../../../../../../components/CustomSelect';
import CustomSwitch from '../../../../../../../../components/CustomSwitch/CustomSwitch';
import CustomInput from '../../../../../../../../components/CustomInput';
import AddFormButton from '../../../../../../../../components/AddFormButton';

const contracts = [
  {
    id: 0,
    title: 'Основний',
  },
  {
    id: 1,
    title: 'Попередній',
  },
];

const buildings = [
  {
    id: 0,
    title: 'Кв.',
  },
  {
    id: 1,
    title: 'П-м.',
  },
  {
    id: 2,
    title: 'ГНП',
  },
];

const Immovable = () => (
  <>
    <RadioButtonsGroup buttons={contracts} onChange={(id) => console.log(id)} />

    <div className="mv12">
      <CustomSelect
        onChange={(val) => console.log(val)}
        data={[]}
        label="Будинок"
      />
    </div>

    <RadioButtonsGroup buttons={buildings} onChange={(id) => console.log(id)} />

    <div className="mv12">
      <CustomSwitch label="Банк" onChange={(val) => console.log(val)} />
    </div>

    <div className="mv12">
      <CustomSwitch label="Довіреність" onChange={(val) => console.log(val)} />
    </div>

    <div className="mv12 df-jc-sb">
      <CustomInput
        label="Номер приміщення"
        onChange={(val) => console.log(val)}
      />

      <div style={{ marginLeft: '12px' }}>
        <AddFormButton onClick={() => console.log('click')} />
      </div>
    </div>
  </>
);

export default Immovable;
