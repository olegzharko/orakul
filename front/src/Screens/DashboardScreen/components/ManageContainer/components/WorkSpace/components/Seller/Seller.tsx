import * as React from 'react';
import './index.scss';
import SectionWithTitle from '../../../../../../../../components/SectionWithTitle';
import TitleInfoDuet from '../../../../../../../../components/TitleInfoDuet';
import CheckBanFields from '../../../../../../../../components/CheckBanFields';
import { useSeller } from './useSeller';
import PrimaryButton from '../../../../../../../../components/PrimaryButton';
import CustomSelect from '../../../../../../../../components/CustomSelect';

const Seller = () => {
  const meta = useSeller();

  return (
    <div className="manage__seller">
      <SectionWithTitle title="Продавець">
        <div className="seller__info">
          <div className="seller__info-title">
            Би Ласкет
          </div>
          <div className="grid">
            <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
            <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
            <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
            <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          </div>
        </div>
      </SectionWithTitle>

      <div className="seller__ban">
        <CheckBanFields data={meta.banData} setData={meta.setBanData} title="Заборони на продавця" />
        <PrimaryButton label="Зберегти" onClick={meta.onBanDataSave} disabled={meta.banDataSaveDisabled} className="seller__ban-button" />
      </div>

      <SectionWithTitle title="Подружжя">
        <div className="grid">
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Підписант">
        <div className="seller__signer">
          <CustomSelect label="Підписант" data={[]} onChange={() => console.log('change')} className="seller__signer-select" />
        </div>

        <div className="seller__signer-title">
          Загальна інформація про підписанта
        </div>

        <div className="grid">
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
        </div>

        <div className="seller__signer-title">
          Дані про договір доручення (довіреності)
        </div>

        <div className="grid">
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
          <TitleInfoDuet title="ПІБ" info="Іванов Іван Іванович" />
        </div>
      </SectionWithTitle>

      <PrimaryButton
        label="Зберегти"
        onClick={() => console.log('click')}
        disabled={meta.signerDataSaveDisabled}
        className="seller__ban-button"
      />
    </div>
  );
};

export default Seller;
