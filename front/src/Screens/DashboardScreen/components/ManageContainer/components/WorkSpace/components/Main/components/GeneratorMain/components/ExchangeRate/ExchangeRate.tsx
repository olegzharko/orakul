import * as React from 'react';
import './index.scss';
import CustomInput from '../../../../../../../../../../../../components/CustomInput';
import PrimaryButton from '../../../../../../../../../../../../components/PrimaryButton';
import SecondaryButton from '../../../../../../../../../../../../components/SecondaryButton';
import SectionWithTitle from '../../../../../../../../../../../../components/SectionWithTitle';
import { useExchangeRate, Props } from './useExchangeRate';

const ExchangeRate = (props: Props) => {
  const {
    exchangeRate,
    contractBuy,
    contractSell,
    setContractBuy,
    setContractSell,
    setExchangeRate,
    onClear,
    onSave,
    onRefreshRate,
    isSaveButtonDisable
  } = useExchangeRate(props);

  return (
    <>
      <SectionWithTitle title="Комерційний курс валют" onClear={onClear}>
        <div className="flex-center mb20">
          <span>Курс української грн до 1$ CША</span>
        </div>

        <div className="exchange mb20">
          <div className="exchange__field">
            <CustomInput required label="Середній курс долара" onChange={setExchangeRate} value={exchangeRate} />
          </div>
          <div className="exchange__field">
            <CustomInput required label="Курс для договорів - купівля" onChange={setContractBuy} value={contractBuy} />
          </div>
          <div className="exchange__field">
            <CustomInput required label="Курс для договорів - продаж" onChange={setContractSell} value={contractSell} />
          </div>
        </div>

        <div className="middle-button">
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
