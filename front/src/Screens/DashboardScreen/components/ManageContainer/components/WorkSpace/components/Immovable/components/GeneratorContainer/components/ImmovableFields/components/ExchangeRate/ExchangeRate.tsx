import * as React from 'react';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SecondaryButton from '../../../../../../../../../../../../../../components/SecondaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';

const ExchangeRate = () => (
  <>
    <SectionWithTitle title="Комерційний курс валют" onClear={() => console.log('clear')}>
      <div className="exchange df">
        <span>Курс української грн до 1$ CША</span>
        <CustomInput label="Курс" onChange={(e) => console.log(e)} />
        <SecondaryButton label="ОНОВИТИ КУРС" onClick={() => console.log('click')} disabled={false} />
      </div>
    </SectionWithTitle>

    <div className="middle-button">
      <PrimaryButton label="Зберегти" onClick={() => console.log('click')} disabled={false} />
    </div>
  </>
);

export default ExchangeRate;
