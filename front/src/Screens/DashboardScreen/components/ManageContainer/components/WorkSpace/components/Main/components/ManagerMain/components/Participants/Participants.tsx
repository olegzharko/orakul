import * as React from 'react';
import CustomSelect from '../../../../../../../../../../../../components/CustomSelect';
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
            data={props.initialData?.representative || []}
            onChange={(e) => meta.setData({ ...meta.data, representative_id: e })}
            selectedValue={meta.data.representative_id}
          />

          <CustomSelect
            label="Менеджер"
            data={props.initialData?.manager || []}
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
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Обновити" onClick={meta.onSave} disabled={false} />
      </div>
    </>
  );
};

export default Participants;
