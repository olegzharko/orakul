import * as React from 'react';
import CustomInput from '../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../components/CustomSelect';
import CustomSwitch from '../../../../../../../../../../../../components/CustomSwitch';
import PrimaryButton from '../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../components/SectionWithTitle';
import { useFields } from './useFields';

const Fields = () => {
  const meta = useFields();

  return (
    <main className="clients">
      <div
        className="dashboard-header section-title"
        style={{
          backgroundColor: '#2323B5',
          color: 'white',
        }}
      >
        Клієнт
      </div>

      <SectionWithTitle title="" onClear={meta.onClientClear}>
        <div className="grid">
          <CustomInput
            required
            label="Прізвище"
            onChange={(e) => meta.setClient({ ...meta.client, surname: e })}
            value={meta.client?.surname}
          />

          <CustomInput
            required
            label="Ім’я"
            onChange={(e) => meta.setClient({ ...meta.client, name: e })}
            value={meta.client?.name}
          />

          <CustomInput
            label="По батькові"
            onChange={(e) => meta.setClient({ ...meta.client, patronymic: e })}
            value={meta.client?.patronymic}
          />

          <CustomInput
            label="Номер телефону"
            onChange={(e) => meta.setClient({ ...meta.client, phone: e })}
            value={meta.client?.phone}
          />

          <CustomInput
            label="E-mail"
            onChange={(e) => meta.setClient({ ...meta.client, email: e })}
            value={meta.client?.email}
          />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Перевірки ПОКУПЦЯ">
        <div className="grid">
          {meta.clientChecks.map(({ title, key, value }: any, index: number) => (
            <CustomSwitch
              key={key}
              label={title}
              onChange={(e) => meta.onClientChecksChange(index, e)}
              selected={value}
            />
          ))}
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Загальні дані">
        <div className="grid-center-duet">
          <CustomSelect
            label="Тип свідоцтва про шлюб"
            data={meta.marriedTypes}
            onChange={(e) => meta.setClient({ ...meta.client, married_type_id: e })}
            selectedValue={meta.client.married_type_id}
          />

          <CustomSelect
            required
            label="Тип документа"
            data={meta.passportTypes}
            onChange={(e) => meta.setClient({ ...meta.client, passport_type_id: e })}
            selectedValue={meta.client.passport_type_id}
          />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Подружжя" headerColor="#FFB800" onClear={meta.onSpouseClear}>
        <div className="grid">
          <CustomInput
            label="Прізвище"
            onChange={(e) => meta.setSpouse({ ...meta.spouse, surname: e })}
            value={meta.spouse.surname}
          />

          <CustomInput
            label="Ім’я"
            onChange={(e) => meta.setSpouse({ ...meta.spouse, name: e })}
            value={meta.spouse.name}
          />

          <CustomInput
            label="По батькові"
            onChange={(e) => meta.setSpouse({ ...meta.spouse, patronymic: e })}
            value={meta.spouse.patronymic}
          />

          {meta.spouseChecks.map(({ title, key, value }: any, index: number) => (
            <CustomSwitch
              key={key}
              label={title}
              onChange={(e) => meta.onSpouseChecksChange(index, e)}
              selected={value}
            />
          ))}
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Представник" headerColor="#04BC00" onClear={meta.onConfidantClear}>
        <div className="grid">
          <CustomInput
            label="Прізвище"
            onChange={(e) => meta.setConfidant({ ...meta.confidant, surname: e })}
            value={meta.confidant.surname}
          />

          <CustomInput
            label="Ім’я"
            onChange={(e) => meta.setConfidant({ ...meta.confidant, name: e })}
            value={meta.confidant.name}
          />

          <CustomInput
            label="По батькові"
            onChange={(e) => meta.setConfidant({ ...meta.confidant, patronymic: e })}
            value={meta.confidant.patronymic}
          />

          {meta.confidantChecks.map(({ title, key, value }: any, index: number) => (
            <CustomSwitch
              key={key}
              label={title}
              onChange={(e) => meta.onConfidantChecksChange(index, e)}
              selected={value}
            />
          ))}
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={meta.isSaveButtonDisabled} />
      </div>
    </main>
  );
};

export default Fields;
