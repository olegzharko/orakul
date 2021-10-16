import * as React from 'react';

import CustomInput from '../../../../../../../../../../../components/CustomInput';
import PrimaryButton from '../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../components/SectionWithTitle';

import { useFields } from './useFields';

const Fields = () => {
  const meta = useFields();

  return (
    <main className="side-notaries">
      <SectionWithTitle title="Називний відмінок та скорочення" onClear={meta.onDenominativeClear}>
        <div className="grid mb20">
          <CustomInput
            label="Прізвище"
            onChange={(e) => meta.setDenominate({ ...meta.denominative, surname_n: e })}
            value={meta.denominative.surname_n}
          />

          <CustomInput
            label="Ім'я"
            onChange={(e) => meta.setDenominate({ ...meta.denominative, name_n: e })}
            value={meta.denominative.name_n}
          />

          <CustomInput
            label="По батькові"
            onChange={(e) => meta.setDenominate({ ...meta.denominative, patronymic_n: e })}
            value={meta.denominative.patronymic_n}
          />
        </div>

        <CustomInput
          label="Назва нотаріального округу в називному відмінку (Хто? Що?), з маленької букви (приватний нотаріус Київського міського нотаріального округу)"
          onChange={(e) => meta.setDenominate({ ...meta.denominative, activity_n: e })}
          value={meta.denominative.activity_n}
        />
      </SectionWithTitle>

      <SectionWithTitle title="Орудний відмінок" onClear={meta.onAblativeClear}>
        <div className="grid mb20">
          <CustomInput
            label="Прізвище"
            onChange={(e) => meta.setAblative({ ...meta.ablative, surname_o: e })}
            value={meta.ablative.surname_o}
          />

          <CustomInput
            label="Ім'я"
            onChange={(e) => meta.setAblative({ ...meta.ablative, name_o: e })}
            value={meta.ablative.name_o}
          />

          <CustomInput
            label="По батькові"
            onChange={(e) => meta.setAblative({ ...meta.ablative, patronymic_o: e })}
            value={meta.ablative.patronymic_o}
          />
        </div>

        <CustomInput
          label="Назва нотаріального округу в орудному відмінку (Ким? Чим?), з маленької букви (державним реєстратором Київського міського округу)"
          onChange={(e) => meta.setAblative({ ...meta.ablative, activity_o: e })}
          value={meta.ablative.activity_o}
        />
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={meta.isButtonDisabled} />
      </div>
    </main>
  );
};

export default Fields;
