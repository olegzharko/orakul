import * as React from 'react';
import CustomSelect from '../../../../../../../../../../../../components/CustomSelect';
import CustomSwitch from '../../../../../../../../../../../../components/CustomSwitch';
import PrimaryButton from '../../../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../../../components/SectionWithTitle';
import { useParticipants, Props } from './useParticipants';

const Participants = (props: Props) => {
  const meta = useParticipants(props);

  return (
    <>
      <SectionWithTitle title="Учасники угоди" onClear={meta.onClear}>
        <div className="grid">
          <CustomSelect
            label="Забудовник"
            data={props.initialData?.developer || []}
            onChange={(e) => meta.setData({ ...meta.data, developer_id: e })}
            selectedValue={meta.data.developer_id}
          />

          <CustomSelect
            label="Представник"
            data={meta.representatives}
            onChange={(e) => meta.setData({ ...meta.data, representative_id: e })}
            selectedValue={meta.data.representative_id}
          />

          <CustomSelect
            label="Менеджер"
            data={meta.manager}
            onChange={(e) => meta.setData({ ...meta.data, manager_id: e })}
            selectedValue={meta.data.manager_id}
          />

          <CustomSelect
            label="Нотаріус"
            data={props.initialData?.notary || []}
            onChange={(e) => meta.setData({ ...meta.data, notary_id: e })}
            selectedValue={meta.data.notary_id}
          />

          <CustomSelect
            label="Набирач"
            data={props.initialData?.generator || []}
            onChange={(e) => meta.setData({ ...meta.data, generator_id: e })}
            selectedValue={meta.data.generator_id}
          />

          <CustomSwitch
            label="Готово до генерації"
            onChange={(e) => meta.setData({ ...meta.data, generation_ready: e })}
            selected={meta.data.generation_ready}
          />
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Оновити" onClick={meta.onSave} disabled={false} />
      </div>
    </>
  );
};

export default Participants;
