import * as React from 'react';
import CustomDatePicker from '../../../../../../../../../../../../../../components/CustomDatePicker';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';

const Ownership = () => (
  <div className="ownership">
    <SectionWithTitle title="Право власності" onClear={() => console.log('clear')}>
      <div className="grid-center-duet">
        <CustomDatePicker label="Дата запису про право власності" onSelect={(e) => console.log(e)} />
        <CustomInput label="Номер запису про право власності" onChange={(e) => console.log(e)} />

        <CustomDatePicker label="Дата запису про право власності" onSelect={(e) => console.log(e)} />
        <CustomInput label="Номер витягу на право власності" onChange={(e) => console.log(e)} />
      </div>
    </SectionWithTitle>

    <div className="middle-button">
      <PrimaryButton label="Зберегти" onClick={() => console.log('click')} disabled={false} />
    </div>
  </div>
);

export default Ownership;
