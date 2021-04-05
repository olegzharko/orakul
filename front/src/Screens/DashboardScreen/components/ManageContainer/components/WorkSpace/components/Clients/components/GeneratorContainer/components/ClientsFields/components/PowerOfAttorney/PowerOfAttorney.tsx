import * as React from 'react';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../../components/CustomSelect';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';

const PowerOfAttorney = () => (
  <div className="clients__power-of-attorney">
    <SectionWithTitle title="Довіренності" onClear={() => console.log('clear')}>
      <div className="grid">
        <CustomSelect label="Нотаріус" data={[]} onChange={(e) => console.log(e)} />
        <CustomInput label="Реєстровий номер" onChange={(e) => console.log(e)} />
        <CustomInput label="Дата видачі" onChange={(e) => console.log(e)} />
      </div>
    </SectionWithTitle>

    <div className="middle-button">
      <PrimaryButton label="Зберегти" onClick={() => console.log('click')} disabled={false} />
    </div>
  </div>
);

export default PowerOfAttorney;
