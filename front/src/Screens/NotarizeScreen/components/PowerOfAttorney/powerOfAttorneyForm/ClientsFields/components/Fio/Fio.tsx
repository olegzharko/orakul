import * as React from 'react';

import CustomInput from '../../../../../../../../components/CustomInput';
import PrimaryButton from '../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../components/SectionWithTitle';

import { useFio, Props } from './useFio';

const Fio = (props: Props) => {
  const { data, setData, onClear, onSave } = useFio(props);
  return (
    <div className="clients__fio">
      <div className="clients__fio-header" style={{ backgroundColor: props?.headerColor }}>
        <span className="section-title" style={{ color: 'white' }}>ПІБ</span>
        <button type="button" className="clear-button">
          <img
            src="/images/clear-form.svg"
            alt="close"
            className="clear-icon"
            onClick={onClear}
          />
        </button>
      </div>

      <SectionWithTitle title="Називний відмінок: Хто? Що?">
        <div className="grid">
          <CustomInput
            label="Прізвище"
            onChange={(e) => setData({ ...data, surname_n: e })}
            value={data.surname_n}
          />

          <CustomInput
            label="Ім'я"
            onChange={(e) => setData({ ...data, name_n: e })}
            value={data.name_n}
          />

          <CustomInput
            label="По батькові"
            onChange={(e) => setData({ ...data, patronymic_n: e })}
            value={data.patronymic_n}
          />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Родовий відмінок: Кого? Чого?">
        <div className="grid">
          <CustomInput
            label="Прізвище"
            onChange={(e) => setData({ ...data, surname_r: e })}
            value={data.surname_r}
          />

          <CustomInput
            label="Ім'я"
            onChange={(e) => setData({ ...data, name_r: e })}
            value={data.name_r}
          />

          <CustomInput
            label="По батькові"
            onChange={(e) => setData({ ...data, patronymic_r: e })}
            value={data.patronymic_r}
          />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Орудний відмінок: Ким? Чим?">
        <div className="grid">
          <CustomInput
            label="Прізвище"
            onChange={(e) => setData({ ...data, surname_o: e })}
            value={data.surname_o}
          />

          <CustomInput
            label="Ім'я"
            onChange={(e) => setData({ ...data, name_o: e })}
            value={data.name_o}
          />

          <CustomInput
            label="По батькові"
            onChange={(e) => setData({ ...data, patronymic_o: e })}
            value={data.patronymic_o}
          />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Давальний відмінок Кому? Чому?">
        <div className="grid">
          <CustomInput
            label="Прізвище"
            onChange={(e) => setData({ ...data, surname_d: e })}
            value={data.surname_d}
          />

          <CustomInput
            label="Ім'я"
            onChange={(e) => setData({ ...data, name_d: e })}
            value={data.name_d}
          />

          <CustomInput
            label="По батькові"
            onChange={(e) => setData({ ...data, patronymic_d: e })}
            value={data.patronymic_d}
          />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={onSave} disabled={false} />
      </div>
    </div>
  );
};

export default Fio;
