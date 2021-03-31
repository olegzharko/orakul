import React, { useEffect } from 'react';
import { Link } from 'react-router-dom';
import CustomDatePicker from '../../../../components/CustomDatePicker';
import CustomInput from '../../../../components/CustomInput';
import CustomSwitch from '../../../../components/CustomSwitch';
import InputWithCopy from '../../../../components/InputWithCopy';
import PrimaryButton from '../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../components/SectionWithTitle';
import { Props, useDeveloper } from './useDeveloper';

const Developer = (props: Props) => {
  const meta = useDeveloper(props);

  if (!props.data) {
    return null;
  }

  return (
    <div className="registrator__developer">
      <SectionWithTitle title={props.data.title}>
        <div className="grid">
          <InputWithCopy label="ПІБ" value={props.data.full_name} disabled />
          <InputWithCopy label="Код" value={props.data.tax_code} disabled />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Перевірка">
        <div className="grid">
          <CustomDatePicker label="Дата перевірки" onSelect={meta.setDate} selectedDate={meta.date} />
          <CustomInput label="Номер перевірки" onChange={meta.setNumber} value={meta.number} />
          <CustomSwitch label="Пройшов перевірку" onChange={meta.setValidation} selected={meta.validation} />
        </div>
      </SectionWithTitle>

      <div className="buttons-group">
        <button
          type="button"
          onClick={meta.onPrevButtonClick}
          disabled={!props.data.prew}
          className="custom-button"
        >
          <img src="/icons/arrow-left.svg" alt="previous" className="left" />
          Попередній
        </button>

        <div className="button-container">
          <PrimaryButton label="Зберегти" onClick={() => console.log('click')} disabled={false} />
        </div>

        <button
          type="button"
          onClick={meta.onNextButtonClick}
          disabled={!props.data.next}
          className="custom-button"
        >
          Наступний
          <img src="/icons/arrow-right.svg" alt="next" className="right" />
        </button>
      </div>
    </div>
  );
};

export default Developer;
