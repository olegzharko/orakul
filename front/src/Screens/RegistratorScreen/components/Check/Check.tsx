import React from 'react';
import CheckBanFields, { CheckBanFieldsData } from '../../../../components/CheckBanFields/CheckBanFields';
import CustomDatePicker from '../../../../components/CustomDatePicker';
import CustomInput from '../../../../components/CustomInput';
import CustomSwitch from '../../../../components/CustomSwitch';
import PrimaryButton from '../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../components/SectionWithTitle';

type Props = {
  data: CheckBanFieldsData,
  setData: (data: CheckBanFieldsData) => void,
  onPrevButtonClick: () => void,
  onSave: () => void,
  onNextButtonClick: () => void,
  disableSaveButton: boolean,
  next: number | undefined,
  prev: number | undefined,
}

const Check = ({
  data,
  setData,
  onPrevButtonClick,
  onSave,
  onNextButtonClick,
  disableSaveButton,
  next,
  prev,
}: Props) => (
  <>
    <CheckBanFields data={data} setData={setData} title="Перевірка" />

    <div className="buttons-group">
      <button
        type="button"
        onClick={onPrevButtonClick}
        disabled={!prev}
        className="custom-button"
      >
        <img src="/icons/arrow-left.svg" alt="previous" className="left" />
        Попередній
      </button>

      <div className="button-container">
        <PrimaryButton label="Зберегти" onClick={onSave} disabled={disableSaveButton} />
      </div>

      <button
        type="button"
        onClick={onNextButtonClick}
        disabled={!next}
        className="custom-button"
      >
        Наступний
        <img src="/icons/arrow-right.svg" alt="next" className="right" />
      </button>
    </div>
  </>
);

export default Check;
