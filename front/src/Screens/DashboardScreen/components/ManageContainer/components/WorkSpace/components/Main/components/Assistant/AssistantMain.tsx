import React from 'react';
import { v4 as uuidv4 } from 'uuid';
import CustomSelect from '../../../../../../../../../../components/CustomSelect';
import CustomSwitch from '../../../../../../../../../../components/CustomSwitch';
import PrimaryButton from '../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../components/SectionWithTitle';
import { useAssistantMain } from './useAssistantMain';

const AssistantMain = () => {
  const meta = useAssistantMain();

  return (
    <div className="main">
      <div className="dashboard-header section-title">{meta.title}</div>

      <SectionWithTitle title="Учасники угоди" onClear={meta.onGeneralClear}>
        <div className="grid">
          <CustomSelect
            required
            label="Забудовник"
            data={meta.developer}
            onChange={(e) => meta.setGeneral({ ...meta.general, developer_id: e })}
            selectedValue={meta.general.developer_id}
          />

          <CustomSelect
            label="Представник"
            data={meta.representative}
            onChange={(e) => meta.setGeneral({ ...meta.general, representative_id: e })}
            selectedValue={meta.general.representative_id}
          />

          <CustomSelect
            label="Менеджер"
            data={meta.manager}
            onChange={(e) => meta.setGeneral({ ...meta.general, manager_id: e })}
            selectedValue={meta.general.manager_id}
          />

          <CustomSelect
            required
            label="Нотаріус"
            data={meta.notary}
            onChange={(e) => meta.setGeneral({ ...meta.general, notary_id: e })}
            selectedValue={meta.general.notary_id}
          />

          <CustomSelect
            label="Набирач"
            data={meta.generator}
            onChange={(e) => meta.setGeneral({ ...meta.general, generator_id: e })}
            selectedValue={meta.general.generator_id}
          />

          <CustomSwitch
            label="Скаcовано"
            selected={meta.general.cancelled}
            onChange={(e) => meta.setGeneral({ ...meta.general, cancelled: e })}
          />
        </div>
      </SectionWithTitle>

      {(meta.immovables || []).map((immovable, index) => (
        <SectionWithTitle key={uuidv4()} title={immovable.address || ''} onClear={() => meta.onImmovableClear(index)}>
          <div className="grid-center-duet">
            <CustomSelect
              label="Читач"
              data={meta.reader}
              onChange={(e) => meta.onImmovableChange(index, 'reader_id', e)}
              selectedValue={immovable.reader_id}
            />

            <CustomSelect
              label="Видавач"
              data={meta.accompanying}
              onChange={(e) => meta.onImmovableChange(index, 'accompanying_id', e)}
              selectedValue={immovable.accompanying_id}
            />
          </div>
        </SectionWithTitle>
      ))}

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={meta.isSaveButtonDisabled} />
      </div>
    </div>
  );
};

export default AssistantMain;
