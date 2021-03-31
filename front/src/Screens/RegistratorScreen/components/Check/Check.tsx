import React from 'react';
import CustomDatePicker from '../../../../components/CustomDatePicker';
import CustomInput from '../../../../components/CustomInput';
import CustomSwitch from '../../../../components/CustomSwitch';
import PrimaryButton from '../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../components/SectionWithTitle';
import { DeveloperCardState } from '../Developer/useDeveloper';

type Props = {
  data: DeveloperCardState,
  setData: (data: DeveloperCardState) => void,
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
    <SectionWithTitle title="Перевірка">
      <div className="grid">
        <CustomDatePicker
          label="Дата перевірки"
          onSelect={(val) => setData({ ...data, date: val })}
          selectedDate={data.date}
        />
        <CustomInput
          label="Номер перевірки"
          onChange={(val) => setData({ ...data, number: val })}
          value={data.number}
        />
        <CustomSwitch
          label="Пройшов перевірку"
          onChange={(val) => setData({ ...data, pass: val })}
          selected={data.pass}
        />
      </div>
    </SectionWithTitle>

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
