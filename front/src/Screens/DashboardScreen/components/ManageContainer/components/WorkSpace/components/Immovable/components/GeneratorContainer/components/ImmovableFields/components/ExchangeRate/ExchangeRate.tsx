import * as React from 'react';
import CustomInput from '../../../../../../../../../../../../../../components/CustomInput';
import PrimaryButton from '../../../../../../../../../../../../../../components/PrimaryButton';
import SecondaryButton from '../../../../../../../../../../../../../../components/SecondaryButton';
import SectionWithTitle from '../../../../../../../../../../../../../../components/SectionWithTitle';
import { useExchangeRate, Props } from './useExchangeRate';

const ExchangeRate = (props: Props) => {
  const {
    exchangeRate,
    setExchangeRate,
    onClear,
    onSave,
    onRefreshRate,
    isSaveButtonDisable
  } = useExchangeRate(props);

  return (
    <>
      <SectionWithTitle title="Комерційний курс валют" onClear={onClear}>
        <div className="exchange df">
          <span>Курс української грн до 1$ CША</span>
          <CustomInput label="Курс" onChange={setExchangeRate} value={exchangeRate} />
          <SecondaryButton label="ОНОВИТИ КУРС" onClick={onRefreshRate} disabled={false} />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={onSave} disabled={isSaveButtonDisable} />
      </div>
    </>
  );
};

export default ExchangeRate;
