import * as React from 'react';

import AddFormButton from '../../../../../../../../../../../../../components/AddFormButton';
import CustomInput from '../../../../../../../../../../../../../components/CustomInput';
import CustomSelect from '../../../../../../../../../../../../../components/CustomSelect';
import PhoneMaskInput from '../../../../../../../../../../../../../components/PhoneMaskInput';
import PrimaryButton from '../../../../../../../../../../../../../components/PrimaryButton';
import RemoveFormButton from '../../../../../../../../../../../../../components/RemoveFormButton';
import SectionWithTitle from '../../../../../../../../../../../../../components/SectionWithTitle';

import { usePersons, Props } from './usePersons';

const Persons = (props: Props) => {
  const meta = usePersons(props);

  return (
    <>
      <SectionWithTitle title="Контактні особи" onClear={meta.onClearAll}>
        {meta.data.map((person, index) => (
          <div className="grid-center-duet main__person-block">
            <CustomSelect
              label="Тип особи"
              data={props.contact_person_type || []}
              onChange={(e) => meta.onDataChange(index, { ...person, person_type: e })}
              selectedValue={person.person_type}
            />

            <CustomInput
              label="ПІБ"
              onChange={(e) => meta.onDataChange(index, { ...person, name: e })}
              value={person.name}
            />

            <CustomInput
              label="E-mail"
              onChange={(e) => meta.onDataChange(index, { ...person, email: e })}
              value={person.email}
            />

            <div className="df-jc-sb">
              <PhoneMaskInput
                label="Номер телефону"
                onChange={(e) => meta.onDataChange(index, { ...person, phone: e })}
                value={person.phone}
              />

              {meta.data.length > 1 && (
              <div style={{ marginLeft: '12px' }}>
                <RemoveFormButton
                  onClick={meta.onRemove}
                  index={index}
                  disabled={false}
                />
              </div>
              )}

              {index === meta.data.length - 1 && (
              <div style={{ marginLeft: '12px' }}>
                <AddFormButton
                  onClick={meta.onAdd}
                  disabled={false}
                />
              </div>
              )}
            </div>
          </div>
        ))}
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Редагувати" onClick={meta.onSave} disabled={false} />
      </div>
    </>
  );
};

export default Persons;
