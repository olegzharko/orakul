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

      <SectionWithTitle title="" onClear={() => console.log('clear')}>
        <div className="grid">
          <CustomInput
            label="Прізвище"
            onChange={(e) => meta.setClient({ ...meta.client, surname: e })}
            value={meta.client?.surname}
          />

          <CustomInput
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
          <CustomSwitch
            label="Паспорт"
            onChange={(e) => meta.setSellerCheck({ ...meta.sellerCheck, passport: e })}
            selected={meta.sellerCheck.passport}
          />

          <CustomSwitch
            label="Код"
            onChange={(e) => meta.setSellerCheck({ ...meta.sellerCheck, tax_code: e })}
            selected={meta.sellerCheck.tax_code}
          />

          <CustomSwitch
            label="Оцінка на фонді"
            onChange={(e) => meta.setSellerCheck({
              ...meta.sellerCheck, evaluation_in_the_fund: e
            })}
            selected={meta.sellerCheck.evaluation_in_the_fund}
          />

          <CustomSwitch
            label="Перевірка на ФОП"
            onChange={(e) => meta.setSellerCheck({ ...meta.sellerCheck, check_fop: e })}
            selected={meta.sellerCheck.check_fop}
          />

          <CustomSwitch
            label="Скани документів"
            onChange={(e) => meta.setSellerCheck({ ...meta.sellerCheck, document_scans: e })}
            selected={meta.sellerCheck.document_scans}
          />

          <CustomSwitch
            label="Єдиний реєстр судових рішень"
            onChange={(e) => meta.setSellerCheck({
              ...meta.sellerCheck, unified_register_of_court_decisions: e
            })}
            selected={meta.sellerCheck.unified_register_of_court_decisions}
          />

          <CustomSwitch
            label="Санкції"
            onChange={(e) => meta.setSellerCheck({ ...meta.sellerCheck, sanctions: e })}
            selected={meta.sellerCheck.sanctions}
          />

          <CustomSwitch
            label="Фінмоніторинг"
            onChange={(e) => meta.setSellerCheck({ ...meta.sellerCheck, financial_monitoring: e })}
            selected={meta.sellerCheck.financial_monitoring}
          />

          <CustomSwitch
            label="Єдиний реєстр боржників"
            onChange={(e) => meta.setSellerCheck({
              ...meta.sellerCheck, unified_register_of_debtors: e
            })}
            selected={meta.sellerCheck.unified_register_of_debtors}
          />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Загальні дані">
        <div className="grid">
          <CustomSwitch
            label="Згода подружжя"
            onChange={(e) => meta.setGeneral({ ...meta.general, spouse_consent: e })}
            selected={meta.general.spouse_consent}
          />

          <CustomSwitch
            label="Актуальне місце проживання"
            onChange={(e) => meta.setGeneral({ ...meta.general, current_place_of_residence: e })}
            selected={meta.general.current_place_of_residence}
          />

          <CustomSelect
            label="Тип свідоцтва про шлюб"
            data={meta.marriedTypes}
            onChange={(e) => meta.setGeneral({ ...meta.general, married_type: e })}
            selectedValue={meta.general.married_type}
          />

          <CustomSwitch
            label="Фото в паспорті"
            onChange={(e) => meta.setGeneral({ ...meta.general, photo_in_the_passport: e })}
            selected={meta.general.photo_in_the_passport}
          />

          <CustomSwitch
            label="Довідка переселенця"
            onChange={(e) => meta.setGeneral({ ...meta.general, immigrant_help: e })}
            selected={meta.general.immigrant_help}
          />

          <CustomSelect
            label="Тип документа"
            data={[]}
            onChange={(e) => meta.setGeneral({ ...meta.general, document_type: e })}
            selectedValue={meta.general.document_type}
          />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Подружжя" headerColor="#FFB800">
        <div className="grid">
          <CustomInput
            label="Прізвище"
            onChange={(e) => meta.setSpouse({ ...meta.client, surname: e })}
            value={meta.client?.surname}
          />

          <CustomInput
            label="Ім’я"
            onChange={(e) => meta.setSpouse({ ...meta.client, name: e })}
            value={meta.client?.name}
          />

          <CustomInput
            label="По батькові"
            onChange={(e) => meta.setSpouse({ ...meta.client, patronymic: e })}
            value={meta.client?.patronymic}
          />
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Представник" headerColor="#04BC00">
        <div className="grid">
          <CustomInput
            label="Прізвище"
            onChange={(e) => console.log(e)}
          />

          <CustomInput
            label="Ім’я"
            onChange={(e) => console.log(e)}
          />

          <CustomInput
            label="По батькові"
            onChange={(e) => console.log(e)}
          />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={false} />
      </div>
    </main>
  );
};

export default Fields;
